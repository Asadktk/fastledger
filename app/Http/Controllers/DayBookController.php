<?php

namespace App\Http\Controllers;

use App\DataTables\DayBookDataTable;
use App\Models\File;
use App\Models\AccountRef;
use App\Models\BankAccount;
use App\Models\PaymentType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\TransactionDataTable;
use App\Http\Requests\StoreTransactionRequest;

class DayBookController extends Controller
{
    
    public function index(DayBookDataTable $dataTable)
    {
        return $dataTable->render('admin.day_book.index');
    }

    public function create()
    {
        $currentClientId = auth()->user()->Client_ID;
        $bankAccounts = BankAccount::with('bankAccountType')
            ->where('Client_ID', $currentClientId)
            ->where('Is_Deleted', 0)
            ->get();

        return view('admin.day_book.create', compact('bankAccounts'));
    }

    public function store(StoreTransactionRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // Fetch the corresponding Bank_Type_ID
            $bankAccount = BankAccount::find($validated['Bank_Account_ID']);
            if (!$bankAccount) {
                return redirect()->route('transactions.index')->with('error', 'Invalid Bank Account ID.');
            }
            $bankTypeId = $bankAccount->Bank_Type_ID;

            $file = File::where('Ledger_Ref', $validated['Ledger_Ref'])
                ->first();

            if (!$file) {
                return redirect()->route('transactions.index')->with('error', 'No matching file found.');
            }

            $transaction = new Transaction();
            $transaction->transaction_date = $validated['Transaction_Date'];
            $transaction->file_id = $file->File_ID;
            // $transaction->ledger_ref = $validated['Ledger_Ref'];
            $transaction->bank_account_id = $validated['Bank_Account_ID'];
            // $transaction->bank_type_id = $bankTypeId; 
            $transaction->paid_in_out = $validated['Paid_In_Out'];
            $transaction->payment_type_id = $validated['Payment_Type_ID'];
            $transaction->cheque = $validated['Cheque'] ?? null;
            $transaction->amount = $validated['Amount'];
            $transaction->Description = $validated['Description'] ?? '';
            $transaction->Is_Imported = 0;
            $transaction->created_by = auth()->id();
            $transaction->created_on = now();
            $transaction->account_ref_id = $validated['Account_Ref_ID'];

            if (!in_array($transaction->account_ref_id, [2, 93])) {
                $vatId = $validated['VAT_ID'] ?? null; 
                if ($vatId) {
                    $transaction->vat_id = $vatId;
                }
            }
           
            $transaction->is_bill = 0;
            try {
                $transaction->save();
            } catch (\Exception $e) {
                dd($e->getMessage());
            }
            // $transaction->save();
            $accountRefId = $validated['Account_Ref_ID'];

            $officeAccount = BankAccount::where('Client_ID', auth()->user()->client_id)
                ->where('Bank_Type_ID', config('constants.OFFICE_BANK_TYPE_ID'))
                ->first();

            if (in_array($accountRefId, [2, 93])) {
                $transaction->update([
                    'Paid_In_Out' => 2,
                    'Is_Bill' => 1,
                    'Payment_Type_ID' => 28,
                ]);
                $transaction->save();
            } elseif (in_array($accountRefId, [90, 91])) {
                $transaction->update([
                    'Bank_Account_ID' => $officeAccount->id,
                    'Paid_In_Out' => 1,
                    'Payment_Type_ID' => 15,
                ]);

                // Handle extra bill generation
                if ($accountRefId == 90) {
                    $transaction->update(['Account_Ref_ID' => 86]);
                } elseif ($accountRefId == 91) {
                    $transaction->update(['Account_Ref_ID' => 87]);
                }
                $transaction->save();
            }

            if (in_array($accountRefId, [2, 93, 90, 91])) {
                $transaction->save();
            }

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transactions.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }




    public function getAccountDetails($id)
    {
        $bankAccount = BankAccount::with('bankAccountType')->find($id);

        if (!$bankAccount) {
            return response()->json(['error' => 'Bank Account not found'], 404);
        }

        return response()->json($bankAccount);
    }


    public function getPaymentTypes(Request $request)
    {

        $validated = $request->validate([
            'bankAccountTypeId' => 'required|integer|exists:bankaccounttype,Bank_Type_ID',
            'paidInOut' => 'required|in:1,2', // 1 = Paid In, 2 = Paid Out
        ]);

        // Fetch payment types for given Bank_Type_ID and Paid_In_Out
        $paymentTypes = PaymentType::where('Bank_Type_ID', $validated['bankAccountTypeId'])
            ->where('Paid_In_Out', $validated['paidInOut'])
            ->get(['Payment_Type_ID', 'Payment_Type_Name']); // Return only required fields

        if ($paymentTypes->isEmpty()) {
            return response()->json(['message' => 'No payment types available'], 404);
        }

        return response()->json($paymentTypes);
    }


    public function getAccountRef(Request $request)
    {

        $bankAccountId = $request->input('bankTypeId');

        $pinout = $request->input('pinout');

        // $pinoutValue = ($pinout == 1) ? 'Paid In' : 'Paid Out';

        $accountRefs = AccountRef::where('Bank_Type_ID', $bankAccountId)
            ->where('Paid_In_Out', $pinout)
            ->get();
        // dd($accountRefs);

        return response()->json($accountRefs);
    }


    public function getVatTypes(Request $request)
    {
        $accountRefId = $request->input('Account_Ref_ID');

        // Query VAT types based on Account_Ref_ID
        $vatTypes = DB::table('vataccref')
            ->join('vattype', 'vataccref.VAT_ID', '=', 'vattype.VAT_ID')
            ->where('vataccref.Account_Ref_ID', $accountRefId)
            ->select('vattype.VAT_ID', 'vattype.VAT_Name')
            ->get();

        return response()->json($vatTypes);
    }

    public function import($id)
{
    try {
       
        $userRole = auth()->user()->User_Role; 
        
        if (!in_array($userRole, [1, 2])) {
            return redirect()->route('transactions.index')->with('error', 'You are not authorized to import transactions.');
        }

        // Find the transaction by ID
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }

        // Check if the transaction is already imported
        if ($transaction->Is_Imported == 1) {
            return redirect()->route('transactions.index')->with('error', 'Transaction is already imported.');
        }

        // Update the transaction's imported status to 1
        $transaction->update(['Is_Imported' => 1]);

        return redirect()->route('transactions.index')->with('success', 'Transaction imported successfully.');
    } catch (\Exception $e) {
        return redirect()->route('transactions.index')->with('error', 'An error occurred: ' . $e->getMessage());
    }
}

   
}

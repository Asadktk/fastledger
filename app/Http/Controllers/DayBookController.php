<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\AccountRef;
use App\Models\BankAccount;
use App\Models\PaymentType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\DataTables\DayBookDataTable;
use App\DataTables\TransactionDataTable;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class DayBookController extends Controller
{

    public function index(DayBookDataTable $dataTable)
    {
        $view = request()->get('view', 'day_book');

        if ($view === 'batch_invoicing') {
            $currentClientId = auth()->user()->Client_ID;
            $bankAccounts = BankAccount::with('bankAccountType')
                ->where('Client_ID', $currentClientId)
                ->where('Is_Deleted', 0)
                ->get();

            return $dataTable->render('admin.batch_invoicing.batch_invoicing', compact('bankAccounts'));
        }
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


    // coorect code for single entry 

    public function store(StoreTransactionRequest $request)
    {

        $validated = $request->validated();

        DB::beginTransaction();
        try {

            // foreach ($transactions as $validated) {
            // Step 1: Validate Bank Account
            $bankAccount = BankAccount::find($validated['Bank_Account_ID']);
            if (!$bankAccount) {
                return redirect()->route('transactions.index')->with('error', 'Invalid Bank Account ID.');
            }

            // Step 2: Validate File
            $file = File::where('Ledger_Ref', $validated['Ledger_Ref'])->first();
            if (!$file) {
                return redirect()->route('transactions.index')->with('error', 'No matching file found.');
            }

            // Step 3: Create the initial transaction
            $transaction = new Transaction();
            $transaction->transaction_date = $validated['Transaction_Date'];
            $transaction->file_id = $file->File_ID;
            $transaction->bank_account_id = $validated['Bank_Account_ID'];
            $transaction->paid_in_out = $validated['Paid_In_Out'];
            $transaction->payment_type_id = $validated['Payment_Type_ID'];
            $transaction->cheque = $validated['Cheque'] ?? null;
            $transaction->amount = $validated['Amount'];
            $transaction->description = $validated['Description'] ?? '';
            $transaction->is_imported = 0;
            $transaction->created_by = auth()->id();
            $transaction->created_on = now();
            $transaction->account_ref_id = $validated['Account_Ref_ID'];
            $transaction->is_bill = 0;

            // Step 4: Adjust VAT if necessary
            if (!in_array($transaction->account_ref_id, [2, 93]) && isset($validated['VAT_ID'])) {
                $transaction->vat_id = $validated['VAT_ID'];
            }

            // Step 5: Adjust Account_Ref_ID for specific cases
            if (in_array($transaction->account_ref_id, [2, 93])) {
                $transaction->account_ref_id = ($transaction->account_ref_id == 2) ? 101 : 99;
            }

            // Step 6: Save the initial transaction
            $transaction->save();

            // Step 7: Handle second transaction for Account_Ref_ID 2 or 93
            if (in_array($validated['Account_Ref_ID'], [2, 93])) {
                $secondTransaction = $transaction->replicate();
                $secondTransaction->paid_in_out = 2;
                $secondTransaction->is_bill = 1;
                $secondTransaction->payment_type_id = 28;
                $secondTransaction->account_ref_id = ($validated['Account_Ref_ID'] == 2) ? 99 : 101;
                $secondTransaction->created_on = now();
                $secondTransaction->vat_id = $validated['VAT_ID'] ?? null;
                $secondTransaction->save();
            }

            // Step 8: Handle transactions when Account_Ref_ID is 90 or 91
            if (in_array($transaction->account_ref_id, [90, 91])) {

                // Assign bank account and payment details
                $transaction->bank_account_id = 23;
                $transaction->paid_in_out = 1;
                $transaction->payment_type_id = 15;
                $transaction->vat_id = null;
                // Store the original account_ref_id before modifying
                $originalAccountRefId = $transaction->account_ref_id;

                // Process extra bills when account_ref_id = 90
                if ($originalAccountRefId == 90) {

                    // First extra bill (with VAT ID = 3)
                    $extraBill1 = $transaction->replicate();
                    $extraBill1->account_ref_id = 99;
                    $extraBill1->paid_in_out = 2;
                    $extraBill1->is_bill = 1;
                    $extraBill1->payment_type_id = 28;
                    $extraBill1->vat_id = $validated['VAT_ID'];
                    $extraBill1->created_on = now();
                    $extraBill1->save();

                    // Second extra bill
                    $extraBill2 = $transaction->replicate();
                    $extraBill2->bank_account_id = $validated['Bank_Account_ID'];
                    $extraBill2->account_ref_id = 86;
                    $extraBill2->paid_in_out = 2;
                    $extraBill2->payment_type_id = 19;
                    $extraBill2->vat_id = null;
                    $extraBill2->created_on = now();
                    $extraBill2->save();
                }

                // Modify the original transaction's account_ref_id
                if ($originalAccountRefId == 90) {
                    $transaction->account_ref_id = 86;
                } elseif ($originalAccountRefId == 91) {
                    $transaction->account_ref_id = 87;
                }
            }

            // Step 9: Save the modified transaction
            $transaction->save();
        // }
            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transactions.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }





    public function edit($id)
    {
        dd('yessds');
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
        }

        return view('admin.day_book.edit', compact('transaction'));
    }

    public function update(UpdateTransactionRequest $request, $id)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $transaction = Transaction::find($id);

            if (!$transaction) {
                return redirect()->route('transactions.index')->with('error', 'Transaction not found.');
            }

            // Step 1: Validate Bank Account
            $bankAccount = BankAccount::find($validated['Bank_Account_ID']);
            if (!$bankAccount) {
                return redirect()->route('transactions.index')->with('error', 'Invalid Bank Account ID.');
            }

            // Step 2: Validate File
            $file = File::where('Ledger_Ref', $validated['Ledger_Ref'])->first();
            if (!$file) {
                return redirect()->route('transactions.index')->with('error', 'No matching file found.');
            }

            // Step 3: Update transaction details
            $transaction->transaction_date = $validated['Transaction_Date'];
            $transaction->file_id = $file->File_ID;
            $transaction->bank_account_id = $validated['Bank_Account_ID'];
            $transaction->paid_in_out = $validated['Paid_In_Out'];
            $transaction->payment_type_id = $validated['Payment_Type_ID'];
            $transaction->cheque = $validated['Cheque'] ?? null;
            $transaction->amount = $validated['Amount'];
            $transaction->description = $validated['Description'] ?? '';
            $transaction->modified_by = auth()->id();
            $transaction->modified_on = now();
            $transaction->account_ref_id = $validated['Account_Ref_ID'];

            // Step 4: Adjust VAT if necessary
            if (!in_array($transaction->account_ref_id, [2, 93]) && isset($validated['VAT_ID'])) {
                $transaction->vat_id = $validated['VAT_ID'];
            }

            // Step 5: Adjust Account_Ref_ID for specific cases
            if (in_array($transaction->account_ref_id, [2, 93])) {
                $transaction->account_ref_id = ($transaction->account_ref_id == 2) ? 101 : 99;
            }

            // Step 6: Save updated transaction
            $transaction->save();

            // Step 7: Handle second transaction for Account_Ref_ID 2 or 93
            if (in_array($validated['Account_Ref_ID'], [2, 93])) {
                $secondTransaction = Transaction::where([
                    'file_id' => $transaction->file_id,
                    'is_bill' => 1
                ])->first();

                if ($secondTransaction) {
                    $secondTransaction->paid_in_out = 2;
                    $secondTransaction->is_bill = 1;
                    $secondTransaction->payment_type_id = 28;
                    $secondTransaction->account_ref_id = ($validated['Account_Ref_ID'] == 2) ? 99 : 101;
                    $secondTransaction->vat_id = $validated['VAT_ID'] ?? null;
                    $secondTransaction->modified_on = now();
                    $secondTransaction->save();
                }
            }

            // Step 8: Handle transactions when Account_Ref_ID is 90 or 91
            if (in_array($transaction->account_ref_id, [90, 91])) {
                $transaction->bank_account_id = 23;
                $transaction->paid_in_out = 1;
                $transaction->payment_type_id = 15;
                $transaction->vat_id = null;
                $originalAccountRefId = $transaction->account_ref_id;

                if ($originalAccountRefId == 90) {
                    // First extra bill
                    $extraBill1 = Transaction::where([
                        'file_id' => $transaction->file_id,
                        'account_ref_id' => 99,
                        'is_bill' => 1
                    ])->first();

                    if ($extraBill1) {
                        $extraBill1->vat_id = $validated['VAT_ID'];
                        $extraBill1->modified_on = now();
                        $extraBill1->save();
                    }

                    // Second extra bill
                    $extraBill2 = Transaction::where([
                        'file_id' => $transaction->file_id,
                        'account_ref_id' => 86,
                        'paid_in_out' => 2
                    ])->first();

                    if ($extraBill2) {
                        $extraBill2->bank_account_id = $validated['Bank_Account_ID'];
                        $extraBill2->modified_on = now();
                        $extraBill2->save();
                    }
                }

                if ($originalAccountRefId == 90) {
                    $transaction->account_ref_id = 86;
                } elseif ($originalAccountRefId == 91) {
                    $transaction->account_ref_id = 87;
                }
            }

            // Step 9: Save the modified transaction
            $transaction->save();

            DB::commit();
            return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
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


    
    public function storeMultiple(StoreTransactionRequest $request)
    {
        $validatedData = $request->validated();

        // Check if transactions array is present
        if (!isset($validatedData['transactions']) || !is_array($validatedData['transactions'])) {
            return redirect()->route('transactions.index')->with('error', 'No transactions provided.');
        }

        DB::beginTransaction();

        try {
            $timestamp = now();
            $userId = auth()->id();
            $successCount = 0;
            $failedTransactions = [];

            foreach ($validatedData['transactions'] as $index => $transactionData) {
                try {
                    // Step 1: Validate Bank Account
                    $bankAccount = BankAccount::find($transactionData['Bank_Account_ID']);
                    if (!$bankAccount) {
                        $failedTransactions[] = "Row {$index}: Invalid Bank Account ID.";
                        continue;
                    }

                    // Step 2: Validate File
                    $file = File::where('Ledger_Ref', $transactionData['Ledger_Ref'])->first();
                    if (!$file) {
                        $failedTransactions[] = "Row {$index}: No matching file found.";
                        continue;
                    }

                    // Step 3: Create initial transaction
                    $transaction = new Transaction([
                        'transaction_date' => $transactionData['Transaction_Date'],
                        'file_id' => $file->File_ID,
                        'bank_account_id' => $transactionData['Bank_Account_ID'],
                        'paid_in_out' => $transactionData['Paid_In_Out'],
                        'payment_type_id' => $transactionData['Payment_Type_ID'],
                        'cheque' => $transactionData['Cheque'] ?? null,
                        'amount' => $transactionData['Amount'],
                        'description' => $transactionData['Description'] ?? '',
                        'is_imported' => 0,
                        'created_by' => $userId,
                        'created_on' => $timestamp,
                        'account_ref_id' => $transactionData['Account_Ref_ID'],
                        'is_bill' => 0,
                    ]);

                    // Step 4: Adjust VAT if necessary
                    if (!in_array($transaction->account_ref_id, [2, 93]) && isset($transactionData['VAT_ID'])) {
                        $transaction->vat_id = $transactionData['VAT_ID'];
                    }

                    // Step 5: Adjust Account_Ref_ID for specific cases
                    if (in_array($transaction->account_ref_id, [2, 93])) {
                        $transaction->account_ref_id = ($transaction->account_ref_id == 2) ? 101 : 99;
                    }

                    $transaction->save();

                    // Step 6: Handle second transaction for Account_Ref_ID 2 or 93
                    if (in_array($transactionData['Account_Ref_ID'], [2, 93])) {
                        $this->createSecondaryTransaction($transaction, $transactionData, $timestamp);
                    }

                    // Step 7: Handle specific Account_Ref_ID scenarios (90, 91)
                    if (in_array($transaction->account_ref_id, [90, 91])) {
                        $this->handleSpecialTransactions($transaction, $transactionData, $timestamp);
                    }

                    $transaction->save();

                    $successCount++;
                } catch (\Exception $e) {
                    $failedTransactions[] = "Row {$index}: Error - " . $e->getMessage();
                }
            }

            DB::commit();

            $message = "{$successCount} transactions added successfully.";
            if (!empty($failedTransactions)) {
                $message .= " Some transactions failed: " . implode(' | ', $failedTransactions);
            }

            return redirect()->route('transactions.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('transactions.index')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    private function createSecondaryTransaction(Transaction $transaction, array $data, $timestamp): void
    {
        $secondTransaction = $transaction->replicate();
        $secondTransaction->paid_in_out = 2;
        $secondTransaction->is_bill = 1;
        $secondTransaction->payment_type_id = 28;
        $secondTransaction->account_ref_id = ($data['Account_Ref_ID'] == 2) ? 99 : 101;
        $secondTransaction->created_on = $timestamp;
        $secondTransaction->vat_id = $data['VAT_ID'] ?? null;
        $secondTransaction->save();
    }

    private function handleSpecialTransactions(Transaction $transaction, array $data, $timestamp): void
    {
        $transaction->bank_account_id = 23;
        $transaction->paid_in_out = 1;
        $transaction->payment_type_id = 15;
        $transaction->vat_id = null;

        $originalAccountRefId = $transaction->account_ref_id;

        if ($originalAccountRefId === 90) {
            $extraBill1 = $transaction->replicate();
            $extraBill1->account_ref_id = 99;
            $extraBill1->paid_in_out = 2;
            $extraBill1->is_bill = 1;
            $extraBill1->payment_type_id = 28;
            $extraBill1->vat_id = $data['VAT_ID'];
            $extraBill1->created_on = $timestamp;
            $extraBill1->save();

            $extraBill2 = $transaction->replicate();
            $extraBill2->bank_account_id = $data['Bank_Account_ID'];
            $extraBill2->account_ref_id = 86;
            $extraBill2->paid_in_out = 2;
            $extraBill2->payment_type_id = 19;
            $extraBill2->vat_id = null;
            $extraBill2->created_on = $timestamp;
            $extraBill2->save();
        }

        $transaction->account_ref_id = ($originalAccountRefId === 90) ? 86 : 87;
    }
}

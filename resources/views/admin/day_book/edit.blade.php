@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Edit Transaction</div>
                        </div>
                        <div class="card-body">
                            <x-form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
                                @method('PUT')
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Date (dd/mm/yyyy)</label>
                                        <input type="date" class="form-control" name="Transaction_Date" value="{{ $transaction->Transaction_Date }}" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Ledger Ref</label>
                                        <input type="text" class="form-control" name="Ledger_Ref" value="{{ $transaction->Ledger_Ref }}" />
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Bank Account:</label>
                                        <select name="Bank_Account_ID" id="BankAccountDropdown" class="form-select">
                                            <option value="" disabled>Select Bank Account</option>
                                            @foreach ($bankAccounts as $bankAccount)
                                                <option value="{{ $bankAccount->Bank_Account_ID }}" data-bank-type="{{ $bankAccount->Bank_Type_ID }}"
                                                    {{ $transaction->Bank_Account_ID == $bankAccount->Bank_Account_ID ? 'selected' : '' }}>
                                                    {{ $bankAccount->Bank_Name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Paid In/Out</label>
                                        <select name="Paid_In_Out" id="PaidInOutDropdown" class="form-select">
                                            <option value="1" {{ $transaction->Paid_In_Out == 1 ? 'selected' : '' }}>Paid In</option>
                                            <option value="2" {{ $transaction->Paid_In_Out == 2 ? 'selected' : '' }}>Paid Out</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Payment Type</label>
                                        <select name="Payment_Type_ID" id="PaymentTypeDropdown" class="form-select">
                                            <option value="" disabled>Select Payment Type</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Account Ref</label>
                                        <select name="Account_Ref_ID" id="txtAccountRef" class="form-select">
                                            <option value="" disabled>Select Account Ref</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">VAT Type</label>
                                        <select name="VAT_ID" id="txtVatType" class="form-select">
                                            <option value="" disabled>Select VAT Type</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Payment/Bill Ref</label>
                                        <input type="text" class="form-control" name="Cheque" value="{{ $transaction->Cheque }}" />
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Amount</label>
                                        <input type="number" class="form-control" name="Amount" value="{{ $transaction->Amount }}" />
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control" name="Description" rows="4">{{ $transaction->Description }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </x-form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const bankAccountDropdown = $("#BankAccountDropdown");
        const paidInOutDropdown = $("#PaidInOutDropdown");
        const paymentTypeDropdown = $("#PaymentTypeDropdown");
        const accountRefDropdown = $("#txtAccountRef");
        const vatTypeDropdown = $("#txtVatType");

        const fetchPaymentTypes = async () => {
            let bankType = bankAccountDropdown.find(":selected").data("bank-type");
            let paidInOut = paidInOutDropdown.val();

            if (!bankType || !paidInOut) {
                paymentTypeDropdown.html('<option value="" selected disabled>Select Payment Type</option>');
                return;
            }

            try {
                const response = await fetch("{{ route('transactions.getPaymentTypes') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    body: JSON.stringify({ bankAccountTypeId: bankType, paidInOut }),
                });

                const paymentTypes = await response.json();
                paymentTypeDropdown.html('<option value="" selected disabled>Select Payment Type</option>');
                paymentTypes.forEach(pt => {
                    paymentTypeDropdown.append(`<option value="${pt.Payment_Type_ID}">${pt.Payment_Type_Name}</option>`);
                });
            } catch (error) {
                console.error("Error fetching payment types:", error);
            }
        };

        const fetchAccountRefs = async () => {
            let bankType = bankAccountDropdown.find(":selected").data("bank-type");
            let paidInOut = paidInOutDropdown.val();

            if (!bankType || !paidInOut) {
                accountRefDropdown.html('<option value="" selected disabled>Select Account Ref</option>');
                return;
            }

            try {
                const response = await fetch("{{ route('transactions.getAccountRefs') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    body: JSON.stringify({ bankTypeId: bankType, pinout: paidInOut }),
                });

                const accountRefs = await response.json();
                accountRefDropdown.html('<option value="" selected disabled>Select Account Ref</option>');
                accountRefs.forEach(ar => {
                    accountRefDropdown.append(`<option value="${ar.Account_Ref_ID}">${ar.Reference}</option>`);
                });
            } catch (error) {
                console.error("Error fetching account refs:", error);
            }
        };

        bankAccountDropdown.change(() => { fetchPaymentTypes(); fetchAccountRefs(); });
        paidInOutDropdown.change(() => { fetchPaymentTypes(); fetchAccountRefs(); });
    });
</script>
@endsection

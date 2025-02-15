@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Complete Transaction Form</div>
                            <div class="prism-toggle">
                                <button class="btn btn-sm btn-primary-light">Show Code<i
                                        class="ri-code-line ms-2 d-inline-block align-middle"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <x-form method="POST" action="transactions.store">
                                <div class="row">
                                    <!-- Date and Transaction Information -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Date (dd/mm/yyyy)</label>
                                        <input type="date" class="form-control @error('Transaction_Date') is-invalid @enderror" name="Transaction_Date"
                                            placeholder="dd/mm/yyyy" />
                                            @error('Transaction_Date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Ledger Ref</label>
                                        <input type="text" class="form-control @error('Ledger_Ref') is-invalid @enderror" name="Ledger_Ref"
                                            placeholder="Ledger Reference"/>
                                            @error('Ledger_Ref')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                    <label class="form-label">Bank Account:</label>
                                    <select id="BankAccountDropdown" name="Bank_Account_ID" class="form-select @error('Bank_Account_ID') is-invalid @enderror">
                                        <option value="" selected disabled>Select Bank Account</option>
                                        @foreach ($bankAccounts as $bankAccount)
                                            <option value="{{ $bankAccount->Bank_Account_ID }}"
                                                data-bank-type="{{ $bankAccount->Bank_Type_ID }}">
                                                {{ $bankAccount->Bank_Name }}
                                                ({{ $bankAccount->bankAccountType->Bank_Type ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('Bank_Account_ID')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                    <div class="mb-3 col-md-6">
                                        <label for="txtPaidInOut" class="form-label">Paid In/Out</label>
                                        <select id="PaidInOutDropdown" name="Paid_In_Out" class="form-select @error('Paid_In_Out') is-invalid @enderror">
                                            <option value="" selected disabled>Select Paid In/Out</option>
                                            <option value="1">Paid In</option>
                                            <option value="2">Paid Out</option>
                                        </select>
                                        @error('Paid_In_Out')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Payment Type Dropdown -->
                                    <div class="mb-3 col-md-6">
                                        <label for="txtPaymentType" class="form-label">Payment Type</label>
                                        <select id="PaymentTypeDropdown" name="Payment_Type_ID" class="form-select @error('Payment_Type_ID') is-invalid @enderror">
                                            <option value="" selected disabled>Select Payment Type</option>
                                            <!-- Dynamically filled via JavaScript -->
                                        </select>
                                        @error('Payment_Type_ID')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Account Ref Dropdown -->
                                    <div class="mb-3 col-md-6">
                                        <label for="txtAccountRef" class="form-label">Account Ref</label>
                                        <select id="txtAccountRef" name="Account_Ref_ID" class="form-select @error('Account_Ref_ID') is-invalid @enderror">
                                            <option value="" selected disabled>Select Account Ref</option>
                                            <!-- This dropdown will be populated dynamically with JavaScript -->
                                        </select>
                                        @error('Account_Ref_ID')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- VAT Type Dropdown -->
                                    <div class="mb-3 col-md-6">
                                        <label for="txtVatType" class="form-label">VAT Type</label>
                                        <select id="txtVatType" name="VAT_ID" class="form-select" >
                                            <option value="" selected disabled>Select VAT Type</option>
                                        </select>
                                    </div>
                                    <!-- Payment/Bill Ref -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Payment/Bill Ref</label>
                                        <input type="text" class="form-control" name="Cheque"
                                            placeholder="Payment/Bill Reference" />
                                    </div>
                                    <!-- Amount -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Amount</label>
                                        <input type="number" class="form-control @error('Amount') is-invalid @enderror" name="Amount" placeholder="Amount"/>
                                        @error('Amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Description -->
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Description</label>
                                        <textarea class="form-control @error('Description') is-invalid @enderror" name="Description" rows="4" placeholder="Transaction Description"></textarea>
                                        @error('Description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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

<!-- jQuery Script for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bankAccountDropdown = document.getElementById('BankAccountDropdown');
        const paidInOutDropdown = document.getElementById('PaidInOutDropdown');
        const paymentTypeDropdown = document.getElementById('PaymentTypeDropdown');
        const accountRefDropdown = document.getElementById('txtAccountRef');

        // Function to fetch Payment Types
        const fetchPaymentTypes = async () => {
            const selectedBankType = bankAccountDropdown.options[bankAccountDropdown.selectedIndex]
                ?.dataset.bankType;
            const selectedPaidInOut = paidInOutDropdown.value;

            if (!selectedBankType || !selectedPaidInOut) {
                paymentTypeDropdown.innerHTML =
                    `<option value="" selected disabled>Select Payment Type</option>`;
                return; // Exit if required fields are not selected
            }

            try {
                const response = await fetch('get-payment-types', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        bankAccountTypeId: selectedBankType, // Send Bank_Type_ID here
                        paidInOut: selectedPaidInOut,
                        
                    }),
                });

                if (!response.ok) throw new Error('Failed to fetch payment types');

                const paymentTypes = await response.json();
                paymentTypeDropdown.innerHTML =
                    `<option value="" selected disabled>Select Payment Type</option>`;
                paymentTypes.forEach(paymentType => {
                    paymentTypeDropdown.innerHTML += `
                    <option value="${paymentType.Payment_Type_ID}">
                        ${paymentType.Payment_Type_Name}
                    </option>`;
                });
            } catch (error) {
                console.error('Error fetching payment types:', error);
                paymentTypeDropdown.innerHTML =
                    `<option value="" selected disabled>No Payment Types Found</option>`;
            }
        };

        // Function to fetch Account Refs
        const fetchAccountRefs = async () => {
            const selectedBankAccount = bankAccountDropdown.value;
            const selectedPaidInOut = paidInOutDropdown.value;
            const selectedBankType = bankAccountDropdown.options[bankAccountDropdown.selectedIndex]
                ?.dataset.bankType; // Get Bank_Type_ID

            if (!selectedBankAccount || !selectedPaidInOut || !selectedBankType) {
                accountRefDropdown.innerHTML =
                    `<option value="" selected disabled>Select Account Ref</option>`;
                return; // Exit if required fields are not selected
            }

            try {
                const response = await fetch('get-account-ref', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        // bankAccountId: selectedBankAccount, // Send Bank_Account_ID
                        pinout: selectedPaidInOut, // Send Paid In/Out value
                        bankTypeId: selectedBankType, // Send Bank_Type_ID
                    }),
                });

                if (!response.ok) throw new Error('Failed to fetch account refs');

                const accountRefs = await response.json();
                accountRefDropdown.innerHTML =
                    `<option value="" selected disabled>Select Account Ref</option>`;
                accountRefs.forEach(accountRef => {
                    accountRefDropdown.innerHTML += `
                    <option value="${accountRef.Account_Ref_ID}">
                        ${accountRef.Reference}
                    </option>`;
                });
            } catch (error) {
                console.error('Error fetching account refs:', error);
                accountRefDropdown.innerHTML =
                    `<option value="" selected disabled>No Account Ref Found</option>`;
            }
        };

        // Add event listeners to triggers
        bankAccountDropdown.addEventListener('change', () => {
            fetchPaymentTypes();
            fetchAccountRefs();
        });
        paidInOutDropdown.addEventListener('change', () => {
            fetchPaymentTypes();
            fetchAccountRefs();
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        const accountRefDropdown = document.getElementById('txtAccountRef');
        const vatTypeDropdown = document.getElementById('txtVatType');

        const fetchVatTypes = async () => {
            const selectedAccountRef = accountRefDropdown.value;

            if (!selectedAccountRef) {
                vatTypeDropdown.innerHTML =
                    `<option value="" selected disabled>Select VAT Type</option>`;
                return;
            }

            try {
                const response = await fetch('/transactions/get-vat-types', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        Account_Ref_ID: selectedAccountRef
                    }),
                });

                if (!response.ok) throw new Error('Failed to fetch VAT types');

                const vatTypes = await response.json();
                vatTypeDropdown.innerHTML =
                    `<option value="" selected disabled>Select VAT Type</option>`;
                vatTypes.forEach(vatType => {
                    vatTypeDropdown.innerHTML += `
                <option value="${vatType.VAT_ID}">
                    ${vatType.VAT_Name}
                </option>`;
                });
            } catch (error) {
                console.error('Error fetching VAT types:', error);
                vatTypeDropdown.innerHTML =
                    `<option value="" selected disabled>No VAT Types Found</option>`;
            }
        };

        accountRefDropdown.addEventListener('change', fetchVatTypes);
    });
</script>

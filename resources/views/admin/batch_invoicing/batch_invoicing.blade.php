@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">Batch Invoicing</div>
                            <div class="prism-toggle">
                                <button class="btn btn-sm btn-primary-light">Show Code<i
                                        class="ri-code-line ms-2 d-inline-block align-middle"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <x-form method="POST" action="transactions.store">

                                <div id="entryContainer">
                                    <div class="row d-flex flex-wrap align-items-end gx-2 entryRow">
                                        <div class="col-md-1">
                                            <label class="form-label">Date</label>
                                            <input type="date" class="form-control" name="Transaction_Date[]" />
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Ledger Ref</label>
                                            <input type="text" class="form-control" name="Ledger_Ref[]" />
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Bank Account</label>
                                            <select id="BankAccountDropdown" name="Bank_Account_ID[]" class="form-select @error('Bank_Account_ID') is-invalid @enderror">
                                                <option value="" selected disabled>Select Bank Account</option>
                                                @foreach ($bankAccounts as $bankAccount)
                                                    <option value="{{ $bankAccount->Bank_Account_ID }}" 
                                                            data-bank-type="{{ $bankAccount->Bank_Type_ID }}"
                                                            {{ old('Bank_Account_ID.0') == $bankAccount->Bank_Account_ID ? 'selected' : '' }}>
                                                        {{ $bankAccount->Bank_Name }} ({{ $bankAccount->bankAccountType->Bank_Type ?? 'N/A' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('Bank_Account_ID')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Paid In/Out</label>
                                            <select id="PaidInOutDropdown" name="Paid_In_Out[]" class="form-select @error('Paid_In_Out') is-invalid @enderror">
                                                <option value="" selected disabled>Select Paid In/Out</option>
                                                <option value="1" {{ old('Paid_In_Out.0') == 1 ? 'selected' : '' }}>Paid In</option>
                                                <option value="2" {{ old('Paid_In_Out.0') == 2 ? 'selected' : '' }}>Paid Out</option>
                                            </select>
                                            @error('Paid_In_Out')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Payment Type</label>
                                            <select id="PaymentTypeDropdown" name="Payment_Type_ID[]" class="form-select @error('Payment_Type_ID') is-invalid @enderror">
                                                <option value="" selected disabled>Select Payment Type</option>
                                            </select>
                                            @error('Payment_Type_ID')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Account Ref</label>
                                            <select id="txtAccountRef" name="Account_Ref_ID[]"
                                                class="form-select @error('Account_Ref_ID') is-invalid @enderror">
                                                <option value="" selected disabled>Select Account Ref</option>
                                                <!-- This dropdown will be populated dynamically with JavaScript -->
                                            </select>
                                            @error('Account_Ref_ID')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">VAT Type</label>
                                            <select id="txtVatType" name="VAT_ID[]" class="form-select">
                                                <option value="" selected disabled>Select VAT Type</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Amount</label>
                                            <input type="number" class="form-control @error('Amount') is-invalid @enderror"
                                                name="Amount[]" placeholder="Amount" />
                                            @error('Amount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control @error('Description') is-invalid @enderror" name="Description[]" rows="1"
                                                placeholder="Transaction Description"></textarea>
                                            @error('Description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-danger removeEntry">X</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <button type="button" id="addEntry" class="btn btn-success">Add More</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </x-form>

                            <div class="table-responsive">
                                {!! $dataTable->table(['class' => 'table table-striped table-bordered text-nowrap table-sm'], true) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}

    
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
                    const response = await fetch('/transactions/get-payment-types', {
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
                    const response = await fetch('/transactions/get-account-ref', {
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

         document.getElementById('addEntry').addEventListener('click', function() {
            let container = document.getElementById('entryContainer');
            let firstRow = document.querySelector('.entryRow');

            // Create a new row
            let newRow = document.createElement('div');
            newRow.classList.add('row', 'd-flex', 'flex-wrap', 'align-items-end', 'gx-2', 'entryRow');

            // Select only input, select, and textarea fields (excluding labels)
            firstRow.querySelectorAll('input, select, textarea').forEach(el => {
                let col = document.createElement('div');
                col.className = 'col-md-1';

                // Clone only the input, select, or textarea (without label)
                let clonedField = el.cloneNode(true);
                clonedField.value = ''; // Clear values

                col.appendChild(clonedField);
                newRow.appendChild(col);
            });

            // Add remove button
            let removeCol = document.createElement('div');
            removeCol.className = 'col-md-1 text-end';
            removeCol.innerHTML = `<button type="button" class="btn btn-danger removeEntry">X</button>`;
            newRow.appendChild(removeCol);

            container.appendChild(newRow);
        });

       
    

        //  document.getElementById('addEntry').addEventListener('click', function() {
        //     let container = document.getElementById('entryContainer');
        //     let firstRow = document.querySelector('.entryRow');

        //     // Create a new row
        //     let newRow = document.createElement('div');
        //     newRow.classList.add('row', 'd-flex', 'flex-wrap', 'align-items-end', 'gx-2', 'entryRow');

        //     // Select only input, select, and textarea fields (excluding labels)
        //     firstRow.querySelectorAll('input, select, textarea').forEach(el => {
        //         let col = document.createElement('div');
        //         col.className = 'col-md-1';

        //         // Clone only the input, select, or textarea (without label)
        //         let clonedField = el.cloneNode(true);
        //         clonedField.value = ''; // Clear values

        //         col.appendChild(clonedField);
        //         newRow.appendChild(col);
        //     });

        //     // Add remove button
        //     let removeCol = document.createElement('div');
        //     removeCol.className = 'col-md-1 text-end';
        //     removeCol.innerHTML = `<button type="button" class="btn btn-danger removeEntry">X</button>`;
        //     newRow.appendChild(removeCol);

        //     container.appendChild(newRow);
        // });

        // Remove row when clicking "X" button
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeEntry')) {
                e.target.closest('.entryRow').remove();
            }
        });
    </script>
@endsection

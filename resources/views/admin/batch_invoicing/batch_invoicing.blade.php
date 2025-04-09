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
                            <form method="POST" action="{{ route('transactions.store-multiple') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div id="entryContainer">
                                    <div class="row d-flex flex-wrap align-items-end gx-2 entryRow">
                                        <div class="col-md-1">
                                            <label class="form-label">Date</label>
                                            <input type="date" class="form-control"
                                                name="transactions[0][Transaction_Date]" required />
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Ledger Ref</label>
                                            <input type="text" class="form-control" name="transactions[0][Ledger_Ref]"
                                                required />
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Bank Account</label>
                                            <select id="BankAccountDropdown" name="transactions[0][Bank_Account_ID]"
                                                class="form-select" required>
                                                <option value="" selected disabled>Select Bank Account</option>
                                                @foreach ($bankAccounts as $bankAccount)
                                                    <option value="{{ $bankAccount->Bank_Account_ID }}"
                                                        data-bank-type="{{ $bankAccount->Bank_Type_ID }}">
                                                        {{ $bankAccount->Bank_Name }}
                                                        ({{ $bankAccount->bankAccountType->Bank_Type ?? 'N/A' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Paid In/Out</label>
                                            <select id="PaidInOutDropdown" name="transactions[0][Paid_In_Out]"
                                                class="form-select" required>
                                                <option value="" selected disabled>Select Paid In/Out</option>
                                                <option value="1">Paid In</option>
                                                <option value="2">Paid Out</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Payment Type</label>
                                            <select id="PaymentTypeDropdown" name="transactions[0][Payment_Type_ID]"
                                                class="form-select">
                                                <option value="" selected disabled>Select Payment Type</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Account Ref</label>
                                            <select id="txtAccountRef" name="transactions[0][Account_Ref_ID]"
                                                class="form-select">
                                                <option value="" selected disabled>Select Account Ref</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">VAT Type</label>
                                            <select id="txtVatType" name="transactions[0][VAT_ID]" class="form-select">
                                                <option value="" selected disabled>Select VAT Type</option>
                                            </select>
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Cheque</label>
                                            <input type="text" class="form-control" name="transactions[0][Cheque]"
                                                placeholder="Cheque" />
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Amount</label>
                                            <input type="number" class="form-control" name="transactions[0][Amount]"
                                                required />
                                        </div>

                                        <div class="col-md-1">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" name="transactions[0][Description]" rows="1" placeholder="Transaction Description"
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2 row align-items-end gx-2">
                                    {{-- <div class="col-md-2">
                                        <label for="rowCount" class="form-label">Number of Rows</label>
                                        <input type="number" id="rowCount" class="form-control" min="1"
                                            value="1" />
                                    </div> --}}
                                    {{-- <div class="col-md-2">
                                        <button type="button" id="addEntry" class="btn btn-success w-100">Add
                                            Rows</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                                    </div> --}}
                                </div>

                                <div class="mt-2 row align-items-end gx-2">
                                    <div class="col-md-1  align-items-center">
                                        <label for="rowCount" class="form-label me-2 mb-0">Number of Rows</label>
                                        <input type="number" id="rowCount" class="form-control" min="1"
                                            value="1" />
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" id="addEntry" class="btn btn-success w-100">Add
                                            Rows</button>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mt-5">
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
                    return;
                }

                try {
                    const response = await fetch('/transactions/get-payment-types', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            bankAccountTypeId: selectedBankType,
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
                    ?.dataset.bankType;

                if (!selectedBankAccount || !selectedPaidInOut || !selectedBankType) {
                    accountRefDropdown.innerHTML =
                        `<option value="" selected disabled>Select Account Ref</option>`;
                    return;
                }

                try {
                    const response = await fetch('/transactions/get-account-ref', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            bankAccountId: selectedBankAccount,
                            pinout: selectedPaidInOut,
                            bankTypeId: selectedBankType,
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

        // Add rows dynamically
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('entryContainer');

            // Event delegation for dynamically added dropdowns
            container.addEventListener('change', async (event) => {
                const target = event.target;

                // Handle BankAccountDropdown change
                if (target.matches('[id^="BankAccountDropdown"]')) {
                    const rowIndex = target.id.split('_')[1]; // Extract row index
                    const paidInOutDropdown = document.getElementById(`PaidInOutDropdown_${rowIndex}`);
                    const paymentTypeDropdown = document.getElementById(
                        `PaymentTypeDropdown_${rowIndex}`);
                    const accountRefDropdown = document.getElementById(`txtAccountRef_${rowIndex}`);

                    await fetchPaymentTypes(target, paidInOutDropdown, paymentTypeDropdown);
                    await fetchAccountRefs(target, paidInOutDropdown, accountRefDropdown);
                }

                // Handle PaidInOutDropdown change
                if (target.matches('[id^="PaidInOutDropdown"]')) {
                    const rowIndex = target.id.split('_')[1]; // Extract row index
                    const bankAccountDropdown = document.getElementById(
                        `BankAccountDropdown_${rowIndex}`);
                    const paymentTypeDropdown = document.getElementById(
                        `PaymentTypeDropdown_${rowIndex}`);
                    const accountRefDropdown = document.getElementById(`txtAccountRef_${rowIndex}`);

                    await fetchPaymentTypes(bankAccountDropdown, target, paymentTypeDropdown);
                    await fetchAccountRefs(bankAccountDropdown, target, accountRefDropdown);
                }

                // Handle AccountRefDropdown change
                if (target.matches('[id^="txtAccountRef"]')) {
                    const rowIndex = target.id.split('_')[1]; // Extract row index
                    const vatTypeDropdown = document.getElementById(`txtVatType_${rowIndex}`);
                    await fetchVatTypes(target, vatTypeDropdown);
                }
            });

            // Fetch Payment Types
            const fetchPaymentTypes = async (bankAccountDropdown, paidInOutDropdown, paymentTypeDropdown) => {
                const selectedBankType = bankAccountDropdown.options[bankAccountDropdown.selectedIndex]
                    ?.dataset.bankType;
                const selectedPaidInOut = paidInOutDropdown.value;

                if (!selectedBankType || !selectedPaidInOut) {
                    paymentTypeDropdown.innerHTML =
                        `<option value="" selected disabled>Select Payment Type</option>`;
                    return;
                }

                try {
                    const response = await fetch('/transactions/get-payment-types', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            bankAccountTypeId: selectedBankType,
                            paidInOut: selectedPaidInOut,
                        }),
                    });

                    if (!response.ok) throw new Error('Failed to fetch payment types');

                    const paymentTypes = await response.json();
                    paymentTypeDropdown.innerHTML =
                        `<option value="" selected disabled>Select Payment Type</option>`;
                    paymentTypes.forEach((paymentType) => {
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

            // Fetch Account Refs
            const fetchAccountRefs = async (bankAccountDropdown, paidInOutDropdown, accountRefDropdown) => {
                const selectedBankAccount = bankAccountDropdown.value;
                const selectedPaidInOut = paidInOutDropdown.value;
                const selectedBankType = bankAccountDropdown.options[bankAccountDropdown.selectedIndex]
                    ?.dataset.bankType;

                if (!selectedBankAccount || !selectedPaidInOut || !selectedBankType) {
                    accountRefDropdown.innerHTML =
                        `<option value="" selected disabled>Select Account Ref</option>`;
                    return;
                }

                try {
                    const response = await fetch('/transactions/get-account-ref', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            bankAccountId: selectedBankAccount,
                            pinout: selectedPaidInOut,
                            bankTypeId: selectedBankType,
                        }),
                    });

                    if (!response.ok) throw new Error('Failed to fetch account refs');

                    const accountRefs = await response.json();
                    accountRefDropdown.innerHTML =
                        `<option value="" selected disabled>Select Account Ref</option>`;
                    accountRefs.forEach((accountRef) => {
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

            // Fetch VAT Types
            const fetchVatTypes = async (accountRefDropdown, vatTypeDropdown) => {
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
                            Account_Ref_ID: selectedAccountRef,
                        }),
                    });

                    if (!response.ok) throw new Error('Failed to fetch VAT types');

                    const vatTypes = await response.json();
                    vatTypeDropdown.innerHTML =
                        `<option value="" selected disabled>Select VAT Type</option>`;
                    vatTypes.forEach((vatType) => {
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
        });

        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('entryContainer');
            const addEntryButton = document.getElementById('addEntry');
            const rowCountInput = document.getElementById('rowCount');

            // Add new rows dynamically
            addEntryButton.addEventListener('click', () => {
                const numberOfRows = parseInt(rowCountInput.value, 10);

                if (isNaN(numberOfRows) || numberOfRows <= 0) {
                    alert('Please enter a valid number of rows.');
                    return;
                }

                for (let i = 0; i < numberOfRows; i++) {
                    const newRowIndex = container.children.length; // Get the current number of rows
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'd-flex', 'flex-wrap', 'align-items-end', 'gx-2',
                        'entryRow');

                    newRow.innerHTML = `
                <div class="col-md-1">
                    <input type="date" class="form-control" name="transactions[${newRowIndex}][Transaction_Date]" required />
                </div>
                <div class="col-md-1">
                    <input type="text" class="form-control" name="transactions[${newRowIndex}][Ledger_Ref]" required />
                </div>
                <div class="col-md-1">
                    <select id="BankAccountDropdown_${newRowIndex}" name="transactions[${newRowIndex}][Bank_Account_ID]" class="form-select" required>
                        <option value="" selected disabled>Select Bank Account</option>
                        @foreach ($bankAccounts as $bankAccount)
                            <option value="{{ $bankAccount->Bank_Account_ID }}" data-bank-type="{{ $bankAccount->Bank_Type_ID }}">
                                {{ $bankAccount->Bank_Name }} ({{ $bankAccount->bankAccountType->Bank_Type ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <select id="PaidInOutDropdown_${newRowIndex}" name="transactions[${newRowIndex}][Paid_In_Out]" class="form-select" required>
                        <option value="" selected disabled>Select Paid In/Out</option>
                        <option value="1">Paid In</option>
                        <option value="2">Paid Out</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <select id="PaymentTypeDropdown_${newRowIndex}" name="transactions[${newRowIndex}][Payment_Type_ID]" class="form-select">
                        <option value="" selected disabled>Select Payment Type</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <select id="txtAccountRef_${newRowIndex}" name="transactions[${newRowIndex}][Account_Ref_ID]" class="form-select">
                        <option value="" selected disabled>Select Account Ref</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <select id="txtVatType_${newRowIndex}" name="transactions[${newRowIndex}][VAT_ID]" class="form-select">
                        <option value="" selected disabled>Select VAT Type</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <input type="text" class="form-control" name="transactions[${newRowIndex}][Cheque]" placeholder="Cheque" />
                </div>
                <div class="col-md-1">
                    <input type="number" class="form-control" name="transactions[${newRowIndex}][Amount]" required />
                </div>
                <div class="col-md-1">
                    <textarea class="form-control" name="transactions[${newRowIndex}][Description]" rows="1" placeholder="Transaction Description" required></textarea>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger removeEntry">Remove</button>
                </div>
            `;

                    container.appendChild(newRow);
                }
            });

            // Remove row functionality
            container.addEventListener('click', (event) => {
                if (event.target.classList.contains('removeEntry')) {
                    event.target.closest('.entryRow').remove();
                }
            });
        });

        // Remove row event listener
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeEntry')) {
                e.target.closest('.entryRow').remove();
            }
        });
    </script>
@endsection

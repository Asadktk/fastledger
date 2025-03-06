@extends('admin.layout.app')


@section('content')
    @extends('admin.partial.errors')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Office Bank Reconciliation Report</h4>
                        </div>
                        <div class="card-body">
                            <!-- Report Filters -->
                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <label for="bank_account_id">Bank Name:</label>
                                    <select name="bank_account_id" id="bank_account_id" class="form-control">
                                        <option value="">Select Bank</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank['Bank_Account_ID'] }}"
                                                {{ request('bank_account_id') == $bank['Bank_Account_ID'] ? 'selected' : '' }}>
                                                {{ $bank['Bank_Name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="from-date">From Date:</label>
                                    <input type="date" id="from-date" class="form-control w-100"
                                        value="{{ now()->format('Y-m-d') }}">
                                </div>
                                <div>
                                    <label for="to-date">To Date:</label>
                                    <input type="date" id="to-date" class="form-control w-100"
                                        value="{{ now()->format('Y-m-d') }}">
                                </div>

                                <div>
                                    <button class="btn btn-success" id="view-report-btn">View Report</button>
                                    <button class="btn btn-secondary">Print PDF Report</button>
                                    <button class="btn btn-info">Print Excel Report</button>
                                </div>
                            </div>

                            <!-- Reconciliation Table -->
                            <div class="table-responsive">
                                <div id="tabletop" class="mb-2 p-2 t-size-20px fs-4 bg-info text-white font-weight-bold">
                                    Office Bank Reconciliation Report</div>


                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <!-- Static Table Headers -->
                                        <tr style="height: 28px;">
                                            <th class="border border-dark p-2"><b>Lloyds TSB Sort Code</b></th>
                                            <th class="border border-dark p-2" width="15%"><b>Sort Code</b></th>
                                            <th class="border border-dark p-2" width="10%"><b>30-98-91</b></th>
                                            <th class="border border-dark p-2" width="10%">&nbsp;</th>
                                            <th class="border border-dark p-2" width="10%"><b>Account</b></th>
                                            <th class="border border-dark p-2" width="10%"><b>30324060</b></th>
                                        </tr>
                                        <tr>
                                            <th class="border border-dark p-2">&nbsp;</th>
                                            <th class="border border-dark p-2" width="15%"><b>Ref</b></th>
                                            <th class="border border-dark p-2" width="10%"><b>Ref</b></th>
                                            <th class="border border-dark p-2 text-center" width="10%"><b>&pound;</b>
                                            </th>
                                            <th class="border border-dark p-2 text-center" width="10%"><b>&pound;</b>
                                            </th>
                                            <th class="border border-dark p-2 text-center" width="10%"><b>&pound;</b>
                                            </th>
                                        </tr>

                                        <!-- Static Table Rows -->
                                        <tr>
                                            <td colspan="6" class="border border-dark p-2"><b>Balance as per Cash
                                                    Book</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="border border-dark p-2">
                                                <table class="table table-sm table-borderless">
                                                    <tr>
                                                        <td>Balance as on:</td>
                                                        <td>February 2025</td>
                                                        <td align="right">
                                                            <font style="color:#FF0000 ">*</font>Balance:
                                                        </td>
                                                        <td colspan="2" align="right">£5000.00</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    <tfoot id="grand-total">
                                    </tfoot>
                                    <!-- Receipts as per Ledger Book -->
                                    <tr>
                                        <td colspan="6" class="border border-dark p-2"><b>Receipts as per Ledger
                                                Book</b></td>
                                    </tr>
                                    <tbody id="bookledger-data">
                                        <!-- Dynamic Rows will be injected here -->
                                    </tbody>
                                    <tfoot id="bookledger-total">
                                    </tfoot>

                                    <!-- Disbursements as per Ledger Book -->
                                    <tr>
                                        <td colspan="6" class="border border-dark p-2"><b>Disbursements as per Ledger
                                                Book</b></td>
                                    </tr>
                                    <tbody id="disbursements-data">
                                        <!-- Dynamic Rows will be injected here -->
                                    </tbody>
                                    <tfoot id="disbursements-total">
                                    </tfoot>

                                    <!-- Receipts as per Sales Book -->
                                    <tr>
                                        <td colspan="6" class="border border-dark p-2"><b>Receipts as per Sales
                                                Book</b></td>
                                    </tr>
                                    <tbody id="salesBook-data">
                                        <!-- Dynamic Rows will be injected here -->
                                    </tbody>
                                    <tfoot id="salesBook-total">
                                    </tfoot>

                                    <!-- Payments and Refunds -->
                                    <tr>
                                        <td colspan="6" class="border border-dark p-2"><b>Payments and Refunds (Net) as
                                                per Purchase Day Book</b></td>
                                    </tr>
                                    <tbody id="payment-refund-data">
                                        <!-- Dynamic Rows will be injected here -->
                                    </tbody>
                                    <tfoot id="payment-refund-total">
                                    </tfoot>
                                    <!-- Receipts, Payments and Transfers for Capital, Drawings and Loan Account -->
                                    <tr>
                                        <td colspan="6" class="border border-dark p-2"><b>Receipts, Payments and
                                                Transfers as per Capital, Drawings and Loan Account</b></td>
                                    </tr>
                                    <tbody id="payment-transfer-data">
                                        <!-- Dynamic Rows will be injected here -->
                                    </tbody>
                                    <tfoot id="payment-transfer-total">
                                    </tfoot>

                                    <!-- Miscellaneous Account -->
                                    <tr>
                                        <td colspan="6" class="border border-dark p-2"><b>Receipts, Payments and
                                                Transfers as per Miscellaneous Account</b></td>
                                    </tr>
                                    <tbody id="miscellaneous-data">
                                        <!-- Dynamic Rows will be injected here -->
                                    </tbody>
                                    <tfoot id="miscellaneous-total">
                                    </tfoot>


                                    </tbody>

                                </table>

                            </div>

                            <div class="mt-4 row" id="bank-statement-section" style="display: none;">
                                <!-- Balance Reconciliation -->
                                <div class="mt-4 row">
                                    <div class="col-md-6">
                                        <h5>Balance as per Bank Statement</h5>
                                        <label for="">Balance is on:</label>
                                        <input type="date" id="balance-date" class="mb-2 form-control w-50">

                                        <div class="p-3 border">
                                            <h6>Less (Interest Paid)</h6>
                                            <button class="btn btn-danger btn-sm" id="delete-interest-row-btn">Delete
                                                Row</button>
                                            <button class="btn btn-primary btn-sm" id="add-interest-row-btn">Add to
                                                List</button>
                                            <table class="table mt-2" id="interest-table">
                                                <thead>
                                                    <tr>
                                                        <th>check</th>
                                                        <th>Ref #</th>
                                                        <th>*Amount (£)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- New rows will be added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <h5>Balance as per Bank Statement</h5>
                                        <label for="">*Balance:</label>
                                        {{-- <input type="number" class="mb-2 form-control w-50"> --}}
                                        <input type="number" id="input-balance" class="mb-2 form-control w-50">

                                        <div class="p-3 border">
                                            <h5>Less (Cheques in Transit)</h5>
                                            <button class="btn btn-danger btn-sm" id="delete-cheque-row-btn">Delete
                                                Row</button>
                                            <button class="btn btn-primary btn-sm" id="add-cheque-row-btn">Add to
                                                List</button>
                                            <table class="table mt-2" id="cheque-table">
                                                <thead>
                                                    <tr>
                                                        <th>Cheque</th>
                                                        <th>Ref #</th>
                                                        <th>*Amount (£)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- New rows will be added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Final Balance -->
                                <div class="mt-3 text-end">
                                    <h5>*Balance: <span class="fw-bold" id="balance-display"></span></h5>
                                    <h5>Difference: <span class="fw-bold" id="difference-display"></span></h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Ensure this function is defined at the top and can be called
            function updateBalanceAndDifference() {
                var totalClientBalance = parseFloat($('#bookledger-total td:nth-child(2) strong').text()) || 0;
                var enteredBalance = $('#input-balance').val().trim(); // Get input value

                // If no balance is entered, clear the difference field
                if (enteredBalance === "") {
                    $('#difference-display').text(""); // Empty the difference field
                    return;
                }

                enteredBalance = parseFloat(enteredBalance) || 0; // Convert to number if not empty

                // Get the total of interest and cheque amounts
                var totalInterest = 0;
                var totalCheque = 0;

                $('.interest-amount').each(function() {
                    var value = parseFloat($(this).val()) || 0;
                    totalInterest += value;
                });

                $('.cheque-amount').each(function() {
                    var value = parseFloat($(this).val()) || 0;
                    totalCheque += value;
                });

                // Calculate the new total balance (entered balance + total interest + total cheque)
                var newBalance = enteredBalance + totalInterest + totalCheque;

                // Update the balance display
                $('#balance-display').text(newBalance.toFixed(2));

                // Calculate the difference by subtracting the new balance from the total client balance
                var difference = totalClientBalance - newBalance;
                $('#difference-display').text(difference.toFixed(2));
            }

            // Attach event listener to input field (on input event)
            $('#input-balance').on('input', updateBalanceAndDifference);

            // Initially, keep the difference empty
            $('#difference-display').text("");
            updateBalanceAndDifference();

            // Other code to manage the report view and rows...
            $('#view-report-btn').on('click', function() {
                var bankAccountId = $('#bank_account_id').val();
                var fromDate = $('#from-date').val();
                var toDate = $('#to-date').val();

                var selectedDate = $('#from-date').val();
                $('#balance-date').val(selectedDate);

                if (!bankAccountId || !fromDate || !toDate) {
                    alert('Please select a bank and date range.');
                    return;
                }

                $.ajax({
                    url: '{{ route('Office.bank_reconciliation.data') }}',
                    method: 'GET',
                    data: {
                        bank_account_id: bankAccountId,
                        from_date: fromDate,
                        to_date: toDate
                    },
                    success: function(data) {
                        $('#disbursements-data, #bookledger-data, #payment-refund-data, #salesBook-data, #payment-transfer-data, #miscellaneous-data')
                            .empty();
                        $('#disbursements-total, #bookledger-total, #payment-refund-total, #salesBook-total, #payment-transfer-total, #miscellaneous-total, #grand-total')
                            .empty();

                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        function formatCurrency(amount) {
                            return '£' + parseFloat(amount).toFixed(2);
                        }

                        let grandTotal = 0; // Initialize Grand Total

                        function calculateTotal(data, sectionId) {
                            let total = 0;
                            data.forEach(function(transaction) {
                                let amount = parseFloat(transaction.Amount);
                                if (transaction.Paid_In_Out == 2) {
                                    if (amount < 0) {
                                        total -= amount;
                                    } else {
                                        total += -Math.abs(amount);
                                    }
                                } else {
                                    total += amount;
                                }
                            });

                            grandTotal += total; // Add section total to grand total

                            let formattedTotal = total < 0 ? `-£${Math.abs(total).toFixed(2)}` :
                                `£${total.toFixed(2)}`;

                            let totalRow = `
                        <tr>
                            <td colspan="3" class="border border-dark p-2 text-right"><b>Total:</b></td>
                            <td class="border border-dark p-2 text-right"><b>${formattedTotal}</b></td>
                            <td class="border border-dark p-2"></td>
                            <td class="border border-dark p-2"></td>
                        </tr>
                    `;

                            $('#' + sectionId + '-total').html(totalRow);
                        }

                        function appendDataToTable(data, sectionId) {
                            data.forEach(function(transaction) {
                                var amount = parseFloat(transaction.Amount);
                                var textColor = amount < 0 ? 'red' : 'black';

                                let row = `
                            <tr>
                                <td class="border border-dark p-2">${transaction.AccountRefDescription}</td>
                                <td class="border border-dark p-2">${transaction.Cheque}</td>
                                <td class="border border-dark p-2">${transaction.Ledger_Ref}</td>
                                <td class="border border-dark p-2 text-right" style="color:${textColor};">${formatCurrency(amount)}</td>
                                <td class="border border-dark p-2 text-right"></td>
                                <td class="border border-dark p-2"></td>
                            </tr>
                        `;
                                $('#' + sectionId + '-data').append(row);
                            });

                            calculateTotal(data, sectionId);
                        }

                        if (data.book_ledger && data.book_ledger.length > 0) {
                            appendDataToTable(data.book_ledger, 'bookledger');
                        }
                        if (data.disbursments && data.disbursments.length > 0) {
                            appendDataToTable(data.disbursments, 'disbursements');
                        }
                        if (data.sales_book && data.sales_book.length > 0) {
                            appendDataToTable(data.sales_book, 'salesBook');
                        }
                        if (data.payment_refund && data.payment_refund.length > 0) {
                            appendDataToTable(data.payment_refund, 'payment-refund');
                        }
                        if (data.payment_transfer && data.payment_transfer.length > 0) {
                            appendDataToTable(data.payment_transfer, 'payment-transfer');
                        }
                        if (data.miscellaneous && data.miscellaneous.length > 0) {
                            appendDataToTable(data.miscellaneous, 'miscellaneous');
                        }

                        // Display the Grand Total after processing all sections
                        let formattedGrandTotal = grandTotal < 0 ?
                            `-£${Math.abs(grandTotal).toFixed(2)}` :
                            `£${grandTotal.toFixed(2)}`;
                        let grandTotalRow = `
                    <tr>
                        <td colspan="3" class="border border-dark p-2 text-right"><b>Total Balance:</b></td>
                        <td colspan="3" class="border border-dark p-2 text-right"><b>${formattedGrandTotal}</b></td>
                    </tr>
                `;
                        $('#grand-total').html(grandTotalRow);

                        updateBalanceAndDifference(); // Update balance and difference
                        $('#bank-statement-section').fadeIn();
                    }
                });
            });

            // Add Interest Row
            $('#add-interest-row-btn').click(function() {
                var rowHtml = `
                <tr>
                    <td><input type="checkbox" class="interest-checkbox"></td>
                    <td><input type="text" class="form-control"></td>
                    <td><input type="number" class="form-control interest-amount"></td>
                </tr>
            `;
                $('#interest-table tbody').append(rowHtml);
                attachInterestInputHandler(); // Re-attach input handler when new row is added
            });

            // Delete Interest Row
            $('#delete-interest-row-btn').click(function() {
                var selectedRows = $('#interest-table tbody input[type="checkbox"]:checked');

                if (selectedRows.length === 0) {
                    alert('Please select a row to delete.');
                    return;
                }

                // Loop through each checked row and remove it
                selectedRows.each(function() {
                    $(this).closest('tr').remove();
                });

                updateBalanceAndDifference(); // Recalculate after deleting rows
            });

            // Add Cheque Row
            $('#add-cheque-row-btn').click(function() {
                var rowHtml = `
                    <tr>
                        <td><input type="checkbox" class="cheque-checkbox"></td>
                        <td><input type="text" class="form-control "></td>
                        <td><input type="number" class="form-control cheque-amount"></td>
                    </tr>
                `;
                $('#cheque-table tbody').append(rowHtml);
                attachChequeInputHandler(); // Re-attach input handler when new row is added
            });

            // Delete Cheque Row
            $('#delete-cheque-row-btn').click(function() {
                var selectedRows = $('#cheque-table tbody input[type="checkbox"]:checked');

                if (selectedRows.length === 0) {
                    alert('Please select a row to delete.');
                    return;
                }

                // Loop through each checked row and remove it
                selectedRows.each(function() {
                    $(this).closest('tr').remove();
                });

                updateBalanceAndDifference(); // Recalculate after deleting rows
            });

            // Function to attach input handlers to the added rows
            function attachInterestInputHandler() {
                $('.interest-amount').off('input').on('input', function() {
                    updateBalanceAndDifference();
                });
            }

            function attachChequeInputHandler() {
                $('.cheque-amount').off('input').on('input', function() {
                    updateBalanceAndDifference();
                });
            }
        });
    </script>
@endsection

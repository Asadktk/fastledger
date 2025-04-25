@extends('admin.layout.app')
<

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">Client Cash Book</h4>
                        </div>
                        <div class="card-body">
                            <!-- Filter Form -->
                            <form method="GET" id="filter-form">
                                <div class="mb-4 row">
                                    <div class="col-md-3">
                                        <label for="from_date">From Date:</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control"
                                            value="{{ request('from_date') }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="to_date">To Date:</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control"
                                            value="{{ request('to_date') }}">
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">

                                        <div class="flex-grow-1">
                                            <label for="bank_account_id">Bank Name:</label>
                                            <select name="bank_account_id" id="bank_account_id" class="form-control">
                                                @foreach ($banks as $key => $bank)
                                                    <option value="{{ $bank['Bank_Account_ID'] }}"
                                                        {{ request('bank_account_id') == $bank['Bank_Account_ID'] || ($key === 0 && !request('bank_account_id')) ? 'selected' : '' }}>
                                                        {{ $bank['Bank_Account_Name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="ms-2">
                                            <button type="submit" id="filter-btn" class="btn btnstyle">View Report</button>
                                        </div>
                                        <div class="ms-2">
                                            <button type="submit" id="print-pdf" class="btn downloadpdf"><i
                                                    class="fas fa-file-pdf"></i>Print PDF Report</button>
                                        </div>
                                        <div class="ms-2">
                                            <button type="submit" id="print-csv" class="btn downloadcsv"><i
                                                    class="fas fa-file-csv"></i> Excel Report</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Display Initial Balance -->
                            <div class="initial-balance">
                                <p><strong>Initial Balance:</strong> {{ number_format($initialBalance, 2) }}</p>
                            </div>

                            <!-- Render DataTable -->
                            <div class="table-responsive">
                                {{-- {!! $dataTable->table(['class' => 'table table-striped table-bordered text-nowrap table-sm'], true) !!} --}}
                                {!! $dataTable->table(['class' => 'table custom-datatable'], true) !!}

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
        $(document).ready(function() {
            const table = $('.dataTable').DataTable();
            const filterBtn = $('#filter-btn');
            const initialBalanceElem = $('.initial-balance p');
            const printPdf = $('#print-pdf');

            // Fetch initial balance on page load (if any filters are present in the URL)
            const urlParams = new URLSearchParams(window.location.search);
            const fromDate = urlParams.get('from_date');
            const toDate = urlParams.get('to_date');
            const bankAccountId = urlParams.get('bank_account_id');

            if (fromDate || toDate || bankAccountId) {
                $.ajax({
                    url: '{{ route('client.cashbook.get_initial_balance') }}', // Use the correct route for fetching initial balance
                    method: 'GET',
                    data: {
                        from_date: fromDate,
                        to_date: toDate,
                        bank_account_id: bankAccountId
                    },
                    success: function(data) {
                        // Update the initial balance display
                        initialBalanceElem.html(
                            `<strong>Initial Balance:</strong> ${data.initial_balance}`);
                    }
                });
            }



            // Handle filter form submission and update both the table and initial balance
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();

                const fromDate = $('#from_date').val();
                const toDate = $('#to_date').val();
                const bankAccountId = $('#bank_account_id').val();
                let isValid = true;

                $('.error-message').remove();

                // Validate from_date
                if (!fromDate) {
                    $('#from_date').after(
                        '<small class="text-danger error-message">From date is required.</small>');
                    isValid = false;
                }

                // Validate to_date
                if (!toDate) {
                    $('#to_date').after(
                        '<small class="text-danger error-message">To date is required.</small>');
                    isValid = false;
                }

                // Stop submission if validation fails
                if (!isValid) {
                    return;
                }
                // Disable the filter button to prevent duplicate clicks
                filterBtn.prop('disabled', true);

                const params = new URLSearchParams({
                    from_date: fromDate || '',
                    to_date: toDate || '',
                    bank_account_id: bankAccountId || ''
                });

                // Reload the DataTable with the new parameters
                table.ajax.url(`?${params.toString()}`).load(function() {
                    // Fetch and update the initial balance after the table reload
                    $.ajax({
                        url: '{{ route('client.cashbook.get_initial_balance') }}',
                        method: 'GET',
                        data: params.toString(),
                        success: function(data) {
                            initialBalanceElem.html(
                                `<strong>Initial Balance:</strong> ${data.initial_balance}`
                            );
                        }
                    });

                    // Enable the filter button after reload
                    filterBtn.prop('disabled', false);
                });
            });

            $('#print-pdf').on('click', function(e) {
                e.preventDefault();

                const fromDate = $('#from_date').val();
                const toDate = $('#to_date').val();
                const bankAccountId = $('#bank_account_id').val();
                let isValid = true;

                $('.error-message').remove();

                // Validate from_date
                if (!fromDate) {
                    $('#from_date').after(
                        '<small class="text-danger error-message">From date is required.</small>');
                    isValid = false;
                }

                // Validate to_date
                if (!toDate) {
                    $('#to_date').after(
                        '<small class="text-danger error-message">To date is required.</small>');
                    isValid = false;
                }

                // Stop submission if validation fails
                if (!isValid) {
                    return;
                }

                // Construct the URL with query parameters
                const params = new URLSearchParams({
                    from_date: fromDate || '',
                    to_date: toDate || '',
                    bank_account_id: bankAccountId || ''
                });

                console.log(params);

                // Open the generated PDF in a new tab
                window.open(`{{ route('client.cashbook.export_pdf') }}?${params.toString()}`, '_blank');
            });
        });
    </script>
@endsection

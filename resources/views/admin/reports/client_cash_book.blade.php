@extends('admin.layout.app')

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
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="from_date">From Date:</label>
                                    <input type="date" id="from_date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="to_date">To Date:</label>
                                    <input type="date" id="to_date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="flex-grow-1">
                                        <label for="bank_name">Bank Name:</label>
                                        <select name="bank_name" id="bank_name" class="form-control">
                                            <option value="">Select Bank</option>
                                            @foreach($banks as $bank)
                                                <option value="{{ $bank['Bank_Account_Name'] }}" 
                                                        {{ request('bank_name') == $bank['Bank_Account_Name'] ? 'selected' : '' }}>
                                                    {{ $bank['Bank_Account_Name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="ms-2">
                                        <button type="submit" id="filter-btn" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Render DataTable -->
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

@push('scripts')
    {!! $dataTable->scripts() !!}

    <script>
        $(document).ready(function () {
            const table = $('.dataTable').DataTable();
            const filterBtn = $('#filter-btn');

            $('#filter-form').on('submit', function (e) {
                e.preventDefault();

                const fromDate = $('#from_date').val();
                const toDate = $('#to_date').val();
                const bankName = $('#bank_name').val();

                filterBtn.prop('disabled', true);

                const params = new URLSearchParams({
                    from_date: fromDate || '',
                    to_date: toDate || '',
                    bank_name: bankName || ''
                });

                table.ajax.url(`?${params.toString()}`).load(function () {
                    filterBtn.prop('disabled', false);
                });
            });
        });
    </script>
@endpush

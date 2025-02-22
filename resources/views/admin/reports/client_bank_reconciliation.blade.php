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
                        <h4 class="card-title">Client Bank Reconciliation Report</h4>
                        <div>
                            <a href="{{ route('transactions.create') }}" class="btn btn-primary rounded-pill btn-wave">New</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Report Filters -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <input type="date" id="filter-date" class="form-control w-25" value="{{ now()->format('Y-m-d') }}">

                            <div>
                                <button class="btn btn-success" id="view-report-btn">View Report</button>
                                <button class="btn btn-secondary">Print PDF Report</button>
                                <button class="btn btn-info">Print Excel Report</button>
                            </div>
                        </div>

                        <!-- Reconciliation Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Ledger Ref#</th>
                                        <th>Client A/C (£)</th>
                                        <th>Office A/C (£)</th>
                                    </tr>
                                </thead>
                                <tbody id="reconciliation-table-body">
                                    <!-- Static Data Added Here -->
                                    <tr>
                                        <td>Client 1</td>
                                        <td>REF123</td>
                                        <td>£500.00</td>
                                        <td>£480.00</td>
                                    </tr>
                                    <tr>
                                        <td>Client 2</td>
                                        <td>REF124</td>
                                        <td>£700.00</td>
                                        <td>£690.00</td>
                                    </tr>
                                    <tr>
                                        <td>Client 3</td>
                                        <td>REF125</td>
                                        <td>£1,200.00</td>
                                        <td>£1,180.00</td>
                                    </tr>
                                    <tr>
                                        <td>Client 4</td>
                                        <td>REF126</td>
                                        <td>£1,000.00</td>
                                        <td>£980.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Balance Reconciliation -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Balance as per Bank Statement</h5>
                                <label for="">Balance is on:</label>
                                <input type="date" class="form-control w-50 mb-2">
                                <div class="border p-3">
                                    <h6>Less (Interest Paid)</h6>
                                    <button class="btn btn-danger btn-sm">Delete Row</button>
                                    <button class="btn btn-primary btn-sm">Add to List</button>
                                    <table class="table mt-2">
                                        <thead>
                                            <tr>
                                                <th>Ref #</th>
                                                <th>*Amount (£)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" class="form-control"></td>
                                                <td><input type="text" class="form-control"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Balance as per Bank Statement</h5>
                                <label for="">*Balance:</label>
                                <input type="number" class="form-control w-50 mb-2">
                                <div class="border p-3">
                                    <h5>Less (Cheques in Transit)</h5>
                                    <button class="btn btn-danger btn-sm">Delete Row</button>
                                    <button class="btn btn-primary btn-sm">Add to List</button>
                                    <table class="table mt-2">
                                        <thead>
                                            <tr>
                                                <th>Cheque</th>
                                                <th>Ref #</th>
                                                <th>*Amount (£)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="checkbox"></td>
                                                <td><input type="text" class="form-control"></td>
                                                <td><input type="text" class="form-control"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Final Balance -->
                        <div class="text-end mt-3">
                            <h5>*Balance: <span class="fw-bold">43.00</span></h5>
                            <h5>Difference: <span class="fw-bold">7,899.00</span></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for displaying the date -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportModalLabel">Bank Reconciliation Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Selected Date:</strong> <span id="modal-date"></span></p>
                <p>The report for the selected date will be shown here.</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Ledger Ref#</th>
                            <th>Client A/C (£)</th>
                            <th>Office A/C (£)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example data to show in the modal -->
                        <tr>
                            <td>Client 1</td>
                            <td>REF123</td>
                            <td>£500.00</td>
                            <td>£480.00</td>
                        </tr>
                        <tr>
                            <td>Client 2</td>
                            <td>REF124</td>
                            <td>£700.00</td>
                            <td>£690.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Download Report</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

{{-- <script>
   document.getElementById('view-report-btn').addEventListener('click', function() {
    alert('were');
    const selectedDate = document.getElementById('filter-date').value;
    console.log("Selected date: ", selectedDate);  // Add this line for debugging
    if (selectedDate) {
        document.getElementById('modal-date').textContent = selectedDate;
        var myModal = new bootstrap.Modal(document.getElementById('reportModal'));
        myModal.show();
    } else {
        alert('Please select a date.');
    }
});
</script> --}}
@endsection

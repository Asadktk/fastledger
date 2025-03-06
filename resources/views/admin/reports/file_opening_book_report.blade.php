@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">File Opening Book Report</h4>
                        </div>
                        <div class="card-body">
                            <!-- Filter Form -->
                            <form method="GET" id="filter-form">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="from_date">From Date:</label>
                                        <input type="date" id="from_date" name="from_date" class="form-control datepicker"
                                            placeholder="dd/mm/yyyy">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="to_date">To Date:</label>
                                        <input type="date" id="to_date" name="to_date" class="form-control datepicker"
                                            placeholder="dd/mm/yyyy">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <div class="ms-2">
                                            <button type="button" id="filter-btn" class="btn btn-primary">View Report</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- Table Section (Initially Hidden) -->
                            <div id="table-section" class="mt-4" style="display: none;">
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <h5 style="margin-top: 10px;margin-right: 23px;">
                                        File Opening Book Report | From Date: <span id="display-from-date"></span> | To
                                        Date: <span id="display-to-date"></span>
                                    </h5>

                                    <button id="download-pdf" class="btn btn-danger me-2">Download PDF</button>
                                    <button id="download-csv" class="btn btn-success">Download CSV</button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>S/No</th>
                                                <th>File Open Date</th>
                                                <th>Ledger Ref</th>
                                                <th>Matter</th>
                                                <th>Client Name</th>
                                                <th>Property/Matter Address</th>
                                                <th>Fee Earner</th>
                                                <th>Status</th>
                                                <th>Close Date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <!-- Data will be appended here via AJAX -->
                                        </tbody>
                                    </table>
                                    {{-- <div id="pagination-links" class="mt-3">
                                        <!-- Pagination links will be appended here -->
                                    </div> --}}
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
        $(document).ready(function () {


            $('#filter-btn').click(function () {
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();

                if (fromDate && toDate) {
                    $.ajax({
                        url: "{{ route('file.report.data') }}",
                        type: "GET",
                        data: { from_date: fromDate, to_date: toDate },
                        success: function (response) {
                            $('#table-body').empty();
                            $('#pagination-links').empty();

                            if (response.data.length > 0) {
                                $.each(response.data, function (index, record) {
                                    let status_l = "";

                                    switch (record.Status) {
                                        case 'L':
                                            status_l = "Live";
                                            break;
                                        case 'C':
                                            status_l = "Close";
                                            break;
                                        case 'A':
                                            status_l = "Abortive";
                                            break;
                                        case 'I':
                                            status_l = "Close Abortive";
                                            break;
                                        default:
                                            status_l = "Unknown";
                                            break;
                                    }

                                    $('#table-body').append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${(formatDates(record.File_Date))}</td>
                                        <td>
                                            <a class='text-primary' href="/file/update/${record.File_ID || ''}">
                                                ${record.Ledger_Ref || 'N/A'}
                                            </a>
                                        </td>

                                        <td>${record.Matter}</td>
                                        <td>${record.First_Name} ${record.Last_Name}</td>
                                        <td>${record.Address1} ${record.Address2} ${record.Town} ${record.Post_Code}</td>
                                        <td>${record.Fee_Earner}</td>
                                        <td>${status_l}</td>
                                        <td>${record.File_Date}</td>
                                    </tr>
                                `);
                                });

                                $('#pagination-links').html(response.pagination);
                                $('#table-section').show();
                                $('#display-from-date').text(formatDate($('#from_date').val()));
                                $('#display-to-date').text(formatDate($('#to_date').val()));

                                function formatDate(date) {
                                    if (!date) return ''; // Handle empty date
                                    let parts = date.split('-'); // Split YYYY-MM-DD
                                    return `${parts[2]}/${parts[1]}/${parts[0]}`; // Convert to DD/MM/YYYY
                                }
                                function formatDates(dateString) {
                    if (!dateString) return 'N/A';  

                    let dateObj = new Date(dateString);
                    let day = String(dateObj.getDate()).padStart(2, '0');
                    let month = String(dateObj.getMonth() + 1).padStart(2, '0');  
                    let year = dateObj.getFullYear();

                    return `${day}/${month}/${year}`;
                }

                            } else {
                                $('#table-body').html('<tr><td colspan="11" class="text-center">No records found</td></tr>');
                                $('#table-section').show();
                            }
                        },
                        error: function () {
                            alert('Something went wrong. Please try again.');
                        }
                    });
                } else {
                    alert('Please select both From Date and To Date.');
                }
            });

            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();

                fetchRecords(page, fromDate, toDate);
            });

            function fetchRecords(page, fromDate, toDate) {
                $.ajax({
                    url: "{{ route('file.report.data') }}?page=" + page + "&from_date=" + fromDate + "&to_date=" + toDate,
                    type: "GET",
                    success: function (response) {
                        $('#table-body').empty();
                        $('#pagination-links').empty();

                        if (response.data.length > 0) {
                            $.each(response.data, function (index, record) {
                                let status_l = "";

                                switch (record.Status) {
                                    case 'L':
                                        status_l = "Live";
                                        break;
                                    case 'C':
                                        status_l = "Close";
                                        break;
                                    case 'A':
                                        status_l = "Abortive";
                                        break;
                                    case 'I':
                                        status_l = "Close Abortive";
                                        break;
                                    default:
                                        status_l = "Unknown";
                                        break;
                                }

                                $('#table-body').append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${record.File_Date}</td>
                                    <td><a href="/file/update/${record.File_ID}">${record.Ledger_Ref}</a></td>
                                    <td>${record.Matter}</td>
                                    <td>${record.First_Name} ${record.Last_Name}</td>
                                    <td>${record.Address1} ${record.Address2} ${record.Town} ${record.Post_Code}</td>
                                    <td>${record.Fee_Earner}</td>
                                    <td>${status_l}</td>
                                    <td>${record.File_Date}</td>
                                </tr>
                            `);
                            });

                            $('#pagination-links').html(response.pagination);
                            $('#table-section').show();
                            // Update displayed dates
                            $('#display-from-date').text(formatDate($('#from_date').val()));
                            $('#display-to-date').text(formatDate($('#to_date').val()));

                            function formatDate(date) {
                                if (!date) return '';  
                                let parts = date.split('-');  
                                return `${parts[2]}/${parts[1]}/${parts[0]}`;  
                            }


                        } else {
                            $('#table-body').html('<tr><td colspan="11" class="text-center">No records found</td></tr>');
                            $('#table-section').show();
                        }
                    }
                });
            }
        });

        $(document).ready(function () {
            $('#download-pdf').click(function () {
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();

                if (!fromDate || !toDate) {
                    alert('Please select both From Date and To Date before downloading.');
                    return;
                }

                window.location.href = "{{ route('file.report.pdf') }}?from_date=" + fromDate + "&to_date=" + toDate;
            });

            $('#download-csv').click(function () {
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();

                if (!fromDate || !toDate) {
                    alert('Please select both From Date and To Date before downloading.');
                    return;
                }

                window.location.href = "{{ route('file.report.csv') }}?from_date=" + fromDate + "&to_date=" + toDate;
            });
        });

        $(document).ready(function() {
    $('#file-table').DataTable({
        "pagingType": "simple_numbers", // Use smaller pagination
        "lengthMenu": [10, 25, 50, 100], // Control page size
        "language": {
            "paginate": {
                "previous": "<", // Use smaller text
                "next": ">"
            }
        }
    });
});

    </script>
    
@endsection
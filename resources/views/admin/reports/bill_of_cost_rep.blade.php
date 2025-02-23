@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">Bill Of Cost Report</h4>
                        </div>
                        <div class="card-body">
                            <div class=" col-lg-12 ">

                                <!-- Filter Form -->
                                <form method="GET" id="filter-form">
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label for="ledger_ref">Ledger Ref:</label>
                                            <input type="text" id="ledger_ref" name="ledger_ref" class="form-control  "
                                                placeholder="">
                                        </div>

                                        <div class="col-md-4 d-flex align-items-end">
                                            <div class="ms-2">
                                                <button type="button" id="filter-btn" class="btn btn-primary">View
                                                    Report</button>
                                            </div>
                                        </div>
                                        <div class="col-md-4  d-flex justify-content-end align-items-center  mt-3">

                                            <button id="download-pdf" class="btn btn-danger me-2">Download PDF</button>
                                            <button id="download-csv" class="btn btn-success">Download CSV</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Table Section (Initially Hidden) -->
                            <div id="table-section" class="mt-4">
                                <div class="table-responsive">

                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Client Name:</td>
                                                <td colspan="5">Tawqir Asghar</td>
                                            </tr>
                                            <tr>
                                                <td>Client Address:</td>
                                                <td colspan="5">123 shaggy calf lane </td>
                                            </tr>
                                            <tr>
                                                <td>Matter</td>
                                                <td>IMM</td>
                                                <td>Bill Date:</td>
                                                <td>15-02-2025</td>
                                                <td colspan="2"></td>

                                            </tr>
                                            <tr>
                                                <td>Ledger Ref</td>
                                                <td><a class="ledger-link"
                                                        onclick="javscript:openClientLedger(6500,'666666');"
                                                        href="javascript:void(0);">666666</a></td>
                                                <td>Bill Ref:</td>
                                                <td>645,test</td>
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"><strong>Particulars</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">On the above information, we expect our fees and other
                                                    charges to be:</td>
                                                <td align="center"><strong>(£)</strong></td>
                                                <td align="center"><strong>(£)</strong></td>
                                                <td align="center"><strong>(£)</strong></td>
                                                <td align="center"><strong>(£)</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">Our Costs</td>
                                                <td align="center"><strong>Net</strong></td>
                                                <td align="center"><strong>VAT</strong></td>
                                                <td align="center"><strong>Total</strong></td>
                                                <td align="center"><strong></strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><a class="ledger-link"
                                                        onclick="javascript: EditProject(196688);"
                                                        href="javascript:void(0);">4</a></td>
                                                <td align="center">45.00</td>
                                                <td align="center">0.00</td>
                                                <td align="center">45.00</td>
                                                <td></td>
                                            </tr>
                                           

                                                <td align="right"><strong>Our Costs total</strong></td>
                                                <td colspan="4">&nbsp;</td>

                                                <td align="right">1,752.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"><strong>Disbursments</strong></td>
                                            </tr>
                                            <tr>

                                                <td colspan="1" align="right"><strong>Disbursments Total</strong></td>
                                                <td colspan="4">&nbsp;</td>

                                                <td align="right" style="border:1px">0.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>

                                                <td align="right"><strong>Bill Total</strong></td>

                                                <td align="right">1,752.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>

                                                <td align="right"><strong>Payment Received</strong></td>

                                                <td align="right">1,752.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>

                                                <td align="right"><strong>Outstanding Balance</strong></td>

                                                <td align="right">0.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <ul class="list-unstyled">
                                                        <li>
                                                        Payments can be made by cheque payable to Z Dummy LLP or by Bank
                                                        transfer to the following account.
                                                        </li>
                                                        <li>
                                                        Bank: Barclays   
                                                        </li>
                                                        <li>
                                                        Account No: 98765432
                                                        </li>
                                                        <li>
                                                        Sort code: 456789
                                                        </li>
                                                        <li>
                                                        If you are not happy or have any query, please do not hesitate to
                                                        contact Our Office on 02020207812 to resolve the issue.
                                                        </li>


                                                    </ul>
                                                    
                                                </td>
                                            </tr>
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

@push('scripts')
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

        $(document).ready(function () {
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

@endpush
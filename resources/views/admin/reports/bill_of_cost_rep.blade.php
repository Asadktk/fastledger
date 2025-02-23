@extends('admin.layout.app')
<style>
    .desc_width{
        width: 22% !important;
    }
    .ledger_dorpdown{
        width: 31% !important;
    }
</style>
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
                            <div class="col-lg-12">
                                <form method="GET" id="filter-form1">
                                    <div class="row mb-4">
                                        <!-- Left Section: Ledger Ref and View Report Button -->
                                        <div class="col-md-4">
                                            <label for="ledger_ref">Ledger Ref:</label>
                                            <input type="text" id="ledger_ref" name="ledger_ref" class="form-control" placeholder="Ledger Ref">
                                            <input type="hidden" id="File_id" name="File_id" class="form-control">
                                            <div id="results-dropdown" class="dropdown-menu ledger_dorpdown" aria-labelledby="ledger_ref"></div>
                                        </div>
                            
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button type="button" id="filter-btn" class="btn btn-primary">View Report</button>
                                        </div>
                            
                                        <!-- Right Section: Download Buttons -->
                                        <div style="display: none !important" class="col-md-4 d-flex justify-content-end align-items-end doc_buttons">
                                            <button id="download-pdf" class="btn btn-danger me-2">Download PDF</button>
                                            <button id="download-csv" class="btn btn-success">Download CSV</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Table Section (Initially Hidden) -->
                            <div id="table-section" class="mt-4" style="display: none" >
                                <div class="table-responsive">

                                    <table class="table table-bordered table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Client Name:</td>
                                                <td class="client_name" colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <td>Client Address:</td>
                                                <td class="client_addres" colspan="5"></td>
                                            </tr>
                                            <tr>
                                                <td>Matter</td>
                                                <td class="matter_name"></td>
                                                <td>Bill Date:</td>
                                                <td class="bill_date"></td>
                                                <td colspan="2"></td>

                                            </tr>
                                            <tr>
                                                <td>Ledger Ref</td>
                                                <td class="ledger_refs"><a class="ledger-link"
                                                        onclick="javscript:openClientLedger(6500,'666666');"
                                                        href="javascript:void(0);"></a></td>
                                                <td>Bill Ref:</td>
                                                <td class="bill_ref" ></td>
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
                                                <td class="description" colspan="2"><a class="ledger-link"
                                                        onclick="javascript: EditProject(196688);"
                                                        href="javascript:void(0);"></a></td>
                                                <td class="net_amout" align="center"> </td>
                                                <td class="vat" align="center"> </td>
                                                <td class="total" align="center"> </td>
                                                <td></td>
                                            </tr>
                                           

                                                <td align="right"><strong>Our Costs total</strong></td>
                                                <td colspan="4">&nbsp;</td>

                                                <td class="cost_total" align="right">1,752.00</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6"><strong>Disbursments</strong></td>
                                            </tr>
                                            <tr>

                                                <td colspan="1" align="right"><strong>Disbursments Total</strong></td>
                                                <td colspan="4">&nbsp;</td>

                                                <td class="disbursments_tota;" align="right" style="border:1px"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>

                                                <td align="right"><strong>Bill Total</strong></td>

                                                <td class="bill_total" align="right"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>

                                                <td align="right"><strong>Payment Received</strong></td>

                                                <td class="payment_received" align="right"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">&nbsp;</td>

                                                <td align="right"><strong>Outstanding Balance</strong></td>

                                                <td class="outstanding_balance" align="right"></td>
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
        document.getElementById('ledger_ref').addEventListener('input', function() {
    const query = this.value;

    if (query.length < 2) {
        document.getElementById('results-dropdown').innerHTML = '';
        document.getElementById('results-dropdown').classList.remove('show');
        return;
    }

    fetch(`/search-ledger?query=${query}`)
        .then(response => response.json())
        .then(data => {
            const dropdown = document.getElementById('results-dropdown');
            dropdown.innerHTML = '';

            if (data.length > 0) {
                data.forEach(item => {
                    const option = document.createElement('a');
                    option.classList.add('dropdown-item');
                    option.href = '#';
                    option.textContent = item.Ledger_Ref;  
                    option.addEventListener('click', function() {
                        document.getElementById('ledger_ref').value = item.Ledger_Ref;
                        dropdown.classList.remove('show');
                    });
                    option.addEventListener('click', function () {
                    document.getElementById('ledger_ref').value = item.Ledger_Ref;

                    document.getElementById('File_id').value = item.file_id;

                    dropdown.classList.remove('show');
                });
                    dropdown.appendChild(option);
                });
                dropdown.classList.add('show');
            } else {
                dropdown.classList.remove('show');
            }
        })
        .catch(error => console.error('Error:', error));
});
$(document).ready(function () {
    $('#filter-btn').click(function () {
        var File_id = $('#File_id').val();
        var ledger_ref = $('#ledger_ref').val();

        if (File_id && ledger_ref) {
            $.ajax({
                url: "{{ route('bill.of.cost.data') }}",
                type: "GET",
                data: { File_id: File_id, ledger_ref: ledger_ref },
                success: function (response) {
                    $('#table-body').empty(); // Clear table
                    $('#Client_Ref').text(response.Client_Ref);
                     
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                }
            });
        } else {
            alert('Please ensure both File ID and Ledger Ref are selected.');
        }
    });
});
     console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                }
            });
        } else {
            alert('Please ensure both File ID and Ledger Ref are selected.');
        }
    });
});
     console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                }
            });
        } else {
            alert('Please ensure both File ID and Ledger Ref are selected.');
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
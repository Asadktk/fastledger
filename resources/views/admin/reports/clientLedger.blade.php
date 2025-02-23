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
                            <h4 class="card-title">Client Ledger Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">
                                <form method="GET" id="filter-form">
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
                             
                            <div id="table-section" class="mt-4" style="display: none" >
                                <div class="d-flex justify-content-center align-items-center mb-3">
                                    <h6 style="margin-top: 10px;margin-right: 23px;">
                                      <span id="Client_Ref"></span> | Client Name: <span id="Client_name"></span> | Ledger Ref: <span id="ledger_Ref"></span> | Address: <span id="Address"></span>   
                                    </h6>
                                    
                                  
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th colspan="3"></th>
                                                <th colspan="3" class="account-header">Office Account</th>
                                                <th colspan="3" class="account-header">Client Account</th>
                                            </tr>
                                            <tr>
                                                <th class="date-column">DATE</th>
                                                <th class="description-column desc_width">DESCRIPTION</th>
                                                <th class="ref-column">Ref</th>
                                                <th class="amount-column">Debit</th>
                                                <th class="amount-column">Credit</th>
                                                <th class="amount-column">BALANCE</th>
                                                <th class="amount-column">Debit</th>
                                                <th class="amount-column">Credit</th>
                                                <th class="amount-column">BALANCE</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body"> <!-- Ensure the id is correct -->
                                            <!-- Rows will be appended here -->
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
                url: "{{ route('client.ledger.data') }}",
                type: "GET",
                data: { File_id: File_id, ledger_ref: ledger_ref },
                success: function (response) {
                    $('#table-body').empty(); // Clear table
                    $('#Client_Ref').text(response.Client_Ref);
                    $('#Client_name').text(response.file_data ? response.file_data.First_Name + ' ' + response.file_data.Last_Name : 'N/A');
                    $('#Address').text(response.file_data ? response.file_data.Address1 + ' ' + response.file_data.Address2 + ' ' + response.file_data.Town : 'N/A');
                    $('#ledger_Ref').text(response.file_data ? response.file_data.Ledger_Ref : 'N/A');
                    
                    if (response.transactions.length > 0) {
                        $.each(response.transactions, function (index, record) {
                            var row = `<tr>
                                <td class="date-column">${record.TransactionDate}</td>
                                <td class="description-column">${record.Description}</td>
                                <td class="ref-column">${record.Cheque}</td>
                                <td class="amount-column">${record.Office_Debit}</td>
                                <td class="amount-column">${record.Office_Credit}</td>
                                <td class="amount-column">${record.Office_Balance}</td>
                                <td class="amount-column">${record.Client_Debit}</td>
                                <td class="amount-column">${record.Client_Credit}</td>
                                <td class="amount-column">${record.Client_Balance}</td>
                            </tr>`;

                            $('#table-body').append(row);
                        });

                        $('#table-section').show();
                        $('.doc_buttons').show();
                    } else {
                        $('#table-body').html('<tr><td colspan="9" class="text-center">No records found</td></tr>');
                        $('#table-section').show();
                    }
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

    </script>
    
@endpush
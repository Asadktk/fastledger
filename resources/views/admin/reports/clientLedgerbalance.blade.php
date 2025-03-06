@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <h4 class="card-title ">14 Days Passed Check</h4>
                            <div class="d-flex justify-content-end">
                                <button id="download-pdf" class="btn btn-danger me-2">Download PDF</button>
                               </div>
                        </div>
                        <div class="card-body">
                                

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Ledger Status</th>
                                                <th>Last Transaction Date</th>
                                                <th>Client A/C Balance</th>
                                                <th>Ledger Ref</th>
                                                <th>Matter</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Fee Earner</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($fileSummaries as $clientsdata)
                                            <tr>
                                                <td>{{ $clientsdata['Days_Since_Last_Transaction'] }}</td>
                                                <td>{{ $clientsdata['Last_Transaction_Date'] }}</td>
                                                <td>{{ $clientsdata['Total_Balance'] }}</td>
                                                <td>{{ $clientsdata['Ledger_Ref'] }}</td>
                                                <td>{{ $clientsdata['Matter'] }}</td>
                                                <td>{{ $clientsdata['First_Name'] }} {{ $clientsdata['Last_Name'] }}</td>
                                                <td>{{ $clientsdata['Address1'] }} {{ $clientsdata['Address2'] }}</td>
                                                <td>{{ $clientsdata['Fee_Earner'] }}</td>
                                            </tr>
                                            @endforeach
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
@endsection

@section('scripts')

 
@endsection
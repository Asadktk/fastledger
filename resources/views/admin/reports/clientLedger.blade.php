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
                                        <tbody >
                                           
                                            
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                         
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

@push('scripts')
 
@endpush
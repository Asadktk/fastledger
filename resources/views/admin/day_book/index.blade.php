@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                       
                            <div class="card-header d-flex justify-content-between ">
                                <h4 class="card-title">Transaction Listing</h4>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('transactions.create') }}" class="btn addbutton  btn-wave" role="button"> <i class="fas fa-plus"></i>Add New</a>
                                    <button id="downloadPDF" class="btn downloadpdf "><i class="fas fa-file-pdf"></i>Download PDF</button>
                                    <button id="download-csv" class="btn downloadcsv">  <i class="fas fa-file-csv"></i> Download CSV</button>
                                </div>
                          
                        </div>
                        <div class="card-body">
                            <!-- Render DataTable -->
                            <div class="table-responsive">
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

        $(document).ready(function () {
            $('#downloadPDF').click(function () {
                $.ajax({
                    url: "{{ route('transactions.daybook.download.pdf') }}", // Updated route
                    type: "GET",
                    xhrFields: { responseType: 'blob' },
                    success: function (data) {
                        var blob = new Blob([data], { type: 'application/pdf' });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "daybook_report.pdf";
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    },
                    error: function () {
                        alert('Failed to download PDF');
                    }
                });
            });
        });
        
         </script>
@endsection

@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">File Export Datatable</h4>
                            <div>
                                <a href="{{ route('files.create') }}" class="btn btn-primary rounded-pill btn-wave"
                                    role="button">Primary link</a>
                            </div>
                        </div>
                        <div class="card-body">
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
    {{-- <script type="text/javascript">
        $(window).on('load', function() {

            if (window.LaravelDataTables && window.LaravelDataTables["award-table"]) {
                var table = window.LaravelDataTables["award-table"];
                table.settings()[0].oFeatures = {
                    ...table.settings()[0].oFeatures,
                    bPaginate: true,
                    bInfo: true,
                    // bSort: true,
                    bAutoWidth: true,
                    bProcessing: true,
                    bServerSide: true
                };


            } else {
                console.error("DataTable instance not found.");
            }


        });
    </script> --}}
@endpush

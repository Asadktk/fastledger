@extends('admin.layout.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">File Export Datatable</h4>
                            <a href="{{ route('clients.create') }}" class="btn btn-primary rounded-pill btn-wave" role="button">
                                Add New
                            </a>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <!-- Render DataTable here -->
                                {!! $dataTable->table(['class' => 'table table-striped table-bordered text-nowrap table-sm'], true) !!}
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
@endsection

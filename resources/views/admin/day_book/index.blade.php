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
                                <a href="{{ route('transactions.create') }}" class="btn btn-primary rounded-pill btn-wave"
                                    role="button">New</a>
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

@section('scripts')
    {!! $dataTable->scripts() !!}
@endsection

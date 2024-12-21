@extends('admin.layout.app')
@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Start::page-header -->
            <div class="d-flex align-items-center justify-content-between my-4 page-header-breadcrumb flex-wrap gap-2">
                <div>
                    @auth
                        <p>Welcome, {{ auth()->user()->Full_Name }}</p>
                    @else
                        {{-- {{ dd(auth()->user()) }} --}}
                        <p>Welcome, Guest!</p>
                    @endauth
                    <p class="fs-13 text-muted mb-0">Let's make today a productive one!</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text bg-primary-transparent text-primary"> <i
                                    class="ri-calendar-line"></i> </div>
                            <input type="text" class="form-control breadcrumb-input" id="daterange"
                                placeholder="Search By Date Range">
                        </div>
                    </div>
                    <div class="btn-list">
                        <button class="btn btn-secondary-light btn-wave">
                            <i class="ri-upload-cloud-line align-middle me-1 lh-1"></i> Export Report
                        </button>
                        <button class="btn btn-icon btn-success btn-wave me-0">
                            <i class="ri-filter-3-line"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start:: row-1 -->
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div>
                                        <span class="d-block mb-2">Sales</span>
                                        <h5 class="mb-4 fs-4">32,981</h5>
                                    </div>
                                    <span class="text-success me-2 fw-medium d-inline-block"><i
                                            class="ti ti-trending-up fs-5 align-middle me-1 d-inline-block"></i>0.45%</span><span
                                        class="text-muted">Since last month</span>
                                </div>
                                <div>
                                    <div class="main-card-icon primary">
                                        <div
                                            class="avatar avatar-lg bg-primary-transparent border border-primary border-opacity-10">
                                            <div class="avatar avatar-sm svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path
                                                        d="M216,64H176a48,48,0,0,0-96,0H40A16,16,0,0,0,24,80V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64ZM128,32a32,32,0,0,1,32,32H96A32,32,0,0,1,128,32Zm88,168H40V80H80V96a8,8,0,0,0,16,0V80h64V96a8,8,0,0,0,16,0V80h40Z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card main-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div>
                                        <span class="d-block mb-2">Profit</span>
                                        <h5 class="mb-4 fs-4">$645</h5>
                                    </div>
                                    <span class="text-success me-2 fw-medium d-inline-block"><i
                                            class="ti ti-trending-up fs-5 align-middle me-1 d-inline-block"></i>0.18%</span><span
                                        class="text-muted">than last month</span>
                                </div>
                                <div>
                                    <div class="main-card-icon secondary">
                                        <div
                                            class="avatar avatar-lg bg-secondary-transparent border border-secondary border-opacity-10">
                                            <div class="avatar avatar-sm svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path
                                                        d="M216,72H56a8,8,0,0,1,0-16H192a8,8,0,0,0,0-16H56A24,24,0,0,0,32,64V192a24,24,0,0,0,24,24H216a16,16,0,0,0,16-16V88A16,16,0,0,0,216,72Zm0,128H56a8,8,0,0,1-8-8V86.63A23.84,23.84,0,0,0,56,88H216Zm-48-60a12,12,0,1,1,12,12A12,12,0,0,1,168,140Z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card main-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div>
                                        <span class="d-block mb-2">Revenue</span>
                                        <h5 class="mb-4 fs-4">$14,32,145</h5>
                                    </div>
                                    <span class="text-success me-2 fw-medium d-inline-block"><i
                                            class="ti ti-trending-up fs-5 align-middle me-1 d-inline-block"></i>0.29%</span><span
                                        class="text-muted">Since last month</span>
                                </div>
                                <div>
                                    <div class="main-card-icon success">
                                        <div
                                            class="avatar avatar-lg bg-success-transparent border border-success border-opacity-10">
                                            <div class="avatar avatar-sm svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path
                                                        d="M200,168a48.05,48.05,0,0,1-48,48H136v16a8,8,0,0,1-16,0V216H104a48.05,48.05,0,0,1-48-48,8,8,0,0,1,16,0,32,32,0,0,0,32,32h48a32,32,0,0,0,0-64H112a48,48,0,0,1,0-96h8V24a8,8,0,0,1,16,0V40h8a48.05,48.05,0,0,1,48,48,8,8,0,0,1-16,0,32,32,0,0,0-32-32H112a32,32,0,0,0,0,64h40A48.05,48.05,0,0,1,200,168Z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="card custom-card main-card">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <div>
                                        <span class="d-block mb-2">Views</span>
                                        <h5 class="mb-4 fs-4">4,678</h5>
                                    </div>
                                    <span class="text-danger me-2 fw-medium d-inline-block"><i
                                            class="ti ti-trending-down fs-5 align-middle me-1 d-inline-block"></i>0.05%</span><span
                                        class="text-muted">Since last month</span>
                                </div>
                                <div>
                                    <div class="main-card-icon orange">
                                        <div
                                            class="avatar avatar-lg bg-orange-transparent border border-orange border-opacity-10">
                                            <div class="avatar avatar-sm svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path
                                                        d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-1 -->


        </div>
    </div>
    <!-- End::app-content -->
@endsection

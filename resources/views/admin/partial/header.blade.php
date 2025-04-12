<header class="app-header sticky" id="header">

    <!-- Start::main-header-container -->
    <div class="main-header-container container-fluid bg-white">

        <!-- Start::header-content-left -->
        <div class="header-content-left">

            <!-- Start::header-element -->
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="index.html" class="header-logo">
                        <img src="{{ asset('admin/assets/images/brand-logos/desktop-logo.png') }}" alt="logo"
                            class="desktop-logo">
                        <img src="{{ asset('admin/assets/images/brand-logos/toggle-logo.png') }}" alt="logo"
                            class="toggle-logo">
                        <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                            class="desktop-dark">
                        <img src="{{ asset('admin/assets/images/brand-logos/toggle-dark.png') }}" alt="logo"
                            class="toggle-dark">
                    </a>
                </div>
            </div>



            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <div class="main-sidebar-header ">
                        <a href="" class="header-logo mx-1" >
                            <img src="{{ asset('admin/assets/images/brand-logos/logo1.JPG') }}" alt="logo" width="150px"
                                class="desktop-logo">


                        </a>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li
                                class="nav-item dropdown {{ request()->routeIs('clients.index') ? 'show active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">Dashboards</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('clients.index') && request('type') == 'active' ? 'active' : '' }}"
                                            href="{{ route('clients.index', ['type' => 'active']) }}">Active
                                            Dashboard</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->routeIs('clients.index') && request('type') == 'archived' ? 'active' : '' }}"
                                            href="{{ route('clients.index', ['type' => 'archived']) }}">Archived</a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('files.index') ? 'nav-link active' : '' }}"
                                    href="{{ route('files.index') }}">File Opening Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->get('view') == 'day_book'  ? 'nav-link active' : '' }}"
                                    href="{{ route('transactions.index', ['view' => 'day_book']) }}">Day Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->get('view') == 'batch_invoicing' ? 'nav-link active' : '' }}"
                                    href="{{ route('transactions.index', ['view' => 'batch_invoicing']) }}">Batch Invicing</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('transactions.imported') ? 'active' : '' }}"
                                    href="{{ route('transactions.imported') }}">Transaction Report</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('transactions.cheque') ? 'active' : '' }}"
                                    href="{{ route('transactions.cheque') }}">Transaction Cheque</a>
                            </li>
                            @php
                                $isActive = request()->routeIs([
                                    'client.cashbook',
                                    'office.cashbook',
                                    'file.report',
                                    'client.passed.check',
                                    'client.ledger',
                                    'client.bank_bank_reconciliation',
                                    'office.bank_reconciliation',
                                    'bill.of.cost',
                                    'apex-heatmap-charts',
                                    'vat.report',
                                    'profit.and.loos'
                                ]);
                            @endphp

                            <li class="nav-item dropdown {{ $isActive ? 'show active' : '' }}">
                                <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">Reports</a>
                                <ul class="dropdown-menu" aria-labelledby="reportsDropdown">
                                    <li><a class="dropdown-item {{ request()->routeIs('client.cashbook') ? 'active' : '' }}"
                                            href="{{ route('client.cashbook') }}">Client Cash Book</a></li>
                                    <li><a class="dropdown-item {{ request()->routeIs('office.cashbook') ? 'active' : '' }}"
                                            href="{{ route('office.cashbook') }}">Office Cash Book</a></li>
                                    <li><a class="dropdown-item {{ request()->routeIs('file.report') ? 'active' : '' }}"
                                            href="{{ route('file.report') }}">File Opening Book</a></li>
                                    <li><a class="dropdown-item {{ request()->routeIs('client.passed.check') ? 'active' : '' }}"
                                            href="{{ route('client.passed.check') }}">14 Days Passed Check</a></li>
                                    <li><a class="dropdown-item {{ request()->routeIs('client.ledger') ? 'active' : '' }}"
                                            href="{{ route('client.ledger') }}">Client Ledger</a></li>
                                    <li><a class="dropdown-item {{ request()->routeIs('client.bank_bank_reconciliation') ? 'active' : '' }}"
                                            href="{{ route('client.bank_bank_reconciliation') }}">Client Bank
                                            Reconciliation</a></li>
                                    <li><a class="dropdown-item {{ request()->routeIs('office.bank_reconciliation') ? 'active' : '' }}"
                                            href="{{ route('office.bank_reconciliation') }}">Office Bank
                                            Reconciliation</a></li>
                                    <li><a class="dropdown-item {{ request()->routeIs('bill.of.cost') ? 'active' : '' }}"
                                            href="{{ route('bill.of.cost') }}">Bill Of Cost</a></li>
                                    <li><a class="dropdown-item {{ request()->routeIs('profit.and.loos') ? 'active' : '' }}"
                                            href="{{ route('profit.and.loos') }}">Profit And Lost</a></li>
                                    <li><a class="dropdown-item {{ request()->routeIs('vat.report') ? 'active' : '' }}"
                                            href="{{ route('vat.report') }}">VAT Report</a></li>
                                </ul>
                            </li>


                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('fee.earners') ? 'nav-link active' : '' }}"
                                    href="{{ route('fee.earners') }}">Fee Earners</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End::main-sidebar -->



            <!-- End::header-element -->

            <!-- Start::header-element -->
            {{-- <div class="header-element mx-lg-0 mx-2">
                <a aria-label="Hide Sidebar"
                    class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                    data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
            </div> --}}


        </div>

        <ul class="header-content-right">

            <!-- Start::header-element -->
            <li class="header-element d-md-none d-block">
                <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal"
                    data-bs-target="#header-responsive-search">
                    <!-- Start::header-link-icon -->
                    <i class="bi bi-search header-link-icon"></i>
                    <!-- End::header-link-icon -->
                </a>
            </li>

            <li class="header-element header-theme-mode">

                <a href="javascript:void(0);" class="header-link layout-setting">
                    <span class="light-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="32" height="32"
                            fill="#000000" viewBox="0 0 256 256">
                            <path
                                d="M98.31,130.38ZM94.38,17.62h0A64.06,64.06,0,0,1,17.62,94.38h0A64.12,64.12,0,0,0,55,138.93h0a44.08,44.08,0,0,1,43.33-8.54,68.13,68.13,0,0,1,45.47-47.32l.15,0c0-1,.07-2,.07-3A64,64,0,0,0,94.38,17.62Z"
                                opacity="0.1"></path>
                            <path
                                d="M164,72a76.45,76.45,0,0,0-12.36,1A71.93,71.93,0,0,0,96.17,9.83a8,8,0,0,0-9.59,9.58A56.45,56.45,0,0,1,88,32,56.06,56.06,0,0,1,32,88a56.45,56.45,0,0,1-12.59-1.42,8,8,0,0,0-9.59,9.59,72.22,72.22,0,0,0,32.29,45.06A52,52,0,0,0,84,224h80a76,76,0,0,0,0-152ZM29.37,104c.87,0,1.75,0,2.63,0a72.08,72.08,0,0,0,72-72c0-.89,0-1.78,0-2.67a55.63,55.63,0,0,1,32,48,76.28,76.28,0,0,0-43,43.4A52,52,0,0,0,54,129.59,56.22,56.22,0,0,1,29.37,104ZM164,208H84a36,36,0,1,1,4.78-71.69c-.37,2.37-.63,4.79-.77,7.23a8,8,0,0,0,16,.92,58.91,58.91,0,0,1,1.88-11.81c0-.16.09-.32.12-.48A60.06,60.06,0,1,1,164,208Z">
                            </path>
                        </svg>
                        <!-- End::header-link-icon -->
                    </span>
                    <span class="dark-layout">
                        <!-- Start::header-link-icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="32"
                            height="32" fill="#000000" viewBox="0 0 256 256">
                            <path
                                d="M131.84,84.41v0a68.22,68.22,0,0,0-41.65,46v-.11a44.08,44.08,0,0,0-38.54,5h0a48,48,0,1,1,80.19-50.94Z"
                                opacity="0.1"></path>
                            <path
                                d="M156,72a76.2,76.2,0,0,0-20.26,2.73,55.63,55.63,0,0,0-9.41-11.54l9.51-13.57a8,8,0,1,0-13.11-9.18L113.22,54A55.9,55.9,0,0,0,88,48c-.58,0-1.16,0-1.74,0L83.37,31.71a8,8,0,1,0-15.75,2.77L70.5,50.82A56.1,56.1,0,0,0,47.23,65.67L33.61,56.14a8,8,0,1,0-9.17,13.11L38,78.77A55.55,55.55,0,0,0,32,104c0,.57,0,1.15,0,1.72L15.71,108.6a8,8,0,0,0,1.38,15.88,8.24,8.24,0,0,0,1.39-.12l16.32-2.88a55.74,55.74,0,0,0,5.86,12.42A52,52,0,0,0,76,224h80a76,76,0,0,0,0-152ZM48,104a40,40,0,0,1,72.54-23.24,76.26,76.26,0,0,0-35.62,40,52.14,52.14,0,0,0-31,4.17A40,40,0,0,1,48,104ZM156,208H76a36,36,0,1,1,4.78-71.69c-.37,2.37-.63,4.79-.77,7.23a8,8,0,0,0,16,.92,58.91,58.91,0,0,1,1.88-11.81c0-.16.09-.32.12-.48A60.06,60.06,0,1,1,156,208Z">
                            </path>
                        </svg>
                        <!-- End::header-link-icon -->
                    </span>
                </a>
                <!-- End::header-link|layout-setting -->
            </li>

            <li class="header-element dropdown">
                <!-- Start::header-link|dropdown-toggle -->
                <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-xl-2 me-0">
                            <img src="{{ asset('admin/assets/images/faces/14.jpg') }}" alt="img"
                                class="avatar avatar-sm avatar-rounded">
                        </div>
                        <div class="d-xl-block d-none lh-1">
                            <span class="fw-medium lh-1"></span>
                        </div>
                    </div>
                </a>
                <!-- End::header-link|dropdown-toggle -->
                <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end"
                    aria-labelledby="mainHeaderProfile">
                    <li><a class="dropdown-item d-flex align-items-center" href="profile.html"><i
                                class="ti ti-user me-2 fs-18 text-primary"></i>Profile</a></li>

                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item d-flex align-items-center" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti ti-logout me-2 fs-18 text-warning"></i>Log Out
                        </a>
                    </li>

                </ul>
            </li>


        </ul>
        <!-- End::header-content-right -->

    </div>
    <!-- End::main-header-container -->

</header>

<script>
    $(document).ready(function() {
        // Check if any of the dropdown items are active
        $('#reportsDropdown').on('click', function() {
            const dropdown = $(this).parent('.nav-item.dropdown'); // Get the dropdown li
            const hasActiveItem = dropdown.find('.dropdown-menu .active').length > 0;

            // Add active class to the parent link if any item inside the dropdown is active
            if (hasActiveItem) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });

        // Additional handling when the page is loaded
        // Check for active items when the page loads (in case the dropdown is already open)
        const dropdown = $('#reportsDropdown').parent('.nav-item.dropdown'); // Get the dropdown li
        const hasActiveItem = dropdown.find('.dropdown-menu .active').length > 0;

        if (hasActiveItem) {
            $('#reportsDropdown').addClass('active');
        }
    });
</script>

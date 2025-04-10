<aside class="app-sidebar sticky" id="sidebar">

    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="index.html" class="header-logo">
            <img src="{{ asset('admin/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
            <img src="{{ asset('admin/assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
            <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png') }}" alt="logo"
                class="desktop-dark">
            <img src="{{ asset('admin/assets/images/brand-logos/toggle-logo.png') }}" alt="logo"
                class="toggle-logo">
        </a>
    </div>
  
    <div class="main-sidebar" id="sidebar-scroll">

        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                <li class="slide__category"><span class="category-name">Main</span></li>
                <!-- End::slide__category -->

                <!-- Start::slide -->
                <li class="slide has-sub">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <i class="ri-arrow-down-s-line side-menu__angle"></i>
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32"
                            viewBox="0 0 256 256">
                            <path
                                d="M216,115.54V208a8,8,0,0,1-8,8H160a8,8,0,0,1-8-8V160a8,8,0,0,0-8-8H112a8,8,0,0,0-8,8v48a8,8,0,0,1-8,8H48a8,8,0,0,1-8-8V115.54a8,8,0,0,1,2.62-5.92l80-75.54a8,8,0,0,1,10.77,0l80,75.54A8,8,0,0,1,216,115.54Z"
                                opacity="0.2"></path>
                            <path
                                d="M218.83,103.77l-80-75.48a1.14,1.14,0,0,1-.11-.11,16,16,0,0,0-21.53,0l-.11.11L37.17,103.77A16,16,0,0,0,32,115.55V208a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V160h32v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V115.55A16,16,0,0,0,218.83,103.77ZM208,208H160V160a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v48H48V115.55l.11-.1L128,40l79.9,75.43.11.1Z">
                            </path>
                        </svg>
                        <span class="side-menu__label">Dashboards</span>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Dashboards</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('clients.index', ['type' => 'active']) }}"
                                class="side-menu__item {{ request()->is('clients*') && request()->query('type') == 'active' ? 'active' : '' }}">Active Dashboard</a>
                        </li>
                        <li class="slide">
                            <a href="{{ route('clients.index', ['type' => 'archived']) }}"
                                class="side-menu__item {{ request()->is('clients*') && request()->query('type') == 'archived' ? 'active' : '' }}">Archived</a>
                        </li>
                    </ul>

                </li>
             
                <li class="slide__category"><span class="category-name">Web Apps</span></li>
              
                <li class="slide">
                    <a href="{{ route('files.index') }}" class="side-menu__item {{ Route::currentRouteName() == 'files.index' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32"
                            viewBox="0 0 256 256">
                            <path d="M208,128v72a8,8,0,0,1-8,8H56a8,8,0,0,1-8-8V128Z" opacity="0.2"></path>
                            <path
                                d="M216,72H180.92c.39-.33.79-.65,1.17-1A29.53,29.53,0,0,0,192,49.57,32.62,32.62,0,0,0,158.44,16,29.53,29.53,0,0,0,137,25.91a54.94,54.94,0,0,0-9,14.48,54.94,54.94,0,0,0-9-14.48A29.53,29.53,0,0,0,97.56,16,32.62,32.62,0,0,0,64,49.57,29.53,29.53,0,0,0,73.91,71c.38.33.78.65,1.17,1H40A16,16,0,0,0,24,88v32a16,16,0,0,0,16,16v64a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V136a16,16,0,0,0,16-16V88A16,16,0,0,0,216,72ZM149,36.51a13.69,13.69,0,0,1,10-4.5h.49A16.62,16.62,0,0,1,176,49.08a13.69,13.69,0,0,1-4.5,10c-9.49,8.4-25.24,11.36-35,12.4C137.7,60.89,141,45.5,149,36.51Zm-64.09.36A16.63,16.63,0,0,1,96.59,32h.49a13.69,13.69,0,0,1,10,4.5c8.39,9.48,11.35,25.2,12.39,34.92-9.72-1-25.44-4-34.92-12.39a13.69,13.69,0,0,1-4.5-10A16.6,16.6,0,0,1,84.87,36.87ZM40,88h80v32H40Zm16,48h64v64H56Zm144,64H136V136h64Zm16-80H136V88h80v32Z">
                            </path>
                        </svg>
                        <span class="side-menu__label">File Opening Book</span>
                    </a>
                </li>
                <!-- End::File Opening Book -->


                <!-- Start::Day Book -->
                <li class="slide">
                    <a href="{{ route('transactions.index') }}" class="side-menu__item {{ Route::currentRouteName() == 'transactions.index' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32"
                            viewBox="0 0 256 256">
                            <path d="M208,128v72a8,8,0,0,1-8,8H56a8,8,0,0,1-8-8V128Z" opacity="0.2"></path>
                            <path
                                d="M216,72H180.92c.39-.33.79-.65,1.17-1A29.53,29.53,0,0,0,192,49.57,32.62,32.62,0,0,0,158.44,16,29.53,29.53,0,0,0,137,25.91a54.94,54.94,0,0,0-9,14.48,54.94,54.94,0,0,0-9-14.48A29.53,29.53,0,0,0,97.56,16,32.62,32.62,0,0,0,64,49.57,29.53,29.53,0,0,0,73.91,71c.38.33.78.65,1.17,1H40A16,16,0,0,0,24,88v32a16,16,0,0,0,16,16v64a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V136a16,16,0,0,0,16-16V88A16,16,0,0,0,216,72ZM149,36.51a13.69,13.69,0,0,1,10-4.5h.49A16.62,16.62,0,0,1,176,49.08a13.69,13.69,0,0,1-4.5,10c-9.49,8.4-25.24,11.36-35,12.4C137.7,60.89,141,45.5,149,36.51Zm-64.09.36A16.63,16.63,0,0,1,96.59,32h.49a13.69,13.69,0,0,1,10,4.5c8.39,9.48,11.35,25.2,12.39,34.92-9.72-1-25.44-4-34.92-12.39a13.69,13.69,0,0,1-4.5-10A16.6,16.6,0,0,1,84.87,36.87ZM40,88h80v32H40Zm16,48h64v64H56Zm144,64H136V136h64Zm16-80H136V88h80v32Z">
                            </path>
                        </svg>
                        <span class="side-menu__label">Day Book</span>
                    </a>
                </li>
                <!-- End::Day Book -->

                <!-- Start::Transaction Report -->
                <li class="slide">
                    <a href="{{ route('transactions.imported') }}" class="side-menu__item {{ Route::currentRouteName() == 'transactions.imported' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32"
                            viewBox="0 0 256 256">
                            <path d="M208,128v72a8,8,0,0,1-8,8H56a8,8,0,0,1-8-8V128Z" opacity="0.2"></path>
                            <path
                                d="M216,72H180.92c.39-.33.79-.65,1.17-1A29.53,29.53,0,0,0,192,49.57,32.62,32.62,0,0,0,158.44,16,29.53,29.53,0,0,0,137,25.91a54.94,54.94,0,0,0-9,14.48,54.94,54.94,0,0,0-9-14.48A29.53,29.53,0,0,0,97.56,16,32.62,32.62,0,0,0,64,49.57,29.53,29.53,0,0,0,73.91,71c.38.33.78.65,1.17,1H40A16,16,0,0,0,24,88v32a16,16,0,0,0,16,16v64a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V136a16,16,0,0,0,16-16V88A16,16,0,0,0,216,72ZM149,36.51a13.69,13.69,0,0,1,10-4.5h.49A16.62,16.62,0,0,1,176,49.08a13.69,13.69,0,0,1-4.5,10c-9.49,8.4-25.24,11.36-35,12.4C137.7,60.89,141,45.5,149,36.51Zm-64.09.36A16.63,16.63,0,0,1,96.59,32h.49a13.69,13.69,0,0,1,10,4.5c8.39,9.48,11.35,25.2,12.39,34.92-9.72-1-25.44-4-34.92-12.39a13.69,13.69,0,0,1-4.5-10A16.6,16.6,0,0,1,84.87,36.87ZM40,88h80v32H40Zm16,48h64v64H56Zm144,64H136V136h64Zm16-80H136V88h80v32Z">
                            </path>
                        </svg>
                        <span class="side-menu__label">Transaction Report</span>
                    </a>
                </li>
                <!-- End::Transaction Report -->

                <!-- Start::Reports -->
                <li class="slide has-sub open-ul">
                    <a href="javascript:void(0);" class="side-menu__item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32"
                            viewBox="0 0 256 256">
                            <path d="M208,40V208H152V40Z" opacity="0.2"></path>
                            <path
                                d="M224,200h-8V40a8,8,0,0,0-8-8H152a8,8,0,0,0-8,8V80H96a8,8,0,0,0-8,8v40H48a8,8,0,0,0-8,8v64H32a8,8,0,0,0,0,16H224a8,8,0,0,0,0-16ZM160,48h40V200H160ZM104,96h40V200H104ZM56,144H88v56H56Z">
                            </path>
                        </svg>
                        <span class="side-menu__label">Reports</span>
                        <i class="ri-arrow-down-s-line side-menu__angle"></i>
                    </a>
                    <ul class="slide-menu child1">
                        <li class="slide side-menu__label1">
                            <a href="javascript:void(0)">Reports</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="{{ route('client.cashbook') }}" class="side-menu__item">Client Cash Book
                                {{-- <i class="ri-arrow-down-s-line side-menu__angle"></i> --}}
                            </a>

                        </li>

                        <li class="slide has-sub">
                            <a href="{{ route('office.cashbook') }}" class="side-menu__item">Office Cash Book</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="{{ route('file.report') }}" class="side-menu__item">File Opening Book
                            </a>
                        </li>

                        <li class="slide has-sub">
                            <a href="{{ route('client.passed.check') }}" class="side-menu__item">14 Days Passed Check</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="{{ route('client.ledger') }}" class="side-menu__item">Client Ledger</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="{{ route('client.bank_bank_reconciliation') }}" class="side-menu__item">Client Bank Reconciliation</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="{{ route('office.bank_reconciliation') }}" class="side-menu__item">Office Bank Reconciliation</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="{{ route('bill.of.cost') }}" class="side-menu__item">Bill Of Cost</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="apex-heatmap-charts.html" class="side-menu__item">Profit And Lost</a>
                        </li>
                        <li class="slide has-sub">
                            <a href="{{ route('vat.report') }}" class="side-menu__item">VAT Report</a>
                        </li>

                    </ul>
                </li>
              
                
                <li class="slide">
                    <a href="{{ route('fee.earners') }}" class="side-menu__item {{ Route::currentRouteName() == 'transactions.imported' ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="32" height="32"
                            viewBox="0 0 256 256">
                            <path d="M208,128v72a8,8,0,0,1-8,8H56a8,8,0,0,1-8-8V128Z" opacity="0.2"></path>
                            <path
                                d="M216,72H180.92c.39-.33.79-.65,1.17-1A29.53,29.53,0,0,0,192,49.57,32.62,32.62,0,0,0,158.44,16,29.53,29.53,0,0,0,137,25.91a54.94,54.94,0,0,0-9,14.48,54.94,54.94,0,0,0-9-14.48A29.53,29.53,0,0,0,97.56,16,32.62,32.62,0,0,0,64,49.57,29.53,29.53,0,0,0,73.91,71c.38.33.78.65,1.17,1H40A16,16,0,0,0,24,88v32a16,16,0,0,0,16,16v64a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V136a16,16,0,0,0,16-16V88A16,16,0,0,0,216,72ZM149,36.51a13.69,13.69,0,0,1,10-4.5h.49A16.62,16.62,0,0,1,176,49.08a13.69,13.69,0,0,1-4.5,10c-9.49,8.4-25.24,11.36-35,12.4C137.7,60.89,141,45.5,149,36.51Zm-64.09.36A16.63,16.63,0,0,1,96.59,32h.49a13.69,13.69,0,0,1,10,4.5c8.39,9.48,11.35,25.2,12.39,34.92-9.72-1-25.44-4-34.92-12.39a13.69,13.69,0,0,1-4.5-10A16.6,16.6,0,0,1,84.87,36.87ZM40,88h80v32H40Zm16,48h64v64H56Zm144,64H136V136h64Zm16-80H136V88h80v32Z">
                            </path>
                        </svg>
                        <span class="side-menu__label">Fee Earners</span>
                    </a>
                </li>

            </ul>

          
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
                    width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
                </svg></div>
        </nav>
        <!-- End::nav -->

    </div>
    <!-- End::main-sidebar -->

</aside>

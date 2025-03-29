<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="transparent"
    data-width="default" data-menu-styles="light" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>fastledger</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="keywords"
        content="admin dashboard, admin template, admin panel, bootstrap admin dashboard, html template, sales dashboard, dashboard, template dashboard, admin, html and css template, admin dashboard bootstrap, personal dashboard, crypto dashboard, stocks dashboard, admin panel template">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('admin/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="{{ asset('admin/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Style CSS -->
    <link href="{{ asset('admin/assets/css/styles.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">


    <!-- Icons CSS -->
    <link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet">

    <!-- Node Waves CSS -->
    <link href="{{ asset('admin/assets/libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- Simplebar CSS -->
    <link href="{{ asset('admin/assets/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <!-- Color Picker CSS -->
    <link href="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/libs/@simonwep/pickr/themes/nano.min.css') }}" rel="stylesheet">

    <!-- Choices CSS -->
    <link href="{{ asset('admin/assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet">

    <!-- Auto Complete CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.min.css">


    <style>
        /* For active items in the dropdown menu */
        .dropdown-menu li a.active {
            background-color: rgba(84, 109, 254, 0.15);
            color: var(--primary-color);
        }

        .navbar-nav .nav-item.active>.nav-link {
            background-color: rgba(84, 109, 254, 0.15);
            color: var(--primary-color);
        }
    </style>

</head>

<body>
    <!-- Start Switcher -->
    @include('admin.partial.switcher')
    <!-- End Switcher -->

    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('admin/assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->
    <div class="page">
        <!-- app-header -->
        @include('admin.partial.header')
        <!-- /app-header -->
        <!-- Start::app-sidebar -->
        {{-- @include('admin.partial.sidebar') --}}
        <!-- End::app-sidebar -->
        <div class="mt-3">
            <!-- End::app-sidebar -->
            @yield('content')
        </div>

        <!-- Footer Start -->
        @include('admin.partial.footer')
        <!-- Footer End -->

        <!-- Modal for Search -->
        <div class="modal fade" id="header-responsive-search" tabindex="-1" aria-labelledby="header-responsive-search"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="text" class="form-control border-end-0" placeholder="Search Anything ..."
                                aria-label="Search Anything ..." aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="button" id="button-addon2"><i
                                    class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scroll To Top -->
    <div class="scrollToTop">
        <span class="arrow lh-1"><i class="ti ti-caret-up fs-20"></i></span>
    </div>
    <div id="responsive-overlay"></div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Popper JS -->
    <script src="{{ asset('admin/assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Defaultmenu JS -->
    <script src="{{ asset('admin/assets/js/defaultmenu.min.js') }}"></script>

    <!-- Node Waves JS -->
    <script src="{{ asset('admin/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- Sticky JS -->

    <!-- Simplebar JS -->
    <script src="{{ asset('admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/simplebar.js') }}"></script>

    <!-- Auto Complete JS -->
    <script src="{{ asset('admin/assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('admin/assets/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('admin/assets/libs/flatpickr/flatpickr.min.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Custom JS -->mmkljkkllklklkjkkjllkljkjlk
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
    <!-- Custom-Switcher JS -->
    <script src="{{ asset('admin/assets/js/custom-switcher.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/sticky.js') }}"></script>

   
    @yield('scripts')

</body>

</html>

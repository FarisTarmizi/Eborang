<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if(auth()->user()->hasRole('KB_BTM')||auth()->user()->hasRole('STAFF_BTM')||auth()->user()->hasRole('KB'))
        <title>E-BORANG | @yield('title')</title>
    @else
        <title>E-BORANG | MBAS</title>
    @endif
    <link rel="icon" href="{{asset('image/mbas.png')}}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('lte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('lte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('lte/dist/css/adminlte.min.css')}}">
    {{-- sweet alert   --}}
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css
" rel="stylesheet">
    <!-- Include JavaScript -->
    {{--    <script src="{{ asset('js/generatePassword.js') }}"></script>--}}
    <style>
        .progress-bar {
            transition: width 0.5s;
        }

        .step-wizard-list {
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
            list-style-type: none;
            border-radius: 10px;
            display: flex;
            padding: 20px 10px;
            position: relative;
            z-index: 10;
            overflow-x: auto; /* Enable horizontal scrolling on smaller screens */
            scrollbar-width: none; /* Hide scrollbar in Firefox */
            -ms-overflow-style: none; /* Hide scrollbar in Internet Explorer */
        }

        .step-wizard-item {
            padding: 0 10px;
            flex-basis: 0;
            flex-grow: 1;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            text-align: center;
            min-width: 100px; /* Adjusted for smaller screens */
            position: relative;
        }

        .step-wizard-item + .step-wizard-item:after {
            content: "";
            position: absolute;
            left: 0;
            top: 19px;
            background: #ddd;
            width: calc(100% - 50px); /* Adjusted for smaller screens */
            height: 2px;
            transform: translateX(-50%);
            z-index: -10;
        }

        .progress-count {
            height: 40px;
            width: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
            margin: 0 auto;
            position: relative;
            z-index: 10;
            color: transparent;
            transition: background 0.3s, color 0.3s;
        }

        .progress-count:after {
            content: "";
            height: 40px;
            width: 40px;
            background: #6f6f6f;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            z-index: -10;
            transition: background 0.3s, border 0.3s;
        }

        .progress-count:before {
            content: "";
            height: 10px;
            width: 20px;
            border-left: 3px solid #ffffff; /* Adjusted to match the light gray background */
            border-bottom: 3px solid #f0f0f0; /* Adjusted to match the light gray background */
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -60%) rotate(-45deg);
            transform-origin: center center;
        }

        .progress-label {
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
            color: rgb(116, 116, 116);
            transition: color 0.3s, opacity 0.3s;
        }

        .current-item .progress-count:before,
        .current-item ~ .step-wizard-item .progress-count:before {
            display: none;
        }

        .current-item ~ .step-wizard-item .progress-count:after {
            height: 10px;
            width: 10px;
            background: #ffffff;
        }

        .current-item ~ .step-wizard-item .progress-label {
            opacity: 0.5;
        }

        .current-item .progress-count:after {
            background: #ffffff; /* Bright blue background for current step */
            border: 5px solid rgb(255, 255, 255);
        }

        .current-item .progress-count {
            color: black;
        }

        .current-item .progress-label {
            color: white;
        }

        /* Media Query for smaller screens */
        @media only screen and (max-width: 600px) {
            .step-wizard-item {
                min-width: auto;
            }

            

        }


    </style>
</head>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">


    <!-- Horizontal Navbar -->
    <nav class="main-header navbar navbar-expand" style="background: linear-gradient(45deg, #000000, #7ebeff); color: #FFFFFF;">
        <!-- Left navbar -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            @if(auth()->user()->hasRole('KB_BTM'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('kb.kb_home')}}">PERMOHONAN</a>
                </li>
            @elseif(auth()->user()->hasRole('STAFF_BTM'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('staff.staff_home')}}">DASHBOARD</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('staff.application')}}">PERMOHONAN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('staff.list_g')}}">PERALATAN ICT</a>
                </li>
            @elseif(auth()->user()->hasRole('PEMOHON'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('borrower.l_history')}}">REKOD PERMOHONAN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('borrower.borrower_home')}}">E-BORANG</a>
                </li>
            @elseif(auth()->user()->hasRole('KB'))
                <li class="nav-item">
                    <a class="nav-link" href="{{route('kb_l.kbl_home')}}">PERMOHONAN</a>
                </li>
            @endif
        </ul>
        <!-- Right navbar -->
        <ul class="navbar-nav ml-auto">
            {{--maximize/minimize page--}}
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            {{--sidebar icon--}}
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>
        </ul>
    </nav>
    <aside class="control-sidebar text-center" style="background: linear-gradient(45deg, #000000, #7ebeff); color: #FFFFFF;">
        <div class="container">
            <h5 class="mt-3">SISTEM PERALATAN ICT</h5>
            <div class="text-justify">
                <p class="mt-3 ">
                    <b>Description:</b><br>
                    ICT Gear System is a <b>simple system</b> that systematically manage ict gear loans.
                    <br>
                    <br> <b>Features:</b> <br>- Manage the ICT gears loaning <br>- ICT gear inventory management

                </p>
                <p class="text-center mt-5">
                    <b>Developer:</b> <br> Faris Tarmizi & Shahrul<br>
                    <b>Start Date:</b> <br> May 2024<br>
                    <b>Laravel Version:</b> <br> 10 & 11
                </p>
            </div>
        </div>
    </aside>
    <div class="content-wrapper" style="background: linear-gradient( #7ebeff, #ffffff); color: #FFFFFF;">
        <!-- Content Header (Page header) -->
        @if(auth()->user()->hasRole('KB_BTM')||auth()->user()->hasRole('STAFF_BTM')||auth()->user()->hasRole('KB'))
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            <div class="content-header bg-white p-5 mx-auto -mb-10">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title2')</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">@yield('page')</a></li>
                                <li class="breadcrumb-item active">SISTEM E-BORANG</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
                <hr style="border-color: whitesmoke">
            </div>
        @endif
        @yield('content')
    </div>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar elevation-4" style="background: linear-gradient( #000000, #9f9f9f); color: #FFFFFF;">
        <!-- Brand Logo -->
        <a href="#" class="brand-link" style="text-decoration: none">
            <img src="{{asset('image/mbas.png')}}" alt="Logo"
                 class="brand-image img-circle elevation-3" style="opacity:0.8">
            <span class="brand-text font-weight-light" data-widget="control-sidebar" data-slide="true" role="button">
                SISTEM E-BORANG
            </span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-auto">
                <div class="image">
                    @yield('img')
                </div>
                <div class="info mt-1">
                    <a href="#" class="d-block" style="text-decoration: none">@yield('position')</a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @if(auth()->user()->hasRole('KB_BTM'))
                        <li class="nav-item">
                            <a href="{{route('kb.kb_home')}}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>KELULUSAN</p>
                            </a>
                        </li>
                    @elseif(auth()->user()->hasRole('STAFF_BTM'))
                        <li class="nav-item">
                            <a href="{{route('staff.staff_home')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>DASHBOARD</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('staff.application')}}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>PERMOHONAN</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-wrench"></i>
                                <p>
                                    PERALATAN ICT
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('staff.list_g')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>SENARAI PERALATAN ICT</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('staff.g_form')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>TAMBAH PERALATAN ICT</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('staff.category')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>KATEGORI</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                    @elseif(auth()->user()->hasRole('PEMOHON'))
                        <li class="nav-item">
                            <a href="{{route('borrower.l_history')}}" class="nav-link">
                                <i class="nav-icon fas fa-history"></i>
                                <p>REKOD PERMOHONAN</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('borrower.borrower_home')}}" class="nav-link">
                                <i class="nav-icon fas fa-file-contract"></i>
                                <p>E-BORANG</p>
                            </a>
                        </li>
                    @elseif(auth()->user()->hasRole('KB'))
                        <li class="nav-item">
                            <a href="{{route('kb_l.kbl_home')}}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>KELULUSAN</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-toggle="modal" data-target="#modal-warning">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>KELUAR</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
        <i class="fas fa-chevron-up"></i>
    </a>
</div>

{{-- Logout Modal --}}
<div class="modal fade" id="modal-warning" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h4 class="modal-title">PENGESAHAN</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="logout-form" action="{{route('logout')}}" method="post">
                @csrf
                <div class="modal-body">
                    Adakah Anda Pasti Log keluar Dari Sistem Ini?
                </div>
                <div class="modal-footer border-0 justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-primary" value="Ya">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('lte/plugins/jquery/jquery.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- jquery-validation -->
<script src="{{asset('lte/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('lte/plugins/jquery-validation/additional-methods.min.js')}}"></script>

<!-- Bootstrap -->
<script src="{{asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<!-- overlayScrollbars -->
<script src="{{asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('lte/dist/js/adminlte.js')}}"></script>

<!-- PAGE PLUGINS -->
<!-- DataTables  & Plugins -->
<script src="{{asset('lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('lte/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('lte/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('lte/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('lte/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('lte/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('lte/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('lte/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<!-- jQuery Mapael -->
<script src="{{asset('lte/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<script src="{{asset('lte/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('lte/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
<script src="{{asset('lte/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('lte/plugins/chart.js/Chart.min.js')}}"></script>
@yield('chart')


<!-- form validation-->
<script>
    $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $("#example2").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>
<script>
    $(document).ready(function () {
        var currentStep = 1;

        // Define the progress percentages for each step
        var progressPercentages = {
            1: 50,
            2: 100
        };

        function updateProgressBar(step) {
            var percentage = progressPercentages[step] || 0;
            $('#progress-bar').css('width', percentage + '%').attr('aria-valuenow', percentage);
        }

        $('.next-step').click(function () {
            $('.form-step').addClass('d-none');
            currentStep++;
            $('.step-' + currentStep).removeClass('d-none');
            updateProgressBar(currentStep);
        });

        $('.prev-step').click(function () {
            $('.form-step').addClass('d-none');
            currentStep--;
            $('.step-' + currentStep).removeClass('d-none');
            updateProgressBar(currentStep);
        });

        updateProgressBar(currentStep);
    });
</script>
</body>

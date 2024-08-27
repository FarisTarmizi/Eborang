<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PERALATAN ICT | @yield('title')</title>
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
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">


    <!-- Horizontal Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
        <!-- Left navbar -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('staff.staff_home')}}">DASHBOARD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('staff.application')}}">PERMOHONAN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('staff.list_g')}}">PERALATAN ICT</a>
            </li>
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
    <aside class="control-sidebar control-sidebar-dark text-center">
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
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0">STAFF TEKNOLOGI MAKLUMAT</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">@yield('page')</a></li>
                            <li class="breadcrumb-item active">SISTEM PERALATAN ICT</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
            <hr style="border-color: whitesmoke">
        </div>
        @yield('content')
    </div>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link" style="text-decoration: none">
            <img src="{{asset('image/mbas.png')}}" alt="Logo"
                 class="brand-image img-circle elevation-3" style="opacity:0.8">
            <span class="brand-text font-weight-light" data-widget="control-sidebar" data-slide="true" role="button">
                PERALATAN ICT
            </span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
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
                                    <p>PERALATAN BARU</p>
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

{{--Logout Modal--}}
<div class="modal fade" id="modal-warning" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content bg-warning">
            <div class="modal-header">
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
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Batal</button>
                    <input type="submit" class="btn btn-outline-dark" value="Ya">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('lte/plugins/jquery/jquery.min.js')}}"></script>

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

</body>

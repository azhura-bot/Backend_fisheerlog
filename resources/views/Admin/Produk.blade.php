<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>FisheerLog - Karyawan</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- DataTables -->
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    </head>


    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                    <i class="ion-close"></i>
                </button>

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <!--<a href="index.html" class="logo"><i class="mdi mdi-assistant"></i> Zoter</a>-->
                        <a href="Dashboard.html" class="logo">
                            <img src="assets/images/LogoFIs.png" class="logo-large">
                        </a>
                    </div>
                </div>

                <div class="sidebar-inner niceScrollleft">

                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Home</li>

                            <li>
                                <a href="Dashboard.html" class="waves-effect">
                                    <i class="mdi mdi-airplay"></i>
                                    <span> Dashboard <span class="badge badge-pill badge-primary float-right"></span></span>
                                </a>
                            </li>
                            <li class="menu-title">Fitur</li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple-plus"></i><span> Karyawan </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="Karyawan.html">Data Karyawan</a></li>
                                    <li><a href="Tambah Karyawan.html">Tambah Karyawan</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti ti-receipt"></i><span> Transaksi </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="Data Masuk.html">Data Masuk</a></li>
                                    <li><a href="Data Keluar.html">Data Keluar</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti ti-package"></i><span> Produk </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="Produk.html">Data Stok</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti ti-book"></i><span> Modul </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="Tambah Modul.html">Tambah Modul</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-calendar-multiple-check"></i><span> Daily Task </span> <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="Tambah Task.html">Tambah Task</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <div class="topbar">

                        <nav class="navbar-custom">

                            <ul class="list-inline float-right mb-0">
                                <!-- language-->
                                <li class="list-inline-item hide-phone app-search">
                                    <form role="search" class="">
                                        <input type="text" placeholder="Search..." class="form-control">
                                        <a href=""><i class="fa fa-search"></i></a>
                                    </form>
                                </li>
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                       aria-haspopup="false" aria-expanded="false">
                                        <i class="ti-bell noti-icon"></i>
                                        <span class="badge badge-success noti-icon-badge">23</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5><span class="badge badge-danger float-right">87</span>Notification</h5>
                                        </div>
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="notify-icon bg-success"><i class="mdi mdi-message"></i></div>
                                            <p class="notify-details"><b>Pesan Baru</b><small class="text-muted">Seseorang menambahkan data masuk</small></p>
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            View All
                                        </a>
                                    </div>
                                </li>
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                                       aria-haspopup="false" aria-expanded="false">
                                        <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5>Welcome</h5>
                                        </div>
                                        <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="Login.html"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                                    </div>
                                </li>

                            </ul>

                            <ul class="list-inline menu-left mb-0">
                                <li class="float-left">
                                    <button class="button-menu-mobile open-left waves-light waves-effect">
                                        <i class="mdi mdi-menu"></i>
                                    </button>
                                </li>                                
                            </ul>

                            <div class="clearfix"></div>

                        </nav>

                    </div>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="btn-group float-right">
                                            <ol class="breadcrumb hide-phone p-0 m-0">
                                                <li class="breadcrumb-item"><a href="Dashboard.html">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="Produk.html">Produk</a></li>
                                                <li class="breadcrumb-item active">Data Produk</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Produk</h4>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Data Produk</h4>
                                            <table class="table" id="my-table">
                                                <thead>
                                                    <tr>
                                                    <th>Jenis Ikan</th>
                                                    <th>Stok</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Mujair</td>
                                                        <td>762</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nila</td>
                                                        <td>491</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Lele</td>
                                                        <td>773</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Patin</td>
                                                        <td>285</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Mas</td>
                                                        <td>491</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div>
                            <!-- end page title end breadcrumb -->
                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                    © 2024 FisheerLog by Fisheero.
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>

        <!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/plugins/datatables/jszip.min.js"></script>
        <script src="assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
 
        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>
        <script src="assets/plugins/tiny-editable/mindmup-editabletable.js"></script>
        <script src="assets/plugins/tiny-editable/numeric-input-example.js"></script>
        <script src="assets/plugins/tabledit/jquery.tabledit.js"></script>
        <script src="assets/pages/tabledit.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
        <script>
            $(document).ready(function() {
                $('#datatable2').DataTable();  
            } );
        </script>

    </body>
</html>
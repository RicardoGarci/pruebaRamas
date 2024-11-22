<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light" data-layout-mode="fluid"
    data-menu-color="brand" data-topbar-color="light" data-layout-position="fixed" data-sidenav-size="sm-hover"
    class="menuitem-active">

{{-- <head><html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-sidenav-size="full" data-theme="light" data-layout-mode="fluid" data-menu-color="brand" data-topbar-color="light" data-layout-position="fixed" class="menuitem-active"> --}}
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SISOP') }}</title>

    <link rel="shortcut icon" href="{{ asset('img/favicon1.png') }}">

    <!-- App css -->
    <link href="{{ asset('css/app-modern.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- SimpleMDE css -->
    <link href="{{ asset('vendor/simplemde/simplemde.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Datatables css -->
    <link href="{{ asset('vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
     <link href="{{ asset('vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" /> 

        
    <link href="{{ asset('vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />

</head>

<body>
    <div class="wrapper">

        <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-lg-2 gap-1">
                    <button class="button-toggle-menu">
                        <i class="mdi mdi-menu"></i>
                    </button>
                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-notification-3-line font-22"></i>
                                <span class="noti-icon-badge"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                            <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 font-16 fw-semibold"> Notificaciones</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="px-1">

                                    <div class="flex-grow-1 ms-2 text-wrap text-center my-2">
                                        <strong class="text-primary">Estamos al día!</strong>
                                    </div>

                                            <a href="#"
                                                class="dropdown-item p-0 notify-item card shadow-none mb-2">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div
                                                                class="notify-icon bg-primary text-white d-flex align-items-center justify-content-center rounded-circle">
                                                                <i class="mdi mdi-comment-account-outline"></i>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 text-wrap">
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>


                                    <form action="" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="dropdown-item text-center text-primary notify-item border-top border-light py-2">
                                            Marcar todo como leído
                                        </button>
                                    </form>
                            </div>
                        </div>
                    </li>
                    <li class="d-none d-sm-inline-block">
                        <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Theme Mode">
                            <i class="ri-moon-line font-22"></i>
                        </div>
                    </li>
                    <li class="d-none d-md-inline-block">
                        <a class="nav-link" href="" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line font-22"></i>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                <i class="ri-user-3-fill"></i>
                            </span>
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                <h5 class="my-0"></h5>
                                <h6 class="my-0 fw-normal"></h6>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Bienvenido(a) a SISOP</h6>
                            </div>
                            <a href="" class="dropdown-item">
                                <i class="ri-user-line"></i>
                                <span>Perfil</span>
                            </a>

                                <a href="" class="dropdown-item">
                                    <i class="mdi mdi-home-modern"></i>
                                    <span>Ente</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a type="submit" href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="dropdown-item">
                                        <i class="mdi mdi-logout me-1"></i>
                                        <span>Cerrar sesión</span>
                                    </a>
                                </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        @include('layouts.navigation')
        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">{{ $header }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <span><img src="{{ asset('img/logo_uie.svg') }}" width="250px" alt="logo"></span>
                        </div>
                        <div class="col-md-6">
                            <br>
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="https://sig.oaxaca.gob.mx/uie/" target="_blank">Contacto</a>
                                <a href="" target="_blank">Manual de Usuario</a>
                                <a href="" target="_blank">Manual de Procedimientos</a>
                                <a href="" target="_blank">Lineamientos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <script src="{{ asset('js/hyper-config.js') }}"></script>

    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <!-- Datatables js -->
    <script src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script> 
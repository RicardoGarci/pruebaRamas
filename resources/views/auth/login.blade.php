<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="topnav" data-topbar-color="dark">

<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        
    </title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('img/favicon1.png') }}">

    <script src="{{ asset('js/hyper-config.js') }}"></script>
    <link href="{{ asset('css/app-modern.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="index.html">
                                <span><img src="{{ asset('img/sisop.svg') }}"
                                        style="filter: grayscale(100%) brightness(500%)" height="90px"
                                        alt="logo"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Iniciar sesión</h4>
                                <p class="text-muted mb-4">Ingrese su dirección de correo electrónico y contraseña para
                                    acceder.</p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            {{--       @if (session('status'))
                                <div class="alert alert-success mb-4">
                                    {{ session('status') }}
                                </div>
                            @endif --}}

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Correo Electrónico</label>
                                    <input class="form-control" type="email" name="email" id="emailaddress"
                                        required="">
                                </div>

                                <div class="mb-3">
                                    {{-- <a href="pages-recoverpw.html" class="text-muted float-end"><small>Olvidaste tu contraseña?</small></a> --}}
                                    <label for="password" class="form-label">Contraseña</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-3 mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                        <label class="form-check-label" for="checkbox-signin">Recordarme</label>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> Iniciar Sesión </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <span><img src="{{ asset('img/logo_uie.svg') }}" alt="logo"></span>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    <script src="{{ asset('js/vendor.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>

</body>

</html>
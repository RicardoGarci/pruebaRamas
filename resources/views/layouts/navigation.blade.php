<div class="leftside-menu">
    <!-- Brand Logo Light -->
    <a href="/dashboard" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ asset('img/logo_gob.svg') }}"
                style="filter: grayscale(100%) brightness(500%); height: 60px; width: auto" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('img/logo_gob.svg') }}"
                style="filter: grayscale(100%) brightness(500%); height: 30px; width: auto" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="/dashboard" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('img/logo_gob.svg') }}"
                style="filter: grayscale(100%) brightness(500%); height: 60px; width: auto"alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('img/logo_gob.svg') }}"
                style="filter: grayscale(100%) brightness(500%); height: 30px; width: auto" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <ul class="side-nav">
            <br>
            <li class="side-nav-item">
                <a href="/dashboard" class="side-nav-link">
                    <i class="btn btn-dashboard" style=""></i>
                    <span class="menu-text">Inicio</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('catalogoContratistas.index') }}" class="side-nav-link">
                    <i class="mdi mdi mdi-36px mdi-bank-plus"></i>
                    <span>Registrar Contratisa</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ route('catalogoContratistas.index') }}" class="side-nav-link">
                    <i class="mdi mdi mdi-36px mdi-bank-plus"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            {{-- seccion de solicitudes historico --}}
            <li class="side-nav-item">
                <a href="" class="side-nav-link">
                    <i class="mdi mdi mdi-36px mdi-text-box-plus-outline"></i>
                    <span>Solicitudes </span>
                </a>
            </li>

            <li class="side-nav-title">Administración</li>
            <li class="side-nav-item">
                <a href="" class="side-nav-link">
                    <i class="mdi mdi mdi-36px mdi-account-plus"></i>
                    <span> Usuarios </span>
                </a>
                <a href="" class="side-nav-link">
                    <i class="mdi mdi mdi-36px mdi-book-plus-outline"></i>
                    <span> Documentación </span>
                </a>
            </li>

            <li class="side-nav-title">Sistema</li>
            <li class="side-nav-item">

                <a href="" class="side-nav-link">
                    <i class="mdi mdi mdi-36px mdi-account-wrench"></i>
                    <span>&nbsp; Permisos </span>
                </a>
                <a href="" class="side-nav-link">
                    <i class="mdi mdi mdi-36px mdi-account-switch"></i>
                    <span>&nbsp; Roles </span>
                </a>
                <a href="/activity-logs" class="side-nav-link">
                    <i class="mdi mdi mdi-36px mdi-briefcase-eye"></i>
                    <span> Registro de actividad </span>
                </a>
                <a href="/logs" target="_blank" class="side-nav-link">
                    <i class="mdi mdi mdi-36px mdi-bug"></i>
                    <span> Logs de sistema </span>
                </a>

            </li>
    </ul>
    <!--- End Sidemenu -->

    <div class="clearfix"></div>
</div>
</div>

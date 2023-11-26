

<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2 fs-14">
        <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}" data-widget="treeview" role="menu" @if(config('adminlte.sidebar_nav_animation_speed') !=300) data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}" @endif @if(!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
            <li class="nav-item">
                <a class="nav-link only" href="/dashboard">
                    <i class="fas fa-tachometer-alt "></i>
                    <p class="ml-2">
                        Bienvenidos
                    </p>
                </a>
            </li>

            <!-- Me gustaria declarar mi amor, pero solo se declarar variables. Un programador triste -->

            <!-- <li id="" class="nav-item has-treeview">
                <a class="nav-link title" href="">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p class="ml-2">
                        Subidas
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a id="" class="nav-link only" href="/upload">
                            <i class="fas fa-link ml-3"></i>
                            <p class="ml-2">
                                Subidas
                            </p>
                        </a>
                    </li>
                </ul>
            </li> -->

            <!-- <li id="" class="nav-item has-treeview">
                <a class="nav-link title" href="">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p class="ml-2">
                        Reportes
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a id="" class="nav-link only" href="/reports">
                            <i class="fas fa-link ml-3"></i>
                            <p class="ml-2">
                                Reportes
                            </p>
                        </a>
                    </li>
                </ul>
            </li> -->

            <li id="" class="nav-item has-treeview">
                <a class="nav-link title" href="">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p class="ml-2">
                        Maestros
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a id="" class="nav-link only" href="/supplier">
                            <i class="fas fa-link ml-3"></i>
                            <p class="ml-2">
                                Proveedores
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a id="" class="nav-link only" href="/teacher">
                            <i class="fas fa-link ml-3"></i>
                            <p class="ml-2">
                                Docentes
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a id="" class="nav-link only" href="/attendance">
                            <i class="fas fa-link ml-3"></i>
                            <p class="ml-2">
                                Asistencia
                            </p>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a id="" class="nav-link only" href="/parent">
                            <i class="fas fa-link ml-3"></i>
                            <p class="ml-2">
                                Pariente
                            </p>
                        </a>
                    </li>
                </ul>
            </li>

            <li id="" class="nav-item has-treeview">
                <a class="nav-link title" href="">
                    <i class="fas fa-cogs"></i>
                    <p class="ml-2">
                        Ajustes
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a id="" class="nav-link only" href="/usuario">
                            <i class="fas fa-link ml-3"></i>
                            <p class="ml-2">
                                Usuarios
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a id="" class="nav-link only" href="/rol">
                            <i class="fas fa-link ml-3"></i>
                            <p class="ml-2">
                                Roles
                            </p>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>

    </div>

</aside>


<!doctype html>
<html data-coreui-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="//fonts.bunny.net" rel="dns-prefetch">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Favicon -->
    <link href="assets/favicon/apple-icon-57x57.png" rel="apple-touch-icon" sizes="57x57">
    <link href="assets/favicon/apple-icon-60x60.png" rel="apple-touch-icon" sizes="60x60">
    <link href="assets/favicon/apple-icon-72x72.png" rel="apple-touch-icon" sizes="72x72">
    <link href="assets/favicon/apple-icon-76x76.png" rel="apple-touch-icon" sizes="76x76">
    <link href="assets/favicon/apple-icon-114x114.png" rel="apple-touch-icon" sizes="114x114">
    <link href="assets/favicon/apple-icon-120x120.png" rel="apple-touch-icon" sizes="120x120">
    <link href="assets/favicon/apple-icon-144x144.png" rel="apple-touch-icon" sizes="144x144">
    <link href="assets/favicon/apple-icon-152x152.png" rel="apple-touch-icon" sizes="152x152">
    <link href="assets/favicon/apple-icon-180x180.png" rel="apple-touch-icon" sizes="180x180">
    <link type="image/png" href="assets/favicon/android-icon-192x192.png" rel="icon" sizes="192x192">
    <link type="image/png" href="assets/favicon/favicon-32x32.png" rel="icon" sizes="32x32">
    <link type="image/png" href="assets/favicon/favicon-96x96.png" rel="icon" sizes="96x96">
    <link type="image/png" href="assets/favicon/favicon-16x16.png" rel="icon" sizes="16x16">
    <link href="assets/favicon/manifest.json" rel="manifest">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('css')
</head>

<body>
    {{-- Sidebar --}}
    @include('layouts.navigation')
    <div id="app" class="wrapper d-flex flex-column min-vh-100">
        <header class="header header-sticky p-0 mb-4">
            <div class="container-fluid border-bottom px-4">
                <button type="button" class="header-toggler" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
                    <i class="cil-menu"></i>
                </button>
                <ul class="header-nav d-none d-lg-flex">
                    <li class="nav-item"><a class="nav-link" href="{{ route('web.home') }}" target="_blank">Website</a></li>
                </ul>
                <ul class="header-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="cil-bell icon icon-lg"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="cil-list-rich icon icon-lg"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="cil-envelope-open icon icon-lg"></i>
                        </a>
                    </li>
                </ul>
                <ul class="header-nav">
                    <li class="nav-item py-1">
                        <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
                    </li>
                    <li class="nav-item dropdown">
                        <button type="button" class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" data-coreui-toggle="dropdown" aria-expanded="false">
                            <i class="cil-contrast theme-icon-active"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center" data-coreui-theme-value="light">
                                    <i class="cil-sun me-3"></i>Light
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center" data-coreui-theme-value="dark">
                                    <i class="cil-moon me-3"></i>Dark
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center active" data-coreui-theme-value="auto">
                                    <i class="cil-contrast me-3"></i>Auto
                                </button>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item py-1">
                        <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
                    </li>
                    <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-md">
                                <img class="avatar-img" src="{{ auth('web')->user()->profile_photo_url }}" alt="{{ auth('web')->user()->name }}">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">Account</div>
                            <a class="dropdown-item" href="#">
                                <i class="cil-bell icon me-2"></i> Updates<span class="badge badge-sm bg-info ms-2">42</span>
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="cil-envelope-open icon me-2"></i> Messages<span class="badge badge-sm bg-success ms-2">42</span>
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="cil-task icon me-2"></i> Tasks<span class="badge badge-sm bg-danger ms-2">42</span>
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="cil-comment-square icon me-2"></i> Comments<span class="badge badge-sm bg-warning ms-2">42</span>
                            </a>
                            <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                                <div class="fw-semibold">Settings</div>
                            </div>
                            <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                <i class="cil-user icon me-2"></i> {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="cil-settings icon me-2"></i> Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="cil-credit-card icon me-2"></i> Payments<span class="badge badge-sm bg-secondary ms-2">42</span>
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="cil-file icon me-2"></i> Projects<span class="badge badge-sm bg-primary ms-2">42</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <i class="cil-lock-locked icon me-2"></i> Lock Account
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="cil-account-logout icon me-2"></i> {{ __('Log Out') }}
                            </a>

                            <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="container-fluid px-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-0">
                        {!! $breadcrumb ?? '<li class="breadcrumb-item active">' . __('Untitled Module') . '</li>' !!}
                    </ol>
                </nav>
            </div>
        </header>
        <x-admin.notifications />
        <main class="body flex-grow-1">
            {{ $slot }}
        </main>
        <footer class="footer px-4">
            <div>Copyright &copy; {{ now()->year }} <a href="https://github.com/xSirLalo" target="_blank">
                    Eduardo Cauich</a>
                {{ __('All rights reserved.') }}
            </div>
            <div class="d-none d-sm-inline-block float-right">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </div>
        </footer>
    </div>

    <script>
        const header = document.querySelector('header.header');

        document.addEventListener('scroll', () => {
            if (header) {
                header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
        });
    </script>

    @stack('js')
</body>

</html>

</html>

<nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('web.home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button type="button" class="navbar-toggler" data-coreui-toggle="offcanvas" data-coreui-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="offcanvasNavbar" class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasNavbarLabel" class="offcanvas-title">Menú</h5>
                <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('web.home') }}" aria-current="page">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

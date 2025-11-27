<div id="sidebar" class="sidebar sidebar-dark sidebar-fixed border-end">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <svg class="sidebar-brand-full" alt="CoreUI Logo" width="88" height="32">
                <use xlink:href="{{ asset('assets/brand/coreui.svg#full') }}"></use>
            </svg>
            <svg class="sidebar-brand-narrow" alt="CoreUI Logo" width="32" height="32">
                <use xlink:href="{{ asset('assets/brand/coreui.svg#signet') }}"></use>
            </svg>
        </div>
        <button type="button" class="btn-close d-lg-none" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="nav-icon cil-speedometer"></i> {{ __('Dashboard') }}
            </a>
        </li>
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <button type="button" class="sidebar-toggler" data-coreui-toggle="unfoldable"></button>
    </div>
</div>

<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="scrollbar-sidebar ">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu mb-5">
                <li>
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'mm-active' : '' }}">
                        <i class="fas fa-chart-line"></i>
                        {{ __('dashboard') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('companies.index') }}"
                        class="{{ request()->routeIs('companies.index') ? 'mm-active' : '' }}">
                        <i class="fas fa-building"></i>
                        {{ __('company') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('employees.index') }}"
                        class="{{ request()->routeIs('employees.index') ? 'mm-active' : '' }}">
                        <i class="fas fa-users"></i>
                        {{ __('employee') }}
                    </a>
                </li>
            </ul>

        </div>
    </div>
</div>

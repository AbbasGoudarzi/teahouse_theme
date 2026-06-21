<header class="app-header sticky-top">
    <h1 class="page-title">@yield('page-title', 'داشبورد')</h1>
    @hasSection('header-right')
        @yield('header-right')
    @else
        <div class="dropdown">
            <button type="button" class="header-icon" id="profileMenu"
                    data-bs-toggle="dropdown" aria-expanded="false" aria-label="پروفایل">
                <i class="bi bi-person"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end profile-menu" aria-labelledby="profileMenu">
                <li><a class="dropdown-item" href="{{ route('settings.index') }}"><i class="bi bi-gear"></i> تنظیمات</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="{{ route('login') }}" onclick="logout(event)"><i class="bi bi-box-arrow-right"></i> خروج</a></li>
            </ul>
        </div>
    @endif
</header>

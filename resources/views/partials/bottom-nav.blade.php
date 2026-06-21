<nav class="bottom-nav">
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door-fill"></i>
        <span>داشبورد</span>
    </a>
    <a href="{{ route('attendance.index') }}" class="nav-item {{ request()->routeIs('attendance.*') ? 'active' : '' }}">
        <i class="bi bi-check2-square"></i>
        <span>حضور و غیاب</span>
    </a>
    <a href="{{ route('personnel.index') }}" class="nav-item {{ request()->routeIs('personnel.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i>
        <span>پرسنل</span>
    </a>
    <a href="{{ route('shifts.index') }}" class="nav-item {{ request()->routeIs('shifts.*') ? 'active' : '' }}">
        <i class="bi bi-calendar-week"></i>
        <span>شیفت‌ها</span>
    </a>
</nav>

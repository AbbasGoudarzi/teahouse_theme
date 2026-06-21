@extends('layouts.auth')

@section('title', 'ورود | مدیریت چایخانه')

@section('content')

<div class="login-brand">
    <div class="brand-logo">
        <i class="bi bi-cup-hot-fill"></i>
    </div>
    <h1 class="brand-title">مدیریت چایخانه</h1>
    <div class="brand-sub">پنل مدیریت پرسنل و شیفت‌ها</div>
</div>

<div class="login-card">
    <h2 class="login-heading">ورود به حساب</h2>
    <p class="login-desc">برای ادامه، شماره موبایل و رمز عبور خود را وارد کنید.</p>

    <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
        @csrf

        <div class="login-field">
            <label for="mobile" class="form-label">شماره موبایل</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                       id="mobile" name="mobile" value="{{ old('mobile') }}"
                       inputmode="numeric" maxlength="11" placeholder="۰۹۱۲۳۴۵۶۷۸۹"
                       autocomplete="tel" required>
            </div>
            @error('mobile')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="login-field">
            <label for="password" class="form-label">رمز عبور</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="password" name="password"
                       placeholder="••••••••" autocomplete="current-password" required>
                <button class="btn toggle-pass" type="button" id="togglePass"
                        aria-label="نمایش رمز عبور">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-login">
            <i class="bi bi-box-arrow-in-left"></i>
            ورود
        </button>
    </form>
</div>

<div class="login-footer">© {{ jdate('Y') }} — تمامی حقوق محفوظ است</div>

@endsection

@push('scripts')
<script>
(function () {
    var toggle = document.getElementById('togglePass');
    var pass = document.getElementById('password');
    if (toggle && pass) {
        toggle.addEventListener('click', function () {
            var isText = pass.type === 'text';
            pass.type = isText ? 'password' : 'text';
            toggle.querySelector('i').className = isText ? 'bi bi-eye' : 'bi bi-eye-slash';
            toggle.setAttribute('aria-label', isText ? 'نمایش رمز عبور' : 'مخفی کردن رمز عبور');
        });
    }
})();
</script>
@endpush

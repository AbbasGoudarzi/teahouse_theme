@extends('layouts.app')

@section('title', 'تنظیمات | مدیریت چایخانه')
@section('page-title', 'تنظیمات')

@section('header-right')
<a href="{{ route('dashboard') }}" class="back-btn" aria-label="بازگشت"><i class="bi bi-arrow-left"></i></a>
@endsection

@section('content')

<div class="form-card">
    <div class="settings-section-title">
        <i class="bi bi-shield-lock"></i> تغییر رمز عبور
    </div>

    <div class="settings-alert" id="passwordAlert" role="alert"></div>

    <form method="POST" action="{{ route('password.update') }}" id="passwordForm" novalidate>
        @csrf
        @method('PUT')

        <div class="password-field">
            <label for="currentPassword" class="form-label">رمز عبور فعلی</label>
            <div class="input-wrap">
                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                       id="currentPassword" name="current_password"
                       placeholder="••••••••" autocomplete="current-password">
                <button type="button" class="toggle-eye" onclick="togglePassword(this)"
                        aria-label="نمایش رمز عبور"><i class="bi bi-eye"></i></button>
            </div>
            @error('current_password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="password-field">
            <label for="newPassword" class="form-label">رمز عبور جدید</label>
            <div class="input-wrap">
                <input type="password" class="form-control @error('password') is-invalid @enderror"
                       id="newPassword" name="password"
                       placeholder="حداقل ۶ کاراکتر" autocomplete="new-password">
                <button type="button" class="toggle-eye" onclick="togglePassword(this)"
                        aria-label="نمایش رمز عبور"><i class="bi bi-eye"></i></button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="password-field">
            <label for="confirmPassword" class="form-label">تکرار رمز عبور جدید</label>
            <div class="input-wrap">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                       id="confirmPassword" name="password_confirmation"
                       placeholder="رمز جدید را دوباره وارد کنید" autocomplete="new-password">
                <button type="button" class="toggle-eye" onclick="togglePassword(this)"
                        aria-label="نمایش رمز عبور"><i class="bi bi-eye"></i></button>
            </div>
        </div>

        <button type="submit" class="btn btn-submit">
            <i class="bi bi-check2-circle"></i> ثبت رمز عبور جدید
        </button>
    </form>
</div>

@endsection

@push('scripts')
<script>
function togglePassword(btn) {
    var input = btn.previousElementSibling;
    var isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.querySelector('i').className = isText ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@endpush

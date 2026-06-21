@extends('layouts.app')

@section('title', 'افزودن پرسنل | مدیریت چایخانه')
@section('page-title', 'افزودن پرسنل')

@section('header-right')
<a href="{{ route('personnel.index') }}" class="back-btn" aria-label="بازگشت"><i class="bi bi-arrow-left"></i></a>
@endsection

@section('content')

<form method="POST" action="{{ route('personnel.store') }}" onsubmit="return false;">
    @csrf

    <div class="mb-3">
        <label class="form-label">نام و نام خانوادگی</label>
        <input type="text" class="form-control @error('full_name') is-invalid @enderror"
               name="full_name" value="{{ old('full_name') }}" placeholder="مثلاً علی رضایی">
        @error('full_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">شماره موبایل</label>
        <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
               name="mobile" value="{{ old('mobile') }}" placeholder="09xxxxxxxxx" dir="ltr">
        @error('mobile')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">چایخانه</label>
        <select class="form-select @error('branch_id') is-invalid @enderror" name="branch_id">
            <option selected disabled>انتخاب چایخانه...</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>
        @error('branch_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">تاریخ تولد</label>
        <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
               name="birth_date" value="{{ old('birth_date') }}">
        @error('birth_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-submit">
        <i class="bi bi-check2-circle"></i> ثبت پرسنل
    </button>
</form>

@endsection

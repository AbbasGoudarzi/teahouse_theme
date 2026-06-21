@extends('layouts.app')

@section('title', 'افزودن شیفت | مدیریت چایخانه')
@section('page-title', 'افزودن شیفت')

@section('header-right')
<a href="{{ route('shifts.index') }}" class="back-btn" aria-label="بازگشت"><i class="bi bi-arrow-left"></i></a>
@endsection

@section('content')

<form method="POST" action="{{ route('shifts.store') }}" onsubmit="return false;">
    @csrf

    <div class="form-card">
        <div class="row g-2">
            <div class="col-7">
                <label class="form-label">تاریخ شیفت</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror"
                       name="date" value="{{ old('date') }}">
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-5">
                <label class="form-label">تاخیر مجاز (دقیقه)</label>
                <input type="number" class="form-control @error('allowed_delay') is-invalid @enderror"
                       name="allowed_delay" value="{{ old('allowed_delay', 30) }}" min="0">
                @error('allowed_delay')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <h2 class="section-title">انتخاب شعب و پاس‌ها</h2>

    @foreach($branches as $branch)
    <div class="branch-pick" id="branch{{ $branch->id }}">
        <div class="branch-header">
            <input class="form-check-input" type="checkbox" id="b{{ $branch->id }}"
                   onchange="toggleBranch('branch{{ $branch->id }}', this.checked)">
            <label for="b{{ $branch->id }}">{{ $branch->name }}</label>
            <i class="bi bi-chevron-down chevron"></i>
        </div>
        <div class="branch-body">
            @foreach($shifts_template as $passIndex => $pass)
            <div class="pass-block">
                <div class="pass-check">
                    <input class="form-check-input" type="checkbox" id="b{{ $branch->id }}p{{ $passIndex }}"
                           {{ $passIndex < 2 ? 'checked' : '' }}
                           onchange="togglePass('b{{ $branch->id }}p{{ $passIndex }}times', this.checked)">
                    <label for="b{{ $branch->id }}p{{ $passIndex }}">{{ $pass['label'] }}</label>
                </div>
                <div class="pass-times {{ $passIndex < 2 ? 'show' : '' }}" id="b{{ $branch->id }}p{{ $passIndex }}times">
                    <div class="time-field">
                        <label class="form-label">شروع</label>
                        <input type="time" class="form-control" name="passes[{{ $branch->id }}][{{ $passIndex }}][start]"
                               value="{{ $pass['start'] }}">
                    </div>
                    <div class="time-field">
                        <label class="form-label">پایان</label>
                        <input type="time" class="form-control" name="passes[{{ $branch->id }}][{{ $passIndex }}][end]"
                               value="{{ $pass['end'] }}">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <button type="submit" class="btn btn-submit mt-2">
        <i class="bi bi-check2-circle"></i> ثبت شیفت
    </button>
</form>

@endsection

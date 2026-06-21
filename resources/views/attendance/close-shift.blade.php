@extends('layouts.app')

@section('title', 'تایید و بستن شیفت | مدیریت چایخانه')
@section('page-title', 'تایید و بستن شیフト')

@section('header-right')
<button class="back-btn" onclick="history.back()" aria-label="بازگشت"><i class="bi bi-arrow-left"></i></button>
@endsection

@section('content')

<div class="cs-subtitle">
    <i class="bi bi-calendar-check"></i>
    شیフト {{ $shift->formatted_date }}
</div>

<div class="cs-card warn">
    <div class="cs-header">
        <i class="bi bi-exclamation-triangle-fill"></i>
        افرادی که ورود زده‌اند اما خروج ندارند
    </div>
    <div class="cs-body">
        <div class="cs-selectall">
            <input class="form-check-input select-all-check" type="checkbox" id="selAll1"
                   checked onclick="toggleSelectAll(this, '#csList1')">
            <label for="selAll1">انتخاب همه</label>
        </div>

        <div class="cs-list" id="csList1">
            @foreach($no_exit_personnel as $person)
            <div class="cs-row">
                <input class="form-check-input row-check" type="checkbox" checked
                       name="no_exit[]" value="{{ $person->id }}">
                <span class="cs-name">{{ $person->full_name }}</span>
                <span class="cs-time"><i class="bi bi-box-arrow-in-left"></i> ورود: {{ $person->entry_time }}</span>
                <i class="bi bi-check-circle-fill cs-check-icon"></i>
            </div>
            @endforeach
        </div>

        <button class="btn-bulk warn" onclick="bulkResolve(this, '#csList1', 'checkout')">
            <i class="bi bi-box-arrow-right"></i> ثبت خروج برای همه در ساعت پایان شیفت (۲۳:۰۰)
        </button>
    </div>
</div>

<div class="cs-card danger">
    <div class="cs-header">
        <i class="bi bi-x-octagon-fill"></i>
        افرادی که وضعیتشان نامشخص است (بدون هیچ ثبتی)
    </div>
    <div class="cs-body">
        <div class="cs-selectall">
            <input class="form-check-input select-all-check" type="checkbox" id="selAll2"
                   checked onclick="toggleSelectAll(this, '#csList2')">
            <label for="selAll2">انتخاب همه</label>
        </div>

        <div class="cs-list" id="csList2">
            @foreach($unknown_personnel as $person)
            <div class="cs-row">
                <input class="form-check-input row-check" type="checkbox" checked
                       name="unknown[]" value="{{ $person->id }}">
                <span class="cs-name">{{ $person->full_name }}</span>
                <i class="bi bi-check-circle-fill cs-check-icon"></i>
            </div>
            @endforeach
        </div>

        <button class="btn-bulk danger" onclick="bulkResolve(this, '#csList2', 'absent')">
            <i class="bi bi-person-x-fill"></i> ثبت غیبت برای همه این افراد
        </button>

        <div class="cs-success alert alert-success py-2 px-3 mb-0" style="display:none;">
            <i class="bi bi-check-circle-fill"></i> غیبت افراد انتخاب‌شده با موفقیت ثبت شد.
        </div>
    </div>
</div>

<button class="btn-close-shift" id="btnCloseShift" disabled onclick="confirmCloseShift()">
    <i class="bi bi-lock-fill"></i> بستن و تایید نهایی شیفت
</button>

@endsection

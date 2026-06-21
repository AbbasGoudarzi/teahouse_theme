@extends('layouts.app')

@section('title', 'حضور و غیاب | مدیریت چایخانه')
@section('page-title', 'حضور و غیاب')

@section('content')

<div class="att-shift-select">
    <label class="form-label"><i class="bi bi-calendar-week"></i> انتخاب شیفت</label>
    <select class="form-select" id="shiftSelect" onchange="onShiftChange(this)">
        @foreach($shifts as $shift)
            <option data-past="{{ $shift->is_past ? 'true' : 'false' }}"
                    value="{{ $shift->id }}" {{ $shift->is_current ? 'selected' : '' }}>
                {{ $shift->formatted_date }}{{ $shift->is_current ? ' (شیفت جاری)' : '' }}
            </option>
        @endforeach
    </select>
</div>

<div class="past-warning" id="pastWarning" style="{{ $is_past_shift ? '' : 'display:none' }}">
    <i class="bi bi-exclamation-triangle-fill"></i>
    شما در حال ویرایش اطلاعات گذشته هستید.
</div>

<div class="search-bar">
    <i class="bi bi-search search-icon"></i>
    <input type="text" class="form-control" id="attSearch" placeholder="جستجوی نام پرسنل..."
           oninput="filterAttendance(this)">
</div>

<div class="att-empty text-danger" id="attEmpty" style="display:none;">
    <i class="bi bi-search"></i> هیچ پرسنلی با این نام یافت نشد.
</div>

<h2 class="section-title">لیست حضور و غیاب پرسنل</h2>

@foreach($personnel as $person)
<div class="att-card">
    <div class="att-info">
        <div class="name">{{ $person->full_name }}</div>
        <div class="times">
            @if($person->entry_time)
                <span class="entry-time"><i class="bi bi-box-arrow-in-left"></i> ورود: {{ $person->entry_time }}</span>
            @else
                <span class="entry-time not-set"><i class="bi bi-box-arrow-in-left"></i> ورود: ثبت نشده</span>
            @endif

            @if($person->exit_time)
                <span class="exit-time"><i class="bi bi-box-arrow-right"></i> خروج: {{ $person->exit_time }}</span>
            @else
                <span class="exit-time not-set"><i class="bi bi-box-arrow-right"></i> خروج: ثبت نشده</span>
            @endif
        </div>
    </div>
    <div class="att-actions">
        @if(!$person->entry_time)
            <button class="btn-quick" data-state="in" onclick="quickAttendance(this)">
                <i class="bi bi-box-arrow-in-left"></i> ثبت ورود
            </button>
        @elseif(!$person->exit_time)
            <button class="btn-quick checkout" data-state="out" onclick="quickAttendance(this)">
                <i class="bi bi-box-arrow-right"></i> ثبت خروج
            </button>
        @else
            <button class="btn-quick done" data-state="done" onclick="quickAttendance(this)">
                <i class="bi bi-check-lg"></i> ثبت شد
            </button>
        @endif
        <button class="btn-detail" onclick="openActionModal('{{ $person->full_name }}')" aria-label="جزئیات">
            <i class="bi bi-three-dots-vertical"></i>
        </button>
    </div>
</div>
@endforeach

<div class="end-shift-sep">
    <a href="{{ route('attendance.close-shift') }}" class="btn btn-end-shift">
        <i class="bi bi-door-closed"></i> اتمام شیفت
    </a>
</div>

@endsection

@section('modals')
<div class="modal fade action-modal" id="actionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    ثبت وضعیت: <span id="modalEmpName">—</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="بستن"></button>
            </div>
            <div class="modal-body">
                <form onsubmit="return false;">
                    <div class="radio-card active">
                        <input class="form-check-input" type="radio" name="actionType" id="optPresent"
                               value="present" checked onchange="onActionTypeChange(this)">
                        <label for="optPresent">ثبت حضور</label>
                        <i class="bi bi-person-check-fill opt-icon present"></i>
                    </div>

                    <div class="present-fields show" id="presentFields">
                        <label class="form-label">پاس کاری</label>
                        <select class="form-select">
                            <option value="1" selected>پاس ۱ (۱۵:۳۰ - ۲۰:۰۰)</option>
                            <option value="2">پاس ۲ (۱۹:۳۰ - ۲۳:۰۰)</option>
                        </select>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="form-label">ساعت ورود</label>
                                <input type="time" class="form-control" value="15:30">
                            </div>
                            <div class="col-6">
                                <label class="form-label">ساعت خروج</label>
                                <input type="time" class="form-control" value="20:00">
                            </div>
                        </div>
                    </div>

                    <div class="radio-card mt-2">
                        <input class="form-check-input" type="radio" name="actionType" id="optLeave"
                               value="leave" onchange="onActionTypeChange(this)">
                        <label for="optLeave">ثبت مرخصی</label>
                        <i class="bi bi-airplane-fill opt-icon leave"></i>
                    </div>

                    <div class="radio-card">
                        <input class="form-check-input" type="radio" name="actionType" id="optAbsent"
                               value="absent" onchange="onActionTypeChange(this)">
                        <label for="optAbsent">ثبت غیبت</label>
                        <i class="bi bi-person-x-fill opt-icon absent"></i>
                    </div>

                    <button type="submit" class="btn btn-save mt-2" data-bs-dismiss="modal">
                        <i class="bi bi-check2-circle"></i> ذخیره
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

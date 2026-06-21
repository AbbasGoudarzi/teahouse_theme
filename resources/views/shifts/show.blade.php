@extends('layouts.app')

@section('title', 'جزئیات شیفت | مدیریت چایخانه')
@section('page-title', 'جزئیات شیفت')

@section('header-right')
<a href="{{ route('shifts.index') }}" class="back-btn" aria-label="بازگشت"><i class="bi bi-arrow-left"></i></a>
@endsection

@section('content')

<div class="welcome-box mb-2">
    <h2 class="section-title">شیفت {{ $shift->day_name }} {{ $shift->formatted_date }} — {{ $shift->branch->name }}</h2>
</div>

<div class="shift-detail-stats">
    <div class="s-box">
        <i class="bi bi-person-check-fill ic ic-present"></i>
        <div class="num">{{ toPersianNum($shift->present_count) }}</div><div class="lbl">حاضر</div>
    </div>
    <div class="s-box">
        <i class="bi bi-person-x-fill ic ic-absent"></i>
        <div class="num">{{ toPersianNum($shift->absent_count) }}</div><div class="lbl">غایب</div>
    </div>
    <div class="s-box">
        <i class="bi bi-airplane-fill ic ic-leave"></i>
        <div class="num">{{ toPersianNum($shift->leave_count) }}</div><div class="lbl">مرخصی</div>
    </div>
    <div class="s-box">
        <i class="bi bi-hourglass-split ic ic-unknown"></i>
        <div class="num">{{ toPersianNum($shift->late_count) }}</div><div class="lbl">تاخیر</div>
    </div>
    <div class="s-box">
        <i class="bi bi-check2-circle ic ic-done"></i>
        <div class="num">{{ toPersianNum($shift->completed_count) }}</div><div class="lbl">اتمام شیفت</div>
    </div>
    <div class="s-box">
        <i class="bi bi-people-fill ic ic-done"></i>
        <div class="num">{{ toPersianNum($shift->total_personnel) }}</div><div class="lbl">کل پرسنل</div>
    </div>
</div>

<h2 class="section-title">پاس‌های این شیفت</h2>
<div class="form-card">
    @foreach($shift->passes as $pass)
        <div class="d-flex justify-content-between">
            <span>{{ $pass->name }}</span>
            <span class="text-muted">{{ $pass->start_time }} - {{ $pass->end_time }}</span>
        </div>
        @unless($loop->last)
            <hr class="my-2">
        @endunless
    @endforeach
</div>

<h2 class="section-title">گزارش افراد این شیفت</h2>

<div class="filter-bar">
    <div class="row g-2">
        <div class="col-8">
            <input type="text" class="form-control" placeholder="جستجوی نام پرسنل...">
        </div>
        <div class="col-4">
            <button class="btn btn-filter" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#shiftFilterCanvas">
                <i class="bi bi-funnel-fill"></i>
                فیلتر
            </button>
        </div>
    </div>
</div>

@foreach($shift->reports as $report)
<div class="report-card">
    <div class="rc-info">
        <div class="name">{{ $report->personnel_name }}</div>
        <div class="meta">
            <span><i class="bi bi-shop"></i> {{ $report->branch_name }}</span>
            <span><i class="bi bi-clock-history"></i> {{ $report->shift_name }}</span>
            @if($report->entry_time)
                <span><i class="bi bi-box-arrow-in-left"></i> ورود: {{ $report->entry_time }}</span>
            @endif
            @if($report->exit_time)
                <span><i class="bi bi-box-arrow-right"></i> خروج: {{ $report->exit_time }}</span>
            @endif
            @if($report->status === 'absent')
                <span class="text-muted"><i class="bi bi-dash-circle"></i> بدون تردد</span>
            @endif
            @if($report->status === 'leave')
                <span class="text-info"><i class="bi bi-info-circle"></i> مرخصی استحقاقی</span>
            @endif
        </div>
    </div>
    @if($report->status === 'present')
        <span class="badge bg-success rc-badge">حاضر</span>
    @elseif($report->status === 'late')
        <span class="badge bg-warning text-dark rc-badge">تاخیر</span>
    @elseif($report->status === 'absent')
        <span class="badge bg-danger rc-badge">غایب</span>
    @elseif($report->status === 'leave')
        <span class="badge bg-info text-dark rc-badge">مرخصی</span>
    @endif
</div>
@endforeach

@endsection

@section('modals')
<div class="offcanvas offcanvas-bottom filter-canvas" tabindex="-1" id="shiftFilterCanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"><i class="bi bi-funnel"></i> فیلتر افراد</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
    </div>
    <div class="offcanvas-body">
        <form method="GET" action="{{ route('shifts.show', $shift->id) }}">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">چایخانه</label>
                    <select class="form-select" name="branch">
                        <option value="">همه شعب</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">وضعیت حضور</label>
                    <select class="form-select" name="status">
                        <option value="">همه وضعیت‌ها</option>
                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>حاضر</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>غایب</option>
                        <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>تاخیر</option>
                        <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>مرخصی</option>
                    </select>
                </div>
                <div class="col-12">
                    <button class="btn btn-apply" type="submit">
                        <i class="bi bi-check2-circle"></i> اعمال فیلتر
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'گزارش‌ها | مدیریت چایخانه')
@section('page-title', 'گزارش‌ها')

@section('content')

<div class="filter-bar">
    <div class="row g-2">
        <div class="col-8">
            <input type="text" class="form-control" placeholder="جستجوی نام کارمند...">
        </div>
        <div class="col-4">
            <button class="btn btn-filter" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#filterCanvas">
                <i class="bi bi-funnel-fill"></i>
                فیلتر
            </button>
        </div>
    </div>
</div>

<h2 class="section-title">لیست گزارش‌ها</h2>

<div class="accordion report-accordion" id="reportsAccordion">
    @foreach($reports as $index => $report)
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#rep{{ $index }}">
                <div class="report-summary">
                    <span class="emp-name">{{ $report->personnel_name }}</span>
                    <span class="emp-meta">
                        <span><i class="bi bi-shop"></i> {{ $report->branch_name }}</span>
                        <span><i class="bi bi-clock-history"></i> {{ $report->shift_name }}</span>
                        @if($report->status === 'present')
                            <span class="badge bg-success">حاضر</span>
                        @elseif($report->status === 'late')
                            <span class="badge bg-warning text-dark">تاخیر</span>
                        @elseif($report->status === 'absent')
                            <span class="badge bg-danger">غایب</span>
                        @elseif($report->status === 'leave')
                            <span class="badge bg-info text-dark">مرخصی</span>
                        @endif
                    </span>
                </div>
            </button>
        </h2>
        <div id="rep{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#reportsAccordion">
            <div class="report-detail">
                <div class="detail-row">
                    <span class="label"><i class="bi bi-box-arrow-in-left"></i> ساعت ورود</span>
                    <span class="value">{{ $report->entry_time ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label"><i class="bi bi-box-arrow-right"></i> ساعت خروج</span>
                    <span class="value">{{ $report->exit_time ?? '—' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label"><i class="bi bi-hourglass-split"></i> مدت تاخیر</span>
                    @if($report->delay_minutes)
                        <span class="value text-warning">{{ toPersianNum($report->delay_minutes) }} دقیقه</span>
                    @else
                        <span class="value">—</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection

@section('modals')
<div class="offcanvas offcanvas-bottom filter-canvas" tabindex="-1" id="filterCanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title"><i class="bi bi-funnel"></i> فیلتر گزارش‌ها</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
    </div>
    <div class="offcanvas-body">
        <form method="GET" action="{{ route('reports.index') }}">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">شعبه</label>
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
                    <label class="form-label">تاریخ</label>
                    <input type="date" class="form-control" name="date" value="{{ request('date') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">وضعیت</label>
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

@extends('layouts.app')

@section('title', 'جزئیات پرسنل | مدیریت چایخانه')
@section('page-title', 'جزئیات پرسنل')

@section('header-right')
<a href="{{ route('personnel.index') }}" class="back-btn" aria-label="بازگشت"><i class="bi bi-arrow-left"></i></a>
@endsection

@section('content')

<div class="person-card mb-3">
    <div class="avatar"><i class="bi bi-person-fill"></i></div>
    <div class="person-info">
        <div class="name">{{ $person->full_name }}</div>
        <div class="sub">{{ $person->branch->name }} · {{ $person->mobile }}</div>
    </div>
</div>

<div class="detail-stats">
    <div class="d-stat">
        <div class="num">{{ toPersianNum($person->assigned_shifts) }}</div>
        <div class="lbl">شیفت موظف</div>
    </div>
    <div class="d-stat">
        <div class="num">{{ toPersianNum($person->completed_shifts) }}</div>
        <div class="lbl">انجام شده</div>
    </div>
    <div class="d-stat">
        <div class="num">{{ toPersianNum($person->leave_count) }}</div>
        <div class="lbl">مرخصی</div>
    </div>
    <div class="d-stat">
        <div class="num">{{ toPersianNum($person->absent_count) }}</div>
        <div class="lbl">غیبت</div>
    </div>
</div>

<h2 class="section-title">سوابق حضور</h2>

@foreach($person->attendance_history as $record)
<div class="history-row st-{{ $record->status }}">
    <div class="h-top">
        <div class="h-place"><i class="bi bi-shop"></i> {{ $record->branch_name }}</div>
        <div class="h-date">{{ $record->formatted_date }}</div>
    </div>
    <div class="h-times">
        @if($record->status === 'present' || $record->status === 'late')
            <span><i class="bi bi-box-arrow-in-left"></i> ورود: {{ $record->entry_time }}</span>
            <span><i class="bi bi-box-arrow-right"></i> خروج: {{ $record->exit_time }}</span>
        @elseif($record->status === 'leave')
            <span><i class="bi bi-info-circle"></i> مرخصی استحقاقی</span>
        @elseif($record->status === 'absent')
            <span><i class="bi bi-x-circle"></i> غیبت ثبت شده</span>
        @endif
    </div>
</div>
@endforeach

@endsection

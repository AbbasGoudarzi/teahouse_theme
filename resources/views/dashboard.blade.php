@extends('layouts.app')

@section('title', 'داشبورد | مدیریت چایخانه')
@section('page-title', 'داشبورد')

@section('content')

<div class="welcome-box">
    <div class="hello">سلام، مدیر عزیز 👋</div>
    <div class="today-date">
        <i class="bi bi-calendar3"></i>
        <span>{{ jdate('l, j F j Y') }}</span>
    </div>
</div>

<h2 class="section-title">وضعیت شیفت {{ jdate('j F Y') }}</h2>

<div class="row g-0">
    @foreach($branches as $branch)
    <div class="col-12">
        <div class="branch-card">
            <div class="branch-name">
                <i class="bi bi-shop"></i>
                {{ $branch->name }}
                <span class="total-badge">کل پرسنل: {{ toPersianNum($branch->total_personnel) }}</span>
            </div>
            <div class="stat-grid">
                <div class="stat-box">
                    <i class="bi bi-person-check-fill stat-icon ic-present"></i>
                    <div class="stat-value">{{ toPersianNum($branch->present_count) }}</div>
                    <div class="stat-label">حاضر</div>
                </div>
                <div class="stat-box">
                    <i class="bi bi-airplane-fill stat-icon ic-leave"></i>
                    <div class="stat-value">{{ toPersianNum($branch->leave_count) }}</div>
                    <div class="stat-label">مرخصی</div>
                </div>
                <div class="stat-box">
                    <i class="bi bi-person-x-fill stat-icon ic-absent"></i>
                    <div class="stat-value">{{ toPersianNum($branch->absent_count) }}</div>
                    <div class="stat-label">غیبت</div>
                </div>
                <div class="stat-box">
                    <i class="bi bi-check2-circle stat-icon ic-done"></i>
                    <div class="stat-value">{{ toPersianNum($branch->completed_count) }}</div>
                    <div class="stat-label">اتمام شیفت</div>
                </div>
                <div class="stat-box">
                    <i class="bi bi-question-circle-fill stat-icon ic-unknown"></i>
                    <div class="stat-value">{{ toPersianNum($branch->unknown_count) }}</div>
                    <div class="stat-label">نامشخص</div>
                </div>
                <div class="stat-box">
                    <i class="bi bi-people-fill stat-icon ic-done"></i>
                    <div class="stat-value">{{ toPersianNum($branch->total_personnel) }}</div>
                    <div class="stat-label">کل پرسنل</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection

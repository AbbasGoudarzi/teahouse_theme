@extends('layouts.app')

@section('title', 'شیفت‌ها | مدیریت چایخانه')
@section('page-title', 'مدیریت شیفت‌ها')

@section('content')

<h2 class="section-title">شیفت‌های تعریف‌شده</h2>

<div class="shift-list">
    @foreach($shifts as $shift)
    <div class="shift-card">
        <div class="s-date">
            <span class="day">{{ $shift->day_name }}</span>
            <span class="date">{{ $shift->formatted_date }}</span>
        </div>
        <div class="s-actions">
            <a href="{{ route('shifts.show', $shift->id) }}" class="btn-icon view" aria-label="جزئیات"><i class="bi bi-eye"></i></a>
            <a href="{{ route('shifts.edit', $shift->id) }}" class="btn-icon edit" aria-label="ویرایش"><i class="bi bi-pencil"></i></a>
            <form method="POST" action="{{ route('shifts.destroy', $shift->id) }}" style="display:inline" onsubmit="return confirm('آیا از حذف این شیفت مطمئن هستید؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-icon del" aria-label="حذف"><i class="bi bi-trash"></i></button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<a href="{{ route('shifts.create') }}" class="fab" aria-label="افزودن شیفت">
    <i class="bi bi-plus-lg"></i>
</a>

@endsection

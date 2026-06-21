@extends('layouts.app')

@section('title', 'پرسنل | مدیریت چایخانه')
@section('page-title', 'پرسنل')

@section('content')

<div class="search-bar">
    <i class="bi bi-search search-icon"></i>
    <input type="text" class="form-control" placeholder="جستجوی نام کارمند...">
</div>

<h2 class="section-title">لیست کارکنان</h2>

@foreach($personnel as $person)
<div class="person-card">
    <div class="avatar"><i class="bi bi-person-fill"></i></div>
    <div class="person-info">
        <div class="name">{{ $person->full_name }}</div>
        <div class="sub">{{ $person->branch->name }} · {{ $person->mobile }}</div>
    </div>
    <div class="actions">
        <a href="{{ route('personnel.show', $person->id) }}" class="btn-icon view" aria-label="جزئیات"><i class="bi bi-eye"></i></a>
        <a href="{{ route('personnel.edit', $person->id) }}" class="btn-icon edit" aria-label="ویرایش"><i class="bi bi-pencil"></i></a>
        <form method="POST" action="{{ route('personnel.destroy', $person->id) }}" style="display:inline" onsubmit="return confirm('آیا از حذف این پرسنل مطمئن هستید؟')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-icon del" aria-label="حذف"><i class="bi bi-trash"></i></button>
        </form>
    </div>
</div>
@endforeach

<a href="{{ route('personnel.create') }}" class="fab" aria-label="افزودن پرسنل">
    <i class="bi bi-plus-lg"></i>
</a>

@endsection

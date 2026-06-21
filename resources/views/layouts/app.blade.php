<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#084738">
    <title>@yield('title', 'مدیریت چایخانه')</title>

    <link href="{{ asset('assets/vendor/bootstrap/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link href="{{ asset('assets/vendor/vazirmatn/vazirmatn.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

<div class="app-wrapper">

    @include('partials.header')

    <main class="main-content">
        @yield('content')
    </main>

    @include('partials.bottom-nav')

</div>

@include('partials.logout-modal')

@yield('modals')

<script src="{{ asset('assets/vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>

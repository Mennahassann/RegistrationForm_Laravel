<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() == 'ar') dir="rtl" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}"  rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>@yield('title', 'Unkown Page')</title>
</head>
<body>
        <header>
            @include('layout.header')
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
            @include('layout.footer')
        </footer>

        <script src="{{ asset('js/validations.js') }}"></script>
</body>
</html>

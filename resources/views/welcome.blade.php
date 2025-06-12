@extends('layout.master')
@section('title', __('auth.welcome_title'))

@section('content')
<body class="bg-light">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center text-center py-5">
        <div class="container" style="max-width: 750px;">
            <div class="d-flex justify-content-end mb-3">
                <form method="get" action="{{ route('lang.switch', ['locale' => 'en']) }}" class="me-2">
                    <button class="btn btn-outline-primary btn-sm" type="submit">English</button>
                </form>
                <form method="get" action="{{ route('lang.switch', ['locale' => 'ar']) }}" class="me-2">
                    <button class="btn btn-outline-primary btn-sm" type="submit">عربي</button>
                </form>
            </div>

            <h1 class="display-4 fw-bold text-primary mb-3">{{ __('auth.welcome_title') }}</h1>
            <p class="lead text-muted mb-4">
                {{ __('auth.welcome_message') }}
            </p>
            <a href="{{ route('register.form') }}" class="btn btn-primary btn-lg px-4 py-2">
                <i class="bi bi-person-plus-fill me-2"></i> {{ __('auth.register_now') }}
            </a>
        </div>
    </div>
</body>
@endsection

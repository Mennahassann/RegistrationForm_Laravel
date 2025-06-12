<header>
    <nav class="header" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="name">
            <i class="bi bi-person-circle"></i>
            <b>{{ __('auth.company_name') }}</b>
        </div>
        <ul class="list" style="list-style: none; padding: 0; margin: 0; display: flex; gap: 1rem; {{ app()->getLocale() == 'ar' ? 'flex-direction: row-reverse;' : '' }}">
            <li>
                <a href="{{ route('welcome.form') }}">
                    <i class="bi bi-house"></i>{{ __('auth.home') }}
                </a>
            </li>
            <li>
                <a href="{{ route('register.form') }}">
                    <i class="bi bi-person-plus"></i>{{ __('auth.register') }}
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-info-circle"></i>{{ __('auth.about') }}
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-envelope"></i>{{ __('auth.contact') }}
                </a>
            </li>
        </ul>
    </nav>
</header>



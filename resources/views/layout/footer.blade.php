<footer>
    <div class="footer" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div>
            <b>{{ __('auth.company_name') }}</b> &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }}
        </div>
        <div class="icon" style="{{ app()->getLocale() == 'ar' ? 'direction: rtl;' : '' }}">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-whatsapp"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
        </div>
    </div>
</footer>


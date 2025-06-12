@extends('layout.master')
@section('title', __('auth.register_title'))
@section('content')
<meta id="csrf-token" url="{{ url('') }}" token="{{ csrf_token() }}">
<style>
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear,
    input[type="password"]::-webkit-credentials-auto-fill-button {
        display: none;
        pointer-events: none;
        height: 0;
        width: 0;
    }
</style>
<body class="bg-light">
    <div class="min-vh-100 py-5 d-flex flex-column align-items-center justify-content-center">
        <div class="container" style="max-width: 850px;">
            <div class="text-center mb-4">
                <h1 class="text-primary fw-bold display-5">{{ __('auth.register_title') }}</h1>
                <p class="text-muted lead">{{ __('auth.register_subtitle') }}</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-bottom border-primary p-4">
                    <div class="d-flex align-items-center">
                        <div>
                            <h4 class="mb-0 fw-bold">{{ __('auth.registration_form') }}</h4>
                            <small class="text-muted">{{ __('auth.personal_info') }}</small>
                        </div>
                        <span class="ms-auto badge bg-primary rounded-pill">{{ __('auth.step') }}</span>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data" id="form" novalidate>
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('auth.full_name') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name"  value="{{ old('name') }}" id="fullname" class="form-control" placeholder="{{ __('auth.full_name') }}"  required>
                                </div>
                                <span class="error text-danger small" id="fullnameError"  data-required="{{ __('auth.full_name_required') }}" data-pattern="{{ __('auth.no_numbers_allowed') }}" ></span>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('auth.username') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-at"></i></span>
                                    <input type="text" name="username" value="{{ old('username') }}" id="username" class="form-control" placeholder="{{ __('auth.username') }}" required>
                                </div>
                                <span class="error text-danger small" id="usernameError" data-required="{{ __('auth.username_required') }}" data-pattern="{{ __('auth.username_invalid') }}" data-duplicated="{{ __('auth.username_duplicated') }}"></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('auth.password') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" value="{{ old('password') }}" id="password" class="form-control" placeholder="{{ __('auth.password') }}" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <span class="error text-danger small" id="passwordError" data-required="{{ __('auth.password_required') }}" data-length ="{{ __('auth.password_min') }}" data-digits="{{ __('auth.contain_digit') }}" data-letters="{{ __('auth.contain_letter') }}" data-chars="{{ __('auth.contain_special_char') }}" ></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('auth.confirm_password') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" id="confirm" class="form-control" placeholder="{{ __('auth.confirm_password') }}" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="bi bi-eye" id="toggleConfirmPasswordIcon"></i>
                                    </button>
                                </div>
                                <span class="error text-danger small" id="confirmError" data-required="{{ __('auth.confirm_password_required') }}"  data-match= "{{ __('auth.confirm_password_match') }}"></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('auth.phone') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="phone" value="{{ old('phone') }}" id ="phone" class="form-control" placeholder="{{ __('auth.phone') }}">
                                </div>
                                <span class="error text-danger small" id="phoneError" data-required="{{ __('auth.phone_required') }}" data-length= "{{ __('auth.phone_min') }}" data-valid="{{ __('auth.phone_invalid') }}" ></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('auth.whatsapp') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" id="whatsappNumber" class="form-control" placeholder="{{ __('auth.whatsapp') }}">
                                </div>
                                <span class="error text-danger small" id="numError" data-required="{{ __('auth.whatsapp_required') }}" data-pattern ="{{ __('auth.whatsapp_invalid') }}"></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('auth.email') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" value="{{ old('email') }}" id="email" class="form-control" placeholder="{{ __('auth.email') }}" required>
                                    <div class="invalid-feedback">{{ __('auth.email') }}</div>
                                </div>
                                <span class="error text-danger small" id="emailError" data-required="{{ __('auth.email_required') }}" data-pattern ="{{ __('auth.email_invalid') }}" data-duplicated="{{ __('auth.email_duplicated') }}"></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('auth.address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="address" value="{{ old('address') }}" id="address" class="form-control" placeholder="{{ __('auth.address') }}">
                                </div>
                                <span class="error text-danger small" id="addressError" data-required="{{ __('auth.address_required') }}" ></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">{{ __('auth.profile_image') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-image"></i></span>
                                    <input type="file" name="user_image" value="{{ old('user_image') }}" id="image" class="form-control">
                                </div>
                                <small class="text-muted">JPG or PNG, max 2MB</small>
                                <span class="error text-danger small" id="imageError" data-required="{{ __('auth.image_required') }}" ></span>
                            </div>

                        </div>

                        <div class="mt-4 d-flex justify-content-between align-items-center">
                            <div class="form-text text-muted"><i class="bi bi-shield-lock"></i> {{ __('auth.secure_data') }}</div>
                            <button type="submit" name="submitBtn" class="btn btn-primary px-4 py-2 d-flex align-items-center">
                                <i class="bi bi-person-plus me-2"></i> {{ __('auth.register_account') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        togglePassword.addEventListener('click', function () {
            const isVisible = passwordInput.type === 'text';
            passwordInput.type = isVisible ? 'password' : 'text';
            togglePasswordIcon.classList.toggle('bi-eye', isVisible);
            togglePasswordIcon.classList.toggle('bi-eye-slash', !isVisible);
        });

        const confirmInput = document.getElementById('confirm');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const toggleConfirmPasswordIcon = document.getElementById('toggleConfirmPasswordIcon');

        toggleConfirmPassword.addEventListener('click', function () {
            const isVisible = confirmInput.type === 'text';
            confirmInput.type = isVisible ? 'password' : 'text';
            toggleConfirmPasswordIcon.classList.toggle('bi-eye', isVisible);
            toggleConfirmPasswordIcon.classList.toggle('bi-eye-slash', !isVisible);
        });
    });
</script>
@endsection

@extends('layouts.auth')
@section('title', 'Kullanıcı Girişi')
@section('description', 'Kullanıcı Girişi. Türkpatent marka bülteni taramalarınızı otomatik yapın. Marka tescil takip hizmeti.')
@section('content')
    <div class="page-holder align-items-center py-4 bg-gray-100 vh-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 px-lg-4">
                    <div class="card">
                        <div class="card-header px-lg-5">
                            <div class="card-heading text-primary">{{ __('reset.reset-password') }}</div>
                        </div>
                        <div class="card-body p-lg-5">
                            <form method="POST" action="{{ route('password.update', ['locale' => app()->getLocale()]) }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('email') is-invalid @enderror" id="floatingInput" type="email" value="{{ $email ?? old('email') }}"
                                           placeholder="email@adresi.com" name="email" required autocomplete="email">
                                    <label for="floatingInput">{{ __('reset.email-address') }}</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password"
                                           placeholder="{{ __('reset.new-password') }}" required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ __('reset.password-confirmation-does-not-match') }}</strong>
                                    </span>
                                    @enderror
                                    <label for="floatingPassword">{{ __('reset.new-password') }}</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="password-confirm" type="password" name="password_confirmation"
                                           placeholder="{{ __('reset.confirm-password') }}" required autocomplete="current-password">
                                    <label for="floatingPassword">{{ __('reset.confirm-password') }}</label>
                                </div>
                                <button class="btn btn-primary btn-lg" type="submit">{{ __('reset.log-in') }}</button>
                            </form>
                        </div>
                        <div class="card-footer px-lg-5 py-lg-4">
                            <div class="text-sm text-muted">{{ __('reset.dont-have-an-account') }} <a href="{{ route('register', ['locale' => app()->getLocale()]) }}">{{ __('reset.register') }}</a>.
                                <span style="float: right"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5 ms-xl-auto px-lg-4 text-center text-primary"><img class="img-fluid mb-4"
                                                                                                width="300" src="{{ asset('assets/dashboard') }}/img/drawkit-illustration.svg" alt=""
                                                                                                style="transform: rotate(10deg)" alt="marka.legal">
                    <h1 class="mb-4">{{ __('passwords.register-and') }} <br class="d-none d-lg-inline">{{ __('passwords.your-brand-and-time') }} <br
                            class="d-none d-lg-inline">{{ __('passwords.protect') }}</h1>
                    <p class="lead text-muted">{{ __('passwords.scan-your-turkpatent') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

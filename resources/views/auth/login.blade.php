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
                        <div class="card-heading text-primary">{{ __('theme/login.card-title') }}</div>
                    </div>
                    <div class="card-body p-lg-5 resend-verification-email">
                        @if (Session::has('message'))
                        <div class="alert alert-{{ (Session::get('code') == 'success') ? 'success' : 'danger' }}">
                            {{ Session::get('message') }}
                        </div>
                        @endif
                        @if(Session::has('code') && Session::get('code') == 're-verification')
                        <div class="alert alert-danger" style="font-size: 16px">
                            {{ __('theme/login.hello') }} <b>{{ Session::get('user')->name }}</b>,
                            {{ __('theme/login.check-your-email') }}
                        </div>
                        <br>
                        <form action="{{ route('send.verify.email.link') }}" method="post" style="text-align: center">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Session::get('user')->id }}">
                            <p class="text-muted text-sm mb-1">{{ __('theme/login.resend-the-verification-email') }}
                                <span style="line-height: 30px" id="time"></span></p>
                            <button id="re-send" class="btn btn-primary mb-1 text-center"
                                type="submit">{{ __('theme/login.resend-confirmation') }}</button>
                        </form>
                        @else
                        <h3 class="mb-4">{{ __('theme/login.hello.again') }} 👋👋</h3>
                        <p class="text-muted text-sm mb-5">{{ __('theme/login.login-to-the-system') }}</p>
                                <form id="loginForm" action="{{ route('login', ['locale' => app()->getLocale()]) }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input class="form-control @error('email') is-invalid @enderror" id="floatingInput"
                                    type="email" value="{{ old('email') }}" placeholder="email@adresi.com" name="email"
                                    required autocomplete="email">
                                <label for="floatingInput">{{ __('theme/login.email-address') }}</label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control @error('password') is-invalid @enderror"
                                    id="floatingPassword" type="password" name="password" placeholder="Parola" required
                                    autocomplete="current-password">
                                <label for="floatingPassword">{{ __('theme/login.password') }}</label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label"
                                    for="remember">{{ __('theme/login.remember-me') }}</label>
                                <div class="reset-password" style="float: right;">
                                    <a href="password/reset">{{ __('theme/login.forgot-password') }}</a>.
                                </div>
                            </div>
                            <button class="btn btn-primary btn-lg" type="submit">{{ __('theme/login.login') }}</button>
                        </form>
                        @endif
                    </div>
                    <div class="card-footer px-lg-5 py-lg-4">
                        <div class="text-sm text-muted">{{ __('theme/login.dont-have-an-account') }}
                            <a href="{{ route('register', ['locale' => app()->getLocale()]) }}">{{ __('theme/login.register') }}</a>.
                            <span style="float: right"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-5 ms-xl-auto px-lg-4 text-center text-primary"><img class="img-fluid mb-4"
                    width="300" src="{{ asset('assets/dashboard') }}/img/drawkit-illustration.svg" alt="marka.legal"
                    style="transform: rotate(10deg)">
                <h1 class="mb-4">{{ __('theme/login.register-and') }} <br
                        class="d-none d-lg-inline">{{ __('theme/login.your-trademark-and-time') }} <br
                        class="d-none d-lg-inline">{{ __('theme/login.protect') }}</h1>
                <p class="lead text-muted">{{ __('theme/login.track-report-message') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function startTimer(duration, display) {
        var timer = duration,
            minutes, seconds;
        setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) {
                timer = 0;
            }
        }, 1000);
    }

    window.onload = function () {
        var remainingTime = {{ Session::get('second') }},
            display = document.querySelector('#time');
        startTimer(remainingTime, display);

        const btn = document.getElementById("re-send")
        btn.disabled = true;
        setTimeout(() => {
            btn.disabled = false;
        }, {{ Session::get('second')*1000 }})
    };

</script>

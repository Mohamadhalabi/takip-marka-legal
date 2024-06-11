@extends('layouts.auth')
@section('title', 'Üye Ol')
@section('description', 'Üye Ol. Türkpatent marka bülteni taramalarınızı otomatik yapın. Marka tescil takip hizmeti.')
@section('content')
    <div class="page-holder align-items-center py-4 bg-gray-100 vh-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 px-lg-4">
                    <div class="card">
                        <div class="card-header px-lg-5">
                            <div class="card-heading text-primary">{{ __('theme/register.card-title') }}</div>
                        </div>
                        <div class="card-body p-lg-5">
                            <h3 class="mb-4">{{ __('theme/register.hello.welcome') }} 👋👋</h3>
                            <p class="text-muted text-sm mb-5">{{ __('theme/register.you-can-register-by-filling-out-the-form-below') }}</p>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul style="margin:0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form id="registerForm" action="{{ route('register', ['locale' => app()->getLocale()]) }}" method="POST">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('name') is-invalid @enderror" id="floatingInputName" type="name" value="{{ old('name') }}"
                                           placeholder="{{ __('theme/register.name-surname') }}" name="name" required autocomplete="name">
                                    <label for="floatingInputName">Ad Soyad</label>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('email') is-invalid @enderror" id="floatingInputEmail" type="email" value="{{ old('email') }}"
                                           placeholder="email@adresi.com" name="email" required autocomplete="email">
                                    <label for="floatingInputEmail">{{ __('theme/register.email-address') }}</label>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control @error('password') is-invalid @enderror" id="floatingPassword" type="password" name="password"
                                           placeholder="{{ __('theme/register.password') }}" required autocomplete="current-password">
                                    <label for="floatingPassword">{{ __('theme/register.password') }}</label>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name="password_confirmation" id="floatingPasswordConfirmation" required autocomplete="new-password"
                                           placeholder="{{ __('theme/register.pasword') }}" required autocomplete="current-password">
                                    <label for="floatingPasswordConfirmation">{{ __('theme/register.password-repeat') }}</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="remember2">
                                    <a href="#" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#myModal">{{ __('theme/register.term-of-use') }}</a><label class="form-check-label" for="remember2">&nbsp;{{ __('theme/register.i-have-read-i-approve') }}.</label>
                                    <div class="modal fade text-start" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header border-0 bg-gray-100">
                                                    <h3 class="h5 text-uppercase modal-title" id="exampleModalLabel">{{ __('theme/dashboard.terms.title') }}</h3>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p style="overflow-y:scroll; max-height:60vh">{{ __('theme/dashboard.terms.content') }}</p>
                                                </div>
                                                <div class="modal-footer border-0 bg-gray-100">
                                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">{{ __('theme/register.close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-lg" type="submit">{{ __('theme/register.register') }}</button>
                            </form>
                        </div>
                        <div class="card-footer px-lg-5 py-lg-4">
                            <div class="text-sm text-muted">{{ __('theme/register.already-a-member') }} <a href="{{ route('login', ['locale' => app()->getLocale()]) }}">{{ __('theme/register.login') }}</a>.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-5 ms-xl-auto px-lg-4 text-center text-primary"><img class="img-fluid mb-4"
                                                                                                width="300" src="{{ asset('assets/dashboard') }}/img/drawkit-illustration.svg" alt=""
                                                                                                style="transform: rotate(10deg)" alt="marka.legal">
                    <h1 class="mb-4">{{ __('theme/login.register-and') }} <br class="d-none d-lg-inline">{{ __('theme/login.your-trademark-and-time') }} <br
                            class="d-none d-lg-inline">{{ __('theme/login.protect') }}</h1>
                    <p class="lead text-muted">{{ __('theme/login.track-report-message') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

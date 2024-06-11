@extends('layouts.dashboard.app')
@section('page-header', __('theme/settings.password.title'))
@section('content')
    <div class="container">
        @if (session()->get('error'))
            <div class="alert alert-danger">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                {{ session()->get('error') }}
            </div>
        @endif
        @if (session()->get('message'))
            <div class="alert alert-success" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        <form class="form-horizontal" method="POST"
                            action="{{ route('change.password.post', ['language' => app()->getLocale()]) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password"
                                    class="col-md-4 control-label">{{ __('theme/settings.password.current-password') }}</label>

                                <div class="col-md-12">
                                    <input id="current-password" type="password" class="form-control"
                                        name="current-password" required>

                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password"
                                    class="col-md-4 control-label">{{ __('theme/settings.password.new-password') }}</label>

                                <div class="col-md-12">
                                    <input id="new-password" type="password" class="form-control" name="new-password"
                                        required>

                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('new-password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="new-password-confirm"
                                    class="col-md-4 control-label">{{ __('theme/settings.password.new-password-again') }}
                                </label>

                                <div class="col-md-12">
                                    <input id="new-password-confirm" type="password" class="form-control"
                                        name="new-password_confirmation" required>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('theme/settings.password.button') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

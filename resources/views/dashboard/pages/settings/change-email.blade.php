@extends('layouts.dashboard.app')
@section('page-header', __('theme/settings.email.title'))
@section('content')
    <div class="container">
        @if (session()->get('code'))
            <div class="alert alert-{{ session()->get('code') == 'success' ? 'success' : 'danger' }}">
                {{ session()->get('response') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                @foreach ($errors->all() as $error)
                    {{ __('theme/settings.email.error') }}
                @endforeach
            </div>
        @endif
        @if (session()->get('message'))
            <div class="alert alert-success" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                {{ __('theme/settings.email.success') }}
            </div>
        @endif
        <div class="row ">
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
                        <form method="POST">
                            @csrf
                            <div class="form-group">
                                <label
                                    for="email"><strong>{{ __('theme/settings.email.label') }}</strong></label><br><br>
                                <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}"
                                    placeholder="{{ __('theme/settings.email.placeholder') }}" name="email">
                            </div>
                            <br>
                            <button class="btn btn-primary" type="submit">{{ __('theme/settings.email.button') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

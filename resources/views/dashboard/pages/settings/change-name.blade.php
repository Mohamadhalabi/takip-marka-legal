@extends('layouts.dashboard.app')
@section('page-header', __('theme/settings.name.title'))
@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                @foreach ($errors->all() as $error)
                    {{ __('theme/settings.name.errorr') }}
                @endforeach
            </div>
        @endif
        @if (session()->get('message'))
            <div class="alert alert-success" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                {{ __('theme/settings.name.success') }}
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
                        <form method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name"><strong>{{ __('theme/settings.name.label') }}</strong></label><br><br>
                                <input type="text" class="form-control" id="name" value="{{ Auth::user()->name }}"
                                    name="name" placeholder="{{ __('theme/settings.name.placeholder') }}">
                            </div>
                            <br>
                            <button class="btn btn-primary" type="submit">{{ __('theme/settings.name.button') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

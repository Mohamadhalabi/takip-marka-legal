@extends('layouts.dashboard.app')
@section('page-header', __('theme/settings.title'))
@section('js')
    <script>
        function resetSettings() {
            $.ajax({
                url: '{{ route('tour.updateAll', ['language' => app()->getLocale()]) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success) {
                        document.getElementById('notification-message').style.display = "block";
                    }
                }
            });
        }

        function checked() {
            $("#radio-checked").prop("checked", true);
        }

        function unchecked() {
            $("#radio-unchecked").prop("checked", false);
        }

        function unsubscribe() {
            $.ajax({
                type: 'POST',
                url: '{{ route('unsubscribe', ['language' => app()->getLocale()]) }}',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    $("#mydiv").load(location.href + " #mydiv");

                    $(".close").click();
                    document.getElementById('notification-unsubscribe').style.display = "block";
                    document.getElementById('notification-subscribe').style.display = "none";

                },
            });
        }

        function subscribe() {
            $.ajax({
                type: 'POST',
                url: '{{ route('subscribe', ['language' => app()->getLocale()]) }}',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    $(".close").click();
                    $("#mydiv").load(location.href + " #mydiv");
                    document.getElementById('notification-subscribe').style.display = "block";
                    document.getElementById('notification-unsubscribe').style.display = "none";

                },
            });
        }
    </script>
@endsection
@section('content')
    <div class="alert alert-success" id="notification-message" role="alert" style="display: none">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
        </svg>
        {{ __('theme/settings.tour-reset-message') }}
    </div>
    <div class="alert alert-success" id="notification-unsubscribe" role="alert" style="display: none">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
        </svg>
        {{ __('theme/settings.successfully-unsubscribed') }}
    </div>
    <div class="alert alert-success" id="notification-subscribe" role="alert" style="display: none">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
        </svg>
        {{ __('theme/settings.successfully-subscribed') }}
    </div>
    <section>
        <div class="row">
            <!-- Basic Form-->
            <div class="col-lg-6 mb-6 card-hover" style="margin-bottom: 30px">
                <a class="dropdown-item" href="{{ route('keyword.create', ['language' => app()->getLocale()]) }}">
                    <div class="card setting-card">
                        <div class="card-header head"
                            style="border-radius: calc(1rem - 1px) calc(1rem - 1px) ; min-height: 86px">
                            <h4 class="card-heading card-text">{{ __('theme/settings.add-keyword') }}</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 mb-6 card-hover" style="margin-bottom: 30px">
                <a class="dropdown-item" href="{{ route('change.password.get', ['language' => app()->getLocale()]) }}">
                    <div class="card setting-card">
                        <div class="card-header head"
                            style="border-radius: calc(1rem - 1px) calc(1rem - 1px) ; min-height: 86px">
                            <h4 class="card-heading card-text">{{ __('theme/settings.password-reset') }}</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
    <section>
        <div class="row">
            <!-- Basic Form-->
            <div class="col-lg-6 mb-6 card-hover" style="margin-bottom: 30px">
                <a class="dropdown-item" href="{{ route('custom.change.email', ['language' => app()->getLocale()]) }}">
                    <div class="card setting-card">
                        <div class="card-header head"
                            style="border-radius: calc(1rem - 1px) calc(1rem - 1px) ; min-height: 86px">
                            <h4 class="card-heading card-text">{{ __('theme/settings.email-reset') }}</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 mb-6 card-hover" style="margin-bottom: 30px">
                <a class="dropdown-item" href="{{ route('change.name', ['language' => app()->getLocale()]) }}">
                    <div class="card setting-card">
                        <div class="card-header head"
                            style="border-radius: calc(1rem - 1px) calc(1rem - 1px) ; min-height: 86px">
                            <h4 class="card-heading card-text">{{ __('theme/settings.name-change') }}</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
    <section>
        <div id="mydiv">
            <div class="row">
                <div class="col-lg-6 mb-6 card-hover" style="margin-bottom: 30px">
                    <button class="btn w-100" onclick="resetSettings()">
                        <div class="card setting-card">
                            <div class="card-header head"
                                style="border-radius: calc(1rem - 1px) calc(1rem - 1px) ; min-height: 86px">
                                <h4 class="card-heading card-text">{{ __('theme/settings.tour-reset') }}</h4>
                            </div>
                        </div>
                    </button>
                </div>
                @if (Auth::user()->subscription == 1)
                    <div class="col-lg-6 mb-6 card-hover" style="margin-bottom: 30px">
                        <button class="btn w-100">
                            <div class="card setting-card">
                                <div class="card-header head"
                                    style="border-radius: calc(1rem - 1px) calc(1rem - 1px) ; min-height: 86px">
                                    <div class="form-switch">
                                        <label class="form-check-label card-heading card-text" onclick="checked()"
                                            for="flexSwitchCheckChecked">
                                            {{ __('theme/settings.email-retrieval') }}
                                            <input class="form-check-input" id="radio-checked"
                                                style="margin-left: 10px;float: right;font-size: 23px; margin-top: 0px"
                                                type="checkbox" role="switch" data-bs-toggle="modal"
                                                data-bs-target="#unsubscribe" checked>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </button>
                    </div>
                @else
                    <div class="col-lg-6 mb-6 card-hover" style="margin-bottom: 30px">
                        <button class="btn w-100">
                            <div class="card setting-card">
                                <div class="card-header head" style="border-radius: calc(1rem - 1px) calc(1rem - 1px) ;">
                                    <div class="form-check form-switch" style="text-align: center">
                                        <label class="form-check-label card-heading card-text"
                                            for="flexSwitchCheckChecked">{{ __('theme/settings.email-retrieval') }}
                                            <input class="form-check-input" id="radio-unchecked"
                                                style="margin-left: 10px;float: right;font-size: 25px; margin-top: 0px"
                                                onclick="subscribe()" type="checkbox" role="switch">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section>
        <div id="mydiv">
            <div class="row">
                <div class="col-lg-6 mb-6 card-hover" style="margin-bottom: 30px">
                    <a class="dropdown-item"
                        href="{{ route('subscription.management', ['language' => app()->getLocale()]) }}">
                        <div class="card setting-card">
                            <div class="card-header head"
                                style="border-radius: calc(1rem - 1px) calc(1rem - 1px) ; min-height: 86px">
                                <h4 class="card-heading card-text">{{ __('theme/settings.manage-subscription') }}</h4>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="unsubscribe" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="card-body" style="padding:15px!important;">
                        <div>
                            <h4>{{ __('theme/settings.unsubscribe') }}</h4>
                            <br>
                            <p>{{ __('theme/settings.you-will-not-receive-reports-by-email') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #eeeff6">
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal">
                        {{ __('theme/settings.close') }}
                    </button>
                    <button type="button" class="btn btn-primary" onclick="unsubscribe()" style="color: white">
                        {{ __('theme/settings.unsubscribe') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

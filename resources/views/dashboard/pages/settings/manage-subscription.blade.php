@extends('layouts.dashboard.app')
@section('page-header', __('theme/settings.subscription.title'))
@section('js')
    <script>
        function cancelSubscription() {
            $.ajax({
                url: '{{ route('cancel.subscription', ['language' => app()->getLocale()]) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#close').click();
                    if (data.statusCode === 200) {
                        $("#mydiv").load(location.href + " #mydiv");
                        document.getElementById('notification-message').style.display = "block";
                    } else {
                        document.getElementById('error-message').style.display = "block";
                    }
                }
            });
        }
    </script>
@endsection
@section('content')
    <div class="alert alert-success" id="notification-message" role="alert" style="display: none">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
        </svg>
        {{ __('theme/settings.subscription.cancelled') }}
    </div>
    <div class="alert alert-danger" id="error-message" role="alert" style="display: none">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
            <use xlink:href="#exclamation-triangle-fill" />
        </svg>
        {{ __('theme/settings.subscription.cannot-unsubscribe') }}
    </div>
    <div class="containerr" id="mydiv">
        <div class="row ">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>{!! __('theme/settings.subscription.current-plan', ['plan' => $plan_name]) !!}</p>
                        <a class="btn btn-primary"
                            href="{{ route('subscription.list', ['language' => app()->getLocale()]) }}">{{ __('theme/settings.subscription.change-plan') }}</a>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
                            {{ __('theme/settings.subscription.unsubscribe') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    {{ __('theme/settings.subscription.cancel-subscribtion') }}</h5>
            </div>
            <div class="modal-body">
                {!! __('theme/settings.subscription.cancel-subscribtion-info') !!}
            </div>
            <div class="modal-footer">
                <button type="button" id="close" class="btn btn-danger"
                    data-dismiss="modal">{{ __('theme/settings.subscription.close') }}</button>
                <button type="button" onclick="cancelSubscription()"
                    class="btn btn-primary">{{ __('theme/settings.subscription.confirm') }}</button>
            </div>
        </div>
    </div>
</div>

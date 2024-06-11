@extends('layouts.dashboard.app')
@section('page-header', __('theme/report.reports-page-title'))
@if (auth()->user()->tour->report)
    @section('js')
        <script>
            introJs().setOptions({
                prevLabel: 'Geri',
                nextLabel: 'İleri',
                doneLabel: 'Tamam',
                showStepNumbers: true,
                stepNumbersOfLabel: '/',
                autoPosition: true,
                showProgress: true,
                steps: [{
                        element: document.querySelector('.tour-title'),
                        title: '{{ __('theme/report.tour.step1.title') }}',
                        intro: '{{ __('theme/report.tour.step1.content') }}',
                        position: 'top'
                    },
                    @if (is_countable($reports) && count($reports) > 0)
                    {
                        element: document.querySelector('.tour-next-report'),
                        title: '{{ __('theme/report.tour.step2.title') }}',
                        intro: '{{ __('theme/report.tour.step2.content') }}',
                        position: 'top'
                    },
                    @endif
                ]
            }).onbeforeexit(function() {
                $.ajax({
                    url: "{{ route('tour.update', ['language' => auth()->user()->language]) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        page: 'report'
                    },
                    success: function(response) {
                        if (response.success) {
                            document.getElementById('notification-message').style.display = "block";
                        }
                    }
                });
            }).start();
        </script>
    @endsection
@endif
@section('content')
    @if (auth()->user()->tour->report)
        <div class="alert alert-success" id="notification-message" role="alert" style="display: none">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill"></use>
            </svg>
            {{ __('theme/report.report-tour-closed-message') }}
        </div>
    @endif
    <section>
        @if ($user_has_no_keywords === true)
            <h5><a href="{{ route('keyword.create') }}">
                    {{ __('theme/report.no-keywords-message') }}
                </a></h5>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger" id="message_id">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                    <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                {{ Session::get('error') }}
                @php
                    Session::forget('error');
                @endphp
            </div>
        @endif
        <br>
        <div class="card card-table mb-4">
            <div class="card-header">
                <h5 class="card-heading">{{ __('theme/report.reports') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="tour-title">
                            <tr>
                                <th class="tour-order">{{ __('theme/report.id') }}</th>
                                <th class="report-date-header tour-date">{{ __('theme/report.created-date') }}</th>
                                <th class="tour-action">{{ __('theme/report.view') }}</th>
                            </tr>
                        </thead>
                        <tbody class="reports-table">
                            <tr class="align-middle tour-next-report" id="myDiv">
                                    <td>#{{ count($reports) + 1 }}</td>
                                    <td class="report-release-date"><span>{{ __('theme/report.next-report') }}: </span>
                                        {{ $result }}</td>
                                    <td><a href="#" onclick="myFunction()" id="myLink">{{ __('theme/report.waiting') }}</a></td>
                            </tr>
                            @foreach ($reports as $key => $report)
                                <tr class="align-middle">
                                    <td>#{{ $layercount - $key }}</td>
                                    <td class="report-release-date">
                                        {{ Carbon\Carbon::parse($report->created_at)->format('d-m-Y') }}</td>
                                    <td><a href="{{ route('report.show', ['language' => app()->getLocale(), 'report' => $report]) }}">{{ __('theme/report.view-report') }}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center p-3 mx-auto">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
<script>
    function myFunction() {
        document.getElementById("myDiv").style.background = "#BEBEBE";
    }

    function codeAddress() {
        var myElem = document.getElementById('message_id');
        if (myElem != null) myElem.style.display = "none";
    }
    window.onload = function() {
        setTimeout(codeAddress, 4000)
    }
</script>

@extends('layouts.dashboard.app')
@section('page-header', __('theme/dashboard.title'))
@if (auth()->user()->tour->dashboard)
    @section('js')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let width = window.innerWidth;
                if (width < 1199) {
                    let sidebar = document.querySelector('#sidebar');
                    sidebar.classList.add('shrink');
                    sidebar.classList.add('show');
                }
            });
            introJs("#dashboard").setOptions({
                prevLabel: 'Geri',
                nextLabel: 'İleri',
                hidePrev: true,
                doneLabel: 'Tamam',
                showStepNumbers: true,
                stepNumbersOfLabel: '/',
                autoPosition: true,
                showProgress: true,
                steps: [{
                        title: '{{ __('theme/dashboard.tour.step1.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step1.content') }}',
                    },
                    {
                        element: document.querySelector('.tour-keyword'),
                        title: '{{ __('theme/dashboard.tour.step2.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step2.content') }}',
                        position: 'right'
                    },
                    {
                        element: document.querySelector('.tour-report'),
                        title: '{{ __('theme/dashboard.tour.step3.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step3.content') }}',
                        position: 'right'
                    },
                    {
                        element: document.querySelector('.tour-classes'),
                        title: '{{ __('theme/dashboard.tour.step4.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step4.content') }}',
                        position: 'right'
                    },
                    {
                        element: document.querySelector('.tour-search'),
                        title: '{{ __('theme/dashboard.tour.step5.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step5.content') }}',
                        position: 'right'
                    },
                    {
                        element: document.querySelector('.tour-contact'),
                        title: '{{ __('theme/dashboard.tour.step6.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step6.content') }}',
                        position: 'right'
                    },
                    {
                        element: document.querySelector('.tour-card-keyword'),
                        title: '{{ __('theme/dashboard.tour.step7.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step7.content') }}',
                    },
                    {
                        element: document.querySelector('.tour-card-report'),
                        title: '{{ __('theme/dashboard.tour.step8.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step8.content') }}',
                    },
                    {
                        element: document.querySelector('.tour-user-activity'),
                        title: '{{ __('theme/dashboard.tour.step9.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step9.content') }}',
                    },
                    {
                        element: document.querySelector('.tour-settings'),
                        title: '{{ __('theme/dashboard.tour.step10.title') }}',
                        intro: '{{ __('theme/dashboard.tour.step10.content') }}',
                        position: 'left'
                    },
                ]
            }).onbeforeexit(function() {
                $.ajax({
                    url: "{{ route('tour.update', ['language' => auth()->user()->language]) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        page: 'dashboard'
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
    @if (auth()->user()->tour->dashboard)
        <div class="alert alert-success" id="notification-message" role="alert" style="display: none">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill"></use>
            </svg>
            {{ __('theme/dashboard.tour-closed-message') }}.
        </div>
    @endif
    <section class="mb-3 mb-lg-5" id="dashboard">
        <div class="row mb-3">
            <!-- /Widget Type 1-->
            <!-- Widget Type 1-->
            <div class="mb-4 col-sm-6 col-lg-6 mb-4">
                <div class="card h-100 tour-card-keyword">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="fw-normal text-blue">
                                    <a style="text-decoration: none"
                                        href="{{ route('keyword.create', ['language' => auth()->user()->language]) }}">
                                        {{ auth()->user()->keywords->count() }}
                                    </a>
                                </h4>
                                <a style="text-decoration: none"
                                    href="{{ route('keyword.create', ['language' => auth()->user()->language]) }}">
                                    <p class="subtitle text-sm text-muted mb-0" id="test">
                                        {{ __('theme/dashboard.keyword') }}
                                    </p>
                                </a>
                            </div>
                            <div class="flex-shrink-0 ms-3">
                                <svg class="svg-icon text-blue">
                                    <use
                                        xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#news-1">
                                    </use>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-3 bg-blue-light">
                        <div class="row align-items-center text-blue">
                            <div class="col-10">
                                <p class="mb-0">
                                    <a href="{{ route('keyword.create', ['language' => auth()->user()->language]) }}">
                                        {{ auth()->user()->keywords->count() }}
                                        {{ __('theme/dashboard.keyword-counter') }}
                                    </a>
                                </p>
                            </div>
                            <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Widget Type 1-->
            <!-- Widget Type 1-->
            <div class="mb-4 col-sm-6 col-lg-6 mb-4">
                <div class="card h-100 tour-card-report">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="fw-normal text-primary">
                                    <a style="text-decoration: none"
                                        href="{{ route('report.index', ['language' => auth()->user()->language]) }}">{{ auth()->user()->reports->count() }}
                                    </a>
                                </h4>
                                <a style="text-decoration: none"
                                    href="{{ route('report.index', ['language' => auth()->user()->language]) }}">
                                    <p class="subtitle text-sm text-muted mb-0">
                                        {{ __('theme/dashboard.you-have-a-report') }}
                                    </p>
                                </a>
                            </div>
                            <div class="flex-shrink-0 ms-3">
                                <svg class="svg-icon text-primary">
                                    <use
                                        xlink:href="{{ asset('assets/dashboard') }}/icons/orion-svg-sprite.71e9f5f2.svg#bookmark-1">
                                    </use>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-3 bg-primary-light">
                        <div class="row align-items-center text-primary">
                            <div class="col-10">
                                <p class="mb-0">
                                    <a href="{{ route('report.index', ['language' => auth()->user()->language]) }}">
                                        {{ __('theme/dashboard.created-report', ['report' =>auth()->user()->reports->count() + 1,'bulletin' =>substr(\App\Models\Media::where('is_official', 1)->latest()->first()->name,0,3) + 1]) }}
                                    </a>
                                </p>
                            </div>
                            <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="card card-table mb-4">
            <div class="card-header tour-user-activity">
                <h5 class="card-heading"> {{ __('theme/dashboard.user-activities') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('theme/dashboard.activity') }}</th>
                                <th></th>
                                <th>{{ __('theme/dashboard.date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userActivity as $key => $activity)
                                <tr class="align-middle">
                                    <td>
                                        <strong>
                                            @switch($activity->event)
                                                @case('Giriş Yapıldı')
                                                    {{ __('theme/dashboard.login') }}
                                                @break

                                                @case('Çıkış Yapıldı')
                                                    {{ __('theme/dashboard.logout') }}
                                                @break

                                                @case('Kayıt Olundu')
                                                    {{ __('theme/dashboard.registered') }}
                                                @break

                                                @case('Anahtar Kelime Eklendi')
                                                    {{ __('theme/dashboard.keyword-added') }}
                                                @break

                                                @case('Anahtar Kelime Güncellendi')
                                                    {{ __('theme/dashboard.keyword-updated') }}
                                                @break

                                                @case('Anahtar Kelime Silindi')
                                                    {{ __('theme/dashboard.keyword-deleted') }}
                                                @break

                                                @default
                                                    {{ $activity->event }}
                                            @endswitch
                                        </strong>
                                    <td>
                                        @if ($activity->data != null && $activity->old_data != null)
                                            {{ $activity->old_data }} <strong>-></strong> {{ $activity->data }}
                                        @else
                                            {{ $activity->data }} <strong>
                                        @endif
                                    </td>
                                    </td>
                                    <td>{{ $activity->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 text-center p-3 mx-auto">
                    {{ $userActivity->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

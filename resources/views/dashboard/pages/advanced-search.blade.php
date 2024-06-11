@extends('layouts.dashboard.app')
@section('page-header', __('theme/advanced-search.title'))
@section('content')
    <style>
        p {
            margin-top: 1rem;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="text-dark text-center">{{ __('theme/advanced-search.title') }}</h1>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <h3>{{ __('theme/advanced-search.subtitle-1') }}</h3>
            {!! __('theme/advanced-search.subtitle-1-description') !!}
            <img src="{{ asset('assets/dashboard/search/1.gif') }}" alt="gif1">
        </div>
        <div class="row mt-5">
            <h3>{{ __('theme/advanced-search.subtitle-2') }}</h3>
            {!! __('theme/advanced-search.subtitle-2-description') !!}
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/2.png') }}" alt="gif1">
            {!! __('theme/advanced-search.subtitle-2-description-2') !!}
        </div>
        <div class="row mt-5">
            <h3>{{ __('theme/advanced-search.subtitle-3') }}</h3>
            {!! __('theme/advanced-search.subtitle-3-description') !!}
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/elektrik_normal_1.png') }}" alt="gif1">
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/elektrik_normal_2.png') }}" alt="gif1">
            {!! __('theme/advanced-search.subtitle-3-description-2') !!}
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/elektrik_filtreli.png') }}" alt="gif1">
        </div>
        <div class="row mt-5">
            <h3>{{ __('theme/advanced-search.subtitle-4') }}</h3>
            {!! __('theme/advanced-search.subtitle-4-description') !!}
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/marka_normal.png') }}" alt="gif1">
            {!! __('theme/advanced-search.subtitle-4-description-2') !!}
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/marka_fullmatch.png') }}" alt="gif1">
        </div>
        <div class="row mt-5">
            <h3>{{ __('theme/advanced-search.subtitle-5') }}</h3>
            {!! __('theme/advanced-search.subtitle-5-description') !!}
            {!! __('theme/advanced-search.subtitle-5-description-2') !!}
            {!! __('theme/advanced-search.subtitle-5-description-3') !!}
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/okullar_normal.png') }}" alt="gif1">
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/okullar_normal_sonuc.png') }}" alt="gif1">
            {!! __('theme/advanced-search.subtitle-5-description-4') !!}
            {!! __('theme/advanced-search.subtitle-5-description-5') !!}
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/okullar_fullmatch.png') }}" alt="gif1">
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/okullar_fullmatch_sonuc.png') }}" alt="gif1">
            {!! __('theme/advanced-search.subtitle-5-description-6') !!}
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <h3>{{ __('theme/advanced-search.subtitle-6') }}</h3>
            {!! __('theme/advanced-search.subtitle-6-description') !!}
            {!! __('theme/advanced-search.subtitle-6-description-2') !!}
            {!! __('theme/advanced-search.subtitle-6-description-3') !!}
            {!! __('theme/advanced-search.subtitle-6-description-4') !!}
            {!! __('theme/advanced-search.subtitle-6-description-5') !!}
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/arteng_normal.png') }}" alt="gif1">
            {!! __('theme/advanced-search.subtitle-6-description-7') !!}
            <img class="pt-0 py-3" src="{{ asset('assets/dashboard/search/arteng_filtreli.png') }}" alt="gif1">
            {!! __('theme/advanced-search.subtitle-6-description-7') !!}
            {!! __('theme/advanced-search.subtitle-6-description-8') !!}
        </div>
    </div>
@endsection

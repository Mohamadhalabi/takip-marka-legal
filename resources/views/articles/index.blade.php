@extends('layouts.main')
@section('header.title', __('theme/landing.articles') . ' - ' . config('app.name'))
@section('header.description', __('theme/landing.article-description'))
@section('content')
    <section id="home" class="home">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-banner" style="text-align:center">
                        <div data-aos="zoom-in-up">
                            <div class="banner-title">
                                <h1 class="font-weight-medium">
                                    {{ __('theme/landing.articles') }}
                                </h1>
                                <h6 class="mt-2 font-weight-medium">{{ __('theme/landing.article-description') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-process" id="marka-takip-hizmeti" style="padding-bottom:60px;margin-top:0">
        <div class="container">
            <div class="row">
                @foreach ($articles as $article)
                    <div class="col-md-4 col-sm-12 mt-2">
                        <div class="card">
                            @if ($article->image)
                                <img class="card-img-top" src="{{ url('article-images/' . $article->image) }}"
                                    alt="{{ $article->title }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $article->title }}</h5>
                                <p class="card-text">{{ $article->description }}</p>
                                <a href="{{ route('front.article', ['language' => app()->getLocale(), 'slug' => $article->slug]) }}"
                                    class="btn btn-primary btn-sm">{{ __('theme/landing.show-article') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

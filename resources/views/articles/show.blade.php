@extends('layouts.main')
@section('header.title',$article->title)
@section('header.description',$article->description)
@section('content')
    <section id="home" class="home">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-banner" style="text-align:center">
                        <div data-aos="zoom-in-up">
                            <div class="banner-title">
                                <h1 class="font-weight-medium">
                                    {{ $article->title }}
                                </h1>
                                <h6 class="mt-2 font-weight-medium">{{ $article->description }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-process" id="marka-takip-hizmeti" style="padding-bottom:60px;margin-top:0">
        <h2 class="font-weight-medium text-center mb-5 mt-0 pt-0">
            {{ $article->title }}
        </h2>
        <div class="container">
            <div class="row">
                @if ($article->image)
                    <div class="col-sm-12 text-center mb-4">
                        <img class="img-responsive" src="{{ url('article-images/' . $article->image) }}"
                            alt="{{ $article->title }}">
                    </div>
                @endif
                <div class="col-sm-12">
                    {!! $article->body !!}
                </div>
            </div>
        </div>
    </section>
@endsection

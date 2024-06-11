@extends('layouts.dashboard.app')
@section('page-header', __('theme/images.search.title'))
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/highlight/jquery.highlight-within-textarea.css">
    <script src="{{ asset('assets/dashboard') }}/vendor/highlight/jquery.highlight-within-textarea.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/tagify/style.css">
    <script src="{{ asset('assets/dashboard') }}/vendor/tagify/main.js"></script>
@endsection
@section('content')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var resultDiv = document.getElementById('result');
            if (resultDiv) {
                window.location.hash = 'result';
            }
        });
    </script>
    <section>
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
        @if (Session::has('success'))
            <div class="alert alert-success" id="message_id">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                {{ Session::get('success') }}
                @php
                    Session::forget('success');
                @endphp
            </div>
        @endif
        <div class="containe">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row">
                        <!-- Basic Form-->
                        <div class="col-lg-12 mb-5">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-heading">{{ __('theme/images.search.title') }}</h4>
                                </div>
                                <div class="card-body">
                                    @if(auth()->user()->remaining_image_search > 0)
                                    <div class="alert alert-warning" role="alert">
                                        Şekil ile arama özelliğimiz şu an için <strong>beta</strong> aşamasındadır. Bu özellik ile arama yaparken karşılaşacağınız hataları lütfen bize bildiriniz.
                                    </div>
                                    <p>{{ __('theme/images.search.info') }}</p>
                                    <div class="alert alert-primary" role="alert">
                                        {!! __('theme/images.search.alert') !!}
                                    </div>
                                    <form action="{{ route('image.search.post', ['language' => app()->getLocale()]) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <label class="form-check-label" for="searchedImage">
                                            {{ __('theme/images.search.form.label') }}
                                        </label>
                                        <input type="file" name="image" class="form-control" id="searchedImage">
                                        <div class="pt-3 pb-3">
                                            <label
                                                class="form-label text-uppercase">{{ __('theme/content.dashboard.search.select-1-label') }}</label>
                                            <select class="form-control rounded" name="bulletin">
                                                @foreach ($bulletins as $bulletin)
                                                    <option @selected(($searchedBulletin ?? 0) == $bulletin->id) value="{{ $bulletin->id }}">
                                                        {{ substr($bulletin->name, 0, 3) }}&nbsp;{{ __('theme/search.official-brand-bulletin-no') }}&nbsp;
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mt-3">
                                            <button
                                                class="btn btn-primary">{{ __('theme/images.search.form.button') }}</button>
                                        </div>
                                        <p class="pt-5">{!! __('theme/images.search.limit', ['count' => auth()->user()->remaining_image_search]) !!}</p>
                                    </form>
                                    @else
                                    <div class="alert alert-warning" role="alert">
                                        Şekil ile arama limitiniz doldu. Daha fazla arama yapmak için lütfen iletişime geçiniz.
                                    </div>
                                    @endif
                                    {{-- <div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h5>{{ __('theme/images.search.search-history') }}</h5>
                                                <p>{{ __('theme/images.search.search-history-info') }}</p>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="scrollable-div">
                                                            @foreach (auth()->user()->images()->where('history', true)->orderByDesc('id')->take(20)->get() as $historedImage)
                                                                <div class="d-inline-block p-3"
                                                                    style="padding-left:0!important">
                                                                    <div class="text-center">
                                                                        <h6>{{ $historedImage->created_at }}</h6>
                                                                        <a
                                                                            href="#"><img
                                                                                src="{{ Storage::url($historedImage->path) }}"
                                                                                class="img-fluid img-thumbnail"
                                                                                style="max-width:100px"></a>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    @isset($image)
                                        <div class="text-center mt-5" id="result">
                                            <h4>{{ __('theme/images.search.result.main-image.title') }}</h4>
                                            <img src="{{ Storage::url($image->path) }}" class="img-fluid img-thumbnail"
                                                style="max-width: 135px">
                                            <div class="row justify-content-md-center mt-3">
                                                <h6>{{ __('theme/images.search.result.main-image.dominant-color') }}</h6>
                                                @foreach ($image->dominantColors as $dominantColor)
                                                    <div class="col-md-3 col-sm-4">
                                                        <p><span>#{{ $dominantColor['hex'] }}</span></p>
                                                        <div
                                                            style="width:30px;height:30px;background-color:#{{ $dominantColor['hex'] }}">
                                                        </div>
                                                        <p><span>%{{ $dominantColor['percentage'] * 100 }}</span></p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- History --}}
    @isset($similarity)
        <section>
            <div class="card card-table mb-4">
                <div class="card-header tour-title" style="box-shadow:none">
                    <div class="row">
                        <div class="col-md-6 my-auto">
                            <h5 class="card-heading">{{ __('theme/images.search.result.main-title') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-header tour-title" style="box-shadow:none">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <h3 class="text-center m-3">ARAMA SONUÇLARI</h3>
                            <p class="mt-3">Yapılan arama sonucunda toplamda <strong>18 marka</strong> eşleşmiştir, <strong>3 farklı başlıkta</strong> sonuçlar derlenmiştir.</p>
                            <p><a href="#phash">Baskın Renk Benzerliği</a> : Aradığınız görsellerdeki renk yoğunluğu skalasını tespit eder ilgili bültendeki markalara ait görsellerin renk yoğunluğu ile karşılaştırma yaparak en
                                benzer sınırlı sayıdaki sonucu size sunar.</p>
                            <p><a href="#histogram">Şekil Benzerliği</a> :  Aradığınız görsellerdeki şekil benzerliği özelliklerini ilgili bültendeki markalara ait görsellerinkilerle karşılaştırma yaparak en benzer sınırlı sayıdaki sonucu size
                                sunar.</p>
                            <p><a href="#colors">Renk Uyumu</a> :  Aradığınız görsellerin içeriğini temsil eden renk bileşenlerini kullanarak ilgili bültendeki markalar ile benzerliklerini karşılaştırır ve en benzer sınırlı sayıdaki
                                sonucu size sunar.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body mt-5">
                    <div class="row">
                        @foreach ($similarity as $key => $type)
                            <h3 class="text-center mt-5">
                                @switch($key)
                                    @case('phash_similarity')
                                        <span id="phash">{{ __('theme/images.search.result.phash') }}</span>
                                    @break

                                    @case('histogram_similarity')
                                        <span id="histogram">{{ __('theme/images.search.result.histogram') }}</span>
                                    @break

                                    @case('color_similarity')
                                        <span id="colors">{{ __('theme/images.search.result.dominant-color') }}</span>
                                    @break

                                    @default
                                        {{ __('theme/images.search.result.similarity') }}
                                @endswitch
                            </h3>

                            <p class="text-center">
                                @switch($key)
                                    @case('phash_similarity')
                                        {{ __('theme/images.search.result.phash-info') }}
                                    @break

                                    @case('histogram_similarity')
                                        {{ __('theme/images.search.result.histogram-info') }}
                                    @break

                                    @case('color_similarity')
                                        {{ __('theme/images.search.result.dominant-color-info') }}
                                    @break

                                    @default
                                        {{ __('theme/images.search.result.similarity') }}
                                @endswitch
                            </p>
                            @foreach ($type as $compare)
                                <div class="col-md-2 col-sm-6 p-5 pt-0 text-center">
                                    {{-- <h6 class="text-center m-3">{{ $compare['trademark']->name }}</h6> --}}
                                    <p style="font-size:16px;height:20px">
                                        {{ $compare['trademark']->application_no }}
                                    </p>
                                    <div style="min-width:100px;min-height:100px">
                                        <img src="{{ Storage::url('bulletin/' . replaceLastSlash($compare['trademark']->image_path)) }}"
                                            class="img-thumbnail text-center" style="max-width:100px">
                                    </div>
                                    <div class="mt-3">
                                        @if ($key == 'phash_similarity')
                                            <p>{{ __('theme/images.search.result.phash') }} :
                                                <strong>{{ number_format($compare['phash_similarity'], 2) }}%</strong>
                                            </p>
                                        @elseif($key == 'histogram_similarity')
                                            <p>{{ __('theme/images.search.result.histogram') }} :
                                                <strong>{{ number_format($compare['histogram_similarity'], 2) }}%</strong>
                                            </p>
                                        @elseif($key == 'color_similarity')
                                            @if (count($compare['color_similarity']) > 0)
                                                <p>{{ __('theme/images.search.result.dominant-color') }}</p>
                                                @foreach ($compare['color_similarity'] as $color_similarity)
                                                    <div style="display:flex">
                                                        <div
                                                            style="margin:5px;width:30px;height:30px;background-color:{{ $color_similarity['color'] }}">
                                                        </div>
                                                        <div
                                                            style="margin:5px;width:30px;height:30px;background-color:{{ $color_similarity['color2'] }}">
                                                        </div>
                                                        <div class="">
                                                            <div>
                                                                <p class="p-0 m-0">
                                                                    <strong>{{ number_format($color_similarity['similarity'], 2) }}%</strong>
                                                                </p>
                                                                <p class="p-0 m-0">{{ $color_similarity['color2'] }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @else
                                            <p>
                                                {{ __('theme/images.search.result.similarity-not-found') }}
                                            </p>
                                        @endif
                                    </div>
                                    <p style="font-size:14px;height:50px">
                                        <i>({{ truncateText($compare['trademark']->name) }})</i>
                                    </p>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endisset
    @isset($compares)
        <section>
            <div class="card card-table mb-4">
                <div class="card-header tour-title" style="box-shadow:none">
                    <div class="row">
                        <div class="col-md-6 my-auto">
                            <h5 class="card-heading">{{ __('theme/images.search.result.main-title') }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($compares as $compare)
                            <div class="col-md-2 p-5">
                                <h6 class="text-center">{{ $compare['trademark']->name }}</h6>
                                <img src="{{ Storage::url('bulletin/' . replaceLastSlash($compare['trademark']->image_path)) }}"
                                    class="img-thumbnail text-center m-3" style="max-width:200px"><br>
                                <div class="mt-3">
                                    @if ($key == 'phash_similarity')
                                        <p>{{ __('theme/images.search.result.phash') }} :
                                            <strong>{{ number_format($compare['phash_similarity'], 2) }}%</strong>
                                        </p>
                                    @elseif($key == 'histogram_similarity')
                                        <p>{{ __('theme/images.search.result.histogram') }} :
                                            <strong>{{ number_format($compare['histogram_similarity'], 2) }}%</strong>
                                        </p>
                                    @elseif($key == 'color_similarity')
                                        @if (count($compare['color_similarity']) > 0)
                                            <p>{{ __('theme/images.search.result.dominant-color') }}</p>
                                            @foreach ($compare['color_similarity'] as $color_similarity)
                                                <div style="display:flex">
                                                    <div
                                                        style="margin:5px;width:30px;height:30px;background-color:{{ $color_similarity['color'] }}">
                                                    </div>
                                                    <div
                                                        style="margin:5px;width:30px;height:30px;background-color:{{ $color_similarity['color2'] }}">
                                                    </div>
                                                    <div class="">
                                                        <div>
                                                            <p class="p-0 m-0">
                                                                <strong>{{ number_format($color_similarity['similarity'], 2) }}%</strong>
                                                            </p>
                                                            <p class="p-0 m-0">{{ $color_similarity['color2'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @else
                                        <p>{{ __('theme/images.search.result.similarity-not-found') }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endisset
@endsection

@extends('layouts.dashboard.app')
@section('page-header', 'ŞEKİLLERİM')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/highlight/jquery.highlight-within-textarea.css">
    <script src="{{ asset('assets/dashboard') }}/vendor/highlight/jquery.highlight-within-textarea.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/tagify/style.css">
    <script src="{{ asset('assets/dashboard') }}/vendor/tagify/main.js"></script>
@endsection
@section('content')
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
                                    <h4 class="card-heading">Şekil Ekle</h4>
                                </div>
                                <div class="card-body">
                                    <p>Aranan Şekil</p>
                                    <img src="{{ Storage::url($image->path) }}" class="img-thumbnail"
                                        style="max-width:300px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="card card-table mb-4">
            <div class="card-header tour-title" style="box-shadow:none">
                <div class="row">
                    <div class="col-md-6 my-auto">
                        <h5 class="card-heading">ŞEKİL LİSTESİ</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($compares as $compare)
                        <div class="col-md-2 text-center p-5">
                            <h6>{{ $compare['trademark']->name }}</h6>
                            <img src="{{ Storage::url('bulletins/' . replaceLastSlash($compare['trademark']->image_path)) }}"
                                class="img-thumbnail" style="max-width:200px"><br>
                            <p>PHash distance : {{ $compare['phash_distance'] }}</p>
                            {{-- <p>Histogram distance : {{ $compare['histogram_distance'] }}</p> --}}
                            <p>PHash ratio : {{ $compare['phash_similarity'] }}%</p>
                            <p>Histogram ratio : {{ number_format($compare['histogram_similarity'], 2) }}%</p>
                            <p><strong>Color Similarity</strong></p>
                            @foreach ($compare['color_similarity'] as $color_similarity)
                                <div style="display:flex">
                                    <div
                                        style="margin:5px;width:30px;height:30px;background-color:{{ $color_similarity['color'] }}">
                                    </div>
                                    <div
                                        style="margin:5px;width:30px;height:30px;background-color:{{ $color_similarity['color2'] }}">
                                    </div>
                                    <div>{{ $color_similarity['similarity'] }}%</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

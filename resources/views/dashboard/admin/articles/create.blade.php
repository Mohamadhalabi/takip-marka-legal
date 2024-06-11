@extends('layouts.dashboard.app')
@section('page-header', 'Create New Article')
@section('js')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
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
                                    <h4 class="card-heading">New Article</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post"
                                        action="{{ route('articles.store', ['language' => app()->getLocale()]) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div>
                                            <div class="mt-2">
                                                <label class="form-label text-uppercase">Title</label>
                                                <input class="form-control" type="text" name="title" value="">
                                            </div>
                                            <div class="mt-2">
                                                <label class="form-label text-uppercase">Description</label>
                                                <input class="form-control" type="text" name="description" value="">
                                            </div>
                                            <div class="mt-2">
                                                <label class="form-label text-uppercase">Content</label>
                                                <textarea class="ckeditor form-control" name="content"></textarea>
                                            </div>
                                        </div>
                                        <div class="input-group mt-2">
                                            <label class="input-group-text" for="language-select">Language</label>
                                            <select class="form-select" name="language" id="language-select"
                                                @php
                                                    $langs = [
                                                        '' => '',
                                                        'tr' => 'Turkish',
                                                        'en' => 'English',
                                                        'es' => 'Spanish',
                                                        'it' => 'Italian',
                                                        'de' => 'German',
                                                        'ko' => 'Korean',
                                                        'ja' => 'Japanese',
                                                        'fr' => 'French',
                                                    ];
                                                @endphp
                                                @foreach ($langs as $code => $lang)
                                                    <option value="{{ $code }}" @selected(old('language') == $code)>
                                                        {{ $lang }}
                                                    </option>
                                                 @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 mt-2">
                                            <label for="formFile" class="form-label">Image</label>
                                            <input class="form-control" type="file" id="formFile" name="image">
                                          </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" checked name="is_published"
                                                id="exactMatch">
                                            <label class="form-check-label" for="exactMatch">
                                                Is Published
                                            </label>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <button class="btn btn-primary tour-button" type="submit">Add Article</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection

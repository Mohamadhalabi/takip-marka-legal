@extends('layouts.dashboard.app')
@section('page-header', 'Edit Article')
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
                                    <form method="post"
                                        action="{{ route('articles.destroy', ['language' => app()->getLocale(), 'article' => $article]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button style="float:right" class="btn btn-danger" type="submit">Delete
                                            Article</button>
                                    </form>
                                    <h4 class="card-heading">Edit Article</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post"
                                        action="{{ route('articles.update', ['language' => app()->getLocale(), 'article' => $article]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div>

                                            <div class="mt-2">
                                                <label class="form-label text-uppercase">Title</label>
                                                <input class="form-control" type="text" name="title"
                                                    value="{{ $article->title }}">
                                            </div>
                                            <div class="mt-2">
                                                <label class="form-label text-uppercase">Description</label>
                                                <input class="form-control" type="text" name="description" value="{{ $article->description }}">
                                            </div>
                                            <div class="mt-2">
                                                <label class="form-label text-uppercase">Content</label>
                                                <textarea class="ckeditor form-control" name="content">{{ $article->body }}</textarea>
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
                                                    <option value="{{ $code }}" @selected($article->language == $code)>
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
                                            <input class="form-check-input" type="checkbox"
                                                {{ $article->is_published ? 'checked' : '' }} name="is_published"
                                                id="exactMatch">
                                            <label class="form-check-label" for="exactMatch">
                                                Is Published
                                            </label>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <button class="btn btn-primary tour-button" type="submit">Edit Article</button>
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

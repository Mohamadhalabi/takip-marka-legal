@extends('layouts.dashboard.app')
@section('page-header', 'ANAHTAR KELİMEYİ GÜNCELLE')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/highlight/jquery.highlight-within-textarea.css">
    <script src="{{ asset('assets/dashboard') }}/vendor/highlight/jquery.highlight-within-textarea.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/tagify/style.css">
    <script src="{{ asset('assets/dashboard') }}/vendor/tagify/main.js"></script>
    <style>
        .hwt-container {
            width: 100%;
        }

        .hwt-content mark.red {
            background-color: #ffc9c9;
        }

        .hwt-content {
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.5;
            color: #343a40;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border-radius: 0.25rem;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
            border-bottom-left-radius: 0.25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        textarea {
            resize: none;
            white-space: nowrap;
            overflow-x: scroll;
        }
    </style>
@endsection
@section('js')
    <script>
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'right'
        });
        $(document).ready(function() {
            $('textarea').keypress(function(event) {

                if (event.keyCode == 13) {
                    event.preventDefault();
                }
            });

            // checkbox exactMatch click event
            $('#exactMatch').click(function() {
                var textareaInput = $('.regex-input').val();
                if ($(this).is(':checked')) {
                    textareaInput = textareaInput.replace(/"/g, '');
                    textareaInput = '"' + textareaInput + '"';
                } else {
                    textareaInput = textareaInput.replace(/"/g, '');
                }
                $('.regex-input').val(textareaInput);
                $('.regex-input').highlightWithinTextarea('update');
            });
        });
    </script>
@endsection
@section('content')
    <section>
        <div class="row">
            <!-- Basic Form-->
            <div class="col-lg-12 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-heading">{{ __('theme/keywords.keyword') }}</h4>
                    </div>
                    <div class="card-body">
                        <p>{{ __('theme/keywords.add-keyword-title') }}</p>
                        <form method="POST" action="{{ route('keyword.update', ['language' => app()->getLocale(), 'keyword' => $keyword->id]) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-4 mt-4 p-3">
                                <label class="form-label text-uppercase">{{ __('theme/keywords.keyword') }}</label>
                                <textarea class="tour-input regex-input" placeholder="Örn: marka legal" spellcheck="false" rows="1" name="keyword"
                                    required>{{ $keyword->keyword }}</textarea>
                                <script>
                                    $('.regex-input').highlightWithinTextarea({
                                        highlight: /"(.*)"/gi,
                                        className: 'red'
                                    });
                                </script>
                                <div class="form-check mt-2" style="margin-left:30px">
                                    <input class="form-check-input" type="checkbox" value="0"
                                        id="exactMatch">
                                    <label class="form-check-label" for="exactMatch">
                                        Tam eşleşme&nbsp;
                                        <span class="fa fa-question-circle fa-lg" data-toggle="tooltip"
                                            data-original-title="{{ __('theme/content.dashboard.search.tooltip-message2') }}"></span>
                                    </label>
                                </div>
                                <div class="mt-2" style="margin-left:30px">
                                    <label class="form-label text-uppercase">{{ __('theme/keywords.excluded-words') }} <span
                                            class="fa fa-question-circle fa-lg" data-toggle="tooltip"
                                            data-original-title="Arama sonucuna aşağıda eklediğiniz kelimeler varsa sonuçlarda gösterilmeyecektir."></span></label>
                                    <input class="form-control" type="text" name="exclusion_keywords"
                                        value="{{ ($keyword->exclusion_keywords != null || $keyword->exclusion_keywords != '') ? implode(',',$keyword->exclusion_keywords) : '' }}" id="exclusion_keywords">
                                </div>
                                <div class="pt-3 pb-3">
                                    <label class="form-label"><span
                                            style="letter-spacing: .2em;">{!! __('theme/content.dashboard.search.select-2-label') !!}</label><br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <select class="form-control" id="choices-multiple" name="classes[]"
                                                multiple="">
                                                @for ($i = 1; $i <= 45; $i++)
                                                    <option
                                                        @if (!is_null($keyword->classes)) @selected((in_array($i,$keyword->classes))) @endif
                                                        value="{{ $i < 10 ? '0' . $i : $i }}">{{ $i < 10 ? '0' . $i : $i }}.
                                                        {{ __('theme/keywords.class') }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary"
                                        type="submit">{{ __('theme/keywords.update-keyword') }}</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script data-name="basic">
        (function() {
            // The DOM element you wish to replace with Tagify
            var input = document.querySelector('input[name=exclusion_keywords]');

            // initialize Tagify on the above input node reference
            new Tagify(input, {
                maxTags: 10,
            })
        })()
    </script>
@endsection

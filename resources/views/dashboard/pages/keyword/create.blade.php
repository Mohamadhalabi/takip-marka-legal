@extends('layouts.dashboard.app')
@section('page-header', __('theme/keywords.keyword-page-title'))
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

@if (auth()->user()->tour->keyword)
    @section('js')
        <script>
            setTimeout(function() {
                introJs().setOptions({
                    prevLabel: '{{ __('theme/keywords.back') }}',
                    nextLabel: '{{ __('theme/keywords.forward') }}',
                    hidePrev: true,
                    doneLabel: '{{ __('theme/keywords.ok') }}',
                    showStepNumbers: true,
                    stepNumbersOfLabel: '/',
                    autoPosition: true,
                    showProgress: true,
                    steps: [{
                            element: document.querySelector('.tour-rules'),
                            title: '{{ __('theme/keywords.tour.step1.title') }}',
                            intro: '{{ __('theme/keywords.tour.step1.content') }}',
                            position: 'top'
                        },
                        {
                            element: document.querySelector('.tour-input'),
                            title: '{{ __('theme/keywords.tour.step2.title') }}',
                            intro: '{{ __('theme/keywords.tour.step2.content') }}',
                            position: 'top'
                        },
                        {
                            element: document.querySelector('.tour-nice-classes'),
                            title: '{{ __('theme/keywords.tour.step3.title') }}',
                            intro: '{{ __('theme/keywords.tour.step3.content') }}',
                            position: 'top'
                        },
                        {
                            element: document.querySelector('.tour-button'),
                            title: '{{ __('theme/keywords.tour.step4.title') }}',
                            intro: '{{ __('theme/keywords.tour.step4.content') }}',
                            position: 'top'
                        },
                        {
                            element: document.querySelector('.tour-table'),
                            title: '{{ __('theme/keywords.tour.step5.title') }}',
                            intro: '{{ __('theme/keywords.tour.step5.content') }}',
                            position: 'top'
                        },
                    ]
                }).onbeforeexit(function() {
                    $.ajax({
                        url: "{{ route('tour.update', ['language' => auth()->user()->language]) }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            page: 'keyword'
                        },
                        success: function(response) {
                            if (response.success) {
                                document.getElementById('notification-message').style.display =
                                    "block";
                            }
                        }
                    });
                }).start();
            }, 300);
        </script>
    @endsection
@endif
@section('js')
    <script type="text/javascript">
        $.fn.editable.defaults.mode = 'inline';
        $('.table-title').editable({
            url: "{{ route('user.update', ['language' => app()->getLocale()]) }}",
            type: 'text',
            pk: 1,
            name: 'limit',
            title: '{{ __('theme/keywords.test-limit') }}',
            success: function(response, newValue) {
                location.reload();
                if (response.status == 'error') alert("{{ __('theme/keywords.invalid-value') }}");
            },
            error: function(response) {
                alert("{{ __('theme/keywords.the-entered-value-must-be') }}")
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#keywords').DataTable({
                columnDefs: [{
                    "orderable": false,
                    "sortable": false,
                    "targets": [1, 2, 4]
                }],
                paging: false,
                searching: false,
                info: false,
            });
        });
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
    @if (auth()->user()->tour->keyword)
        <div class="alert alert-success" id="notification-message" role="alert" style="display: none">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill"></use>
            </svg>
            {{ __('theme/keywords.keywords-tour-closed-message') }}.
        </div>
    @endif
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
                                    <h4 class="card-heading">{{ __('theme/keywords.keyword') }}</h4>
                                </div>
                                <div class="card-body">
                                    <p>{{ __('theme/keywords.add-keyword-title') }}</p>
                                    <div class="alert alert-primary" role="alert">
                                        {{ __('theme/keywords.info') }}
                                    </div>
                                    <form method="post"
                                        action="{{ route('keyword.store', ['language' => app()->getLocale()]) }}">
                                        @csrf
                                        <div class="p-3">
                                            <label
                                                class="form-label text-uppercase">{{ __('theme/keywords.keyword') }}</label>
                                            <textarea class="tour-input regex-input" placeholder="{{ __('theme/keywords.placeholder') }} marka legal"
                                                spellcheck="false" rows="1" name="keyword" required>{{ old('keyword', $keyword ?? null) }}</textarea>
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
                                                    {{ __('theme/keywords.exact-match') }}&nbsp;
                                                    <span class="fa fa-question-circle fa-lg" data-toggle="tooltip"
                                                        data-original-title="{{ __('theme/content.dashboard.search.tooltip-message2') }}"></span>
                                                </label>
                                            </div>
                                            <div class="mt-2" style="margin-left:30px">
                                                <label
                                                    class="form-label text-uppercase">{{ __('theme/keywords.excluded-words') }}&nbsp;
                                                    <span class="fa fa-question-circle fa-lg" data-toggle="tooltip"
                                                        data-original-title="{{ __('theme/keywords.if-there-are-words-you-add') }}"></span></label>
                                                <input class="form-control" type="text" name="exclusion_keywords"
                                                    value="{{ $exclusion_keywords ?? '' }}" id="exclusion_keywords">
                                            </div>

                                        </div>

                                        <div class="p-3">
                                            <label class="form-label"><span
                                                    style="letter-spacing: .2em;">{!! __('theme/content.dashboard.search.select-2-label') !!}</label><br>
                                            <div class="row">
                                                <div class="col-sm-12 tour-nice-classes">
                                                    <select class="form-control" id="choices-multiple" name="classes[]"
                                                        multiple="">
                                                        @for ($i = 1; $i <= 45; $i++)
                                                            <option value="{{ $i < 10 ? '0' . $i : $i }}">
                                                                {{ $i < 10 ? '0' . $i : $i }}. sınıf</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary tour-button"
                                                type="submit">{{ __('theme/keywords.add-keyword') }}</button>
                                            <button type="button" class="btn btn-info  tour-rules" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                                {{ __('theme/keywords.how-to-add-keyword') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="card-heading">{{ __('theme/keywords.how-to-add-keyword') }}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body" style="padding:0!important;">
                            <p class="anahtar-nasil-eklenir">
                                <span class="star">*</span> {{ __('theme/keywords.first-step') }}
                            </p>
                            <p class="example"> {{ __('theme/keywords.first-example') }}
                            </p>
                            <p class="anahtar-nasil-eklenir">
                                <span class="star">*</span> {{ __('theme/keywords.second-step') }}
                            </p>
                            <p class="example">{{ __('theme/keywords.second-example') }}
                            </p>
                            <p class="anahtar-nasil-eklenir">
                                <span class="star">*</span> {{ __('theme/keywords.third-step') }}
                            </p>
                            <p class="example">{{ __('theme/keywords.third-example') }}
                            </p>
                            <p class="anahtar-nasil-eklenir">
                                <span class="star">*</span> {{ __('theme/keywords.fourth-step') }}
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('theme/keywords.close') }}</button>
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
                        <h5 class="card-heading">{{ __('theme/keywords.keywords') }}</h5>
                    </div>
                    @if (($filter_keyword ?? '') || ($filter_class ?? ''))
                        <div class="col-md-6" style="text-align:right">
                            <p class="mb-0"><span><i
                                        style="margin-right: 5px;
                            cursor: pointer;
                            margin-bottom: -10px;
                            position: absolute;
                            margin-top: -3px;
                            margin-left: -35px;"
                                        onclick="window.location.href='{{ route('keyword.create', ['language' => app()->getLocale()]) }}'"
                                        class="far fa-times-circle fa-2x text-red filter_keyword_button"></i></span>
                                @if ($filter_keyword != '')
                                    {{ __('theme/keywords.Keywords') }}
                                    <strong>({{ $filter_keyword }})</strong>
                                    @endif @if ($filter_class != '')
                                        {{ __('theme/keywords.classes') }}<strong>({{ $filter_class }})</strong>
                                    @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="keywords" class="table table-hover mb-0">
                        <thead>
                            <tr class="tour-table">
                                <th class="tour-order"><span>{{ __('theme/keywords.keywords-table.order') }}</span></th>
                                <th class="tour-keywords"><a class="table-title text-white" href="javascript:;"
                                        data-toggle="popover-keyword">{{ __('theme/keywords.keywords-table.keywords') }}
                                        <i class="fa fa-search" data-toggle="tooltip" data-placement="bottom"
                                            title="{{ __('theme/keywords.click-here-to-filter-keywords') }}."></i></a>
                                </th>
                                <th class="tour-keywords"><a class="table-title text-white" href="javascript:;"
                                        data-toggle="popover-class">{{ __('theme/keywords.keywords-table.nice_classes') }}<i
                                            class="fa fa-search" style="margin-left:5px" data-toggle="tooltip"
                                            data-placement="bottom"
                                            title="{{ __('theme/keywords.click-here-to-filter-classes') }}."></i></a>
                                </th>
                                <th class="tour-date"><span data-toggle="tooltip" data-placement="bottom"
                                        title="{{ __('theme/keywords.the-date-the-keyword-was-last-updated') }}">{{ __('theme/keywords.keywords-table.date') }}</span>
                                </th>
                                <th class="tour-action">{{ __('theme/keywords.keywords-table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($keywords as $key => $keyword)
                                <tr class="align-middle">
                                    <td>{{ ($keywords->currentPage() - 1) * 10 + $key + 1 }}</td>
                                    <td> <strong>{{ $keyword->keyword }}</strong></td>
                                    <td style="max-width:300px">
                                        @php
                                            $classes = $keyword->classes ?? [];
                                            sort($classes);
                                            $classes = implode(',', $classes);
                                        @endphp
                                        {{ $classes }}
                                    </td>
                                    <td>{{ $keyword->updated_at }}</td>
                                    <td>
                                        <form
                                            action="{{ route('keyword.destroy', ['language' => app()->getLocale(), 'keyword' => $keyword->id]) }}"
                                            method="POST">
                                            <a class="btn btn-primary"
                                                href="{{ route('keyword.edit', ['language' => app()->getLocale(), 'keyword' => $keyword->id]) }}">{{ __('theme/keywords.edit') }}</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger">{{ __('theme/keywords.delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <form id="search_post" method="post"
                action="{{ route('keyword.search', ['language' => app()->getLocale()]) }}">
                @csrf
                <input type="hidden" name="filter_keyword">
                <input type="hidden" name="filter_class">
            </form>
            <script type="text/javascript">
                $('[data-toggle="popover-keyword"]').popover({
                    trigger: "click",
                    html: true,
                    content: `
                    <div id="popover_content_wrapper_keyword">
                        <p>
                            {{ __('theme/keywords.enter-the-keyword-you-want-to-search') }}
                        </p>
                        <div class="row">
                            <div class="col-md-10" id="keyword_filtering">
                                <input type="text" class="form-control filter_keyword" data-html='true'
                                    name="filter_keyword" value="" placeholder="Örn: marka legal">
                            </div>
                            <div class="col-md-2 my-auto accept">
                                <i style="margin-left:-13px"
                                    class="far fa-check-circle fa-2x text-green filter_keyword_button"></i>
                            </div>
                        </div>
                    </div>
                    `,
                    sanitize: false
                });
                $('[data-toggle="popover-class"]').popover({
                    trigger: "click",
                    html: true,
                    content: `
                    <div id="popover_content_wrapper_class">
                        <p>
                            {{ __('theme/keywords.enter-the-class-you-wan-to-search') }}
                        </p>
                        <div class="row">
                            <div class="col-md-10" id="class_filtering">
                                <input type="text" class="form-control filter_class" name="filter_class"
                                    placeholder="Örn: 4,5,25,42">
                            </div>
                            <div class="col-md-2 my-auto accept">
                                <i style="margin-left:-13px" class="far fa-check-circle fa-2x text-green filter_class_button"></i>
                            </div>
                        </div>
                    </div>
            `,
                    sanitize: false
                });
                // Filtering keyword
                $(document).on('click', '.filter_keyword_button', function() {
                    var keyword = $('.filter_keyword').val();
                    var classes = $('.filter_class').val();
                    $('input[name="filter_keyword"]').val(keyword);
                    $('input[name="filter_class"]').val(classes);
                    $('#search_post').submit();
                });
                // Filtering keyword
                $(document).on('click', '.filter_class_button', function() {
                    var keyword = $('.filter_keyword').val();
                    var classes = $('.filter_class').val();
                    $('input[name="filter_keyword"]').val(keyword);
                    $('input[name="filter_class"]').val(classes);
                    $('#search_post').submit();
                });
            </script>
            <div class="col-md-12 text-center p-3 mx-auto">
                {{ $keywords->links() }}
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

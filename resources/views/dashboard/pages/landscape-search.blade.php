@extends('layouts.dashboard.app')
@section('page-header', 'Alan Taraması')
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js">
    </script>

    <script>
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'right'
        });
        $(document).ready(function() {
            $('#username').editable();
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
    @if (\Illuminate\Support\Facades\Auth::user()->landscape_limit == 0)
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('assets/dashboard') }}/img/premium-quality.png" alt="premium-icon" class="premium-icon">
                </div>
                <div class="col-md-12 d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <h1>{{ __('theme/landscape-search.exclusive-to-subscriber-users-only')}}</h1>
                        <p>{{ __('theme/landscape-search.this-page-is-for-sub-users')}}:</p>
                        <a href="{{ route('subscription.list') }}" class="btn btn-primary">{{ __('theme/landscape-search.subscribe-now')}}</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Button trigger modal -->
        @isset($number_of_results)
            @if($number_of_results >= 1000)
                <div class="alert alert-warning" id="notification-message" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                    {{ __('theme/landscape-search.the-number-of-results-has-exceeded-1000')}}.
                </div>
            @endif
        @endisset
        @if(auth()->user()->remaining_landscape_search_limit == 0)
            <div class="alert alert-warning" id="notification-message" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg>
                {{ __('theme/landscape-search.you-have-exceeded-your-limit')}}
            </div>
        @endif
        <div class="containe">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="row">
                        <!-- Basic Form-->
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-heading">{{ __('theme/landscape-search.area-scan')}}
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <p>{{ __('theme/landscape-search.you-can-search-for-your-brands-in-all-bulletins')}}.</p>
                                    <p>{{ __('theme/content.dashboard.search.card-description-2') }}</p>
                                    <form action="{{ route('search.landscape-search', ['language' => app()->getLocale()]) }}" method="post">
                                        <fieldset @disabled(auth()->user()->remaining_landscape_search_limit == 0 &&
                                            !auth()->user()->hasRole('admin'))>
                                            @csrf
                                            <input type="hidden" name="search_type" value="landscape_search">
                                            <div class="pt-3 pb-3">
                                                <label
                                                    class="form-label text-uppercase">{{ __('theme/content.dashboard.search.input.label') }}</label>
                                                <textarea class="tour-input regex-input" placeholder="Örn: marka legal" spellcheck="false" rows="1" name="keyword"
                                                          required>{{ old('keyword', $keyword ?? null) }}</textarea>
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
                                                        {{ __('theme/landscape-search.exact-match')}}&nbsp;
                                                        <span class="fa fa-question-circle fa-lg" data-toggle="tooltip"
                                                              data-original-title="{{ __('theme/content.dashboard.search.tooltip-message2') }}"></span>
                                                    </label>
                                                </div>
                                                <div class="mt-2" style="margin-left:30px">
                                                    <label class="form-label text-uppercase">{{ __('theme/landscape-search.excluded-words')}}</label>
                                                    <input class="form-control" type="text" name="exclusion_keywords"
                                                           value="{{ $exclusion_keywords ?? '' }}" id="exclusion_keywords">
                                                </div>
                                            </div>
                                            <div class="pt-3">
                                                <label class="form-label"><span
                                                        style="letter-spacing: .2em;">{!! __('theme/content.dashboard.search.select-2-label') !!}</label><br>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <select class="form-control" id="choices-multiple" name="classes[]"
                                                                multiple="">
                                                            @for ($i = 1; $i <= 45; $i++)
                                                                <option
                                                                    @isset($classes) @if (!is_null($classes))@selected((in_array($i,$classes)))@endif @endisset
                                                                    value="{{ $i < 10 ? '0' . $i : $i }}">
                                                                    {{ $i < 10 ? '0' . $i : $i }}. {{ __('theme/landscape-search.class')}}&nbsp;</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>

                                            <div class="pb-3">
                                                @if (!auth()->user()->hasRole('admin'))
                                                    <p class="text text-strong mb-0 test-limit">{!! __('theme/content.dashboard.search.card-header-2', ['limit' => auth()->user()->remaining_landscape_search_limit]) !!}
                                                        <span class="fa fa-question-circle fa-lg" data-toggle="tooltip"
                                                              data-original-title="{{ __('theme/content.dashboard.search.tooltip-message') }}"></span>
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="mb-3 mt-2">
                                                <button class="btn btn-primary tour-button"
                                                        type="submit">{{ __('theme/content.dashboard.search.button-label') }}</button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            @isset($filteredTrademarks)
                                <div class="col-lg-12 mt-4">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h4 class="card-heading">{{ __('search.search_results') }} -
                                                {{ __('theme/landscape-search.all-brands-releases')}}&nbsp; ({{ number_format($time, 3) }}sn -
                                                {{ count($filteredTrademarks) }} {{ __('search.match') }})</h4>
                                        </div>
                                        <div class="card-body landscape-card-body">
                                            @if (count($filteredTrademarks) > 0)
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-4 col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header" id="heading1">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                                                        {{ __('theme/landscape-search.one-to-one-matching')}}
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div id="collapse1" class="collapse show" aria-labelledby="heading1">
                                                                <div class="card-body landscape-card-body">
                                                                    <table id="my-table" class="table table-striped table-hover card-text landscape-table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>{{ __('search.trademark') }}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody class="table-data">
                                                                        @php
                                                                            $i = 1;
                                                                        @endphp
                                                                        @foreach ($filteredTrademarks as $trademark)
                                                                            @if(preg_match('/(^|\s)'.strtolower($keyword).'(\s|$)/', $trademark->name))
                                                                                <tr>
                                                                                    <th scope="row">{{ $i++ }}</th>
                                                                                    <td><a href="#" onclick="getTrademarkDetails(event, {{ $trademark->id }})">
                                                                                            {!! str_replace($trademark->_filtered['highlights'][0], '<span style="background-color:#c0ffc8;">'.$trademark->_filtered['highlights'][0].'</span>', $trademark->name) !!}
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    <div id="pagination-container"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header" id="heading2">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                                        {{ __('theme/landscape-search.found-in')}}
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div id="collapse2" class="collapse show" aria-labelledby="heading2">
                                                                <div class="card-body landscape-card-body">
                                                                    <table id="my-table2" class="table table-striped table-hover card-text landscape-table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>{{ __('search.trademark') }}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @php
                                                                            {{   $i= 1;}}
                                                                        @endphp
                                                                        @foreach ($filteredTrademarks as $key => $trademark)
                                                                            @if(!preg_match('/(^|\s)'.strtolower($keyword).'(\s|$)/', $trademark->name) && str_contains($trademark->name,strtolower($keyword)))
                                                                                <tr>
                                                                                    <th scope="row">{{  $i++ }}</th>
                                                                                    <td>
                                                                                        <a href="#" onclick="getTrademarkDetails(event, {{ $trademark->id }})">
                                                                                            {!! str_replace($trademark->_filtered['highlights'][0], '<span style="background-color:#c0ffc8;">'.$trademark->_filtered['highlights'][0].'</span>', $trademark->name) !!}
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    <div id="pagination-container2"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-sm-12">
                                                        <div class="card">
                                                            <div class="card-header" id="heading3">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                        Benzer Bulunan
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div id="collapse3" class="collapse show" aria-labelledby="heading3">
                                                                <div class="card-body landscape-card-body">
                                                                    <table id="my-table3" class="table table-striped table-hover card-text landscape-table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>{{ __('search.trademark') }}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @php
                                                                            {{ $j= 1;}}
                                                                        @endphp
                                                                        @foreach ($filteredTrademarks as $trademark)
                                                                            @if(!preg_match('/(^|\s)'.strtolower($keyword).'(\s|$)/', $trademark->name) && !str_contains($trademark->name,strtolower($keyword)))
                                                                                <tr>
                                                                                    <th scope="row">{{ $j++ }}</th>
                                                                                    <td>
                                                                                        <a href="#" onclick="getTrademarkDetails(event, {{ $trademark->id }})">
                                                                                            {!! str_replace($trademark->_filtered['highlights'][0], '<span style="background-color:#c0ffc8;">'.$trademark->_filtered['highlights'][0].'</span>', $trademark->name) !!}
                                                                                        </a>
                                                                                    </td>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    <div id="pagination-container3"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-center">{{ __('search.no_results_found') }}</p>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="modal fade" id="trademark-details"
                                     tabindex="-1" role="dialog"
                                     aria-labelledby="trademark-details-label"
                                     aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    {{-- {{ $trademark->name }} --}}
                                                </h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12 text-center mb-3">
                                                    <img id="trademark_img"
                                                         src=""
                                                         loading="lazy" alt="img"
                                                         class="img-thumbnail text-center"
                                                         style="max-height:200px;"></div>
                                                <h6>{{ __('theme/search.app-no')}}</h6>
                                                <p id="application_no"></p>
                                                <h6>{{ __('theme/search.app-date')}}</h6>
                                                <p id="application_date"></p>
                                                <h6>{{ __('theme/search.classes')}}</h6>
                                                <p id="nice_classes"></p>
                                                <h6>{{ __('theme/search.vienna-classes')}}</h6>
                                                <p id="vienna_classes"></p>
                                                <h6>{{ __('theme/search.proxy-info')}}</h6>
                                                <p id="attorney"></p>
                                                <h6>{{ __('theme/search.brand-owner-info')}}</h6>
                                                <p id="holder"></p>
                                                <p id="holder_details"></p>
                                                <p id="holder_address"></p>
                                                <h6>{{ __('theme/search.goods-and-services')}}</h6>
                                                <p id="good_description"></p>
                                                <h6>{{ __('theme/search.denied-goods-and-services')}}</h6>
                                                <p id="extracted_good_description"></p>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('theme/search.close')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif
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
    <script>


        $(document).ready(function() {
            var $tableRows = $('#my-table tbody tr');
            var totalRows = $tableRows.length;
            var currentPage = 1;
            var rowsPerPage = 18;

            // Initialize pagination plugin
            $('#pagination-container').twbsPagination({
                totalPages: Math.ceil(totalRows / rowsPerPage),
                visiblePages: 5,
                onPageClick: function(event, page) {
                    currentPage = page;
                    // Hide all rows and show only the ones for the current page
                    $tableRows.hide().slice((currentPage - 1) * rowsPerPage, currentPage * rowsPerPage).show();
                }
            });

            var $tableRows2 = $('#my-table2 tbody tr');
            var totalRows2 = $tableRows2.length;
            var currentPage2 = 1;
            var rowsPerPage2 = 18;

            // Initialize pagination plugin
            $('#pagination-container2').twbsPagination({
                totalPages: Math.ceil(totalRows2 / rowsPerPage2),
                visiblePages: 5,
                onPageClick: function(event, page2) {
                    currentPage2 = page2;
                    // Hide all rows and show only the ones for the current page
                    $tableRows2.hide().slice((currentPage2 - 1) * rowsPerPage2, currentPage2 * rowsPerPage2).show();
                }
            });


            var $tableRows3 = $('#my-table3 tbody tr');
            var totalRows3 = $tableRows3.length;
            var currentPage3 = 1;
            var rowsPerPage3 = 18;
            $('#pagination-container3').twbsPagination({
                totalPages: Math.ceil(totalRows3 / rowsPerPage3),
                visiblePages: 5,
                onPageClick: function(event, page3) {
                    currentPage3 = page3;
                    // Hide all rows and show only the ones for the current page
                    $tableRows3.hide().slice((currentPage3 - 1) * rowsPerPage3, currentPage3 * rowsPerPage3).show();
                }
            });
        });


        function getTrademarkDetails(event,trademarkId) {
            $.ajax({
                url: '{{ route('trademark.details', ['language' => app()->getLocale()]) }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: trademarkId
                },
                success: function (response) {

                    if(response.status == 'success'){
                        // set text
                        $('#application_no').text(response.data.application_no)
                        $('#application_date').text(response.data.application_date)
                        $('#nice_classes').text(response.data.nice_classes)
                        $('#vienna_classes').text(response.data.vienna_classes)
                        $('#attorney').text(response.data.attorney_no+' '+response.data.attorney_name+' '+response.data.attorney_title)
                        $('#holder').text(response.data.holder_tpec_client_id+' '+response.data.holder_title)
                        $('#holder_details').text(response.data.holder_city+' '+response.data.holder_state+' '+response.data.holder_postal_code+' '+response.data.holder_country_no)
                        $('#holder_address').text(response.data.holder_address)
                        $('#good_description').text(response.data.good_description)
                        $('#extracted_good_description').text(response.data.extracted_good_description)
                        $('#trademark_img').attr('src',response.data.image_reel_path)

                        $('#trademark-details').modal('show')
                    }
                }
            });
        }


    </script>

@endsection
<style>
    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination ,.pagination2 ,.pagination3{
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .page-numbers ,.page-numbers2 ,.page-numbers3{
        display: flex;
        flex-wrap: wrap;
        margin-right: 10px;
    }

    .page, .prev-page, .next-page , .page2, .prev-page2, .next-page2 ,.page3, .prev-page3 ,.next-page3{
        background-color: #f2f2f2;
        border: none;
        color: black;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }
    .next-page,.next-page2 ,.next-page3{
        margin-left: -6px;
    }

    .active-page ,.active-page2,.active-page3 {
        background-color: #4650dd;
        color: white;
    }

    @media only screen and (max-width: 425px) {
        .pagination ,.pagination2 ,.pagination3{
            flex-direction: column;
            align-items: center;
        }

        .page-numbers,.page-numbers2 ,.page-numbers3 {
            margin-right: 0;
            margin-bottom: 10px;
        }
    }

</style>

<html>

<head>
    <style>
        * {
            font-family: poppins, "Dejavu Sans";
        }

        table {
            border-collapse: collapse;
            width: 100%;
            /* page-break-inside: avoid; */
        }

        strong {
            font-weight: bolder;
        }

        hr {
            height: 1px;
            margin: 1rem 0;
            color: inherit;
            background-color: currentColor;
            border: 0;
            opacity: .25;
        }

        .bg-gray-600 {
            background-color: #6c757d !important;
        }

        .my-5 {
            margin-top: 2rem !important;
            margin-bottom: 2rem !important;
        }

        .text-uppercase {
            text-transform: uppercase;
            letter-spacing: .2em;
        }

        .text-muted {
            --bs-text-opacity: 1;
            color: #6c757d !important;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid transparent;
            border-radius: 1rem;
        }

        .card-table thead th {
            text-transform: uppercase;
            color: #fff;
            border-bottom-width: 0;
            background: #343a40;
            font-size: 12px;
            text-align: center;
            padding: 5px 0;
        }

        .card-table tbody tr td {
            font-size: 12px;
            padding: 0;
            margin: 0;
            text-align: center;
            padding: 5px 3px;
        }

        @page {
            margin: 20;
        }
    </style>
</head>

<body>
    @isset($similarity)
        <h5 class="card-heading">{{ __('theme/images.search.result.main-title') }}</h5>

        <section style="page-break-before:always">
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
                        @foreach ($similarity as $key => $type)
                            <h3 class="text-center mt-5">
                                @switch($key)
                                    @case('phash_similarity')
                                        {{ __('theme/images.search.result.phash') }}
                                    @break

                                    @case('histogram_similarity')
                                        {{ __('theme/images.search.result.histogram') }}
                                    @break

                                    @case('color_similarity')
                                        {{ __('theme/images.search.result.dominant-color') }}
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
                            <table>
                                <tr>
                                    @foreach ($type as $compare)
                                        <td>
                                            <h6>{{ $compare['trademark']->name }}</h6>
                                            <img
                                                style="max-width:150px"src="{{ base_path() }}/public/storage/bulletins/{{ replaceLastSlash($compare['trademark']->image_path) }}" />
                                            @if ($key == 'phash_similarity')
                                                <p>
                                                    {{ __('theme/images.search.result.phash') }} :
                                                    <strong>{{ number_format($compare['phash_similarity'], 2) }}%11</strong>
                                                </p>
                                            @endif
                                            @if ($key == 'histogram_similarity')
                                                <p>
                                                    {{ __('theme/images.search.result.histogram') }} :
                                                    <strong>{{ number_format($compare['histogram_similarity'], 2) }}%22</strong>
                                                </p>
                                            @endif
                                            @if ($key == 'color_similarity')
                                                @if (count($compare['color_similarity']) > 0)
                                                    <p>{{ __('theme/images.search.result.dominant-color') }}</p>
                                                    @foreach ($compare['color_similarity'] as $color_similarity)
                                                        {{-- <div
                                                            style="margin:5px;width:30px;height:30px;background-color:{{ $color_similarity['color'] }}">
                                                        </div>

                                                        <div
                                                            style="margin:5px;width:30px;height:30px;background-color:{{ $color_similarity['color2'] }}">
                                                        </div> --}}
                                                        <p>
                                                            <strong>{{ number_format($color_similarity['similarity'], 2) }}%</strong>
                                                        </p>
                                                        <p>{{ $color_similarity['color2'] }}</p>
                                                    @endforeach
                                                @endif
                                            @else
                                                <p>
                                                    {{ __('theme/images.search.result.similarity-not-found') }}
                                                </p>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endisset
    <section class="mb-5">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div style="float:right">
                            <img src="{{ base_path() }}/public/images/pdf-logo.png" width="200" />
                        </div>
                        <div style="margin-top:50px">
                            <p>{!! __('theme/report.owner', ['name' => $data['user']->name]) !!}</p>
                            <p><strong>{{ $report->created_at->format('d-m-Y') }}</strong>
                                {{ __('theme/report.this-report') }}</p>
                        </div>
                        <hr class="bg-gray-600 my-5">
                        <p class="mb-5"><strong>{{ __('theme/report.report-information') }}</strong></p>
                        <p>{!! __('theme/report.total-keyword', ['count' => $data['user']->keywords->count()]) !!}</p>
                        <p>{!! __('theme/report.total-match', ['match' => $data['match_count']]) !!}</p>
                        <p>{{ __('theme/report.number-of-bulletins-inquired') }} :
                            <strong>{{ count($json['bulletins']) }}</strong>
                        </p>
                        <p>{{ __('theme/report.number-of-trademarks-inquired') }} :
                            <strong>{{ $json['totalTrademark'] }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Page Start --}}
    <section class="bultenler" style="margin-top:10px">
        <div class="card card-table mb-4 mt-4">
            <div class="card-header">
                <p class="card-heading"><strong>{{ __('theme/report.bulletins') }}</strong></p>
                <p class="mt-3 mb-0">{{ __('theme/report.bulletins-reviewed-in-this-report') }}</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" cellspacing="0">
                        <thead>
                            <tr style="border: 1pt solid #e8ebee">
                                <th>{{ __('theme/report.id') }}</th>
                                <th>{{ __('theme/report.bulletin') }}</th>
                                <th>{{ __('theme/report.number-of-trademarks') }}</th>
                                <th>{{ __('theme/report.bulletin-date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($json['bulletins'] as $key => $bulletin)
                                <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                    <td>#{{ $key + 1 }}</td>
                                    <td>{{ substr($bulletin['name'], 0, 3) }}
                                        {{ __('theme/report.official-trademark-bulletin-no') }}</td>
                                    <td>{{ $bulletin['total'] }}</td>
                                    <td>{{ Carbon\Carbon::parse($bulletin['created_at'])->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="qrcode-container" style="position:absolute;bottom:0;width:100%;text-align:center">
                <img src="data:image/png;base64, {!! $qrcode !!}">
                <p><i style="font-size:12px">{{ __('theme/report.qr-code') }}</i>
                </p>
            </div>
        </div>
    </section>
    @if (count($json['reports']) <= 100)

        <section style="page-break-before: always">
            <div class="card card-table mb-4 mt-4">
                <div class="card-header">
                    <p class="card-heading">{{ __('theme/report.keywords-searched') }}</p>
                    <p class="mt-3 mb-0"><i>{{ __('theme/report.report-details') }}</i></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" cellspacing="0">
                            <thead>
                                <tr style="border: 1pt solid #e8ebee">
                                    <th>{{ __('theme/report.id') }}</th>
                                    <th>{{ __('theme/report.keyword') }}</th>
                                    <th>{{ __('theme/report.number-of-similar-trademarks') }}</th>
                                    <th>{{ __('theme/report.nice-classes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($json['reports'] as $key => $keyword)
                                    <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                        <td>#{{ $key + 1 }}</td>
                                        <td>{{ $keyword['keyword']['keyword'] }}</td>
                                        </td>
                                        <td>{{ count($keyword['keyword']['trademarks']) }}</td>
                                        @php
                                            $niceClasses = implode(',', $keyword['keyword']['classes'] ?? []);
                                        @endphp
                                        @isset($keyword['keyword']['classes'])
                                            <td style="max-width:250px">
                                                {{ $niceClasses != '' ? $niceClasses : 'Tüm nice sınıflarında arama yapılmıştır.' }}
                                            </td>
                                        @else
                                            <td></td>
                                        @endisset
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        @php
            $counter = 1;
        @endphp
        @foreach ($json['reports'] as $key => $report)
            {{-- @if (isset($report['keyword']['trademarks']) != null && count($report['keyword']['trademarks']) > 0) --}}
            @if (count($json['reports']) <= 100)
                <section id="keyword-{{ $report['keyword']['id'] }}">
                    <div class="card card-table mb-4">
                        <div class="card-header" style="page-break-inside:avoid">
                            {{-- p.card-heading : 50px --}}
                            <p class="card-heading">({{ $report['keyword']['keyword'] }})
                                {{ __('theme/report.trademarks-similar-to-your-keywords') }}</p>
                            @if (isset($report['trademarks']) != null)
                                <p class="mt-3 mb-0"><i>{{ __('theme/report.detailed-information') }}</i>
                                </p>
                            @endif
                            <table class="table table-hover mb-0">
                                <thead>
                                    {{-- tr height : 26.31px --}}
                                    <tr style="border: 1pt solid #e8ebee">
                                        <th>{{ __('theme/report.id') }}</th>
                                        <th>{{ __('theme/report.trademark') }}</th>
                                        <th>{{ __('theme/report.application-number') }}</th>
                                        <th>{{ __('theme/report.application-date') }}</th>
                                        <th>{{ __('theme/report.bulletin-no') }}</th>
                                        <th>{{ __('theme/report.international-no') }}</th>
                                        <th>{{ __('theme/report.nice-classes') }}</th>
                                        <th>{{ __('theme/report.vienna-classes') }}</th>
                                        {{-- <th>{{ __('theme/report.matched-words') }}</th> --}}
                                    </tr>
                                </thead>
                                @if (isset($report['keyword']['trademarks']) != null && count($report['keyword']['trademarks']) > 0)
                                    <tbody>
                                        <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                            <td style="width:12.5%">#{{ $counter }}</td>
                                            <td style="width:12.5%">
                                                {{ $report['keyword']['trademarks'][array_key_first($report['keyword']['trademarks'])]['name'] }}
                                            </td>
                                            <td style="width:12.5%">
                                                {{ $report['keyword']['trademarks'][array_key_first($report['keyword']['trademarks'])]['application_no'] }}
                                            </td>
                                            <td style="width:12.5%">
                                                {{ $report['keyword']['trademarks'][array_key_first($report['keyword']['trademarks'])]['application_date'] }}
                                            </td>
                                            @foreach ($json['bulletins'] as $js)
                                                @if ($report['keyword']['trademarks'][array_key_first($report['keyword']['trademarks'])]['bulletin_id'] === $js['id'])
                                                    <td style="width:12.5%">{{ substr($js['name'], 0, 3) }}</td>
                                                @else
                                                    <td style="width:12.5%"></td>
                                                @endif
                                            @endforeach
                                            <td style="width:12.5%">
                                                {{ $report['keyword']['trademarks'][array_key_first($report['keyword']['trademarks'])]['intreg_no'] }}
                                            </td>
                                            <td style="width:12.5%">
                                                {{ $report['keyword']['trademarks'][array_key_first($report['keyword']['trademarks'])]['nice_classes'] }}
                                            </td>
                                            <td style="width:12.5%">
                                                {{ $report['keyword']['trademarks'][array_key_first($report['keyword']['trademarks'])]['vienna_classes'] }}
                                            </td>
                                            {{-- <td>{{ implode(',', $report['keyword']['trademarks'][array_key_first($report['keyword']['trademarks'])]['_filtered']['matches'] ?? []) }}</td> --}}
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <tbody>
                                        @if (isset($report['keyword']['trademarks']) != null && count($report['keyword']['trademarks']) > 0)
                                            @foreach ($report['keyword']['trademarks'] as $key => $trademark)
                                                @if (!$loop->first)
                                                    <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                                        <td style="width:12.5%">#{{ $counter }}</td>
                                                        <td style="width:12.5%">{{ $trademark['name'] }}</td>
                                                        <td style="width:12.5%">{{ $trademark['application_no'] }}</td>
                                                        <td style="width:12.5%">{{ $trademark['application_date'] }}
                                                        </td>
                                                        @foreach ($json['bulletins'] as $js)
                                                            @if ($trademark['bulletin_id'] === $js['id'])
                                                                <td style="width:12.5%">
                                                                    {{ substr($js['name'], 0, 3) }}
                                                                </td>
                                                            @else
                                                                <td style="width:12.5%"></td>
                                                            @endif
                                                        @endforeach
                                                        <td style="width:12.5%">{{ $trademark['intreg_no'] }}</td>
                                                        <td style="width:12.5%">{{ $trademark['nice_classes'] }}</td>
                                                        <td style="width:12.5%">{{ $trademark['vienna_classes'] }}
                                                        </td>
                                                        {{-- <td>{{ implode(',', $trademark['_filtered']['matches'] ?? []) }}</td> --}}
                                                    </tr>
                                                @endif
                                                @php
                                                    $counter++;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr style="border: 1pt solid #e8ebee">
                                                <td colspan="11" class="text-center">
                                                    {{ __('theme/report.no-similar-trademark-found') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
        <section style="page-break-before: always">
            <div class="card card-table mb-4 mt-4">
                <div class="card-header">
                    <p class="card-heading">{{ __('theme/report.keywords-searched') }}</p>
                    <p class="mt-3 mb-0"><i>{{ __('theme/report.report-details') }}</i></p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" cellspacing="0">
                            <thead>
                                <tr style="border: 1pt solid #e8ebee">
                                    <th>{{ __('theme/report.id') }}</th>
                                    <th>{{ __('theme/report.keyword') }}</th>
                                    <th>{{ __('theme/report.number-of-similar-trademarks') }}</th>
                                    <th>{{ __('theme/report.nice-classes') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($json['reports'] as $key => $keyword)
                                    <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                        <td>#{{ $key + 1 }}</td>
                                        <td>{{ $keyword['keyword']['keyword'] }}</td>
                                        </td>
                                        <td>{{ count($keyword['keyword']['trademarks']) }}</td>
                                        @php
                                            $niceClasses = implode(',', $keyword['keyword']['classes'] ?? []);
                                        @endphp
                                        @isset($keyword['keyword']['classes'])
                                            <td style="max-width:250px">
                                                {{ $niceClasses != '' ? $niceClasses : 'Tüm nice sınıflarında arama yapılmıştır.' }}
                                            </td>
                                        @else
                                            <td></td>
                                        @endisset
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    @endif

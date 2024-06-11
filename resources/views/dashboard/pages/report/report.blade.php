<html>

<head>
    <style>
        * {
            font-family: poppins, "Dejavu Sans";
        }
    </style>
</head>

<body>
    <section class="mb-5">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <p>{!! __('theme/report.owner', ['name' => auth()->user()->name]) !!}</p>
                        <p>
                            {!! __('theme/report.this-report', ['date' => $report->created_at->format('d-m-Y')]) !!}</p>
                        <hr class="bg-gray-600 my-4">
                        @if (count($json['userImages'] ?? []) == 0)
                            <p>{!! __('theme/report.total-keyword', [
                                'count' => auth()->user()->keywords->count(),
                            ]) !!}
                            </p>
                            <p>{!! __('theme/report.total-match', ['match' => $data['match_count']]) !!}</p>
                        @else
                            <p>{!! __('theme/report.total-keyword-and-images', [
                                'count' => auth()->user()->keywords->count(),
                                'count2' => count($json['userImages']),
                            ]) !!}
                            </p>
                            <p>{!! __('theme/report.total-match', ['match' => $data['match_count']]) !!}</p>
                        @endif
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
    <section class="bultenler">
        <div class="card card-table mb-4 mt-4">
            <div class="card-header">
                <p class="card-heading"> {{ __('theme/report.bulletins') }}</p>
                <p class="mt-3 mb-0"><i>{{ __('theme/report.bulletins-reviewed-in-this-report') }}</i></p>
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
        </div>
    </section>
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
                                <th>{{ __('theme/report.date-of-upload') }}</th>
                                <th>{{ __('theme/report.number-of-similar-trademarks') }}</th>
                                <th>{{ __('theme/report.nice-classes') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($json['reports'] as $key => $keyword)
                                <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                    <td>#{{ $key + 1 }}</td>
                                    <td><a class="lastClicked" keyword-id="{{ $keyword['keyword']['id'] }}"
                                            href="#keyword-{{ $keyword['keyword']['id'] }}">{{ $keyword['keyword']['keyword'] }}</a>
                                    </td>
                                    <td>{{ Carbon\Carbon::parse($keyword['keyword']['created_at'])->format('d-m-Y') }}
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
    @isset($json['userImages'])
        {{-- image search section --}}
        <section id="image-search">
            <div class="card card-table mb-4 mt-4">
                <div class="card-header">
                    <p class="card-heading">{{ __('theme/images.search.title') }}</p>
                    <p class="mt-3"><i>{!! __('theme/images.search.result.beta-text') !!}</i>
                    </p>
                    <p style="">{!! __('theme/images.search.result.beta-contact-text') !!}</p>

                    <p style="">{!! __('theme/images.search.result.result-text', ['count' => 18]) !!}</p>

                    <p>
                        <strong>{{ __('theme/images.search.result.phash') }}</strong> :
                        {{ __('theme/images.search.result.phash-info') }}
                    </p>
                    <p>
                        <strong>{{ __('theme/images.search.result.histogram') }}</strong> :
                        {{ __('theme/images.search.result.histogram-info') }}
                    </p>
                    <p>
                        <strong>{{ __('theme/images.search.result.dominant-color') }}</strong> :
                        {{ __('theme/images.search.result.dominant-color-info') }}
                    </p>
                </div>
                <div class="row">
                    @if (count($json['userImages']) > 6)
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" cellspacing="0">
                                        <thead>
                                            <tr style="border: 1pt solid #e8ebee">
                                                <th>{{ __('theme/images.search.result.order') }}</th>
                                                <th>{{ __('theme/images.search.result.title') }}</th>
                                                <th>{{ __('theme/images.search.result.image') }}</th>
                                                <th>{{ __('theme/images.search.result.searched-bulletin') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (array_slice($json['userImages'], 0, 5) as $key => $userImage)
                                                <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                                    <td>#{{ $key + 1 }}</td>
                                                    <td><a
                                                            href="#image-{{ $key + 1 }}-{{ $userImage['id'] }}">{{ $userImage['title'] }}</a>
                                                    </td>
                                                    <td><a href="#image-{{ $key + 1 }}-{{ $userImage['id'] }}"><img
                                                                style="max-width:50px;max-height:50px"src="{{ url('storage/' . $userImage['path']) }}" /></a>
                                                    </td>
                                                    <td>
                                                        <p style=";margin-left:4px;margin-bottom:0">432</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" cellspacing="0">
                                        <thead>
                                            <tr style="border: 1pt solid #e8ebee">
                                                <th>{{ __('theme/images.search.result.order') }}</th>
                                                <th>{{ __('theme/images.search.result.title') }}</th>
                                                <th>{{ __('theme/images.search.result.image') }}</th>
                                                <th>{{ __('theme/images.search.result.searched-bulletin') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (array_slice($json['userImages'], 5, 10) as $key => $userImage)
                                                <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                                    <td>#{{ $key + 6 }}</td>
                                                    <td><a
                                                            href="#image-{{ $key + 6 }}-{{ $userImage['id'] }}">{{ $userImage['title'] }}</a>
                                                    </td>
                                                    <td><a href="#image-{{ $key + 6 }}-{{ $userImage['id'] }}"><img
                                                                style="max-width:50px;max-height:50px"src="{{ url('storage/' . $userImage['path']) }}" /></a>
                                                    </td>
                                                    <td>
                                                        <p style=";margin-left:4px;margin-bottom:0">432</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0" cellspacing="0">
                                        <thead>
                                            <tr style="border: 1pt solid #e8ebee">
                                                <th>{{ __('theme/images.search.result.order') }}</th>
                                                <th>{{ __('theme/images.search.result.title') }}</th>
                                                <th>{{ __('theme/images.search.result.image') }}</th>
                                                <th>{{ __('theme/images.search.result.searched-bulletin') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (array_slice($json['userImages'], 0, 5) as $key => $userImage)
                                                <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                                    <td>#{{ $key + 1 }}</td>
                                                    <td><a
                                                            href="#image-{{ $key + 1 }}-{{ $userImage['id'] }}">{{ $userImage['title'] }}</a>
                                                    </td>
                                                    <td><a href="#image-{{ $key + 1 }}-{{ $userImage['id'] }}"><img
                                                                style="max-width:50px;max-height:50px"src="{{ url('storage/' . $userImage['path']) }}" /></a>
                                                    </td>
                                                    <td>
                                                        <p style=";margin-left:4px;margin-bottom:0px">432</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
        <div class="row">
            @foreach ($json['userImages'] as $key => $image)
                <section id="image-{{ $key + 1 }}-{{ $image['id'] }}">
                    <div class="card card-table mb-4 mt-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" cellspacing="0">
                                    <thead>
                                        <tr style="border: 1pt solid #e8ebee">
                                            <th>{{ __('theme/images.search.result.order') }}</th>
                                            <th>{{ __('theme/images.search.result.title') }}</th>
                                            <th>{{ __('theme/images.search.result.image') }}</th>
                                            <th>{{ __('theme/images.search.result.searched-bulletin') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <p style="margin-left:4px;margin-bottom:0">{{ $image['title'] }}</p>
                                            </td>
                                            <td><img
                                                    style="max-width:75px;max-height:75px"src="{{ url('storage/' . $image['path']) }}" />
                                            </td>
                                            <td>
                                                <p style="margin-left:4px;margin-bottom:0">432</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="row p-5 pt-3">
                                        <h3 class="text-center mb-3"><strong>{{ __('theme/images.search.result.phash') }}</strong></h3>
                                        @foreach ($image['similarities']['phash'] as $compare)
                                            <div class="col-md-2 col-sm-6 text-center">
                                                <p style="height:20px">
                                                    <a href="#"
                                                        style="text-decoration: none">{{ $compare['trademark']['application_no'] }}</a>
                                                </p>

                                                <div style="min-height:50px;min-width:50px">
                                                    <img
                                                        style=  "max-width:50px;max-height:50px"src="{{ url('storage/bulletin') . '/' . replaceLastSlash($compare['trademark']['image_path']) }}" />
                                                </div>
                                                <p>
                                                    {{ number_format($compare['similarity'], 0) }}%
                                                </p>
                                                <p>
                                                    <i>({{ truncateText($compare['trademark']['name']) }})</i>
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row">
                                        <div class="row p-5 pt-3">
                                            <h3 class="text-center mb-3"><strong>{{ __('theme/images.search.result.histogram') }}</strong></h3>
                                            @foreach ($image['similarities']['histogram'] as $compare)
                                                <div class="col-md-2 col-sm-6 text-center">
                                                    <p style="height:20px">
                                                        <a href="#"
                                                            style="text-decoration: none">{{ $compare['trademark']['application_no'] }}</a>
                                                    </p>

                                                    <div style="min-height:50px;min-width:50px">
                                                        <img
                                                            style=  "max-width:50px;max-height:50px"src="{{ url('storage/bulletin') . '/' . replaceLastSlash($compare['trademark']['image_path']) }}" />
                                                    </div>
                                                    <p>
                                                        {{ number_format($compare['similarity'], 2) * 100 }}%
                                                    </p>
                                                    <p>
                                                        <i>({{ truncateText($compare['trademark']['name']) }})</i>
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="row p-5 pt-3">
                                        <h3 class="text-center mb-3"><strong>{{ __('theme/images.search.result.dominant-color') }}</strong></h3>
                                        @foreach (array_slice($image['similarities']['dominant_colors'], 0, 3) as $compare)
                                            <div class="col-md-4 col-sm-6 text-center">
                                                <div>
                                                    <p style="height:20px">
                                                        <a href="#"
                                                            style="text-decoration: none">{{ $compare['trademark']['application_no'] }}</a>
                                                    </p>

                                                    <div style="min-height:50px;min-width:50px">
                                                        <img
                                                            style=  "max-width:50px;max-height:50px"src="{{ url('storage/bulletin') . '/' . replaceLastSlash($compare['trademark']['image_path']) }}" />
                                                    </div>
                                                    <p style="height:50px">
                                                        <i>({{ truncateText($compare['trademark']['name']) }})</i>
                                                    </p>
                                                </div>
                                                @foreach (array_slice($compare['similarity'],0,4)  as $color_similarity)
                                                    <div class="d-flex justify-content-center">
                                                        <div
                                                            style="width:20px;height:20px;background-color:{{ $color_similarity['color'] }}">
                                                        </div>
                                                        <div
                                                            style="width:20px;height:20px;background-color:{{ $color_similarity['color2'] }}">
                                                        </div>
                                                        <p style="margin-left:5px;padding:0">
                                                            {{ number_format($color_similarity['similarity'], 2) }}%
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="row p-5 pt-3">
                                        @foreach (array_slice($image['similarities']['dominant_colors'], 3, 6) as $compare)
                                            <div class="col-md-4 col-sm-6 text-center">
                                                <div>
                                                    <p style="height:20px">
                                                        <a href="#"
                                                            style="text-decoration: none">{{ $compare['trademark']['application_no'] }}</a>
                                                    </p>

                                                    <div style="min-height:50px;min-width:50px">
                                                        <img
                                                            style=  "max-width:50px;max-height:50px"src="{{ url('storage/bulletin') . '/' . replaceLastSlash($compare['trademark']['image_path']) }}" />
                                                    </div>
                                                    <p style="height:50px">
                                                        <i>({{ truncateText($compare['trademark']['name']) }})</i>
                                                    </p>
                                                </div>
                                                @foreach (array_slice($compare['similarity'],0,4) as $color_similarity)
                                                    <div class="d-flex justify-content-center">
                                                        <div
                                                            style="width:20px;height:20px;background-color:{{ $color_similarity['color'] }}">
                                                        </div>
                                                        <div
                                                            style="width:20px;height:20px;background-color:{{ $color_similarity['color2'] }}">
                                                        </div>
                                                        <p style="margin-left:5px;padding:0">
                                                            {{ number_format($color_similarity['similarity'], 2) }}%
                                                        </p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
            @endforeach
        </div>
    @endisset
    @php
        $counter = 1;
    @endphp
    @foreach ($json['reports'] as $key => $report)
        @if (isset($report['keyword']['trademarks']) != null && count($report['keyword']['trademarks']) > 0)
            <section id="keyword-{{ $report['keyword']['id'] }}">
                <div class="card card-table mb-4">
                    <div class="card-header">
                        <p class="card-heading">({{ $report['keyword']['keyword'] }})
                            {{ __('theme/report.trademarks-similar-to-your-keywords') }}</p>
                        @if (isset($report['trademarks']) != null)
                            <p class="mt-3 mb-0"><i>{{ __('theme/report.detailed-information') }}</i>
                            </p>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" cellspacing="0" cellspacing="0">
                                <thead>
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
                                <tbody>
                                    @if (isset($report['keyword']['trademarks']) != null && count($report['keyword']['trademarks']) > 0)
                                        @foreach ($report['keyword']['trademarks'] as $key => $trademark)
                                            <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                                <td>#{{ $counter }}</td>
                                                <td><a class="lastClicked" trademark-id="{{ $trademark['id'] }}"
                                                        href="#trademark-detail-{{ $trademark['id'] }}">{{ $trademark['name'] }}</a>
                                                </td>
                                                <td>{{ $trademark['application_no'] }}</td>
                                                <td>{{ $trademark['application_date'] }}</td>
                                                @foreach ($json['bulletins'] as $js)
                                                    @if ($trademark['bulletin_id'] === $js['id'])
                                                        <td>{{ substr($js['name'], 0, 3) }}</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                @endforeach
                                                <td>{{ $trademark['intreg_no'] }}</td>
                                                <td>{{ $trademark['nice_classes'] }}</td>
                                                <td>{{ $trademark['vienna_classes'] }}</td>
                                                {{-- <td>{{ implode(',', $trademark['_filtered']['matches'] ?? []) }}</td> --}}
                                            </tr>
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


    @foreach ($json['reports'] as $key => $report)
        @if (isset($report['keyword']['trademarks']) != null)
            @foreach ($report['keyword']['trademarks'] as $trademark)
                <section>
                    <div class="card card-table mb-4 trademark" id="trademark-detail-{{ $trademark['id'] }}"
                        style="background-color: #f5f5f5!important">
                        <p style="padding:15px;font-size: 16px;font-weight: 500" class="card-heading trademark-title">
                            {{ $trademark['name'] }} #{{ $trademark['application_no'] }}</p>
                        <div class="card-body">
                            <div>
                                <div class="p-5" id="trademark-{{ $key + 1 }}">
                                    <div class="col-md-12 text-center mb-4">
                                        <img src="{{ url('storage/bulletin/' . preg_replace('/\/([^\/]*)$/', '_$1', $trademark['image_path'])) }}"
                                            loading="lazy" alt="img" class="img-thumbnail text-center"
                                            style="max-height:300px;">
                                    </div>
                                    @if ($trademark['holder_tpec_client_id'])
                                        <p class="text-uppercase mb-4 text-center"
                                            style="font-weight: 400; color: #3d4345">
                                            {{ __('theme/report.owner-information') }}</p>
                                        <p style="line-height: 13px; font-weight: 400;">
                                            <span class="text-uppercase text-muted"
                                                style="font-size: 14px;">{{ __('theme/report.title') }}:</span>
                                            {{ $trademark['holder_title'] }}
                                        </p>
                                        <p>
                                        <p style="line-height: 13px; font-weight: 400;">
                                            <span class="text-uppercase text-muted"
                                                style="font-size: 14px;">{{ __('theme/report.address') }}:</span>
                                            {{ $trademark['holder_address'] }}
                                        </p>
                                        <p>
                                        <p style="line-height: 13px; font-weight: 400;">
                                            <span class="text-uppercase text-muted"
                                                style="font-size: 14px;">{{ __('theme/report.state') }}:</span>
                                            {{ $trademark['holder_state'] }}
                                        </p>
                                        <p style="line-height: 13px; font-weight: 400;">
                                            <span class="text-uppercase text-muted"
                                                style="font-size: 14px;">{{ __('theme/report.post-code') }}:</span>
                                            {{ $trademark['holder_postal_code'] }}
                                        </p>
                                        <p style="line-height: 13px; font-weight: 400;">
                                            <span class="text-uppercase text-muted"
                                                style="font-size: 14px;">{{ __('theme/report.city') }}:</span>
                                            {{ $trademark['holder_city'] }}
                                        </p>
                                        <p style="line-height: 13px; font-weight: 400;">
                                            <span class="text-uppercase text-muted"
                                                style="font-size: 14px;">{{ __('theme/report.country-code') }}:</span>
                                            {{ $trademark['holder_country_no'] }}
                                        </p>
                                        @if ($trademark['attorney_no'])
                                            <p style="line-height: 13px; font-weight: 400;">
                                                <span class="text-uppercase text-muted"
                                                    style="font-size: 14px;">{{ __('theme/report.proxy') }}:</span>
                                                {{ $trademark['attorney_name'] }}
                                            </p>
                                        @endif
                                    @endif
                                    @if ($trademark['good_class_id'])
                                        <p class="text-uppercase mb-4 text-center"
                                            style="font-weight: 400;color:#3d4345">
                                            {{ __('theme/report.good-and-services') }}</p>
                                        <p style="line-height: 20px;font-size: 13px;">
                                            <span class="text-uppercase text-muted"
                                                style="font-size: 14px;">{{ __('theme/report.good-and-services') }}:</span>
                                            {{ $trademark['good_description'] }}
                                        </p>
                                    @endif
                                    @if ($trademark['extracted_good_class_id'])
                                        <p class="text-uppercase mb-4 text-center"
                                            style="font-weight: 400;color:#3d4345">
                                            {{ __('theme/report.rejected-goods-and-services') }}</p>
                                        <p style="line-height: 20px;font-size: 13px">
                                            <span class="text-uppercase text-muted"
                                                style="font-size: 14px; font-weight: 400">{{ __('theme/report.rejected-goods-and-services') }}:</span>
                                            {{ $trademark['extracted_good_description'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
        @endif
    @endforeach

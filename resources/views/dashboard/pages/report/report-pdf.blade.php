<html>

<head>
    <style>
        * {
            font-family: poppins, "Dejavu Sans";
        }

        table {
            border-collapse: collapse;
            width: 100%;
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

        .bg-image {
            background-repeat: repeat;
        }
    </style>
</head>

<body>

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
                        <p>Bu rapor tarihi itibariyle takip ettiğiniz <strong>{{ count($json['reports']) }}</strong> marka,
                            <strong>{{ $userImages->count() }}</strong> şekil
                            bulunmaktadır.
                        </p>
                        <p>
                            {!! __('theme/report.total-match', ['match' => $data['match_count']]) !!}
                        </p>
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
                <p><i style="font-size:12px">QR Kodu okutarak site üzerinden raporu daha detaylı inceleyebilirsiniz</i></p>
            </div>
        </div>
    </section>
    @if (count($json['reports']) <= 300)

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
                                    <th>TAM EŞLEŞME</th>
                                    <th>İSTENMEYEN KELİMELER</th>
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
                                        <td>{{ $keyword['keyword']['exatchMatch'] }}</td>
                                        <td>{{ $keyword['keyword']['exclusion_keywords'] }}</td>

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
            @if (count($json['reports']) <= 300)
                <section id="keyword-{{ $report['keyword']['id'] }}">
                    <div class="card card-table mb-4">
                        <div class="card-header" style="page-break-inside:avoid">
                            {{-- p.card-heading : 50px --}}
                            <p class="card-heading">({{ $report['keyword']['keyword'] }})
                                {{ __('theme/report.trademarks-similar-to-your-keywords') }}</p>
                            <p style="font-size:12px;margin-top:0">
                                <i>
                                    bülten:436
                                    @if ($report['keyword']['filtered_classes'] != '')
                                        sınıf:{{ $report['keyword']['filtered_classes'] }}
                                    @endif
                                    @if ($report['keyword']['exatchMatch'] != '')
                                        +"{{ $report['keyword']['exatchMatch'] }}"
                                    @endif
                                    @if ($report['keyword']['exclusion_keywords'] != '')
                                        -{{ $report['keyword']['exclusion_keywords'] }}
                                    @endif
                                </i>
                            </p>
                            @if (isset($report['trademarks']) != null)
                                <p class="mt-3 mb-0"><i>{{ __('theme/report.detailed-information') }}</i>
                                </p>
                            @endif
                            <table class="table table-hover mb-0">
                                <thead>
                                    {{-- tr height : 26.31px --}}
                                    <tr style="border: 1pt solid #e8ebee;text-align:center">
                                        <th style="width:12.5%;text-align:center">{{ __('theme/report.id') }}</th>
                                        <th style="width:12.5%;text-align:center">{{ __('theme/report.trademark') }}
                                        </th>
                                        <th style="width:12.5%;text-align:center">
                                            {{ __('theme/report.application-number') }}</th>
                                        <th style="width:12.5%;text-align:center">
                                            {{ __('theme/report.application-date') }}</th>
                                        <th style="width:12.5%;text-align:center">{{ __('theme/report.bulletin-no') }}
                                        </th>
                                        <th style="width:12.5%;text-align:center">
                                            {{ __('theme/report.international-no') }}</th>
                                        <th style="width:12.5%;text-align:center">{{ __('theme/report.nice-classes') }}
                                        </th>
                                        <th style="width:12.5%;text-align:center">
                                            {{ __('theme/report.vienna-classes') }}</th>
                                        {{-- <th>{{ __('theme/report.matched-words') }}</th> --}}
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <tbody>
                                        @if (isset($report['keyword']['trademarks']) != null && count($report['keyword']['trademarks']) > 0)
                                            @foreach ($report['keyword']['trademarks'] as $key => $trademark)
                                                <tr style="border: 1pt solid #e8ebee">
                                                    <td style="width:12.5%">#{{ $counter }}</td>
                                                    <td style="width:12.5%">{{ $trademark['name'] }}</td>
                                                    <td style="width:12.5%">{{ $trademark['application_no'] }}</td>
                                                    <td style="width:12.5%">{{ $trademark['application_date'] }}</td>
                                                    @foreach ($json['bulletins'] as $js)
                                                        @if ($trademark['bulletin_id'] === $js['id'])
                                                            <td style="width:12.5%">{{ substr($js['name'], 0, 3) }}
                                                            </td>
                                                        @else
                                                            <td style="width:12.5%"></td>
                                                        @endif
                                                    @endforeach
                                                    <td style="width:12.5%">{{ $trademark['intreg_no'] ?? '' }}</td>
                                                    <td style="width:12.5%">{{ $trademark['nice_classes'] ?? '' }}</td>
                                                    <td style="width:12.5%">
                                                        @if ($trademark['vienna_classes'] == 'null')
                                                            &nbsp;test
                                                        @else
                                                            {{ str_replace(';', '; ', $trademark['vienna_classes']) ?? '' }}
                                                        @endif
                                                    </td>
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
    @endif
    @isset($userImages)
        @if($userImages->count() > 0)
        <section style="page-break-before:always" class="bg-image">
            <p><strong>ŞEKİLLER</strong></p>
            <p style="font-size:12px;"><i>Şekil ile arama özelliğimiz şu an için <strong>beta</strong> aşamasındadır. Bu
                    özellik ile arama
                    sonuçlarında karşılaşacağınız hataları lütfen bize bildiriniz.</i></p>
            <p style="font-size:12px">Yapılan arama sonucunda toplamda <strong>18</strong> marka eşleşmiştir, <strong>3
                    farklı</strong> başlıkta sonuçlar derlenmiştir.</p>

            <p style="font-size:12px">
                <strong>Renk Uyumu</strong> : Aradığınız görsellerin içeriğini temsil eden renk bileşenlerini kullanarak
                ilgili bültendeki markalar ile benzerliklerini karşılaştırır ve en benzer sınırlı sayıdaki sonucu size
                sunar.
            </p>
            <p style="font-size:12px">
                <strong>Şekil Benzerliği</strong> : Aradığınız görsellerdeki şekil benzerliği özelliklerini ilgili
                bültendeki
                markalara ait görsellerinkilerle karşılaştırma yaparak en benzer sınırlı sayıdaki sonucu size sunar.
            </p>
            <p style="font-size:12px">
                <strong>Baskın Renk Benzerliği</strong> : Aradığınız görsellerdeki renk yoğunluğu skalasını tespit eder
                ilgili
                bültendeki markalara ait görsellerin renk yoğunluğu ile karşılaştırma yaparak en benzer sınırlı sayıdaki
                sonucu size sunar.
            </p>
            <p style="margin-top:30px"><strong>TAKİP EDİLEN ŞEKİLLER</strong></p>
            <table class="card-table">
                <tr>
                    @if ($userImages->count() > 6)
                        <td>
                            <table>
                                <tr>

                                    <div class="card card-table mb-4 mt-4">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0" cellspacing="0">
                                                    <thead>
                                                        <tr style="border: 1pt solid #e8ebee">
                                                            <th>SIRA</th>
                                                            <th>ŞEKİL BAŞLIĞI</th>
                                                            <th>ŞEKİL</th>
                                                            <th>ARANAN BÜLTEN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($userImages->shift(5) as $key => $userImage)
                                                            <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                                                <td>
                                                                        <p style="font-size:12px;margin-left:4px">
                                                                            {{ $key + 1 }}</p>
                                                                </td>
                                                                <td>
                                                                        <p style="font-size:12px;margin-left:4px">
                                                                            {{ $userImage->title }}</p>
                                                                </td>
                                                                <td><img
                                                                        style="max-width:50px;max-height:50px"src="{{ base_path() }}/public/storage/{{ $userImage->path }}" />
                                                                </td>
                                                                <td>
                                                                    <p style="font-size:12px;margin-left:4px">436</p>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table>
                                <tr>

                                    <div class="card card-table mb-4 mt-4">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0" cellspacing="0">
                                                    <thead>
                                                        <tr style="border: 1pt solid #e8ebee">
                                                            <th>SIRA</th>
                                                            <th>ŞEKİL BAŞLIĞI</th>
                                                            <th>ŞEKİL</th>
                                                            <th>ARANAN BÜLTEN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($userImages as $key => $userImage)
                                                            <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                                                <td>
                                                                        <p style="font-size:12px;margin-left:4px">
                                                                            {{ $key + 6 }}</p>
                                                                </td>
                                                                <td>
                                                                        <p style="font-size:12px;margin-left:4px">
                                                                            {{ $userImage->title }}</p>
                                                                </td>
                                                                <td><img
                                                                        style="max-width:50px;max-height:50px"src="{{ base_path() }}/public/storage/{{ $userImage->path }}" />
                                                                </td>
                                                                <td>
                                                                    <p style="font-size:12px;margin-left:4px">436</p>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            </table>
                        </td>
                    @else
                        <td>
                            <table>
                                <tr>
                                    <div class="card card-table mb-4 mt-4">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover mb-0" cellspacing="0">
                                                    <thead>
                                                        <tr style="border: 1pt solid #e8ebee">
                                                            <th>SIRA</th>
                                                            <th>ŞEKİL BAŞLIĞI</th>
                                                            <th>ŞEKİL</th>
                                                            <th>ARANAN BÜLTEN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($userImages as $key => $userImage)
                                                            <tr class="align-middle" style="border: 1pt solid #e8ebee">
                                                                <td>
                                                                        <p style="font-size:12px;margin-left:4px">
                                                                            {{ $key + 1 }}</p>
                                                                </td>
                                                                <td>
                                                                        <p style="font-size:12px;margin-left:4px">
                                                                            {{ $userImage->title }}</p>
                                                                </td>
                                                                <td><img
                                                                        style="max-width:50px;max-height:50px"src="{{ base_path() }}/public/storage/{{ $userImage->path }}" />
                                                                </td>
                                                                <td>
                                                                    <p style="font-size:12px;margin-left:4px">436</p>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            </table>
                        </td>
                    @endif
                </tr>
            </table>
        </section>
        @endif
    @endisset

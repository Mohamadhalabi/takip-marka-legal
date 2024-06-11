<!DOCTYPE html>
<html lang="tr">

<head>
    @include('components.schema')
    @production
        @include('components.gtag')
    @endproduction
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('header.description', 'Türkpatent marka bülteni taramalarınızı otomatik yapın. Tüm markalarınızın takip raporu e-postanıza gelsin.')">
    <meta name="keywords" content="marka takip,marka izleme,marka bülteni takip,otomatik marka takibi,marka kontrol,markamı başka kullanan var mı">
    <meta name="author" content="takip.marka.legal">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="publisher" content="takip.marka.legal">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('header.title', env('APP_NAME').' - '.env('APP_TITLE'))">
    <meta name="twitter:description" content="@yield('header.description', 'Türkpatent marka bülteni taramalarınızı otomatik yapın. Tüm markalarınızın takip raporu e-postanıza gelsin.')">
    <meta name="twitter:image" content="https://takip.marka.legal/images/marka-takip-hizmeti.png">
    <meta property="og:title" content="@yield('header.title', env('APP_NAME').' - '.env('APP_TITLE'))">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://takip.marka.legal/">
    <meta property="og:image" content="https://takip.marka.legal/images/marka-takip-hizmeti.png">
    <meta property="og:description" content="@yield('header.description', 'Türkpatent marka bülteni taramalarınızı otomatik yapın. Tüm markalarınızın takip raporu e-postanıza gelsin.')">
    <meta property="og:site_name" content="takip.marka.legal">
    <meta property="og:locale" content="tr_TR">
    <meta name="csrf-token" content="{{ csrf_token() }}" <link rel="canonical" href="https://takip.marka.legal/">

    <title>@yield('header.title', env('APP_NAME').' - '.env('APP_TITLE'))</title>
    <link rel="stylesheet" href="{{ asset('css') }}/style.min.css">
    <link rel="shortcut icon" href="images/favicon.png" />
    <style>
        @media (max-width: 991px) {
            #language-form{
                width:100%;
            }
            #language-select{
                background-color:#00d663!important;
                border-radius:50px!important;
                color:#000000!important;
            }
        }
    </style>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">
    <div id="mobile-menu-overlay"></div>
    <nav class="navbar navbar-expand-lg fixed-top bgcolor">
        <div class="container">
            <a href="/" class="brand-logo" title="Anasayfa">
                <img src="{{ asset('assets/dashboard') }}/img/takip-marka-legal-white-logo.png" alt="logo"
                    width="200" height="85">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
                aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0,0,256,256">
                    <g fill-opacity="0" fill="#000000" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,256v-256h256v256z" id="bgRectangle"></path></g><g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M0,7.5v5h50v-5zM0,22.5v5h50v-5zM0,37.5v5h50v-5z"></path></g></g>
                    </svg></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav ml-auto align-items-center">
                    <li class="nav-item active">
                        <a class="nav-link" href="#home" title="Anasayfa">{{ __('theme/landing.home') }}<span
                                class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#marka-takip-hizmeti"
                            title="Anasayfa">{{ __('theme/landing.info') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact-us" title="İletişim">{{ __('theme/landing.contact') }}</a>
                    </li>
                    @if (!Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register', ['locale' => app()->getLocale()]) }}"
                                title="Kayıt Ol">{{ __('theme/landing.register') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-success"
                                href="{{ route('login', ['locale' => app()->getLocale()]) }}"
                                title="Giriş Yap">{{ __('theme/landing.login') }}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                title="Çıkış Yap">{{ __('theme/landing.logout') }}</a>
                        </li>
                    @endif
                    <form id="language-form" method="GET">
                        <select id="language-select" class="nav-item" onchange="changeLanguage()">
                            @foreach(config('app.languages') as $locale => $label)
                                <option value="{{ $locale }}" {{ App::getLocale() === $locale ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <div class="page-body-wrapper">
        @yield('content')
    </div>
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row p-4">
                    <div class="col-md-6 col-sm-4">
                        <address>
                            <p>{{ __('theme/landing.address') }}: İstiklal Cd. No:189,K:2 D:3, Beyoğlu,<br> 34433,
                                İstanbul / Türkiye</p>
                            <p class="mb-4"></p>
                            <div style="">
                                <a href="https://wa.me/905071996494?text=Merhaba" target="_blank">
                                    <img src="{{ asset('images') }}/whatsapp-logo.svg" width="40" height="40" alt="whatsapp"
                                        title="whatsapp numara" class="footer-contact-methods">
                                </a>
                                <a href="mailto:info@marka.legal" title="E-posta" class="footer-link">
                                    <img src="{{ asset('images') }}/mail-logo.svg" width="40" height="40" alt="email"
                                        title="E-posta" class="footer-contact-methods">
                                </a>
                            </div>
                        </address>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <p class="footer-title">{{ __('theme/footer.landing') }}</p>
                                <ul class="list-footer pl-0">
                                    <li><a href="#" class="footer-link"
                                            title="Anasayfa">{{ __('theme/landing.home') }}</a></li>
                                    <li><a href="https://marka.legal/" target="_blank" class="footer-link"
                                            title="marka.legal">{{ __('theme/landing.about') }}</a></li>
                                    <li><a href="#" class="footer-link"
                                            title="İletişim">{{ __('theme/landing.contact') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <p class="footer-title">{{ __('theme/landing.dashboard') }}</p>
                                <ul class="list-footer pl-0">
                                    @if (!Auth::check())
                                        <li><a href="{{ route('register', ['locale' => app()->getLocale()]) }}"
                                                class="footer-link"
                                                title="Kayıt Ol">{{ __('theme/landing.register') }}</a></li>
                                        <li><a href="{{ route('login', ['locale' => app()->getLocale()]) }}"
                                                class="footer-link"
                                                title="Giriş Yap">{{ __('theme/landing.login') }}</a></li>
                                    @else
                                        <li><a href="{{ route('logout', ['locale' => app()->getLocale()]) }}"
                                                class="footer-link"
                                                title="Çıkış Yap">{{ __('theme/landing.logout') }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('vendors') }}/base/vendor.bundle.base.js"></script>
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                var scroll = $(window).scrollTop();
                if ($(this).scrollTop() > 100) {
                    $(".brand-logo img").attr("src",
                        "{{ asset('assets/dashboard') }}/img/takip-marka-legal-blue-logo.png");
                    $(".brand-logo img").attr("width",
                        "180");
                    $(".brand-logo img").attr("height",
                        "66");
                } else {
                    //back to default
                    $(".brand-logo img").attr("src","{{ asset('assets/dashboard') }}/img/takip-marka-legal-white-logo.png");
                    $(".brand-logo img").attr("width","200");
                    $(".brand-logo img").attr("height",
                        "85");
                }
                if (scroll > 100) {
                    $(".mdi-menu").css("color", "black");
                    $(".bgcolor").css("background", "white");
                    $(".navbar-brand").css("color", "black");
                    $(".navbar-brand").css("font-weight", "100");
                    $(".bgcolor").css("box-shadow", "0 2px 4px 0 rgba(0,0,0,.2)");
                    $(".nav-link").css("color", "black");
                    $(".navbar").css("height", "12%");
                    $(".nav-link.active").css("background", "transparent");
                    $("#language-select").css("color", "black");
                }
                if (scroll < 100) {
                    $(".mdi-menu").css("color", "white");
                    $(".bgcolor").css("background", "transparent");
                    $(".bgcolor").css("box-shadow", "none");
                    $(".navbar-brand").css("background-image", "image1.pmg");
                    $(".nav-link").css("color", "white");
                    $(".navbar").css("transition", "0.5s all ease");
                    $(".navbar").css("height", "15%");
                    $(".nav-link.active").css("background", "rgba(0, 0, 0, 0.2)");
                    $("#language-select").css("color", "white");
                }
                if (jQuery(window).width() < 993) {
                    $(".nav-link").css("color", "black");

                }
            })
        })
        function changeLanguage() {
            var select = document.getElementById('language-select');
            var language = localStorage.setItem('language', select.value);
            var languageCode = select.options[select.selectedIndex].value;
            var baseUrl = "{{ URL::to('/') }}"; // Get the base URL
            var newUrl = baseUrl + '/' + languageCode;
            window.location.href = newUrl;
        }
    </script>
</body>

</html>
<style>
    #language-select {
        padding: 10px;
        font-size: 16px;
        border-bottom: 1px solid #ccc;
        border-top: transparent;
        border-right: transparent;
        border-left: transparent;
        color: white;
        background-color: transparent;
    }

    /* Styling the options */
    #language-select option {
        text-align: center;
        padding: 8px;
        font-size: 14px;
        color: #333;
        background-color: #fff;
    }

    /* Styling the selected option */
    #language-select option:checked {
        background-color: #007bff;
        color: #fff;
    }
</style>

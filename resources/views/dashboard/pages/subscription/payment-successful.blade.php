<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Marka Takip Sistemi - Marka.Legal</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Google fonts - Popppins for copy-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Prism Syntax Highlighting-->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/prismjs/plugins/toolbar/prism-toolbar.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/prismjs/themes/prism-okaidia.css">
    <!-- The Main Theme stylesheet (Contains also Bootstrap CSS)-->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/style.default.4faf0c98.css" id="theme-stylesheet">
    <!-- VanillaJs Datepicker CSS-->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/vanillajs-datepicker/css/datepicker-bs4.min.css">
    <!-- No UI Slider-->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/nouislider/nouislider.css">
    <link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
    @yield('css')
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/style.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('assets/dashboard') }}/img/favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/rr-1.3.1/sc-2.0.7/sp-2.1.0/sl-1.5.0/datatables.min.css"/>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/rr-1.3.1/sc-2.0.7/sp-2.1.0/sl-1.5.0/datatables.min.js"></script>
    <script>$.fn.poshytip={defaults:null}</script>
</head>
</html>
<body>
<div class="center">
    <svg fill="#16a34a" height="120px" width="120px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-256 -256 1024.00 1024.00" xml:space="preserve" stroke="#16a34a"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M256,0C114.837,0,0,114.843,0,256s114.837,256,256,256s256-114.843,256-256S397.163,0,256,0z M376.239,227.501 L257.348,346.391c-13.043,13.043-34.174,13.044-47.218,0l-68.804-68.804c-13.044-13.038-13.044-34.179,0-47.218 c13.044-13.044,34.174-13.044,47.218,0l45.195,45.19l95.282-95.278c13.044-13.044,34.174-13.044,47.218,0 C389.283,193.321,389.283,214.462,376.239,227.501z"></path> </g> </g> </g></svg>{{--    <div class="bg-white p-6  md:mx-auto">--}}
    <h3 style="margin-bottom: 20px">Ödeme başarılı</h3>
    <span style="color: #898a8e;

    ">İşlem referans numarası: #{{$reference}}</span><br><br>
    <div style="border-bottom: 2px dashed #c9cbd1; width: 80%;margin-left: auto;margin-right: auto">
    </div>
    <br><br>
    <div style="color: #6d6f76">
        <p>Kullanıcı adı: {{$user_name}}</p>
        <p>Yeni plan adı: {{$plan_name}}</p>
        <p>Abonelik bitiş tarihi: {{$subscription_ends_on}}</p>
        <p>Ödenen miktar: {{$amount}} ₺</p>
    </div>
</div>
</body>
<style>
    .center {
        width: 100%;
        text-align: center;
        position: absolute;
        top: 25%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>

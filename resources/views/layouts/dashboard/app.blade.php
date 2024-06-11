<!DOCTYPE html>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.min.js" integrity="sha512-frFP3ZxLshB4CErXkPVEXnd5ingvYYtYhE5qllGdZmcOlRKNEPbufyupfdSTNmoF5ICaQNO6SenXzOZvoGkiIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.2/jquery.twbsPagination.js" integrity="sha512-uzuo1GprrBscZGr+iQSv8+YQQsKY+rSHJju0FruVsGHV2CZNZPymW/4RkxoHxAxw3Lo5UQaxDMF8zINUfAsGeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/rr-1.3.1/sc-2.0.7/sp-2.1.0/sl-1.5.0/datatables.min.js"></script>
    <script>$.fn.poshytip={defaults:null}</script>
</head>

<body>
    <!-- navbar-->
    @include('dashboard.components.navbar')
    <div class="d-flex align-items-stretch">
        @include('dashboard.components.sidebar')
        <div class="page-holder bg-gray-100">
            <div class="container-fluid px-lg-4 px-xl-5">
                <!-- Page Header-->
                <div class="page-header">
                    <h1 class="page-heading">@yield('page-header')</h1>
                </div>
                @yield('content')
            </div>

            @include('dashboard.components.footer')
        </div>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>
    <!-- JavaScript files-->
    <script src="{{ asset('assets/dashboard') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Data Tables-->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
    <!-- Init Charts on Homepage-->
    <!-- Choices.js-->
    <script src="{{ asset('assets/dashboard') }}/vendor/choices.js/public/assets/scripts/choices.min.js"></script>
    <!-- Forms init-->
    <script src="{{ asset('assets/dashboard') }}/js/forms-advanced.5797ee8f.js"></script>
    <script src="{{ asset('assets/dashboard') }}/vendor/chart.js/Chart.min.js"></script>
    <!-- Main Theme JS File-->
    <script src="{{ asset('assets/dashboard') }}/js/theme.413b8ff4.js"></script>
    <!-- Prism for syntax highlighting-->
    <script src="{{ asset('assets/dashboard') }}/vendor/prismjs/prism.js"></script>
    <script src="{{ asset('assets/dashboard') }}/vendor/prismjs/plugins/normalize-whitespace/prism-normalize-whitespace.min.js">
    </script>
    <script src="{{ asset('assets/dashboard') }}/vendor/prismjs/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/vendor/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
    <script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>
    {{-- jQuery Cdn  --}}
    @yield('js')
    <script type="text/javascript">
        // Optional
        Prism.plugins.NormalizeWhitespace.setDefaults({
            'remove-trailing': true,
            'remove-indent': true,
            'left-trim': true,
            'right-trim': true,
        });
    </script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    @stack('scripts')
</body>

</html>

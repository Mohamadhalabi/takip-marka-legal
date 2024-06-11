
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') - Marka Takip Sistemi</title>
    <meta name="description" content="@yield('description')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
    <!-- Google fonts - Popppins for copy-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Prism Syntax Highlighting-->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/prismjs/plugins/toolbar/prism-toolbar.css">
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/vendor/prismjs/themes/prism-okaidia.css">
    <!-- The Main Theme stylesheet (Contains also Bootstrap CSS)-->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/style.default.4faf0c98.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('assets/dashboard') }}/css/custom.0a822280.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('assets/dashboard') }}/img/favicon.png">
  </head>
  <body>
    @yield('content')
    <!-- JavaScript files-->
    <script src="{{ asset('assets/dashboard') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <!-- Main Theme JS File-->
    <script src="{{ asset('assets/dashboard') }}/js/theme.413b8ff4.js"></script>
    <!-- Prism for syntax highlighting-->
    <script src="{{ asset('assets/dashboard') }}/vendor/prismjs/prism.js"></script>
    <script src="{{ asset('assets/dashboard') }}/vendor/prismjs/plugins/normalize-whitespace/prism-normalize-whitespace.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/vendor/prismjs/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="{{ asset('assets/dashboard') }}/vendor/prismjs/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
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
  </body>
</html>

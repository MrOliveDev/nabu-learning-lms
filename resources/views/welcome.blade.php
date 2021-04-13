<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>LMS</title>

    <meta name="description" content="Dashmix - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Dashmix - Bootstrap 4 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="Dashmix">
    <meta property="og:description" content="Dashmix - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="assets/js/plugins/highlightjs/styles/atom-one-light.css">
    <link rel="stylesheet" href="assets/js/plugins/magnific-popup/magnific-popup.css">

    <!-- Fonts and Dashmix framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/xwork.min.css"> -->
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/xmodern.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/app.css') }}">
    <!-- END Stylesheets -->
</head>

<body>
    <div id="page-container" class="sidebar-dark enable-page-overlay side-scroll page-header-fixed page-header-dark page-header-glass main-content-boxed side-trans-enabled sidebar-o-xs sidebar-o">

        @include('sidebar')
        @include('header')
        <main class="main-container">

        @yield('con')

        </main>
    </div>
    <script src="{{asset('assets/js/dashmix.core.min.js')}}"></script>

    <script src="{{asset('assets/js/dashmix.app.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script>
        jQuery(function() {
            Dashmix.helpers(['highlightjs', 'magnific-popup']);
        });

        $(document).ready(function(){
            $("#page-header").removeClass("page-header-trigger");
            $("#page-container").removeClass("page-header-trigger");
        })

        $("#sidebar").hover(
            function(){$("#page-header, #page-container").addClass("page-header-trigger");},
            function(){$("#page-header, #page-container").removeClass("page-header-trigger");}
        )
    </script>
<script>
            var btns =
                $("#sidebar .nav-main .nav-main-link");

            for (var i = 0; i < btns.length; i++) {
                btns[i].addEventListener("click",
                                      function () {
                    var current = document
                        .getElementsByClassName("active");

                    current[0].className = current[0]
                        .className.replace(" active", "");

                    this.className += " active";
                });
            }
</script>


    <script src="{{asset('assets/js/plugins/highlightjs/highlight.pack.min.js')}}"></script>

    <script src="{{asset('assets/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>


</body>

</html>

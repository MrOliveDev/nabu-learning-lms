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

    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <script src="{{asset('assets/js/dashmix.core.min.js')}}"></script>

    <script src="{{asset('assets/js/dashmix.app.min.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
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
    <script src="{{asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script>
        jQuery(function() {
            Dashmix.helpers(['highlightjs', 'magnific-popup']);
        });

        $(document).ready(function() {
            $("#page-header").removeClass("page-header-trigger");
            $("#page-container").removeClass("page-header-trigger");
        })

        $("#sidebar").hover(
            function() {
                $("#page-header, #page-container").addClass("page-header-trigger");
                $("#RightPanel").css({
                    "width": $("#content").width() - $("#LeftPanel").width() - $("#div_vertical").width() + "px"
                    // "width": $("#RightPanel").width() - 150 + "px"
                });
                console.log($("#content").width() + ":" + ($("#RightPanel").width() + $("#LeftPanel").width()));
            },
            function() {
                $("#page-header, #page-container").removeClass("page-header-trigger");
                if ($('#content').width()>($('#RightPanel').width()+$('#LeftPanel').width())) {
                    $("#RightPanel").css({
                        "width": $("#content").width() - $("#LeftPanel").width() - $("#div_vertical").width() + "px"
                    });
                }
                console.log($("#content").width() + ":" + ($("#RightPanel").width() + $("#LeftPanel").width()));

            }
        )
        $(document).ready(function() {
            window.onresize = resize;
            resize();
        });

        function resize() {
            var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));
            var divHight = 20 + $("#div_left").height(); //20=body padding:10px
            $("#content").css({
                "min-height": h - divHight + "px"
            });
            $("#div_vertical").css({
                "height": h - divHight + "px"
            });
            $("#LeftPanel").css({
                "height": h - divHight + "px"
            });
            $("#RightPanel").css({
                "height": h - divHight + "px",
                "width": $("#content").width() - $("#LeftPanel").width() - $("#div_vertical").width() + "px"
            });
        }

        jQuery.resizable = function(resizerID, vOrH) {
            console.log("sjdflsjlf");
            jQuery('#' + resizerID).bind("mousedown", function(e) {
                var start = e.pageY;
                if (vOrH == 'v') start = e.pageX;
                jQuery('body').bind("mouseup", function() {
                    jQuery('body').unbind("mousemove");
                    jQuery('body').unbind("mouseup");

                });
                jQuery('body').bind("mousemove", function(e) {
                    var end = e.pageY;
                    if (vOrH == 'v') end = e.pageX;
                    if (vOrH == 'h') {
                        jQuery('#' + resizerID).prev().height(jQuery('#' + resizerID).prev().height() + (end - start));
                        jQuery('#' + resizerID).next().height(jQuery('#' + resizerID).next().height() - (end - start));
                    } else {
                        jQuery('#' + resizerID).prev().width(jQuery('#' + resizerID).prev().width() + (end - start));
                        jQuery('#' + resizerID).next().width(jQuery('#' + resizerID).next().width() - (end - start));
                    }
                    start = end;
                });
            });
        }

        jQuery.resizable('div_vertical', "v");
        jQuery.resizable('div_right', "h");
        jQuery.resizable('div_left', "h");
    </script>


    <script src="{{asset('assets/js/plugins/highlightjs/highlight.pack.min.js')}}"></script>

    <script src="{{asset('assets/js/popper.min.js')}}"></script>



</body>

</html>

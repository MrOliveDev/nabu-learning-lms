<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>LMS</title>

    <meta name="description"
        content="Dashmix - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Dashmix - Bootstrap 4 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="Dashmix">
    <meta property="og:description"
        content="Dashmix - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets/media/favicons/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/media/favicons/favicon-192x192.png') }}">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('assets/media/favicons/apple-touch-icon-180x180.png') }}">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/highlightjs/styles/atom-one-light.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/jQuery-Plugin-For-Creating-Loading-Overlay-with-CSS3-Animations-waitMe/waitMe.min.css') }}">

    <!-- Fonts and Dashmix framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/xmodern.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">

    @yield('css_after')

    <script src="{{ asset('assets/js/dashmix.core.min.js') }}"></script>

    <script src="{{ asset('assets/js/dashmix.app.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/baseURL.js') }}"></script>

    @yield('js_before')
    <!-- Scripts -->

    <!-- END Stylesheets -->
</head>

<body @if (session('pageBackground') != null && session('pageBackground') != '') style="background:{{ session('pageBackground') }}" @endif>
    <div id="page-container"
        class="sidebar-dark enable-page-overlay side-scroll page-header-fixed page-header-dark page-header-glass main-content-boxed side-trans-enabled sidebar-o-xs sidebar-o">
        @include('sidebar')
        @include('header')
        <main class="main-container">

            @yield('con')

        </main>
    </div>
    <script src="{{ asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <script>
        $(document)
            .ajaxStart(function() {
                $('body').waitMe({
                    effect: 'bounce',
                    text: 'Loading...',
                    bg: 'rgba(255, 255, 255, 0.7)',
                    color: '#000'
                });
            })
            .ajaxStop(function() {
                $('body').waitMe("hide");
            });
        // $(document).load(function() {
        //     $('body').waitMe({
        //         effect: 'bounce',
        //         text: 'Lodading...',
        //         bg: 'rgba(255, 255, 255, 0.7)',
        //         color: '#000'
        //     });
        // }).ready(function() {
        //     $('body').waitMe("hide");
        // });
        jQuery(function() {
            Dashmix.helpers(['highlightjs', 'magnific-popup', 'rangeslider']);
        });

        $(document).ready(function() {
            $("#page-header ").removeClass("page-header-trigger ");
            $("#page-container").removeClass("page-header-trigger");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })

        // $(".content-side.content-side-full").hover(
        //     function() {
        //         if ($(".simplebar-content").css('width') == '150px') {

        //             $("#page-header, #page-container").addClass("page-header-trigger");
        //             $("#RightPanel").css({
        //                 "width": $("#content").width() - $("#LeftPanel").width() - $(
        //                         "#div_vertical")
        //                     .width() - 10 + "px"
        //                 // "width": $("#RightPanel").width() - 150 + "px"
        //             });
        //         }
        //     },
        //     function() {
        //         if ($(".simplebar-content").css('width') == '150px') {

        //             $("#page-header, #page-container").removeClass("page-header-trigger");
        //             if ($('#content').width() > ($('#RightPanel').width() + $('#LeftPanel').width())) {
        //                 $("#RightPanel").css({
        //                     "width": $("#content").width() - $("#LeftPanel").width() - $(
        //                             "#div_vertical")
        //                         .width() - 10 + "px"
        //                 });
        //             }
        //         }
        //     }
        // )
        $(document).ready(function() {
            window.onresize = resize;
            resize();
        });

        function resize() {
            var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document
                .body
                .clientHeight));
            var divHight = 20 + parseInt($("#div_left").height()) + parseInt($('.content-header')
                .height()); //20=body padding:10px
            $("#content").css({
                "min-height": h - divHight + "px"
            });
            $("#div_vertical").css({
                "height": h - divHight + "px"
            });
            // $("#LeftPanel").css({
            //     "height": h - divHight + "px"
            // });
            $("#RightPanel").css({
                // "height": h - divHight + "px",
                "width": $("#content").width() - $("#LeftPanel").width() - $("#div_vertical")
                    .width() - 10 +
                    "px"
            });
            $("#RightPanel1").css({
                // "height": h - divHight + "px",
                "width": $("#content1").width() - $("#LeftPanel1").width() - $("#div_vertical1")
                    .width() - 10 +
                    "px"
            });
            $("#content1").css({
                "min-height": h - divHight + "px"
            });
            // $("#LeftPanel1").css({
            //     "height": h - divHight + "px"
            // });
        }

        jQuery.resizable = function(resizerID, vOrH) {
            jQuery('#' + resizerID).bind("mousedown", function(e) {
                var start = e.pageY;
                if (vOrH == 'v') start = e.pageX;
                jQuery('body').bind("mouseup", function() {
                    jQuery('body').unbind("mousemove");
                    jQuery('body').unbind("mouseup");
                    if ($(".js-rangeslider").length) {
                        $(".js-rangeslider").data("ionRangeSlider").update({
                            from: $(this).data(
                                "ionRangeSlider"
                            )
                        });
                    }
                    if ($("#attempts").length) {
                        $("#attempts").data("ionRangeSlider").update({
                            from: $(this).data(
                                "ionRangeSlider"
                            )
                        });
                    }
                });
                jQuery('body').bind("mousemove", function(e) {
                    var end = e.pageY;
                    if (vOrH == 'v') end = e.pageX;
                    if (vOrH == 'h') {
                        jQuery('#' + resizerID).prev().height(jQuery('#' + resizerID)
                            .prev()
                            .height() + (end - start));
                        // jQuery('#' + resizerID).next().height(jQuery('#' + resizerID).next().height() - (end - start));
                    } else {
                        jQuery('#' + resizerID).prev().width(jQuery('#' + resizerID)
                            .prev()
                            .width() + (end - start));
                        jQuery('#' + resizerID).next().width(jQuery('#' + resizerID)
                            .parent()
                            .width() - jQuery('#' + resizerID).prev().width() -
                            jQuery('#' +
                                resizerID).width() - 10);
                    }
                    start = end;
                    console.log($("#content").width() + "  " + $("#LeftPanel").width() +
                        "  " + $(
                            "#RightPanel").width());
                });
            });
        }

        jQuery.resizable('div_vertical', "v");
        jQuery.resizable('div_vertical1', "v");
        jQuery.resizable('div_vertical2', "v");
        jQuery.resizable('div_right', "h");
        jQuery.resizable('div_right1', "h");
        jQuery.resizable('div_right2', "h");
        jQuery.resizable('div_left', "h");
        jQuery.resizable('div_left1', "h");
        jQuery.resizable('div_left2', "h");
    </script>


    <script src="{{ asset('assets/js/plugins/highlightjs/highlight.pack.min.js') }}"></script>
    <script
        src="{{ asset('assets/js/plugins/jQuery-Plugin-For-Creating-Loading-Overlay-with-CSS3-Animations-waitMe/waitMe.min.js') }}">
    </script>

    <script src="{{ asset('assets/js/popper.min.js') }}"></script>

    @yield('js_after')


</body>

</html>

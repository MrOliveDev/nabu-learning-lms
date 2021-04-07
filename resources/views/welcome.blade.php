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
    <link rel="stylesheet" href="assets/js/plugins/highlightjs/styles/atom-one-light.css">
    <link rel="stylesheet" href="assets/js/plugins/magnific-popup/magnific-popup.css">

    <!-- Fonts and Dashmix framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/dashmix.min.css') }}">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/xwork.min.css"> -->
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/xmodern.min.css') }}">
    <!-- END Stylesheets -->
</head>

<body>
    <div id="page-container" class="sidebar-dark enable-page-overlay side-scroll page-header-fixed page-header-dark page-header-glass main-content-boxed side-trans-enabled sidebar-o-xs sidebar-o">

        @include('sidebar')
        @include('header')
        <main class="main-container">
            <div class="tab-row">
                <div class="tab-item">
                    <div class="tab-content">
                        <div class="tab-avatar">
                            <i class="fa fa-users"></i>
                        </div>
                        <span class="tab-item-value">16.023</span>
                        <span class="tab-description">Utilisateurs <br>enregistrés</span>
                        <div class="tab-link">Consulter <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </div>

                <div class="tab-item">
                    <div class="tab-content">
                        <div class="tab-avatar">
                            <i class="fa fa-users"></i>
                        </div>
                        <span class="tab-item-value">16.023</span>
                        <span class="tab-description">Utilisateurs <br>enregistrés</span>
                        <div class="tab-link">Consulter <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </div>
                <div class="tab-item">
                    <div class="tab-content">
                        <div class="tab-avatar">
                            <i class="fa fa-users"></i>
                        </div>
                        <span class="tab-item-value">16.023</span>
                        <span class="tab-description">Utilisateurs <br>enregistrés</span>
                        <div class="tab-link">Consulter <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </div>
                <div class="tab-item">
                    <div class="tab-content">
                        <div class="tab-avatar">
                            <i class="fa fa-users"></i>
                        </div>
                        <span class="tab-item-value">16.023</span>
                        <span class="tab-description">Utilisateurs <br>enregistrés</span>
                        <div class="tab-link">Consulter <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </div>
                <div class="tab-item">
                    <div class="tab-content">
                        <div class="tab-avatar">
                            <i class="fa fa-users"></i>
                        </div>
                        <span class="tab-item-value">16.023</span>
                        <span class="tab-description">Utilisateurs <br>enregistrés</span>
                        <div class="tab-link">Consulter <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </div>
                <div class="tab-item">
                    <div class="tab-content">
                        <div class="tab-avatar">
                            <i class="fa fa-users"></i>
                        </div>
                        <span class="tab-item-value">16.023</span>
                        <span class="tab-description">Utilisateurs <br>enregistrés</span>
                        <div class="tab-link">Consulter <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </div>
            </div>
            <table class="session-table">
                <tr>
                    <th>
                        <div>
                            Mes dernières SESSIONS
                            <i class="fa fal fa-sliders-h"></i>
                        </div>
                    </th>
                    <th>
                        <div>
                            Language
                        </div>
                    </th>
                    <th>
                        <div>
                            Status
                        </div>
                    </th>
                    <th>
                        <div>
                            Date de debut
                        </div>
                    </th>
                    <th>
                        <div>
                            Date de fin
                        </div>
                    </th>
                </tr>
                <tr>
                    <td>
                        <div>
                            Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique
                        </div>
                    </td>
                    <td>
                        <div>
                            Français - FR
                        </div>
                    </td>
                    <td>
                        <div>
                            En cours
                        </div>
                    </td>
                    <td>
                        <div>
                            23/04/2021
                        </div>
                    </td>
                    <td>
                        <div>
                            23/04/2021
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div>
                            Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique
                        </div>
                    </td>
                    <td>
                        <div>
                            Français - FR
                        </div>
                    </td>
                    <td>
                        <div>
                            En cours
                        </div>
                    </td>
                    <td>
                        <div>
                            23/04/2021
                        </div>
                    </td>
                    <td>
                        <div>
                            23/04/2021
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div>
                            Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique
                        </div>
                    </td>
                    <td>
                        <div>
                            Français - FR
                        </div>
                    </td>
                    <td>
                        <div>
                            En cours
                        </div>
                    </td>
                    <td>
                        <div>
                            23/04/2021
                        </div>
                    </td>
                    <td>
                        <div>
                            23/04/2021
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div>
                            Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique
                        </div>
                    </td>
                    <td>
                        <div>
                            Français - FR
                        </div>
                    </td>
                    <td>
                        <div>
                            En cours
                        </div>
                    </td>
                    <td>
                        <div>
                            23/04/2021
                        </div>
                    </td>
                    <td>
                        <div>
                            23/04/2021
                        </div>
                    </td>
                </tr>

            </table>


            <div class="dashbord">
                <div class="flesible-colum">
                    <div class="collespe-card">
                        <div class="collespe-header">
                            <div>
                                <i class="fa fa-bars">

                                </i>
                                Les Bonnes Pratiques de Fabrication
                                Dans l’Industrie Pharmaceutique
                            </div>

                        </div>
                        <img src="{{ asset('assets/media/17.jpg') }}" alt="" class="collespe-body">
                        <div class="collespe-bottom">
                            <div class="collespe-bottom-right">
                                <i class="fa fa-chart-line">

                                </i>
                                <span class="text-mute">
                                    75%
                                </span>
                            </div>
                            <div class="collespe-bottom-left">
                                <i class="fa fa-check-circle text-success">

                                </i>
                                <span>
                                    85%
                                </span>
                            </div>
                            <div class="collespe-description">
                                Ouvert jusqu’au 26 mars 2021
                            </div>
                        </div>
                    </div>
                    <div class="collespe-card">
                        <div class="collespe-header">
                            <div>
                                <i class="fa fa-bars">

                                </i>
                                Les Bonnes Pratiques de Fabrication
                                Dans l’Industrie Pharmaceutique
                            </div>

                        </div>
                        <img src="{{ asset('assets/media/18.jpg') }}" alt="" class="collespe-body">
                        <div class="collespe-bottom">
                            <div class="collespe-bottom-right">
                                <i class="fa fa-chart-line">

                                </i>
                                <span class="text-mute">
                                    75%
                                </span>
                            </div>
                            <div class="collespe-bottom-left">
                                <i class="fa fa-check-circle text-success">

                                </i>
                                <span>
                                    85%
                                </span>
                            </div>
                            <div class="collespe-description">
                                Ouvert jusqu’au 26 mars 2021
                            </div>
                        </div>
                    </div>
                    <div class="collespe-card">
                        <div class="collespe-header">
                            <div>
                                <i class="fa fa-bars">

                                </i>
                                Les Bonnes Pratiques de Fabrication
                                Dans l’Industrie Pharmaceutique
                            </div>

                        </div>
                        <img src="{{ asset('assets/media/19.jpg') }}" alt="" class="collespe-body">
                        <div class="collespe-bottom">
                            <div class="collespe-bottom-right">
                                <i class="fa fa-chart-line">

                                </i>
                                <span class="text-mute">
                                    75%
                                </span>
                            </div>
                            <div class="collespe-bottom-left">
                                <i class="fa fa-check-circle text-success">

                                </i>
                                <span>
                                    85%
                                </span>
                            </div>
                            <div class="collespe-description">
                                Ouvert jusqu’au 26 mars 2021
                            </div>
                        </div>
                    </div>
                </div>
                <div class="width-controller">
                    <i class="fas fa-grip-lines-vertical">

                    </i>
                </div>
                <div class="dash-colum">
                    <table class="dash-table">
                        <tr>
                            <td>
                                <div class="round-corner-10">
                                    <div>
                                        <i class="fa fa-chart-line">

                                        </i>
                                        <span>
                                            75%
                                        </span>
                                    </div>
                                    <div>
                                        <i class="fa fa-check-circle">

                                        </i>
                                        <span>
                                            75%
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="round-corner-10">
                                    <span>
                                        Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique
                                    </span>
                                    <i class="fas fa-exclamation-circle text-light">

                                    </i>
                                    <i class="fa fa-play text-light">

                                    </i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="round-corner-10">
                                    <div>
                                        <i class="fa fa-chart-line">

                                        </i>
                                        <span>
                                            75%
                                        </span>
                                    </div>
                                    <div>
                                        <i class="fa fa-check-circle">

                                        </i>
                                        <span>
                                            75%
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="round-corner-10">
                                    <span>
                                        Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique
                                    </span>
                                    <i class="fas fa-exclamation-circle text-light">

                                    </i>
                                    <i class="fa fa-play text-light">

                                    </i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p>lajsdfjalsjdflajsddddddddddddddddddddddddddddddddddddddddddddddddddddddddflllllfdgdsfgsdf
                                    gsdfgsddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="round-corner-10">
                                    <div>
                                        <i class="fa fa-chart-line">

                                        </i>
                                        <span>
                                            75%
                                        </span>
                                    </div>
                                    <div>
                                        <i class="fa fa-check-circle">

                                        </i>
                                        <span>
                                            75%
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="round-corner-10">
                                    <span>
                                        Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique
                                    </span>
                                    <i class="fas fa-exclamation-circle text-light">

                                    </i>
                                    <i class="fa fa-play text-light">

                                    </i>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="round-corner-10">
                                    <div>
                                        <i class="fa fa-chart-line">

                                        </i>
                                        <span>
                                            75%
                                        </span>
                                    </div>
                                    <div>
                                        <i class="fa fa-check-circle">

                                        </i>
                                        <span>
                                            75%
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="round-corner-10">
                                    <span>
                                        Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique
                                    </span>
                                    <i class="fas fa-exclamation-circle text-light">

                                    </i>
                                    <i class="fa fa-play text-light">

                                    </i>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div class="height-controller"><i class="fas fa-grip-lines"></i></div>

                <div class="dash-description">
                    <div class="dash-panel">
                        <span class="dash-panel-title">Objectifs :</span>
                        <div class="dash-panel-content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eleifend
                            magna dignissim nunc maximus maximus. Nunc eget laoreet purus. Proin
                            interdum, felis non malesuada vehicula, est ante ornare tortor, blandit
                            sodales enim diam eu leo. Nam malesuada in tortor quis pharetra. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia
                            curae; Curabitur ultricies odio velit, vitae rutrum ipsum viverra in. Suspendisse mollis et dolor gravida ultrices. Aenean iaculis, orci ultrices posuere
                            sagittis, nisi felis fermentum quam, viverra euismod eros velit non ligula.
                            Etiam sit amet tempor massa.
                        </div>
                        <div class="dash-panel-footer"><span class="dash-panel-bottom-title">Durée :</span>25 minutes</div>
                    </div>
                    <div class="dash-item-list">
                        <div class="dash-item">
                            <div><img src="{{ asset('assets/media/13.jpg') }}" alt="" class="dash-avatar"></div>
                            <div class="dash-avatar-title text-mute">
                                Télécharger mon
                                attestation de
                                formation
                            </div>
                        </div>
                        <div class="dash-item">
                            <img src="{{ asset('assets/media/14.jpg') }}" alt="" class="dash-avatar">
                            <div class="dash-avatar-title text-mute">
                                Télécharger mon
                                attestation de
                                formation
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

    </div>
    <script src="{{asset('assets/js/dashmix.core.min.js')}}"></script>

    <script src="{{asset('assets/js/dashmix.app.min.js')}}"></script>

    <script src="{{asset('assets/js/plugins/highlightjs/highlight.pack.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js')}}"></script>

    <script>
        jQuery(function() {
            Dashmix.helpers(['highlightjs', 'magnific-popup']);
        });

        show_sidebar = function() {
            var element = document.getElementById("page-header");
            var pageContainer = document.getElementById('page-container');
            element.classList.toggle("page-header-trigger");
            pageContainer.classList.toggle("page-header-trigger");
        }
    </script>


</body>

</html>

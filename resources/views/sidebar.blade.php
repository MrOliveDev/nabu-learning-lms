<div id="page-overlay"></div>
<div id="page-overlay"></div>
<div id="page-overlay"></div>
<!-- Side Overlay-->
<aside id="side-overlay" data-simplebar="init">
    <div class="simplebar-wrapper" style="margin: 0px;">
        <div class="simplebar-height-auto-observer-wrapper">
            <div class="simplebar-height-auto-observer"></div>
        </div>
        <div class="simplebar-mask">
            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;">
                    <div class="simplebar-content" style="padding: 0px;">
                        <!-- Side Header -->
                        <div class="bg-primary">
                            <div class="content-header">
                                <div class="font-size-lg font-w300 text-white">
                                    <i class="fa fa-users mr-1"></i> People
                                </div>

                                <!-- Close Side Overlay -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <a class="ml-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
                                    <i class="fa fa-times-circle"></i>
                                </a>
                                <!-- END Close Side Overlay -->
                            </div>
                        </div>
                        <!-- END Side Header -->

                        <!-- Side Content -->
                        <div class="content-side">
                            <form class="push" action="http://localhost:8000/db_social.html" method="POST" onsubmit="return false;">
                                <div class="input-group">
                                    <input class="form-control form-control-alt" placeholder="Search People..">
                                    <div class="input-group-append">
                                        <span class="input-group-text input-group-text-alt">
                                            <i class="fa fa-fw fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- END Side Content -->
                    </div>
                </div>
            </div>
        </div>
        <div class="simplebar-placeholder" style="width: auto; height: 227px;"></div>
    </div>
    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
    </div>
    <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
        <div class="simplebar-scrollbar" style="height: 0px; display: none; transform: translate3d(0px, 0px, 0px);">
        </div>
    </div>
</aside>

<nav id="sidebar" aria-label="Main Navigation" data-simplebar="init" onmouseover="show_sidebar()" onmouseout="show_sidebar()">
    <div class="simplebar-wrapper" style="margin: 0px;">
        <div class="simplebar-height-auto-observer-wrapper">
            <div class="simplebar-height-auto-observer"></div>
        </div>
        <div class="simplebar-mask">
            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden;">
                    <div class="simplebar-content" style="padding: 0px;">
                        <!-- Side Header -->
                        <div class="content-header">
                            <a class="img-link d-inline-block" href="javascript:void(0)">
                                <img class="img-avatar img-avatar96" src="http://localhost:8000/assets/media/light.png" alt="">
                            </a>
                            <div class="sidetitle">
                                <img class="" src="http://localhost:8000/assets/media/letter.png">
                            </div>
                        </div>
                        <!-- END Side Header -->

                        <!-- User Info -->
                        <div class="smini-hidden">

                        </div>
                        <!-- END User Info -->

                        <!-- Side Navigation -->
                        <div class="content-side content-side-full">
                            <ul class="nav-main">
                                <li class="nav-main-item">
                                    <a class="nav-main-link active" href="http://localhost:8000/#">
                                        <!-- <div class="nav-cover"> -->
                                            <i class="nav-main-link-icon fas fa-tachometer-alt"></i>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">Tableau de bord</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="http://localhost:8000/#">
                                        <!-- <div class="nav-cover"> -->
                                            <i class="nav-main-link-icon fas fa-cogs"></i>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">Session</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="http://localhost:8000/#">
                                        <!-- <div class="nav-cover"> -->
                                            <i class="nav-main-link-icon fas fa-user"></i>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">Utilisateurs</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="http://localhost:8000/#">
                                        <!-- <div class="nav-cover"> -->
                                            <i class="nav-main-link-icon fas fa-users"></i>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">Groupes</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="http://localhost:8000/#">
                                        <!-- <div class="nav-cover"> -->
                                            <i class="nav-main-link-icon fas fa-th"></i>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">Sociétés</span>
                                    </a>
                                </li>

                                <hr>

                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="http://localhost:8000/#">
                                        <!-- <div class="nav-cover"> -->
                                            <i class="nav-main-link-icon fas fa-cubes"></i>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">Parcours de
                                            Formation</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="http://localhost:8000/#">
                                        <!-- <div class="nav-cover"> -->
                                            <i class="nav-main-link-icon fas fa-newspaper"></i>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">Templates</span>
                                    </a>
                                </li>

                                <hr>

                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="http://localhost:8000/#">
                                        <!-- <div class="nav-cover"> -->
                                            <i class="nav-main-link-icon far fa-envelope"></i>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">Outil mail</span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="http://localhost:8000/#">
                                        <!-- <div class="nav-cover"> -->
                                            <i class="nav-main-link-icon fas fa-chart-pie"></i>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">Rapports et
                                            Certificats</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- END Side Navigation -->
                    </div>
                </div>
            </div>
        </div>
        <div class="simplebar-placeholder" style="width: auto; height: 372px;"></div>
    </div>
    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
        <div class="simplebar-scrollbar" style="width: 0px; transform: translate3d(0px, 0px, 0px); display: none;">
        </div>
    </div>
    <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
        <div class="simplebar-scrollbar" style="height: 0px; transform: translate3d(0px, 0px, 0px); display: none;">
        </div>
    </div>
</nav>
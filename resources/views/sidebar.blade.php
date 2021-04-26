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
                                    <i class="fa fa-users mr-1"></i>
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
                            <form class="push" action="db_social.html" method="POST" onsubmit="return false;">
                                <div class="input-group">
                                    <select class="form-control" id="val-language" name="val-language">
                                        <option value="">{{$translation->l('Select your language')}}</option>
                                        @isset($language)
                                        @foreach($language as $languageItem)
                                        <option value="{{$languageItem->language_iso}}">{{$languageItem->language_name}}</option>
                                        @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <br>
                                <div class="input-group">
                                    <input class="form-control form-control-alt" placeholder="Search Dictionary..." id="search_word">
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

<nav id="sidebar" aria-label="Main Navigation" data-simplebar="init">
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
                                <img class="img-avatar img-avatar96" src="{{asset('assets/media/light.png')}}" alt="">
                            </a>
                            <div class="sidetitle">
                                <img class="" src="{{asset('assets/media/letter.png')}}">
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
                                    <a class="nav-main-link" href="{{route('admin.dash')}}" id="tableau">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item">
                                            <i class="nav-main-link-icon fas fa-tachometer-alt"></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{$translation->l('Dashboard')}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('session')}}" id="sessions">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item">
                                            <i class="nav-main-link-icon fas fa-cogs"></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{$translation->l('Sessions')}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('student')}}" id="utilisateurs">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item">
                                            <i class="nav-main-link-icon fas fa-user"></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{$translation->l('Users')}}
                                        </span>
                                    </a>
                                </li>
                                <!-- <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('dash')}}" id="groupes">
                                        <div class="nav-main-cover-item">
                                            <i class="nav-main-link-icon fas fa-users"></i>
                                            </div>
                                        <span class="nav-main-link-name">Groupes</span>
                                    </a>
                                </li> -->
                                <!--                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('lesson')}}" id="societes">
                                        <div class="nav-main-cover-item">
                                            <i class="nav-main-link-icon fas fa-th"></i>
                                            </div>
                                        <span class="nav-main-link-name">Companies</span>
                                    </a>
                                </li>
 -->
                                <hr>

                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('lesson')}}" id="parcours">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item">
                                            <i class="nav-main-link-icon fas fa-cubes"></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{$translation->l('Training Courses')}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('template')}}" id="templates">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item">
                                            <i class="nav-main-link-icon fas fa-newspaper"></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{$translation->l('Templates')}}
                                        </span>
                                    </a>
                                </li>

                                <hr>

                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{route('dash')}}" id="outil">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item">
                                            <i class="nav-main-link-icon far fa-envelope"></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{$translation->l('Mail')}}
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="#" id="rapports">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item">
                                            <i class="nav-main-link-icon fas fa-chart-pie"></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{$translation->l('Report and Certificates')}}
                                        </span>
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
<script>
    $(document).ready(
        function() {
            $('#val-language').change(function(evt) {
                $.get(
                    "{{route('changeLanguage')}}", {
                        language: evt.target.value
                    },
                    function(data, statues) {
                        //show alarm that language is changed
                        window.location.reload();
                    }
                )
            });
            $('#search_word').change(function(evt){
                $.post(
                    "{{route('searchfromdictionary')}}",
                    {
                        'keyword':evt.target.value
                    },
                    function(data, statues){

                    }
                )
            })
        }
    )
</script>

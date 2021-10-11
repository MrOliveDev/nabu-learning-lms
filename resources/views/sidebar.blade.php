<div id="page-overlay"></div>
<div id="page-overlay"></div>
<div id="page-overlay"></div>
<!-- Side Overlay-->

<!-- <link rel='stylesheet' href="{{ asset('assets/css/jquery-ui.css') }}"></link> -->
<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
@if(session("iconOverColor")!=null ||
session("menuBackground")!=null)
<style>
    .nav-main-dark .nav-main-link.active .nav-main-link-icon,
     .nav-main-dark .nav-main-link:hover,
     .page-header-dark #page-header .nav-main-link.active .nav-main-link-icon,
     .page-header-dark #page-header .nav-main-link:hover,
     .sidebar-dark #sidebar .nav-main-link.active .nav-main-link-icon, 
     .sidebar-dark #sidebar .nav-main-link.active .nav-main-link-name, 
     .sidebar-dark #sidebar .nav-main-link.active, 
    .sidebar-dark #sidebar .nav-main-link:hover {
        color: <?php echo session("iconOverColor") ?> !important;
        background-color:none;
    }
    .nav-main-link:hover {
        border: solid 1px transparent;
        border-radius: 5px;
        width: 253px;
        background-color:  <?php echo session("menuBackground") ?> !important;
    }
    .nav-main-item .nav-main-link:hover i.nav-main-link-icon, .nav-main-link:hover .nav-main-link-name {
        color: <?php echo session("iconOverColor") ?> !important;
    }

    #page-container.sidebar-dark #sidebar .simplebar-content {
        background-color: <?php echo session("menuBackground") ?> !important;
        /* background-color: #2e3092; */
    }
</style>
@endif
<aside id="side-overlay" data-simplebar="init">

    <div class="simplebar-wrapper" style="margin: 0px;">
        <div class="simplebar-height-auto-observer-wrapper">
            <div class="simplebar-height-auto-observer"></div>
        </div>
        <div class="simplebar-mask">
            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                <div class="simplebar-content-wrapper" style="height: 100%;">
                    <div class="simplebar-content p-0" style="background-color:{{session("menuBackground")}}">
                        <!-- Side Header -->
                        <div class="bg-primary">
                            <div class="content-header">
                                <div class="text-white font-size-lg font-w300">
                                    <i class="mr-1 fa fa-users"></i>
                                </div>

                                <!-- Close Side Overlay -->
                                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                                <a class="ml-auto text-white" href="javascript:void(0)" data-toggle="layout"
                                    data-action="side_overlay_close">
                                    <i class="fa fa-times-circle"></i>
                                </a>
                                <!-- END Close Side Overlay -->
                            </div>
                        </div>
                        <!-- END Side Header -->

                        <!-- Side Content -->
                        {{-- <div class="content-side">
                            <form class="push" action="db_social.html" method="POST" onsubmit="return false;">
                                <div class="input-group">
                                    <select class="form-control" id="val-language" name="val-language">
                                        <option value="">{{ $translation->l('Select your language') }}</option>
                                        @isset($language)
                                            @foreach ($language as $languageItem)
                                                <option value="{{ $languageItem->language_iso }}">
                                                    {{ $languageItem->language_name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                <br>
                                <div class="input-group ui-widget">
                                    <input class="form-control form-control-alt" placeholder="Search Dictionary..."
                                        id="search_word">
                                    <div class="input-group-append">
                                        <span class="input-group-text input-group-text-alt">
                                            <i class="fa fa-fw fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </form>

                        </div> --}}
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
                <div class="simplebar-content-wrapper" style="height: 100%;">
                    <div class="simplebar-content" style="padding: 0px;">
                        <!-- Side Header -->
                        <div class="mx-auto mt-3 content-header w-100" id="sidebar-content-header">
                            <div style="width: 100%;">
                                <a class="img-link d-inline-block" href="javascript:void(0)">
                                    <img class="" src="{{ session('logo') ? session('logo') : asset('assets/media/light.png') }}" alt="" style='{{ session('logo') ? "border-radius: 50%;" : ''; }}'>
                                </a>
                            </div>
                            <div class="pb-4 sidetitle">
                                <img class="" src="{{ asset('assets/media/letter.png') }}">
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
                                @if (isset(session('permission')->admindash))
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('admindash') }}" id="tableau">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item mr-2">
                                            <i class="nav-main-link-icon fas fa-tachometer-alt" @if(session("iconDefaultColor") != null && session("iconDefaultColor") != "") style="color:{{session("iconDefaultColor")}}" @endif></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{ $translation->l('Dashboard') }}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (isset(session('permission')->session))
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('session') }}" id="sessions">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item mr-2">
                                            <i class="nav-main-link-icon fas fa-cogs" @if(session("iconDefaultColor") != null && session("iconDefaultColor") != "") style="color:{{session("iconDefaultColor")}}" @endif></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{ $translation->l('Sessions') }}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (isset(session('permission')->student))
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('student') }}" id="utilisateurs" @if(session("iconDefaultColor") != null && session("iconDefaultColor") != "") style="color:{{session("iconDefaultColor")}}" @endif>
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item mr-2">
                                            <i class="nav-main-link-icon fas fa-user" @if(session("iconDefaultColor") != null && session("iconDefaultColor") != "") style="color:{{session("iconDefaultColor")}}" @endif></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{ $translation->l('Users') }}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(isset(session('permission')->training)||isset(session('permission')->template))
                                <hr>
                                @endif
                                @if (isset(session('permission')->training))
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('training') }}" id="parcours">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item mr-2">
                                            <i class="nav-main-link-icon fas fa-cubes" @if(session("iconDefaultColor") != null && session("iconDefaultColor") != "") style="color:{{session("iconDefaultColor")}}" @endif></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{ $translation->l('Trainings') }}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if (isset(session('permission')->template))
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('template') }}" id="templates">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item mr-2">
                                            <i class="nav-main-link-icon fas fa-newspaper" @if(session("iconDefaultColor") != null && session("iconDefaultColor") != "") style="color:{{session("iconDefaultColor")}}" @endif></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{ $translation->l('Templates') }}
                                        </span>
                                    </a>
                                </li>
                                @endif
                                @if(isset(session('permission')->report)||isset(session('permission')->report))
                                <hr>
                                @endif
                                @if (isset(session('permission')->report))
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('sendmail') }}" id="outil">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item mr-2">
                                            <i class="nav-main-link-icon far fa-envelope" @if(session("iconDefaultColor") != null && session("iconDefaultColor") != "") style="color:{{session("iconDefaultColor")}}" @endif></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{ $translation->l('Mail') }}
                                        </span>
                                    </a>
                                </li>
                                @endif

                                @if (isset(session('permission')->report))
                                <li class="nav-main-item">
                                    <a class="nav-main-link" href="{{ route('report') }}" id="rapports">
                                        <!-- <div class="nav-cover"> -->
                                        <div class="nav-main-cover-item mr-2">
                                            <i class="nav-main-link-icon fas fa-chart-pie" @if(session("iconDefaultColor") != null && session("iconDefaultColor") != "") style="color:{{session("iconDefaultColor")}}" @endif></i>
                                        </div>
                                        <!-- </div> -->
                                        <span class="nav-main-link-name">
                                            {{ $translation->l('Reports') }}
                                        </span>
                                    </a>
                                </li>
                                @endif
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
            // $('.simplebar-content-wrapper').scroll(
            // $('.simplebar-content-wrapper').css({'overflow':'visible !important'})
            // );
            $('#val-language').change(function(evt) {
                $.get(
                    "{{ route('changeLanguage') }}", {
                        language: evt.target.value
                    },
                    function(data, statues) {
                        //show alarm that language is changed
                        window.location.reload();
                    }
                )
            });
            $('#search_word').change(function(evt) {
                $.post(
                    "{{ route('searchfromdictionary') }}", {
                        'keyword': evt.target.value
                    },
                    function(data, statues) {

                    }
                )
            })
        }
    )
    $(function() {
        var availableTags = [
            "ActionScript",
            "AppleScript",
            "Asp",
            "BASIC",
            "C",
            "C++",
            "Clojure",
            "COBOL",
            "ColdFusion",
            "Erlang",
            "Fortran",
            "Groovy",
            "Haskell",
            "Java",
            "JavaScript",
            "Lisp",
            "Perl",
            "PHP",
            "Python",
            "Ruby",
            "Scala",
            "Scheme"
        ];

        function split(val) {
            return val.split(/,\s*/);
        }

        function extractLast(term) {
            return split(term).pop();
        }

        $("#search_word")
            // don't navigate away from the field on tab when selecting an item
            .on("keydown", function(event) {
                if (event.keyCode === $.ui.keyCode.TAB &&
                    $(this).autocomplete("instance").menu.active) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 0,
                source: function(request, response) {
                    // delegate back to autocomplete, but extract the last term
                    response($.ui.autocomplete.filter(
                        availableTags, extractLast(request.term)));
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    var terms = split(this.value);
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push(ui.item.value);
                    // add placeholder to get the comma-and-space at the end
                    terms.push("");
                    this.value = terms.join(", ");
                    return false;
                }
            });
    });

</script>

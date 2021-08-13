<header id="page-header" data-client="{{session("client")}}">
    <div class="content-header">
        <div>
            <button type="button" class="btn btn-rounded btn-dual mr-1" id="sidebar-control">
                <!-- <i class="fa fa-fw fa-bars"></i> -->
                <i class="fa fa-fw fa-bars"></i>
            </button>
            @if (isset(session('permission')->superadmin))
                <button type="button" class="btn btn-rounded btn-dual" style="margin-right: 10px;">
                    <a href="{{ route('superadminsettings') }}"><i class="fas fa-cogs"></i></a>
                </button>
            @endif
        </div>

        <div>
            <!-- User Profile Dropdown Menu -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual btn-rounded" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <!-- <i class="fa fa-fw fa-user d-sm-none"></i> -->
                    <span class="d-none d-sm-inline-block">
                        {{-- {{ $translation->l('Admin') }} --}}
                        {{Session::get('user_name')}}
                    </span>
                    <i class="fa fa-fw fa-user"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown"
                    x-placement="bottom-end"
                    style="position: absolute; transform: translate3d(-90px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <!-- <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                        User Options
                    </div> -->
                    <div class="p-2">
                        <!-- <a class="dropdown-item" href="#">
                            <i class="far fa-fw fa-user mr-1"></i> Profile
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="be_pages_generic_inbox.html">
                            <span><i class="far fa-fw fa-envelope mr-1"></i> Inbox</span>
                            <span class="badge badge-primary badge-pill">3</span>
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="far fa-fw fa-file-alt mr-1"></i> Invoices
                        </a> -->
                        <!-- <div role="separator" class="dropdown-divider"></div> -->

                        <!-- Toggle Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <!-- <a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="far fa-fw fa-building mr-1"></i> Settings
                        </a> -->
                        <!-- END Side Overlay -->

                        <!-- <div role="separator" class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="{{ url('/logout') }}">
                            <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> {{ $translation->l('Sign Out') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notification Drop Down -->
            @if (auth()->user()->type === 0)
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn btn-dual btn-rounded" id="page-header-notifications-dropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-fw fa-bell"></i>
                        {{-- <span class="badge badge-secondary badge-pill">6</span> --}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg p-0"
                        aria-labelledby="page-header-notifications-dropdown">
                        <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                            Clients
                        </div>
                        <ul class="nav-items my-2">
                            @foreach ($clients as $client)
                            <li>
                                <a class="text-dark media py-2 client-item" href="javascript:void(0)" id="client_{{$client['id']}}">
                                    <div class="mx-3">
                                        <i class="fa fa-fw fa-user text-primary"></i>
                                    </div>
                                    <div class="media-body font-size-sm pr-2">
                                        <div class="font-w600">
                                            {{$client["first_name"]}}&nbsp;{{$client["last_name"]}}
                                        </div>
                                        <div class="text-muted font-italic"></div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                            
                        <div class="p-2 border-top">
                            <a class="btn btn-light btn-block text-center" href="#">
                                <i class="fa fa-fw fa-eye mr-1"></i> {{ $translation->l('View All') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>


        <div id="page-header-search" class="overlay-header bg-primary">
            <div class="content-header">
                <form class="w-100" action="http://dev2.nabuserver.com/newlms/be_pages_generic_search.html"
                    method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control border-0" placeholder="Search your network.."
                            id="page-header-search-input" name="page-header-search-input">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" data-toggle="layout"
                                data-action="header_search_off">
                                <i class="fa fa-fw fa-times-circle"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="page-header-loader" class="overlay-header bg-primary-darker">
            <div class="content-header">
                <div class="w-100 text-center">
                    <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset("assets/js/headerPage.js?v=12")}}"></script>
</header>

<header id="page-header">
    <div class="content-header">
        @if(auth()->user()->type===0)
        <div>
            <button type="button" class="btn btn-rounded btn-dual mr-1" data-toggle="layout" data-action="sidebar_toggle">
                <!-- <i class="fa fa-fw fa-bars"></i> -->
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <button type="button" class="btn btn-rounded btn-dual" data-toggle="layout" data-action="side_overlay_toggle" style="margin-right: 10px;">
                <i class="fas fa-cogs"></i>
            </button>
        </div>

        <div>
            <!-- User Profile Dropdown Menu -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual btn-rounded" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <!-- <i class="fa fa-fw fa-user d-sm-none"></i> -->
                    <span class="d-none d-sm-inline-block">
                    {{$translation->l('Admin')}}
                    </span>
                    <i class="fa fa-fw fa-user"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown" x-placement="bottom-end" style="position: absolute; transform: translate3d(-90px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
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
                            <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> {{$translation->l('Sign Out')}}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Notification Drop Down -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual btn-rounded" id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="badge badge-secondary badge-pill">6</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg p-0" aria-labelledby="page-header-notifications-dropdown" style="">
                    <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                        {{$translation->l('Notifications')}}
                    </div>
                    <ul class="nav-items my-2">
                        <li>
                            <a class="text-dark media py-2" href="javascript:void(0)">
                                <div class="mx-3">
                                    <i class="fa fa-fw fa-user-plus text-primary"></i>
                                </div>
                                <div class="media-body font-size-sm pr-2">
                                    <div class="font-w600">{{$translation->l('John Doe send you a friend request!')}}</div>
                                    <div class="text-muted font-italic">6 min ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark media py-2" href="javascript:void(0)">
                                <div class="mx-3">
                                    <i class="fa fa-fw fa-user-plus text-primary"></i>
                                </div>
                                <div class="media-body font-size-sm pr-2">
                                    <div class="font-w600">{{$translation->l('Elisa Doe send you a friend request!')}}</div>
                                    <div class="text-muted font-italic">10 min ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark media py-2" href="javascript:void(0)">
                                <div class="mx-3">
                                    <i class="fa fa-check-circle text-success"></i>
                                </div>
                                <div class="media-body font-size-sm pr-2">
                                    <div class="font-w600">{{$translation->l('Backup completed successfully!')}}</div>
                                    <div class="text-muted font-italic">2 hours ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark media py-2" href="javascript:void(0)">
                                <div class="mx-3">
                                    <i class="fa fa-fw fa-user-plus text-primary"></i>
                                </div>
                                <div class="media-body font-size-sm pr-2">
                                    <div class="font-w600">{{$translation->l('George Smith send you a friend request!')}}</div>
                                    <div class="text-muted font-italic">3 hours ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark media py-2" href="javascript:void(0)">
                                <div class="mx-3">
                                    <i class="fa fa-exclamation-circle text-warning"></i>
                                </div>
                                <div class="media-body font-size-sm pr-2">
                                    <div class="font-w600">{{$translation->l('You are running out of space. Please consider upgrading your plan.')}}</div>
                                    <div class="text-muted font-italic">1 day ago</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="text-dark media py-2" href="javascript:void(0)">
                                <div class="mx-3">
                                    <i class="fa fa-envelope-open text-info"></i>
                                </div>
                                <div class="media-body font-size-sm pr-2">
                                    <div class="font-w600">You have a new message!</div>
                                    <div class="text-muted font-italic">2 days ago</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="p-2 border-top">
                        <a class="btn btn-light btn-block text-center" href="#">
                            <i class="fa fa-fw fa-eye mr-1"></i> {{$translation->l('View All')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <div id="page-header-search" class="overlay-header bg-primary">
            <div class="content-header">
                <form class="w-100" action="http://dev2.nabuserver.com/newlms/be_pages_generic_search.html" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control border-0" placeholder="Search your network.." id="page-header-search-input" name="page-header-search-input">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" data-toggle="layout" data-action="header_search_off">
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
        @endif
    </div>
</header>

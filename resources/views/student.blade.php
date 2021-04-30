@extends('welcome')

@section('con')

<style>
    #students .toolkit,
    #students .list-group-item {
        background-color: <?php echo "#" . $interfaceCfg->Students->c; ?> !important;
    }

    #students .list-group-item.active {
        background-color: <?php echo "#" . $interfaceCfg->Students->h; ?> !important;
    }

    #groups .toolkit,
    #groups .list-group-item {
        background-color: <?php echo "#" . $interfaceCfg->Groups->c; ?> !important;
    }

    #groups .list-group-item.active {
        background-color: <?php echo "#" . $interfaceCfg->Groups->h; ?> !important;
    }

    #teachers .toolkit,
    #teachers .list-group-item {
        background-color: <?php echo "#" . $interfaceCfg->Teachers->c; ?> !important;
    }

    #teachers .list-group-item.active {
        background-color: <?php echo "#" . $interfaceCfg->Teachers->h; ?> !important;
    }

    #authors .toolkit,
    #authors .list-group-item {
        background-color: <?php echo "#" . $interfaceCfg->Authors->c; ?> !important;
    }

    #authors .list-group-item.active {
        background-color: <?php echo "#" . $interfaceCfg->Authors->h; ?> !important;
    }

    #companies .toolkit,
    #companies .list-group-item {
        background-color: <?php echo "#" . $interfaceCfg->Companies->c; ?> !important;
    }

    #companies .list-group-item.active {
        background-color: <?php echo "#" . $interfaceCfg->Companies->h; ?> !important;
    }

    .nav-link#students-tab {
        background-color: <?php echo "#" . $interfaceCfg->Students->c; ?> !important;
    }

    .nav-link#students-tab.active {
        background-color: <?php echo "#" . $interfaceCfg->Students->h; ?> !important;
    }

    .nav-link#teachers-tab {
        background-color: <?php echo "#" . $interfaceCfg->Teachers->c; ?> !important;
    }

    .nav-link#teachers-tab.active {
        background-color: <?php echo "#" . $interfaceCfg->Teachers->h; ?> !important;
    }

    .nav-link#authors-tab {
        background-color: <?php echo "#" . $interfaceCfg->Authors->c; ?> !important;
    }

    .nav-link#authors-tab.active {
        background-color: <?php echo "#" . $interfaceCfg->Authors->h; ?> !important;
    }

    .nav-link#companies-tab {
        background-color: <?php echo "#" . $interfaceCfg->Companies->c; ?> !important;
    }

    .nav-link#companies-tab.active {
        background-color: <?php echo "#" . $interfaceCfg->Companies->h; ?> !important;
    }

    .nav-link#groups-tab {
        background-color: <?php echo "#" . $interfaceCfg->Groups->c; ?> !important;
    }

    .nav-link#groups-tab.active {
        background-color: <?php echo "#" . $interfaceCfg->Groups->h; ?> !important;
    }
</style>

<div id="content">
    <fieldset id="LeftPanel">
        <div id="div_A" class="window top">
            <ul class="nav nav-tabs border-0 mb-2 mx-4">
                <li class="nav-item">
                    <a class="nav-link active m-1 rounded-1 border-0" id="students-tab" href="#home">{{$translation->l('STUDENTS')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link m-1 rounded-1 border-0" id="teachers-tab" href="#menu1"> {{$translation->l('TEACHERS')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link m-1 rounded-1 border-0" id="authors-tab" href="#menu1">{{$translation->l('AUTHORS')}}</a>
                </li>
            </ul>

            <div class="clear-fix mx-4">
                <div id="students">
                    <div class="clear-fix text-white mb-3 toolkit" style="height:50px">
                        <strong class="float-left p-2">{{$translation->l('Mes cours')}}</strong>
                        <div class="float-right p-2">
                            <div class="input-container">
                                <i class="fa fa-plus icon p-2"></i>
                                <span class="bg-white text-black p-2 rounded">
                                    <input class="input-field border-0" type="text" name="usrnm">
                                    <i class="fa fa-search icon p-2"></i>
                                </span>
                                <i class="fa fa-bars icon p-2"></i>
                            </div>
                        </div>
                    </div>

                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                John Madeo
                            </div>
                            <div class="btn-group float-right">
                                <button class="btn text-primary px-2">
                                    <span class="font-weight-bolder">EN</span>
                                </button>
                                <button class="btn text-primary px-2">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn text-primary px-2" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-primary px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                John Hode
                            </div>
                            <div class="btn-group float-right">
                                <button class="btn text-primary px-2">
                                    <span class="font-weight-bolder">EN</span>
                                </button>
                                <button class="btn text-primary px-2">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn text-primary px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-primary px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                Rinda Nora
                            </div>
                            <div class="btn-group float-right">
                                <button class="btn text-primary px-2">
                                    <span class="font-weight-bolder">EN</span>
                                </button>
                                <button class="btn text-primary px-2">
                                    <i class="fa fa-eye"></i>
                                </button>
                                <button class="btn text-primary px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-primary px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>

                    </div>
                </div>

            </div>
        </div>
        <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white  mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">

            <div class="mx-4">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active container m-0 p-2" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        <div class="row">
                            <div class="card col-md-5 bg-white text-black p-3 mx-2 text-left">
                                <strong>
                                    {{$translation->l('Objectifs')}} :
                                    <i class="fa fa-cog float-right p-2"></i>
                                </strong>

                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eleifend
                                    magna dignissim nunc maximus
                                    maximus. Nunc eget laoreet purus.
                                    Proin interdum, felis non malesuada
                                    vehicula, est ante ornare tortor, blandit
                                </p>
                                <span>
                                    <b>{{$translation->l('Durée')}} :</b>25 minutes
                                </span>
                                <strong>
                                    <br>{{$translation->l('Langue')}} :</br>FR (français) En ligne
                                </strong>
                                <br>
                                <strong>
                                    <b>{{$translation->l('Public cible')}} :</b>techniciens
                                </strong>


                            </div>

                            <div class="px-2 col-md-3">
                                <div class="dropdown bg-primary show">
                                    <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$translation->l('Status')}}
                                        <i class="fa fa-chevron-down float-right p-1"></i>
                                    </a>

                                    <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink1">
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Action</a>
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Another</a>
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Something</a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 col-md-3">
                                <div class="dropdown bg-primary show">
                                    <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Créé le
                                    </a>

                                    <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink2">
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Action</a>
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Another</a>
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Something</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">Messages</div>
                    <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">Settings</div>
                </div>
            </div>


        </div>
    </fieldset>
    <div id="div_vertical" class="handler_vertical width-controller">
        <i class="fas fa-grip-lines-vertical text-white"></i>
    </div>
    <fieldset id="RightPanel">
        <div id="div_C" class="window top">

            <ul class="nav nav-tabs border-0 mb-2 mx-4">
                <li class="nav-item">
                    <a class="nav-link active m-1 rounded-1 border-0" id="groups-tab" href="#home">{{$translation->l('GROUPS')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link m-1 rounded-1 border-0" id="companies-tab" href="#menu1">{{$translation->l('COMPANIES')}}</a>
                </li>
            </ul>
            <div id="groups">
                <div class="toolkit clear-fix text-white mb-3 mx-4" style="height:50px">
                    <strong class="float-left p-2">{{$translation->l('Mes Parcours de Formation')}}</strong>
                    <div class="float-right p-2">
                        <div class="input-container">
                            <i class="fa fa-plus icon p-2"></i>
                            <span class="bg-white text-black p-2 rounded">
                                <input class="input-field border-0" type="text" name="usrnm">
                                <i class="fa fa-search icon p-2"></i>
                            </span>
                            <i class="fa fa-bars icon p-2"></i>
                        </div>
                    </div>
                </div>

                <div class="list-group mx-4" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active p-1 border-0 " id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Delta co.
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn text-primary px-2">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button class="btn text-primary px-2" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 border-0  " id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Moscow university
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn text-primary px-2">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 border-0  " id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Tronto stuff company
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn text-primary px-2">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                            </button>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div id="div_right" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_D" class="window bottom">

            <div class="tab-content mx-4" id="nav-tabContent">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card bg-white text-black mx-2">
                            <img src="{{ asset('assets/media/17.jpg') }}" alt="" class="card-img-top">
                            <div class="card-body  p-3">
                                <strong>
                                    {{$translation->l('Objectifs')}} :
                                    <i class="fa fa-cog float-right p-2"></i>
                                </strong>

                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eleifend
                                    magna dignissim nunc maximus
                                    maximus. Nunc eget laoreet purus.
                                    Proin interdum, felis non malesuada
                                    vehicula, est ante ornare tortor, blandit
                                </p>
                                <span>
                                    <b>
                                        {{$translation->l('Durée')}} :
                                    </b> 25 minutes
                                </span>
                                <br>
                                <span class="text-wrap">
                                    <b>
                                        {{$translation->l('Langue')}} :
                                    </b>FR (français) En ligne
                                </span>
                                <br>
                                <span>
                                    <b>
                                        {{$translation->l('Public cible')}} :
                                    </b>
                                </span>
                                techniciens
                            </div>
                        </div>
                    </div>

                    <div class="px-2 col-md-3">
                        <div class="dropdown bg-blue-2 show">
                            <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{$translation->l('Status')}}
                                <i class="fa fa-chevron-down float-right p-1"></i>
                            </a>

                            <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink3">
                                <a class="dropdown-item p-1 bg-blue-2 text-green-0 mb-0" href="#">Action</a>
                                <a class="dropdown-item p-1 bg-blue-2 text-red-0 mb-0" href="#">Another</a>
                            </div>
                        </div>
                    </div>
                    <div class="px-2 col-md-3">
                        <div class="dropdown bg-primary show">
                            <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Cree le
                            </a>

                            <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink4">
                                <a class="dropdown-item p-1 bg-red-1 text-white mb-0" href="#">Action</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade " id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">Messages</div>
                <div class="tab-pane fade " id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">Settings</div>
            </div>

        </div>
    </fieldset>
</div>
<script>
    $('#utilisateurs').addClass('active');
</script>
@endsection

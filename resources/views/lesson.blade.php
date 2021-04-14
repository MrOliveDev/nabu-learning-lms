@extends('welcome')

@section('con')
<div id="lesson-blade">
    <div class="d-flex mb-3 wrap" id="content">
        <div class="px-2 resizable resizable1" style="width:600px" id="RightPanel">
            <div class="clear-fix">

                <div class="clear-fix bg-primary text-white mb-3 toolkit" style="height:50px">
                    <strong class="float-left p-2">Mes cours</strong>
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
                            Module1
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
                            <button class="btn text-primary px-2">
                                <i class="fa fa-play"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-cube"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action  p-1 border-0" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Module1
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
                            <button class="btn text-primary px-2">
                                <i class="fa fa-play"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-cube"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action  p-1 border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Module1
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
                            <button class="btn text-primary px-2">
                                <i class="fa fa-play"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-cube"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Module1
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
                            <button class="btn text-primary px-2">
                                <i class="fa fa-play"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-cube"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 border-0" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Module1
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
                            <button class="btn text-primary px-2">
                                <i class="fa fa-play"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-cube"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Module1
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
                            <button class="btn text-primary px-2">
                                <i class="fa fa-play"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-cube"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>
                    </a>
                </div>

            </div>

            <div class="height-controller" id="div_left"><i class="fa fa-grip-lines"></i></div>

            <div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active container m-0 p-2" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        <div class="row">
                            <div class="card col-md-5 bg-white text-black p-3 mx-2">
                                <strong>
                                    Objectifs :
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
                                    <b>Durée :</b>25 minutes
                                </span>
                                <strong>
                                    <br>Langue :</br>FR (français) En ligne
                                </strong>
                                <br>
                                <strong>
                                    <b>Public cible :</b>techniciens
                                </strong>


                            </div>

                            <div class="px-2 col-md-3">
                                <div class="dropdown bg-primary show">
                                    <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Status
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



        <div class="p-2 width-controller my-auto" id="div_vertical"><i class="fas fa-grip-lines-vertical"></i></div>



        <div class="flex-grow-1" id="">
            <div class="px-2">

                <div class="toolkit clear-fix bg-danger text-white mb-3" style="height:50px">
                    <strong class="float-left p-2">Mes Parcours de Formation</strong>
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
                    <a class="list-group-item list-group-item-action active p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Module1
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
                            <button class="btn text-primary px-2">
                                <i class="fa fa-play"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-cube"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 border-0" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Module1
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
                            <button class="btn text-primary px-2">
                                <i class="fa fa-play"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-cube"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            Module1
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
                            <button class="btn text-primary px-2">
                                <i class="fa fa-play"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-cube"></i>
                            </button>
                            <button class="btn text-primary px-2">
                                <i class="fa fa-sync-alt"></i>
                            </button>
                        </div>
                    </a>
                </div>

                <div class="height-controller" id="div_right"><i class="fa fa-grip-lines"></i></div>

                <div class="tab-content" id="nav-tabContent">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card bg-white text-black mx-2">
                                <img src="{{ asset('assets/media/17.jpg') }}" alt="" class="card-img-top">
                                <div class="card-body  p-3">
                                    <strong>
                                        Objectifs :
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
                                            Durée :
                                        </b> 25 minutes
                                    </span>
                                    <br>
                                    <span class="text-wrap">
                                        <b>
                                            Langue :
                                        </b>FR (français) En ligne
                                    </span>
                                    <br>
                                    <span>
                                        <b>
                                            Public cible :
                                        </b>
                                    </span>
                                    techniciens
                                </div>
                            </div>
                        </div>

                        <div class="px-2 col-md-3">
                            <div class="dropdown bg-blue-2 show">
                                <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Status
                                    <i class="fa fa-chevron-down float-right p-1"></i>
                                </a>

                                <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink3">
                                    <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Action</a>
                                    <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Another</a>
                                    <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Something</a>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 col-md-3">
                            <div class="dropdown bg-primary show">
                                <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Cree le
                                </a>

                                <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink4">
                                    <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Action</a>
                                    <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Another</a>
                                    <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">Something</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">Messages</div>
                    <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">Settings</div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $('#session').addClass('active')
</script>
@endsection

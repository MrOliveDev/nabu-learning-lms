@extends('welcome')

@section('con')
<div id="content">
    <fieldset id="LeftPanel">
        <div id="div_A" class="window top">
            <div class="clear-fix toolkit mx-4 flex-column">

                <div class="clear-fix bg-primary text-white mb-3" style="height:50px;">
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

            </div>
            <div class="list-group mx-4" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active  p-1 border-0 bg-blue-1" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
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
                <a class="list-group-item list-group-item-action  p-1 border-0 bg-blue-1" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
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
                <a class="list-group-item list-group-item-action  p-1 border-0 bg-blue-1" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
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
                <a class="list-group-item list-group-item-action  p-1 border-0 bg-blue-1" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
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
                <a class="list-group-item list-group-item-action p-1 border-0  bg-blue-1" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
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
                <a class="list-group-item list-group-item-action p-1 border-0  bg-blue-1" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
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
        <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white  mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">

            <div class="px-4">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active container m-0 p-2" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs border-0 mb-2">
                            <li class="nav-item">
                                <a class="nav-link active m-1 bg-red-1 rounded-1 border-0" href="#home">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link m-1 bg-red-0 rounded-1 border-0" href="#menu1">Menu 1</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content border-0 mb-3">
                            <div id="home" class="container tab-pane active border-0 p-0">

                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading bg-red-0 text-left rounded-1">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="text-white">
                                                <h4 class="panel-title mb-0 p-2">Collapsible Group 1 <i class="fa fa-tint-slash float-right text-yellow-0"></i></h4>
                                            </a>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse in">
                                            <div class="panel-body pl-5 mt-2">
                                                <div class="list-group" id="list-tab" role="tablist">
                                                    <a class="list-group-item list-group-item-action active p-1 border-0 bg-blue-1 text-black">
                                                        <div class="float-left">
                                                            <i class="fa fa-circle text-danger m-2"></i>
                                                            Module1
                                                        </div>
                                                    </a>
                                                    <a class="list-group-item list-group-item-action active p-1 border-0 bg-blue-1 text-black">
                                                        <div class="float-left">
                                                            <i class="fa fa-circle text-danger m-2"></i>
                                                            Module1
                                                        </div>
                                                    </a>
                                                    <a class="list-group-item list-group-item-action active p-1 border-0 bg-blue-1 text-black">
                                                        <div class="float-left">
                                                            <i class="fa fa-circle text-danger m-2"></i>
                                                            Module1
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div id="menu1" class="container tab-pane fade"><br>
                                <h3>Menu 1</h3>
                                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
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
            <div class="row py-3 bg-white rounded m-0 mx-4">
                <div class="col-md-6">
                    <div class="card bg-white text-black">
                        <img src="{{ asset('assets/media/17.jpg') }}" alt="" class="card-img-top">
                        <i class="fa fa-cog float-right p-2 position-absolute ml-auto" style="right:0;"></i>
                        <div class="card-body  p-3">
                            <strong>
                                Objectifs :
                            </strong>
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
                <div class="col-md-6">
                    <div class="card bg-white text-black border-0">
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
                            sodales enim diam eu leo. Nam
                            malesuada in tortor quis pharetra.
                            Vestibulum ante ipsum primis in
                            faucibus orci luctus et ultrices posuere
                            cubilia curae; Curabitur ultricies odio
                            velit, vitae rutrum ipsum viverra in.
                            Suspendisse mollis et dolor gravida
                            ultrices. Aenean iaculis, orci ultrices
                            posuere sagittis, nisi felis fermentum
                            quam, viverra euismod eros velit non
                            ligula. Etiam sit amet tempor massa
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="div_right" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_D" class="window bottom">
            <div class="toolkit clear-fix bg-red-0 text-white mb-3 mx-4 flex-column" style="height:50px;">
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

            <div class="list-group mx-4" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active p-1 border-0 bg-red-1" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
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
                <a class="list-group-item list-group-item-action p-1 border-0 bg-red-1" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
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
                <a class="list-group-item list-group-item-action p-1 border-0 bg-red-1" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
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
    </fieldset>
</div>
@endsection

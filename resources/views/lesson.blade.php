@extends('welcome')

@section('con')

<style>
        #lesson .toolkit, #lesson .list-group-item{
            background-color:<?php echo "#".$lessonCfg->color_schemar_hex; ?> !important;
        }
        #lesson .list-group-item.active{
            background-color:<?php echo "#".$lessonCfg->color_schemar_hex_hover; ?> !important;
        }
        #training-course .toolkit, #training-course .list-group-item{
            background-color:<?php echo "#".$trainingcourseCfg->color_schemar_hex; ?> !important;
        }
        #training-course .list-group-item.active{
            background-color:<?php echo "#".$trainingcourseCfg->color_schemar_hex_hover; ?> !important;
        }

</style>


<div id="content">
    <fieldset id="LeftPanel">
        <div id="div_A" class="window top">

            <div class="clear-fix mx-4" id="lesson">

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

                    <a class="list-group-item list-group-item-action active  p-1 border-0" id="" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$translation->l('Module1')}}
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn text-primary px-2">
                                <span class="font-weight-bolder">EN</span>
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
                    <a class="list-group-item list-group-item-action  p-1 border-0" id="" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$translation->l('Module1')}}
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn text-primary px-2">
                                <span class="font-weight-bolder">EN</span>
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
                    <a class="list-group-item list-group-item-action p-1 border-0" id="" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$translation->l('Module1')}}
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn text-primary px-2">
                                <span class="font-weight-bolder">EN</span>
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
                            <div class="card col-md-5 bg-white text-black p-3 mx-2">
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
                                    <b>{{$translation->l('Public cible')}} :</b>{{$translation->l('techniciens')}}
                                </strong>


                            </div>

                            <div class="px-2 col-md-3">
                                <div class="dropdown bg-primary show">
                                    <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{$translation->l('Status')}}
                                        <i class="fa fa-chevron-down float-right p-1"></i>
                                    </a>

                                    <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink1">
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">{{$translation->l('Action')}}</a>
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">{{$translation->l('Another')}}</a>
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">{{$translation->l('Something')}}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="px-2 col-md-3">
                                <div class="dropdown bg-primary show">
                                    <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Créé le
                                    </a>

                                    <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink2">
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">{{$translation->l('Action')}}</a>
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">{{$translation->l('Another')}}</a>
                                        <a class="dropdown-item p-1 bg-blue-2 text-white mb-0" href="#">{{$translation->l('Something')}}</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">{{$translation->l('Messages')}}</div>
                    <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">{{$translation->l('Settings')}}</div>
                </div>
            </div>


        </div>
    </fieldset>
    <div id="div_vertical" class="handler_vertical width-controller">
        <i class="fas fa-grip-lines-vertical text-white"></i>
    </div>
    <fieldset id="RightPanel">
        <div id="div_C" class="window top">
            <div id="training-course">
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

                    <a class="list-group-item list-group-item-action p-1 border-0" id="training-course" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$translation->l('Module1')}}
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

                    <a class="list-group-item list-group-item-action active p-1 border-0" id="training-course" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$translation->l('Module1')}}
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
                                {{$translation->l('techniciens')}}
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
                                <a class="dropdown-item p-1 bg-blue-2 text-green-0 mb-0" href="#">{{$translation->l('Action')}}</a>
                                <a class="dropdown-item p-1 bg-blue-2 text-red-0 mb-0" href="#">{{$translation->l('Another')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="px-2 col-md-3">
                        <div class="dropdown bg-primary show">
                            <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Cree le
                            </a>

                            <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink4">
                                <a class="dropdown-item p-1 bg-red-1 text-white mb-0" href="#">{{$translation->l('Action')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade " id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">{{$translation->l('Messages')}}</div>
                <div class="tab-pane fade " id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">{{$translation->l('Settings')}}</div>
            </div>

        </div>
    </fieldset>
</div>
<script>
    $('#parcours').addClass('active');

</script>
@endsection

@extends('welcome')

@section('con')
<div id="content">
    <fieldset id="LeftPanel">
        <div id="div_A" class="window top">
            <div class="clear-fix mx-4">

                <div class="clear-fix bg-warning text-white mb-3 toolkit" style="height:50px">
                    <strong class="float-left p-2">Template</strong>
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
                    @foreach($templates as $template)
                    <a class="list-group-item list-group-item-action p-1 border-0 bg-yellow-2" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$template->name}}
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
                    @endforeach

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
                    <a class="nav-link m-1 bg-green-2 rounded-1 border-0" href="#menu1">COMPANIES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active m-1 bg-green-2 rounded-1 border-0" href="#home">TRAINING COURSES</a>
                </li>
            </ul>

            <div class="toolkit clear-fix bg-success text-white mb-3 mx-4" style="height:50px">
                <strong class="float-left p-2">Companies</strong>
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
                <a class="list-group-item list-group-item-action active p-1 border-0 bg-green-1" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                    <div class="float-left">
                        <i class="fa fa-circle text-danger m-2"></i>
                        Delta co.
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
                <a class="list-group-item list-group-item-action p-1 border-0  bg-green-1" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                    <div class="float-left">
                        <i class="fa fa-circle text-danger m-2"></i>
                        Moscow university
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
                <a class="list-group-item list-group-item-action p-1 border-0  bg-green-1" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                    <div class="float-left">
                        <i class="fa fa-circle text-danger m-2"></i>
                        Tronto stuff company
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

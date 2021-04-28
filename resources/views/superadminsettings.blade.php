@extends('welcome')

@section('css_after')
<link rel="stylesheet" href="assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<style>
    #LeftPanel {
        width: 30%;
        float: left;
    }

    #RightPanel {
        width: 70%;
        float: right;
    }

    #LeftPanel1 {
        width: 30%;
        float: left;
    }

    #RightPanel1 {
        width: 70%;
        float: right;
    }

    .list-group-item {
        background-color: #c8c7c7 !important;
    }

    .list-group-item.active {
        background-color: #362f81 !important;
    }

    .nav-link {
        background-color: #c8c7c7 !important;
    }

    .nav-link {
        background-color: #362f81 !important;
    }

    .card,
    .card-body,
    .form-group {
        background-color: #c8c7c7 !important;
    }
</style>
@endsection

@section('js_after')
<script src="{{asset('assets/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>

<script>
    jQuery(function() {
        Dashmix.helpers(['colorpicker']);
    });
</script>
@endsection

@section('con')
<script>
    $(function() {
        $("#tabs").tabs();
    });
</script>
<div id="tabs">
    <ul class="nav nav-tabs border-0 mb-2">
        <li class="nav-item">
            <a class="nav-link active m-1 bg-red-1 rounded-1 border-0" href="#clients">CLIENTS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link m-1 bg-red-0 rounded-1 border-0" href="#languages">LANGUAGES</a>
        </li>
        <li class="nav-item">
            <a class="nav-link m-1 bg-red-0 rounded-1 border-0" href="#reports">REPORTS</a>
        </li>
    </ul>
    <div id="clients">
        <div id="content">
            <fieldset id="LeftPanel">
                <div class="px-4">
                    <div class="list-group m-0" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                Client1
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                Client2
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                Client3
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>

                    </div>
                </div>
            </fieldset>
            <div id="div_vertical" class="handler_vertical width-controller">
                <i class="fas fa-grip-lines-vertical text-white"></i>
            </div>
            <fieldset id="RightPanel">

                <div class="mx-4">

                    <div class="row">
                        <div class="card text-black mx-2 col-md-8 pt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{asset('assets/media/17.jpg')}}" alt="" class="card-img-top">
                                    <i class="fa fa-cog float-right p-3 position-absolute ml-auto" style="right:0;"></i>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="js-colorpicker input-group" data-format="hex">
                                            <label for="" class="pr-2">
                                                Menu Background
                                            </label>
                                            <div class="input-group-append float-right">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="js-colorpicker input-group" data-format="hex">
                                            <label for="" class="pr-2">
                                                Page Background
                                            </label>
                                            <div class="input-group-append float-right">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="js-colorpicker input-group" data-format="hex">
                                            <label for="" class="pr-2">
                                                Icon over color
                                            </label>
                                            <div class="input-group-append float-right">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="js-colorpicker input-group" data-format="hex">
                                            <label for="" class="pr-2">
                                                Icon default color
                                            </label>
                                            <div class="input-group-append float-right">
                                                <span class="input-group-text colorpicker-input-addon">
                                                    <i></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="float-right">
                                        <span>
                                            Restore Default
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body  p-3">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Login Administrator
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="" name="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Password
                                            </span>
                                        </div>
                                        <input type="password" class="form-control" id="" name="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Company
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="" name="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Name
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="" name="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Surname
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="" name="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Complete Address
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="" name="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Email
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="" name="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Language of the Platform
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="" name="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Pack
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="" name="">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <button type="submit" class="float-right bg-blue-0 text-white p-1 mx-2">SAVE</button>
                                    <button type="reset" class="float-right bg-blue-0 text-white p-1">CANCEL</button>
                                </div>
                            </div>
                        </div>

                        <div class="px-2 col-md-3">
                            <div class="dropdown bg-primary show mb-8">
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
                            <div class="dropdown bg-primary show mb-8">
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

                    </div>

            </fieldset>
        </div>
    </div>



    <div id="languages">

        <div class="content1">
            <fieldset id="LeftPanel1">
                <div class="mx-4">
                    <div class="list-group m-0" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                French
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                English
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                Polish
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>

                    </div>
                </div>
            </fieldset>
            <div id="div_vertical1" class="handler_vertical width-controller">
                <i class="fas fa-grip-lines-vertical text-white"></i>
            </div>
            <fieldset id="RightPanel1">
                <div class="px-4">

                    <div class="card bg-secondary text-black  col-md-11">
                        <div class="card-body p-3">

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Lesson Plan
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Appendix
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Curren Language
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Interface Language
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="float-right bg-blue-0 text-white p-1 mx-2">SAVE</button>
                                <button type="reset" class="float-right bg-blue-0 text-white p-1">CANCEL</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>


    </div>
</div>

@endsection

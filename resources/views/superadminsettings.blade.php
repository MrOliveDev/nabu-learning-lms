@extends('welcome')


<?php
$icon = asset("assets/media/part.png"); ?>
@section('css_after')
<link rel="stylesheet" href="{{asset('assets/js/plugins/summernote/summernote-bs4.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css')}}">
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

    .nav-item .nav-link {
        background-color: #c8c7c7 !important;
    }

    .nav-item[aria-selected='true'] .nav-link {
        background-color: #362f81 !important;
    }

    .card,
    .card-body,
    .form-group {
        background-color: #c8c7c7 !important;
    }

    #color-picker-select .active-item span {
        background-color: #aaa;
    }

    #color-picker-select label {
        width: 200px;
    }

    #color-picker-select .active-item i.pl-2.fas.fa-crosshairs {
        color: green;
    }
    .fas.fa-crosshairs {
        font-size: 26pt;
        color: red;
    }

    .dropdown-menu {
        min-width: 0px;
    }

    .dropdown-toggle::after {
        border: 0px;
    }

    .input-group>.input-group-prepend>.input-group-text {
        background-color: transparent;
        border-color: transparent;
    }

    .custom-control-label::before {
        background-color: green;
        border-color: green;
    }

    .custom-control-input:checked~.custom-control-label::before {
        background-color: red;
        border-color: red;
    }

    i.pl-2.fas.fa-crosshairs:hover {
        padding: 5px;
        font-size: 20pt;
        transition: all .1s;
    }


    #preview {
        cursor: url('{{$icon}}'),
        cell;
    }

    .card-body.p-3 span.input-group-text {
        min-width: 200px;
    }


    .form-group button:hover {
        background-color: #d52f72 !important;
        border: 0px;
    }

    .input-group>.input-group-prepend>.input-group-text {
        background-color: transparent;
        border-color: transparent;
    }

    .btn-hero-primary {
        background-color: #2d4272;
    }

    .btn-hero-primary:hover #upload_button:hover {
        background-color: #d52f72;
    }

    #upload_button{
        color:#2d4272;
    }
    #upload_button:hover{
        color:#d52f72;
    }
    #reports .list-group-item {
        background-color: transparent !important;
    }


</style>
@endsection

@section('js_after')
<script src="{{asset('assets/js/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script>
    jQuery(function() {
        // Dashmix.helpers(['colorpicker', 'summernote']);
        Dashmix.helpers(['colorpicker', 'summernote', 'rangeslider']);
    });

</script>

@endsection

@section('con')
<script>
    $(function() {
        $("#tabs, #tab1").tabs();
    });
</script>
<div id="tabs">
    <ul class="nav nav-tabs border-0 mb-2 px-4">
        <li class="nav-item">
            <a class="nav-link active mr-2 bg-red-1 rounded-1 border-0" href="#clients">CLIENTS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link mr-2 bg-red-0 rounded-1 border-0" href="#languages">LANGUAGES</a>
        </li>
        <li class="nav-item">
            <a class="nav-link mr-2 bg-red-0 rounded-1 border-0" href="#reports">REPORTS</a>
        </li>
    </ul>
    <div id="clients">
        @yield('client');
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
                        <a class="text-white float-left" href="#" style="font-size:40px; line-height: 30px; font-weight: 900;">+</a>
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
                                    <input type="text" class="form-control" id="lessonPlan" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Appendix
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="appendix" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Curren Language
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="currenLanguage" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Interface Language
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="interfaceLanguage" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-hero-primary float-right mx-1">SAVE</button>
                                <button type="button" class="btn btn-hero-primary float-right mx-1">CANCEL</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

    </div>
    <div id="reports">

        <div id="content">
            <fieldset id="LeftPanel">
                <div id="div_A" class="window top">
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
                            <a class="text-white float-left" href="#" style="font-size:40px; line-height: 30px; font-weight: 900;">+</a>
                        </div>
                    </div>
                </div>

                <div id="div_left2" class="handler_horizontal text-center font-size-h3 text-white  mb-4">
                    <i class="fas fa-grip-lines"></i>
                </div>
                <div id="div_B" class="window bottom">
                    <div class="px-4">
                        <div id="tab1">
                            <ul class="nav nav-tabs border-0 mb-2">
                                <li class="nav-item">
                                    <a class="nav-link active mr-2 bg-red-1 rounded-1 border-0" href="#variables">Variables</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mr-2 bg-red-0 rounded-1 border-0" href="#contentbloc">Content bloc</a>
                                </li>
                            </ul>
                            <div id="variables">
                                <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">

                                    #First Name
                                    <i class="fas fa-hourglass"></i>
                                </a>
                                <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">

                                    #First Name
                                    <i class="fas fa-hourglass"></i>
                                </a>
                                <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">

                                    #First Name
                                    <i class="fas fa-hourglass"></i>
                                </a>
                            </div>
                            <div id="contentbloc">
                                <div class="list-group m-0" id="list-tab" role="tablist">
                                    <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">

                                        #First Name
                                        <i class="fas fa-cube"></i>
                                    </a>
                                    <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">

                                        #First Name
                                        <i class="fas fa-cube"></i>
                                    </a>
                                    <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">

                                        #First Name
                                        <i class="fas fa-cube"></i>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div id="div_vertical2" class="handler_vertical width-controller">
                <i class="fas fa-grip-lines-vertical text-white"></i>
            </div>
            <fieldset id="RightPanel">
                <div class="block-content block-content-full">
                    <!-- Summernote Container -->
                    <div class="js-summernote">Hello Summernote!</div>
                </div>
            </fieldset>
        </div>

    </div>
</div>


@endsection

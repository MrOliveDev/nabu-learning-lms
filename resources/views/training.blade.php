@extends('welcome')

@section('con')

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cropper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/cropperModal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}" />
    <style>
        :root {
            --lesson-c:
                <?php
                echo '#'. $interfaceCfg->Lessons->c;
            ?>
            ;
            --lesson-h:
                <?php
                echo '#'. $interfaceCfg->Lessons->h;
            ?>
            ;
            --training-c:
                <?php
                echo '#'. $interfaceCfg->TrainingCourses->c;
            ?>
            ;
            --training-h:
                <?php
                echo '#'. $interfaceCfg->TrainingCourses->h;
            ?>
            ;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/trainingPage.css') }}">


@section('js_after')
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>

    <script src="{{ asset('assets/js/cropper.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.js') }}"></script>
    <script src="{{ asset('assets/js/cropperModal1.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/trainingPage.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script>
        jQuery(function() {
            Dashmix.helpers(['select2', 'rangeslider', 'notify', 'summernote']);
        });

    </script>

@endsection

<div id="content">
    <fieldset id="LeftPanel">
        <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column mx-4"
            id="lesson-toolkit">
            <div class="w-100 p-2">
                <div class="input-container">
                    <a href="#" class="toolkit-add-item">
                        <i class="fa fa-plus icon p-2 text-white"></i>
                    </a>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 search-filter" type="text" name="search-filter">
                        <i class="fa fa-search icon p-2"></i>
                    </span>
                    <a href="#" class="toolkit-show-filter float-right">
                        <i class="fas fa-sliders-h icon p-2  text-white"></i>
                    </a>
                </div>
            </div>
            <div class="filter p-2 toolkit-filter">
                <div class="float-left">
                    <div class="status-switch">
                        <input type="radio" id="filter-state-on" name="status" value="1">
                        <span>TO BE EDITED&nbsp;</span>
                        <input type="radio" id="filter-state-off" name="status" value="2">
                        <span>TO BE CHECKED&nbsp;</span>
                        <input type="radio" id="filter-state-all" name="status" value="3">
                        <span>TO BE FIXED&nbsp;</span>
                        <input type="radio" id="filter-state-all" name="status" value="4">
                        <span>APPROVED&nbsp;</span>
                        <input type="radio" id="filter-state-all" name="status" value="5">
                        <span>ONLINE&nbsp;</span>
                        <input type="radio" id="filter-state-all" name="status" value="all">
                        <span>ALL&nbsp;</span>
                        <input type="radio" id="filter-state-all" name="status" value="orphans">
                        <span>ORPHANS&nbsp;</span>
                    </div>
                </div>
                <div class="float-right">
                    <button value='' class="rounded text-white filter-name-btn px-1 border-0">Name
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                    <button value='' class="rounded text-white filter-date-btn px-1 border-0">Date
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="div_A" class="window top">
            <div class="clear-fix mx-4">
                <div class="list-group" id="list-tab" role="tablist" data-src=''>
                    @foreach ($lessons as $lesson)
                        <a class="list-group-item list-group-item-action p-0 border-transparent border-5x lesson_{{ $lesson['id'] }}"
                            id="lesson_{{ $lesson['id'] }}" data-date="{{ $lesson['creation_date'] }}"
                            data-training="{{ implode('_', $lesson['training']) }}">
                            <div class="float-left">
                                @if ($lesson['status'] == 1)
                                    <i class="fa fa-circle  m-2" style="color:green;"></i>
                                    <input type="hidden" name="item-status" class='status-notification' value="1">
                                @elseif ($lesson['status'] == 2)
                                    <i class="fa fa-circle m-2" style="color:blue;"></i>
                                    <input type="hidden" name="item-status" class='status-notification' value="0">
                                @elseif ($lesson['status'] == 3)
                                    <i class="fa fa-circle m-2" style="color:yellow;"></i>
                                    <input type="hidden" name="item-status" class='status-notification' value="0">
                                @elseif ($lesson['status'] == 4)
                                    <i class="fa fa-circle m-2" style="color:orange;"></i>
                                    <input type="hidden" name="item-status" class='status-notification' value="0">
                                @else
                                    <i class="fa fa-circle m-2" style="color:white;"></i>
                                    <input type="hidden" name="item-status" class='status-notification' value="0">
                                @endif
                                <span class="item-name">{{ $lesson['name'] }}</span>
                                <input type="hidden" name="item-name" value="{{ $lesson['name'] }}">
                            </div>
                            <div class="btn-group float-right">
                                <span
                                    class=" p-2 font-weight-bolder item-lang">{{ strtoupper($lesson['language_iso']) }}</span>
                                <button class="btn  item-show" data-content='lesson'
                                    data-item-id="{{ $lesson['id'] }}">
                                    <i class="px-2 fa fa-eye"></i>
                                </button>
                                <button class="btn item-edit" data-content='lesson'
                                    data-item-id="{{ $lesson['id'] }}">
                                    <i class="px-2 fa fa-edit"></i>
                                </button>
                                <button class="btn item-delete" data-content='lesson'
                                    data-item-id="{{ $lesson['id'] }}">
                                    <i class="px-2 fa fa-trash-alt"></i>
                                </button>
                                <button class="btn item-play" data-content='lesson'
                                    data-fabrica="{{ $lesson['idFabrica'] }}">
                                    <i class="px-2 fa fa-play"></i>
                                </button>
                                <button class="btn item-template" data-content='lesson'
                                    data-template="{{ $lesson['template_player_id'] }}">
                                    <i class="px-2 fa fa-cube"></i>
                                </button>
                                <button class="btn item-refresh" data-content='lesson'
                                    data-item-id="{{ $lesson['id'] }}">
                                    <i class="px-2 fa fa-sync-alt"></i>
                                </button>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white  mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">

            <div class="mx-4">
                <form method="post" id="lesson_form" enctype="multipart/form-data" class="form"
                    action="http://localhost:8000/newlms/user" autocomplete="off" data-cate="" data-item="">
                    <input type="hidden" name="_token" value="aoenpfPhy8DEX9wObeHolrgRMtZc3zD7LcnH2I2Q">
                    <input name="_method" type="hidden" value="POST" class="method-select">
                    <div class="card text-black pt-3">
                        <div class="card-body  p-3">

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Name<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="lesson_name" name="lesson_name" value=""
                                        required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Duration<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="lesson_duration" name="lesson_duration"
                                        value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Target audience<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="lesson_target" name="lesson_target"
                                        value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Status
                                        </span>
                                    </div>
                                    <select class="form-control" id="lesson_status" name="lesson_status">
                                        <option value="" selected>No Status</option>
                                        <option value="1">TO BE EDITED</option>
                                        <option value="2">TO BE CHECKED</option>
                                        <option value="3">TO BE FIXED</option>
                                        <option value="4">APPROVED</option>
                                        <option value="5">ONLINE</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Language
                                        </span>
                                    </div>
                                    <select class="form-control" id="lesson_language" name="lesson_language">
                                        <option value="" selected>No Langauge</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->language_id }}">
                                                {{ $language->language_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="input-group-text bg-transparent border-0">
                                    Description<span class="text-danger">*</span>
                                </span>
                                <textarea class="form-control clearfix w-100" id="lesson-description"
                                    required></textarea>
                            </div>
                            <div class="form-group clearfix">
                                <button type="submit" class="btn btn-hero-primary float-right mx-1 submit-btn"
                                    id="lesson_save_button" data-form="lesson_form">SAVE</button>
                                <button type="button" class="btn btn-hero-primary float-right mx-1 cancel-btn"
                                    id="lesson_cancel_button">CANCEL</button>
                            </div>

                        </div>
                    </div>
                </form>

                <div class="second-table" id="lesson-table">
                    <div class="list-group" id="list-tab" role="tablist" data-src=''>

                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div id="div_vertical" class="handler_vertical width-controller">
        <i class="fas fa-grip-lines-vertical text-white"></i>
    </div>
    <fieldset id="RightPanel">
        <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column mx-4"
            id="training-toolkit">
            <div class="w-100 p-2">
                <div class="input-container">
                    <a href="#" class="toolkit-add-item">
                        <i class="fa fa-plus icon p-2 text-white"></i>
                    </a>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 search-filter" type="text" name="search-filter">
                        <i class="fa fa-search icon p-2"></i>
                    </span>
                    <a href="#" class="toolkit-show-filter float-right">
                        <i class="fas fa-sliders-h icon p-2  text-white"></i>
                    </a>
                </div>
            </div>
            <div class="filter p-2 toolkit-filter">
                <div class="float-left">
                    <div class="status-switch">
                        <input type="radio" id="filter-state-on" name="status" value="on">
                        <span>on&nbsp;</span>
                        <input type="radio" id="filter-state-off" name="status" value="off">
                        <span>off&nbsp;</span>
                        <input type="radio" id="filter-state-all" name="status" value="all">
                        <span>all&nbsp;</span>
                    </div>
                </div>
                <div class="float-right">
                    <button value='' class="rounded text-white filter-name-btn px-1 border-0">Name
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                    <button value='' class="rounded text-white filter-date-btn px-1 border-0">Date
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="div_C" class="window top">
            <div class="clear-fix mx-4">
                <div class="list-group" id="list-tab" role="tablist" data-src=''>
                    @foreach ($trainings as $training)
                        <a class="list-group-item list-group-item-action p-0 border-transparent border-5x training_{{ $training->id }}"
                            id="training_{{ $training->id }}" data-date="{{ $training->creation_date }}"
                            data-lesson='{{ $training->lesson_content }}'>
                            <div class="float-left">
                                @if ($training->status != 0)
                                    <i class="fa fa-circle  m-2" style="color:green;"></i>
                                    <input type="hidden" name="item-status" class='status-notification' value="1">
                                @else
                                    <i class="fa fa-circle m-2" style="color:red;"></i>
                                    <input type="hidden" name="item-status" class='status-notification' value="0">
                                @endif
                                <span class="item-name">{{ $training->name }}</span>
                                <input type="hidden" name="item-name" value="{{ $training->name }}">
                            </div>
                            <div class="btn-group float-right">
                                <span
                                    class=" p-2 font-weight-bolder  item-lang">{{ strtoupper($training->language_iso) }}</span>

                                <button class="btn  item-type" data-content='training'
                                    data-value="{{ $training->type }}" data-item-id="{{ $training->id }}">
                                    @if ($training->type == 1)
                                        <i class="px-2 fas fa-wave-square"></i>
                                    @else
                                        <i class="px-2 fas fa-sort-amount-down-alt"></i>
                                    @endif
                                </button>
                                <button class="btn item-show" data-content='training'
                                    data-item-id="{{ $training->id }}">
                                    <i class="px-2 fa fa-eye"></i>
                                </button>
                                <button class="btn item-edit" data-content='training'
                                    data-item-id="{{ $training->id }}">
                                    <i class="px-2 fa fa-edit"></i>
                                </button>
                                <button class="btn item-delete" data-content='training'
                                    data-item-id="{{ $training->id }}">
                                    <i class="px-2 fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="div_right" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_D" class="window bottom">

            <div class=" mx-4" id="nav-tabContent">
                <form method="post" id="training_form" enctype="multipart/form-data" class="form" action=""
                    autocomplete="off" data-cate="" data-item="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input name='_method' type='hidden' value='PUT' class='method-select' />
                    <div class="card text-black">
                        <div class="justify-content-center flex-wrap pb-3" style="overflow:hidden;">
                            <div>
                                <i class="fa fa-cog float-right p-3 position-absolute ml-auto" style="right:0;"
                                    id="upload_button">
                                    <input type="file" name="image" class="image" accept="image/*" hidden>
                                </i>
                                <img src="" alt="" id="preview-rect" width="100%" height="300px" name="preview" />
                                <input type="hidden" name="base64_img_data" id="base64_img_data">
                            </div>
                        </div>
                        <div class="form-group m-5 my-auto" id='status-form'>
                            <div class="custom-control custom-switch custom-control-lg mb-2 ml-0 ">
                                <input type="checkbox" class="custom-control-input" id="training-status-icon"
                                    name="training-status-icon" checked="">
                                <label class="custom-control-label" for="training-status-icon">Online/Offline</label>
                            </div>
                        </div>
                        <div class="card-body  p-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Name<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="training_name" name="training_name"
                                        value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Duration<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="training_duration"
                                        name="training_duration" value="" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Language
                                        </span>
                                    </div>
                                    <select class="form-control" id="training_language" name="training_language">
                                        <option value="" selected>No Langauge</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->language_id }}">
                                                {{ $language->language_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Type
                                        </span>
                                    </div>
                                    <select class="form-control" id="training_type" name="training_type">
                                        <option value="" selected>No Type</option>
                                        <option value="1">Step by step</option>
                                        <option value="2">Free</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <span class="input-group-text bg-transparent border-0">
                                    Description<span class="text-danger">*</span>
                                </span>
                                <textarea class="form-control clearfix w-100" id="training-description"
                                    required></textarea>
                            </div>
                            <div class="form-group clearfix">
                                <button type="submit" class="btn btn-hero-primary float-right mx-1 submit-btn"
                                    id="training_save_button" data-form="training_form">SAVE</button>
                                <button type="button" class="btn btn-hero-primary float-right mx-1 cancel-btn"
                                    id="training_cancel_button">CANCEL</button>
                            </div>

                        </div>
                    </div>
                </form>
                <div id="training-table" class="second-table">
                    <div class="list-group" id="list-tab" role="tablist" data-src=''>

                    </div>
                </div>
            </div>
            <div class="modal myModal fade mt-lg-5" id="image-crop-modal" tabindex="-1" role="dialog"
                aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-body" id="drop">
                            <!-- <div id="drop">Drop files here.</div> -->

                            <div class="img-container" id="img-range-slider">

                                <!-- <img id="image" src="https://avatars0.githubusercontent.com/u/3456749" style="max-width:500px;"> -->
                                <div class="form-group" id="zoom-rangeslider-group">
                                    <input type="text" class="js-rangeslider" id="zoom-rangeslider" value="50">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="crop">Crop</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div>
<script>
    $('#parcours').addClass('active');

</script>
@endsection

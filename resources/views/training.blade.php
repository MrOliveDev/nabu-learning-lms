@extends('welcome')

@section('con')
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

    <script src="{{ asset('assets/js/cropper.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.js') }}"></script>
    <script src="{{ asset('assets/js/cropperModal.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/trainingPage.js') }}"></script>
    
    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script>
        $('#utilisateurs').addClass('active');
        jQuery(function() {
            Dashmix.helpers(['select2', 'rangeslider', 'notify', 'summernote']);
        });

    </script>

@endsection



    <div id="content">
        <fieldset id="LeftPanel">
            <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column mx-4"
                id="user-toolkit">
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
                        <button value='' class="rounded text-white filter-name-btn px-1 border-0">Name
                            <i class="fas fa-sort-numeric-down"></i>
                        </button>
                        <button value='' class="rounded text-white filter-date-btn px-1 border-0">Date
                            <i class="fas fa-sort-numeric-down"></i>
                        </button>
                    </div>
                    <div class="float-right">
                        <button type="button" value="" class="rounded text-white filter-company-btn px-1 border-0">company
                            +<i></i></button>&nbsp;
                        <button type="button" value="" class="rounded text-white filter-function-btn px-1 border-0">function
                            +<i></i></button>
                    </div>
                </div>
            </div>
            <div id="div_A" class="window top">
                <div class="clear-fix mx-4">
                    <div class="list-group" id="list-tab" role="tablist" data-src=''>
                        @foreach ($lessons as $lesson)
                            <a class="list-group-item list-group-item-action  p-1 border-0" id="lesson_{{ $lesson->id }}"
                                data-date="{{ $lesson->creation_date }}">
                                <div class="float-left">
                                    @if ($lesson->status != 0)
                                        <i class="fa fa-circle  m-2" style="color:green;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="1">
                                    @else
                                        <i class="fa fa-circle m-2" style="color:red;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="0">
                                    @endif
                                    <span
                                        class="item-name">{{ $lesson->name }}</span>

                                </div>
                                <div class="btn-group float-right">
                                    <span class=" p-2 font-weight-bolder">EN</span>
                                    <button class="btn  item-show" data-content='lesson'>
                                        <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    <button class="btn item-edit" data-content='lesson'>
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    <button class="btn item-delete" data-content='lesson'>
                                        <i class="px-2 fa fa-trash-alt"></i>
                                    </button>
                                    <button class="btn item-play px-2" data-content='lesson'>
                                        <i class="fa fa-play"></i>
                                    </button>
                                    <button class="btn item-template px-2" data-content='lesson'>
                                        <i class="fa fa-cube"></i>
                                    </button>
                                    <button class="btn item-refresh px-2" data-content='lesson'>
                                        <i class="fa fa-sync-alt"></i>
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
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active container m-0 p-2" id="list-home" role="tabpanel"
                            aria-labelledby="list-home-list">
                            <div class="row">
                                <div class="card col-md-5 bg-white text-black p-3 mx-2">
                                    <strong>
                                        {{ $translation->l('Objectifs') }} :
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
                                        <b>{{ $translation->l('Durée') }} :</b>25 minutes
                                    </span>
                                    <strong>
                                        <br>{{ $translation->l('Langue') }} :</br>FR (français) En ligne
                                    </strong>
                                    <br>
                                    <strong>
                                        <b>{{ $translation->l('Public cible') }}
                                            :</b>{{ $translation->l('techniciens') }}
                                    </strong>


                                </div>

                                <div class="px-2 col-md-3">
                                    <div class="dropdown bg-primary show">
                                        <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button"
                                            id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            {{ $translation->l('Status') }}
                                            <i class="fa fa-chevron-down float-right p-1"></i>
                                        </a>

                                        <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink1">
                                            <a class="dropdown-item p-1 bg-blue-2 text-white mb-0"
                                                href="#">{{ $translation->l('Action') }}</a>
                                            <a class="dropdown-item p-1 bg-blue-2 text-white mb-0"
                                                href="#">{{ $translation->l('Another') }}</a>
                                            <a class="dropdown-item p-1 bg-blue-2 text-white mb-0"
                                                href="#">{{ $translation->l('Something') }}</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="px-2 col-md-3">
                                    <div class="dropdown bg-primary show">
                                        <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button"
                                            id="dropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Créé le
                                        </a>

                                        <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink2">
                                            <a class="dropdown-item p-1 bg-blue-2 text-white mb-0"
                                                href="#">{{ $translation->l('Action') }}</a>
                                            <a class="dropdown-item p-1 bg-blue-2 text-white mb-0"
                                                href="#">{{ $translation->l('Another') }}</a>
                                            <a class="dropdown-item p-1 bg-blue-2 text-white mb-0"
                                                href="#">{{ $translation->l('Something') }}</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                            {{ $translation->l('Messages') }}</div>
                        <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                            {{ $translation->l('Settings') }}</div>
                    </div>

                    <div id="lesson-form-tags" class="second-table">

                    </div>
                </div>
            </div>
        </fieldset>
        <div id="div_vertical" class="handler_vertical width-controller">
            <i class="fas fa-grip-lines-vertical text-white"></i>
        </div>
        <fieldset id="RightPanel">
            <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column mx-4"
                id="user-toolkit">
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
                        <button value='' class="rounded text-white filter-name-btn px-1 border-0">Name
                            <i class="fas fa-sort-numeric-down"></i>
                        </button>
                        <button value='' class="rounded text-white filter-date-btn px-1 border-0">Date
                            <i class="fas fa-sort-numeric-down"></i>
                        </button>
                    </div>
                    <div class="float-right">
                        <button type="button" value="" class="rounded text-white filter-company-btn px-1 border-0">company
                            +<i></i></button>&nbsp;
                        <button type="button" value="" class="rounded text-white filter-function-btn px-1 border-0">function
                            +<i></i></button>
                    </div>
                </div>
            </div>
            <div id="div_C" class="window top">
                <div class="clear-fix mx-4">
                    <div class="list-group" id="list-tab" role="tablist" data-src=''>
                        @foreach ($trainings as $training)
                            <a class="list-group-item list-group-item-action  p-1 border-0" id="training_{{ $training->id }}"
                                data-date="{{ $training->creation_date }}">
                                <div class="float-left">
                                    @if ($training->status != 0)
                                        <i class="fa fa-circle  m-2" style="color:green;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="1">
                                    @else
                                        <i class="fa fa-circle m-2" style="color:red;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="0">
                                    @endif
                                    <span
                                        class="item-name">{{ $training->name }}</span>
                                    <input type="hidden" name="item-name"
                                        value="{{ $training->name }}">
                                </div>
                                <div class="btn-group float-right">
                                    <span class=" p-2 font-weight-bolder">EN</span>

                                    <button class="btn  item-show" data-content='training'>
                                        <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    <button class="btn item-edit" data-content='training'>
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    <button class="btn item-delete" data-content='training'>
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

                <div class="tab-content mx-4" id="nav-tabContent">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card bg-white text-black mx-2">
                                <img src="{{ asset('assets/media/17.jpg') }}" alt="" class="card-img-top">
                                <div class="card-body  p-3">
                                    <strong>
                                        {{ $translation->l('Objectifs') }} :
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
                                            {{ $translation->l('Durée') }} :
                                        </b> 25 minutes
                                    </span>
                                    <br>
                                    <span class="text-wrap">
                                        <b>
                                            {{ $translation->l('Langue') }} :
                                        </b>FR (français) En ligne
                                    </span>
                                    <br>
                                    <span>
                                        <b>
                                            {{ $translation->l('Public cible') }} :
                                        </b>
                                    </span>
                                    {{ $translation->l('techniciens') }}
                                </div>
                            </div>
                        </div>

                        <div class="px-2 col-md-3">
                            <div class="dropdown bg-blue-2 show">
                                <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button"
                                    id="dropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    {{ $translation->l('Status') }}
                                    <i class="fa fa-chevron-down float-right p-1"></i>
                                </a>

                                <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink3">
                                    <a class="dropdown-item p-1 bg-blue-2 text-green-0 mb-0"
                                        href="#">{{ $translation->l('Action') }}</a>
                                    <a class="dropdown-item p-1 bg-blue-2 text-red-0 mb-0"
                                        href="#">{{ $translation->l('Another') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="px-2 col-md-3">
                            <div class="dropdown bg-primary show">
                                <a class="btn btn-primary dropdown-toggle w-100" href="#" role="button"
                                    id="dropdownMenuLink4" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Cree le
                                </a>

                                <div class="dropdown-menu show p-0" aria-labelledby="dropdownMenuLink4">
                                    <a class="dropdown-item p-1 bg-red-1 text-white mb-0"
                                        href="#">{{ $translation->l('Action') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                        {{ $translation->l('Messages') }}</div>
                    <div class="tab-pane fade " id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                        {{ $translation->l('Settings') }}</div>
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

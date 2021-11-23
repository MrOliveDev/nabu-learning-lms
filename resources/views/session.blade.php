@extends('layout')

@section('con')

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cropper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/cropperModal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}" />

    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/jquery-password-validation-while-typing/css/jquery.passwordRequirements.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/jquery-password-validation-while-typing/demo.css') }}" />
    <meta name='date' content="{{ date('Y-m-d') }}">

    <style>
        :root {
            --student-c:
                <?php
                echo '#' . $interfaceCfg->Students->h;
                ?>;
            --student-h:
                <?php
                echo '#' . $interfaceCfg->Students->c;
                ?>;
            --teacher-c:
                <?php
                echo '#' . $interfaceCfg->Teachers->h;
                ?>;
            --teacher-h:
                <?php
                echo '#' . $interfaceCfg->Teachers->c;
                ?>;
            --author-c:
                <?php
                echo '#' . $interfaceCfg->Authors->h;
                ?>;
            --author-h:
                <?php
                echo '#' . $interfaceCfg->Authors->c;
                ?>;
            --group-c:
                <?php
                echo '#' . $interfaceCfg->Groups->h;
                ?>;
            --group-h:
                <?php
                echo '#' . $interfaceCfg->Groups->c;
                ?>;
            --company-c:
                <?php
                echo '#' . $interfaceCfg->Companies->h;
                ?>;
            --company-h:
                <?php
                echo '#' . $interfaceCfg->Companies->c;
                ?>;
            --position-c:
                <?php
                echo '#' . $interfaceCfg->Positions->h;
                ?>;
            --position-h:
                <?php
                echo '#' . $interfaceCfg->Positions->c;
                ?>;
            --session-c:
                <?php
                echo '#' . $interfaceCfg->Sessions->h;
                ?>;
            --session-h:
                <?php
                echo '#' . $interfaceCfg->Sessions->c;
                ?>;
            --training-c:
                <?php
                echo '#' . $interfaceCfg->TrainingCourses->c;
                ?>;
            --training-h:
                <?php
                echo '#' . $interfaceCfg->TrainingCourses->h;
                ?>;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/sessionPage.css') }}">


@section('js_after')
    <script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

    <script src="{{ asset('assets/js/cropper.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.js') }}"></script>
    <script src="{{ asset('assets/js/cropperModal.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script
        src="{{ asset('assets/js/plugins/jquery-password-validation-while-typing/js/jquery.passwordRequirements.min.js') }}">
    </script>
    <script src="{{ asset('assets/js/sessionPage.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script>
        $(function() {
            $("#RightPanel").tabs();
            $(".second-table").tabs();
        });
    </script>
    <script>
        jQuery(function() {
            Dashmix.helpers(['select2', 'rangeslider', 'notify', 'summernote', 'flatpickr', 'datepicker']);
        });
    </script>
@endsection

<div id="content" data-session-display="{{ isset(session('permission')->session->session->display) }}"
    data-session-delete="{{ isset(session('permission')->session->session->delete) }}"
    data-session-show="{{ isset(session('permission')->session->session->show) }}"
    data-session-edit="{{ isset(session('permission')->session->session->edit) }}"
    data-session-create="{{ isset(session('permission')->session->session->create) }}"
    data-student-display="{{ isset(session('permission')->session->student->display) }}"
    data-student-link="{{ isset(session('permission')->session->student->link) }}"
    data-teacher-display="{{ isset(session('permission')->session->teacher->display) }}"
    data-teacher-link="{{ isset(session('permission')->session->teacher->link) }}"
    data-group-display="{{ isset(session('permission')->session->group->display) }}"
    data-group-link="{{ isset(session('permission')->session->group->link) }}"
    data-search-session="{{ isset(session('permission')->session->search->session) }}"
    data-search-category="{{ isset(session('permission')->session->search->category) }}">
    <fieldset id="LeftPanel">
        <div class="mx-4 mb-3 text-white clear-fix toolkit d-flex justify-content-lg-start flex-column"
            id="session-toolkit">
            <div class="p-2 w-100">
                <span style="font-size:16pt" id="toolkit-tab-name">SESSIONS</span>
                <div class="float-right input-container">
                    @if (isset(session('permission')->session->session->create))
                        <a href="#" class="toolkit-add-item">
                            <i class="p-2 text-white fa fa-plus icon"></i>
                        </a>
                    @endif
                    <span class="p-2 text-black bg-white rounded">
                        <input class="border-0 input-field mw-100 search-filter" type="text" name="search-filter">
                        <i class="p-2 fa fa-search icon"></i>
                    </span>
                    <a href="#" class="float-right toolkit-show-filter">
                        <i class="p-2 text-white fas fa-sliders-h icon"></i>
                    </a>
                </div>
            </div>
            <div class="p-2 filter toolkit-filter">
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
                    <button value='' class="px-1 text-white border-0 rounded filter-name-btn">Name
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                    <button value='' class="px-1 text-white border-0 rounded filter-date-btn">Date
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                    <button type="button" value="" class="px-1 text-white border-0 rounded filter-company-btn"
                        style="display:none;">company
                        +<i></i></button>&nbsp;
                    <button type="button" value="" class="px-1 text-white border-0 rounded filter-function-btn"
                        style="display:none;">function
                        +<i></i></button>
                </div>
            </div>
        </div>
        <div id="div_A" class="window top">
            <div class="mx-4 clear-fix">
                <div id="session">
                    <div class="list-group" id="list-tab" role="tablist" data-src=''>
                        @if (isset(session('permission')->session->session->display))
                            @foreach ($sessions as $session)
                                <a class="list-group-item list-group-item-action p-0 border-transparent border-5x session_{{ $session->id }}"
                                    id="session_{{ $session->id }}" data-date='{{ $session->create_date }}'
                                    data-participant='{{ $session->participants }}'
                                    data-content="{{ $session->contents }}">
                                    <div class="float-left">
                                        @if ($session->status == 1)
                                            <i class="m-2 fa fa-circle" style="color:green;"></i>
                                            <input type="hidden" name="item-status" class='status-notification'
                                                value="1">
                                        @else
                                            <i class="m-2 fa fa-circle" style="color:red;"></i>
                                            <input type="hidden" name="item-status" class='status-notification'
                                                value="0">
                                        @endif
                                        <span class="item-name">{{ $session->name }}</span>
                                        <input type="hidden" name="item-name" value="{{ $session->name }}">
                                    </div>
                                    <div class="float-right btn-group">
                                        <span
                                            class="p-2 font-weight-bolder item-lang">{{ strtoupper($session->language_iso) }}
                                        </span>
                                        @if (isset(session('permission')->session->session->delete))

                                            <button class="btn item-mail"
                                                onclick="redirectPage('{{ route('sendmail') }}?sessionId={{ $session->id }}')"
                                                data-id="{{ $session->id }}">
                                                <i class="px-2 fa fa-envelope"></i>
                                            </button>
                                            <button class="btn item-delete" data-content='session'>
                                                <i class="px-2 fa fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="div_left" class="mb-4 text-center text-white handler_horizontal font-size-h3">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">
            <div class="mx-4">
                <div id="user-form-tags" class="second-table">
                    <ul class="mb-2 border-0 nav nav-tabs">
                        <li class="nav-item">
                            <a class="m-1 border-0 nav-link active rounded-1" id="table-participant-tab"
                                href="#table-participant">Participants</a>
                        </li>
                        <li class="nav-item">
                            <a class="m-1 border-0 nav-link rounded-1" id="table-content-tab" href="#table-content">
                                Contents</a>
                        </li>
                    </ul>

                    <div id="table-participant">
                        <div class="list-group" id="list-tab" role="tablist" data-src=''>

                        </div>
                    </div>
                    <div id="table-content">
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


        </div>
    </fieldset>
    <div id="div_vertical" class="handler_vertical width-controller">
        <i class="text-white fas fa-grip-lines-vertical"></i>
    </div>
    <fieldset id="RightPanel">


        <ul class="mx-4 mb-2 border-0 nav nav-tabs">
            <li class="nav-item">
                <a class="m-1 border-0 nav-link active rounded-1" id="students-tab"
                    href="#students">{{ $translation->l('STUDENTS') }}</a>
            </li>
            <li class="nav-item">
                <a class="m-1 border-0 nav-link rounded-1" id="teachers-tab" href="#teachers">
                    {{ $translation->l('TEACHERS') }}</a>
            </li>
            <li class="nav-item">
                <a class="m-1 border-0 nav-link rounded-1" id="groups-tab" href="#groups">GROUPS</a>
            </li>
        </ul>
        <div class="mx-4 mb-3 text-white clear-fix toolkit d-flex justify-content-lg-start flex-column"
            id="cate-toolkit">
            <div class="p-2 w-100">
                <div class="float-right input-container">
                    {{-- <a href="#" class="toolkit-add-item">
                        <i class="p-2 text-white fa fa-plus icon"></i>
                    </a> --}}
                    <span class="p-2 text-black bg-white rounded">
                        <input class="border-0 input-field mw-100 search-filter" type="text" name="search-filter">
                        <i class="p-2 fa fa-search icon"></i>
                    </span>
                    <a href="#" class="float-right toolkit-show-filter">
                        <i class="p-2 text-white fas fa-sliders-h icon"></i>
                    </a>
                </div>
            </div>
            <div class="p-2 filter toolkit-filter">
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
                    <span>
                        <button value='' class="px-1 text-white border-0 rounded filter-name-btn">Name
                            <i class="fas"></i>
                        </button>
                        <button value='' class="px-1 text-white border-0 rounded filter-date-btn">Date
                            <i class="fas"></i>
                        </button>
                    </span>
                    <button type="button" value="" class="px-1 text-white border-0 rounded filter-company-btn">company
                        +<i></i></button>&nbsp;
                    <button type="button" value="" class="px-1 text-white border-0 rounded filter-function-btn">function
                        +<i></i></button>
                </div>
            </div>
        </div>
        <div id="div_C" class="window top">
            <div class="mx-4 clear-fix">
                <div id="paticipant-group">
                    <div id="students">


                        <div class="list-group" id="list-tab" role="tablist" data-src=''>
                            @if (isset(session('permission')->session->student->display))
                                @foreach ($students as $student)
                                    <a class="list-group-item list-group-item-action p-0 border-transparent border-5x student_{{ $student->id }}"
                                        id="student_{{ $student->id }}" data-date="{{ $student->creation_date }}">
                                        <div class="float-left">
                                            @if ($student->status == 1)
                                                <i class="m-2 fa fa-circle" style="color:green;"></i>
                                                <input type="hidden" name="item-status" class='status-notification'
                                                    value="1">
                                            @else
                                                <i class="m-2 fa fa-circle" style="color:red;"></i>
                                                <input type="hidden" name="item-status" class='status-notification'
                                                    value="0">
                                            @endif
                                            <span
                                                class="item-name">{{ $student->first_name }}&nbsp;{{ $student->last_name }}</span>
                                            <input type="hidden" name="item-name"
                                                value="{{ $student->first_name }}{{ $student->last_name }}">
                                            <input type="hidden" name="item-group"
                                                value="{{ $student->linked_groups }}">
                                            <input type="hidden" name="item-company" value="{{ $student->company }}">
                                            <input type="hidden" name="item-function"
                                                value="{{ $student->function }}">
                                        </div>
                                        <div class="float-right btn-group">
                                            <span
                                                class="p-2 font-weight-bolder item-lang">{{ strtoupper($student->language_iso) }}
                                            </span>
                                            <button class="btn item-mail"
                                                onclick="redirectPage('{{ route('sendmail') }}?studentId={{ $student->id }}')">
                                                <i class="px-2 fa fa-envelope"></i>
                                            </button>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div id="teachers">

                        <div class="list-group" id="list-tab" role="tablist" data-src=''>
                            @if (isset(session('permission')->session->teacher->display))
                                @foreach ($teachers as $teacher)
                                    <a class="list-group-item list-group-item-action p-0 border-transparent border-5x teacher_{{ $teacher->id }}"
                                        id="teacher_{{ $teacher->id }}" data-date="{{ $teacher->creation_date }}">
                                        <div class="float-left">
                                            @if ($teacher->status == 1)
                                                <i class="m-2 fa fa-circle" style="color:green;"></i>
                                                <input type="hidden" name="item-status" class='status-notification'
                                                    value="1">
                                            @else
                                                <i class="m-2 fa fa-circle" style="color:red;"></i>
                                                <input type="hidden" name="item-status" class='status-notification'
                                                    value="0">
                                            @endif
                                            <span
                                                class="item-name">{{ $teacher->first_name }}&nbsp;{{ $teacher->last_name }}</span>
                                            <input type="hidden" name="item-name"
                                                value="{{ $teacher->first_name }}{{ $teacher->last_name }}">
                                            <input type="hidden" name="item-group"
                                                value="{{ $teacher->linked_groups }}">
                                            <input type="hidden" name="item-company" value="{{ $teacher->company }}">
                                            <input type="hidden" name="item-function"
                                                value="{{ $teacher->function }}">
                                        </div>
                                        <div class="float-right btn-group">
                                            <span
                                                class="p-2 font-weight-bolder item-lang">{{ strtoupper($teacher->language_iso) }}</span>
                                            <button class="btn item-mail"
                                                onclick="redirectPage('{{ route('sendmail') }}?teacherId={{ $teacher->id }}')">
                                                <i class="px-2 fa fa-envelope"></i>
                                            </button>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div id="groups">
                        <div class="list-group" id="list-tab" role="tablist" data-src=''>
                            @if (isset(session('permission')->session->group->display))
                                @foreach ($groups as $group)
                                    <a class="list-group-item list-group-item-action p-0 border-transparent border-5x group_{{ $group->id }}"
                                        id="group_{{ $group->id }}" data-date="{{ $group->creation_date }}">
                                        <div class="float-left">
                                            @if ($group->status == 1)
                                                <i class="m-2 fa fa-circle" style="color:green;"></i>
                                                <input type="hidden" name="item-status" class="status-notification"
                                                    value="1">
                                            @else
                                                <i class="m-2 fa fa-circle" style="color:red;"></i>
                                                <input type="hidden" name="item-status" class="status-notification"
                                                    value="0">
                                            @endif
                                            <span class="item-name">{{ $group->name }}</span>
                                            <input type="hidden" name="item-name" value="{{ $group->name }}">
                                        </div>
                                        <div class="float-right btn-group">
                                            <button class="btn toggle2-btn" data-content="group">
                                                <i class="px-2 fas fa-check-circle"></i>
                                            </button>
                                            <button class="btn item-mail"
                                                onclick="redirectPage('{{ route('sendmail') }}?groupId={{ $group->id }}')">
                                                <i class="px-2 fa fa-envelope"></i>
                                            </button>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div id="companies">

                        <div class="mx-4 list-group" id="list-tab" role="tablist" data-src=''>
                            @foreach ($companies as $company)
                                <a class="list-group-item list-group-item-action p-0 border-transparent border-5x company_{{ $company->id }}"
                                    id="company_{{ $company->id }}" data-date="{{ $company->creation_date }}">
                                    <div class="float-left">
                                        <span class="item-name">{{ $company->name }}</span>
                                        <input type="hidden" name="item-name" value="{{ $company->name }}">
                                    </div>
                                    <div class="float-right btn-group">
                                        <button class="btn toggle2-btn" data-content='company'>
                                            <i class="px-2 fas fa-check-circle"></i>
                                        </button>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div id="positions">

                        <div class="mx-4 list-group" id="list-tab" role="tablist" data-src=''>
                            @foreach ($positions as $position)
                                <a class="list-group-item list-group-item-action p-0 border-transparent border-5x function_{{ $position->id }}"
                                    id="function_{{ $position->id }}">
                                    <div class="float-left">
                                        <!-- <i class="m-2 fa fa-circle text-danger"></i> -->
                                        <span class="item-name">{{ $position->name }}</span>
                                        <input type="hidden" name="item-name" value="{{ $position->name }}">
                                    </div>
                                    <div class="float-right btn-group">
                                        <button class="btn toggle2-btn" data-content='position'>
                                            <i class="px-2 fas fa-check-circle"></i>
                                        </button>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="content-group">
                    <div id="trainings">
                        <div class="list-group" id="list-tab" role="tablist" data-src=''>
                            @foreach ($trainings as $training)
                                <a class="list-group-item list-group-item-action p-0 border-transparent border-5x training_{{ $training->id }}"
                                    id="training_{{ $training->id }}" data-date="{{ $training->creation_date }}"
                                    data-lesson='{{ $training->lesson_content }}'>
                                    <div class="float-left">
                                        @if ($training->status != 0)
                                            <i class="m-2 fa fa-circle" style="color:green;"></i>
                                            <input type="hidden" name="item-status" class='status-notification'
                                                value="1">
                                        @else
                                            <i class="m-2 fa fa-circle" style="color:red;"></i>
                                            <input type="hidden" name="item-status" class='status-notification'
                                                value="0">
                                        @endif
                                        <span class="item-name">{{ $training->name }}</span>
                                        <input type="hidden" name="item-name" value="{{ $training->name }}">
                                    </div>
                                    <div class="float-right btn-group">
                                        <span
                                            class="p-2 font-weight-bolder item-lang">{{ strtoupper($training->language_iso) }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="div_right" class="mb-4 text-center text-white handler_horizontal font-size-h3">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_D" class="window bottom">

            <div class="mx-4 tab-content" id="nav-tabContent">
                <form method="post" id="session_form" enctype="multipart/form-data" class="form" action=""
                    onSubmit="false">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input name='_method' type='hidden' value='PUT' class='method-select' />
                    <div class="mx-2 text-black bg-white card">
                        <div class="p-3 card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Name<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="session_name" name="session_name"
                                        value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Description
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="session_description"
                                        name="session_description" value="">
                                </div>
                            </div>
                            <div class="form-group" id="expired_date_input">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Start date
                                        </span>
                                    </div>
                                    <input type="text" class="bg-white js-flatpickr form-control" id="begin_date"
                                        name="begin_date" placeholder="Y-m-d" data-date-format="Y-m-d" required
                                        title="You need a correct date">

                                </div>
                            </div>
                            <div class="form-group" id="expired_date_input">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            End date
                                        </span>
                                    </div>
                                    <input type="text" class="bg-white js-flatpickr form-control" id="end_date"
                                        name="end_date" placeholder="Y-m-d" data-date-format="Y-m-d" required
                                        title="You need a correct date">

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Language
                                        </span>
                                    </div>
                                    <select class="form-control" id="language" name="language" required>
                                        <option value="" selected>Langauge</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->language_id }}">
                                                {{ $language->language_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend mb-5">
                                        <span class="input-group-text">
                                            Maximum attempt to evaluation
                                        </span>
                                    </div>
                                </div>
                                <input type="text" class="js-rangeslider" id="attempts"
                                    name="attempts" value="0">
                            </div>
                        </div>
                        <div class="form-group" id='status-form-group'>
                            <div class="mb-2 ml-0 custom-control custom-switch custom-control-lg ">
                                <input type="checkbox" class="custom-control-input" id="session-status-icon"
                                    name="session-status-icon">
                                <label class="custom-control-label" for="session-status-icon">Session Offline</label>
                            </div>
                        </div>
                        <div class="clearfix form-group">
                            <button type="submit" class="float-right mx-1 btn btn-hero-primary submit-btn"
                                id="session_save_button" data-form="session_form">SAVE</button>
                            <button type="button" class="float-right mx-1 btn btn-hero-primary cancel-btn"
                                id="user_cancel_button">CANCEL</button>
                            <input type="hidden" name="cate-status">
                        </div>
                    </div>
            </div>
            </form>
        </div>
</div>
</fieldset>
</div>
<button type="button" id="notificator" class="js-notify btn btn-secondary push" data-message="Your message!<br>"
    style="display:none">
    Top Right
</button>
<script>
    $('#sessions').addClass('active');

    function redirectPage(link) {
        window.location.href = link;
    }
</script>
@endsection 

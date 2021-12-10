<!-- <i class="fas fa-graduation-cap"></i> -->
@extends('layout')

@section('con')


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

            --report-c: "";
            --report-h: "";
        }

    </style>

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/admindashPage.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/js/admindashPage.js') }}"></script>
    {{-- <script src="{{asset("assets/")}}"></script>
<script src="{{asset("assets/")}}"></script> --}}
    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>

    <script>
        jQuery(function() {
            Dashmix.helpers(['notify', 'summernote']);
        });
    </script>
    <div id="admindash" data-permission="{{ isset(session('permission')->admindash) }}">

        <div class="tab-row">
            <div class="tab-item"
                style='background-color: {{ session('paneBack') ? session('paneBack') : '#c3aaca' }}'>
                <div class="tab-content">
                    <div class="tab-avatar"
                        style='background-color: {{ session('iconBack') ? session('iconBack') : '#912891' }}'>
                        <i class="fa fa-users"></i>
                    </div>
                    <span class="tab-item-value counter">0</span>
                    <input type="hidden" class="store-value" value="{{ $registeredUsers }}">
                    <span class="tab-description">Registered<br>Users</span>
                    <div class="tab-link"
                        style='background-color: {{ session('capBack') ? session('capBack') : '#946e97' }}'>
                        {{ $translation->l('Consulter') }} <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </div>

            <div class="tab-item"
                style='background-color: {{ session('paneBack') ? session('paneBack') : '#c3aaca' }}'>
                <div class="tab-content">
                    <div class="tab-avatar"
                        style='background-color: {{ session('iconBack') ? session('iconBack') : '#912891' }}'>
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <span class="tab-item-value counter">0</span>
                    <input type="hidden" class="store-value" value="{{ $activedStudents }}">
                    <span class="tab-description">Actived <br>Students</span>
                    <div class="tab-link"
                        style='background-color: {{ session('capBack') ? session('capBack') : '#946e97' }}'>
                        {{ $translation->l('Consulter') }} <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </div>
            <div class="tab-item"
                style='background-color: {{ session('paneBack') ? session('paneBack') : '#c3aaca' }}'>
                <div class="tab-content">
                    <div class="tab-avatar"
                        style='background-color: {{ session('iconBack') ? session('iconBack') : '#912891' }}'>
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <span class="tab-item-value counter">0</span>
                    <input type="hidden" class="store-value" value="{{ $sessionsInProgress }}">
                    <span class="tab-description">Sessions <br>in Progress</span>
                    <div class="tab-link"
                        style='background-color: {{ session('capBack') ? session('capBack') : '#946e97' }}'>
                        {{ $translation->l('Consulter') }} <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </div>
            <div class="tab-item"
                style='background-color: {{ session('paneBack') ? session('paneBack') : '#c3aaca' }}'>
                <div class="tab-content">
                    <div class="tab-avatar"
                        style='background-color: {{ session('iconBack') ? session('iconBack') : '#912891' }}'>
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <span class="tab-item-value counter">0</span>
                    <input type="hidden" class="store-value" value="{{ $createdLessons }}">
                    <span class="tab-description">Created<br>Lessons</span>
                    <div class="tab-link"
                        style='background-color: {{ session('capBack') ? session('capBack') : '#946e97' }}'>
                        {{ $translation->l('Consulter') }} <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </div>
            <div class="tab-item"
                style='background-color: {{ session('paneBack') ? session('paneBack') : '#c3aaca' }}'>
                <div class="tab-content">
                    <div class="tab-avatar"
                        style='background-color: {{ session('iconBack') ? session('iconBack') : '#912891' }}'>
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <span class="tab-item-value counter">0</span>
                    <input type="hidden" class="store-value" value="{{ $finishedSessions }}">
                    <span class="tab-description">Finished <br>Sessions</span>
                    <div class="tab-link"
                        style='background-color: {{ session('capBack') ? session('capBack') : '#946e97' }}'>
                        {{ $translation->l('Consulter') }} <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </div>
            <div class="tab-item"
                style='background-color: {{ session('paneBack') ? session('paneBack') : '#c3aaca' }}'>
                <div class="tab-content">
                    <div class="tab-avatar"
                        style='background-color: {{ session('iconBack') ? session('iconBack') : '#912891' }}'>
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <span class="tab-item-value counter">0</span>
                    <input type="hidden" class="store-value" value="{{ $generatedReports }}">
                    <span class="tab-description">Generated <br>Reports</span>
                    <div class="tab-link"
                        style='background-color: {{ session('capBack') ? session('capBack') : '#946e97' }}'>
                        {{ $translation->l('Consulter') }} <i class="fa fa-arrow-circle-right"></i></div>
                </div>
            </div>
        </div>

        <table class="session-table"
            data-report-permission="{{ isset(session('permission')->admindash->report->display) }}"
            data-report-disconnect="{{ isset(session('permission')->admindash->report->disconnect) }}"
            data-training-permission="{{ isset(session('permission')->admindash->training->display) }}"
            data-training-disconnect="{{ isset(session('permission')->admindash->training->disconnect) }}"
            data-participant-permission="{{ isset(session('permission')->admindash->participant->display) }}"
            data-participant-disconnect="{{ isset(session('permission')->admindash->participant->disconnect) }}"
            data-participant-edit="{{ isset(session('permission')->admindash->participant->edit) }}"
            data-report-download="{{ isset(session('permission')->admindash->report->download) }}">
            <tr>
                <th>
                    <div>
                        {{ $translation->l('Mes dernières SESSIONS') }}
                        {{-- <i class="fa fal fa-sliders-h p-1"></i> --}}
                    </div>
                </th>
                <th>
                    <div>
                        {{ $translation->l('Language') }}
                    </div>
                </th>
                <th>
                    <div>
                        {{ $translation->l('Status') }}
                    </div>
                </th>
                <th>
                    <div>
                        {{ $translation->l('Date de debut') }}
                    </div>
                </th>
                <th>
                    <div>
                        {{ $translation->l('Date de fin') }}
                    </div>
                </th>
            </tr>
            @foreach ($sessions as $session)
                <tr class="session-title" id="session_{{ $session['id'] }}">
                    <td>
                        <div class="p-2">
                            {{ $session['name'] }}
                        </div>
                    </td>
                    <td>
                        <div class="p-2">
                            {{ strtoupper($session['language_iso']) }}
                        </div>
                    </td>
                    <td>
                        <div class="p-2">
                            {{ $session['status'] }}
                        </div>
                    </td>
                    <td>
                        <div class="p-2">
                            @if (session('language') == 'fr')
                                {{ $session['begin_date'] ? date('d-m-Y', strtotime($session['begin_date'])) : 'Not Defined' }}
                            @else
                                {{ $session['begin_date'] ? $session['begin_date'] : 'Not Defined' }}
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="p-2">
                            @if (session('language') == 'fr')
                                {{ $session['end_date'] ? date('d-m-Y', strtotime($session['end_date'])) : 'Not Defined' }}
                            @else
                                {{ $session['end_date'] ? $session['end_date'] : 'Not Defined' }}
                            @endif
                        </div>
                    </td>
                </tr>
                <tr class="session-content session-{{ $session['id'] }}">
                    <td colspan="5">
                        <div class="container w-100 p-0 mx-0 bg-transparent" style="max-width:100%;">
                            <div class=" row py-0">
                                <div class="col-md-9 py-0">
                                    <div class="toolkit clear-fix text-white p-0" style="height:50px;">
                                        <div class="float-right p-2 m-0">
                                            <span class="bg-white text-black p-2 rounded">
                                                <input class="input-field border-0 mw-100 search-filter" type="text"
                                                    name="search-filter">
                                                <i class="fa fa-search icon p-2"></i>
                                            </span>
                                            <a href="javascript:void(0)" class="toolkit-show-filter float-right">
                                                <i class="fas fa-sliders-h icon p-2  text-white"></i>
                                            </a>
                                        </div>
                                        <ul class="nav nav-tabs border-0 mb-2">

                                            @if (isset(session('permission')->admindash->participant->display))
                                                <li class="nav-item">
                                                    <a class="nav-link active m-1 rounded-1 border-0 table-participant-tab"
                                                        id="table-participant-tab_{{ $session['id'] }}"
                                                        href="#table-participant_{{ $session['id'] }}">Participants</a>
                                                </li>
                                            @endif
                                            @if (isset(session('permission')->admindash->training->display))
                                                <li class="nav-item">
                                                    <a class="nav-link m-1 rounded-1 border-0 table-training-tab"
                                                        id="table-training-tab_{{ $session['id'] }}"
                                                        href="#table-training_{{ $session['id'] }}">
                                                        Trainings</a>
                                                </li>
                                            @endif
                                            @if (isset(session('permission')->admindash->report->display))
                                                <li class="nav-item">
                                                    <a class="nav-link m-1 rounded-1 border-0 table-report-tab"
                                                        id="table-report-tab_{{ $session['id'] }}"
                                                        href="#table-report_{{ $session['id'] }}">
                                                        Reports</a>
                                                </li>
                                            @endif
                                        </ul>

                                    </div>
                                    <!-- Tab panes -->
                                    <div class="div-tab">
                                        @if (isset(session('permission')->admindash->participant->display))

                                            <div id="table-participant_{{ $session['id'] }}" class="table-participant">
                                                <div class="list-group" id="list-tab" role="tablist" data-src=''>

                                                </div>
                                            </div>
                                        @endif


                                        @if (isset(session('permission')->admindash->training->display))
                                            <div id="table-training_{{ $session['id'] }}" class="table-training">
                                                <div class="list-group" id="list-tab" role="tablist" data-src=''>

                                                </div>
                                            </div>
                                        @endif


                                        @if (isset(session('permission')->admindash->report->display))
                                            <div id="table-report_{{ $session['id'] }}" class="table-report">
                                                <table class="table table-striped table-vcenter reportTbl"
                                                    id="historic-table_{{ $session['id'] }}" style="width:100%;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 25%;">{{ $translation->l('Session') }}</th>
                                                            <th style="width: 25%;">{{ $translation->l('Student') }}</th>
                                                            <th style="width: 25%;">{{ $translation->l('FileName') }}
                                                            </th>
                                                            <th style="width: 25%;" class="text-center">
                                                                {{ $translation->l('Actions') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- <tr>
                                                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                                                    <td class="font-w600">Name of File</td>
                                                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                                                    <td class="font-w600">Details</td>
                                                    <td class="font-w600">Date</td>
                                                    <td style="background-color: #7e3e98; cursor: pointer;">
                                                        <i class="far fa-trash-alt"></i>
                                                    </td>
                                                </tr> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-md-3">

                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach

        </table>
        <script>
            $('#tableau').addClass('active');
            $('#tableau .nav-main-link-icon').css('color', '<?php echo session('iconOverColor'); ?>');
        </script>
        <button type="button" id="notificator" class="js-notify btn btn-secondary push" data-message="Your message!<br>"
            style="display:none">
            Top Right
        </button>
    </div>

@endsection

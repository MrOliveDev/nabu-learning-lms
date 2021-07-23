<!-- <i class="fas fa-graduation-cap"></i> -->
@extends('layout')

@section('con')


<style>
    :root {
        --student-c:
            <?php
            echo '#'. $interfaceCfg->Students->h;
        ?>
        ;
        --student-h:
            <?php
            echo '#'. $interfaceCfg->Students->c;
        ?>
        ;
        --teacher-c:
            <?php
            echo '#'. $interfaceCfg->Teachers->h;
        ?>
        ;
        --teacher-h:
            <?php
            echo '#'. $interfaceCfg->Teachers->c;
        ?>
        ;
        --author-c:
            <?php
            echo '#'. $interfaceCfg->Authors->h;
        ?>
        ;
        --author-h:
            <?php
            echo '#'. $interfaceCfg->Authors->c;
        ?>
        ;
        --group-c:
            <?php
            echo '#'. $interfaceCfg->Groups->h;
        ?>
        ;
        --group-h:
            <?php
            echo '#'. $interfaceCfg->Groups->c;
        ?>
        ;
        --company-c:
            <?php
            echo '#'. $interfaceCfg->Companies->h;
        ?>
        ;
        --company-h:
            <?php
            echo '#'. $interfaceCfg->Companies->c;
        ?>
        ;
        --position-c:
            <?php
            echo '#'. $interfaceCfg->Positions->h;
        ?>
        ;
        --position-h:
            <?php
            echo '#'. $interfaceCfg->Positions->c;
        ?>
        ;
        --session-c:
            <?php
            echo '#'. $interfaceCfg->Sessions->h;
        ?>
        ;
        --session-h:
            <?php
            echo '#'. $interfaceCfg->Sessions->c;
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

        --report-c:"";
        --report-h:"";
    }

</style>

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{asset("assets/css/admindashPage.css")}}">
<script src="{{asset("assets/js/admindashPage.js")}}"></script>
{{-- <script src="{{asset("assets/")}}"></script>
<script src="{{asset("assets/")}}"></script> --}}
<script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>

<script>
    jQuery(function() {
        Dashmix.helpers(['notify', 'summernote']);
    });
</script>
<div id="admindash">

    <div class="tab-row">
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fa fa-users"></i>
                </div>
                <span class="tab-item-value counter">0</span>
                <input type="hidden" class="store-value" value="{{$registeredUsers}}">
                <span class="tab-description">Registered<br>Users</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>

        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fas fa-user-friends"></i>
                </div>
                <span class="tab-item-value counter">0</span>
                <input type="hidden" class="store-value" value="{{$activedStudents}}">
                <span class="tab-description">Actived <br>Students</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <span class="tab-item-value counter">0</span>
                <input type="hidden" class="store-value" value="{{$sessionsInProgress}}">
                <span class="tab-description">Sessions <br>in Progress</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span class="tab-item-value counter">0</span>
                <input type="hidden" class="store-value" value="{{$createdLessons}}">
                <span class="tab-description">Created<br>Lessons</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fas fa-file-pdf"></i>
                </div>
                <span class="tab-item-value counter">0</span>
                <input type="hidden" class="store-value" value="{{$finishedSessions}}">
                <span class="tab-description">Finished <br>Sessions</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fas fa-network-wired"></i>
                </div>
                <span class="tab-item-value counter">0</span>
                <input type="hidden" class="store-value" value="{{$generatedReports}}">
                <span class="tab-description">Generated <br>Reports</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
    </div>

    <table class="session-table">
        <tr>
            <th>
                <div>
                    {{$translation->l('Mes dernières SESSIONS')}}
                    <i class="fa fal fa-sliders-h"></i>
                </div>
            </th>
            <th>
                <div>
                    {{$translation->l('Language')}}
                </div>
            </th>
            <th>
                <div>
                    {{$translation->l('Status')}}
                </div>
            </th>
            <th>
                <div>
                    {{$translation->l('Date de debut')}}
                </div>
            </th>
            <th>
                <div>
                    {{$translation->l('Date de fin')}}
                </div>
            </th>
        </tr>
        @foreach ($sessions as $session)
        <tr class="session-title" id="session_{{$session['id']}}">
            <td>
                <div class="p-2">
                    {{$session['name']}}
                </div>
            </td>
            <td>
                <div class="p-2">
                    {{strtoupper($session['language_iso'])}}
                </div>
            </td>
            <td>
                <div class="p-2">
                    {{$session['status']}}
                </div>
            </td>
            <td>
                <div class="p-2">
                    {{$session['begin_date']?$session['begin_date']:"Not Defined"}}
                </div>
            </td>
            <td>
                <div class="p-2">
                    {{$session['end_date']?$session['end_date']:"Not Defined"}}
                </div>
            </td>
        </tr>
        <tr class = "session-content session-{{$session['id']}}">
            <td colspan="5" >
                <div class="container w-100 p-0 mx-0 bg-transparent" style="max-width:100%;">
                    <div class=" row py-0">
                        <div class="col-md-9 py-0">
                            <div class="toolkit clear-fix text-white p-0" style="height:50px;">
                                <div class="float-right p-2 m-0">
                                    <span class="bg-white text-black p-2 rounded">
                                        <input class="input-field border-0 mw-100 search-filter" type="text" name="search-filter">
                                        <i class="fa fa-search icon p-2"></i>
                                    </span>
                                    <a href="javascript:void(0)" class="toolkit-show-filter float-right">
                                        <i class="fas fa-sliders-h icon p-2  text-white"></i>
                                    </a>
                                </div>
                                <ul class="nav nav-tabs border-0 mb-2">
                                    <li class="nav-item">
                                        <a class="nav-link active m-1 rounded-1 border-0 table-participant-tab" id="table-participant-tab_{{$session['id']}}"
                                            href="#table-participant_{{$session['id']}}">Participants</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link m-1 rounded-1 border-0 table-training-tab" id="table-training-tab_{{$session['id']}}" href="#table-training_{{$session['id']}}">
                                            Trainings</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link m-1 rounded-1 border-0 table-report-tab" id="table-report-tab_{{$session['id']}}" href="#table-reports_{{$session['id']}}">
                                            Reports</a>
                                    </li>
                                </ul>


                            </div>
                            <!-- Tab panes -->
                            <div id="table-participant_{{$session['id']}}" class="table-participant">
                                <div class="list-group" id="list-tab" role="tablist" data-src=''>
        
                                </div>
                            </div>
                            <div id="table-training_{{$session['id']}}" class="table-training">
                                <div class="list-group" id="list-tab" role="tablist" data-src=''>
        
                                </div>
                            </div>
                            <div id="table-report_{{$session['id']}}" class="table-report">
                                <div class="list-group" id="list-tab" role="tablist" data-src=''>
        
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            {{-- <div class="card w-100 text-left bg-white">
                                <img src="{{asset('assets/media/17.jpg')}}" alt="" class="card-img-top">
                                <div class="card-body border-0">
                                    <span>
                                        <strong>{{$translation->l('Objectifs')}}</strong>
                                        <p>
                                            {{$translation->l('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eleifend
                                            magna dignissim nunc maximus
                                            maximus. Nunc eget laoreet purus.
                                            Proin interdum, felis non malesuada
                                            vehicula, est ante ornare tortor, blandit')}}
                                        </p>

                                    </span>
                                    <span>
                                        <b>
                                            {{$translation->l('Durée')}} :
                                        </b>25 minutes
                                    </span>
                                </div>
                            </div>
                            <div class="card w-100 text-left bg-white" id="menu1">
                                <div class="card-body border-0">
                                    <div class="border-0">
                                        <img src="{{asset('assets/media/user.jpg')}}" alt="" class="rounded-circle w-100">
                                        <i class="fa fa-alpha align-text-bottom"></i>
                                    </div>
                                    <div class="p-4 border-0">
                                    <span>
                                        <b>{{$translation->l('Sandrine Mourand')}}
                                        </b>
                                        s.mourand@gmail.com
                                    </span>
                                    <br>
                                    <span class=""><b>{{$translation->l('Société')}} : </b>{{$translation->l('INNOTHERA')}}</span><br>
                                    <span><b>{{$translation->l('Status')}} : </b>{{$translation->l('actif')}}</span>
                                    <div class="border-0 ">
                                        <p class="text-wrap mb-3"><i class="fas fa-file-pdf font-size-h1 text-pink-2 pr-2"></i>
                                        {{$translation->l('Attestation de formation')}}
                                        </p>

                                        <p class="text-wrap mb-3"><i class="far fa-file-pdf font-size-h1 text-second pr-2"></i>
                                        {{$translation->l('Rapport complet de formation')}}</p>
                                    </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
        {{-- <tr>
            <td>
                <div>
                    {{$translation->l('Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique')}}
                </div>
            </td>
            <td>
                <div>
                    {{$translation->l('Français - FR')}}
                </div>
            </td>
            <td>
                <div>
                    {{$translation->l('En cours')}}
                </div>
            </td>
            <td>
                <div>
                    23/04/2021
                </div>
            </td>
            <td>
                <div>
                    23/04/2021
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    {{$translation->l('Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique')}}
                </div>
            </td>
            <td>
                <div>
                    {{$translation->l('Français - FR')}}
                </div>
            </td>
            <td>
                <div>
                    {{$translation->l('En cours')}}
                </div>
            </td>
            <td>
                <div>
                    23/04/2021
                </div>
            </td>
            <td>
                <div>
                    23/04/2021
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    {{$translation->l('Les Bonnes Pratiques de Fabrication Dans l’Industrie Pharmaceutique')}}
                </div>
            </td>
            <td>
                <div>
                    {{$translation->l('Français - FR')}}
                </div>
            </td>
            <td>
                <div>
                    {{$translation->l('En cours')}}
                </div>
            </td>
            <td>
                <div>
                    23/04/2021
                </div>
            </td>
            <td>
                <div>
                    23/04/2021
                </div>
            </td>
        </tr> --}}

    </table>
<script>
    $('#tableau').addClass('active');
</script>
<button type="button" id="notificator" class="js-notify btn btn-secondary push" data-message="Your message!<br>"
    style="display:none">
    Top Right
</button>
</div>
@endsection

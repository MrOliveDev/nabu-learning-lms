<!-- <i class="fas fa-graduation-cap"></i> -->
@extends('welcome')

@section('con')
<div id="admindash">

    <div class="tab-row">
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fa fa-users"></i>
                </div>
                <span class="tab-item-value">16.023</span>
                <span class="tab-description">{{$translation->l('Utilisateurs')}} <br>{{$translation->l('enregistrés')}}</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>

        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fa fa-users"></i>
                </div>
                <span class="tab-item-value">16.023</span>
                <span class="tab-description">{{$translation->l('Utilisateurs')}} <br>{{$translation->l('enregistrés')}}</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fa fa-users"></i>
                </div>
                <span class="tab-item-value">16.023</span>
                <span class="tab-description">{{$translation->l('Utilisateurs')}} <br>{{$translation->l('enregistrés')}}</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fa fa-users"></i>
                </div>
                <span class="tab-item-value">16.023</span>
                <span class="tab-description">{{$translation->l('Utilisateurs')}} <br>{{$translation->l('enregistrés')}}</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fa fa-users"></i>
                </div>
                <span class="tab-item-value">16.023</span>
                <span class="tab-description">{{$translation->l('Utilisateurs')}} <br>{{$translation->l('enregistrés')}}</span>
                <div class="tab-link">{{$translation->l('Consulter')}} <i class="fa fa-arrow-circle-right"></i></div>
            </div>
        </div>
        <div class="tab-item">
            <div class="tab-content">
                <div class="tab-avatar">
                    <i class="fa fa-users"></i>
                </div>
                <span class="tab-item-value">16.023</span>
                <span class="tab-description">{{$translation->l('Utilisateurs')}} <br>{{$translation->l('enregistrés')}}</span>
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
            <td colspan="5">
                <div class="container w-100 p-0 mx-0 bg-transparent" style="max-width:100%;">
                    <div class=" row py-0">
                        <div class="col-md-9 py-0">
                            <div class="toolkit clear-fix text-white p-0" style="height:50px;">

                                <ul class="nav nav-tabs border-0" style="float:left;">
                                    <li class="nav-item">
                                        <a class="nav-link m-1 bg-red-0 active border-0" href="#home">{{$translation->l('Participants à la session')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  m-1 bg-red-1 active border-0" href="#menu1">{{$translation->l('Parcours')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  m-1 bg-red-2 active border-0" href="#menu2">{{$translation->l('Rapports et certificats')}}</a>
                                    </li>
                                </ul>

                                <div class="float-right p-0 m-0">
                                    <div class="input-container font-size-h5">
                                        <i class="fa fa-plus icon p-2"></i>
                                        <span class="bg-white text-black p-2 rounded">
                                            <input class="input-field border-0" type="text" name="usrnm">
                                            <i class="fa fa-search icon p-2"></i>
                                        </span>
                                        <i class="fa fa-bars icon p-2"></i>
                                    </div>
                                </div>
                            </div>



                            <!-- Tab panes -->
                            <div class="tab-content border mb-3 border-0">
                                <div id="home" class="container tab-pane active m-0 p-0 mw-100">
                                    <div class="panel-group border-0 p-0" id="accordion">
                                        <div class="panel panel-default border-0 p-0">

                                            <div class="panel-heading bg-red-0 text-left rounded-1">

                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="text-white" aria-expanded="true">
                                                    <h4 class="panel-title mb-0 p-2">{{$translation->l('Rapports et certificats')}} <i class="fa fa-tint-slash float-right text-yellow-0"></i></h4>
                                                </a>
                                            </div>
                                            <div id="collapse1" class="panel-collapse in collapse show border-0 p-0 show" >
                                                <div class="panel-body ml-5 p-0">
                                                    <div class="list-group p-0" id="list-tab" role="tablist">
                                                        <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                            <div class="float-left border-0">
                                                                <i class="fa fa-circle text-danger m-2"></i>
                                                                {{$translation->l('Module1')}}
                                                            </div>
                                                        </a>
                                                        <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                            <div class="float-left border-0">
                                                                <i class="fa fa-circle text-danger m-2"></i>
                                                                {{$translation->l('Module1')}}
                                                            </div>
                                                        </a>
                                                        <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                            <div class="float-left border-0">
                                                                <i class="fa fa-circle text-danger m-2"></i>
                                                                {{$translation->l('Module1')}}
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div id="home1" class="container tab-pane active m-0 p-0 mw-100"><br>
                                    <div class="panel-group border-0 p-0" id="accordion1">
                                        <div class="panel panel-default border-0 p-0">
                                            <div class="list-group p-0" id="list-tab1" role="tablist">
                                                <a class="list-group-item list-group-item-action active p-1 border-0 bg-green-0 text-black">
                                                    <div class="float-left border-0">
                                                        <i class="fa fa-circle text-danger m-2"></i>
                                                        {{$translation->l('Module1')}}
                                                    </div>
                                                </a>
                                                <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                    <div class="float-left border-0">
                                                        <i class="fa fa-circle text-danger m-2"></i>
                                                        {{$translation->l('Module1')}}
                                                    </div>
                                                </a>
                                                <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                    <div class="float-left border-0">
                                                        <i class="fa fa-circle text-danger m-2"></i>
                                                        {{$translation->l('Module1')}}
                                                    </div>
                                                </a>
                                                <div class="panel-heading bg-red-0 text-left rounded-1">

                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="text-white" aria-expanded="true">
                                                        <h4 class="panel-title mb-0 p-2">{{$translation->l('Rapports et certificats')}} <i class="fa fa-tint-slash float-right text-yellow-0"></i></h4>
                                                    </a>
                                                </div>
                                                <div id="collapse1" class="panel-collapse in collapse show border-0 p-0 show">
                                                    <div class="panel-body ml-5 p-0">
                                                        <div class="list-group p-0" id="list-tab" role="tablist">
                                                            <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                                <div class="float-left border-0">
                                                                    <i class="fa fa-circle text-danger m-2"></i>
                                                                    {{$translation->l('Module1')}}
                                                                </div>
                                                            </a>
                                                            <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                                <div class="float-left border-0">
                                                                    <i class="fa fa-circle text-danger m-2"></i>
                                                                    {{$translation->l('Module1')}}
                                                                </div>
                                                            </a>
                                                            <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                                <div class="float-left border-0">
                                                                    <i class="fa fa-circle text-danger m-2"></i>
                                                                    {{$translation->l('Module1')}}
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="list-group-item list-group-item-action active p-1 border-0 bg-success text-white">
                                                    <div class="float-left border-0">
                                                        <i class="fa fa-circle text-danger m-2"></i>
                                                        {{$translation->l('Module1')}}
                                                    </div>
                                                </a>
                                                <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                    <div class="float-left border-0">
                                                        <i class="fa fa-circle text-danger m-2"></i>
                                                        {{$translation->l('Module1')}}
                                                    </div>
                                                </a>
                                                <a class="list-group-item list-group-item-action active p-1 border-0  bg-green-0 text-black">
                                                    <div class="float-left border-0">
                                                        <i class="fa fa-circle text-danger m-2"></i>
                                                        {{$translation->l('Module1')}}
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu2" class="container tab-pane fade"><br>
                                    <h3>{{$translation->l('Menu 2')}}</h3>
                                    <p>{{$translation->l('Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card w-100 text-left bg-white">
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
                            </div>
                        </div>
                    </div>
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

    </table>
<script>
    $('#tableau').addClass('active');
</script>
</div>
@endsection

@extends('layout')

@section('con')
    <link rel="stylesheet" href="{{ asset('assets/css/commondashPage.css') }}">
@section('js_after')
    <script src="{{ asset('assets/js/commondashPage.js') }}"></script>
@endsection
<div id="content">
    <div class="row">
        <fieldset class='col-sm-12 col-md-3 col-lg-3 h-100'>
            @foreach ($trainings as $training)
                <div class="collespe-card card mb-3 rounded mx-4">
                    <div class="collespe-header bg-blue-4 d-flex">
                        <div class="w-100 text-white">
                            <i class="fa fa-bars float-right">

                            </i>
                            <h3 class='h3 mb-0 text-white'>{{ $training->name }}</h3>
                        </div>

                    </div>
                    <div class="row items-push">
                        <div class="col-md-12 animated fadeIn">
                            <div class="options-container fx-item-zoom-in fx-overlay-slide-right">
                                <img class="img-fluid options-item" src="assets/media/photos/photo16.jpg" alt="">
                                <div class="options-overlay bg-black-75">
                                    <div class="options-overlay-content">

                                        <p class="h6 text-white-75 mb-3">{{ $training->description }}</p>
                                        <a class="btn btn-sm btn-primary" href="javascript:void(0)">
                                            <i class="fa fa-pencil-alt mr-1"></i> Edit
                                        </a>
                                        {{-- <a class="btn btn-sm btn-danger" href="javascript:void(0)">
                                            <i class="fa fa-times mr-1"></i> Delete
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="collespe-bottom">
                        <div class="collespe-bottom-right">
                            <i class="fa fa-chart-line">

                            </i>
                            <span class="text-mute">
                                75%
                            </span>
                        </div>
                        <div class="collespe-bottom-left">
                            <i class="fa fa-check-circle text-success">

                            </i>
                            <span>
                                85%
                            </span>
                        </div>
                        <div class="collespe-description">
                            {{ $translation->l('Ouvert jusqu’au') }} 26 mars 2021
                        </div>
                    </div>
                </div>
            @endforeach
        </fieldset>
        <fieldset class='col-sm-12 col-md-9 col-lg-9'>
            <div id="div_C" class="window top">


                <div class="ml-3 list-group" id="list-tab" role="tablist" data-src=''>
                    @foreach ($lessons as $lesson)
                        <a class="row d-flex list-group-item list-group-item-action p-0 border-transparent border-0 bg-transparent font-size-h3 teacher_{{ $lesson['id'] }}"
                            id="teacher_{{ $lesson['id'] }}" data-date="{{ $lesson['creation_date'] }}">
                            <div class="round-corner-10 col-md-3 text-white m-0">
                                <span>
                                    <i class="fa fa-chart-line">
                                    </i>
                                    <span>
                                        75%
                                    </span>
                                </span>
                                <span>
                                    <i class="fa fa-check-circle">

                                    </i>
                                    <span>
                                        75%
                                    </span>
                                </span>
                            </div>
                            <div class="round-corner-10  col-md-9 border-transparent border-left-1">
                                <div class="float-left">
                                    <span class="item-name">{{ $lesson['name'] }}</span>
                                </div>
                                <div class="btn-group float-right ">
                                    <button class="btn  item-show" data-content='teacher'>
                                        <i class="fas fa-exclamation-circle text-white font-size-h3 m-0 p-2"></i>
                                    </button>
                                    <button class="btn  item-show" data-content='teacher'>
                                        <i class="fa fa-play text-white font-size-h3 m-0 p-2"></i>
                                    </button>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
            <div id="div_right" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div id="div_D" class="window bottom">

                {{-- <div class="dash-description mx-4">
                        <div class="dash-panel">
                            <span class="dash-panel-title">{{ $translation->l('Objectifs') }} :</span>
                            <div class="dash-panel-content">
                                {{ $translation->l('
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eleifend
                        magna dignissim nunc maximus maximus. Nunc eget laoreet purus. Proin
                        interdum, felis non malesuada vehicula, est ante ornare tortor, blandit
                        sodales enim diam eu leo. Nam malesuada in tortor quis pharetra. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia
                        curae; Curabitur ultricies odio velit, vitae rutrum ipsum viverra in. Suspendisse mollis et dolor gravida ultrices. Aenean iaculis, orci ultrices posuere
                        sagittis, nisi felis fermentum quam, viverra euismod eros velit non ligula.
                        Etiam sit amet tempor massa.
                        ') }}
                            </div>
                            <div class="dash-panel-footer"><span
                                    class="dash-panel-bottom-title">{{ $translation->l('Durée') }} :</span>25 minutes
                            </div>
                        </div>
                        <div class="dash-item-list">
                            <div class="dash-item">
                                <div><img src="{{ asset('assets/media/13.jpg') }}" alt="" class="dash-avatar"></div>
                                <div class="dash-avatar-title text-mute">
                                    {{ $translation->l('Télécharger mon
                            attestation de
                            formation') }}
                                </div>
                            </div>
                            <div class="dash-item">
                                <img src="{{ asset('assets/media/14.jpg') }}" alt="" class="dash-avatar">
                                <div class="dash-avatar-title text-mute">
                                    {{ $translation->l('Télécharger mon
                            attestation de
                            formation') }}
                                </div>
                            </div>
                        </div>

                    </div> --}}

            </div>
        </fieldset>
    </div>
</div>
@endsection

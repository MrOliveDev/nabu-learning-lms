@extends('layout')

@section('con')
    <link rel="stylesheet" href="{{ asset('assets/css/commondashPage.css') }}">
@section('js_after')
    <script src="{{ asset('assets/js/commondashPage.js') }}"></script>
@endsection
<div id="content">
    <div class="row ml-3">
        <fieldset class='col-sm-12 col-md-3 col-lg-3 h-100'>
            <div id="div_A" class="window top">
                @foreach ($trainings as $training)
                    <div class="card mb-4" id="training_{{ $training->id }}">
                        <div class="card-header d-flex">
                            <div class="w-100 text-white">
                                <a class="training-collapse" href="javascript:void(0)">
                                    <i class="mb-0 text-white fa fa-bars float-right">
                                    </i>
                                </a>
                                <h3 class='mb-0 text-white'>{{ $training->name }}</h3>
                            </div>
                        </div>
                        <div class="items-push card-img-top">
                            <div class="animated fadeIn ">
                                <div class="options-container fx-item-zoom-in fx-overlay-slide-right">
                                    <img class="img-fluid options-item w-100"
                                        src="{{ $training->training_icon ? $training->training_icon : asset('assets/media/18.jpg') }}"
                                        alt="">
                                    <div class="options-overlay bg-black-75">
                                        <div class="options-overlay-content">

                                            <p class="h6 text-white-75 mb-3">{{ $training->description }}</p>
                                            <a class="btn btn-sm btn-primary training-show" href="javascript:void(0)">
                                                <i class="fa fa-eye mr-1"></i> show
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-0 text-center text-black">
                                <div class="col-6">
                                    <i class="fa fa-chart-line">

                                    </i>
                                    <span class="text-mute">
                                        75%
                                    </span>
                                </div>
                                <div class="col-6">
                                    <i class="fa fa-check-circle text-success">

                                    </i>
                                    <span>
                                        85%
                                    </span>
                                </div>
                            </div>
                            <p class="h4 mb-0 mt-2 text-center ">
                                Terminated on {{ date_format(date_create($training->date_end), 'd F Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </fieldset>
        <fieldset class='col-sm-12 col-md-9 col-lg-9'>
            <div id="div_C" class="window top">
                <div class="push">
                    @foreach ($lessons as $lesson)
                        <div class="accordion" role="tablist" aria-multiselectable="true">

                            <div class="block block-rounded mb-1 bg-transparent shadow-none">
                                <div class="block-header block-header-default border-transparent border-0 bg-transparent p-0"
                                    role="tab" id="accordion_h1">
                                    <div class=" col-md-3 text-white align-self-stretch d-flex text-center  flex-md-row"
                                        style="border-right:2px solid #9a6cb0;">
                                        <span class="col-md-6 py-2">
                                            <i class="fa fa-chart-line">
                                            </i>
                                            <span>
                                                75%
                                            </span>
                                        </span>
                                        <span class="col-md-6 py-2">
                                            <i class="fa fa-check-circle">

                                            </i>
                                            <span>
                                                75%
                                            </span>
                                        </span>
                                    </div>
                                    <div
                                        class="  col-md-9 border-transparent border-left-1 align-self-stretch d-flex flex-row justify-content-between">
                                        <div class="float-left py-2">
                                            <span class="item-name">{{ $lesson['name'] }}</span>
                                        </div>
                                        <div class="btn-group float-right d-flex">
                                            <button class="btn  item-show" data-content='teacher'>
                                                <a class="font-w600 collapsed" data-toggle="collapse"
                                                    data-parent="#accordion" href="#lesson_{{ $lesson['id'] }}"
                                                    aria-expanded="false" aria-controls="accordion_q1">
                                                    <i class="fas fa-exclamation-circle m-0 p-2"></i>
                                                </a>
                                            </button>
                                            <button class="btn  item-play" data-content='teacher'
                                                data-fabrica="{{ $lesson['idFabrica'] }}">
                                                <i class="fa fa-play m-0 p-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    {{-- <a class="font-w600" data-toggle="collapse" data-parent="#accordion" href="#accordion_q1" aria-expanded="true" aria-controls="accordion_q1">1.1 Accordion Title</a> --}}
                                </div>
                                <div id="lesson_{{ $lesson['id'] }}" class="collapse" role="tabpanel"
                                    aria-labelledby="accordion_h1" data-parent="#accordion">
                                    <div class="block-content bg-white mt-2  pb-3">
                                        <p>{{ $lesson['description'] }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
            {{-- <div id="div_right" class="handler_horizontal  text-center text-white mb-4">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div id="div_D" class="window bottom"> --}}

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

            {{-- </div> --}}
        </fieldset>
    </div>
</div>
@endsection

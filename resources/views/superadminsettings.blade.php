@extends('layout')


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

    #reports .list-group-item {
        background-color: transparent !important;
    }


</style>
@endsection

@section('js_after')
<script src="{{asset('assets/js/plugins/summernote/summernote-bs4.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{asset('assets/js/superadminpage.js')}}"></script>
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
        if(window.location.href.indexOf("?page=")!=-1 || window.location.href.indexOf("?page=")!=-1) {
            $("#languages_tab").click();
        }
    });
</script>
<div id="tabs">
    <ul class="nav nav-tabs border-0 mb-2 px-4">
        <li class="nav-item">
            <a class="nav-link active mr-2 bg-red-1 rounded-1 border-0" href="#clients" id="clients_tab">CLIENTS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link mr-2 bg-red-0 rounded-1 border-0" href="#languages" id="languages_tab">LANGUAGES</a>
        </li>
    </ul>
    <div id="clients">
        @yield('client');
    </div>

    <div id="languages">

        <div class="content1">
            <fieldset id="LeftPanel1">
                <div class="mx-4 mb-3 text-white clear-fix toolkit d-flex justify-content-lg-start flex-column"
                id="cate-toolkit">
                    <div class="w-100">
                        <div class="input-container d-flex flex-row">
                            <a href="#" class="toolkit-add-item py-1">
                                <i class="p-2 text-white fa fa-plus icon"></i>
                            </a>
                            <span class="p-2 text-black bg-white rounded">
                                <input class="border-0 input-field mw-100 search-filter" type="text" name="search_str" id="search_str">
                            </span>
                        </div>
                    </div>
                </div>
                <div class="mx-4">
                    <div>
                        <div class="list-group m-0" id="translate-list-group" role="tablist">
                            @foreach ($translates as $translate)
                            <a class="list-group-item list-group-item-action p-1 border-0" id="translate_{{$translate->translation_id}}" data-toggle="list" href="#list-home" role="tab" aria-controls="home" 
                                data-value="{{ $translate->translation_value }}" 
                                data-lang-iso="{{ $translate->language_id }}" 
                                data-string="{{$translate->translation_string}}">
                                <div class="float-left" >
                                    {{$translate->translation_string}}
                                </div>
                                <div class="btn-group float-right">
                                    <span class="language_span text-white p-1">{{strtoupper($translate->lang_iso)}}</span>
                                    <button class="btn text-white px-2 item-edit" data-id="{{$translate->translation_id}}" href="#list-home">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn text-white px-2 item-delete" data-id="{{$translate->translation_id}}">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                </div>
                            </a>
                            @endforeach
                        </div>
                        {{-- <div class="d-flex justify-content-center">
                            {!! $translates->links() !!}
                        </div> --}}
                        <nav aria-label="Page navigation example" id="page-nav">
                        @if ($translates->hasPages())
                            <ul class="pagination pagination" id="page_nav" data-last="{{$translates->lastPage()}}">
                                {{-- Previous Page Link --}}
                                @if ($translates->onFirstPage())
                                    <li class="disabled page-item">
                                        <a href="" class="page-link">
                                            <span>«</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $translates->previousPageUrl() }}" rel="prev">«</a></li>
                                @endif

                                @if($translates->currentPage() > 3)
                                    <li class="page-item"><a class="page-link" href="{{ $translates->url(1) }}">1</a></li>
                                @endif
                                @if($translates->currentPage() > 4)
                                    <li class="page-item">
                                        <a href="" class="page-link">
                                            <span>...</span>
                                        </a>
                                    </li>
                                @endif
                                @foreach(range(1, $translates->lastPage()) as $i)
                                    @if($i >= $translates->currentPage() - 2 && $i <= $translates->currentPage() + 2)
                                        @if ($i == $translates->currentPage())
                                            <li class="active page-item">
                                                <a href="" class="page-link">
                                                    <span>{{ $i }}</span>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item"><a class="page-link" href="{{ $translates->url($i) }}">{{ $i }}</a></li>
                                        @endif
                                    @endif
                                @endforeach
                                @if($translates->currentPage() < $translates->lastPage() - 3)
                                    <li class="page-item">
                                        <a href="" class="page-link">
                                            <span>...</span>
                                        </a>
                                    </li>
                                @endif
                                @if($translates->currentPage() < $translates->lastPage() - 2)
                                    <li class="page-item"><a class="page-link" href="{{ $translates->url($translates->lastPage()) }}">{{ $translates->lastPage() }}</a></li>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($translates->hasMorePages())
                                    <li class="page-item"><a class="page-link" href="{{ $translates->nextPageUrl() }}" rel="next">»</a></li>
                                @else
                                    <li class="disabled page-item">
                                        <a href="" class="page-link">
                                            <span>»</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                        </nav>
                        {{-- <a class="text-white float-left" href="#" style="font-size:40px; line-height: 30px; font-weight: 900;">+</a> --}}
                    </div>
                </div>
            </fieldset>
            <div id="div_vertical1" class="handler_vertical width-controller">
                <i class="fas fa-grip-lines-vertical text-white"></i>
            </div>
            <fieldset id="RightPanel1">
                <div class="px-4">

                    <div class="card bg-secondary text-black  col-md-11">
                        <form action="" id="translateForm">
                            @csrf
                            <div class="card-body p-3">

                                {{-- <div class="form-group">
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
                                </div> --}}

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Current Language
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="currenLanguage" name="currenLanguage" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Interface Language
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="interfaceLanguage" name="interfaceLanguage" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                Language code
                                            </span>
                                        </div>
                                        <select class="form-control" name="selectLanguage" id="selectLanguage" required>
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->language_id }}">{{ $language->language_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-hero-primary float-right mx-1" id="translate_save_btn">SAVE</button>
                                    {{-- <button type="button" class="btn btn-hero-primary float-right mx-1" id="translate_cancel_btn">CANCEL</button> --}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </fieldset>
        </div>

    </div>
</div>
@endsection

@extends('layout')

@section('css_after')
<link rel="stylesheet" href="{{ asset('assets/css/report.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/trumbowyg/trumbowyg.min.css') }}">
@endsection

@section('con')
<div class="">
    
<fieldset id="ReportPanel">
    <ul class="nav nav-tabs border-0 mb-2 mx-4">
        <li class="nav-item">
            <a class="nav-link m-1 rounded-1 border-0" id="training-tab"
                href="#historique">{{ $translation->l('Historic') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link m-1 rounded-1 border-0" id="company-tab"
                href="#generer">{{ $translation->l('Generates') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link m-1 rounded-1 border-0" id="session-tab"
                href="#modeles">{{ $translation->l('Models') }}</a>
        </li>
    </ul>
    <div id="div_C" class="top">
        <div id="historique" class="ml-4">
            <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column mx-4"
            id="cate-toolkit">
                <div class="w-100 p-2">        
                    <div class="input-container ">
                        <a href="#" class="toolkit-show-filter">
                            <i class="fas fa-sliders-h icon p-2  text-white"></i>
                        </a>
                        <span class="bg-white text-black p-2 rounded">
                            <input class="input-field border-0 mw-100 search-filter" type="text" name="search-filter">
                            <i class="fa fa-search icon p-2"></i>
                        </span>
                    </div>
                </div>
                <!-- <div class="row filter p-2 toolkit-filter">
                    <div class="">
                        <div class="status-switch">
                            <input type="radio" id="filter-state-on" name="status" value="on">
                            <span>on&nbsp;</span>
                            <input type="radio" id="filter-state-off" name="status" value="off">
                            <span>off&nbsp;</span>
                            <input type="radio" id="filter-state-all" name="status" value="all">
                            <span>all&nbsp;</span>
                        </div>
                    </div>
                    <div class="ml-5">
                        <button value='' class="rounded text-white filter-name-btn px-1 border-0">Name
                            <i class="fas fa-sort-numeric-down"></i>
                        </button>
                        <button value='' class="rounded text-white filter-date-btn px-1 border-0">Date
                            <i class="fas fa-sort-numeric-down"></i>
                        </button>
                    </div>
                </div> -->
            </div>
            <table class="table table-bordered table-striped table-vcenter" id="historic-table" style="width:100%;">
            <thead>
                <tr>
                    <th style="width: 15%;">{{ $translation->l('Session') }}</th>
                    <th style="width: 15%;">{{ $translation->l('FileName') }}</th>
                    <th style="width: 10%;">{{ $translation->l('FileType') }}</th>
                    <th style="width: 40%;">{{ $translation->l('Details') }}</th>
                    <th style="width: 10%;">{{ $translation->l('Date') }}</th>
                    <th style="width: 10%; background-color: #7e3e98;"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-pdf"></i> .pdf</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-archive"></i> .zip</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-archive"></i> .zip</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-archive"></i> .zip</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-archive"></i> .zip</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
                <tr>
                    <td class="font-w600">Name of Session <i class="fa fa-download"></i></td>
                    <td class="font-w600">Name of File</td>
                    <td class="font-w600"><i class="fa fa-file-csv"></i> .csv</td>
                    <td class="font-w600">Details</td>
                    <td class="font-w600">Date</td>
                    <td style="background-color: #7e3e98; cursor: pointer;">
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
        <div id="generer" class="ml-4">
            <fieldset id="genererLeft">
                <div class="w-100 p-2 sliderStyle" style="height: 200px;">
                    <div class="input-container ">
                        <span style="color: white;">Choose the type of document </span>
                        <span class="bg-white text-black p-2 rounded">
                            <input class="input-field border-0 mw-100 type-filter" type="text" name="type-filter">
                            <i class="fa fa-search icon p-2"></i>
                        </span>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 1</span>
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 2</span>
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 3</span>
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 4</span>
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 5</span>
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 6</span>
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 7</span>
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 8</span>
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 9</span>
                        <i class="fa fa-edit"></i>
                    </div>
                    <div class="doc-type-item">
                        <span>Report 10</span>
                        <i class="fa fa-edit"></i>
                    </div>
                </div>

                <div id="horizSplit1" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
                    <i class="fas fa-grip-lines"></i>
                </div>

                <div class="w-100 p-2 sliderStyle" style="height: 250px;">
                    <div class="input-container mb-2">
                        <span style="color: white;">Choose the session </span>
                        <a href="#" class="toolkit-show-filter">
                            <i class="fas fa-sliders-h icon p-2  text-white"></i>
                        </a>
                        <span class="bg-white text-black p-2 rounded">
                            <input class="input-field border-0 mw-100 session-filter" type="text" name="session-filter">
                            <i class="fa fa-search icon p-2"></i>
                        </span>
                    </div>
                    <table class="table table-bordered table-striped table-vcenter" id="session-table" style="width:100%;">
                        <colgroup>
                            <col span="1" style="width: 75%;">
                            <col span="1" style="width: 25%;">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Name of session</td>
                                <td class="font-w600">12 April 2021</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="horizSplit2" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
                    <i class="fas fa-grip-lines"></i>
                </div>

                <div class="w-100 p-2 sliderStyle" style="height: 200px;">
                    <div class="input-container mb-2">
                        <span style="color: white;">List of learners </span>
                        <a href="#" class="toolkit-show-filter">
                            <i class="fas fa-sliders-h icon p-2  text-white"></i>
                        </a>
                        <span class="bg-white text-black p-2 rounded">
                            <input class="input-field border-0 mw-100 learner-filter" type="text" name="session-filter">
                            <i class="fa fa-search icon p-2"></i>
                        </span>
                    </div>
                    <table class="table table-bordered table-striped table-vcenter" id="session-table" style="width:100%;">
                        <colgroup>
                            <col span="1" style="width: 70%;">
                            <col span="1" style="width: 5%;">
                            <col span="1" style="width: 25%;">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td class="font-w600 learnerName">Hideo Fujimoto</td>
                                <td class="font-w600 text-center learnerAction"><i class="fa fa-download"></i></td>
                                <td class="font-w600 text-center learnerAction">Overview <i class="fa fa-eye"></i></td>
                            </tr>
                            <tr>
                                <td class="font-w600 learnerName">Yutaka</td>
                                <td class="font-w600 text-center learnerAction"><i class="fa fa-download"></i></td>
                                <td class="font-w600 text-center learnerAction">Overview <i class="fa fa-eye"></i></td>
                            </tr>
                            <tr>
                                <td class="font-w600 learnerName">Sebastien Acacia</td>
                                <td class="font-w600 text-center learnerAction"><i class="fa fa-download"></i></td>
                                <td class="font-w600 text-center learnerAction">Overview <i class="fa fa-eye"></i></td>
                            </tr>
                            <tr>
                                <td class="font-w600 learnerName">Nicolas Tournade</td>
                                <td class="font-w600 text-center learnerAction"><i class="fa fa-download"></i></td>
                                <td class="font-w600 text-center learnerAction">Overview <i class="fa fa-eye"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="horizSplit3" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
                    <i class="fas fa-grip-lines"></i>
                </div>

                <div class="w-100 p-2 text-center">
                    <button class="downloadBtn">
                        Download all PDFs <i class="fa fa-download"></i>
                    </button>
                </div>

            </fieldset>
            <div id="verticalSplit1" class="handler_vertical width-controller">
                <i class="fas fa-grip-lines-vertical text-white"></i>
            </div>
            <fieldset id="genererRight">
                <div class="w-100 p-2" style="min-height: 700px; border-radius: 5px; background-color: white;">
                </div>
            </fieldset>
        </div>
        
        <div id="modeles" class="ml-4">
            <fieldset id="modelLeft">
                <div class="w-100 p-2 sliderStyle" style="height: 200px;">
                    <div class="model-item">
                        <div>
                            <i class="fa fa-circle mr-3" style="color: green;"></i>
                            <span>Report 1</span>
                        </div>
                        <div>
                            <i class="fa fa-edit mr-3"></i>
                            <i class="fa fa-trash mr-3"></i>
                        </div>
                    </div>
                    <div class="model-item">
                        <div>
                            <i class="fa fa-circle mr-3" style="color: red;"></i>
                            <span>Certificate 1</span>
                        </div>
                        <div>
                            <i class="fa fa-edit mr-3"></i>
                            <i class="fa fa-trash mr-3"></i>
                        </div>
                    </div>
                    <div class="model-item">
                        <div>
                            <i class="fa fa-circle mr-3" style="color: green;"></i>
                            <span>Report Complete</span>
                        </div>
                        <div>
                            <i class="fa fa-edit mr-3"></i>
                            <i class="fa fa-trash mr-3"></i>
                        </div>
                    </div>
                    <i class="fa fa-plus addModelBtn ml-3 mt-3"></i>
                </div>

                <div id="horizSplit4" class="handler_horizontal  text-center  font-size-h3 mb-4" style="color: #362f81;">
                    <i class="fas fa-grip-lines"></i>
                </div>

                <div id="modelDragItems">
                    <ul class="nav nav-tabs border-0 mb-2 mx-4">
                        <li class="nav-item">
                            <a class="model-tab-item m-1 rounded-1 border-0" id="variables-tab"
                                href="#variables">{{ $translation->l('Variables') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="model-tab-item m-1 rounded-1 border-0" id="blocks-tab"
                                href="#blocks">{{ $translation->l('Content blocks') }}</a>
                        </li>
                    </ul>
                    <div class="ml-3">
                        <div id="variables">
                            <p class="model-drag-item mt-1">#last_name</p>
                            <p class="model-drag-item mt-1">#first_name</p>
                            <p class="model-drag-item mt-1">#student_company</p>
                            <p class="model-drag-item mt-1">#training_name</p>
                            <p class="model-drag-item mt-1">#total_time_spent_on_training</p>
                            <p class="model-drag-item mt-1">#session_begin_Date</p>
                            <p class="model-drag-item mt-1">#session_end_Date</p>
                            <p class="model-drag-item mt-1">#session_administrator_complete_name</p>
                            <p class="model-drag-item mt-1">#session_teacher_complete_name</p>
                            <p class="model-drag-item mt-1">#evaluation_pc_result</p>
                            <p class="model-drag-item mt-1">#evaluation_num_result</p>
                        </div>
                        <div id="blocks">
                            <p class="model-drag-item mt-1">#Content block1</p>
                            <p class="model-drag-item mt-1">#Content block2</p>
                            <p class="model-drag-item mt-1">#Content block3</p>
                            <p class="model-drag-item mt-1">#Content block4</p>
                        </div>
                    </div>  
                </div>

            </fieldset>

            <div id="verticalSplit2" class="handler_vertical width-controller" style="color: #362f81;">
                <i class="fas fa-grip-lines-vertical"></i>
            </div>

            <fieldset id="modelRight">
                <div class="mb-3">
                    <span class="text-white mr-3">Name * </span>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 model-name-input" type="text" style="width: 350px;">
                    </span>
                </div>
                <div class="w-100" style="height: 600px; background-color: white;" id="model-trumb-pane">
                </div>
                <div class="float-right mt-3">
                    <button class="modelActBtn mr-2"> CANCEL </button>
                    <button class="modelActBtn mr-2"> SAVE </button>
                </div>
            </fieldset>
        </div>

    </div>
    
</fieldset>

</div>

@section('js_after')
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/trumbowyg/trumbowyg.min.js') }}"></script>
@endsection

@include('report.script')
@endsection

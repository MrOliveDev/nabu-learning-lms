@extends('welcome')

@section('con')
<link rel="stylesheet" href="{{asset('assets/js/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/cropper.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/cropperModal.css')}}">
<link rel="stylesheet" href="{{asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css')}}">



<style>
    :root {
        --student-c: <?php echo "#" . $interfaceCfg->Students->h; ?>;
        --student-h: <?php echo "#" . $interfaceCfg->Students->c; ?>;
        --teacher-c: <?php echo "#" . $interfaceCfg->Teachers->h; ?>;
        --teacher-h: <?php echo "#" . $interfaceCfg->Teachers->c; ?>;
        --author-c: <?php echo "#" . $interfaceCfg->Authors->h; ?>;
        --author-h: <?php echo "#" . $interfaceCfg->Authors->c; ?>;
        --group-c: <?php echo "#" . $interfaceCfg->Groups->h; ?>;
        --group-h: <?php echo "#" . $interfaceCfg->Groups->c; ?>;
        --company-c: <?php echo "#" . $interfaceCfg->Companies->h; ?>;
        --company-h: <?php echo "#" . $interfaceCfg->Companies->c; ?>;
        --position-c: <?php echo "#" . $interfaceCfg->Positions->h; ?>;
        --position-h: <?php echo "#" . $interfaceCfg->Positions->c; ?>;
        --session-c: <?php echo "#" . $interfaceCfg->Sessions->h; ?>;
        --session-h: <?php echo "#" . $interfaceCfg->Sessions->c; ?>;
    }
</style>
<link rel="stylesheet" href="{{asset('assets/css/userPage.css')}}">


@section('js_after')
<script>
    $(function() {
        $("#LeftPanel, #RightPanel").tabs();
        $(".second-table").tabs();
    });
</script>
<script src="{{asset('assets/js/cropper.js')}}"></script>
<script src="{{asset('assets/js/plugins/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.js')}}"></script>
<script src="{{asset('assets/js/cropperModal.js')}}"></script>

<script src="{{asset('assets/js/plugins/select2/js/select2.full.min.js')}}"></script>

<script src="{{asset('assets/js/userPage.js')}}"></script>
<script>
    $('#utilisateurs').addClass('active');
    jQuery(function() {
        Dashmix.helpers(['select2', 'rangeslider']);
    });
</script>
@endsection

<div id="content">
    <fieldset id="LeftPanel">
        <ul class="nav nav-tabs border-0 mb-2 mx-4">
            <li class="nav-item">
                <a class="nav-link active m-1 rounded-1 border-0" id="students-tab" href="#students">{{$translation->l('STUDENTS')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1 rounded-1 border-0" id="teachers-tab" href="#teachers"> {{$translation->l('TEACHERS')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1 rounded-1 border-0" id="authors-tab" href="#authors">{{$translation->l('AUTHORS')}}</a>
            </li>
        </ul>
        <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column mx-4">
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
                        <i class="fa fa-bars icon p-2  text-white"></i>
                    </a>
                </div>
            </div>
            <div class="fliter p-2 toolkit-filter">
                <div class="float-left">
                    <input type="radio" id="filter-state-on" name="status" value="on">
                    <span>on&nbsp;</span>
                    <input type="radio" id="filter-state-off" name="status" value="off">
                    <span>off&nbsp;</span>
                    <input type="radio" id="filter-state-all" name="status" value="all">
                    <span>all&nbsp;</span>
                </div>
                <div class="float-right">
                    <button type="button" value="" class="rounded text-white fliter-company-btn px-1 border-0">company +</button>&nbsp;
                    <button type="button" value="" class="rounded text-white fliter-function-btn px-1 border-0">function +</button>
                </div>
            </div>
        </div>
        <div id="div_A" class="window top">
            <div class="clear-fix mx-4">
                <div id="students">


                    <div class="list-group" id="list-tab" role="tablist">
                        @foreach($students as $student)
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="student_{{$student->id}}">
                            <div class="float-left">
                                @if($student->status==1)
                                <i class="fa fa-circle text-success m-2"></i>
                                <input type="hidden" name="item-status" class='status-notification' value="1">
                                @else
                                <i class="fa fa-circle text-danger m-2"></i>
                                <input type="hidden" name="item-status" class='status-notification' value="0">
                                @endif
                                {{$student->first_name}}&nbsp;{{$student->last_name}}
                                <input type="hidden" name="item-name" value="{{$student->first_name}}{{$student->last_name}}">
                                <input type="hidden" name="item-group" value="{{$student->linked_groups}}">
                                <input type="hidden" name="item-company" value="{{$student->company}}">
                                <input type="hidden" name="item-function" value="{{$student->function}}">
                            </div>
                            <div class="btn-group float-right">
                                <span class=" p-2 font-weight-bolder">EN</span>
                                <button class="btn  item-show">
                                    <i class="px-2 fa fa-eye"></i>
                                </button>
                                <button class="btn ">
                                    <i class="px-2 fa fa-edit"></i>
                                </button>
                                <button class="btn ">
                                    <i class="px-2 fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div id="teachers">

                    <div class="list-group" id="list-tab" role="tablist">
                        @foreach($teachers as $teacher)
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="teacher_{{$teacher->id}}">
                            <div class="float-left">
                                @if($teacher->status==1)
                                <i class="fa fa-circle text-success m-2"></i>
                                <input type="hidden" name="item-status" class='status-notification' value="1">
                                @else
                                <i class="fa fa-circle text-danger m-2"></i>
                                <input type="hidden" name="item-status" class='status-notification' value="0">
                                @endif
                                {{$teacher->first_name}}&nbsp;{{$teacher->last_name}}
                                <input type="hidden" name="item-name" value="{{$teacher->first_name}}{{$teacher->last_name}}">
                                <input type="hidden" name="item-group" value="{{$teacher->linked_groups}}">
                                <input type="hidden" name="item-company" value="{{$teacher->company}}">
                                <input type="hidden" name="item-function" value="{{$teacher->function}}">
                            </div>
                            <div class="btn-group float-right">
                                <span class=" p-2 font-weight-bolder">EN</span>

                                <button class="btn  item-show">
                                    <i class="px-2 fa fa-eye"></i>
                                </button>
                                <button class="btn ">
                                    <i class="px-2 fa fa-edit"></i>
                                </button>
                                <button class="btn ">
                                    <i class="px-2 fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                <div id="authors">

                    <div class="list-group" id="list-tab" role="tablist">
                        @foreach($authors as $author)
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="author_{{$author->id}}">
                            <div class="float-left">
                                @if($author->status==1)
                                <i class="fa fa-circle text-success m-2"></i>
                                <input type="hidden" name="item-status" class='status-notification' value="1">
                                @else
                                <i class="fa fa-circle text-danger m-2"></i>
                                <input type="hidden" name="item-status" class='status-notification' value="0">
                                @endif
                                {{$author->first_name}}&nbsp;{{$author->last_name}}
                                <input type="hidden" name="item-name" value="{{$author->first_name}}{{$author->last_name}}">
                                <input type="hidden" name="item-group" value="{{$author->linked_groups}}">
                                <input type="hidden" name="item-company" value="{{$author->company}}">
                                <input type="hidden" name="item-function" value="{{$author->function}}">
                            </div>
                            <div class="btn-group float-right">
                                <span class=" p-2 font-weight-bolder">EN</span>

                                <button class="btn  item-show">
                                    <i class="px-2 fa fa-eye"></i>
                                </button>
                                <button class="btn " id="list-home-list">
                                    <i class="px-2 fa fa-edit"></i>
                                </button>
                                <button class="btn ">
                                    <i class="px-2 fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white  mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">

            <div class="mx-4">
                <form method="post" id="user_form" enctype="multipart/form-data" class="form" action="">
                    @csrf
                    <!-- <input name='_method' type='hidden' value='PUT' id='method-select' /> -->
                    <div class="card text-black mx-2 pt-3">
                        <div class="d-flex justify-content-center flex-wrap pl-3 pb-3" style="overflow:hidden;">
                            <div style="width:300px !important; position:relative">
                                <i class="fa fa-cog float-right p-3 position-absolute ml-auto" style="right:0;" id="upload_button">
                                    <input type="file" name="image" class="image" accept="image/*" hidden>
                                </i>
                                <img src="" alt="" id="preview" width=300 height=300 name="preview" />
                                <input type="hidden" name="base64_img_data" id="base64_img_data">
                            </div>
                        </div>
                        <div class="card-body  p-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Login Administrator
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="login" name="login" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Password
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            First Name
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Last Name
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Company
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="company" name="company" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Position
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="position" name="position" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Complete contact info
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="contact_info" name="contact_info" value="" required>
                                </div>
                            </div>


                            <div class="form-group clearfix">
                                <button type="submit" class="btn btn-hero-primary float-right mx-1" id="user_save_button" disabled>SAVE</button>
                                <button type="button" class="btn btn-hero-primary float-right mx-1 cancel-btn" id="user_cancel_button">CANCEL</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div id="user-form-tags" class="second-table">
                    <ul class="nav nav-tabs border-0 mb-2">
                        <li class="nav-item">
                            <a class="nav-link active m-1 rounded-1 border-0" id="table-groups-tab" href="#table-groups">{{$translation->l('GROUPS')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link m-1 rounded-1 border-0" id="table-session-tab" href="#table-session"> {{$translation->l('SESSIONS')}}</a>
                        </li>
                    </ul>

                    <div id="table-groups">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action p-1 border-0 " id="">
                                <div class="float-left">
                                    <i class="fa fa-circle text-danger m-2"></i>
                                    askkd
                                </div>
                                <div class="btn-group float-right">
                                    <button class="btn  toggle1-btn">
                                        <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    <button class="btn  toggle1-btn" id="list-home-list">
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    <button class="btn  toggle1-btn">
                                        <i class="px-2 fa fa-trash-alt"></i>
                                    </button>
                                    <button class="btn  toggle1-btn text-white">
                                        <i class="px-2 fas fa-unlink"></i>
                                    </button>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div id="table-session">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action p-1 border-0 " id="">
                                <div class="float-left">
                                    <i class="fa fa-circle text-danger m-2"></i>
                                    askkd
                                </div>
                                <div class="btn-group float-right">
                                    <button class="btn  toggle1-btn">
                                        <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    <button class="btn  toggle1-btn" id="list-home-list">
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    <button class="btn  toggle1-btn">
                                        <i class="px-2 fa fa-trash-alt"></i>
                                    </button>
                                    <button class="btn  toggle1-btn text-white">
                                        <i class="px-2 fas fa-unlink"></i>
                                    </button>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="modal myModal fade mt-lg-5" id="image-crop-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
        <i class="fas fa-grip-lines-vertical text-white"></i>
    </div>
    <fieldset id="RightPanel">


        <ul class="nav nav-tabs border-0 mb-2 mx-4">
            <li class="nav-item">
                <a class="nav-link active m-1 rounded-1 border-0" id="groups-tab" href="#groups">{{$translation->l('GROUPS')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1 rounded-1 border-0" id="companies-tab" href="#companies">{{$translation->l('COMPANIES')}}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link m-1 rounded-1 border-0" id="positions-tab" href="#positions">{{$translation->l('positions')}}</a>
            </li>
        </ul>
        <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column mx-4">
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
                        <i class="fa fa-bars icon p-2  text-white"></i>
                    </a>
                </div>
            </div>
            <div class="fliter p-2 toolkit-filter">
                <div class="float-left">
                    <input type="radio" id="filter-state-on" name="status" value="on">
                    <span>on&nbsp;</span>
                    <input type="radio" id="filter-state-off" name="status" value="off">
                    <span>off&nbsp;</span>
                    <input type="radio" id="filter-state-all" name="status" value="all">
                    <span>all&nbsp;</span>
                </div>
                <div class="float-right d-none">
                    <button type="button" value="" class="rounded text-white fliter-company-btn px-1 border-0">company +</button>&nbsp;
                    <button type="button" value="" class="rounded text-white fliter-function-btn px-1 border-0">function +</button>
                </div>
            </div>
        </div>
        <div id="div_C" class="window top">
            <div id="groups">


                <div class="list-group mx-4" id="list-tab" role="tablist">
                    @foreach($groups as $group)
                    <a class="list-group-item list-group-item-action p-1 border-0 " id="group_{{$group->id}}">
                        <div class="float-left">
                            @if($group->status==1)
                            <i class="fa fa-circle text-success m-2"></i>
                            <input type="hidden" name="item-status" class='status-notification' value="1">
                            @else
                            <i class="fa fa-circle text-danger m-2"></i>
                            <input type="hidden" name="item-status" class='status-notification' value="0">
                            @endif
                            {{$group->name}}
                            <input type="hidden" name="item-name" value="{{$group->name}}">
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn  toggle1-btn  item-show">
                                <i class="px-2 fa fa-eye"></i>
                            </button>
                            <button class="btn  toggle1-btn" id="list-home-list">
                                <i class="px-2 fa fa-edit"></i>
                            </button>
                            <button class="btn  toggle1-btn">
                                <i class="px-2 fa fa-trash-alt"></i>
                            </button>
                            <button class="btn  toggle2-btn text-white">
                                <i class="px-2 fas fa-check-circle"></i>
                            </button>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <div id="companies">

                <div class="list-group mx-4" id="list-tab" role="tablist">
                    @foreach($companies as $company)
                    <a class="list-group-item list-group-item-action p-1 border-0 " id="company_{{$company->id}}">
                        <div class="float-left">
                            {{$company->name}}
                            <input type="hidden" name="item-status" value="{{$group->status}}">
                            <input type="hidden" name="item-name" value="{{$group->name}}">
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn  toggle1-btn  item-show">
                                <i class="px-2 fa fa-eye"></i>
                            </button>
                            <button class="btn  toggle1-btn" id="list-home-list">
                                <i class="px-2 fa fa-edit"></i>
                            </button>
                            <button class="btn  toggle1-btn">
                                <i class="px-2 fa fa-trash-alt"></i>
                            </button>
                            <button class="btn  toggle2-btn text-white">
                                <i class="px-2 fas fa-check-circle"></i>
                            </button>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            <div id="positions">

                <div class="list-group mx-4" id="list-tab" role="tablist">
                    @foreach($positions as $position)
                    <a class="list-group-item list-group-item-action p-1 border-0 " id="position_{{$position->id}}">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$position->name}}
                            <input type="hidden" name="item-name" value="{{$group->name}}">
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn  toggle1-btn  item-show">
                                <i class="px-2 fa fa-eye"></i>
                            </button>
                            <button class="btn  toggle1-btn" id="list-home-list">
                                <i class="px-2 fa fa-edit"></i>
                            </button>
                            <button class="btn  toggle1-btn">
                                <i class="px-2 fa fa-trash-alt"></i>
                            </button>
                            <button class="btn  toggle2-btn text-white">
                                <i class="px-2 fas fa-check-circle"></i>
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
                <form method="post" id="category_form" enctype="multipart/form-data" class="form" action="">
                    <div class="card bg-white text-black mx-2">
                        <div class="card-body  p-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Name
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="category_name" name="company" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Description
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="category_description" name="company" value="" required>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <button type="submit" class="btn btn-hero-primary float-right mx-1" id="category_save_button" disabled>SAVE</button>
                                <button type="button" class="btn btn-hero-primary float-right mx-1 cancel-btn" id="category_cancel_button">CANCEL</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="category-form-tags" class="second-table mx-4">
                <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column ">
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
                                <i class="fa fa-bars icon p-2  text-white"></i>
                            </a>
                        </div>
                    </div>
                    <div class="fliter p-2 toolkit-filter">
                        <div class="float-left">
                            <input type="radio" id="filter-state-on" name="status" value="on">
                            <span>on&nbsp;</span>
                            <input type="radio" id="filter-state-off" name="status" value="off">
                            <span>off&nbsp;</span>
                            <input type="radio" id="filter-state-all" name="status" value="all">
                            <span>all&nbsp;</span>
                        </div>
                        <div class="float-right">
                            <button type="button" value="" class="rounded text-white fliter-company-btn px-1 border-0">company +</button>&nbsp;
                            <button type="button" value="" class="rounded text-white fliter-function-btn px-1 border-0">function +</button>
                        </div>
                    </div>
                </div>
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action p-1 border-0 " id="">
                        <div class="float-left">
                            <i class="fa fa-circle text-success m-2"></i>
                            <input type="hidden" name="item-status" class='status-notification' value="1">
                            askkd

                        </div>
                        <div class="btn-group float-right">
                            <button class="btn  toggle1-btn">
                                <i class="px-2 fa fa-eye"></i>
                            </button>
                            <button class="btn  toggle1-btn" id="list-home-list">
                                <i class="px-2 fa fa-edit"></i>
                            </button>
                            <button class="btn  toggle1-btn">
                                <i class="px-2 fa fa-trash-alt"></i>
                            </button>
                            <button class="btn  toggle1-btn text-white">
                                <i class="px-2 fas fa-unlink"></i>
                            </button>
                        </div>
                    </a>
                </div>
            </div>


    </fieldset>
</div>

@endsection

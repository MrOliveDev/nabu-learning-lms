@extends('layout')

@section('css_after')
<link rel="stylesheet" href="{{ asset('assets/css/mail.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/trumbowyg/trumbowyg.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}" >
<link rel="stylesheet" href="{{asset('assets/css/cropper.css')}}" />
<link rel="stylesheet" href="{{asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css')}}">
@endsection

@section('con')
<div class="">
    
<fieldset id="MailPanel">
    <ul class="nav nav-tabs border-0 mb-2 mx-4">
        <li class="nav-item">
            <a class="nav-link m-1 rounded-1 border-0" id="send-tab"
                href="#generer">{{ $translation->l('Send Mail') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link m-1 rounded-1 border-0" id="histories-tab"
                href="#historique">{{ $translation->l('Historic') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link m-1 rounded-1 border-0" id="models-tab"
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
            <table class="table table-striped table-vcenter mailTbl" id="historic-table" style="width:100%;">
            <thead>
                <tr>
                    <th style="width: 15%;">{{ $translation->l('Sender') }}</th>
                    <th style="width: 20%;">{{ $translation->l('Model Name') }}</th>
                    <th style="width: 30%;">{{ $translation->l('Details') }}</th>
                    <th style="width: 15%;">{{ $translation->l('Date') }}</th>
                    <th style="width: 20%;" class="text-center">{{ $translation->l('Actions') }}</th>
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
        <div id="generer" class="ml-4">
            <fieldset id="genererLeft">
                <div class="input-container p-2">
                    <span style="color: white;">Choose the type of mail </span>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100" type="text" id="type-filter">
                        <i class="fa fa-search icon p-2"></i>
                    </span>
                </div>
                <div class="w-100 p-2 sliderStyle">
                    <div id="doc-type-list">
                        @foreach($templates as $template)
                        <div class="doc-type-item" onclick="selectModel({{ $template['id'] }})" id="doc-type-item-{{ $template['id'] }}">
                            <span id="doc-type-item-title-{{$template['id']}}">{{ $template['name'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div id="horizSplit1" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
                    <i class="fas fa-grip-lines"></i>
                </div>
                <div class="input-container mb-2 mt-5 p-2">
                    <span style="color: white;">List of receivers </span>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 user-filter" type="text" name="user-filter">
                        <i class="fa fa-search icon p-2"></i>
                    </span>
                </div>
                <div class="w-100 p-2 sliderStyle" id="usersPane" style="height: 300px;">
                    <table class="table table-bordered table-striped table-vcenter" style="width:100%;">
                        <colgroup>
                            <col span="1" style="width: 10%;">
                            <col span="1" style="width: 60%;">
                            <col span="1" style="width: 30%;">
                        </colgroup>
                        <tbody id="usersList">
                            <tr style="border: 1px solid #7e3e98; cursor: pointer;">
                                <td class="text-center" style="padding: 0; background-color: #7e3e98; border: 0px;">
                                    <input style="cursor: pointer; filter: hue-rotate(120deg); transform: scale(1.3);" type="checkbox" id="sendcheck_all" checked>
                                </td>
                            </tr>
                            @forelse($users as $user)
                            <tr class="user-item">
                                <td class="text-center userAction">
                                    <input type="checkbox" id="sendcheck_{{$user['id']}}" class="sendcheck" style="cursor:pointer; filter: hue-rotate(120deg); transform: scale(1.3);" checked>
                                </td>
                                <td class="font-w600 userName" id="user-name-{{$user['id']}}">{{ $user['first_name']. ' ' . $user['last_name'] }}</td>
                                <!-- <td class="font-w600 text-center userAction" onclick="sendMail({{ $user['id'] }})"><i class="fa fa-envelope"></i></td> -->
                                <td class="font-w600 text-center userAction" onclick="previewMail({{ $user['id'] }})">Preview <i class="fa fa-envelope"></i></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="horizSplit3" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
                    <i class="fas fa-grip-lines"></i>
                </div>

                <div class="w-100 p-2 text-center">
                    <button class="downloadBtn" onclick="sendToAll()">
                        Send to all selected users <i class="fa fa-mail-bulk"></i>
                    </button>
                </div>

            </fieldset>
            <div id="verticalSplit1" class="handler_vertical width-controller">
                <i class="fas fa-grip-lines-vertical text-white"></i>
            </div>
            <fieldset id="genererRight">
                <div class="mb-4">
                    <span class="text-white mr-4">From * </span>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 model-name-input" type="text" style="width: 350px;" id="from-address" value="{{ $fromAddress }}">
                    </span>
                </div>
                <div class="mb-4">
                    <span class="text-white mr-4">To * &nbsp; &nbsp; </span>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 model-name-input" type="text" style="width: 350px;" id="to-address">
                    </span>
                </div>
                <div class="mb-3">
                    <span class="text-white mr-1">Subject *</span>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 model-name-input" type="text" style="width: 350px;" id="send-subject">
                    </span>
                </div>
                <div class="w-100 p-2" id="overviewPane">
                </div>
                <button class="downloadBtn mt-2" onclick="sendNow()">
                    Send <i class="fa fa-envelope"></i>
                </button>
            </fieldset>
        </div>
        
        <div id="modeles" class="ml-4">
            <fieldset id="modelLeft">
                <div class="w-100 p-2 sliderStyle" style="height: 200px;">
                    <div id="model-item-list">
                    @foreach($templates as $template)
                    <div class="model-item" id="model-item-{{$template['id']}}">
                        <div>
                            <i class="fa fa-circle mr-3" style="color: green;"></i>
                            <span id="model-title-{{$template['id']}}">{{ $template['name'] }}</span>
                        </div>
                        <div>
                            <i class="fa fa-edit mr-3 actionBtn" onclick="editTemplate({{$template['id']}})"></i>
                            <i class="fa fa-trash mr-3 dangerBtn" onclick="delTemplate({{$template['id']}})"></i>
                        </div>
                    </div>
                    @endforeach
                    </div>
                    <i class="fa fa-plus addModelBtn ml-3 mt-3 actionBtn" onclick="addTemplate()"></i>
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
                                href="#images">{{ $translation->l('Images') }}</a>
                        </li>
                    </ul>
                    <div class="ml-3">
                        <div id="variables">
                            <p class="model-drag-item mt-1" onclick="toggleActive(this)">#last_name</p>
                            <p class="model-drag-item mt-1" onclick="toggleActive(this)">#first_name</p>
                            <p class="model-drag-item mt-1" onclick="toggleActive(this)">#password</p>
                            <p class="model-drag-item mt-1" onclick="toggleActive(this)">#username</p>
                            <!-- <p class="model-drag-item mt-1" onclick="toggleActive(this)">#total_time_spent_on_training</p>
                            <p class="model-drag-item mt-1" onclick="toggleActive(this)">#evaluation_pc_result</p>
                            <p class="model-drag-item mt-1" onclick="toggleActive(this)">#evaluation_num_result</p> -->
                        </div>
                        <div id="images">
                            <div id="imagePreviews">
                                @foreach($images as $image)
                                <img src="{{ $image['data'] }}" alt="image" class="model-drag-item previewImg" width="100" height="100" onclick="toggleActive(this)">
                                @endforeach
                            </div>
                            <i class="fa fa-plus addModelBtn ml-3 mt-3 actionBtn" id="upload_button">
                                <input type="file" name="image" class="image" accept="image/*" hidden>
                            </i>
                        </div>
                    </div>  
                </div>

            </fieldset>

            <div id="verticalSplit2" class="handler_vertical width-controller" style="color: #362f81;">
                <i class="fas fa-grip-lines-vertical"></i>
            </div>

            <fieldset id="modelRight">
                <div class="mb-4">
                    <span class="text-white mr-3">Name * </span>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 model-name-input" type="text" style="width: 350px;" id="model-name">
                    </span>
                </div>
                <div class="mb-3">
                    <span class="text-white mr-1">Subject *</span>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 model-name-input" type="text" style="width: 350px;" id="mail-subject">
                    </span>
                </div>
                <div class="w-100" style="height: 600px; background-color: white;" id="model-trumb-pane">
                </div>
                <div class="float-right mt-3">
                    <button class="modelActBtn mr-2" onclick="cancelTemplate()"> CANCEL </button>
                    <button class="modelActBtn mr-2" onclick="saveTemplate()"> SAVE </button>
                </div>
            </fieldset>
        </div>

        <input type="hidden" id="process" value="{{ $process }}">
    </div>
    
    <div class="modal myModal fade" id="image-crop-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body" id="drop">
                    <div class="img-container" id="img-range-slider">
                        <div class="form-group" id="zoom-rangeslider-group" style="display:none;">
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

    <div class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="modal-block-popout" aria-hidden="true">
        <div class="modal-dialog modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Progress</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <p class="text-center" id="statusNumbers">0 / 0</p>
                        <textarea style="width: 100%; height: 350px; resize: none;" id="statusNotes" readonly>
                        </textarea>
                    </div>
                    <div class="block-content block-content-full text-right bg-light">
                        <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Done</button>
                    </div>
                </div>
            </div>
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
<script src="{{ asset('assets/js/plugins/trumbowyg/jquery-resizable.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/trumbowyg/trumbowyg.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/trumbowyg/trumbowyg.resizimg.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

<script src="{{asset('assets/js/cropper.js')}}"></script>
<script src="{{asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.js')}}"></script>
<script>
    var $modal = $('#image-crop-modal');
    var previewimg = document.getElementById('image');
    var cropper;
    var zoomscale = 50;
    $("body").on("change", ".image", function(e) {
        var files = e.target.files;
        var done = function(url) {
            var list = $('.img-container')[0];
            var img = document.createElement("img");
            // img.file = file;
            img.src = url;
            img.id = 'image';
            list.prepend(img);

            previewimg = document.getElementById('image');
            previewimg.src = url;
            cropper = new Cropper(previewimg, {
                aspectRatio: 1,
                "container": {
                    "width": "100%",
                    "height": 400
                },
                "viewport": {
                    "width": 200,
                    "height": 200,
                    "type": "circle",
                    "border": {
                        "width": 2,
                        "enable": true,
                        "color": "#fff"
                    }
                },
                "zoom": {
                    "enable": true,
                    "mouseWheel": true,
                    "slider": true
                },
                "rotation": {
                    "slider": true,
                    "enable": true,
                    "position": "left"
                },
                "transformOrigin": "viewport"

            });

            $("#zoom-rangeslider-group").css('display', 'block');
            $('#drag-comment').remove();
            // $('#drop').unbind('click');
            let my_range = $(".js-rangeslider").data("ionRangeSlider");
            my_range.reset();
        };
        var reader;
        var file;
        var url;
        if (files && files.length > 0) {
            file = files[0];
            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function() {
        $('#image-crop-modal .modal-body').prepend('<div id="drag-comment"><div class="text-center mt-3" id="drop-text">Drop your file here!</div><div class="text-center my-1" id="drop-text1">or</div><div class="row"  id="browse-btn"><button type="button" class="btn btn-hero-primary float-right mx-auto" id="browse">Browse</button></div></div>');
        $('#image').remove();
        $("#zoom-rangeslider-group").css('display', 'none');
        if (cropper != null) {
            cropper.destroy();
            cropper = null;
        }
    }).on('hidden.bs.modal', function() {
        // $("#zoom-rangeslider-group").remove();
        $('#drag-comment').remove()
        $('#image').remove();
        $("#zoom-rangeslider-group").css('display', 'none');

        if (cropper != null) {
            cropper.destroy();
            cropper = null;
        }
    });
    $("#crop").click(function() {

        if (cropper != null) {

            // var range_slider_template = '<div class="form-group mb-5" id="zoom-rangeslider-group">' +
            //     '<input type="text" class="js-rangeslider" id="zoom-rangeslider" value="50"> </div>';

            // $("#img-range-slider").append(range_slider_template);
            canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;
                    $("#preview").attr('src', base64data);
                    $modal.modal('hide');
                    $.ajax({
                        url: 'saveMailImg',
                        method: 'post',
                        data: {data: base64data},
                        success: function(res) {
                            if(res.success){
                                $("#imagePreviews").append('<img src="' + base64data + '" alt="image" class="model-drag-item previewImg" width="100" height="100" onclick="toggleActive(this)">');
                            } else
                                Dashmix.helpers('notify', {type: 'danger', icon: 'fa fa-times mr-1', message: res.message });
                        },
                        error: function(err) {
                            Dashmix.helpers('notify', {type: 'danger', icon: 'fa fa-times mr-1', message: "Sorry, You have an error!" });
                        }
                    });
                }
            });
            $('#drag-comment').remove()
            $('#image').remove();
            $("#zoom-rangeslider-group").css('display', 'none');
            cropper.destroy();
            cropper = null;
        } else {
            $modal.modal('hide');
        }
    })
    $("#zoom-rangeslider").change(function() {
        // if (zoomscale < $(this).val()) {
        //     cropper.zoom(0.9);
        // } else if(zoomscale > $(this).val()) {
        //     cropper.zoom(-0.8);
        // }
        if (cropper != null) {
            zoomvalue = 1 - (50 - $(this).val()) * 0.02;
            cropper.zoomTo(zoomvalue);
        }
        // zoomscale = $(this).val();
    })
    $('#upload_button').click(function(evt) {
        evt.stopPropagation();
        // alert($('#menuBackground').css('background-color'));
        // var interface_color={
        //     'menuBackground':RGBToHex($('#menu-background').css('background-color')),
        //     'pageBackground':RGBToHex($('#page-background').css('background-color')),
        //     'iconOverColor':RGBToHex($('#icon-over-color').css('background-color')),
        //     'iconDefaultColor':RGBToHex($('#icon-default-color').css('background-color'))
        // }
        // $('#interface_color').val(JSON.stringify(interface_color));
        // alert($('#interface_color').val());
        // $(this).children("input[type='file']")[0].click();
        // if ($(".uploadcare--link.uploadcare--widget__file-name").length == 0) {
        $("#zoom-rangeslider").val(50);
        $modal.modal({
            backdrop: 'static',
            keyboard: false
        });
        // $("input.image")[0].click();
    });
    if (window.FileReader) {
        var drop;
        addEventHandler(window, 'load', function() {
            drop = document.getElementById('drop');
            var list = $('.img-container')[0];

            function cancel(e) {
                if (e.preventDefault) {
                    e.preventDefault();
                }
                return false;
                $('.modal').removeClass('dropover');
                $('.modal-content').removeClass('modal_dropover');
            }

            // Tells the browser that we *can* drop on this target
            addEventHandler(drop, 'dragover', function(e) {
                e = e || window.event; // get window.event if e argument missing (in IE)
                if (e.preventDefault) {
                    e.preventDefault();
                }
                $('.modal').addClass('dropover');
                $('.modal-content').addClass('modal_dropover');

                return false;
            });
            addEventHandler(drop, 'dragleave', function(e) {
                e = e || window.event; // get window.event if e argument missing (in IE)
                if (e.preventDefault) {
                    e.preventDefault();
                }
                $('.modal').removeClass('dropover');
                $('.modal-content').removeClass('modal_dropover');
                return false;
            });
            addEventHandler(drop, 'dragenter', cancel);
            addEventHandler(drop, 'drop', function(e) {
                $('.modal-content').removeClass('modal_dropover');
                $('.modal').removeClass('dropover');
                $('#drag-comment').remove()
                e = e || window.event; // get window.event if e argument missing (in IE)
                if (e.preventDefault) {
                    e.preventDefault();
                } // stops the browser from redirecting off to the image.

                var dt = e.dataTransfer;
                var files = dt.files;
                // for (var i = 0; i < files.length; i++) {
                var file = files[0];
                var reader = new FileReader();

                //attach event handlers here...

                reader.readAsDataURL(file);
                addEventHandler(reader, 'loadend', function(e, file) {
                    var bin = this.result;
                    var img = document.createElement("img");
                    img.file = file;
                    img.src = bin;
                    img.id = 'image';
                    $('#image').remove();
                    list.prepend(img);

                    $('#drop-text').remove();

                    if (cropper != null) {
                        cropper.destroy();
                        cropper = null;
                    }
                    previewimg = document.getElementById('image');
                    cropper = new Cropper(previewimg, {
                        aspectRatio: 1,
                        "container": {
                            "width": "100%",
                            "height": 400
                        },
                        "viewport": {
                            "width": 200,
                            "height": 200,
                            "type": "circle",
                            "border": {
                                "width": 2,
                                "enable": true,
                                "color": "#fff"
                            }
                        },
                        "zoom": {
                            "enable": true,
                            "mouseWheel": true,
                            "slider": true
                        },
                        "rotation": {
                            "slider": true,
                            "enable": true,
                            "position": "left"
                        },
                        "transformOrigin": "viewport"

                    });

                    // var range_slider_template = '<div class="form-group mb-5" id="zoom-rangeslider-group">' +
                    //     '<input type="text" class="js-rangeslider" id="zoom-rangeslider" value="50"> </div>';

                    // //////////
                    // var temp = 1;
                    // $("#img-range-slider").append(range_slider_template);
                    $("#zoom-rangeslider-group").css('display', 'block');
                    let my_range = $(".js-rangeslider").data("ionRangeSlider");
                    my_range.reset();

                }.bindToEventHandler(file));
                // }
                return false;
            });
            Function.prototype.bindToEventHandler = function bindToEventHandler() {
                var handler = this;
                var boundParameters = Array.prototype.slice.call(arguments);
                console.log(boundParameters);
                //create closure
                return function(e) {
                    e = e || window.event; // get window.event if e argument missing (in IE)
                    boundParameters.unshift(e);
                    handler.apply(this, boundParameters);
                }
            };
        });
    } else {
        console.log('Your browser does not support the HTML5 FileReader.');
    }

    function addEventHandler(obj, evt, handler) {
        if (obj.addEventListener) {
            // W3C method
            obj.addEventListener(evt, handler, false);
        } else if (obj.attachEvent) {
            // IE method.
            obj.attachEvent('on' + evt, handler);
        } else {
            // Old school method.
            obj['on' + evt] = handler;
        }
    }
    $('#drop').click(function(e) {
        if (cropper == null) {
        e.preventDefault();
        $(".image")[0].click();
        }
    })
</script>
@endsection

@include('mail.script')

<script src="{{asset('assets/js/ga.js')}}"></script>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);
</script>
@endsection

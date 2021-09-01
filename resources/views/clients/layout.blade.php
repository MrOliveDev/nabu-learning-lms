@extends('superadminsettings')

@section('client')

<link rel="stylesheet" href="{{asset('assets/css/cropper.css')}}" />
<link rel="stylesheet" href="{{asset('assets/js/plugins/sweetalert2/sweetalert2.min.css')}}" />

<style type="text/css">
    .cropper-view-box {
        border-radius: 50%;
    }
    .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }

    .modal-lg {
        max-width: 1000px !important;
    }

    .swal2-container {
        z-index: 3000;
    }

    .swal2-container .btn,
    .modal .btn {
        border-radius: 3px;
    }

    .uploadcare--jcrop-holder>div>div,
    #preview {
        border-radius: 50%;
    }

    .uploadcare--widget__button.uploadcare--widget__button_type_open {
        display: none;
    }

    #uploadcare--widget__text {
        display: none;

    }

    /* ////////////////////////
    ///////////dropzon
    //////////////////////// */
    #drop {
        min-height: 150px;
        min-width: 250px;
        max-width: 100%;
        border: 1px dashed blue;
        margin: 10px;
        padding: 10px;
    }

    .dropover {
        background-color: #2e6dea70;
    }

    .modal_dropover {
        background-color: #a6c1f4;
    }

    #upload_button{
        color:#2d4272;
    }
    #upload_button:hover{
        color:#d52f72;
    }

    .btn-hero-primary:hover #upload_button:hover {
        background-color: #d52f72;
    }

</style>
<div id="content">
    <fieldset id="LeftPanel">
        <div id="div_A" class="window top">

            <div class="px-4">
                <div class="list-group m-0" id="list-tab" role="tablist">
                    @foreach($clientsList as $key => $client)
                    <a class="list-group-item list-group-item-action  p-1 border-0" id="client_{{$key}}" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$client['first_name']}} &nbsp {{$client["last_name"]}}
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn text-white px-2 edit-button" data-idx="{{$key}}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-white px-2 delete-button js-swal-confirm" onclick="clientDelete(event, '{{$key}}')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                        <input type="hidden" name="login" id="hidden_login_{{$key}}" value="{{$client['login']}}">
                        <input type="hidden" name="company" id="hidden_company_{{$key}}" value="{{$client['company']}}">
                        <input type="hidden" name="firstname" id="hidden_firstname_{{$key}}" value="{{$client['first_name']}}">
                        <input type="hidden" name="lastname" id="hidden_lastname_{{$key}}" value="{{$client['last_name']}}">
                        <input type="hidden" name="contact_info" id="hidden_contact_info_{{$key}}" value="{{$client['contact_info']}}">
                        <input type="hidden" name="email" id="hidden_email_{{$key}}" value="{{$client['email']}}">
                        <input type="hidden" name="lang" id="hidden_lang_{{$key}}" value="{{$client['lang']}}">
                        <input type="hidden" name="pack" id="hidden_pack_{{$key}}" value="{{$client['pack']}}">
                        <input type="hidden" name="change_pw" id="hidden_change_pw_{{$key}}" value="{{$client['change_pw']}}">

                        <input type="hidden" name="status" id="hidden_status_{{$key}}" value="{{$client['status']}}">
                        <input type="hidden" name="pptimport" id="hidden_pptimport_{{$key}}" value="{{$client['pptimport']}}">

                        <input type="hidden" name="interface_icon" id="hidden_interface_icon_{{$key}}" value="{{$client['interface_icon']}}">
                        @if($client['interface_color']!==null)
                        <input type="hidden" name="menu-background" id="hidden_menu-background_{{$key}}" value="{{$client['interface_color']->menuBackground}}">
                        <input type="hidden" name="page-background" id="hidden_page-background_{{$key}}" value="{{$client['interface_color']->pageBackground}}">
                        <input type="hidden" name="icon-over-color" id="hidden_icon-over-color_{{$key}}" value="{{$client['interface_color']->iconOverColor}}">
                        <input type="hidden" name="icon-default-color" id="hidden_icon-default-color_{{$key}}" value="{{$client['interface_color']->iconDefaultColor}}">
                        @endif

                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white  mb-4 px-4">
            <a class="text-white float-left" href="#" style="font-size:40px; line-height: 30px; font-weight: 900;" id="client_add_button">+</a>
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">
            <div class="mt-3 d-flex flex-column px-4">
                <div class="clearfix mb-3">
                    <label class="px-2 py-1 bg-blue-4 text-white" style="width:150px; font-size:18pt;">
                        Status
                    </label>
                    <div class="custom-control custom-switch custom-control-lg custom-control-inline pl-2">
                        <input type="checkbox" class="custom-control-input" id="example-sw-custom-lg1" name="example-sw-custom-lg1" checked="">
                        <label class="custom-control-label" for="example-sw-custom-lg1"><i></i></label>
                    </div>
                </div>
                <div class="clearfix mb-3">
                    <label class="px-2 py-1 bg-blue-4 text-white" style="width:150px; font-size:18pt;">
                        PPT import
                    </label>
                    <div class="custom-control custom-switch custom-control-lg custom-control-inline pl-2">
                        <input type="checkbox" class="custom-control-input" id="example-sw-custom-lg2" name="example-sw-custom-lg2" checked="">
                        <label class="custom-control-label" for="example-sw-custom-lg2"><i></i></label>
                    </div>
                </div>


            </div>
        </div>
    </fieldset>
    <div id="div_vertical" class="handler_vertical width-controller">
        <i class="fas fa-grip-lines-vertical text-white"></i>
    </div>
    <fieldset id="RightPanel">
        <form method="post" id="client_form" enctype="multipart/form-data" class="form" action="">
            @csrf
            <!-- <input name='_method' type='hidden' value='PUT' id='method-select' /> -->
            <div class="card text-black mx-2 pt-3">
                <div class="d-flex  flex-wrap pl-3" style="overflow:hidden;">
                    <div style="width:300px !important; position:relative">
                        <i class="fa fa-cog float-right p-3 position-absolute ml-auto" style="right:0;" id="upload_button">
                            <input type="file" name="image" class="image" accept="image/*" hidden>
                            <input type="hidden" name="interface_color" value="" id="interface_color" />
                            <input type="hidden" name="status" value="" id="status" />
                            <input type="hidden" name="pptimport" value="" id="pptimport" />
                        </i>
                        <img src="" alt="" id="preview" width=300 height=300 name="preview" />
                        <input type="hidden" name="base64_img_data" id="base64_img_data">
                    </div>
                    <div class="flex-grow-1 p-4">
                        <div id="color-picker-select">
                            <div class="form-group">
                                <div class="js-colorpicker input-group" data-format="hex">
                                    <label for="" class="pr-2">
                                        Menu Background
                                    </label>

                                    <div class="input-group-append float-right">
                                        <span class="input-group-text colorpicker-input-addon p-0" style="width:38px; height:38px;">
                                            <i style="width:38px; height:38px; " id="menu-background">
                                                <input type="hidden" name="menuBackground" value=''>
                                            </i>
                                        </span>
                                        <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs" name="menu-background">
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="js-colorpicker input-group" data-format="hex">
                                    <label for="" class="pr-2">
                                        Page Background
                                    </label>

                                    <div class="input-group-append float-right">
                                        <span class="input-group-text colorpicker-input-addon p-0" style="width:38px; height:38px;">
                                            <i style="width:38px; height:38px; " id='page-background'>
                                                <input type="hidden" name="pageBackground" value=''>
                                            </i>
                                        </span>
                                        <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs" name='page-background'>
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="js-colorpicker input-group" data-format="hex">
                                    <label for="" class="pr-2">
                                        Icon over color
                                    </label>

                                    <div class="input-group-append float-right">
                                        <span class="input-group-text colorpicker-input-addon p-0" style="width:38px; height:38px;">
                                            <i style="width:38px; height:38px; " id="icon-over-color">
                                                <input type="hidden" name="iconOverColor" value=''>
                                            </i>
                                        </span>
                                        <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs" name="icon-over-color">
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="js-colorpicker input-group" data-format="hex">
                                    <label for="" class="pr-2">
                                        Icon default color
                                    </label>

                                    <div class="input-group-append float-right">
                                        <span class="input-group-text colorpicker-input-addon p-0" style="width:38px; height:38px;">
                                            <i style="width:38px; height:38px; " id='icon-default-color'>
                                                <input type="hidden" name="iconDefaultColor" value=''>
                                            </i>
                                        </span>
                                        <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs" name='icon-default-color'>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="float-right" href="#" id="restore_default">
                            Restore Default
                        </a>
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
                                    Complete contact_info
                                </span>
                            </div>
                            <input type="text" class="form-control" id="contact_info" name="contact_info" value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Email
                                </span>
                            </div>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Language of the Platform
                                </span>
                            </div>
                            <select class="form-control" id="lang" name="lang" required>
                                @foreach($languages as $language_item)
                                <option value="{{$language_item->language_id}}">{{$language_item->language_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    Pack
                                </span>
                            </div>
                            <select class="form-control" id="pack" name="pack" required>
                                <option value="50">up to 50</option>
                                <option value="100">up to 100</option>
                                <option value="150">up to 150</option>
                                <option value="200">up to 200</option>
                                <option value="250">up to 250</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group clearfix">
                        <button type="submit" class="btn btn-hero-primary float-right mx-1" id="client_save_button" disabled>SAVE</button>
                        <button type="button" class="btn btn-hero-primary float-right mx-1" id="client_cancel_button">CANCEL</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="modal myModal fade" id="image-crop-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body" id="drop">
                        <!-- <div id="drop">Drop files here.</div> -->

                        <div class="img-container" id="img-range-slider">

                            <!-- <img id="image" src="https://avatars0.githubusercontent.com/u/3456749" style="max-width:500px;"> -->
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
    </fieldset>
</div>



<script src="{{asset('assets/js/cropper.js')}}"></script>
<script src="{{asset('assets/js/plugins/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/js/cropperModal.js')}}"></script>
<script src="{{asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.js')}}"></script>

<script>
    ////////////////////////////////////////////
    ////////////////////////////////////////////
    ////////////////////////////Javascript
    ////////////////////////////////////////////
    ////////////////////////////////////////////

    let image;
    $(document).ready(function() {
        (function(factory) {
            "use strict";
            if (typeof define === "function" && define.amd) {

                // AMD
                define(["jquery"], factory);
            } else if (typeof exports === "object") {

                // CommonJs
                factory(require("jquery"));
            } else {

                // Browser globals
                factory(jQuery);
            }
        }(function($) {
            "use strict";
            $.fn.broiler = function(callBack) {
                var canvas = $("<canvas/>")[0],
                    imageData;
                this.click(function(event) {
                    image = $('#preview')[0];
                    canvas.width = image.width;
                    canvas.height = image.height;
                    canvas.getContext("2d").drawImage(image, 0, 0, image.width, image.height);
                    imageData = canvas.getContext("2d").getImageData(0, 0, image.width, image.height).data;
                    // console.log(image.src);
                    var offset = $(this).offset(),
                        x, y, scrollLeft, scrollTop, start;
                    scrollLeft = $(window).scrollLeft();
                    scrollTop = $(window).scrollTop();
                    x = Math.round(event.clientX - offset.left + scrollLeft);
                    y = Math.round(event.clientY - offset.top + scrollTop);
                    start = (x + y * image.width) * 4;

                    callBack({
                        r: imageData[start],
                        g: imageData[start + 1],
                        b: imageData[start + 2],
                        a: imageData[start + 3]
                    });
                });
            };
        }));
        $('#color-picker-select').children('.active-item').removeClass('active-item');
        $('#color-picker-select i').click(function() {
            $('#color-picker-select').children('.active-item').removeClass('active-item');
        })
        $(".fas.fa-crosshairs").click(function(event) {
            $(this).parents('.form-group').addClass('active-item');
        });

    });
    $(function() {
        $("#preview").broiler(function(color) {
            var hex1 = ((1 << 24) + (color.r << 16) + (color.g << 8) + color.b).toString(16).slice(1);
            var hex = "#" + hex1;
            $("#color-picker-select").find('.active-item i:first').css("background-color", hex);
        });
    });

    // ////////////////////////////////////////
    // ////////////////////////////////////////
    ///////////////RGB to hex
    // ////////////////////////////////////////
    // ////////////////////////////////////////

    function RGBToHex(rgb) {
        if (rgb != undefined) {

            // Choose correct separator
            let sep = rgb.indexOf(",") > -1 ? "," : " ";
            // Turn "rgb(r,g,b)" into [r,g,b]
            rgb = rgb.substr(4).split(")")[0].split(sep);

            let r = (+rgb[0]).toString(16),
                g = (+rgb[1]).toString(16),
                b = (+rgb[2]).toString(16);

            if (r.length == 1)
                r = "0" + r;
            if (g.length == 1)
                g = "0" + g;
            if (b.length == 1)
                b = "0" + b;

            return "#" + r + g + b;
        } else {
            return "#000000";
        }
    }

    ///////////////////////
    ///////////////////////
    //////Style Event
    ///////////////////////
    ///////////////////////
    // (function() {
    //     var ev = new $.Event('style'),
    //         orig = $.fn.css;
    //     $.fn.css = function() {
    //         $(this).trigger(ev);
    //         return orig.apply(this, arguments);
    //     }
    // })();

    // $('.colorpicker-input-addon i').bind('style', function(e) {
    //     console.log($(this).css('background'));
    //     // $(this).children("input[type='hidden']")[0].val($(this).css("background"));
    // });


    /////////////////////////////////
    /////////////////////////////////
    /////////////Image base64 upload
    /////////////////////////////////
    /////////////////////////////////

    // $('#modal').modal();

    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////
    /////////////////////////////////////From operation
    ////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////

    var e = Swal.mixin({
        buttonsStyling: !1,
        customClass: {
            confirmButton: 'btn btn-success m-1',
            cancelButton: 'btn btn-danger m-1',
            input: 'form-control'
        }
    });

    clientDelete = function(event, id) {
        // event.stopPropagation();
        e.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this imaginary file!',
            icon: 'warning',
            showCancelButton: !0,
            customClass: {
                confirmButton: 'btn btn-danger m-1',
                cancelButton: 'btn btn-secondary m-1'
            },
            confirmButtonText: 'Yes, delete it!',
            html: !1,
            preConfirm: function(e) {
                return new Promise((function(e) {
                    setTimeout((function() {
                        e()
                        $.ajax({
                            "url": "{{ route('clients.destroy', '') }}/" + id,
                            "type": "DELETE",
                            success: function(result) {
                                // alert(result);
                            }
                        });
                    }), 50)
                }))
            }
        }).then((function(n) {
            if (n.value) {
                e.fire('Deleted!', 'Your imaginary file has been deleted.', 'success');
                console.log(id);
                $('#client_' + id).remove();
            } else {
                'cancel' === n.dismiss && e.fire('Cancelled', 'Your imaginary file is safe :)', 'error');
            }
        }))


    }

    $(document).ready(function() {
        $("#preview").attr('src', "{{asset('assets/media/defaultAvatar.jpg')}}");
        $("#preview").css('border-radius', "50%");
        $("#pack").attr('autocomplete', "off");

        $('#login').prop('disabled', true);
        $('#company').prop('disabled', true);
        $('#password').prop('disabled', true);
        $('#firstname').prop('disabled', true);
        $('#lastname').prop('disabled', true);
        $('#contact_info').prop('disabled', true);
        $('#email').prop('disabled', true);
        $('#lang').prop('disabled', true);
        $('#pack').prop('disabled', true);
    });

    formclear = function() {
        $("#preview").attr('src', "{{asset('assets/media/defaultAvatar.jpg')}}");
        $("#preview").css('border-radius', "50%");


        $("#login").val('');
        $("#password").val('');
        $('#password').attr('placeholder', '');
        $("#company").val('');
        $("#firstname").val('');
        $("#lastname").val('');
        $("#contact_info").val('');
        $("#email").val('');
        $("#lang").val('1');
        $("#pack").val('50');

        $("#example-sw-custom-lg1").prop("checked", false);
        $("#example-sw-custom-lg2").prop("checked", false);

        $('#preview').attr("src", "{{asset('assets/media/defaultAvatar.jpg')}}");
        $('#menu-background').css("background", "#332422");
        $('#page-background').css("background", "#665778");
        $('#icon-over-color').css("background", "#ffef2f");
        $('#icon-default-color').css("background", "#aaaaaa");
        $('#base64_img_data').val('');
    }

    $('.edit-button').click(function(event) {
        event.preventDefault();
        formclear();
        var listItem = $(this).parents('.list-group-item')[0];
        var id = listItem.id.split('_')[1];
        console.log(id);
        $("#login").val($('#hidden_login_' + id).val());
        $("#company").val($('#hidden_company_' + id).val());
        $("#firstname").val($('#hidden_firstname_' + id).val());
        $("#lastname").val($('#hidden_lastname_' + id).val());
        $("#contact_info").val($('#hidden_contact_info_' + id).val());
        $("#email").val($('#hidden_email_' + id).val());
        $("#lang").val($('#hidden_lang_' + id).val());
        $("#pack").val($('#hidden_pack_' + id).val());

        if ($('#hidden_change_pw_' + id).val() == 0) {
            $("#password").val('');
            $("#password").attr("disabled", true);
            $("#password").prop('placeholder', "Private password!");
            $("#password").prop('required', false);
        }

        $("#example-sw-custom-lg1").prop("checked", $('#hidden_status_' + id).val() == 1);
        $("#example-sw-custom-lg2").prop("checked", $('#hidden_pptimport_' + id).val() == 1);

        if ($('#hidden_interface_icon_' + id).val() != '') {
            $("#preview").attr('src', $('#hidden_interface_icon_' + id).val());
        } else {
            $("#preview").attr('src', "{{asset('assets/media/defaultAvatar.jpg')}}");
        }

        var route_url = "{{route('clients.update', '')}}" + '/' + id;
        $("#client_form").attr('action', route_url);

        if ($('#method-select').length == 0) {
            $("#client_form").prepend("<input name='_method' type='hidden' value='PUT' id='method-select' />");
        }
        $("#client_save_button").prop('disabled', false);
        $('#login').prop('disabled', false);
        $('#company').prop('disabled', false);
        $('#firstname').prop('disabled', false);
        $('#lastname').prop('disabled', false);
        $('#contact_info').prop('disabled', false);
        $('#email').prop('disabled', false);
        $('#lang').prop('disabled', false);
        $('#pack').prop('disabled', false);

        $("#menu-background").css('background', $('#hidden_menu-background_' + id).val()) + " !important";
        $("#page-background").css('background', $('#hidden_page-background_' + id).val()) + " !important";
        $("#icon-over-color").css('background', $('#hidden_icon-over-color_' + id).val()) + " !important";
        $("#icon-default-color").css('background', $('#hidden_icon-default-color_' + id).val()) + " !important";
    });

    $('#client_add_button').click(function() {
        formclear();
        var route_url = "{{route('clients.store')}}";
        $("#client_form").attr('action', route_url);
        $("#client_form").attr('method', "post");
        if ($('#method-select').length) {
            $('#method-select').remove();
        }
        $("#client_save_button").prop('disabled', false);
        $('#login').prop('disabled', false);
        $('#company').prop('disabled', false);
        $('#password').prop('disabled', false);
        $('#firstname').prop('disabled', false);
        $('#lastname').prop('disabled', false);
        $('#contact_info').prop('disabled', false);
        $('#email').prop('disabled', false);
        $('#lang').prop('disabled', false);
        $('#pack').prop('disabled', false);

        $('.list-group-item').removeClass('active');
    });

    $("#client_cancel_button").click(function() {
        $('.list-group-item').removeClass('active');
    })

    $('#restore_default').click(function(evt) {
        evt.preventDefault();
        formclear();

    });


    ///////////////////////////////////
    ///////////////////////////////////
    //////////upload button combine
    ///////////////////////////////////
    ///////////////////////////////////




    // $("#upload_tip").change(function(event) {
    //     // fileChange(event);
    //     console.log(event.target.files[0]);
    // });


    $('#client_form').submit(function() {
        // alert('asdfasdf');
        var interface_color = {
            'menuBackground': RGBToHex($('#menu-background').css('background-color')),
            'pageBackground': RGBToHex($('#page-background').css('background-color')),
            'iconOverColor': RGBToHex($('#icon-over-color').css('background-color')),
            'iconDefaultColor': RGBToHex($('#icon-default-color').css('background-color'))
        }
        $('#interface_color').val(JSON.stringify(interface_color));

        if ($('#base64_img_data').val() == undefined) {
            $('#base64_img_data').val() = "";
        }

        if ($('#example-sw-custom-lg1').is(":checked") == true) {
            $('#status').val('1')
        } else {
            $('#status').val('0');
        }
        if ($('#example-sw-custom-lg2').is(":checked") == true) {
            $('#pptimport').val('1');
        } else {
            $('#pptimport').val('0');
        }
        return true;
    })

</script>
<script src="{{asset('assets/js/ga.js')}}"></script>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);
</script>

@endsection

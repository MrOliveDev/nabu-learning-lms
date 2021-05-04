@extends('superadminsettings')




@section('client');

<div id="content">
    <fieldset id="LeftPanel">
        <div id="div_A" class="window top">

            <div class="px-4">
                <div class="list-group m-0" id="list-tab" role="tablist">
                    @foreach($clientsList as $key => $client)
                    <a class="list-group-item list-group-item-action  p-1 border-0" id="client_{{$key}}" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$client['login']}}
                        </div>
                        <div class="btn-group float-right">
                            <button class="btn text-white px-2 edit-button" data-idx="{{$key}}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-white px-2 delete-button">
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
        <form method="post" id="client_form" class="form" action="" autocomplete="off">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card text-black mx-2 pt-3">
                <div class="d-flex  flex-wrap pl-3" style="overflow:hidden;">
                    <div style="width:350px !important; height:250px; position:relative">
                        <img id="rainbow" src="{{asset('assets/media/17.jpg')}}" width="350" height="250">
                        <i class="fa fa-cog float-right p-3 position-absolute ml-auto" style="right:0;" id="upload_button">
                            <input type="file" value="" hidden name="img"></i>
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
                                            </i>
                                        </span>
                                        <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs" name="menu-background">
                                        </i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group active-item">
                                <div class="js-colorpicker input-group" data-format="hex">
                                    <label for="" class="pr-2">
                                        Page Background
                                    </label>
                                    <div class="input-group-append float-right">
                                        <span class="input-group-text colorpicker-input-addon p-0" style="width:38px; height:38px;">
                                            <i style="width:38px; height:38px; " id='page-background'>
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
                                            </i>
                                        </span>
                                        <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs" name='icon-default-color'>
                                        </i>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <a class="float-right" href="#">
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
                                <option value="0">Please select</option>
                                <option value="1">Option #1</option>
                                <option value="2">Option #2</option>
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
                        <button type="submit" class="btn btn-hero-primary float-right mx-1">SAVE</button>
                        <button type="button" class="btn btn-hero-primary float-right mx-1">CANCEL</button>
                    </div>
                </div>
            </div>
        </form>
    </fieldset>
</div>

<script>
    formclear = function() {


        $("#rainbow").attr('src', "{{asset('assets/media/17.jpg')}}");


        $("#login").val('');
        $("#password").val('');
        $("#company").val('');
        $("#firstname").val('');
        $("#lastname").val('');
        $("#contact_info").val('');
        $("#email").val('');
        $("#lang").val('1');
        $("#pack").val('50');
    }

    $('.edit-button').click(function(event) {
        event.preventDefault();
        var listItem = $(this).parents('.list-group-item')[0];
        var id = listItem.id.split('_')[1];
        $("#login").val($('#hidden_login_' + id).val());
        $("#company").val($('#hidden_company_' + id).val());
        $("#firstname").val($('#hidden_firstname_' + id).val());
        $("#lastname").val($('#hidden_lastname_' + id).val());
        $("#contact_info").val($('#hidden_contact_info_' + id).val());
        $("#email").val($('#hidden_email_' + id).val());
        $("#lang").val($('#hidden_lang_' + id).val());
        $("#pack").val($('#hidden_pack_' + id).val());

        console.log($('#hidden_interface_icon_' + id).val() == '');
        if ($('#hidden_interface_icon_' + id).val() != '') {
            $("#rainbow").attr('src', $('#hidden_interface_icon_' + id).val());
        } else {
            $("#rainbow").attr('src', "{{asset('assets/media/17.jpg')}}");
        }
        var route_url = "{{route('clients.update', '')}}" + '/' + id;
        $("#client_form").attr('action', route_url);
        if ($('#method-select').length == 0) {
            $("#client_form").prepend("<input name='_method' type='hidden' value='PUT' id='method-select' />");
        }

        $("#menu-background").css('background', "#" + $('#hidden_menu-background_' + id).val()) + " !important";
        $("#page-background").css('background', "#" + $('#hidden_page-background_' + id).val()) + " !important";
        $("#icon-over-color").css('background', "#" + $('#hidden_icon-over-color_' + id).val()) + " !important";
        $("#icon-default-color").css('background', "#" + $('#hidden_icon-default-color_' + id).val()) + " !important";



    });

    $('#client_add_button').click(function() {
        formclear();
        var route_url = "{{route('clients.store')}}";
        $("#client_form").attr('action', route_url);
        // $("#client_form").attr('method', "post");
        if ($('#method-select').length) {
            $('#method-select').remove();
        }
    });

    $('#upload_button').click(function(evt) {
        // evt.stopPropagation();
        $(this).children("input").click();
    })
</script>
@endsection

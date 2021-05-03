@extends('superadminsettings')




@section('client');
<script>
    $('.list-group-item').click(function(event){
        event.preventDefault();
        event.stopPropagation();
        console.log('sjdlkfjsld');
        console.log($(this).parents('.list-group-item').attr('id').split('_')[1]);
    })
</script>
<div id="content">
    <fieldset id="LeftPanel">
        <div id="div_A" class="window top">

            <div class="px-4">
                <div class="list-group m-0" id="list-tab" role="tablist">
                    @foreach($clients as $client)
                    <a class="list-group-item list-group-item-action  p-1 border-0" id="client_{{$client->id}}" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            {{$client->name}}
                        </div>
                        <div class="btn-group float-right">

                            <button class="btn text-white px-2 edit-button">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn text-white px-2 delete-button">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white  mb-4 px-4">
            <a class="text-white float-left" href="#" style="font-size:40px; line-height: 30px; font-weight: 900;">+</a>
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
        <div class="card text-black mx-2 pt-3">
            <div class="d-flex  flex-wrap pl-3" style="overflow:hidden;">
                <div style="width:350px !important; height:250px; position:relative">
                    <img id="rainbow" src="{{asset('assets/media/17.jpg')}}" width="350" height="250">
                    <i class="fa fa-cog float-right p-3 position-absolute ml-auto" style="right:0;"></i>
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
                                        <i style="width:38px; height:38px; ">
                                        </i>
                                    </span>
                                    <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs">
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
                                        <i style="width:38px; height:38px; ">
                                        </i>
                                    </span>
                                    <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs">
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
                                        <i style="width:38px; height:38px; ">
                                        </i>
                                    </span>
                                    <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs">
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
                                        <i style="width:38px; height:38px; ">
                                        </i>
                                    </span>
                                    <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs">
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
                        <input type="text" class="form-control" id="administrator" name="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Password
                            </span>
                        </div>
                        <input type="password" class="form-control" id="password" name="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Company
                            </span>
                        </div>
                        <input type="text" class="form-control" id="company" name="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                First Name
                            </span>
                        </div>
                        <input type="text" class="form-control" id="name" name="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Last Name
                            </span>
                        </div>
                        <input type="text" class="form-control" id="surname" name="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Complete Address
                            </span>
                        </div>
                        <input type="text" class="form-control" id="address" name="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Email
                            </span>
                        </div>
                        <input type="text" class="form-control" id="email" name="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Language of the Platform
                            </span>
                        </div>
                        <select class="form-control" id="languagePlatform" name="example-select">
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
                        <select class="form-control" id="pack" name="example-select">
                            <option value="0">Please select</option>
                            <option value="1">Option #1</option>
                            <option value="2">Option #2</option>
                        </select>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <button type="button" class="btn btn-hero-primary float-right mx-1">SAVE</button>
                    <button type="button" class="btn btn-hero-primary float-right mx-1">CANCEL</button>
                </div>
            </div>
        </div>
    </fieldset>
</div>
@endsection

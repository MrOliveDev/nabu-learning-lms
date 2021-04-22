@extends('welcome')

@section('con')
<div id="content">
    <fieldset id="LeftPanel">
        <div id="div_A" class="window top">
            <div class="clear-fix mx-4">

                <div class="clear-fix bg-warning text-white mb-3 toolkit" style="height:50px">
                    <strong class="float-left p-2">Template</strong>
                    <div class="float-right p-2">
                        <div class="input-container">
                            <button class="border-0 bg-transparent text-white" id="template_add_btn">
                                <i class="fa fa-plus icon p-2"></i>
                            </button>
                            <span class="bg-white text-black p-2 rounded">
                                <input class="input-field border-0" type="text" name="usrnm">
                                <i class="fa fa-search icon p-2"></i>
                            </span>
                            <i class="fa fa-bars icon p-2"></i>
                        </div>
                    </div>
                </div>

                <div class="list-group" id="template-list-tab" role="tablist">
                    @foreach($templates as $template)
                    <div class="list-group-item list-group-item-action p-1 border-0 bg-yellow-2 " id="template_item_{{$template->id}}" data-toggle="list" role="tab">
                        <div class="float-left">
                            <i class="fa fa-circle text-danger m-2"></i>
                            <span id="template_name">{{$template->name}}</span>
                        </div>
                        <div class="btn-group float-right">
                            <a class="btn text-primary px-2" href="" onclick="viewTemplateItem()">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a class="btn text-primary px-2" href="" onclick="editTemplateItem()">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn text-primary px-2" href="" onclick="deleteTemplateItem('{{$template->id}}')">
                                <i class="fa fa-trash-alt"></i>
                            </a>
                            <a class="btn text-primary px-2" href="" onclick="toTemplateEditor('{{$template->id}}')">
                                <i class="fa fa-cube"></i>
                            </a>
                            <a class="btn text-primary px-2" href="">
                                <i class="fa fa-sync-alt"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach

                </div>

            </div>
        </div>

        <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white  mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">

            <div class="mx-4">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active container m-0 p-2" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        <div class="card bg-white text-black p-3 mx-2 text-left">
                            <p>
                                <strong class="pt-1">Template Name :</strong>
                                <button class="float-right p-2 border-0" id="template_edit_btn"><i class="fa fa-cog"></i></button>
                            </p>

                            <label id="template_name_label"></label>
                            <input type="label" id="template_name_input">
                            <!--
                            <p>
                                <strong class="pt-1">Template Code :</strong>
                            </p>

                            <input type="text" value="" class=""> -->
                            <button class="float-right mt-3 p-2 border-0 float-right bg-yellow-1" id="template_save_btn">SAVE</button>


                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">Messages</div>
                    <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">Settings</div>
                </div>
            </div>


        </div>
    </fieldset>
    <div id="div_vertical" class="handler_vertical width-controller">
        <i class="fas fa-grip-lines-vertical text-white"></i>
    </div>
    <fieldset id="RightPanel">
        <div id="div_C" class="window top">

            <ul class="nav nav-tabs border-0 mb-2 mx-4">
                <li class="nav-item">
                    <a class="nav-link m-1 bg-green-2 rounded-1 border-0" href="#menu1">COMPANIES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active m-1 bg-green-2 rounded-1 border-0" href="#home">TRAINING COURSES</a>
                </li>
            </ul>

            <div class="toolkit clear-fix bg-success text-white mb-3 mx-4" style="height:50px">
                <strong class="float-left p-2">Companies</strong>
                <div class="float-right p-2">
                    <div class="input-container">
                        <i class="fa fa-plus icon p-2"></i>
                        <span class="bg-white text-black p-2 rounded">
                            <input class="input-field border-0" type="text" name="usrnm">
                            <i class="fa fa-search icon p-2"></i>
                        </span>
                        <i class="fa fa-bars icon p-2"></i>
                    </div>
                </div>
            </div>

            <div class="list-group mx-4" id="list-tab" role="tablist">
                <a class="list-group-item list-group-item-action active p-1 border-0 bg-green-1" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                    <div class="float-left">
                        <i class="fa fa-circle text-danger m-2"></i>
                        Delta co.
                    </div>
                    <div class="btn-group float-right">
                        <button class="btn text-primary px-2">
                            <span class="font-weight-bolder">EN</span>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn text-primary px-2" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-play"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-cube"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-sync-alt"></i>
                        </button>
                    </div>
                </a>
                <a class="list-group-item list-group-item-action p-1 border-0  bg-green-1" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                    <div class="float-left">
                        <i class="fa fa-circle text-danger m-2"></i>
                        Moscow university
                    </div>
                    <div class="btn-group float-right">
                        <button class="btn text-primary px-2">
                            <span class="font-weight-bolder">EN</span>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-play"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-cube"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-sync-alt"></i>
                        </button>
                    </div>
                </a>
                <a class="list-group-item list-group-item-action p-1 border-0  bg-green-1" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                    <div class="float-left">
                        <i class="fa fa-circle text-danger m-2"></i>
                        Tronto stuff company
                    </div>
                    <div class="btn-group float-right">
                        <button class="btn text-primary px-2">
                            <span class="font-weight-bolder">EN</span>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-play"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-cube"></i>
                        </button>
                        <button class="btn text-primary px-2">
                            <i class="fa fa-sync-alt"></i>
                        </button>
                    </div>
                </a>
            </div>

        </div>

    </fieldset>
</div>

<script>
    const VIEWMODE = 1,
        EDITMODE = 2,
        SAVEMODE = 3,

        UPDATEMODE = 1,
        ADDMODE = 2;

    let tmpbtnmode = VIEWMODE,
        sendmode = UPDATEMODE;

    let selecteditem;

    toTemplateEditor = function(id) {
        window.open("{{route('temp')}}", '_blank');
    }

    viewTemplateItem = function() {
        tmpbtnmode = VIEWMODE;
        template_btn_action(null);
    }

    editTemplateItem = function() {
        tmpbtnmode = EDITMODE;
        template_btn_action(null);
    }

    deleteTemplateItem = function(id) {
        $.post("{{route('template.delete')}}", {
                "_token": "{{ csrf_token() }}",
                "id": id
            },
            function(data, status) {
                $("#div_B").hide();
                $('#template_item_' + id).remove();
            });
    }

    template_btn_action = function(data) {
        switch (tmpbtnmode) {
            case VIEWMODE:
                $('#template_name_label').show();
                $('#template_name_input').hide();
                break;

            case EDITMODE:
                $('#template_name_label').hide();
                $('#template_name_input').show();
                break;

            case SAVEMODE:
                if (sendmode == UPDATEMODE) {
                    $.post("{{route('template.update')}}", data,
                        function(data, status) {
                            tmpbtnmode = VIEWMODE;
                            selecteditem.children('#template_name').html($('#template_name_input').val());
                        });
                } else {
                    $.post("{{route('template.add')}}", data,
                        function(data, status) {
                            tmpbtnmode = VIEWMODE;
                            $('#template-list-tab').append(
                                "<div class='list-group-item list-group-item-action p-1 border-0 bg-yellow-2 ' id='template_item_"+data.id+"' data-toggle='list' role='tab'>" +
                                "<div class='float-left'>" +
                                "<i class='fa fa-circle text-danger m-2'></i>" +
                                "<span id='template_name'>"+data.name+"</span>" +
                                "</div>" +
                                "<div class='btn-group float-right'>" +
                                "<a class='btn text-primary px-2' href='' onclick='viewTemplateItem()'>" +
                                "<i class='fa fa-eye'></i>" +
                                "</a>" +
                                "<a class='btn text-primary px-2' href='' onclick='editTemplateItem()'>" +
                                "<i class='fa fa-edit'></i>" +
                                " </a>" +
                                "<a class='btn text-primary px-2' href='' onclick='deleteTemplateItem('"+data.id+"')'>" +
                                "<i class='fa fa-trash-alt'></i>" +
                                "</a>" +
                                "<a class='btn text-primary px-2' href='' onclick='toTemplateEditor('"+data.id+"')'>" +
                                "<i class='fa fa-cube'></i>" +
                                "</a>" +
                                "<a class='btn text-primary px-2' href=''>" +
                                "<i class='fa fa-sync-alt'></i>" +
                                "</a>" +
                                "</div>" +
                                "</div>"
                            );
                        });
                    $("#div_B").hide();
                }
                break;

            default:
                break;
        }
    };
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#div_B").hide();
        $('#template-list-tab>.list-group-item').click(function(e) {
                selecteditem = $(this);
                sendmode = UPDATEMODE;
                tmpbtnmode = VIEWMODE;
                $("#div_B").show();
                $("#template_save_btn").hide();
                $("#template_edit_btn").show();
                template_btn_action({
                    _token: "{{ csrf_token() }}",
                    id: selecteditem.attr("id").split("_")[2],
                    name: $('#template_name_input').val(),
                });

                $('#template_name_label').html($("#" + e.target.id + " #template_name").html());
                $('#template_name_input').val($("#" + e.target.id + " #template_name").html());
            }

        );
        $('#template-list-tab>.list-group-item a.btn').click(function(event) {
                event.stopProgation();
            }

        )
    });

    // $('')

    $('#template_edit_btn').click(
        function() {
            template_btn_action({
                _token: "{{ csrf_token() }}",
                id: selecteditem.attr("id").split("_")[2],
                name: $('#template_name_input').val()
            });
            tmpbtnmode == 3 ? (tmpbtnmode = 1) : (tmpbtnmode++);
        }
    );

    $('#template_save_btn').click(
        function() {
            tmpbtnmode = SAVEMODE;
            template_btn_action({
                name: $('#template_name_input').val()
            });
        }
    );

    $('#template_add_btn').click(
        function() {
            tmpbtnmode = EDITMODE;
            sendmode = ADDMODE;
            $("#div_B").show();
            template_btn_action({
                _token: "{{ csrf_token() }}",
                name: $('#template_name_input').val()
            });
            $("#template_save_btn").show();
            $("#template_edit_btn").hide();
            $('#template_name_label').html('');
            $('#template_name_input').val('');
        }
    )
</script>
@endsection

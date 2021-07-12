<script>
$(document).ready(function(){
    $("#ReportPanel").tabs({ active: 0 });

    Dashmix.helpers(['notify']);

    // $("#historic-table").dataTable({
    //     pageLength: 5,
    //         lengthMenu: false,
    //         searching: false,
    //         autoWidth: false,
    //         dom: "<'row'<'col-sm-12'tr>>" +
    //             "<'row'<'col-sm-6'i><'col-sm-6'p>>",
    //         "columnDefs": [ {
    //             "targets": 5,
    //             "orderable": false
    //         } ]
    // });

    jQuery.resizable('verticalSplit1', "v");
    jQuery.resizable('verticalSplit2', "v");
    jQuery.resizable('horizSplit1', "h");
    jQuery.resizable('horizSplit2', "h");
    jQuery.resizable('horizSplit3', "h");
    jQuery.resizable('horizSplit4', "h");

    $("#modelDragItems").tabs({ active: 0 });

    $("#model-trumb-pane").trumbowyg();

    var table = $('#historic-table').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "orderCellsTop": true,
        "pageLength" : 50,
        "ajax":{
                "url": "{{ url('getReportList') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
        "columns": [
            { "data": "session" },
            { "data": "filename" },
            { "data": "type" },
            { "data": "detail" },
            { "data": "created_time" },
            { "data": "actions", "orderable": false }
        ],
        pageLength: 5,
        lengthMenu: false,
        searching: false,
        autoWidth: false,
        dom: "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        "columnDefs": [ {
            "targets": 5,
            "orderable": false
        } ]
    });

    $("#model-trumb-pane").on("click", function(){
        $(".model-drag-item").each(function() {
            if($(this).hasClass("active")){
                console.log($(this).html());
                if($(this).html() == "#Training_Synthetic_details_bloc"){
                    $.ajax({
                        url: 'getBlockHTML',
                        method: 'post',
                        data: {name: "training_synthetic"},
                        success: function(res) {
                            if(res.success && res.html){
                                $('#model-trumb-pane').trumbowyg('execCmd', {
                                    cmd: 'insertHTML',
                                    param: res.html,
                                    forceCss: false,
                                });
                            } else
                                notification(res.message, 2);
                        },
                        error: function(err) {
                            notification("Sorry, You have an error!", 2);
                        }
                    });
                }  else if($(this).html() == "#Training_lessons_list_bloc"){
                    $.ajax({
                        url: 'getBlockHTML',
                        method: 'post',
                        data: {name: "training_lessons"},
                        success: function(res) {
                            if(res.success && res.html){
                                $('#model-trumb-pane').trumbowyg('execCmd', {
                                    cmd: 'insertHTML',
                                    param: res.html,
                                    forceCss: false,
                                });
                            } else
                                notification(res.message, 2);
                        },
                        error: function(err) {
                            notification("Sorry, You have an error!", 2);
                        }
                    });
                } else if($(this).html() == "#Training_Complete_details_bloc"){
                    $.ajax({
                        url: 'getBlockHTML',
                        method: 'post',
                        data: {name: "training_complete_details"},
                        success: function(res) {
                            if(res.success && res.html){
                                $('#model-trumb-pane').trumbowyg('execCmd', {
                                    cmd: 'insertHTML',
                                    param: res.html,
                                    forceCss: false,
                                });
                            } else
                                notification(res.message, 2);
                        },
                        error: function(err) {
                            notification("Sorry, You have an error!", 2);
                        }
                    });
                } else if($(this).html() == "#Training_Evaluation_details_bloc"){
                    $.ajax({
                        url: 'getBlockHTML',
                        method: 'post',
                        data: {name: "training_evaluation_details"},
                        success: function(res) {
                            if(res.success && res.html){
                                $('#model-trumb-pane').trumbowyg('execCmd', {
                                    cmd: 'insertHTML',
                                    param: res.html,
                                    forceCss: false,
                                });
                            } else
                                notification(res.message, 2);
                        },
                        error: function(err) {
                            notification("Sorry, You have an error!", 2);
                        }
                    });
                } else if($(this).html() == "#Training_Complete_Evaluation_details_bloc"){
                    $.ajax({
                        url: 'getBlockHTML',
                        method: 'post',
                        data: {name: "training_complete_evaluation"},
                        success: function(res) {
                            if(res.success && res.html){
                                $('#model-trumb-pane').trumbowyg('execCmd', {
                                    cmd: 'insertHTML',
                                    param: res.html,
                                    forceCss: false,
                                });
                            } else
                                notification(res.message, 2);
                        },
                        error: function(err) {
                            notification("Sorry, You have an error!", 2);
                        }
                    });
                } else if($(this).html() == "#Signature_bloc"){
                    $.ajax({
                        url: 'getBlockHTML',
                        method: 'post',
                        data: {name: "signature_bloc"},
                        success: function(res) {
                            if(res.success && res.html){
                                $('#model-trumb-pane').trumbowyg('execCmd', {
                                    cmd: 'insertHTML',
                                    param: res.html,
                                    forceCss: false,
                                });
                            } else
                                notification(res.message, 2);
                        },
                        error: function(err) {
                            notification("Sorry, You have an error!", 2);
                        }
                    });
                } else {
                    $('#model-trumb-pane').trumbowyg('execCmd', {
                        cmd: 'insertText',
                        param: $(this).html(),
                        forceCss: false,
                    });
                }

                $(this).removeClass("active");
            }
        })
    });

    $('#model-trumb-pane').trumbowyg().on('tbwchange', () => {
        trumbowygChanged ++;
        console.log(trumbowygChanged);
    });
});

var notification = function(str, type) {
    switch (type) {
        case 1:
            Dashmix.helpers('notify', {
                type: 'info',
                icon: 'fa fa-info-circle mr-1',
                message: str
            });
            break;

        case 2:
            Dashmix.helpers('notify', {
                type: 'danger',
                icon: 'fa fa-times mr-1',
                message: str
            });
            break;

        default:
            break;
    }

};

function toggleActive(e){
    $(".model-drag-item").each(function() {
        if(e != this)
            $(this).removeClass('active');
        else
            $(this).toggleClass('active');
    });
}

var trumbowygChanged = -1;
var modelSelectedId = -1;

function alertChanged(){
    return new Promise((resolve, reject) => {
        swal.fire({
            title: "Warning",
            html: "You have unsaved model contents. <br> Continue?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: `Yes`,
            cancelButtonText: `No`,
        })
        .then(( result ) => {
            if ( result.value )
                resolve(true);
            else
                resolve(false);
        });
    })
}

async function editTemplate(id){
    if(trumbowygChanged >= 1){
        if(await alertChanged() == false)
            return;
    }

    $.ajax({
        url: 'getTemplateData',
        method: 'post',
        data: {id: id},
        success: function(res) {
            if(res.success){
                trumbowygChanged = -1;
                modelSelectedId = id;
                $('#model-name').val(res.name);
                $('#model-trumb-pane').trumbowyg('html', res.data);
            } else
                notification(res.message, 2);
        },
        error: function(err) {
            notification("Sorry, You have an error!", 2);
        }
    });
}

function saveTemplate(){
    if($("#model-name").val() == ''){
        swal.fire({ title: "Warning", text: "Please input the model name.", icon: "info", confirmButtonText: `OK` });
        return;
    }

    $.ajax({
        url: 'saveTemplateData',
        method: 'post',
        data: {id: modelSelectedId, data: $('#model-trumb-pane').trumbowyg('html'), name: $("#model-name").val()},
        success: function(res) {
            if(res.success){
                if(modelSelectedId == -1){
                    $("#model-item-list").append('<div class="model-item" id="model-item-' + res.id + '">' + 
                        '<div>' + 
                            '<i class="fa fa-circle mr-4" style="color: green;"></i>' + 
                            '<span id="model-title-' + res.id + '">' + $("#model-name").val() + '</span>' + 
                        '</div>' + 
                        '<div>' + 
                            '<i class="fa fa-edit mr-4 actionBtn" onclick="editTemplate(' + res.id + ')"></i>' + 
                            '<i class="fa fa-trash mr-3 dangerBtn" onclick="delTemplate(' + res.id + ')"></i>' +
                        '</div>' + 
                    '</div>');
                } else
                    $("#model-title-" + modelSelectedId).html($("#model-name").val());
                notification("Successfully saved.", 1);
                trumbowygChanged = 0;
            } else
                notification("Sorry, You have an error!", 2);
        },
        error: function(err) {
            notification("Sorry, You have an error!", 2);
        }
    });
}

async function addTemplate(){
    if(trumbowygChanged >= 1){
        if(await alertChanged() == false)
            return;
    }

    modelSelectedId = -1;
    trumbowygChanged = -1;
    $('#model-name').val('');
    $('#model-trumb-pane').trumbowyg('html', '');
}

function delTemplate(id){
    swal.fire({
        title: "Warning",
        html: "Are you sure delete this template?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: `Yes`,
        cancelButtonText: `No`,
    })
    .then(( result ) => {
        if ( result.value ){
            $.ajax({
                url: 'delTemplate',
                method: 'post',
                data: {id: id},
                success: function(res) {
                    if(res.success){
                        notification('Successfully deleted.', 1);
                        $('#model-item-' + id).remove();
                        if(modelSelectedId == id){
                            modelSelectedId = -1;
                            trumbowygChanged = -1;
                            $("#model-name").val('');
                            $('#model-trumb-pane').trumbowyg('html', '');
                        }
                    } else
                        notification(res.message, 2);
                },
                error: function(err) {
                    notification("Sorry, You have an error!", 2);
                }
            });
        }
    });
}

async function cancelTemplate(){
    if(trumbowygChanged >= 1){
        if(await alertChanged() == false)
            return;
    }

    modelSelectedId = -1;
    trumbowygChanged = -1;
    $('#model-name').val('');
    $('#model-trumb-pane').trumbowyg('html', '');
}

</script>
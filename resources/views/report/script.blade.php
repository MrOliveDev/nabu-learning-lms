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

    $("#model-trumb-pane").trumbowyg({
        plugins: {
          resizimg: {
              minSize: 64,
              step: 16,
          }
        },
    });

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
                if($(this).html() == "#Header"){
                    $.ajax({
                        url: 'getBlockHTML',
                        method: 'post',
                        data: {name: "header"},
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
                } else if($(this).html() == "#Training_Synthetic_details_bloc"){
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
                } else if($(this).html() == "#Footer"){
                    $.ajax({
                        url: 'getBlockHTML',
                        method: 'post',
                        data: {name: "footer"},
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
                } else if($(this).is('img')){
                    if($(this).attr('src') != ''){
                        $('#model-trumb-pane').trumbowyg('execCmd', {
                            cmd: 'insertImage',
                            param: $(this).attr('src'),
                            forceCss: false,
                            skipTrumbowyg: true
                        });
                    }
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
    });

    $("#type-filter").on('keyup', function(){
        $(".doc-type-item").each(function(){
            let html = $(this).children('span').html();
            if(html && html.includes($("#type-filter").val())){
                $(this).css("display", "flex");
            } else
                $(this).css("display", "none");
        });
    });

    $(".session-filter").on('keyup', function(){
        $(".session-item").each(function(){
            let sessionName = $(this).children()[0].innerHTML;
            let sessionDate = $(this).children()[1].innerHTML;
            if((sessionName && sessionName.includes($(".session-filter").val())) || (sessionDate && sessionDate.includes($(".session-filter").val()))){
                $(this).css("display", "table-row");
            } else
                $(this).css("display", "none");
        });
    });

    $(".learner-filter").on('keyup', function(){
        $(".learner-item").each(function(){
            let html = $(this).children()[0].innerHTML;
            if(html && html.includes($(".learner-filter").val())){
                $(this).css("display", "table-row");
            } else
                $(this).css("display", "none");
        });
    })
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
                    $("#doc-type-list").append('<div class="doc-type-item" onclick="selectModel(' + res.id + ')" id="doc-type-item-' + res.id + '">' + 
                            '<span>' + res.name + '</span>' + 
                            '<i class="fa fa-edit"></i>' + 
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

var curModel = 0, curSession = 0, curStudent = 0;
function selectModel(templateId){
    curModel = templateId;
    $(".doc-type-item").each(function(){
        $(this).removeClass("active");
    });
    $("#doc-type-item-" + templateId).addClass("active");
    if(curModel && curSession && curStudent){
        overviewReport(curStudent);
    }
}

function selectSession(sessionId){
    curSession = sessionId;
    $(".session-item").each(function(){
        $(this).removeClass("active");
    });
    $("#session-" + sessionId).addClass("active");
    $("#studentsList").html('');
    swal.fire({ title: "Please wait...", showConfirmButton: false });
    swal.showLoading();
    $.ajax({
        url: 'getStudentsList',
        method: 'post',
        data: {sessionId: sessionId},
        success: function(res) {
            swal.close();
            if(res.success && res.students){
                res.students.forEach(student => {
                    $("#studentsList").append('<tr class="learner-item">' + 
                                '<td class="font-w600 learnerName">' + student.first_name + ' ' + student.last_name + '</td>' + 
                                '<td class="font-w600 text-center learnerAction" onclick="downloadReport(' + student.id + ')"><i class="fa fa-download"></i></td>' + 
                                '<td class="font-w600 text-center learnerAction" onclick="overviewReport(' + student.id + ')">Overview <i class="fa fa-eye"></i></td>' + 
                            '</tr>');
                });
                $("#studentsPane").css("height", "150px");
            } else
                notification(res.message, 2);
        },
        error: function(err) {
            swal.close();
            notification("Sorry, You have an error!", 2);
        }
    });
}

function getReportData(){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'getReportData',
            method: 'post',
            data: {sessionId: curSession, studentId: curStudent},
            success: function(res) {
                if(res.success){
                    resolve(res.data);
                } else{
                    notification(res.message, 2);
                    resolve(null);
                }
            },
            error: function(err) {
                notification("Sorry, You have an error!", 2);
                resolve(null);
            }
        });
    })
}

function getTemplateData(){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'getTemplateData',
            method: 'post',
            data: {id: curModel},
            success: function(res) {
                if(res.success){
                    resolve(res.data);
                } else{
                    notification(res.message, 2);
                    resolve(null);
                }
            },
            error: function(err) {
                notification("Sorry, You have an error!", 2);
                resolve(null);
            }
        });
    })
}

async function overviewReport(studentId){
    curStudent = studentId;
    if(!curModel){
        swal.fire({ title: "Warning", text: "Please select document type.", icon: "info", confirmButtonText: `OK` });
        return;
    }
    if(!curSession){
        swal.fire({ title: "Warning", text: "Please select session.", icon: "info", confirmButtonText: `OK` });
        return;
    }

    swal.fire({ title: "Please wait...", showConfirmButton: false });
    swal.showLoading();

    var info = await getReportData();
    var template = await getTemplateData();
    console.log(info, template);
}

</script>
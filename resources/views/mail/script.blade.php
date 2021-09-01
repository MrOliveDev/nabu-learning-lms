<script>
$(document).ready(function(){
    $("#MailPanel").tabs({ active: "{{ $activeTab }}" });

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
        semantic: {
            'div': 'div'
        }
    });

    $("#overviewPane").trumbowyg({
        plugins: {
          resizimg: {
              minSize: 64,
              step: 16,
          }
        },
        semantic: {
            'div': 'div'
        }
    });

    var table = $('#historic-table').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "orderCellsTop": true,
        "pageLength" : 50,
        "ajax":{
                "url": "{{ url('getMailHistories') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{csrf_token()}}"}
            },
        "columns": [
            { "data": "sender" },
            { "data": "model" },
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
            "targets": 4,
            "orderable": false
        } ]
    });

    $("#model-trumb-pane").on("click", function(){
        $(".model-drag-item").each(function() {
            if($(this).hasClass("active")){
                $('#model-trumb-pane').trumbowyg('execCmd', {
                    cmd: 'insertText',
                    param: $(this).html(),
                    forceCss: false,
                });

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

    $(".user-filter").on('keyup', function(){
        $(".user-item").each(function(){
            let html = $(this).children()[1].innerHTML;
            if(html && html.includes($(".user-filter").val())){
                $(this).css("display", "table-row");
            } else
                $(this).css("display", "none");
        });
    });

    $("#sendcheck_all").on('click', function(){
        if($(this)[0].checked)
            $(".sendcheck").prop('checked', true);
        else
            $(".sendcheck").prop('checked', false);
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
        url: 'getMailTemplate',
        method: 'post',
        data: {id: id},
        success: function(res) {
            if(res.success){
                trumbowygChanged = -1;
                modelSelectedId = id;
                $('#model-name').val(res.name);
                $('#mail-subject').val(res.subject);
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
    if($("#mail-subject").val() == ''){
        swal.fire({ title: "Warning", text: "Please input the subject.", icon: "info", confirmButtonText: `OK` });
        return;
    }

    $.ajax({
        url: 'saveMailTemplate',
        method: 'post',
        data: {id: modelSelectedId, data: $('#model-trumb-pane').trumbowyg('html'), name: $("#model-name").val(), subject: $("#mail-subject").val()},
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
                            '<span id="doc-type-item-title-' + res.id + '">' + $("#model-name").val() + '</span>' + 
                        '</div>');
                } else{
                    $("#model-title-" + modelSelectedId).html($("#model-name").val());
                    $("#doc-type-item-title-" + modelSelectedId).html($("#model-name").val());
                }   
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
    $('#mail-subject').val('');
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
                url: 'delMailTemplate',
                method: 'post',
                data: {id: id},
                success: function(res) {
                    if(res.success){
                        notification('Successfully deleted.', 1);
                        $('#model-item-' + id).remove();
                        $('#doc-type-item-' + id).remove();
                        if(modelSelectedId == id){
                            modelSelectedId = -1;
                            trumbowygChanged = -1;
                            $("#model-name").val('');
                            $("#mail-subject").val('');
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
    $('#mail-subject').val('');
    $('#model-trumb-pane').trumbowyg('html', '');
}

var curModel = 0, curUser = 0;
async function selectModel(templateId){
    curModel = templateId;
    $(".doc-type-item").each(function(){
        $(this).removeClass("active");
    });
    $("#doc-type-item-" + templateId).addClass("active");
    if(curModel && curUser){
        previewMail(curUser);
    } else if(curModel) {
        var data = await getTemplateData();
        var template = data.data;

        $('#overviewPane').trumbowyg('html', template);
    }
}

function getTemplateData(){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'getMailTemplate',
            method: 'post',
            data: {id: curModel},
            success: function(res) {
                if(res.success){
                    resolve(res);
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

function getUserInfo(userId = null){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'getUserInfo',
            method: 'post',
            data: {id: (userId ? userId : curUser)},
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

// async function overviewMail(userId){
//     curUser = userId;
//     if(!curModel){
//         swal.fire({ title: "Warning", text: "Please select template type.", icon: "info", confirmButtonText: `OK` });
//         return;
//     }

//     swal.fire({ title: "Please wait...", showConfirmButton: false });
//     swal.showLoading();

//     var template = await getTemplateData(true);
//     if(template == null){
//         swal.fire({ title: "Warning", text: "Error while getting template data.", icon: "error", confirmButtonText: `OK` });
//         return;
//     }

//     var info = await getUserInfo();
//     if(info == null){
//         swal.fire({ title: "Warning", text: "Error while getting user info.", icon: "error", confirmButtonText: `OK` });
//         return;
//     }
    
//     if(info && info.contact_info){
//         let contact;
//         try {
//             contact = JSON.parse(info.contact_info);
//         } catch(e) {
//             console.log(e);
//             $("#to-address").val('');
//         }
        
//         if(contact && contact.email)
//             $("#to-address").val(contact.email);
//         else
//             $("#to-address").val('');
//     } else
//         $("#to-address").val('');
    
//     if(template.includes('#last_name')){
//         if(info && info.last_name)
//             template = template.split('#last_name').join(info.last_name);
//         else
//             template = template.split('#last_name').join('');
//     }
//     if(template.includes('#first_name')){
//         if(info && info.last_name)
//             template = template.split('#first_name').join(info.first_name);
//         else
//             template = template.split('#first_name').join('');
//     }
//     if(template.includes('#password')){
//         template = template.split('#password').join('XXXXXXXX');
//     }
//     if(template.includes('#username')){
//         if(info && info.login)
//             template = template.split('#username').join(info.login);
//         else
//             template = template.split('#username').join('');
//     }

//     $('#overviewPane').trumbowyg('html', template);

//     swal.close();
// }

async function previewMail(userId){
    curUser = userId;
    if(!curModel){
        swal.fire({ title: "Warning", text: "Please select template type.", icon: "info", confirmButtonText: `OK` });
        return;
    }

    swal.fire({ title: "Please wait...", showConfirmButton: false });
    swal.showLoading();

    var data = await getTemplateData();
    var template = data.data;

    if(template == null){
        swal.fire({ title: "Warning", text: "Error while getting template data.", icon: "error", confirmButtonText: `OK` });
        return;
    }
    $("#send-subject").val(data.subject);

    var info = await getUserInfo();
    if(info == null){
        swal.fire({ title: "Warning", text: "Error while getting user info.", icon: "error", confirmButtonText: `OK` });
        return;
    }
    
    var contact;
    if(info && info.contact_info){
        try {
            contact = JSON.parse(info.contact_info);
        } catch(e) {
            console.log(e);
            $("#to-address").val('');
        }

        if(contact && contact.email)
            $("#to-address").val(contact.email);
        else{
            $("#to-address").val('');
            swal.fire({ title: "Warning", text: "Cannot find user mail.", icon: "error", confirmButtonText: `OK` });
        }
    } else{
        $("#to-address").val('');
        swal.fire({ title: "Warning", text: "Cannot find user mail.", icon: "error", confirmButtonText: `OK` });
    }

    if(template.includes('#last_name')){
        if(info && info.last_name)
            template = template.split('#last_name').join(info.last_name);
        else
            template = template.split('#last_name').join('');
    }
    if(template.includes('#first_name')){
        if(info && info.last_name)
            template = template.split('#first_name').join(info.first_name);
        else
            template = template.split('#first_name').join('');
    }
    if(template.includes('#username')){
        if(info && info.login)
            template = template.split('#username').join(info.login);
        else
            template = template.split('#username').join('');
    }
    // if(template.includes('#password')){
    //     template = template.split('#password').join('########');
    // }

    $('#overviewPane').trumbowyg('html', template);

    swal.close();
}

function sendNow(){
    if($("#from-address").val() == ""){
        swal.fire({ title: "Warning", text: "From Address cannot be empty.", icon: "error", confirmButtonText: `OK` });
        return;
    }
    if($("#to-address").val() == ""){
        swal.fire({ title: "Warning", text: "To Address cannot be empty.", icon: "error", confirmButtonText: `OK` });
        return;
    }
    if($("#send-subject").val() == ""){
        swal.fire({ title: "Warning", text: "Mail Subject cannot be empty.", icon: "error", confirmButtonText: `OK` });
        return;
    }

    swal.fire({ title: "Please wait...", showConfirmButton: false });
    swal.showLoading();

    $.ajax({
        url: 'mailsend',
        method: 'post',
        data: {from: $("#from-address").val(), to: $("#to-address").val(), subject: $("#send-subject").val(), content: $("#overviewPane").trumbowyg('html'), userId: curUser},
        success: function(res) {
            if(res.success){
                notification("Successfully sent!", 1);
                insertHistory($("#process").val(), $("#to-address").val() + ' -------- Success\n');
            } else{
                notification(res.message, 2);
                insertHistory($("#process").val(), $("#to-address").val() + ' -------- Error(' + res.message + ')\n');
            }
            swal.close();
        },
        error: function(err) {
            notification("Sorry, You have an error!", 2);
            swal.close();
            insertHistory($("#process").val(), $("#to-address").val() + ' -------- Error(API Failed)\n');
        }
    });
    
}

function mailsend(from, to, subject, content, userId){
    return new Promise((resolve, reject) => {
        $.ajax({
            url: 'mailsend',
            method: 'post',
            data: {from: from, to: to, subject: subject, content: content, userId: userId},
            success: function(res) {
                if(res.success){
                    resolve('Success');
                } else{
                    let msg = 'Error(' + res.message + ')';
                    resolve(msg);
                }
            },
            error: function(err) {
                resolve("Error(API Failed)");
            }
        });   
    })
}

async function sendToAll(){
    $(document).ajaxStart(function() { $('body').waitMe("hide"); });

    if(!curModel){
        swal.fire({ title: "Warning", text: "Please select template type.", icon: "info", confirmButtonText: `OK` });
        return;
    }
    
    var ids = [];
    $(".sendcheck").each(function(){
        if($(this)[0].checked){
            ids.push($(this).attr('id').split('sendcheck_').join(''));
        }
    });
    if(ids.length == 0){
        swal.fire({ title: "Warning", text: "Please select students.", icon: "info", confirmButtonText: `OK` });
        return;
    }

    swal.fire({ title: "Please wait...", showConfirmButton: false });
    swal.showLoading();

    var data = await getTemplateData();
    var template = data.data;

    if(template == null){
        swal.fire({ title: "Warning", text: "Error while getting template data.", icon: "error", confirmButtonText: `OK` });
        return;
    }
    if($("#from-address").val() == ""){
        swal.fire({ title: "Warning", text: "From Address cannot be empty.", icon: "error", confirmButtonText: `OK` });
        return;
    }

    swal.close();

    $("#statusNotes").val('');
    $("#statusNumbers").html(`0 / ${ids.length}`);
    $("#progressModal").modal({ backdrop: 'static', keyboard: false });
    for(let i = 0; i < ids.length; i ++){
        $("#statusNotes").val($("#statusNotes").val() + $("#user-name-" + ids[i]).html());
        var info = await getUserInfo(ids[i]);
        var content = template;
        if(info == null){
            swal.fire({ title: "Warning", text: "Error while getting user info.", icon: "error", confirmButtonText: `OK` });
            return;
        }
        
        var contact;
        if(info && info.contact_info){
            try {
                contact = JSON.parse(info.contact_info);
            } catch(e) {
                console.log(e);
            }

            if(!contact || !contact.email){
                $("#statusNotes").val($("#statusNotes").val() + ' -------- Error(No Email)\n');
                break;
            } else
                $("#statusNotes").val($("#statusNotes").val() + `(${contact.email}) -------- `);
        } else {
            $("#statusNotes").val($("#statusNotes").val() + ' -------- Error(No Contact Info)\n');
            break;
        }
        
        if(content.includes('#last_name')){
            if(info && info.last_name)
                content = content.split('#last_name').join(info.last_name);
            else
                content = content.split('#last_name').join('');
        }
        if(content.includes('#first_name')){
            if(info && info.last_name)
                content = content.split('#first_name').join(info.first_name);
            else
                content = content.split('#first_name').join('');
        }
        if(content.includes('#username')){
            if(info && info.login)
                content = content.split('#username').join(info.login);
            else
                content = content.split('#username').join('');
        }

        var status = await mailsend($("#from-address").val(), contact.email, data.subject, content, ids[i]);
        $("#statusNotes").val($("#statusNotes").val() + `${status}\n`);

        $("#statusNumbers").html(`${i + 1} / ${ids.length}`);
    }

    insertHistory($("#process").val(), $("#statusNotes").val());
    swal.fire({ title: "All done.", text: "Sending mails finished.", icon: "success", confirmButtonText: `OK` });

    $(document)
        .ajaxStart(function() {
            $('body').waitMe({
                effect: 'bounce',
                text: 'Loading...',
                bg: 'rgba(255, 255, 255, 0.7)',
                color: '#000'
            });
        })
        .ajaxStop(function() {
            $('body').waitMe("hide");
        });
}

function insertHistory(process, result){
    $.ajax({
        url: 'insertMailHistory',
        method: 'post',
        data: {from: $("#from-address").val(), model: curModel, process: process, result: result.split('\n')},
        success: function(res) {
            $('#historic-table').DataTable().ajax.reload();
        },
        error: function(err) {
            $('#historic-table').DataTable().ajax.reload();
        }
    });
}

function delHistory(id){
    swal.fire({
        title: "Warning",
        html: "Are you sure delete this history?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: `Yes`,
        cancelButtonText: `No`,
    })
    .then(( result ) => {
        if ( result.value ){
            $.ajax({
                url: 'delMailHistory',
                method: 'post',
                data: {id: id},
                success: function(res) {
                    if(res.success){
                        notification('Successfully deleted.', 1);
                        $('#historic-table').DataTable().ajax.reload();
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

</script>
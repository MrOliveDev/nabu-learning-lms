
// var baseURL = window.location.protocol + "//" + window.location.host + '/newlms';
var baseURL = window.location.protocol + "//" + window.location.host;

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

var itemClick = function(event) {
    event.preventDefault();
    $(this).parents(".row").find(".list-group-item").toggleClass("active", false);
    $(this).toggleClass('active');
    $(this).parents(".row").find(".col-md-3").empty();
    var element = $(event.target);
    switch ($(this).attr("data-type")) {
        case "3":
        case "4":
            $.get({url:baseURL+"/user/"+$(this).attr('id').split('_')[1],
                success:function(data){
                    var userCard = createUserCard(data);
                    element.parents(".row").find(".col-md-3").append(userCard);
                },
                error:function(err){
                    notification("You have error getting user data.", 2);
                }
                });
            break;
        case "training":
            $.get({url:baseURL+"/training/"+$(this).attr('id').split('_')[1],
                success:function(data){
                    var trainingCard = createTrainingCard(data);
                    element.parents(".row").find(".col-md-3").append(trainingCard);
                },
                error:function(err){
                    notification("You have error getting training data.", 2);
                }
                });
            break;
    
        default:
            break;
    }
}

var editUser = function(e) {
    e.preventDefault();
    var parentId = $(this).parents('.list-group-item').attr('id');
    $.post({url:baseURL+"/setSessionForUserPage", data:{"data":parentId}}).then(function(data){
        window.open(baseURL+"/student");
    }).fail(function(err){
        notification("You have an error going to user page.", 2);
    })
}

var detachLinkTo = function(item) {
    var parent = item.parents('.list-group-item');
    var isSubItem = parent.attr('data-sub');
    if (isSubItem) {
        var showeditem = parent.parents('.list-group div.d-flex').attr('data-src');
    } else {
        var showeditem = parent.attr('data-src');
    }
    var id = parent.attr('id').split('_')[1];
    var cate = parent.attr('id').split('_')[0],
        sendCate;
    var participantData = $('#session_' + showeditem).attr('data-participant');
    var participant = participantData ? JSON.parse(participantData) : {
        "s": [],
        "t": [],
        "g": []
    };
    var contentData = $('#session_' + showeditem).attr('data-content');
    var content = contentData ? JSON.parse(contentData) : [];


    switch (cate) {
        case 'training':
            content = "";
            $('#session_' + showeditem).attr('data-content', content);
            sendCate = 'content';
            break;
        case 'group':
            var group = participant.g;
            participant.g = group.filter(function(groupItem) {
                return groupItem.value != parseInt(id);
            });
            $('#session_' + showeditem).attr('data-participant', JSON.stringify(participant));
            sendCate = 'participant';
            break;
        case 'student':
            var student = participant.s;
            participant.s = student.filter(function(studentItem) {
                return studentItem != parseInt(id);
            });
            sendCate = 'participant';
            $('#session_' + showeditem).attr('data-participant', JSON.stringify(participant));
            break;
        case 'teacher':
            var teacher = participant.t;
            participant.t = teacher.filter(function(teacherItem) {
                return teacherItem != parseInt(id);
            });
            sendCate = 'participant';
            $('#session_' + showeditem).attr('data-participant', JSON.stringify(participant));
            break;
        default:
            break;
    }
    detachCall({
        id: showeditem,
        participant: JSON.stringify(participant),
        content: content,
        cate: sendCate
    }, $(item));
};

var combine = function(value, id) {
    var combineArray = value.split('_').filter(function(item, i, d) {
        return item != id && item != null;
    });
    console.log(combineArray);
    return combineArray;
};

var detachCall = function(connectiondata, element) {
    $.post({
        url: baseURL + '/sessionjointo',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: connectiondata
    }).then(function(data) {
        notification('Successfully unliked!', 1);

        if (element.parents('.list-group-item').next().is('div.d-flex')) {
            element.parents('.list-group-item').next().detach();
        }
        element.parents('.list-group-item').detach();
        return true;
    }).fail(function(err) {
        notification("Sorry, Your action brocken!", 2);
        return false;
    }).always(function(data) {
        console.log(data);
    });
};

var disconnect = function(event) {
    var e = Swal.mixin({
        buttonsStyling: !1,
        customClass: {
            confirmButton: 'btn btn-success m-1',
            cancelButton: 'btn btn-danger m-1',
            input: 'form-control'
        }
    });
    e.fire({
        title: 'Are you sure you want to disconnect this item ?',
        text: ' This item will be disconnected',
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
                    e();
                    detachLinkTo($(event.target));
                }), 50);
            }));
        }
    }).then((function(n) {
        if (n.value) {
            e.fire('Deleted!', 'This item is disconnected.', 'success');
            console.log();
        } else {
            'cancel' === n.dismiss && e.fire('Cancelled', 'Your data is safe :)', 'error');
        }
    }));


};

var sessionItemClick = function(e) {
    var activeTr = $(this).is(".active");
    $(".session-table").find('.session-title').toggleClass("active", false);
    $(this).toggleClass("active", !activeTr);
    if($(this).is(".active")){
        $('.session-table .list-group-item').detach();

        var id = $(this).attr('id').split('_')[1];
        $.get({
            url: baseURL+'/admindash_getdata/'+id,
            success: function(data, state) {
                $("#session_"+id).attr("data-participant", data.session_info.participants);
                $("#session_"+id).attr("data-content", parseInt(data.session_info.contents));
                notification('We got session data successfully!', 1);
                if (data.contents) {
                    if (data.contents != null && Object.keys(data.contents).length != 0) {
                        var newItem = createContentItem(data.contents[0]);
                        newItem.attr('data-src', id);
                        $('#table-training_'+id+' .list-group').append(newItem);
                    }
                }

                if (data.participants) {
                    if (data.participants.group) {
                        data.participants.group.map(function(participant_item) {
                            if (participant_item) {
                                var newItem = createGroupItem(participant_item);
                                newItem.attr('data-src', id);
                                $('#table-participant_'+id+' .list-group').append(newItem);
                                $(newItem[1]).find(".list-group-item").toggle(false);
                            }
                        });
                    }
                    if (data.participants.student) {
                        data.participants.student.map(function(participant_item) {
                            if (participant_item) {
                                var newItem = createUserItem(participant_item);
                                newItem.attr('data-src', id);
                                $('#table-participant_'+id+' .list-group').append(newItem);
                            }
                        });
                    }
                    if (data.participants.teacher) {
                        data.participants.teacher.map(function(participant_item) {
                            if (participant_item) {
                                var newItem = createUserItem(participant_item);
                                newItem.attr('data-src', id);
                                $('#table-participant_'+id+' .list-group').append(newItem);
                            }
                        });
                    }
                    if (data.reports) {
                        data.reports.map(function(report_item) {
                            if (report_item) {
                                var newItem = createReportItem(report_item);
                                newItem.attr('data-src', id);
                                $('#table-report_'+id+' .list-group').append(newItem);
                            }
                        });
                    }
                }
                $("tr.session-content.session-"+id).find("a.nav-link:first").click();
            },
            error: function(err) {
                notification("Sorry, You can't get session data!", 2);
            }
        });
    }
};

var createUserItem = function(data) {
    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var element = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x ' + (data.type == 4 ? "student_" + data.id : "teacher_" + data.id) + '" id="' + (data.type == 4 ? "student_" + data.id : "teacher_" + data.id) + '_copy" data-type = "' + data.type + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.first_name + '&nbsp;' + data.last_name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.first_name + data.last_name + '">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        //         '<span class=" p-2 font-weight-bolder item-lang">'+ data.lang+
        //         '</span>' +
        '</div>' +
        '</a>');
        if(data.type == 4) {
            var progressComp = $('<span class = "p-1"><i class="fa fa-chart-line px-2"></i>'+data.progress+'%</span>');
            var evalComp = $('<span class = "p-1"><i class="fa fa-chart-line fa fa-check-circle px-2"></i>'+data.eval+'%</span>');
            
            if (data.progress==100) {
                progressComp.addClass('text-success');
            } else if (data.progress<70&&data.progress>=50) {
                progressComp.addClass('text-info');
            } else if (data.progress<50&&data.progress>=20) {
                progressComp.addClass('text-warning');
            } else {
                progressComp.addClass('text-danger');
            }

            if (data.eval==100) {
                evalComp.addClass('text-success');
            } else if (data.eval<70&&data.eval>=50) {
                evalComp.addClass('text-info');
            } else if (data.eval<50&&data.eval>=20) {
                evalComp.addClass('text-warning');
            } else {
                evalComp.addClass('text-danger');
            }
            
            element.find('.btn-group').append(progressComp);
            element.find('.btn-group').append(evalComp);

        }
    var unlinkbtn = $('<button class="btn toggle1-btn unlink-btn text-white"><i class="px-2 fas fa-unlink"></i></button>').on('click', disconnect);
    
    var editbtn = $('<button class="btn item-edit text-white" data-content=""'+ data.id + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>');
        editbtn.click(editUser);
    element.find('.btn-group').append(editbtn);
    element.find('.btn-group').append(unlinkbtn);
    $(element).click(itemClick);
    return $(element);
};

var createGroupItem = function(data) {
    var status_temp = data.value.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var element = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x group_' + data.value.id + '" id="group_' + data.value.id + '_copy" data-type="group">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.value.name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.value.name + '">' +
        '</div>' +
        '<div class="btn-group p-1 float-right">' +
        '</div>' +
        '</a>' +
        '<div class="group_' + data.value.id + ' d-flex flex-column p-0 pl-4"></div>');
    unlinkbtn = $('<button class="btn toggle1-btn text-white"><i class="px-2 fas fa-unlink"></i></button>').on('click', disconnect);
    openbtn = $('<button class="btn text-white"><i class="px-2 fas fa-angle-down"></i></button>').on('click', function(e) {
        $(this).parents('.list-group-item').next('div.d-flex').find('.list-group-item').fadeToggle();
    });

    element.find('.btn-group').append(unlinkbtn);
    element.find('.btn-group').append(openbtn);
    data.items.map(function(userItem) {
        if (userItem.type == 4) {
            var userElem = createUserItem(userItem);
            userElem.attr('data-sub', data.value.id);
            userElem.find('.unlink-btn').detach();
            $(element[1]).append(userElem);
        }
    });
    $(element[0]).click(itemClick);
    return element;
};

var createContentItem = function(data) {
    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var element = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x training_' + data.id + '" id="training_' + data.id + '_copy" data-type="training" id="training_'+data.id+'">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.name + '">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        //     '<span class=" p-2 font-weight-bolder  item-lang">' +
        //     '</span>' +
        '</div>' +
        '</a>');
    unlinkbtn = $('<button class="btn toggle1-btn text-white"><i class="px-2 fas fa-unlink"></i></button>').on('click', disconnect);
    element.find('.btn-group').append(unlinkbtn);
    element.click(itemClick);
    return element;
}

var createReportItem = function(data) {
    var element = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x report_' + data.id + '" id="report_' + data.id + '_copy" data-type="report">' +
        '<div class="float-left">' +
        '<span class="item-name">' + data.filename + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.filename + '">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '</div>' +
        '</a>');
    return element;
}

var createUserCard = function(data){
    var contact = data.contact_info;
    var email = contact?contact.email:"";
    var address = contact?contact.address:"";
    var userCard = $('<div class="card w-100 text-left bg-white" id="menu1">'+
    '<div class="card-body border-0">'+
    '<div class="border-0">'+
    '<img src='+(data.user_info.interface_icon?data.user_info.interface_icon:'"public/assets/media/user.jpg"')+' alt="" class="rounded-circle w-100">'+
    '<i class="fa fa-alpha align-text-bottom"></i>'+
    '</div>'+
    '<div class="p-4 border-0">'+
    '<p>'+
    '<span>'+
    '<b>Address : '+
    '</b>'+address+
    ''+
    '</span>'+
    '</p>'+
    '<p>'+
    '<span>'+
    '<b>E-mail : '+
    '</b>'+ email +
    ''+
    '</span>'+
    '</p>'+
    '<p><span class=""><b>Company : </b>'+(data.user_info.comany?data.user_info.company:"")+'</span></p>'+
    '<p><span><b>Status : </b>'+(data.user_info.status==1?"Online":"Offline")+'</span></p>'+
    '<div class="border-0 ">'+
    (data.reports?
    '<p class="text-wrap mb-3"><i class="fas fa-file-pdf font-size-h1 text-pink-2 pr-2"></i>'+
    data.reports.filename+
    '</p>':
    '<p class="text-wrap mb-3"><i class="far fa-file-pdf font-size-h1 text-second pr-2"></i>'+
    'Reports</p>')+
    '</div>'+
    '</div>'+
    '</div>'+
    '</div>');
    return userCard;
}

var createTrainingCard = function(data){
    var trainingCard = '<div class="card w-100 text-left bg-white">'+
    '<img src="'+(data.training_icon?data.training_icon:"/assets/media/17.jpg")+'" alt="" class="card-img-top">'+
    '<div class="card-body border-0">'+
    '<p>'+
    '<span>'+
    '<strong>Description : <strong>'+
    data.description+
    '</span>'+
    '</p>'+
    '<p><span>'+
    '<b>'+
    'Duration : '+
    '</b>'+data.duration+
    '</span></p>'+
    '</div>'+
    '</div>';
    return trainingCard;
}

var searchfilter = function(e){
    var value = $(e.target).val();
    var activeTabSelector = $(e.target).parents("tr.session-content").find(".ui-state-active a").attr("href");
    $(activeTabSelector).find(".list-group>.list-group-item").map(function(i, item){
        var item_name = $(item).find("input[name='item-name']").val();
        item_name.toLowerCase().indexOf(value.replace(/\s+/g, ''))==-1?$(item).css('display', "none"):$(item).css('display', "block");
    })
}

$(document).ready(function(){
    $("tr.session-title").click(sessionItemClick);
    $("tr.session-content").map(function(i, item){
        $(item).tabs();
    });
    // $(".nav-link").click(function(event){
    //     var avatarCard = $(this).parents(".row").find(".col-md-3");
    //     avatarCard.find(".card").toggle(false);
    //     if($(this).is(".table-participant-tab")){
    //         avatarCard.find('.user-avatar')
    //     } else if($(this).is(".table-training-tab")) {
            
    //     } else {

    //     }
    // });

    $(".search-filter").on('keydown keyup', searchfilter);
    $('.counter').each(function () {
        var $this = $(this);
        jQuery({ Counter: 0 }).animate({ Counter: $this.next(".store-value").val() }, {
          duration: 2000,
          easing: 'swing',
          step: function () {
            $this.html(Math.ceil(this.Counter));
          }
        });
    });
    
    $('.table-report>table').map(function(){
            $(this).DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "orderCellsTop": true,
            "pageLength" : 50,
            "ajax":{
                    "url": baseURL+"/getReportListBySession",
                    "dataType": "json",
                    "type": "POST",
                    "data":{
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            session_id:$(this).parents(".table-report").attr('id').split('_')[1]
                        }
                },
            "columns": [
                { "data": "session" },
                { "data": "student" },
                { "data": "filename" },
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
    });
});
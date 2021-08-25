var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));

var filteritem = null;
var grouptab = null,
    detailtags = null;
var detailtag1 = null;
var activedTab = '#students';

var window_level = 1;

var input_group_position = null,
    expired_date = $('#expired_date_input .input-group');

var heightToggleLeft = false;
var heightToggleRight = false;

var userDateSort = false,
    userNameSort = false,
    cateDateSort = false,
    cateNameSort = false,
    showDateSort = false,
    showNameSort = false;

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

var clearClassName = function(i, highlighted) {
    $(highlighted).find(".btn").each(function(index, btnelement) {
        $(btnelement).removeClass("active");
    });
    if ($(highlighted).hasClass('highlight')) {
        $(highlighted).removeClass('highlight');
    }
};

var itemDBClick = function() {
    $(this).parents('.list-group').children(".list-group-item").each(function(i, e) {
        if ($(e).hasClass("active")) {
            $(e).removeClass("active");
        }
    });
};


var rightItemClick = function(e) {
    var parent = $(event.target);
    if (!parent.is('.list-group-item')) {
        parent = $(event.target).parents('.list-group-item');
    }
    if (parent.is('.active')) {
        parent.removeClass('active');
    } else {
        parent.addClass('active');
    }

};

var btnClick = function(e) {
    if (!$(this).hasClass('toggle2-btn')) {
        e.stopPropagation();
        $(this).parents('.window').find('.list-group-item').each(clearClassName);
        $(this).parents('.list-group-item').addClass('highlight');

        if ($(this).parents('.window').find('.highlight').length != 0) {
            $(this).parents('.window').find('.highlight').each(function(i, e) {
                $(e).removeClass("highlight");
                $(e).find('.btn').each(function(i, item) {
                    $(item).removeClass('active');
                });
            });
        }
    } else {
        $(this).parents('.window').find('.list-group-item').each(clearClassName);
        $(this).parents('.list-group').children(".list-group-item").each(function(i, e) {
            if ($(e).hasClass("active")) {
                $(e).removeClass("active");
            }
        });
    }
    $(this).parents('.list-group').find('.btn.active').removeClass('active');
    $(this).addClass("active");
};

var clearTable = function(element) {
    element.each(function(i, em) {
        if ($(em).find('.list-group-item').length != 0) {
            $(em).find('.list-group-item').detach();
        }
    });
};

var clearFrom = function(element) {
    element.find('input, select').each(function(i, forminput) {
        if ($(forminput).attr('name') != '_token' && $(forminput).attr('name') != '_method') {
            $(forminput).val('');
        }
    });
};

var goTab = function(name) {
    $('#' + name + '-tab').click();
};

var emailBtn = function(event) {
    var item = $(event.target).closest(".btn");
    var id = item.attr("data-id");
    window.location.href = baseURL+"/sendemail?sessionId="+id;
}

var filterToggleShow = function(event) {
    var parent = $(this).parents('.toolkit');
    parent.children(".toolkit-filter").toggle();
    if (parent.attr('id') == 'cate-toolkit') {
        var leftActiveTab = $('#RightPanel .ui-state-active a').attr('href').split('#')[1];
        if ($('#table-content-tab').parents('li').is('.ui-state-active')) {
            parent.find('.filter-function-btn').toggle(false);
            parent.find('.filter-company-btn').toggle(false);
        } else if (leftActiveTab == 'students') {
            parent.find('.filter-function-btn').toggle(true);
        } else if (leftActiveTab == 'teachers') {
            parent.find('.filter-function-btn').toggle(false);
        } else {
            parent.find('.filter-function-btn').toggle(false);
            parent.find('.filter-company-btn').toggle(false);
        }
    }

    parent.children('.toolkit-filter input').each(function(i, e) {
        $(e).attr('checked', false);
    });
    parent.find('.filter-company-btn').html('company +<i></i>');
    parent.find('.filter-function-btn').html('function +<i></i>');

    parent.find('.search-filter').val('')
    parent.find('input[name=status]').each(function(i, e) {
        $(e).prop('checked', false);
    });
    parent.find('.filter-company-btn').val('');
    parent.find('.filter-company-btn').html('company +<i></i>');
    parent.find('.filter-function-btn').val('');
    parent.find('.filter-function-btn').html('function +<i></i>');
    searchfilter(event);

    parent.find('.filter-name-btn i').toggleClass('fa-sort-alpha-down', false);
    parent.find('.filter-name-btn i').toggleClass('fa-sort-alpha-up', false);
    parent.find('.filter-date-btn i').toggleClass('fa-sort-numeric-up', false);
    parent.find('.filter-date-btn i').toggleClass('fa-sort-numeric-down', false);
};

var toolkitAddItem = function(event) {
    event.preventDefault();
    event.stopPropagation();
    $('#session_form').toggle(true);
    notification('Please insert new session.', 1);
    $('#div_B .list-group-item').detach();
    clearFrom($('#session_form'));
    $('#div_A .list-group-item').removeClass('active');
    $("#session_form .method-select").val('POST');
    $("#language").val(1);
    $("#session_form").attr('action', baseURL + '/session');

};


var sessionItemClick = function(e) {
    $('#session_form').toggle(true);
    $('#div_A .list-group-item').removeClass('active');
    if (!$(this).hasClass("active")) {
        $(this).addClass("active");
    }
    heightToggleLeft = true;
    var parent = $(this).parents('.list-group-item');
    $('#div_B .list-group-item').detach();

    $('#session_form .method-select').val('PUT');
    $("#session_form").attr('action', baseURL + '/session/' + $(this).attr('id').split('_')[1]);
    $('#session_form').attr('data-item', $(this).attr('id'));
    var parent = $(this);
    var id = parent.attr('id').split('_')[1];
    $.get({
        url: baseURL + '/session/' + id,
        success: function(data, state) {
            notification('We got session data successfully!', 1);
            console.log(state);
            //TODO:show function;
            if (data.contents) {
                //                 data.contents.map(function(content_item) {
                //                     if(content_item!=null){
                //                         var newItem = createContentItem(content_item);
                //                         newItem.attr('data-src', id);
                //                         $('#table-content .list-group').append(newItem);
                //                     }
                //                 });
                if (data.contents != null && Object.keys(data.contents).length != 0) {
                    var newItem = createContentItem(data.contents[0]);
                    newItem.attr('data-src', id);
                    $('#table-content .list-group').append(newItem);
                }
            }

            if (data.participants) {
                if (data.participants.group) {
                    data.participants.group.map(function(participant_item) {
                        if (participant_item) {
                            var newItem = createGroupItem(participant_item);
                            newItem.attr('data-src', id);
                            $('#table-participant .list-group').append(newItem);
                        }
                    });
                }
                if (data.participants.student) {
                    data.participants.student.map(function(participant_item) {
                        if (participant_item) {
                            var newItem = createUserItem(participant_item);
                            newItem.attr('data-src', id);
                            $('#table-participant .list-group').append(newItem);
                        }
                    });
                }
                if (data.participants.teacher) {
                    data.participants.teacher.map(function(participant_item) {
                        if (participant_item) {
                            var newItem = createUserItem(participant_item);
                            newItem.attr('data-src', id);
                            $('#table-participant .list-group').append(newItem);
                        }
                    });
                }
            }

            $('#session-status-icon').prop('checked', data.session_info.status == 1).change();
            $('#session_name').val(data.session_info.name);
            $('#session_description').val(data.session_info.description);
            $('#end_date').val(data.session_info.end_date);
            $('#begin_date').val(data.session_info.begin_date);
            $('#language').val(data.session_info.language_iso);
        },
        error: function(err) {
            notification("Sorry, You can't get session data!", 2);
        }
    });
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
    unlinkbtn = $('<button class="btn toggle1-btn unlink-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
    element.find('.btn-group').append(unlinkbtn);
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
        '<div class="btn-group float-right">' +
        '</div>' +
        '</a>' +
        '<div class="group_' + data.value.id + ' d-flex flex-column pl-4"></div>');
    unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
    openbtn = $('<button class="btn"><i class="px-2 fas fa-angle-down"></i></button>').on('click', function(e) {
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

    })
    return element;
};
var createContentItem = function(data) {
    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var element = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x training_' + data.id + '" id="training_' + data.id + '_copy">' +
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
    unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
    element.find('.btn-group').append(unlinkbtn);
    return element;
}
var createSessionData = function(data) {
    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var element = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x session_' + data.id + '" id="session_' + data.id + '_copy" data-date="' + data.create_date + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.name + '">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '<span class=" p-2 font-weight-bolder item-lang">' + data.language_iso.toUpperCase() + '</span>' +
        '<button class="btn item-delete" data-content="session">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>' +
        '</div>' +
        '</a>');

    var email_btn = $('<button class="btn item-mail" data-id="'+data.id+'">'+
    '<i class="px-2 fa fa-envelope"></i>'+
    '</button>');
    email_btn.click(emailBtn);
    email_btn.insertAfter(element.find(".btn-group>span"));
    element.click(sessionItemClick);
    element.attr('draggable', false);
    element.on('drop', dropEnd);
    element.on('dragover', dragOver);
    element.on('dragleave', dragLeave);
    element.find('.item-delete').click(itemDelete);
    return element;
}

var updateSessionData = function(data, target) {
    $('#' + target + " .item-lang").html(data.language_iso.toUpperCase());
    $('#' + target + " input[name='item-name']").val(data.name);
    $('#' + target + " .item-name").html(data.name);
    $('#' + target).find('.status-notification').val(data.status);
    $('#' + target).find('.status-notification').prev().css('color', data.status == '1' ? 'green' : 'red');
}

var refreshGroupBtn = function(e) {
    //     ajax
}

var formInputChange = function(event) {
    console.log($(event.target).val());
};

var formStatusChange = function(e) {
    $(this).val($(this).prop('checked'));
};

var submitFunction = function(event) {
    console.log($(this).attr('action'));
    console.log($("#cate-status").attr("checked"));

    return false;
};

var submitBtn = function(event) {
    var formname = $(this).attr('data-form');
    if ($('#' + formname).attr('action')) {
        if ($("#" + formname).attr('data-item')) {
            $("#" + $(this).parents('form').attr('data-item')).toggleClass('highlight', false);
            $("#" + $(this).parents('form').attr('data-item') + " .btn").each(function(i, em) {
                $(em).toggleClass('active', false);
            });
        }

        var serialval = $('#' + formname).serializeArray().map(function(item) {
            var arr = {};
            if (item.name == 'session-status-icon') {
                item.value = $('#session-status-icon').prop('checked') == true ? 1 : 0;
            }
            return item;
        });
        if (!serialval.filter(function(em, t, arr) {
                return em.name == 'session-status-icon';
            }).length) {

        }
        if (!$("#session_form").find('input[type=checkbox]').prop('checked')) {
            serialval.push({
                name: 'session-status-icon',
                value: 0
            });
        }

        if ($('#begin_date').val() != '' && $('#end_date').val() != '' && $('#begin_date').val() > $('#end_date').val()) {
            notification('You have to insert correct date!', 2);
            return;
        }
        console.log(serialval);
        $.ajax({
            url: $('#' + formname).attr('action'),
            method: $('#' + formname).find('.method-select').val(),
            data: serialval,
            success: function(data) {
                console.log(data);
                $('#div_B .list-group-item').detach();
                clearFrom($('#session_form'));
                $('#div_A .list-group-item').removeClass('active');
                if ($('#session_form .method-select').val() == 'POST') {
                    notification('A session has been registered sucessfully!', 1);
                    $('#session .list-group').append(createSessionData(data));
                } else {
                    var target = $("#session_form").attr('data-item');
                    updateSessionData(data, target);
                }
            },
            error: function(err) {
                notification("Sorry, You have an error!", 2);
            }
        });

        if ($("#" + formname).attr('data-item') != '' && $("#" + formname).attr('data-item') != null) {
            var targetName = $("#" + formname).attr('data-item').split('_')[0],
                sourceId = $("#session_form").attr('data-item');
            $('#' + sourceId).toggleClass('highlight', false);
            $('#' + sourceId + ' .item-edit').toggleClass('active', false);
        }
    }
};

var cancelBtn = function(event) {
    var parent = $(event.target).parents('form');
    parent.toggle(false);
    clearFrom($('#session_form'));
};

var item_delete = function(element) {
    var parent = element.parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];
    $.ajax({
        type: "DELETE",
        url: baseURL + '/session/' + id,
        // dataType: "json",
        success: function(result) {
            console.log(result);
            notification('Successfully deleted!', 1);
            if (parent.hasClass('active')) {
                $('#div_B .list-group-item').detach();
                clearFrom($('#session_form'));
                $('#div_A .list-group-item').removeClass('active');
            }
            parent.detach();
        },
        error: function(err) {
            console.log(err);
            notification("Sorry, You can't delete!", 2);
        }
    });
};

var itemDelete = function(event) {
    elem = $(this);
    cate = $(this).attr('data-content');
    var e = Swal.mixin({
        buttonsStyling: !1,
        customClass: {
            confirmButton: 'btn btn-success m-1',
            cancelButton: 'btn btn-danger m-1',
            input: 'form-control'
        }
    });
    e.fire({
        title: 'Are you sure you want to delete this item ?',
        text: cate == 'student' ? ' This user and all his historic and reports will be permanently deleted' : '',
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
                    item_delete(elem);
                }), 50);
            }));
        }
    }).then((function(n) {
        if (n.value) {
            e.fire('Deleted!', 'Your ' + cate + ' has been deleted.', 'success');
            console.log();
            $(elem).parents('.list-group-item').remove();
        } else {
            'cancel' === n.dismiss && e.fire('Cancelled', 'Your data is safe :)', 'error');
        }
    }));
};

var detachLinkTo = function(e) {
    var parent = $(this).parents('.list-group-item');
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
    }, $(this));
};

var refreshGroupBtn = function(event) {
    var parent = $(this).parents('.list-group-item');
    var id = parent.attr('id');
    var dataSrc = parent.attr('data-src');
    var participantData = $('#session_' + dataSrc).attr('data-participant');
    var participant = JSON.parse(participantData);
    $.post({
        url: baseURL + '/grouprefresh'
    })

}

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

var filterCompanyBtn = function(event) {
    // var activedTab = $('#RightPanel').find('.ui-state-active a').attr('href');
    switch ($(this).html()) {
        case 'company +<i></i>':
            if ($(this).parents('.toolkit').find('.filter-function-btn').html() != 'Cancel') {
                getFilterCategory(this, 'companies');
            }
            break;

        case 'Cancel':
            $('#companies').fadeOut(1);
            $(activedTab).fadeIn(1);
            $(this).html('company +<i></i>');
            break;
        default:
            clearFilterCategory(this, 'companies', 'company +<i></i>');
            break;
    }
};

var filterFunctionBtn = function(event) {
    switch ($(this).html()) {
        case 'function +<i></i>':
            if ($(this).parents('.toolkit').find('.filter-company-btn').html() != 'Cancel') {
                getFilterCategory(this, 'positions');
            }
            break;
        case 'Cancel':
            $('#positions').fadeOut(1);
            $(activedTab).fadeIn(1);
            $(this).html('function +<i></i>');
            break;
        default:
            clearFilterCategory(this, 'positions', 'function +<i></i>');
            break;
    }
};

var clearFilterCategory = function(element, category, defaultStr) {
    $(element).val('');
    $(element).html(defaultStr);
    $(element).change();
    $('#' + category).find('.list-group-item').each(clearClassName);
    $('#' + category).find('.toggle1-btn').toggle(true);
    $('#' + category).find('.toggle2-btn').toggle(false);
};

var toggleAndSearch = function(element, category, defaultStr) {
    if ($('#' + category).find('.list-group-item.active').length) {
        var items = [],
            itemVal = [];
        $('#' + category).find('.list-group-item.active').each(function(i, el) {
            items.push($(el).find('.item-name').html());
            itemVal.push($(el).attr('id').split('_')[1]);
        });
        $(element).val(itemVal.join('_'));
        $(element).html(items.join(', ') + "&nbsp; X");
        // searchfilter(event);
        $(element).change();
    } else {
        $(element).html(defaultStr);
    }
    if ('#' + category != activedTab) {
        $('#' + category).fadeOut(1);
        $(activedTab).fadeIn(1);
    } else {
        $(activedTab).find('.toggle2-btn').each(function(i, e) {
            $(e).toggle(false);
            $(e).siblings('.toggle1-btn').toggle(true);
            $(e).parents('.list-group-item').toggleClass('active', false);
        });
    }
};

var getFilterCategory = function(element, category) {
    $(activedTab).fadeOut(1);
    $('#' + category).fadeIn(1);
    $('#' + category + " .list-group").attr('data-filter', $(element).parents('.toolkit').attr('id'));
    $(element).html('Cancel');
    $("#" + category).find('.toggle2-btn').each(function(i, e) {
        $(e).toggle(true);
    });
    $("#" + category).find('.toggle1-btn').each(function(i, e) {
        $(e).toggle(false);
    });
    $('#' + category).find('.list-group-item').each(clearClassName);
};

var cancelFilterCategoryAll = function() {
    $('.filter-function-btn').each(function(i, e) {
        if ($(e).html() != 'function +<i></i>') {
            $(e).html('function +<i></i>');
            $(e).val('');
            $('#positions').fadeOut(1);
            $(activedTab).fadeIn(1);
        }
    });
    $('.filter-company-btn').each(function(i, e) {
        if ($(e).html() != 'company +<i></i>') {
            $(e).html('company +<i></i>');
            $(e).val('');
            $('#companies').fadeOut(1);
            $(activedTab).fadeIn(1);
        }
    });
};
var toggle2Btn = function(evt) {
    // evt.stopPropagation();
    var tooltipid = $(this).parents('.list-group').attr('data-filter');
    $(this).parents('.list-group-item').addClass('active');
    // $(this).parents('.list-group-item').attr('draggable', function(index, attr) {
    //     return attr == "true" ? false : true;
    // });
    if ($('#' + tooltipid).find('.filter-function-btn').html() == 'Cancel') {
        toggleAndSearch($('#' + tooltipid).find('.filter-function-btn'), 'positions', 'function +<i></i>');
    } else {
        toggleAndSearch($('#' + tooltipid).find('.filter-company-btn'), 'companies', 'company +<i></i>');
    }
    $(this).parents('.list-group-item').removeClass('active');
    $(this).parents('.list-group-item').find('.btn.active').removeClass('active');
};

var searchfilter = function(event) {
    var parent = $(event.target).parents('.toolkit');
    var items = null;
    var str = parent.find('input.search-filter').val();
    var opt = parent.find('input[name=status]:checked').val();
    var ctgc = parent.find('button.filter-company-btn').val();
    var ctgf = parent.find('button.filter-function-btn').val();

    if ($(event.target).is('input.search-filter')) {
        str = event.target.value;
        console.log(str);
    }

    if (parent.attr('id') == 'cate-toolkit') {
        if ($('#table-content-tab').parents('li.nav-item').hasClass('ui-state-active')) {
            items = parent.next('div:first').find('.list-group-item');
        } else {
            var selector = parent.prev().find('.ui-state-active a').attr('href').split('#')[1];
            items = $("#" + selector).find('.list-group .list-group-item');
        }

    } else if (parent.attr('id') == 'session-toolkit') {
        items = parent.next('div:first').find('.list-group-item');
    }
    // console.log(items);

    items.map(function(i, e) {
        var item_name = $(e).find('input[name="item-name"]').val();
        var item_status = $(e).find('input[name="item-status"]').val();
        var item_company = $(e).find('input[name="item-company"]').val();
        var item_function = $(e).find('input[name="item-function"]').val();

        // console.log(item_name);

        if (str == null || str == '' || item_name.toLowerCase().indexOf(str.replace(/\s+/g, '')) >= 0) {
            if (ctgc == '' || ctgc.split("_").filter(function(iem, i, d) {
                    return iem == item_company;
                }).length) {
                if (ctgf == '' || ctgf.split("_").filter(function(iem, i, d) {
                        return iem == item_function;
                    }).length) {

                    switch (opt) {
                        case 'all':

                            $(e).toggle(true);

                            break;
                        case 'on':
                            if (item_status == 1) {
                                $(e).toggle(true);
                            } else {
                                $(e).toggle(false);
                            }
                            break;
                        case 'off':
                            if (item_status == 1) {
                                $(e).toggle(false);
                            } else {
                                $(e).toggle(true);
                            }
                            break;
                        default:
                            $(e).toggle(true);
                            break;
                    }
                } else {
                    $(e).toggle(false);
                }
            } else {
                $(e).toggle(false);
            }
        } else {
            $(e).toggle(false);
        }
    });
    if ($(this).parents('fieldset').attr('id') == "LeftPanel") {
        heightToggleLeft = true;
    } else if ($(this).parents('fieldset').attr('id') == "RightPanel") {
        heightToggleRight = true;
    }
};

var sortfilter = function(event) {
    var parent = $(event.target).parents('.toolkit');
    var $items = null,
        $itemgroup;
    var nameIcon = $(event.target).parents('.toolkit').find('.filter-name-btn i');
    var dateIcon = $(event.target).parents('.toolkit').find('.filter-date-btn i');


    if ($(this).siblings('button').find('i').hasClass('fa-sort-numeric-down')) {
        $(this).siblings('button').find('i').removeClass('fa-sort-numeric-down');
    }

    if ($(this).siblings('button').find('i').hasClass('fa-sort-numeric-up')) {
        $(this).siblings('button').find('i').removeClass('fa-sort-numeric-up');
    }

    if ($(this).siblings('button').find('i').hasClass('fa-sort-alpha-down')) {
        $(this).siblings('button').find('i').removeClass('fa-sort-alpha-down');
    }

    if ($(this).siblings('button').find('i').hasClass('fa-sort-alpha-up')) {
        $(this).siblings('button').find('i').removeClass('fa-sort-alpha-up');
    }

    if (parent.attr('id') == 'cate-toolkit') {
        if ($('#table-content-tab').parents('li.nav-item').hasClass('ui-state-active')) {
            $itemgroup = $('#trainings').find('.list-group');
        } else {
            var selector = parent.prev().find('.ui-state-active a').attr('href').split('#')[1];
            $itemgroup = $("#" + selector).find('.list-group');
        }

    } else if (parent.attr('id') == 'session-toolkit') {
        $itemgroup = parent.next('div:first').find('.list-group');
    }
    $items = $itemgroup.children('.list-group-item');
    switch ($(this).parents('.toolkit').attr('id')) {
        case 'session-toolkit':
            if ($(this).is('.filter-name-btn')) {
                userNameSort = !userNameSort;
                $items.sort(function(a, b) {
                    var an = $(a).find('span.item-name').html().split('&nbsp;').join('').toLowerCase(),
                        bn = $(b).find('span.item-name').html().split('&nbsp;').join('').toLowerCase();

                    if (userNameSort) {
                        nameIcon.toggleClass('fa-sort-alpha-down', true);
                        nameIcon.toggleClass('fa-sort-alpha-up', false);
                        if (an > bn) {
                            return 1;
                        }
                        if (an < bn) {
                            return -1;
                        }
                        return 0;

                    } else {
                        nameIcon.toggleClass('fa-sort-alpha-down', false);
                        nameIcon.toggleClass('fa-sort-alpha-up', true);
                        if (an < bn) {
                            return 1;
                        }
                        if (an > bn) {
                            return -1;
                        }
                        return 0;
                    }
                });
                $items.detach().appendTo($itemgroup);

            } else {
                userDateSort = !userDateSort;
                $items.sort(function(a, b) {
                    var an = new Date(a.dataset.date),
                        bn = new Date(b.dataset.date);
                    if (userDateSort) {
                        dateIcon.toggleClass('fa-sort-numeric-down', true);
                        dateIcon.toggleClass('fa-sort-numeric-up', false);
                        if (an > bn) {
                            return 1;
                        }
                        if (an < bn) {
                            return -1;
                        }
                        return 0;
                    } else {
                        dateIcon.toggleClass('fa-sort-numeric-down', false);
                        dateIcon.toggleClass('fa-sort-numeric-up', true);
                        if (an < bn) {
                            return 1;
                        }
                        if (an > bn) {
                            return -1;
                        }
                        return 0;
                    }
                });

                $items.detach().appendTo($itemgroup);
            }
            break;
        case 'cate-toolkit':
            if ($(this).is('.filter-name-btn')) {
                cateNameSort = !cateNameSort;
                $items.sort(function(a, b) {
                    var an = $(a).find('span.item-name').html().split('&nbsp;').join('').toLowerCase(),
                        bn = $(b).find('span.item-name').html().split('&nbsp;').join('').toLowerCase();

                    if (cateNameSort) {
                        nameIcon.toggleClass('fa-sort-alpha-down', true);
                        nameIcon.toggleClass('fa-sort-alpha-up', false);
                        if (an > bn) {
                            return 1;
                        }
                        if (an < bn) {
                            return -1;
                        }
                        return 0;
                    } else {
                        nameIcon.toggleClass('fa-sort-alpha-down', false);
                        nameIcon.toggleClass('fa-sort-alpha-up', true);
                        if (an < bn) {
                            return 1;
                        }
                        if (an > bn) {
                            return -1;
                        }
                        return 0;
                    }
                });

                $items.detach().appendTo($itemgroup);

            } else {
                cateDateSort = !cateDateSort;
                $items.sort(function(a, b) {
                    var an = new Date(a.dataset.date),
                        bn = new Date(b.dataset.date);
                    if (cateDateSort) {
                        dateIcon.toggleClass('fa-sort-numeric-down', true);
                        dateIcon.toggleClass('fa-sort-numeric-up', false);
                        if (an > bn) {
                            return 1;
                        }
                        if (an < bn) {
                            return -1;
                        }
                        return 0;
                    } else {
                        dateIcon.toggleClass('fa-sort-numeric-down', false);
                        dateIcon.toggleClass('fa-sort-numeric-up', true);
                        if (an < bn) {
                            return 1;
                        }
                        if (an > bn) {
                            return -1;
                        }
                        return 0;
                    }
                });

                $items.detach().appendTo($itemgroup);
            }
            break;
        default:
            break;
    }

    $(this).addClass('active');
    $(this).siblings('button').toggleClass('.active', false);
};

var tabClick = function(event) {
    if ($(this).parents('fieldset').attr('id') == 'LeftPanel') {
        switch ($(this).attr('id')) {
            case 'table-conent-tab':
                $('#cate-toolkit .filter-function-btn').toggle(false);
                $('#cate-toolkit .filter-company-btn').toggle(false);
                break;
            default:
                break;
        }

    } else if ($(this).parents('fieldset').attr('id') == 'RightPanel') {
        switch ($(this).attr('id')) {
            case 'groups-tab':
                $('#RightPanel .toolkit>div').css('background-color', 'var(--group-h)');
                activedTab = '#groups';
                $('#cate-toolkit .filter-function-btn').toggle(false);
                $('#cate-toolkit .filter-company-btn').toggle(false);
                break;
            case 'teachers-tab':
                $('#RightPanel .toolkit:first>div').css('background-color', 'var(--teacher-h)');
                activedTab = '#teachers';
                $('#cate-toolkit .filter-function-btn').toggle(false);
                $('#cate-toolkit .filter-company-btn').toggle(true);
                break;
            case 'students-tab':
                $('#RightPanel .toolkit:first>div').css('background-color', 'var(--student-h)');
                activedTab = '#students';
                $('#cate-toolkit .filter-function-btn').toggle(true);
                $('#cate-toolkit .filter-company-btn').toggle(true);
                break;

            default:
                break;
        }

        cancelFilterCategoryAll();
        $("#RightPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });
        $('#div_C').find('.list-group-item').each(clearClassName);
        $('#cate-toolkit .search-filter').val('');
        $('#cate-toolkit .search-filter').change();
        var nameIcon = $('#cate-toolkit').find('.filter-name-btn i');
        var dateIcon = $('#cate-toolkit').find('.filter-date-btn i');
        nameIcon.toggleClass('fa-sort-alpha-down', false);
        nameIcon.toggleClass('fa-sort-alpha-up', false);
        dateIcon.toggleClass('fa-sort-numeric-down', false);
        dateIcon.toggleClass('fa-sort-numeric-up', false);
        $('#cate-toolkit input[name="status"]:checked').prop('checked', false)
    }
};

var handlerDBClick = function(event) {
    var heightToggle;
    if ($(this).parents('fieldset').attr('id') == 'LeftPanel') {
        heightToggleLeft = !heightToggleLeft;
        heightToggle = heightToggleLeft;
    } else if ($(this).parents('fieldset').attr('id') == 'RightPanel') {
        heightToggleRight = !heightToggleRight;
        heightToggle = heightToggleRight;
    }
    var divHight = 20 + parseInt($("#div_left").height()) + parseInt($('.content-header').height());
    if (heightToggle) {
        $(this).prev().css('height', (h - parseInt($('.toolkit').css('height')) - divHight) - 90 + 'px');
    } else {
        if ($(this).parents('fieldset').attr('id') == 'LeftPanel') {
            var activeTabHeight = $('#div_A .list-group').css('height');
        } else {
            var activeTabHeight = parseInt($($(this).parents('fieldset').find('.ui-state-active a').first().attr('href')).find('.list-group').css('height'));
        }

        var newHeight = (h - parseInt($('.toolkit').css('height')) - divHight) / 2 - 90;
        if (newHeight > activeTabHeight) {
            $(this).prev().css('height', activeTabHeight + "px");
        } else {
            $(this).prev().css('height', newHeight + "px");
        }
    }
};

var statusBtn = function(event) {
    var today = $('meta[name="date"]').attr('content');
    if($(event.target).prop('checked')==true){
        if ($("#begin_date").val() > today||$("#end_date").val() < today) {
            console.log('error');
            notification('You are not allowed to set online when you are out date', 2);
            $(event.target).prop('checked', false);
        }
    }
}

var dragitem = null;

function dragStart(event) {
    dragitem = Array();
    $(this).parents(".list-group").children('.active.list-group-item').each(function(i, dragelem) {
        dragitem.push($(dragelem).attr("id"));
    });
    if (dragitem.indexOf($(this).attr('id')) == -1) {
        dragitem.push($(this).attr('id'));
    }
    console.log($(this).css('cursor'));
    // console.log(dragitem);
}

function dragOver(event) {
    $(event.target).css('opacity', '50%');
    event.preventDefault();
}

function dragLeave(event) {
    $(event.target).css('opacity', '100%');
    event.preventDefault();
}

function dragEnd(event) {
    $('main').css('cursor', 'default');
}

var sessionLinkTo = function(parent, sendData) {
    return new Promise((resolve, reject) => {
        $.post({
            url: baseURL + '/sessionjointo',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: sendData
        }).done(function(data) {
            //             if(data.message==null){
            if (dragitem[0]) {
                notification('Items linked to ' + parent.find('.item-name').html() + '!', 1);
            }
            //             } else {
            //                 notification('This training is already allocated.',2);
            //             }
            parent.click();
            resolve(true);
        }).fail(function(err) {
            notification("Sorry, You have an error!", 2);
            resolve(false);
        }).always(function(data) {
            console.log(data);
            dragitem = null;
            //             $(this).click();
        });
    })
}

async function dropEnd(event, item) {
    $(event.target).css('opacity', '100%');
    var parent = $(event.target);
    if (!$(event.target).is('.list-group-item')) {
        parent = $(event.target).parents('.list-group-item');
    }
    var requestData = Array();
    if (!$(event.target).is('.list-group-item')) {
        var id = $(event.target).parents('.list-group-item').attr("id").split('_')[1];
    } else {
        var id = $(event.target).attr("id").split('_')[1];
    }

    var participantData = $(this).attr('data-participant');
    var participant = participantData ? JSON.parse(participantData) : {
        s: [],
        t: [],
        g: []
    };
    var contentData = $(this).attr('data-content');
    var content = contentData ? JSON.parse(contentData) : [];
    var rowData;
    if (dragitem != null) {
        var droppeditem_cate = dragitem[0].split('_')[0];
        var cate;
        dragitem.map(function(droppeditem) {
            var droppeditem_id = parseInt(droppeditem.split('_')[1]);
            switch (droppeditem_cate) {
                case "group":
                    var groupData = participant.g ? participant.g : [];
                    if (groupData.length != 0) {
                        var repeat = groupData.filter(function(groupitem) {
                            return groupitem.value == droppeditem_id;
                        })
                        if (repeat.length == 0) {
                            groupData.push({
                                value: droppeditem_id
                            });
                            //TODO:Here we have to add real group datas.
                        }
                    } else {
                        groupData.push({
                            value: droppeditem_id
                        });
                    }
                    participant.g = groupData;
                    $(event.target).attr('data-participant', JSON.stringify(participant));
                    cate = 'participant';
                    break;
                case "student":
                    var studentData = participant.s ? participant.s : [];
                    if (studentData.length != 0) {
                        var repeat = studentData.filter(function(studentItem) {
                            return studentItem == droppeditem_id;
                        })
                        if (repeat.length == 0) {
                            studentData.push(droppeditem_id);
                        }
                    } else {
                        studentData.push(droppeditem_id);
                    }
                    participant.s = studentData;
                    $(event.target).attr('data-participant', JSON.stringify(participant));
                    cate = 'participant';
                    break;
                case "teacher":
                    var teacherData = participant.t ? participant.t : [];
                    if (teacherData.length != 0) {
                        var repeat = teacherData.filter(function(teacherItem) {
                            return teacherItem == droppeditem_id;
                        })
                        if (repeat.length == 0) {
                            teacherData.push(droppeditem_id);
                        }
                    } else {
                        teacherData.push(droppeditem_id);
                    }
                    participant.t = teacherData;
                    $(event.target).attr('data-participant', JSON.stringify(participant));

                    cate = 'participant';
                    break;
                case "training":
                    //                     if(content.length!=0){
                    //                        var repeat = content.filter(function(contentItem){
                    //                            return contentItem == droppeditem_id;
                    //                        })
                    //                        if(repeat.length==0){
                    //                            content.push(droppeditem_id);
                    //                        }
                    //                     } else {
                    //                         content.push(droppeditem_id);
                    //                     }

                    content = droppeditem_id;
                    $(event.target).attr('data-content', content);
                    cate = 'content';

                    break;
                default:
                    break;
            }
        });

        var sendData = {
            'participant': JSON.stringify(participant),
            'content': content,
            'id': id,
            'cate': cate
        };
        await sessionLinkTo(parent, sendData);
        requestData = [];
    }
    $("#RightPanel").find('.list-group-item').each(function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
    });

}

var participateClick = function(e) {
    $('#paticipant-group').toggle(true);
    $('#content-group').toggle(false);
    $('#RightPanel>ul').toggle(true);
    goTab('students');
}

var contentClick = function(e) {
    $('#paticipant-group').toggle(false);
    $('#content-group').toggle(true);
    $('#RightPanel>ul').toggle(false);
    $('#cate-toolkit>div').css('background', "var(--training-c)");
    $('#cate-toolkit .filter-function-btn').toggle(false);
    $('#cate-toolkit .filter-company-btn').toggle(false);
}


$(document).ready(function() {

    $('#LeftPanel .toolkit>div').css('background-color', 'var(--session-h)');
    $('#RightPanel .toolkit:first>div').css('background-color', 'var(--student-h)');
    $('.second-table .toolkit>div').css('background-color', 'var(--session-h)');

    $("#LeftPanel .list-group-item").each(function(i, elem) {
        $(elem).attr('draggable', false);
        $(elem).on('drop', dropEnd);
        elem.addEventListener('dragover', dragOver);
        elem.addEventListener('dragleave', dragLeave);
    });

    $("#RightPanel .list-group-item").each(function(i, elem) {
        elem.addEventListener('dragstart', dragStart);
        elem.addEventListener('dragend', dragEnd);
        $(elem).attr('draggable', true);
    });

});
$('input[name=status], input.search-filter, button.filter-company-btn, button.filter-function-btn').change(searchfilter);
$('input.search-filter').on('keydown change keyup', searchfilter);
$("button.filter-company-btn, button.filter-function-btn").on('drop', searchfilter);

$("#RightPanel .list-group-item").dblclick(itemDBClick);
$("#RightPanel .list-group-item, #RightPanel .list-group-item *").click(rightItemClick);

$(".list-group-item button.btn").click(btnClick);

$('.item-delete').click(itemDelete);

$('.toolkit-add-item').click(toolkitAddItem);
$('form input, form select').change(formInputChange);
$('#user-status-icon, #cate-status-icon').change(formStatusChange);
$('.submit-btn').click(submitBtn);
$('form').submit(submitFunction);
$(".toolkit-show-filter").click(filterToggleShow);
$('.filter-company-btn').click(filterCompanyBtn);
$('.filter-function-btn').click(filterFunctionBtn);
$('.filter-name-btn').click(sortfilter);
$('.filter-date-btn').click(sortfilter);

$('.toggle2-btn').click(toggle2Btn);
$('.nav-link').click(tabClick);

$('.handler_horizontal').dblclick(handlerDBClick);
$('#table-participant-tab').click(participateClick);
$('#table-content-tab').click(contentClick);

$('#session .list-group-item').click(sessionItemClick);
$('.refresh-group').click(refreshGroupBtn);
$("#table-content .list-group").sortable({
    update: function(event, ui) {
        var src = $(this).find('.list-group-item:first').attr('data-src');
        var temparr = [];
        $(this).find('.list-group-item').each(function(i, e) {
            temparr.push($(e).attr('id').split('_')[1]);
        });
        $('#session_' + src).attr('data-content', JSON.stringify(temparr));
        $.post({
            url: baseURL + '/sessionjointo',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: src,
                content: temparr,
                participant: $('#session_' + src).attr('data-participant'),
                cate: 'content'
            }
        }).done(function() {
            notification('The order of training changed successfully.', 1);
        }).fail(function() {
            notification('The order of training have some problem.', 2);
        });
    }
});
$('.cancel-btn').click(cancelBtn);
$('#session-status-icon').click(statusBtn);

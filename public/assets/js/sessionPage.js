var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));

var baseURL = window.location.protocol + "//" + window.location.host;
// var baseURL = window.location.protocol + "//" + window.location.host + '/newlms';
var filteritem = null;
var grouptab = null,
    detailtags = null;
var detailtag1 = null;
var activedTab = '#groups';

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
    $(this).addClass('active');
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

var filterToggleShow = function(event) {
    var parent = $(this).parents('.toolkit');
    parent.children(".toolkit-filter").toggle();
    if (parent.attr('id') == 'cate-toolkit') {
        var leftActiveTab = $('#RightPanel .ui-state-active a').attr('href').split('#')[1];
        if (leftActiveTab == 'students') {
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

    clearFrom($('#session_form'));
    $("#session-status-icon").val('POST');
    $("#session_form .method-select").val('POST');
    $("#session_form").attr('action', baseURL + '/session');
};

var sessionItemClick = function(e) {
    if (!$(this).hasClass("active")) {
        $(this).addClass("active");
    } else {
        $(this).removeClass("active");
    }
    heightToggleLeft = true;
    $('#div_left').dblclick();
    var parent = $(this).parents('.list-group-item');

    $('#session_form .method-select').val('PUT');
    $("#session_form").attr('action', baseURL + '/session/' + $(this).attr('id').split('_')[1]);
    var parent = $(this);
    var id = parent.attr('id').split('_')[1];
    $.get({
        url: baseURL + '/session/' + id,
        success: function(data, state) {
            notification('We got session data successfully!', 1);
            console.log(state);
            //TODO:show function;
            if (data.contents) {
                data.contents.map(function(content_item) {
                    $('#table-content .list-group').append(createContentItem(content_item));
                });
            }

            if (data.participants) {
                data.participants.group.map(function(participant_item) {
                    $('#table-participant .list-group').append(createGroupItem(participant_item));
                });
                data.participants.student.map(function(participant_item) {
                    $('#table-participant .list-group').append(createUserItem(participant_item));
                });
                data.participants.teacher.map(function(participant_item) {
                    $('#table-participant .list-group').append(createUserItem(participant_item));
                });
            }

            $('#session-status-icon').prop('checked', data.session_info.status == 1).change();
            $('#session_name').val(data.session_info.name);
            $('#session_description').val(data.session_info.description);
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
    var element = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x '+ (data.type == 4? "student_"+data.id:"teacher_"+data.id)+' data-date="2021-05-25 08:50:54" data-type = "'+data.type+'">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">'+data.first_name+'&nbsp;'+data.last_name+'</span>' +
        '<input type="hidden" name="item-name" value="'+data.first_name+data.last_name+'">' +
        '</div>' +
        '<div class="btn-group float-right">' +
//         '<span class=" p-2 font-weight-bolder item-lang">'+ data.lang+
//         '</span>' +
        '</div>' +
        '</a>');
        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
        element.find('.btn-group').append(unlinkbtn);
    return $(element);
};

var createGroupItem = function(data) {
    var status_temp = data.value.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var element = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x group_'+data.value.id+'" data-date="'+data.value.creation_date+'" data-type="group">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">'+data.value.name+'</span>' +
        '<input type="hidden" name="item-name" value="'+data.value.name+'">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '</div>' +
        '</a>'+
        '<div class="group_'+data.value.id+' d-flex flex-column pl-4"></div>');
        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
        openbtn = $('<button class="btn"><i class="px-2 fas fa-angle-down"></i></button>').on('click', function(e){
            $(this).parents('.list-group-item').next('div.d-flex').find('.list-group-item').fadeToggle();
        });
        var refreshbtn = $('<button class="btn"><i class="px-2 fa fa-sync-alt"></i></button>').on('click', refreshGroupBtn);
        
        element.find('.btn-group').append(refreshbtn);
        element.find('.btn-group').append(unlinkbtn);
        element.find('.btn-group').append(openbtn);
        data.items.map(function(userItem){
            var userElem = createUserItem(userItem);
            $(element[1]).append(userElem);
        })
    return element;
};

var createContentItem = function(data) {
        var status_temp = data.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var element =$('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x training_22" id="training_22" data-date="2021-06-19 05:30:44" data-lesson="[{&quot;item&quot;:218}]" draggable="true">' +
    '<div class="float-left">' +
    status_temp +
    '<span class="item-name">new Training</span>' +
    '<input type="hidden" name="item-name" value="new Training">' +
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
    var element =     $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x session_3821" id="session_3821" data-date="" draggable="false">' +
    '<div class="float-left">' +
    status_temp +
    '<span class="item-name">'+data.name+'</span>' +
    '<input type="hidden" name="item-name" value="'+data.name+'">' +
    '</div>' +
    '<div class="btn-group float-right">' +
    '<span class=" p-2 font-weight-bolder item-lang">'+data.language_iso+'</span>' +
    '<button class="btn item-delete" data-content="session">' +
    '<i class="px-2 fa fa-trash-alt"></i>' +
    '</button>' +
    '</div>' +
    '</a>');
    return element;
}


var updateSessionData = function(data, target) {
    $('#' + target + " .item-lang").html(data.language_iso);
    $('#' + target + " input[name='item-name'").val(data.name);
    $('#' + target + " .item-name").html(data.name);
}

var refreshGroupBtn =function(e){
//     ajax
}

var formInputChange = function(event) {
    console.log($(event.target).val());
};

var formStatusChange = function(e) {
    $(this).val($(this).prop('checked'));
};

var submitBtn = function(event) {
    var formname = $(this).attr('data-form');
    if ($("#" + formname).attr('data-item')) {
        $("#" + $(this).parents('form').attr('data-item')).toggleClass('highlight', false);
        $("#" + $(this).parents('form').attr('data-item') + " .btn").each(function(i, em) {
            $(em).toggleClass('active', false);
        });
    }

    var serialval = $('#' + formname).serializeArray().map(function(item) {
        var arr = {};
        if (item.name == 'user-status-icon') {
            item.value = $('#user-status-icon').prop('checked') == true ? 1 : 0;
        } else if (item.name == 'cate-status-icon') {
            item.value = $('#cate-status-icon').prop("checked") == true ? 1 : 0;
        } else if (item.name == 'generatepassword') {
            item.value = $('#generatepassword').prop("checked") == true ? 1 : 0;
        }
        return item;
    });
    if (!serialval.filter(function(em, t, arr) {
            return em.name == 'user-status-icon' || em.name == 'cate-status-icon';
        }).length) {
        if (formname == 'user_form') {
            serialval.push({
                name: 'user-status-icon',
                value: $('#user-status-icon').prop('checked') == true ? 1 : 0
            });
            serialval.push({
                name: 'generatepassword',
                value: $('#generatepassword').prop('checked') == true ? 1 : 0
            });
        } else if (formname == 'cate_form') {
            serialval.push({
                name: 'cate-status-icon',
                value: $('#cate-status-icon').prop('checked') == true ? 1 : 0
            });
        }
    }
    if (!$("#" + formname).find('input[type=checkbox]').prop('checked')) {
        if (formname == 'user_form') {
            serialval.push({
                name: 'user-status-icon',
                value: 0
            });
            if ($('#generatepassword').prop('checked') == false) {
                serialval.push({
                    name: 'generatepassword',
                    value: 0
                });
            }
        } else if (formname == 'cate_form') {
            serialval.push({
                name: 'cate-status-icon',
                value: 0
            });
        }
    }
    console.log(serialval);
    $.ajax({
        url: $('#' + formname).attr('action'),
        method: $('#' + formname).find('.method-select').val(),
        data: serialval,
        success: function(data) {
            console.log(data);
            if ($("#" + formname).attr('data-item') == '' || $("#" + formname).attr('data-item') == null) {
                notification('A session has been registered sucessfully!', 1);
                $('#session .list-group').append(createSessionData(data));
            } else {
                var target = $("#" + formname).attr('data-item');
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
            parent.detach();
            notification('Successfully deleted!', 1);
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
    var showeditem = parent.attr('data-src');
    var id = parent.attr('id').split('_')[1];
    var cate = parent.attr('id').split('_')[0];
    var value = $("#" + showeditem).find('input[name="item-' + cate + '"]').val();
    if (cate == 'group') {
        $("#div_A #" + showeditem).find('input[name="item-' + cate + '"]').val(combine(value, id).join('_'));
    } else {
        $("#div_A #" + showeditem).find('input[name="item-' + cate + '"]').val('');
    }

    var result = $("#" + showeditem).find('input[name="item-' + cate + '"]').val();

    detachCall(cate, {
        id: showeditem.split('_')[1],
        target: result,
        flag: false
    }, $(this));
};

var detachLinkFrom = function(e) {
    var parent = $(this).parents('.list-group-item');
    var divAitem = $("#div_A #" + parent.attr('id'));
    var showeditem = parent.attr('data-src');
    var id = $("#" + showeditem).attr('id').split('_')[1];
    var cate = $("#" + showeditem).attr('id').split('_')[0];
    var value = divAitem.find('input[name="item-' + cate + '"]').val();
    if (cate == 'group') {
        divAitem.find('input[name="item-' + cate + '"]').val(combine(value, id).join('_'));
    } else {
        divAitem.find('input[name="item-' + cate + '"]').val('');
    }

    var result = parent.find('input[name="item-' + cate + '"]').val();
    var parent_id = parent.attr('id').split('_')[1];

    detachCall(cate, {
        id: parent_id,
        target: result,
        flag: false
    }, $(this));
};

var combine = function(value, id) {
    var combineArray = value.split('_').filter(function(item, i, d) {
        return item != id && item != null;
    });
    console.log(combineArray);
    return combineArray;
};

var detachCall = function(cate, connectiondata, element) {
    $.post({
        url: baseURL + '/userjointo' + cate,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'data': JSON.stringify(Array(connectiondata))
        }
    }).then(function(data) {
        notification('Successfully unliked!', 1);
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

    if (parent.attr('id') == 'user-toolkit' || parent.attr('id') == 'cate-toolkit') {
        var selector = parent.prev().find('.ui-state-active a').attr('href').split('#')[1];
        // console.log(selector);
        items = $("#" + selector).find('.list-group .list-group-item');
    } else {
        items = $('#div_D .list-group').find('.list-group-item');
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
        $('#div_left').dblclick();
    } else if ($(this).parents('fieldset').attr('id') == "RightPanel") {
        heightToggleRight = true;
        $('#div_right').dblclick();
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

    if (parent.prev().is('.nav')) {
        var selector = parent.prev().find('.ui-state-active a').attr('href').split('#')[1];
        $itemgroup = $("#" + selector).find('.list-group');
        // items = $("#" + selector).find('.list-group .list-group-item');
    } else {
        // items = parent.next('.list-group').find('.list-group-item');
        $itemgroup = parent.next('.list-group');
    }
    $items = $itemgroup.children('.list-group-item');
    switch ($(this).parents('.toolkit').attr('id')) {
        case 'user-toolkit':
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
        case 'show-toolkit':
            if ($(this).is('.filter-name-btn')) {
                showNameSort = !showNameSort;
                $items.sort(function(a, b) {
                    var an = $(a).find('span.item-name').html().split('&nbsp;').join('').toLowerCase(),
                        bn = $(b).find('span.item-name').html().split('&nbsp;').join('').toLowerCase();

                    if (showNameSort) {
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
                showDateSort = !showDateSort;
                $items.sort(function(a, b) {
                    var an = new Date(a.dataset.date),
                        bn = new Date(b.dataset.date);
                    if (showDateSort) {
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

        var nameIcon = $('#user-toolkit').find('.filter-name-btn i');
        var dateIcon = $('#user-toolkit').find('.filter-date-btn i');
        nameIcon.toggleClass('fa-sort-alpha-down', false);
        nameIcon.toggleClass('fa-sort-alpha-up', false);
        dateIcon.toggleClass('fa-sort-numeric-down', false);
        dateIcon.toggleClass('fa-sort-numeric-up', false);

        switch ($(this).attr('id')) {
            case 'students-tab':
                $('#RightPanel .toolkit>div').css('background-color', 'var(--student-h)');
                if ($("#table-groups").length == 0) {
                    grouptab.appendTo("#user-form-tags");
                }

                if ($('#user-form-tags ul').length == 0) {
                    $('#user-form-tags').prepend(detailtags);
                }

                if ($('#table-groups-tab').length == 0) {
                    $('#user-form-tags li:first').prepend(detailtag1);
                }

                if ($('#user_form #input_group_position').length == 0) {
                    $('#user_form #form_group_position').append(input_group_position);
                }

                if ($('#table-user').length == 0) {
                    $('#category-form-tags').append(tableuser);
                }

                $('#groups-tab').toggle(true);
                $('#positions-tab').toggle(true);

                $('#user-toolkit .filter-function-btn').toggle(true);
                $('#div_A').find('.list-group-item').each(clearClassName);
                break;
            case 'teachers-tab':
                $('#RightPanel .toolkit>div').css('background-color', 'var(--teacher-h)');
                if ($("#table-groups").length != 0) {
                    grouptab = $("#table-groups");
                    $("#table-groups").detach();
                }

                if ($('#user-form-tags ul').length == 0) {
                    $('#user-form-tags').prepend(detailtags);
                }

                if ($('#table-groups-tab').length != 0) {
                    detailtag1 = $('#table-groups-tab');
                    $('#table-groups-tab').detach();
                }

                if ($('#user_form #input_group_position').length != 0) {
                    input_group_position = $("#user_form #input_group_position");
                    $("#user_form #input_group_position").detach();
                }

                if (activedTab == '#groups') {
                    if ($('#table-user').length != 0) {
                        tableuser = $('#table-user');
                        $('#table-user').detach();
                    }
                } else {
                    if ($('#table-user').length == 0) {
                        $('#category-form-tags').append(tableuser);
                    }
                }

                $('#groups-tab').toggle(false);
                $('#positions-tab').toggle(true);

                if (activedTab != '#positions' || activedTab != '#companies') {
                    $('#companies-tab').click();
                }

                $('#user-toolkit .filter-function-btn').toggle(true);
                $('#div_A').find('.list-group-item').each(clearClassName);

                break;
            case 'authors-tab':
                $('#RightPanel .toolkit>div').css('background-color', 'var(--author-h)');
                if ($("#table-groups").length != 0) {
                    grouptab = $("#table-groups");
                    $("#table-groups").detach();
                }

                if ($('#user-form-tags ul').length != 0) {
                    detailtags = $('#user-form-tags ul');
                    $('#user-form-tags ul').detach();
                }

                if ($('#user_form #input_group_position').length != 0) {
                    input_group_position = $("#user_form #input_group_position");
                    $("#user_form #input_group_position").detach();
                }

                $('#user-toolkit .filter-function-btn').toggle(false);
                if (activedTab == '#groups' || activedTab == '#positions') {
                    if ($('#table-user').length != 0) {
                        tableuser = $('#table-user');
                        $('#table-user').detach();
                    }
                } else {
                    if ($('#table-user').length == 0) {
                        $('#category-form-tags').append(tableuser);
                    }
                }

                $('#groups-tab').toggle(false);
                $('#positions-tab').toggle(false);
                if (activedTab != '#companies') {
                    $('#companies-tab').click();
                }
                $('#div_A').find('.list-group-item').each(clearClassName);

                break;

            default:
                break;
        }
        $("#LeftPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });
        cancelFilterCategoryAll();
        $('#user-toolkit .search-filter').val('');
        $('#user-toolkit .search-filter').change();
        $('#user-toolkit input[name="status"]:checked').prop('checked', false);
    } else if ($(this).parents('fieldset').attr('id') == 'RightPanel') {
        switch ($(this).attr('id')) {
            case 'groups-tab':
                $('#RightPanel .toolkit>div').css('background-color', 'var(--group-h)');
                activedTab = '#groups';
                $('#cate-toolkit .status-switch').toggle(true);
                break;
            case 'teachers-tab':
                $('#RightPanel .toolkit:first>div').css('background-color', 'var(--teacher-h)');
                activedTab = '#teachers';
                $('#cate-toolkit .status-switch').toggle(false);
                break;
            case 'students-tab':
                $('#RightPanel .toolkit:first>div').css('background-color', 'var(--student-h)');
                activedTab = '#students';
                $('#cate-toolkit .status-switch').toggle(false);
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
        var activeTabHeight = parseInt($($(this).parents('fieldset').find('.ui-state-active a').first().attr('href')).find('.list-group').css('height'));
        var newHeight = (h - parseInt($('.toolkit').css('height')) - divHight) / 2 - 90;
        if (newHeight > activeTabHeight) {
            $(this).prev().css('height', activeTabHeight + "px");
        } else {
            $(this).prev().css('height', newHeight + "px");
        }
    }
};

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

function dropEnd(event, item) {
    $(event.target).css('opacity', '100%');
    $('main').css('cursor', 'default');
    var parent = $(event.target);
    var showCate = null,
        showItem = null;
    if (parent.hasClass('highlight')) {
        showCate = parent.attr('id');
    }

    var requestData = Array();

    var cate_id = $(event.target).attr("id").split('_')[1];
    var cate = $(event.target).attr("id").split('_')[0];
    var rowData = Array();
    if (dragitem != null) {
        // var category = dragitem[0].split('_')[0];
        dragitem.map(function(droppeditem) {

            // console.log(droppeditem.split('_')[1]);
            if (cate == "group") {
                var cate_items = $("#" + droppeditem).find('input[name="item-group"]').val();
                if (cate_items.indexOf(cate_id) == -1) {
                    cate_items += "_" + cate_id;
                }
                $("#" + droppeditem).find('input[name="item-group"]').val(cate_items);
            } else {
                var cate_item = $("#" + droppeditem).find('input[name="item-' + cate + '"]').val();
                if (cate_item != cate_id) {
                    $("#" + droppeditem).find('input[name="item-' + cate + '"]').val(cate_id);
                    // console.log($("#" + item).find('input[name="item-' + cate + '"]').val());
                }
            }
            rowData = {};
            rowData.id = droppeditem.split('_')[1];
            rowData.target = $("#" + droppeditem).find('input[name="item-' + cate + '"]').val();
            rowData.flag = true;

            requestData.push(rowData);
            if ($('#' + droppeditem).hasClass('highlight')) {
                showItem = droppeditem;
            }
        });

        $.post({
            url: baseURL + '/userjointo' + cate,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'data': JSON.stringify(requestData)
            }
        }).done(function(data) {

            if (showCate) {
                $('#div_C #' + showCate + " .item-show").click();
            }
            if (showItem) {
                $('#div_A #' + showItem + " .item-show").click();
            }
            if (dragitem[0]) {
                notification(dragitem.length + ' ' + dragitem[0].split('_')[0] + 's linked to ' + $(event.target).find('.item-name').html() + '!', 1);
            }
            requestData = [];
        }).fail(function(err) {
            notification("Sorry, You have an error!", 2);
            requestData = [];
        }).always(function(data) {
            console.log(data);
            dragitem = null;
        });
    }
    $("#LeftPanel").find('.list-group-item').each(function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
    });
}

function companyDropEnd(event, item) {
    $(event.target).css('opacity', '100%');
    if (dragitem != null && dragitem[0].split('_')[0] == 'company') {
        $(this).html(dragitem.map(function(om, t, rr) {
            return $('#' + om + " .item-name").html();
        }).join(', ') + "&nbsp <i>X</i>");
        var companyName = dragitem.map(function(e, i, r) {
            return e.split('_')[1];
        });
        $(this).val(companyName.join('_'));
        console.log(dragitem[0]);
        searchfilter(event);

        $(activedTab).fadeIn(1);
        $('#companies').fadeOut(1);
    }
    dragitem = null;
    $('.filter-company-btn').change();
}

function functionDropEnd(event, item) {
    $(event.target).css('opacity', '100%');
    if (dragitem != null && dragitem[0].split('_')[0] == 'function') {
        $(this).html(dragitem.map(function(om, t, rr) {
            return $('#' + om + " .item-name").html();
        }).join(', ') + "&nbsp <i>X</i>");
        var companyName = dragitem.map(function(e, i, r) {
            return e.split('_')[1];
        });
        $(this).val(companyName.join('_'));
        console.log(dragitem[0]);
        searchfilter(event);

        $(activedTab).fadeIn(1);
        $('#positions').fadeOut(1);
    }
    dragitem = null;
    $('.filter-function-btn').change();
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

    $(".filter-company-btn").on('drop', companyDropEnd);
    $(".filter-function-btn").on('drop', functionDropEnd);
});
$('input[name=status], input.search-filter, button.filter-company-btn, button.filter-function-btn').change(searchfilter);
$('input.search-filter').on('keydown change keyup', searchfilter);
$("button.filter-company-btn, button.filter-function-btn").on('drop', searchfilter);

$(".list-group-item").dblclick(itemDBClick);
$("#RightPanel .list-group-item").click(rightItemClick);

$(".list-group-item button.btn").click(btnClick);

$('.item-delete').click(itemDelete);

$('.toolkit-add-item').click(toolkitAddItem);
$('form input, form select').change(formInputChange);
$('#user-status-icon, #cate-status-icon').change(formStatusChange);
$('.submit-btn').click(submitBtn);

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
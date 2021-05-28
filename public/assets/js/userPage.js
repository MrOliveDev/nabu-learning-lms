// const { nodeName } = require("jquery");

// const { parseHTML } = require("jquery");

// const { forEach } = require("lodash");

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

var userDateSort = false,
    userNameSort = false,
    cateDateSort = false,
    cateNameSort = false,
    showDateSort = false,
    showNameSort = false;

// Dashmix.helpers('notify', {message: 'Your message!'});

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

var countDisplayUser = function(event) {
    $('#member-count').html($(this).find('.list-group-item').length + " members");
};

var clearClassName = function(i, highlighted) {
    $(highlighted).find(".btn").each(function(index, btnelement) {
        $(btnelement).removeClass("active");
    });
    if ($(highlighted).hasClass('highlight')) {
        $(highlighted).removeClass('highlight');
    }
};

var toggleBtnChange = function() {
    $(this).find('.toggle2-btn').toggle(false);
    $(this).find('.toggle1-btn').toggle(true);
    $(this).removeClass('select-active');
};

var itemDBClick = function() {
    $(this).parents('.list-group').children(".list-group-item").each(function(i, e) {
        if ($(e).hasClass("active")) {
            $(e).removeClass("active");
        }
    });
};

// $("#RightPanel .list-group-item").click(function(e) {
//     $(this).parents('.list-group').children(".list-group-item").each(function(i, e) {
//         if ($(e).hasClass("active")) {
//             $(e).removeClass("active");
//         }
//     });
//     $(this).addClass('active');
// });

var leftItemClick = function(e) {
    // e.stopPropagation();
    if (!$(this).hasClass("active")) {
        $(this).addClass("active");
        $(this).attr('draggable', true);
    } else {
        $(this).removeClass("active");
        $(this).attr('draggable', false);
    }

};

var btnClick = function(e) {
    if (!$(this).hasClass('toggle2-btn')) {
        e.stopPropagation();
        $(this).parents('.window').find('.list-group-item').each(clearClassName);
        $(this).parents('.list-group-item').addClass('highlight');
        switch ($(this).parents('.window').attr("id")) {
            case "div_A":
                if ($('#div_D').find('.highlight').length != 0)
                    $('#div_D').find('.highlight').each(function(i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function(i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;
            case "div_B":
                if ($('#div_C').find('.highlight').length != 0 && activedTab == '#groups')
                    $('#div_C').find('.highlight').each(function(i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function(i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;
            case "div_C":
                if ($('#div_B').find('.highlight').length != 0 && activedTab == '#groups')
                    $('#div_B').find('.highlight').each(function(i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function(i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;
            case "div_D":
                if ($('#div_A').find('.highlight').length != 0)
                    $('#div_A').find('.highlight').each(function(i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function(i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;

            default:
                break;
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
    element.find('.list-group-item').detach();
};

var clearFrom = function(element) {
    element.find('input, select').each(function(i, forminput) {
        if ($(forminput).attr('name') != '_token' && $(forminput).attr('name') != '_method') {
            $(forminput).val('');
        }
    });
    if (element.has('#preview').length != 0) {
        element.find('#preview').attr('src', '');
    }

};

//@param : div_b | div_d
var toggleFormOrTable = function(element, flag = null, flag1 = true) {
    var form = element.find('form');
    var table = element.find('.second-table');
    clearFrom(form);
    clearTable(table);
    if (flag1) {
        if (flag) {
            if (form.css('display') == "none") {

                form.css('display', 'block');
                table.css('display', 'none');

                return form;
            }
        } else if (!flag) {
            if (table.css('display') == "none") {
                form.css('display', 'none');
                table.css('display', 'block');

                return table;
            }
        } else if (flag == null) {
            if (table.css('display') == "block") {
                table.css('display', 'none');
                form.css('display', 'block');

                return form;
            } else {
                if (form.css('display') == "block") {
                    form.css('display', 'none');
                    table.css('display', 'block');

                    return table;
                }
            }
        }
    } else {
        form.toggle(false);
        table.toggle(false);

        return null;
    }

};

var goTab = function(name) {
    // console.log($('#' + name + '-tab')[0]);
    $('#' + name + '-tab').click();
};

// var contentFilter = function(element_id, str = '', comp = null, func = null, online = 0) {

//     var category = element_id.split('_')[0].split('-')[0];
//     var id = element_id.split('_')[1];
//     var data = {
//         'id': id,
//         'str': str,
//         'comp': comp,
//         'func': func,
//         'online': online
//     };
//     $.post(baseURL + "/userFind" + category + "/" + id, data)
//         .done(function(responseData) {
//             notification("Data Loaded!", 1);
//             return responseData;
//         })
//         .fail(function(err) {
//             notification('Sorry, You have an error!', 2);
//         }).always(function(data) {
//             console.log(data);
//         });;

// };
var toolkitToggleShowFilter = function(event) {
    var parent = $(this).parents('.toolkit');
    parent.children(".toolkit-filter").toggle();
    if (parent.attr('id') == 'user-toolkit') {
        var leftActiveTab = $('#LeftPanel .ui-state-active a').attr('href').split('#')[1];
        if (leftActiveTab == 'teachers' || leftActiveTab == 'authors') {
            parent.find('.filter-function-btn').toggle(false);
        } else {
            parent.find('.filter-function-btn').toggle(true);
        }

    }

    parent.children('.toolkit-filter input').each(function(i, e) {
        $(e).attr('checked', false);
    });
    parent.children('.search-filter').val('');
    parent.children('.filter-company-btn').html('company +<i></i>');
    parent.children('.filter-function-btn').html('function +<i></i>');

    parent.find('.search-filter').val('')
    parent.find('input[name=status]').each(function(i, e) {
        $(e).prop('checked', false);
    });
    parent.find('.filter-company-btn').val('');
    parent.find('.filter-company-btn').html('company +<i></i>');
    parent.find('.filter-function-btn').val('');
    parent.find('.filter-function-btn').html('function +<i></i>');
    searchfilter(event);

    switch (activedTab) {
        case '#groups':
            $('#cate-toolkit .status-switch').toggle(true);
            break;
        case '#companies':
            $('#cate-toolkit .status-switch').toggle(false);
            break;
        case '#positions':
            $('#cate-toolkit .status-switch').toggle(false);
            break;

        default:
            break;
    }
};

var secondShow1 = function(event) {
    var parent = $(this).parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];

    if ($(this).parents('fieldset').attr('id') == "RightPanel") {

        var item_group = parent.find('input[name="item-group"]').val();
        var arr_group = item_group.split('_');

        arr_group.map(function(group) {
            // console.log(group);
            $('#groups').find('.list-group-item').each(function(i, e) {
                if (group == $(this).attr('id').split('_')[1]) {
                    var element = $(e).clone(false);
                    var unlinkbtn = null;
                    var sectId = $(event.target).parents('.window').attr('id');
                    if (sectId == 'div_B' || sectId == 'div_D') {
                        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
                    } else {
                        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                    }
                    if (element.hasClass('highlight')) {
                        element.removeClass('highlight');
                        element.find('.btn.active').each(function(i, e) {
                            $(e).removeClass('active');
                        });
                    }

                    if (element.hasClass('active')) {
                        element.removeClass('active');
                    }
                    // unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                    element.find('.btn-group').append(unlinkbtn);
                    element.find('button.btn').click(btnClick);
                    element.find('.item-show').bind('click', divBDshow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').click(itemDelete);

                    element.toggle(true);
                    element.attr('data-src', parent.attr('id'));
                    element.parents('.list-group').attr('data-src', parent.attr('id'));
                    element.removeClass('active');
                    $("#table-groups .list-group").append(element);
                }
            });
        });

        if (!$(document).has("#user-form-tags"))
            grouptab.appendTo("#user-form-tags");

    } else if ($(this).parents('fieldset').attr('id') == "LeftPanel") {

        var activetab = $("#LeftPanel").find(".ui-state-active:first a").attr('href').split('#')[1];
        var items = $('#' + activetab).find('.list-group-item input[name="item-group"]');
        items.map(function(i, e) {
            // var item = $(e).parents('.list-group-item');
            var arr_group = $(e).val().split('_');
            var unlinkbtn = null;
            arr_group.map(function(group) {
                // console.log(group);
                if (id == group) {
                    var element = $(e).parents('.list-group-item').clone(false);
                    var sectId = $(event.target).parents('.window').attr('id');
                    if (sectId == 'div_B' || sectId == 'div_D') {
                        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                    } else {
                        unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
                    }
                    if (element.hasClass('highlight')) {
                        element.removeClass('highlight');
                        element.find('.btn.active').each(function(i, e) {
                            $(e).removeClass('active');
                        });
                    }
                    if (element.hasClass('active')) {
                        element.removeClass('active');
                    }
                    element.find('button.btn').click(btnClick);
                    element.find('.btn-group').append(unlinkbtn);
                    element.find('.item-show').bind('click', divBDshow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').click(itemDelete);

                    element.toggle(true);
                    element.attr('data-src', parent.attr('id'));
                    element.parents('.list-group').attr('data-src', parent.attr('id'));
                    element.removeClass('active');
                    $("#category-form-tags .list-group").append(element);
                }
            });
        });
    }
};

var divBDshow = function(event) {
    event.preventDefault();
    var parent = $(this).parents('fieldset');
    if (parent.attr('id') == "LeftPanel") {
        toggleFormOrTable($('#RightPanel'), false);
        $('.second-table .toolkit').css('background-color', 'var(--student-h)');
        $("#category-form-tags .list-group-item").css('background-color', 'var(--student-c)');
        $("#category-form-tags .list-group-item.active").css('background-color', 'var(--student-h)');
    } else {
        toggleFormOrTable($('#LeftPanel'), false);
    }
};

var divACshow = function(event) {
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, false);
};

var toolkitAddItem = function(event) {
    event.preventDefault();
    event.stopPropagation();
    toggleFormOrTable($(this).parents('fieldset'), true);
    if ($('#groups-tab').parents('li').hasClass('ui-state-active')) {
        $('#status-form-group').css('display', 'block');
        $('#cate-status-icon').val('true');
        $('#cate-status-icon').prop('checked', true);
    } else {
        $('#status-form-group').css('display', 'none');
        $('#user-status-icon').val('true');
        $('#user-status-icon').prop('checked', true);
    }
    var parent = $(this).parents('fieldset');
    var parent_id = parent.attr('id');
    var activeTagName;
    if (parent_id == 'RightPanel') {
        activeTagName = $('#RightPanel').find('.ui-state-active:first a').attr('href');
        $('#div_B').find('.list-group-item').each(clearClassName);
        switch (activeTagName) {
            case '#groups':
                $("#category_form").attr('action', baseURL + '/group');
                $('#status_checkbox').css('display', 'block');
                $('#category_status').attr("checked", 'checked');

                $('#category_form').attr('data-item', '');

                $("#category_form .method-select").val('POST');
                break;
            case '#companies':
                $("#category_form").attr('action', baseURL + '/company');
                $('#status_checkbox').css('display', 'none');

                $('#category_form').attr('data-item', '');

                $("#category_form .method-select").val('POST');
                break;
            case '#positions':
                $("#category_form").attr('action', baseURL + '/function');
                $('#status_checkbox').css('display', 'none');

                $('#category_form').attr('data-item', '');

                $("#category_form .method-select").val('POST');
                break;

            default:
                console.log('There is some error adding new component');
                break;
        }


    } else {
        activeTagName = $('#LeftPanel').find('.ui-state-active:first a').attr('href');
        $('#div_A').find('.list-group-item').each(clearClassName);
        $('#user_form').attr('action', baseURL + '/user');

        $('#user_form').attr('data-item', '');

        $("#user_form .method-select").val('POST');

        // $('#password').attr('disabled', false);
        $('#password').attr('placeholder', '');
        $('#preview').attr('src', baseURL + '/assets/media/default.png');
        $('#generatepassword').prop('checked', false);

        switch (activeTagName) {
            case '#students':
                $('#user_type').val('4');
                $('#login-label').html('Login Student');

                if ($('#expired_date_input .input-group').length == 0) {
                    expired_date.appendTo($('#expired_date_input'));
                }
                break;
            case '#teachers':
                $('#user_type').val('3');
                $('#login-label').html('Login Teacher');

                if ($('#expired_date_input .input-group').length == 0) {
                    expired_date.appendTo($('#expired_date_input'));
                }
                break;
            case '#authors':
                $('#user_type').val('2');
                $('#login-label').html('Login Author');

                if ($('#expired_date_input .input-group').length != 0) {
                    expired_date = $('#expired_date_input .input-group');
                    expired_date.appendTo($('#expired_date_input'));
                }

                break;

            default:
                break;
        }
        // $.get({
        //     url: baseURL + "/usercreate",
        //     success: function(data) {
        //         notification('Initialized success!', 1);
        //         $('#login').val(data.name);
        //         $('#preview').attr('src', baseURL + '/assets/media/default.png');
        //         $('#password').val(data.password);
        //         $('#password').attr('data-password', data.password);
        //     },
        //     error: function(err) {
        //         notification("Sorry, You can't init the form!", 2);
        //     }
        // })
    }
};

var divACedit = function(event) {
    // event.stopPropagation();
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, true);
};

var divBDedit = function(event) {
    // event.stopPropagation();
    var parent = $(this).parents('fieldset');
    if (parent.attr('id') == "LeftPanel") {
        toggleFormOrTable($('#RightPanel'), true);
    } else {
        toggleFormOrTable($('#LeftPanel'), true);
    }
};

var divAshow = function(event) {
    var parent = $(this).parents('.list-group-item');
    // var id = parent.attr('id').split('_')[1];

    var item_group = parent.find('input[name="item-group"]').val();
    var arr_group = item_group.split('_');

    arr_group.map(function(group) {
        // console.log(group);
        $('#groups').find('.list-group-item').each(function(i, e) {
            if (group == $(e).attr('id').split('_')[1]) {
                var element = $(e).clone(false);
                var unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
                element.find('.btn-group').append(unlinkbtn);
                element.find('button.btn').click(btnClick);
                element.find('.item-show').bind('click', divBDshow);
                element.find('.item-show').bind('click', secondShow1);
                element.find('.item-edit').bind('click', itemEdit);
                element.find('.item-delete').click(itemDelete);

                if (element.hasClass('highlight')) {
                    element.removeClass('highlight');
                    element.find('.btn.active').each(function(i, e) {
                        $(e).removeClass('active');
                    });
                }
                if (element.hasClass('active')) {
                    element.removeClass('active');
                }
                element.find('button.btn').click(btnClick);

                element.toggle(true);
                element.attr('data-src', parent.attr('id'));
                element.parents('.list-group').attr('data-src', parent.attr('id'));
                element.removeClass('active');
                $("#table-groups .list-group").append(element);
            }
        });
    });
};

var divCshow = function(event) {
    var parent = $(this).parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];
    var cate = parent.attr('id').split('_')[0];
    var activetab = $("#LeftPanel").find(".ui-state-active:first a").attr('href').split('#')[1];
    var items = $('#' + activetab).find('.list-group-item input[name="item-' + cate + '"]');
    items.map(function(i, e) {
        var item = $(e).parents('.list-group-item');
        if (cate == 'group') {
            var arr_group = $(e).val().split('_');
            arr_group.map(function(group) {
                // console.log(group);
                if (id == group) {
                    var element = item.clone(false);
                    unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                    element.find('.btn-group').append(unlinkbtn);
                    element.find('button.btn').click(btnClick);
                    element.find('.item-show').bind('click', divBDshow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', itemEdit);
                    element.find('.item-delete').click(itemDelete);
                    if (element.hasClass('highlight')) {
                        element.removeClass('highlight');
                        element.find('.btn.active').each(function(i, e) {
                            $(e).removeClass('active');
                        });
                    }
                    if (element.hasClass('active')) {
                        element.removeClass('active');
                    }
                    element.toggle(true);
                    element.attr('data-src', parent.attr('id'));
                    element.parents('.list-group').attr('data-src', parent.attr('id'));
                    element.removeClass('active');
                    $("#category-form-tags .list-group").append(element);
                }
            });
        } else {
            var cateVal = $(e).val();
            // console.log(group);
            if (id == cateVal) {
                var element = item.clone(false);
                unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                element.find('.btn-group').append(unlinkbtn);
                element.find('button.btn').click(btnClick);
                element.find('.item-show').bind('click', divBDshow);
                element.find('.item-show').bind('click', secondShow1);
                element.find('.item-edit').bind('click', itemEdit);
                element.find('.item-delete').click(itemDelete);
                if (element.hasClass('highlight')) {
                    element.removeClass('highlight');
                    element.find('.btn.active').each(function(i, e) {
                        $(e).removeClass('active');
                    });
                }
                if (element.hasClass('active')) {
                    element.removeClass('active');
                }
                element.toggle(true);
                element.attr('data-src', parent.attr('id'));
                element.parents('.list-group').attr('data-src', parent.attr('id'));
                element.removeClass('active');
                $("#category-form-tags .list-group").append(element);
            }
        }
    });

    //TODO:
    switch ($('#LeftPanel .ui-state-active a').attr('href')) {
        case '#students':
            $('.second-table .toolkit').css('background-color', 'var(--student-h)');
            $("#category-form-tags .list-group-item").css('background-color', 'var(--student-c)');
            $("#category-form-tags .list-group-item.active").css('background-color', 'var(--student-h)');
            $('#show-toolkit .filter-function-btn').toggle(true);
            break;
        case '#teachers':
            $('.second-table .toolkit').css('background-color', 'var(--teacher-h)');
            $("#category-form-tags .list-group-item").css('background-color', 'var(--teacher-c)');
            $("#category-form-tags .list-group-item.active").css('background-color', 'var(--teacher-h)');
            $('#show-toolkit .filter-function-btn').toggle(false);
            break;
        case '#authors':
            $('.second-table .toolkit').css('background-color', 'var(--author-h)');
            $("#category-form-tags .list-group-item").css('background-color', 'var(--author-c)');
            $("#category-form-tags .list-group-item.active").css('background-color', 'var(--author-h)');
            break;
            $('#show-toolkit .filter-function-btn').toggle(false);
        default:
            break;
    }

};

var formInputChange = function(event) {
    console.log($(event.target).val());
};

var item_edit = function(element) {
    var parent = element.parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];

    if ($('#groups-tab').parents('li').hasClass('ui-state-active')) {
        $('#status-form-group').css('display', 'block');
    } else {
        $('#status-form-group').css('display', 'none');
    }
    switch (element.attr('data-content')) {
        case 'student':
        case 'teacher':
        case 'author':
            $('#user_form .method-select').val('PUT');
            // $('#password').attr('disabled', false);
            $.get({
                url: baseURL + '/user/' + id,
                success: function(data, state) {
                    notification('We got user data successfully!', 1);
                    console.log(state);
                    toggleFormOrTable($('#LeftPanel'), true);
                    clearFrom($('LeftPanel'));
                    if (data.user_info.interface_icon == null || data.user_info.interface_icon == "") {
                        $('#preview').attr('src', baseURL + '/assets/media/default.png');
                    } else {
                        $('#preview').attr('src', data.user_info.interface_icon);
                        $('#base64_img_data').val(data.user_info.interface_icon);
                    }
                    $('#user_form').attr('data-item', parent.attr('id'));

                    $('#login').val(data.user_info.login);
                    $('#expired_date').val(data.user_info.expired_date);
                    $('#password').attr('placeholder', "Private password");
                    $('#generatepassword').prop('checked', false);
                    $('#firstname').val(data.user_info.first_name);
                    $('#lastname').val(data.user_info.last_name);
                    $('#company').val(data.user_info.company);
                    $('#position').val(data.user_info.function);
                    $("#user_form").attr('action', baseURL + '/user/' + id);
                    $('#status-form-group').css('display', 'block !important');
                    switch (data.user_info.type) {
                        case 2:
                            $('#login-label').html('Login Author');
                            if ($('#expired_date_input .input-group').length != 0) {
                                expired_date = $('#expired_date_input .input-group');
                                $('#expired_date_input .input-group').detach();
                            }
                            break;
                        case 4:
                            $('#login-label').html('Login Student');
                            if ($('#expired_date_input .input-group').length == 0) {
                                expired_date.appendTo($('#expired_date_input'));
                            }
                            break;
                        case 3:
                            $('#login-label').html('Login Teacher');

                            if ($('#expired_date_input .input-group').length == 0) {
                                expired_date.appendTo($('#expired_date_input'));
                            }
                            break;

                        default:
                            break;
                    }

                    if (data.user_info.contact_info != null && data.user_info.contact_info != "") {
                        $('#contact_info').val(JSON.parse(data.user_info.contact_info).address);
                        $('#user-email').val(JSON.parse(data.user_info.contact_info).email);
                    }

                    $('#user-status-icon').prop('checked', data.user_info.status == 1).change();
                    // $("#user_form").prop('method', "PUT");

                },
                error: function(err) {
                    notification("Sorry, You can't get user data!", 2);
                }
            });

            break;

        case 'group':
            $.get({
                url: baseURL + '/group/' + id,
                success: function(data, state) {
                    notification('We got group data successfully!', 1);
                    console.log(state);
                    toggleFormOrTable($('#RightPanel'), true);
                    clearFrom($('RightPanel'));
                    $('#category_name').val(data.name);
                    $('#category_description').val(data.description);
                    $('#status_checkbox').css('display', 'block');
                    $('#cate-status-icon').prop("checked", data.status == 1).change();
                    $('#cate-status').val(data.status);

                    $('#category_form').attr('data-item', parent.attr('id'));

                    $("#category_form").attr('action', baseURL + '/group/' + id);

                    $('#category_form .method-select').val('PUT');
                },
                error: function(err) {
                    notification("Sorry, You can't get group data!", 2);
                }
            });
            break;

        case 'company':
            $.get({
                url: baseURL + '/company/' + id,
                success: function(data, state) {
                    notification('We got company data successfully!', 1);
                    console.log(state);
                    toggleFormOrTable($('#RightPanel'), true);
                    clearFrom($('RightPanel'));
                    $('#category_name').val(data.name);
                    $('#category_description').val(data.description);
                    $('#status_checkbox').css('display', 'none');

                    $('#category_form').attr('data-item', parent.attr('id'));
                    $("#category_form").attr('action', baseURL + '/company/' + id);

                    $('#category_form .method-select').val('PUT');

                },
                error: function(err) {
                    notification("Sorry, You can't get company data!", 2);
                }
            });
            break;

        case 'position':
            $.get({
                url: baseURL + '/function/' + id,
                success: function(data, state) {
                    notification('We got position data successfully!', 1);
                    console.log(state);
                    toggleFormOrTable($('#RightPanel'), true);
                    clearFrom($('RightPanel'));

                    $('#category_name').val(data.name);
                    $('#category_description').val(data.description);
                    $('#status_checkbox').css('display', 'none');

                    $('#category_form').attr('data-item', parent.attr('id'));
                    $("#category_form").attr('action', baseURL + '/function/' + id);

                    $('#category_form .method-select').val('PUT');

                },
                error: function(err) {
                    notification("Sorry, You can't get position data!", 2);
                }
            });
            break;

        case 'session':
            notification('There is no session for this user', 1);
            break;

        default:
            notification('How dare you can do this!<br>Please contact me about this error :)');
            break;
    }
};

var itemEdit = function(event) {
    item_edit($(this));
};

var formStatusChange = function(e) {
    $(this).val($(this).prop('checked'));
};

var item_delete = function(element) {
    var parent = element.parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];
    switch (element.attr('data-content')) {
        case 'student':
        case 'teacher':
        case 'author':
            $.ajax({
                type: "DELETE",
                url: baseURL + '/user/' + id,
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
            break;

        case 'group':
            $.ajax({
                type: "DELETE",
                url: baseURL + '/group/' + id,

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
            break;

        case 'company':
            $.ajax({
                type: "DELETE",
                url: baseURL + '/company/' + id,

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
            break;

        case 'position':
            $.ajax({
                type: "DELETE",
                url: baseURL + '/function/' + id,

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
            break;

        case 'session':
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
            break;

        default:
            break;
    }
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

var submitFunction = function(event) {
    console.log($(this).attr('action'));
    console.log($("#cate-status").attr("checked"));

    return false;
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
        if (element.parents('fieldset').attr('id') == 'RightPanel') {
            toggleFormOrTable($("#LeftPanel"), false, false);
        } else {
            toggleFormOrTable($("#RightPanel"), false, false);
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

var submitBtn = function(event) {
    var formname = $(this).attr('data-form');
    var inputpassword = document.getElementById('password');
    var validate = true;
    document.getElementById(formname).checkValidity();
    var regularExpression = new RegExp("^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[!%&@#$^*?_~+={}().,\/<>-]).*$");

    var password = $('#password').val();
    if (formname == 'user_form') {
        validate = validate && $("#expired_date")[0].checkValidity();
        validate = validate && $("#login")[0].checkValidity();
        validate = validate && $("#contact_info")[0].checkValidity();
        validate = validate && $("#user-email")[0].checkValidity();
        validate = validate && $("#lastname")[0].checkValidity();
        validate = validate && $("#firstname")[0].checkValidity();
        if (password == '' || password == null) {
            if ($('#password').attr('placeholder') == '') {
                validate = false;
                inputpassword.setCustomValidity('bad password');
                inputpassword.reportValidity();
            }
        } else {
            if (!regularExpression.test(password)) {
                validate = false;
                inputpassword.setCustomValidity('bad password');
                inputpassword.reportValidity();
            }
        }


        if ($('#expired_date').val() == '' || $('#expired_date').val() == null) {
            validate = false;
            // document.getElementById('expired_date').setCustomValidity('You have to insert date');
            // document.getElementById('expired_date').reportValidity();
            notification('You have to insert date', 2);
        }
    } else if (formname == 'cate_form') {
        validate = validate && $("#category_description")[0].checkValidity();
        validate = validate && $("#category_name")[0].checkValidity();
    }

    if (validate) {
        event.preventDefault(); // stops the "normal" <form> request, so we can post using ajax instead, below
        var submit_data = Array();

        $('#' + formname).find('input, switch').each(function(i, e) {
            submit_data[$(e).attr('name')] = $(e).val();
        });

        console.log($('#' + formname).serializeArray());
        var serialval = $('#' + formname).serializeArray().map(function(item) {
            var arr = {};
            if (item.name == 'user-status-icon') {
                item.value = $('#user-status-icon').prop('checked') == true ? 1 : 0;
            } else if (item.name == 'cate-status-icon') {
                item.value = $('#cate-status-icon').prop("checked") == true ? 1 : 0;
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
            } else {
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
            } else {
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
                    var arr_url = $('#' + formname).attr('action').split('/');
                    var groupName = arr_url[arr_url.length - 1];
                    switch (groupName) {
                        case 'user':

                            notification('User added successfully!', 1);
                            switch ($("#user_type").val()) {
                                case '4':
                                    $('#students .list-group').append(createUserData(data, 'student'));
                                    break;

                                case '3':
                                    $('#teachers .list-group').append(createUserData(data, 'teacher'));
                                    break;

                                case '2':
                                    $('#authors .list-group').append(createUserData(data, 'author'));
                                    break;

                                default:
                                    break;
                            }
                            break;
                        case 'group':
                            notification('The group has been saved sucessfully!', 1);
                            $('#groups .list-group').append(createGroupData(data, 'group'));
                            break;
                        case 'company':
                            notification('The company has been saved sucessfully!', 1);
                            $('#companies .list-group').append(createCategoryData(data, 'company'));
                            $('#company').append('<option value="' + data.id + '">' + data.name + '</option>');
                            break;
                        case 'function':
                            notification('The position has been saved sucessfully!', 1);
                            $('#positions .list-group').append(createCategoryData(data, 'function'));
                            $('#position').append('<option value="' + data.id + '">' + data.name + '</option>');
                            break;

                        default:
                            break;
                    }
                } else {
                    var target = $("#" + formname).attr('data-item');
                    switch (target.split('_')[0]) {
                        case 'student':
                        case 'teacher':
                        case 'author':
                            updateUserData(data, target);
                            break;
                        case 'group':
                            updateGroupData(data, target);
                            break;
                        case 'company':
                            updateCategoryData(data, target);
                            break;
                        case 'function':
                            updateCategoryData(data, target);
                            break;

                        default:
                            break;
                    }
                }
            },
            error: function(err) {
                notification("Sorry, You have an error!", 2);
            }
        });
        var type = $('#user_type').val();
        submit_data = null;
        toggleFormOrTable($(this).parents('fieldset'), true, false);
        $('#user_type').val(type);
    }
    if ($("#" + formname).attr('data-item') != '' && $("#" + formname).attr('data-item') != null) {
        var targetName = $("#" + formname).attr('data-item').split('_')[0],
            sourceId;
        if (targetName == 'student' || targetName == 'author' || targetName == 'teacher') {
            sourceId = $("#user_form").attr('data-item');
        } else {
            sourceId = $("#cate_form").attr('data-item');
        }
        $('#' + sourceId).toggleClass('highlight', false);
        $('#' + sourceId + ' .item-edit').toggleClass('active', false);
    }

};

var createUserData = function(data, category) {

    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var userItem = $('<a class="list-group-item list-group-item-action  p-1 border-0" id="' + category + '_' + data.id + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.first_name + '&nbsp;' + data.last_name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.first_name + data.last_name + '">' +
        '<input type="hidden" name="item-group" value="' + data.linked_groups + '">' +
        '<input type="hidden" name="item-company" value="' + data.company + '">' +
        '<input type="hidden" name="item-function" value="' + data.function+'">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '<span class=" p-2 font-weight-bolder">EN</span>' +
        '</div>' +
        '</a>');
    var showbtn = $('<button class="btn  item-show" data-content="' + category + '">' +
        '<i class="px-2 fa fa-eye"></i>' +
        '</button>');

    var editbtn = $('<button class="btn item-edit" data-content="' + category + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>');

    var deletebtn = $('<button class="btn item-delete" data-content="' + category + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>');
    showbtn.attr('drag', false);

    showbtn.click(btnClick);
    showbtn.click(divACshow);
    showbtn.click(divAshow);

    editbtn.click(btnClick);
    editbtn.click(itemEdit);
    editbtn.click(divACedit);

    deletebtn.click(btnClick);
    deletebtn.click(itemDelete);

    userItem.dblclick(itemDBClick);
    userItem.find('.btn-group').append(showbtn).append(editbtn).append(deletebtn);
    userItem.click(leftItemClick);

    userItem.find('.item-name').val(data.first_name + data.last_name);
    userItem.bind('dragstart', dragStart);

    return userItem;

};

var createGroupData = function(data, category) {
    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var groupItem = $('<a class="list-group-item list-group-item-action p-1 border-0 " id="' + category + '_' + data.id + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.name + '">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '<button class="btn  toggle1-btn  item-show" data-content="' + category + '">' +
        '<i class="px-2 fa fa-eye"></i>' +
        '</button>' +
        '<button class="btn item-edit toggle1-btn" data-content="' + category + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>' +
        '<button class="btn item-delete toggle1-btn" data-content="' + category + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>' +
        '<button class="btn  toggle2-btn" data-content="' + category + '">' +
        '<i class="px-2 fas fa-check-circle"></i>' +
        '</button>' +
        '</div>' +
        '</a>');

    groupItem.attr('draggable', false);
    groupItem.on('drop', dropEnd);
    groupItem.on('dragover', dragOver);
    groupItem.on('dragleave', dragLeave);

    groupItem.find('button.btn').click(btnClick);
    groupItem.find('.item-edit').click(itemEdit);
    groupItem.find('.item-edit').click(divACedit);
    groupItem.find('.item-delete').click(itemDelete);
    groupItem.find('.item-show').click(divACshow);
    groupItem.find('.item-show').click(divCshow);

    return groupItem;
};

var createCategoryData = function(data, category) {
    var cateItem = $(' <a class="list-group-item list-group-item-action p-1 border-0 " id="' + category + '_' + data.id + '">' +
        ' <div class="float-left">' +
        '<span class="item-name">' + data.name + '</span>' +
        '<input type="hidden" name="item-status" value="">' +
        '<input type="hidden" name="item-name" value="' + data.name + '">' +
        ' </div>' +
        ' <div class="btn-group float-right">' +
        '<button class="btn  toggle1-btn  item-show" data-content="' + category + '">' +
        '<i class="px-2 fa fa-eye"></i>' +
        '</button>' +
        '<button class="btn item-edit toggle1-btn" data-content="' + category + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>' +
        '<button class="btn item-delete toggle1-btn" data-content="' + category + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>' +
        '<button class="btn  toggle2-btn" data-content="' + category + '">' +
        '<i class="px-2 fas fa-check-circle"></i>' +
        '</button>' +
        ' </div>' +
        '</a>');

    cateItem.attr('draggable', false);
    cateItem.on('drop', dropEnd);
    cateItem.on('dragover', dragOver);
    cateItem.on('dragleave', dragLeave);

    cateItem.find('button.btn').click(btnClick);
    cateItem.find('.item-edit').click(itemEdit);
    cateItem.find('.item-edit').click(divACedit);
    cateItem.find('.item-delete').click(itemDelete);
    cateItem.find('.item-show').click(divACshow);
    cateItem.find('.item-show').click(divCshow);

    return cateItem;
};

var updateUserData = function(data, target) {
    $('#' + target + ' .item-name').html(data.first_name + "&nbsp;" + data.last_name);
    $('#' + target + ' .status-notification').val(data.status);
    $('#' + target + ' .status-notification').prev().css('color', data.status == '1' ? 'green' : 'red');
    $('#' + target + ' input[name="item-name"]').val(data.name);
    $('#' + target + ' input[name="item-group]').val(data.linked_groups);
    $('#' + target + ' input[name="item-company]').val(data.company);
    $('#' + target + ' input[name="item-function]').val(data.function);

};

var updateGroupData = function(data, target) {
    $('#' + target + ' .item-name').html(data.name);
    $('#' + target + ' input[name="item-name"]').html(data.name);
    $('#' + target + ' .status-notification').val(data.status);
    $('#' + target + ' .status-notification').prev().css('color', data.status == '1' ? 'green' : 'red');
};

var updatCategoryData = function(data, target) {
    $('#' + target + ' .item-name').html(data.name);
    $('#' + target + ' input[name="item-name"]').val(data.name);
};

var cancelBtn = function(event) {
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, null, false);
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
    $('#' + category).find('.toggle1-btn').toggle(false);
    $('#' + category).find('.toggle2-btn').toggle(true);
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
//filter
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

    if (parent.prev().is('.nav')) {
        var selector = parent.prev().find('.ui-state-active a').attr('href').split('#')[1];
        // console.log(selector);
        items = $("#" + selector).find('.list-group .list-group-item');
    } else {
        items = parent.next('.list-group').find('.list-group-item');
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

};

var sortfilter = function(event) {
    var parent = $(event.target).parents('.toolkit');
    var $items = null,
        $itemgroup;
    var nameIcon = $(event.target).parents('.toolkit').find('.filter-name-btn i');
    var dateIcon = $(event.target).parents('.toolkit').find('.filter-date-btn i');

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

var cateStateIcon = function(e) {
    var el = $(this);
    if (el.is(':checked')) {
        $("#cate-status").val(1);
    } else {
        $("#cate-status").val(0);
    }
};

var tabClick = function(event) {
    if ($(this).parents('fieldset').attr('id') == 'LeftPanel') {

        toggleFormOrTable($('#div_B'), null, false);
        var nameIcon = $('#user-toolkit').find('.filter-name-btn i');
        var dateIcon = $('#user-toolkit').find('.filter-date-btn i');
        nameIcon.toggleClass('fa-sort-alpha-down', false);
        nameIcon.toggleClass('fa-sort-alpha-up', false);
        dateIcon.toggleClass('fa-sort-numeric-down', false);
        dateIcon.toggleClass('fa-sort-numeric-up', false);

        switch ($(this).attr('id')) {
            case 'students-tab':
                $('#LeftPanel .toolkit>div').css('background-color', 'var(--student-h)');
                // $("#table-groups").toggle(true);
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
                break;
            case 'teachers-tab':
                $('#LeftPanel .toolkit>div').css('background-color', 'var(--teacher-h)');
                // $("#table-groups").toggle(false);
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

                if (activedTab != '#positions') {
                    $('#companies-tab').click();
                }

                $('#user-toolkit .filter-function-btn').toggle(false);
                break;
            case 'authors-tab':
                $('#LeftPanel .toolkit>div').css('background-color', 'var(--author-h)');
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
                $('#companies-tab').click();

                break;

            default:
                break;
        }
        $("#LeftPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });
        $('#div_A').find('.list-group-item').each(clearClassName);
        cancelFilterCategoryAll();
        $('#user-toolkit .search-filter').val('');
        $('#user-toolkit .search-filter').change();
    } else if ($(this).parents('fieldset').attr('id') == 'RightPanel') {
        switch ($(this).attr('id')) {
            case 'groups-tab':
                $('#RightPanel .toolkit:first>div').css('background-color', 'var(--group-h)');
                activedTab = '#groups';
                $('#cate-toolkit .status-switch').toggle(true);
                break;
            case 'companies-tab':
                $('#RightPanel .toolkit:first>div').css('background-color', 'var(--company-h)');
                activedTab = '#companies';
                $('#cate-toolkit .status-switch').toggle(false);
                break;
            case 'positions-tab':
                $('#RightPanel .toolkit:first>div').css('background-color', 'var(--position-h)');
                activedTab = '#positions';
                $('#cate-toolkit .status-switch').toggle(false);
                break;

            default:
                break;
        }
        $('#RightPanel').find('.list-group-item').each(toggleBtnChange);

        toggleFormOrTable($('#div_D'), null, false);
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
    }
};

var handlerDBClick = function(event) {
    $(this).siblings('.window').find('.list-group').toggleClass('nolimit');
};
//////////////////////////////////
///////////////////////////////////
//////////////////////////////////

var dragitem = null;

function dragStart(event) {
    dragitem = Array();
    $(this).parents(".list-group").children('.active.list-group-item').each(function(i, dragelem) {
        dragitem.push($(dragelem).attr("id"));
    });
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

function dropEnd(event, item) {
    $(event.target).css('opacity', '100%');

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
        });

        // requestData.forEach(itemData => {
        //     itemData =JSON.stringify(itemData)
        // })

        $.post({
            url: baseURL + '/userjointo' + cate,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'data': JSON.stringify(requestData)
            }
        }).done(function(data) {
            notification(dragitem.length + ' ' + dragitem[0].split('_')[0] + 's linked to ' + $(event.target).find('.item-name').html() + '!', 1);
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


////

$(document).ready(function() {

    $(".pr-password").passwordRequirements({
        numCharacters: 8,
    });

    // var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));
    // $("#content").css({
    //     'max-height': h - $('#div-left').height() - $('.content-header').height() - $('.nav-tab').height()
    // });

    // if ($('#div_A, #div_C').css('height') > $('#content').css('height') * 0.7) {
    //     $('#div_A, #div_C').css('height', $('#content').css('height') * 0.7);
    // }

    $('#LeftPanel .toolkit>div').css('background-color', 'var(--student-h)');
    $('#RightPanel .toolkit:first>div').css('background-color', 'var(--group-h)');
    $('.second-table .toolkit').css('background-color', 'var(--student-h)');



    $("#RightPanel .list-group-item").each(function(i, elem) {
        $(elem).attr('draggable', false);
        $(elem).on('drop', dropEnd);

        elem.addEventListener('dragover', dragOver);
        elem.addEventListener('dragleave', dragLeave);
    });

    $("#LeftPanel .list-group-item").each(function(i, elem) {
        elem.addEventListener('dragstart', dragStart);
        $(elem).attr('drag', false);
    });

    $(".filter-company-btn").on('drop', companyDropEnd);
    $(".filter-function-btn").on('drop', functionDropEnd);

    // $(".filter-function-btn").on('dragstart', dragStart);
    // $(".filter-company-btn").on('dragstart', dragStart);

    // $(".filter-company-btn").on('dragover', dragOver);
    // $(".filter-company-btn").on('dragleave', dragLeave);

    // $(".filter-function-btn").on('dragover', dragOver);
    // $(".filter-function-btn").on('dragleave', dragLeave);

});
$('input[name=status], input.search-filter, button.filter-company-btn, button.filter-function-btn').change(searchfilter);
$('input.search-filter').on('keydown change keyup', searchfilter);
$("button.filter-company-btn, button.filter-function-btn").on('drop', searchfilter);

$(".list-group-item").dblclick(itemDBClick);
$("#LeftPanel .list-group-item").click(leftItemClick);

$(".list-group-item button.btn").click(btnClick);

$('.item-delete').click(itemDelete);

$('.item-edit').click(itemEdit);
$('#div_A .fa.fa-edit, #div_C .fa.fa-edit').click(divACedit);
$('#div_B .fa.fa-edit, #div_D .fa.fa-edit').click(divBDedit);

$('#div_A .item-show, #div_C .item-show').click(divACshow);
$('#div_B .item-show, #div_D .item-show').click(divBDshow);
$('#div_A .item-show').click(divAshow);
$('#div_C .item-show').click(divCshow);

$('.toolkit-add-item').click(toolkitAddItem);
$('form').submit(submitFunction);
$('form input, form select').change(formInputChange);
$('#user-status-icon, #cate-status-icon').change(formStatusChange);
$('.submit-btn').click(submitBtn);
$('.cancel-btn').click(cancelBtn);

$(".toolkit-show-filter").click(toolkitToggleShowFilter);
$('.filter-company-btn').click(filterCompanyBtn);
$('.filter-function-btn').click(filterFunctionBtn);
$('.filter-name-btn').click(sortfilter);
$('.filter-date-btn').click(sortfilter);
$("#cate-status-icon").change(cateStateIcon);
$('.toggle2-btn').click(toggle2Btn);

$('#table-user').on('DOMSubtreeModified', countDisplayUser);
$('.nav-link').click(tabClick);
$('.nav-link').click(tabClick);

$('.handler_horizontal').dblclick(handlerDBClick);

$('#generatepassword').change(function(event) {
    if ($(this).prop('checked') == true) {
        $.get({
            url: baseURL + "/usercreate",
            success: function(data) {
                notification('Initializing login and password success!', 1);
                $('#password').val(data.password);
                $('#password').attr('data-password', data.password);
                $('#login').val(data.name);
            },
            error: function(err) {
                notification('You have a problem getting new password!');
            }
        });
        // $('#password').attr('disabled', true);
    } else {
        // $('#password').attr('disabled', false);
    }
});


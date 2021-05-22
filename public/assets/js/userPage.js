// const { nodeName } = require("jquery");

// const { forEach } = require("lodash");

// var baseURL = window.location.protocol + "//" + window.location.host;

var baseURL = window.location.protocol + "//" + window.location.host + '/newlms';
var filteritem = null;
var grouptab = null,
    detailtags = null;
var detailtag1 = null;
var activedTab = '#groups';

var window_level = 1;

var input_group_position = null;

var notification = function(str) {
    $('#notificator').prop({
        'data-message': 'Link Success!'
    });
    $('#notificator').click();
};

// Dashmix.helpers('notify', {message: 'Your message!'});
$(document).ready(function() {

    //height controll
    // $('fieldset').each(function (element){
    //     element.
    // });

    var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));

    $("#content").css({
        'max-height': h - $('#div-left').height() - $('.content-header').height() - $('.nav-tab').height()
    });

    if ($('#div_A, #div_C').css('height') > $('#content').css('height') * 0.7) {
        $('#div_A, #div_C').css('height', $('#content').css('height') * 0.7);
    }

    $('#LeftPanel .toolkit>div').css('background-color', 'var(--student-h)');
    $('#RightPanel .toolkit:first>div').css('background-color', 'var(--group-h)');
    $('.second-table .toolkit').css('background-color', 'var(--student-h)');

    $('#students-tab').click(function() {
        $('#LeftPanel .toolkit>div').css('background-color', 'var(--student-h)');
        $('.second-table .toolkit').css('background-color', 'var(--student-h)');
        toggleFormOrTable($('#div_B'), null, false);
        $("#category-form-tags .list-group-item").css('background-color', 'var(--student-c)');
        $("#category-form-tags .list-group-item.active").css('background-color', 'var(--student-h)');
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

        $("#LeftPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_A').find('.list-group-item').each(clearClassName);
        cancelFilterCategoryAll();
    });
    $('#teachers-tab').click(function() {
        $('#LeftPanel .toolkit>div').css('background-color', 'var(--teacher-h)');
        $('.second-table .toolkit').css('background-color', 'var(--teacher-h)');
        toggleFormOrTable($('#div_B'), null, false);
        $("#category-form-tags .list-group-item").css('background-color', 'var(--teacher-c)');
        $("#category-form-tags .list-group-item.active").css('background-color', 'var(--teacher-h)');
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

        $("#LeftPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

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

        $('#div_A').find('.list-group-item').each(clearClassName);
        cancelFilterCategoryAll();
    });
    $('#authors-tab').click(function() {
        $('#LeftPanel .toolkit>div').css('background-color', 'var(--author-h)');
        $('.second-table .toolkit').css('background-color', 'var(--author-h)');
        toggleFormOrTable($('#div_B'), null, false);
        $("#category-form-tags .list-group-item").css('background-color', 'var(--author-c)');
        $("#category-form-tags .list-group-item.active").css('background-color', 'var(--author-h)');
        // $("#table-groups").toggle(false);
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

        $("#LeftPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_A').find('.list-group-item').each(clearClassName);
        cancelFilterCategoryAll();

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
    });


    $('#groups-tab').click(function() {
        $('#RightPanel .toolkit:first>div').css('background-color', 'var(--group-h)');
        $('#RightPanel').find('.list-group-item').each(toggleBtnChange);
        toggleFormOrTable($('#div_D'), null, false);


        $("#RightPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_C').find('.list-group-item').each(clearClassName);
        activedTab = '#groups';
        cancelFilterCategoryAll();

    });
    $('#companies-tab').click(function() {
        $('#RightPanel .toolkit:first>div').css('background-color', 'var(--company-h)');
        $('#RightPanel').find('.list-group-item').each(toggleBtnChange);
        toggleFormOrTable($('#div_D'), null, false);

        $("#RightPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_C').find('.list-group-item').each(clearClassName);
        activedTab = '#companies';
        cancelFilterCategoryAll();

    });
    $('#positions-tab').click(function() {
        $('#RightPanel .toolkit:first>div').css('background-color', 'var(--position-h)');
        $('#RightPanel').find('.list-group-item').each(toggleBtnChange);
        toggleFormOrTable($('#div_D'), null, false);

        $("#RightPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_C').find('.list-group-item').each(clearClassName);
        activedTab = '#positions';
        cancelFilterCategoryAll();

    });

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

    // $(".fliter-company-btn").on('drop', companyDropEnd);
    // $(".fliter-function-btn").on('drop', functionDropEnd);

    // $(".fliter-function-btn").on('dragstart', dragStart);
    // $(".fliter-company-btn").on('dragstart', dragStart);

    // $(".fliter-company-btn").on('dragover', dragOver);
    // $(".fliter-company-btn").on('dragleave', dragLeave);

    // $(".fliter-function-btn").on('dragover', dragOver);
    // $(".fliter-function-btn").on('dragleave', dragLeave);


    $('input[name=status], input.search-filter, button.fliter-company-btn, button.fliter-function-btn').change(searchfilter);
    $('input.search-filter').keypress(searchfilter);
    $("button.fliter-company-btn, button.fliter-function-btn").on('drop', searchfilter);
});


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


$(".list-group-item").dblclick(function() {
    $(this).parents('.list-group').children(".list-group-item").each(function(i, e) {
        if ($(e).hasClass("active")) {
            $(e).removeClass("active");
        }
    });
});

// $("#RightPanel .list-group-item").click(function(e) {
//     $(this).parents('.list-group').children(".list-group-item").each(function(i, e) {
//         if ($(e).hasClass("active")) {
//             $(e).removeClass("active");
//         }
//     });
//     $(this).addClass('active');
// });

$("#LeftPanel .list-group-item").click(function(e) {
    // e.stopPropagation();
    if (!$(this).hasClass("active")) {
        $(this).addClass("active");
        $(this).attr('draggable', true);
    } else {
        $(this).removeClass("active");
        $(this).attr('draggable', false);
    }

});

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

$(".list-group-item button.btn").click(btnClick);

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

var contentFilter = function(element_id, str = '', comp = null, func = null, online = 0) {

    var category = element_id.split('_')[0].split('-')[0];
    var id = element_id.split('_')[1];
    var data = {
        'id': id,
        'str': str,
        'comp': comp,
        'func': func,
        'online': online
    };
    $.post(baseURL + "/userFind" + category + "/" + id, data)
        .done(function(responseData) {
            console.log("Data Loaded: " + responseData);
            return responseData;
        })
        .fail(function(err) {
            console.log(err);
        }).always(function(data) {
            console.log(data);
        });;

};

$(".toolkit-show-filter").click(function(event) {
    var parent = $(this).parents('.toolkit');
    parent.children(".toolkit-filter").toggle();
    parent.children('.toolkit-filter input').each(function(i, e) {
        $(e).attr('checked', false);
    });
    parent.children('.search-filter').val('');
    parent.children('.fliter-company-btn').html('company +<i></i>');
    parent.children('.fliter-function-btn').html('function +<i></i>');

    parent.find('.search-filter').val('')
    parent.find('input[name=status]').each(function(i, e) {
        $(e).prop('checked', false);
    });
    parent.find('.fliter-company-btn').val('');
    parent.find('.fliter-company-btn').html('company +<i></i>');
    parent.find('.fliter-function-btn').val('');
    parent.find('.fliter-function-btn').html('function +<i></i>');
    searchfilter(event);
});

var secondLevelShow = function(event) {
    event.preventDefault();
    var parent = $(this).parents('fieldset');
    if (parent.attr('id') == "LeftPanel") {
        toggleFormOrTable($('#RightPanel'), false);
    } else {
        toggleFormOrTable($('#LeftPanel'), false);
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
                    element.find('.item-show').bind('click', secondLevelShow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').bind('click', function() {
                        itemDelete($(this), cate);
                    });
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
                    element.find('.item-show').bind('click', secondLevelShow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').bind('click', function() {
                        itemDelete($(this), cate);
                    });
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

$('#div_B .item-show, #div_D .item-show').click(secondLevelShow);

$('#div_A .item-show, #div_C .item-show').click(function(event) {
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, false);
});

$('.item-edit').click(function(event) {
    item_edit($(this));
});

$('.item-delete').click(function(event) {
    itemDelete($(this), $(this).attr('data-content'));
});

$('.toolkit-add-item').click(function(event) {
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
        switch (activeTagName) {
            case '#students':
                $('#user_type').val('4');
                $('#login-label').html('Login Student');
                break;
            case '#teachers':
                $('#user_type').val('3');
                $('#login-label').html('Login Teacher');
                break;
            case '#authors':
                $('#user_type').val('2');
                $('#login-label').html('Login Author');
                break;

            default:
                break;
        }
        $.get({
            url: baseURL + "/usercreate",
            success: function(data) {
                console.log(data);
                $('#login').val(data.name);
                $('#preview').attr('src', baseURL + '/assets/media/default.png');
                $('#password').val(data.password);
            },
            error: function(err) {
                console.log(err);
            }
        })
    }
});
$('#div_A .fa.fa-edit, #div_C .fa.fa-edit').click(function(event) {
    // event.stopPropagation();
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, true);
});

$('#div_B .fa.fa-edit, #div_D .fa.fa-edit').click(function(event) {
    // event.stopPropagation();
    var parent = $(this).parents('fieldset');
    if (parent.attr('id') == "LeftPanel") {
        toggleFormOrTable($('#RightPanel'), true);
    } else {
        toggleFormOrTable($('#LeftPanel'), true);
    }
});

$('#div_A .item-show').click(function(event) {
    var parent = $(this).parents('.list-group-item');
    // var id = parent.attr('id').split('_')[1];

    var item_group = parent.find('input[name="item-group"]').val();
    var arr_group = item_group.split('_');

    arr_group.map(function(group) {
        // console.log(group);
        $('#groups').find('.list-group-item').each(function(i, e) {
            if (group == $(this).attr('id').split('_')[1]) {
                var element = $(e).clone(false);
                var unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
                element.find('.btn-group').append(unlinkbtn);
                element.find('button.btn').click(btnClick);
                element.find('.item-show').bind('click', secondLevelShow);
                element.find('.item-show').bind('click', secondShow1);
                element.find('.item-edit').bind('click', function() {
                    item_edit($(this));
                });
                element.find('.item-delete').bind('click', function() {
                    itemDelete($(this), cate);
                });
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
});

$('#div_C .item-show').click(function(event) {
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
                    element.find('.item-show').bind('click', secondLevelShow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').bind('click', function(ev) {
                        itemDelete($(this), cate);
                    });
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
                element.find('.item-show').bind('click', secondLevelShow);
                element.find('.item-show').bind('click', secondShow1);
                element.find('.item-edit').bind('click', function() {
                    item_edit($(this));
                });
                element.find('.item-delete').bind('click', function() {
                    itemDelete($(this), cate);
                });
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
});

$('form input, form select').change(function(event) {
    console.log($(event.target).val());
})

$('form').submit(submitFunction);

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
            $.get({
                url: baseURL + '/user/' + id,
                success: function(data, state) {
                    console.log(data);
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
                    $('#password').val(data.user_info.password);
                    $('#firstname').val(data.user_info.first_name);
                    $('#lastname').val(data.user_info.last_name);
                    $('#company').val(data.user_info.company);
                    $('#position').val(data.user_info.function);
                    $("#user_form").attr('action', baseURL + '/user/' + id);
                    $('#status-form-group').css('display', 'block !important');
                    switch (data.user_info.type) {
                        case 2:
                            $('#login-label').html('Login Author');
                            break;
                        case 4:
                            $('#login-label').html('Login Student');
                            break;
                        case 3:
                            $('#login-label').html('Login Teacher');
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
                    console.log(err);
                }
            });

            break;

        case 'group':
            $.get({
                url: baseURL + '/group/' + id,
                success: function(data, state) {
                    console.log(data);
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
                    console.log(err);
                }
            });
            break;

        case 'company':
            $.get({
                url: baseURL + '/company/' + id,
                success: function(data, state) {
                    console.log(data);
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
                    console.log(err);
                }
            });
            break;

        case 'position':
            $.get({
                url: baseURL + '/function/' + id,
                success: function(data, state) {
                    console.log(data);
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
                    console.log(err);
                }
            });
            break;

        case 'session':
            console.log('There is no session for this user');
            break;

        default:
            console.log('how dare you can do this!');
            break;
    }
};


$('#user-status-icon, #cate-status-icon').change(function(e) {
    $(this).val($(this).prop('checked'));
});
// var item_show = function(element) {
//     var parent = element.parents('.list-group-item');
//     var id = parent.attr('id').split('_')[1];
//     switch (element.attr('data-content')) {
//         case 'student':
//             // $.get({
//             //     url: baseURL + '/user/' + id,
//             //     success: function (data, state) {
//             //         data.session.foreach(sessionItem=>{

//             //         })
//             //     },
//             //     error:function(err){

//             //     }});

//             break;

//         case 'teacher':

//             break;

//         case 'author':

//             break;

//         case 'group':

//             break;

//         case 'company':

//             break;

//         case 'position':

//             break;

//         case 'session':

//             break;

//         default:
//             break;
//     }
// };

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
                },
                error: function(err) {
                    console.log(err);
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
                },
                error: function(err) {
                    console.log(err);
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
                },
                error: function(err) {
                    console.log(err);
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
                },
                error: function(err) {
                    console.log(err);
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
                },
                error: function(err) {
                    console.log(err);
                }
            });
            break;

        default:
            break;
    }
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
        $("#" + showeditem).find('input[name="item-' + cate + '"]').val(combine(value, id).join('_'));
    } else {
        $("#" + showeditem).find('input[name="item-' + cate + '"]').val('');
    }

    var result = $("#" + showeditem).find('input[name="item-' + cate + '"]').val();

    detachCall(cate, {
        id: showeditem.split('_')[1],
        target: result,
        flag: false
    });

    if ($(this).parents('fieldset').attr('id') == 'RightPanel') {
        toggleFormOrTable($("#LeftPanel"), false, false);
    } else {
        toggleFormOrTable($("#RightPanel"), false, false);
    }
    parent.detach();
};

var detachLinkFrom = function(e) {
    var parent = $(this).parents('.list-group-item');
    var showeditem = parent.attr('data-src');
    var id = $("#" + showeditem).attr('id').split('_')[1];
    var cate = $("#" + showeditem).attr('id').split('_')[0];
    var value = parent.find('input[name="item-' + cate + '"]').val();
    if (cate == 'group') {
        parent.find('input[name="item-' + cate + '"]').val(combine(value, id).join('_'));
    } else {
        parent.find('input[name="item-' + cate + '"]').val('');
    }

    var result = parent.find('input[name="item-' + cate + '"]').val();
    var parent_id = parent.attr('id').split('_')[1];

    detachCall(cate, {
        id: parent_id,
        target: result,
        flag: false
    });

    if ($(this).parents('fieldset').attr('id') == 'RightPanel') {
        toggleFormOrTable($("#LeftPanel"), false, false);
    } else {
        toggleFormOrTable($("#RightPanel"), false, false);
    }
    parent.detach();
};

var combine = function(value, id) {
    var combineArray = value.split('_').map(function(item, i, d) {
        if (item != id) {
            return item;
        }
    });
    return combineArray;
};

var detachCall = function(cate, connectiondata) {
    $.post({
        url: baseURL + '/userjointo' + cate,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'data': JSON.stringify(Array(connectiondata))
        }
    }).then(function(data) {
        console.log(data);
    }).fail(function(err) {
        console.log(err);
    }).always(function(data) {
        console.log(data);
    });
};

$('.submit-btn').click(function(event) {
    var formname = $(this).attr('data-form');
    var validate = document.getElementById(formname).checkValidity();
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
                item.value = $('#user-status-icon').val() == 'true' ? 1 : 0;
            } else if (item.name == 'cate-status-icon') {
                item.value = $('#cate-status-icon').val() == 'true' ? 1 : 0;
            }
            return item;
        });
        if ($("#" + formname).find('input[type=checkbox]').val() == 'false') {
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
        console.log($('#' + formname).serializeArray());
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

                            switch ($("#user_type")) {
                                case '4':
                                    $('#students').append(makeUserData(data, 'student'));
                                    break;

                                case '3':
                                    $('#teachers').append(makeUserData(data, 'teacher'));
                                    break;

                                case '2':
                                    $('#authors').append(makeUserData(data, 'author'));
                                    break;

                                default:
                                    break;
                            }
                            break;
                        case 'group':
                            $('#groups').append(makeGroupData(data, 'group'));
                            break;
                        case 'company':
                            $('#companies').append(makeCategoryData(data, 'company'));
                            break;
                        case 'function':
                            $('#positions').append(makeCategoryData(data, 'function'));
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
                console.log(err);
            }
        });

        submit_data = null;
    }
});

var makeUserData = function(data, category) {

    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle text-success m-2"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle text-danger m-2"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    return '<a class="list-group-item list-group-item-action  p-1 border-0" id="' + category + '_' + data.id + '">' +
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
        '<button class="btn  item-show" data-content="' + category + '">' +
        '<i class="px-2 fa fa-eye"></i>' +
        '</button>' +
        '<button class="btn item-edit" data-content="' + category + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>' +
        '<button class="btn item-delete" data-content="' + category + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>' +
        '</div>' +
        '</a>';
};

var makeGroupData = function(data, category) {
    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle text-success m-2"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle text-danger m-2"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    return '<a class="list-group-item list-group-item-action p-1 border-0 " id="' + category + '_' + data.id + '">' +
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
        '</a>';
};
var makeCategoryData = function(data, category) {
    return ' <a class="list-group-item list-group-item-action p-1 border-0 " id="' + category + '_' + data.name + '">' +
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
        '</a>';
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

$('.cancel-btn').click(function(event) {
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, null, false);
});

$('.fliter-company-btn').click(function(event) {
    // var activedTab = $('#RightPanel').find('.ui-state-active a').attr('href');
    switch ($(this).html()) {
        case 'company +<i></i>':
            if ($(this).parents('.toolkit').find('.fliter-function-btn').html() != 'Cancel') {
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
});

$('.fliter-function-btn').click(function(event) {
    switch ($(this).html()) {
        case 'function +<i></i>':
            if ($(this).parents('.toolkit').find('.fliter-company-btn').html() != 'Cancel') {
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
});

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
    $('#' + category).fadeOut(1);
    $(activedTab).fadeIn(1);
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
    $('.fliter-function-btn').each(function(i, e) {
        if ($(e).html() != 'function +<i></i>') {
            $(e).html('function +<i></i>');
            $(e).val('');
            $('#positions').fadeOut(1);
            $(activedTab).fadeIn(1);
        }
    });
    $('.fliter-company-btn').each(function(i, e) {
        if ($(e).html() != 'company +<i></i>') {
            $(e).html('company +<i></i>');
            $(e).val('');
            $('#companies').fadeOut(1);
            $(activedTab).fadeIn(1);
        }
    });
}

$('.toggle2-btn').click(function(evt) {
    // evt.stopPropagation();
    var tooltipid = $(this).parents('.list-group').attr('data-filter');
    $(this).parents('.list-group-item').addClass('active');
    // $(this).parents('.list-group-item').attr('draggable', function(index, attr) {
    //     return attr == "true" ? false : true;
    // });
    if ($('#' + tooltipid).find('.fliter-function-btn').html() == 'Cancel') {
        toggleAndSearch($('#' + tooltipid).find('.fliter-function-btn'), 'positions', 'function +<i></i>');
    } else {
        toggleAndSearch($('#' + tooltipid).find('.fliter-company-btn'), 'companies', 'company +<i></i>');
    }
    $(this).parents('.list-group-item').removeClass('active');
    $(this).parents('.list-group-item').find('.btn.active').removeClass('active');
});

//filter

var searchfilter = function(event) {
    var parent = $(event.target).parents('.toolkit');
    var items = null;
    var str = parent.find('input.search-filter').val();
    var opt = parent.find('input[name=status]:checked').val();
    var ctgc = parent.find('button.fliter-company-btn').val();
    var ctgf = parent.find('button.fliter-function-btn').val();

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

        if (item_name.toLowerCase().indexOf(str) >= 0) {
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

$("#cate-status-icon").on('change', function(e) {
    var el = $(this);
    if (el.is(':checked')) {
        $("#cate-status").val(1);
    } else {
        $("#cate-status").val(0);
    }
});
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
            console.log(data);

            requestData = [];
        }).fail(function(err) {
            console.log(err);

            requestData = [];
        }).always(function(data) {
            console.log(data);
        });
    }
    $("#LeftPanel").find('.list-group-item').each(function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
    });
    notification(cate + cate_id);
    dragitem = null;
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

var itemDelete = function(elem, cate) {
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

//
// const { nodeName } = require("jquery");

// const { forEach } = require("lodash");

var baseURL = window.location.protocol + "//" + window.location.host + '/newlms';
var filteritem = null;
var grouptab = null,
    detailtags = null;
var detailtag1 = null;


var notification = function(str) {
    $('#notificator').prop({
        'data-message': str
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

        if ($('#user-form-tags ui').length == 0) {
            $('#user-form-tags').prepend(detailtags);
        }

        if ($('#user-form-tags ui li:first').length == 0) {
            $('#user-form-tags ui').prepend(detailtag1);
        }

        $("#LeftPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_A').find('.list-group-item').each(function(i, highlighted) {
            if ($(highlighted).hasClass('active')) {
                $(highlighted).find(".btn").each(function(index, btnelement) {
                    $(btnelement).removeClass("active");
                });
            }
            if ($(highlighted).hasClass('highlight')) {
                $(highlighted).removeClass('highlight');
            }
        });
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

        if ($('#user-form-tags ui li:first').length != 0) {
            detailtag1 = $('#user-form-tags ui li:first');
            $('#user-form-tags ui li:first').detach();
        }

        $("#LeftPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        if ($('#user-form-tags ui').length == 0) {
            $('#user-form-tags').prepend(detailtags);
        }

        $('#div_A').find('.list-group-item').each(function(i, highlighted) {
            if ($(highlighted).hasClass('active')) {
                $(highlighted).find(".btn").each(function(index, btnelement) {
                    $(btnelement).removeClass("active");
                });
            }
            if ($(highlighted).hasClass('highlight')) {
                $(highlighted).removeClass('highlight');
            }
        });
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

        if ($('#user-form-tags ui').length != 0) {
            detailtags = $('#user-form-tags ui');
            $('#user-form-tags ui').detach();
        }

        $("#LeftPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_A').find('.list-group-item').each(function(i, highlighted) {
            if ($(highlighted).hasClass('active')) {
                $(highlighted).find(".btn").each(function(index, btnelement) {
                    $(btnelement).removeClass("active");
                });
            }
            if ($(highlighted).hasClass('highlight')) {
                $(highlighted).removeClass('highlight');
            }
        });
    });


    $('#groups-tab').click(function() {
        $('#RightPanel .toolkit:first>div').css('background-color', 'var(--group-h)');
        $('#RightPanel').find('.list-group-item').each(function() {
            $(this).find('.toggle2-btn').toggle(false);
            $(this).find('.toggle1-btn').toggle(true);
            $(this).removeClass('select-active');
        });
        toggleFormOrTable($('#div_D'), null, false);


        $("#RightPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_C').find('.list-group-item').each(function(i, highlighted) {
            if ($(highlighted).hasClass('active')) {
                $(highlighted).find(".btn").each(function(index, btnelement) {
                    $(btnelement).removeClass("active");
                });
            }
            if ($(highlighted).hasClass('highlight')) {
                $(highlighted).removeClass('highlight');
            }
        });
    });
    $('#companies-tab').click(function() {
        $('#RightPanel .toolkit:first>div').css('background-color', 'var(--company-h)');
        $('#RightPanel').find('.list-group-item').each(function() {
            $(this).find('.toggle2-btn').toggle(false);
            $(this).find('.toggle1-btn').toggle(true);
            $(this).removeClass('select-active');
        });
        toggleFormOrTable($('#div_D'), null, false);

        $("#RightPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_C').find('.list-group-item').each(function(i, highlighted) {
            if ($(highlighted).hasClass('active')) {
                $(highlighted).find(".btn").each(function(index, btnelement) {
                    $(btnelement).removeClass("active");
                });
            }
            if ($(highlighted).hasClass('highlight')) {
                $(highlighted).removeClass('highlight');
            }
        });
    });
    $('#positions-tab').click(function() {
        $('#RightPanel .toolkit:first>div').css('background-color', 'var(--position-h)');
        $('#RightPanel').find('.list-group-item').each(function() {
            $(this).find('.toggle2-btn').toggle(false);
            $(this).find('.toggle1-btn').toggle(true);
            $(this).removeClass('select-active');
        });
        toggleFormOrTable($('#div_D'), null, false);

        $("#RightPanel").find(".list-group-item").each(function() {
            $(this).removeClass("active");
        });

        $('#div_C').find('.list-group-item').each(function(i, highlighted) {
            if ($(highlighted).hasClass('active')) {
                $(highlighted).find(".btn").each(function(index, btnelement) {
                    $(btnelement).removeClass("active");
                });
            }
            if ($(highlighted).hasClass('highlight')) {
                $(highlighted).removeClass('highlight');
            }
        });
    });


    $("#LeftPanel .list-group-item").each(function(index, elem) {
        elem.addEventListener('dragstart', dragStart);
        $(elem).attr('drag', false);
    });

    $("#RightPanel .list-group-item").each(function(index, elem) {
        $(elem).attr('draggable', false);
        $(elem).on('drop', dropEnd);

        elem.addEventListener('dragover', dragOver);
        elem.addEventListener('dragleave', dragLeave);
    });
    $("#companies .list-group-item, #positions .list-group-item").each(function(index, elem) {
        elem.addEventListener('dragstart', dragStart);
        elem.addEventListener('dragend', dragEnd);
    });
    $(".fliter-company-btn").on('drop', companyDropEnd);
    $(".fliter-function-btn").on('drop', functionDropEnd);

    $(".fliter-function-btn").on('dragstart', dragStart);
    $(".fliter-company-btn").on('dragstart', dragStart);

    $(".fliter-company-btn").on('dragover', dragOver);
    $(".fliter-company-btn").on('dragleave', dragLeave);

    $(".fliter-function-btn").on('dragover', dragOver);
    $(".fliter-function-btn").on('dragleave', dragLeave);


    $('input[name=status], input.search-filter, button.fliter-company-btn, button.fliter-function-btn').change(searchfilter);
    $('input.search-filter').keydown(searchfilter);
    $("button.fliter-company-btn, button.fliter-function-btn").on('drop', searchfilter);
});

$(".list-group-item").dblclick(function() {
    $(this).parents('.list-group').children(".list-group-item").each(function(i, e) {
        if ($(e).hasClass("active")) {
            $(e).removeClass("active");
        }
    });
});

// $("#RightPanel .list-group-item").click(function (e) {
//     $(this).parents('.list-group').children(".list-group-item").each(function (i, e) {
//         if ($(e).hasClass("active")) {
//             $(e).removeClass("active");
//         }
//     });
//     $(this).addClass('active');
// });

$("#LeftPanel .list-group-item").click(function(e) {
    // e.stopPropagation();
    $(this).toggleClass("active");
    $(this).attr('draggable', function(index, attr) {
        return attr == "true" ? false : true;
    });
});

var btnClick = function(e) {
    e.stopPropagation();
    $(this).parents('.window').find('.list-group-item').each(function(i, highlighted) {
        if ($(highlighted).hasClass('active')) {
            $(highlighted).find(".btn").each(function(index, btnelement) {
                $(btnelement).removeClass("active");
            });
        }
        if ($(highlighted).hasClass('highlight')) {
            $(highlighted).removeClass('highlight');
        }
    });
    $(this).addClass("active");
    $(this).parents('.list-group-item').addClass('highlight');
}
$(".list-group-item button.btn").click(btnClick);

var clearTable = function(element) {
    element.find('.list-group-item').detach();
};
var clearFrom = function(element) {
    element.find('input, select').each(function(i, forminput) {
        if ($(forminput).attr('name') != '_token') {
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
    if (flag1 == true) {
        if (flag == true) {
            if (form.css('display') == "none") {

                form.css('display', 'block');
                table.css('display', 'none');

                return form;
            }
        } else if (flag == false) {
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
            } else if (form.css('display') == "block") {
                form.css('display', 'none');
                table.css('display', 'block');

                return table;
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
    let reponseData = null;
    // console.log(str);
    // console.log(comp);
    // console.log(func);
    // console.log(online);
    // console.log(element_id.split('_')[1]);
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
        .done(function(data) {
            responseData = data;
        });
    // console.log("Data Loaded: " + responseData);

    return responseData;
};

$(".toolkit-show-filter").click(function(event) {
    $(this).parents('.toolkit').children(".toolkit-filter").toggle();
});



var secondShow = function(event) {
    event.preventDefault();
    var parent = $(this).parents('fieldset');
    if (parent.attr('id') == "LeftPanel") {
        toggleFormOrTable($('#RightPanel'), false);
    } else {
        toggleFormOrTable($('#LeftPanel'), false);
    }
};

var secondShow1 = function(event) {
    if ($(this).parents('fieldset').attr('id') == "RightPanel") {
        var parent = $(this).parents('.list-group-item');
        var id = parent.attr('id').split('_')[1];


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
                    }

                    if (element.hasClass('active')) {
                        element.removeClass('active');
                    }
                    // unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                    element.find('.btn-group').append(unlinkbtn);
                    element.find('button.btn').click(btnClick);
                    element.find('.item-show').bind('click', secondShow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').bind('click', function() {
                        item_delete($(this));
                    });
                    element.toggle(true);
                    element.attr('data-src', parent.attr('id'));
                    element.removeClass('active');
                    $("#table-groups .list-group").append(element);
                }
            });
        });

        if (!$(document).has("#user-form-tags"))
            grouptab.appendTo("#user-form-tags");

    } else if ($(this).parents('fieldset').attr('id') == "LeftPanel") {
        var parent = $(this).parents('.list-group-item');
        var id = parent.attr('id').split('_')[1];

        var activetab = $("#LeftPanel").find(".ui-state-active:first a").attr('href').split('#')[1];
        var items = $('#' + activetab).find('.list-group-item input[name="item-group"]');
        items.map(function(i, e) {
            var item = $(e).parents('.list-group-item');
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
                    }
                    if (element.hasClass('active')) {
                        element.removeClass('active');
                    }
                    element.find('button.btn').click(btnClick);
                    element.find('.btn-group').append(unlinkbtn);
                    element.find('.item-show').bind('click', secondShow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').bind('click', function() {
                        item_delete($(this));
                    });
                    element.toggle(true);
                    element.attr('data-src', parent.attr('id'));
                    element.removeClass('active');
                    $("#category-form-tags .list-group").append(element);
                }
            })
        });
    }
}

$('#div_B .item-show, #div_D .item-show').click(secondShow);

$('#div_A .item-show, #div_C .item-show').click(function(event) {
    // event.stopPropagation();
    // event.preventDefault();
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, false);
});

$('.item-edit').click(function(event) {
    // event.stopPropagation();
    // event.preventDefault();
    // $(this).attr('data-content')
    item_edit($(this));
});

$('.item-delete').click(function(event) {
    // event.stopPropagation();
    // event.preventDefault();
    // $(this).attr('data-content')
    item_delete($(this));
});

$('.toolkit-add-item').click(function(event) {
    toggleFormOrTable($(this).parents('fieldset'), true);

    var parent = $(this).parents('fieldset');
    var parent_id = $(this).parents('fieldset').attr('id');
    var activeTagName;
    if (parent_id == 'RightPanel') {
        activeTagName = $('#RightPanel').find('.ui-state-active:first a').attr('href');
        switch (activeTagName) {
            case '#groups':
                $("#category_form").attr('action', baseURL + '/group');
                $('#status_checkbox').css('display', 'block');
                $('#category_status').attr("checked", 'checked');


                if ($('#category_form .method-select').length > 0) {
                    $("#category_form .method-select").remove();
                }
                break;
            case '#companies':
                $("#category_form").attr('action', baseURL + '/company');
                $('#status_checkbox').css('display', 'none');

                if ($('#category_form .method-select').length > 0) {
                    $("#category_form .method-select").remove();
                }
                break;
            case '#positions':
                $("#category_form").attr('action', baseURL + '/function');
                $('#status_checkbox').css('display', 'none');

                if ($('#category_form .method-select').length > 0) {
                    $("#category_form .method-select").remove();
                }
                break;

            default:
                console.log('There is some error adding new component');
                break;
        }


    } else {
        activeTagName = $('#LeftPanel').find('.ui-state-active:first a').attr('href');
        $('#user_form').attr('action', baseURL + '/user');


        if ($('#user_form .method-select').length > 0) {
            $("#user_form .method-select").remove();
        }
        switch (activeTagName) {
            case '#students':
                $('#user_type').val('4');
                break;
            case '#teachers':
                $('#user_type').val('3');
                break;
            case '#authors':
                $('#user_type').val('2');
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
    var id = parent.attr('id').split('_')[1];

    var item_group = parent.find('input[name="item-group"]').val();
    var arr_group = item_group.split('_');

    arr_group.map(function(group) {
        // console.log(group);
        $('#groups').find('.list-group-item').each(function(i, e) {
            if (group == $(this).attr('id').split('_')[1]) {
                var element = $(e).clone(false);
                unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
                element.find('.btn-group').append(unlinkbtn);
                element.find('button.btn').click(btnClick);
                element.find('.item-show').bind('click', secondShow);
                element.find('.item-show').bind('click', secondShow1);
                element.find('.item-edit').bind('click', function() {
                    item_edit($(this));
                });
                element.find('.item-delete').bind('click', function() {
                    item_delete($(this));
                });
                if (element.hasClass('highlight')) {
                    element.removeClass('highlight');
                }
                if (element.hasClass('active')) {
                    element.removeClass('active');
                }
                element.find('button.btn').click(btnClick);

                element.toggle(true);
                element.attr('data-src', parent.attr('id'));
                element.removeClass('active');
                $("#table-groups .list-group").append(element);
            }
        });
    });

    // $post(baseURL+"/user/findsession", id, function(){
    //     console.log()
    // })
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
                    element.find('.item-show').bind('click', secondShow);
                    element.find('.item-show').bind('click', secondShow1);
                    element.find('.item-edit').bind('click', function() {
                        item_edit($(this));
                    });
                    element.find('.item-delete').bind('click', function() {
                        item_delete($(this));
                    });
                    if (element.hasClass('highlight')) {
                        element.removeClass('highlight');
                    }
                    if (element.hasClass('active')) {
                        element.removeClass('active');
                    }
                    element.toggle(true);
                    element.attr('data-src', parent.attr('id'));
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
                element.find('.item-show').bind('click', secondShow);
                element.find('.item-show').bind('click', secondShow1);
                element.find('.item-edit').bind('click', function() {
                    item_edit($(this));
                });
                element.find('.item-delete').bind('click', function() {
                    item_delete($(this));
                });
                if (element.hasClass('highlight')) {
                    element.removeClass('highlight');
                }
                if (element.hasClass('active')) {
                    element.removeClass('active');
                }
                element.toggle(true);
                element.attr('data-src', parent.attr('id'));
                element.removeClass('active');
                $("#category-form-tags .list-group").append(element);
            }
        }
    });
});

$('form input, form select').change(function(event) {
    console.log($(event.target).val());
    // $(event.target).parents('form').find("input").each(function(i, e){
    // })
})

$('form').submit(submitFunction);

var item_edit = function(element) {
    var parent = element.parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];

    if ($('li[aria-controls="groups"]').hasClass('ui-state-active')) {
        $('#status-form-group').css('display', 'block');
    } else {
        $('#status-form-group').css('display', 'none');
    }
    switch (element.attr('data-content')) {
        case 'student':
        case 'teacher':
        case 'author':
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
                    $('#login').val(data.user_info.login);
                    $('#password').val(data.user_info.password);
                    $('#firstname').val(data.user_info.first_name);
                    $('#lastname').val(data.user_info.last_name);
                    $('#company').val(data.user_info.company);
                    $('#position').val(data.user_info.function);
                    $("#user_form").attr('action', baseURL + '/user/' + id);
                    $('#status-form-group').css('display', 'block !important');

                    if (data.user_info.contact_info != null && data.user_info.contact_info != "") {
                        $('#contact_info').val(JSON.parse(data.user_info.contact_info).address);
                        $('#user-email').val(JSON.parse(data.user_info.contact_info).email);
                    }

                    $('#user-status-icon').attr('checked', data.user_info.status == 1).change();
                    // $("#user_form").prop('method', "PUT");

                    if ($('#user_form .method-select').length == 0) {
                        $("#user_form").prepend("<input name='_method' type='hidden' value='PUT' class='method-select' />");
                    }

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
                    $('#cate-status-icon').attr("checked", data.status == 1).change();
                    $('#cate-status').val(data.status);

                    $("#category_form").attr('action', baseURL + '/group/' + id);

                    if ($('#category_form .method-select').length == 0) {
                        $("#category_form").prepend("<input name='_method' type='hidden' value='PUT' class='method-select' />");
                    }
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

                    $("#category_form").attr('action', baseURL + '/company/' + id);

                    if ($('#category_form .method-select').length == 0) {
                        $("#category_form").prepend("<input name='_method' type='hidden' value='PUT' class='method-select' />");
                    }
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

                    $("#category_form").attr('action', baseURL + '/function/' + id);

                    if ($('#category_form .method-select').length == 0) {
                        $("#category_form").prepend("<input name='_method' type='hidden' value='PUT' class='method-select' />");
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
            break;

        case 'session':
            notification('There is no session for this user');
            break;

        default:
            console.log('how dare you can do this!');
            break;
    }
};

var item_show = function(element) {
    var parent = element.parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];
    switch (element.attr('data-content')) {
        case 'student':
            // $.get({
            //     url: baseURL + '/user/' + id,
            //     success: function (data, state) {
            //         data.session.foreach(sessionItem=>{

            //         })
            //     },
            //     error:function(err){

            //     }});

            break;

        case 'teacher':

            break;

        case 'author':

            break;

        case 'group':

            break;

        case 'company':

            break;

        case 'position':

            break;

        case 'session':

            break;

        default:
            break;
    }
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
        var new_item = Array();
        value.split('_').forEach(item => {
            if (item != id) {
                new_item.push(item);
            }
        });

        $("#" + showeditem).find('input[name="item-' + cate + '"]').val(new_item.join('_'));
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
}

var detachLinkFrom = function(e) {
    var parent = $(this).parents('.list-group-item');
    var showeditem = parent.attr('data-src');
    var id = $("#" + showeditem).attr('id').split('_')[1];
    var cate = $("#" + showeditem).attr('id').split('_')[0];
    var value = parent.find('input[name="item-' + cate + '"]').val();
    if (cate == 'group') {
        var new_item = Array();
        value.split('_').forEach(item => {
            if (item != id) {
                new_item.push(item);
            }
        });
        parent.find('input[name="item-' + cate + '"]').val(new_item.join('_'));
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
}

var detachCall = function(cate, connectiondata) {
    $.post({
        url: baseURL + '/userjointo' + cate,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'data': JSON.stringify(Array(connectiondata))
        },
        success: function(data) {
            console.log(data);

            requestData = [];
        },
        error: function(err) {
            console.log(err);

            requestData = [];
        }
    });
}

$('.cancel-btn').click(function(event) {
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, null, false);
})

$('.fliter-company-btn').click(function() {
    $('#companies-tab').click();
    $("#companies").find('.toggle2-btn').each(function() {
        $(this).toggle();
    });
    $("#companies").find('.toggle1-btn').each(function() {
        $(this).toggle();
    });
    $('#companies').find('.list-group-item').each(function(i, highlighted) {
        if ($(highlighted).hasClass('active')) {
            $(highlighted).find(".btn").each(function(index, btnelement) {
                $(btnelement).removeClass("active");
            });
        }
        if ($(highlighted).hasClass('highlight')) {
            $(highlighted).removeClass('highlight');
        }
    });
});

$('.fliter-company-btn').dblclick(function() {
    $(this).val('');
    $(this).html('company +');
    $(this).change();
    $('#companies').find('.list-group-item').each(function(i, highlighted) {
        if ($(highlighted).hasClass('active')) {
            $(highlighted).find(".btn").each(function(index, btnelement) {
                $(btnelement).removeClass("active");
            });
        }
        if ($(highlighted).hasClass('highlight')) {
            $(highlighted).removeClass('highlight');
        }
    });
    $('#companies').find('.toggle1-btn').toggle(false);
    $('#companies').find('.toggle2-btn').toggle(true);
});

$('.fliter-function-btn').click(function() {
    $('#positions-tab').click();
    $("#positions").find('.toggle2-btn').each(function() {
        $(this).toggle();
    });
    $("#positions").find('.toggle1-btn').each(function() {
        $(this).toggle();
    });
    $('#positions').find('.list-group-item').each(function(i, highlighted) {
        if ($(highlighted).hasClass('active')) {
            $(highlighted).find(".btn").each(function(index, btnelement) {
                $(btnelement).removeClass("active");
            });
        }
        if ($(highlighted).hasClass('highlight')) {
            $(highlighted).removeClass('highlight');
        }
    });
});

$('.fliter-function-btn').dblclick(function() {
    $(this).val('');
    $(this).html('function +');
    $(this).change();
    $('#positions').find('.list-group-item').each(function(i, highlighted) {
        if ($(highlighted).hasClass('active')) {
            $(highlighted).find(".btn").each(function(index, btnelement) {
                $(btnelement).removeClass("active");
            });
        }
        if ($(highlighted).hasClass('highlight')) {
            $(highlighted).removeClass('highlight');
        }
    });
    $('#positions').find('.toggle1-btn').toggle(false);
    $('#positions').find('.toggle2-btn').toggle(true);
});

$('.toggle2-btn').click(function(evt) {
    // evt.stopPropagation();
    $(this).parents('.list-group-item').toggleClass('active');
    $(this).parents('.list-group-item').attr('draggable', function(index, attr) {
        return attr == "true" ? false : true;
    });
})

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
            if (ctgc == '' || item_company == ctgc) {
                if (ctgf == '' || item_function == ctgf) {

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


$('#student fa.fa-edit,#teacher fa.fa-edit, #author fa.fa-edit').click(function(event) {
    var id = $(this).parents('.list-group-item').attr('id');
    $post(baseURL + "/user/findUser", id);
});

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

function dragEnd(event) {
    // console.log(event);
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
        dragitem.forEach(droppeditem => {
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
            },
            success: function(data) {
                console.log(data);

                requestData = [];
            },
            error: function(err) {
                console.log(err);

                requestData = [];
            }
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
        $(this).val(dragitem[0].split('_')[1]);
        $(this).html(dragitem[0]);
    }
    console.log(dragitem[0]);
    searchfilter(event);
    dragitem = null;
    $('.filter-company-btn').change();
}

function functionDropEnd(event, item) {
    $(event.target).css('opacity', '100%');
    if (dragitem != null && dragitem[0].split('_')[0] == 'function') {
        $(this).val(dragitem[0].split('_')[1]);
        $(this).html(dragitem[0]);
    }
    console.log(dragitem[0]);
    dragitem = null;
    $('.filter-function-btn').change();
}
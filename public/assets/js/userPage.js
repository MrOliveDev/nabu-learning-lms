// const { nodeName } = require("jquery");

var baseURL = window.location.protocol + "//" + window.location.host;
var filteritem = null;
var grouptab = null;

$(document).ready(function () {
    $('#LeftPanel .toolkit>div').css('background-color', 'var(--student-h)');
    $('#RightPanel .toolkit:first>div').css('background-color', 'var(--group-h)');
    $('.second-table .toolkit').css('background-color', 'var(--student-h)');

    $('#students-tab').click(function () {
        $('#LeftPanel .toolkit>div').css('background-color', 'var(--student-h)');
        $('.second-table .toolkit').css('background-color', 'var(--student-h)');
        toggleFormOrTable($('#div_B'), null, false);
        $("#category-form-tags .list-group-item").css('background-color', 'var(--student-c)');
        $("#category-form-tags .list-group-item.active").css('background-color', 'var(--student-h)');
        // $("#table-groups").toggle(true);
        grouptab.appendTo("#user-form-tags");

        $("#LeftPanel").find(".list-group-item").each(function () {
            $(this).removeClass("active");
        });
    });
    $('#teachers-tab').click(function () {
        $('#LeftPanel .toolkit>div').css('background-color', 'var(--teacher-h)');
        $('.second-table .toolkit').css('background-color', 'var(--teacher-h)');
        toggleFormOrTable($('#div_B'), null, false);
        $("#category-form-tags .list-group-item").css('background-color', 'var(--teacher-c)');
        $("#category-form-tags .list-group-item.active").css('background-color', 'var(--teacher-h)');
        // $("#table-groups").toggle(false);
        grouptab = $("#table-groups").detach();


        $("#LeftPanel").find(".list-group-item").each(function () {
            $(this).removeClass("active");
        });
    });
    $('#authors-tab').click(function () {
        $('#LeftPanel .toolkit>div').css('background-color', 'var(--author-h)');
        $('.second-table .toolkit').css('background-color', 'var(--author-h)');
        toggleFormOrTable($('#div_B'), null, false);
        $("#category-form-tags .list-group-item").css('background-color', 'var(--author-c)');
        $("#category-form-tags .list-group-item.active").css('background-color', 'var(--author-h)');
        // $("#table-groups").toggle(false);
        grouptab = $("#table-groups").detach();

        $("#LeftPanel").find(".list-group-item").each(function () {
            $(this).removeClass("active");
        });
    });


    $('#groups-tab').click(function () {
        $('#RightPanel .toolkit:first>div').css('background-color', 'var(--group-h)');
        $('#RightPanel').find('.list-group-item').each(function () {
            $(this).find('.toggle2-btn').toggle(false);
            $(this).find('.toggle1-btn').toggle(true);
            $(this).removeClass('select-active');
        });
        toggleFormOrTable($('#div_D'), null, false);


        $("#RightPanel").find(".list-group-item").each(function () {
            $(this).removeClass("active");
        });
    });
    $('#companies-tab').click(function () {
        $('#RightPanel .toolkit:first>div').css('background-color', 'var(--company-h)');
        $('#RightPanel').find('.list-group-item').each(function () {
            $(this).find('.toggle2-btn').toggle(false);
            $(this).find('.toggle1-btn').toggle(true);
            $(this).removeClass('select-active');
        });
        toggleFormOrTable($('#div_D'), null, false);

        $("#RightPanel").find(".list-group-item").each(function () {
            $(this).removeClass("active");
        });
    });
    $('#positions-tab').click(function () {
        $('#RightPanel .toolkit:first>div').css('background-color', 'var(--position-h)');
        $('#RightPanel').find('.list-group-item').each(function () {
            $(this).find('.toggle2-btn').toggle(false);
            $(this).find('.toggle1-btn').toggle(true);
            $(this).removeClass('select-active');
        });
        toggleFormOrTable($('#div_D'), null, false);

        $("#RightPanel").find(".list-group-item").each(function () {
            $(this).removeClass("active");
        });
    });


    $("#LeftPanel .list-group-item").each(function (index, elem) {
        elem.addEventListener('dragstart', dragStart);
        $(elem).attr('drag', false);
    });

    $("#RightPanel .list-group-item").each(function (index, elem) {
        $(elem).attr('draggable', false);
        $(elem).on('drop', dropEnd);

        elem.addEventListener('dragover', dragOver);
        elem.addEventListener('dragleave', dragLeave);
    });
    $("#companies .list-group-item, #positions .list-group-item").each(function (index, elem) {
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
    $("button.fliter-company-btn, button.fliter-function-btn").on('drop', searchfilter);
});

$(".list-group-item").dblclick(function () {
    $(this).parents('.list-group').children(".list-group-item").each(function (i, e) {
        if ($(e).hasClass("active")) {
            $(e).removeClass("active");
        }
    });
});

$("#RightPanel .list-group-item").click(function (e) {
    $(this).parents('.list-group').children(".list-group-item").each(function (i, e) {
        if ($(e).hasClass("active")) {
            $(e).removeClass("active");
        }
    });
    $(this).addClass('active');
});

$("#LeftPanel .list-group-item").click(function (e) {
    e.stopPropagation();
    $(this).toggleClass("active");
    $(this).attr('draggable', function (index, attr) {
        return attr == "true" ? false : true;
    });
});

$(".list-group-item button.btn").focus(function (e) {
    e.stopPropagation();
    $(this).addClass("active");
});
$(".list-group-item button.btn").focusout(function (e) {
    e.stopPropagation();
    if ($(this).hasClass("active")) {
        $(this).removeClass("active");
    }
});



clearTable = function (element) {
    element.find('.list-group-item').detach();
};
clearFrom = function (element) {
    element.find('input').each(function () {
        $(this).val('');
    });
};

//@param : div_b | div_d
toggleFormOrTable = function (element, flag = null, flag1 = true) {
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

goTab = function (name) {
    // console.log($('#' + name + '-tab')[0]);
    $('#' + name + '-tab').click();
};
contentFilter = function (element_id, str = '', comp = null, func = null, online = 0) {
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
        .done(function (data) {
            responseData = data;
        });
    // console.log("Data Loaded: " + responseData);

    return responseData;
};

$(".toolkit-show-filter").click(function (event) {
    $(this).parents('.toolkit').children(".toolkit-filter").toggle();
});

$(".toolkit-add-item").click(function (event) {
    toggleFormOrTable($(this).parents('fieldset'), true);
});

secondShow = function (event) {
    event.stopPropagation();
    event.preventDefault();
    var parent = $(this).parents('fieldset');
    if (parent.attr('id') == "LeftPanel") {
        toggleFormOrTable($('#RightPanel'), false);
    } else {
        toggleFormOrTable($('#LeftPanel'), false);
    }
};

secondShow1 = function (event) {
    if ($(this).parents('fieldset').attr('id') == "RightPanel") {
        var parent = $(this).parents('.list-group-item');
        var id = parent.attr('id').split('_')[1];


        var item_group = parent.find('input[name="item-group"]').val();
        var arr_group = item_group.split('_');

        arr_group.map(function (group) {
            // console.log(group);
            $('#groups').find('.list-group-item').each(function (i, e) {
                if (group == $(this).attr('id').split('_')[1]) {
                    var element = $(e).clone(false);
                    unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                    element.find('.btn-group').append(unlinkbtn);
                    element.find('.item-show').bind('click', secondShow);
                    element.find('.item-show').bind('click', secondShow1);
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
        items.map(function (i, e) {
            var item = $(e).parents('.list-group-item');
            var arr_group = $(e).val().split('_');
            arr_group.map(function (group) {
                // console.log(group);
                if (id == group) {
                    var element = $(e).parents('.list-group-item').clone(false);
                    unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
                    element.find('.btn-group').append(unlinkbtn);
                    element.find('.item-show').bind('click', secondShow);
                    element.find('.item-show').bind('click', secondShow1);
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

$('#div_A .item-show, #div_C .item-show').click(function (event) {
    event.stopPropagation();
    event.preventDefault();
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, false);
});


$('#div_A .fa.fa-edit, #div_C .fa.fa-edit').click(function (event) {
    event.stopPropagation();
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, true);
});



$('#div_B .fa.fa-edit, #div_D .fa.fa-edit').click(function (event) {
    event.stopPropagation();
    var parent = $(this).parents('fieldset');
    if (parent.attr('id') == "LeftPanel") {
        toggleFormOrTable($('#RightPanel'), true);
    } else {
        toggleFormOrTable($('#LeftPanel'), true);
    }
});

$('#div_A .item-show').click(function (event) {
    var parent = $(this).parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];

    var item_group = parent.find('input[name="item-group"]').val();
    var arr_group = item_group.split('_');

    arr_group.map(function (group) {
        // console.log(group);
        $('#groups').find('.list-group-item').each(function (i, e) {
            if (group == $(this).attr('id').split('_')[1]) {
                var element = $(e).clone(false);
                unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
                element.find('.btn-group').append(unlinkbtn);
                element.find('.item-show').bind('click', secondShow);
                element.find('.item-show').bind('click', secondShow1);
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

$('#div_C .item-show').click(function (event) {


    var parent = $(this).parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];

    var activetab = $("#LeftPanel").find(".ui-state-active:first a").attr('href').split('#')[1];
    var items = $('#' + activetab).find('.list-group-item input[name="item-group"]');
    items.map(function (i, e) {
        var item = $(e).parents('.list-group-item');
        var arr_group = $(e).val().split('_');
        arr_group.map(function (group) {
            // console.log(group);
            if (id == group) {
                var element = item.clone(false);
                unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
                element.find('.btn-group').append(unlinkbtn);
                element.find('.item-show').bind('click', secondShow);
                element.find('.item-show').bind('click', secondShow1);
                element.toggle(true);
                element.attr('data-src', parent.attr('id'));
                element.removeClass('active');
                $("#category-form-tags .list-group").append(element);
            }
        })
    });
});

detachLinkTo = function (e) {
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
    if ($(this).parents('fieldset').attr('id') == 'RightPanel') {
        toggleFormOrTable($("#LeftPanel"), false, false);
    } else {
        toggleFormOrTable($("#RightPanel"), false, false);
    }
    parent.detach();
}

detachLinkFrom = function (e) {
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
    if ($(this).parents('fieldset').attr('id') == 'RightPanel') {
        toggleFormOrTable($("#LeftPanel"), false, false);
    } else {
        toggleFormOrTable($("#RightPanel"), false, false);
    }
    parent.detach();
}



$('.cancel-btn').click(function (event) {
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, null, false);
})

$('.fliter-company-btn').click(function () {
    $('#companies-tab').click();
    $("#companies").find('.toggle2-btn').each(function () {
        $(this).toggle();
    });
    $("#companies").find('.toggle1-btn').each(function () {
        $(this).toggle();
    });
});

$('.fliter-function-btn').click(function () {
    $('#positions-tab').click();
    $("#positions").find('.toggle2-btn').each(function () {
        $(this).toggle();
    });
    $("#positions").find('.toggle1-btn').each(function () {
        $(this).toggle();
    });
});

$('.toggle2-btn').click(function () {
    $(this).parents('.list-group-item').toggleClass('select-active');
    $(this).parents('.list-group-item').attr('draggable', function (index, attr) {
        return attr == "true" ? false : true;
    });
})

//filter

searchfilter = function (event) {
    var parent = $(this).parents('.toolkit');
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

    items.map(function (i, e) {
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
                            if (item_status == 1) {
                                $(e).toggle(true);
                            } else {
                                $(e).toggle(true);
                            }
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


$('#student fa.fa-edit,#teacher fa.fa-edit, #author fa.fa-edit').click(function (event) {
    var id = $(this).parents('.list-group-item').attr('id');
    $post(baseURL + "/user/findUser", id);
});

//////////////////////////////////
///////////////////////////////////
//////////////////////////////////

var dragitem = null;

function dragStart(event) {
    dragitem = Array();
    $(this).parents(".list-group").children('.active').each(function () {
        dragitem.push($(this).attr("id"));
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
    var cate_id = $(event.target).attr("id").split('_')[1];
    var cate = $(event.target).attr("id").split('_')[0];
    if (dragitem != null) {
        var category = dragitem[0].split('_')[0];
        // console.log(category);
        dragitem.forEach(item => {
            // console.log(item.split('_')[1]);
            if (cate == "group") {
                var cate_items = $("#" + item).find('input[name="item-group"]').val();
                if (cate_items.indexOf(cate_id) == -1) {
                    cate_items += "_" + cate_id;
                }
                $("#" + item).find('input[name="item-group"]').val(cate_items);
            } else {
                var cate_item = $("#" + item).find('input[name="item-' + cate + '"]').val();
                if (cate_item != cate_id) {
                    $("#" + item).find('input[name="item-' + cate + '"]').val(cate_id);
                    // console.log($("#" + item).find('input[name="item-' + cate + '"]').val());
                }
            }
        });
    }
    $("#LeftPanel").find('.list-group-item').each(function () {
        $(this).removeClass('.active');
    });
    alert(cate + cate_id + dragitem.join('_'));
    dragitem = null;
}

function companyDropEnd(event, item) {
    $(event.target).css('opacity', '100%');
    if (dragitem != null && dragitem[0].split('_')[0] == 'company') {
        $(this).val(dragitem[0].split('_')[1]);
        $(this).html(dragitem[0]);
    }
    alert(dragitem[0]);
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
    alert(dragitem[0]);
    dragitem = null;
    $('.filter-function-btn').change();
}

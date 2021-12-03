// const { nodeName } = require("jquery");

// const { parseHTML } = require("jquery");

// const { forEach } = require("lodash");

var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));

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

var selectStart = null;

// Dashmix.helpers('notify', {message: 'Your message!'});

/**
 * notification for every actions.
 * @param {*} str 
 * @param {*} type 
 */
var notification = function (str, type) {
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

/**
 * show div_D count of items
 * @param {*} event 
 */
var countDisplayUser = function (event) {
    $('#member-count').html($(this).find('.list-group-item').length + " members");
};

/**
 * clear active class in the item list
 * @param {*} i 
 * @param {*} highlighted 
 */
var clearClassName = function (i, highlighted) {
    $(highlighted).find(".btn").each(function (index, btnelement) {
        $(btnelement).removeClass("active");
    });
    if ($(highlighted).hasClass('highlight')) {
        $(highlighted).removeClass('highlight');
    }
};

/**
 * toggle button change
 */
var toggleBtnChange = function () {
    $(this).find('.toggle2-btn').toggle(false);
    $(this).find('.toggle1-btn').toggle(true);
    $(this).removeClass('select-active');
};

/**
 * remove actived item when dbclick on one item
 */
var itemDBClick = function () {
    $(this).parents('.list-group').children(".list-group-item").each(function (i, e) {
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

/**
 * user item click
 * @param {*} e 
 */
var leftItemClick = function (e) {
    // e.stopPropagation();
    var target = $(e.target).closest(".list-group-item");
    var category = target.attr("id").split("_")[0];
    if (!target.hasClass("active")) {
        if (selectStart == "" || selectStart == null) {
            selectStart = target.attr("id").split("_")[1];
        } else {
            if (e.shiftKey) {
                var itemList = target.parents(".list-group").find(".list-group-item").map(function () {
                    return $(this).attr("id").split("_")[1];
                }).toArray();
                if (itemList.indexOf(selectStart) != -1) {
                    var selectEnd = target.attr("id").split("_")[1];
                    var startIndex = itemList.indexOf(selectEnd);
                    var endIndex = itemList.indexOf(selectStart);
                    if (endIndex >= startIndex) {
                        for (let i = startIndex; i <= endIndex; i++) {
                            $("#" + category + "_" + itemList[i]).toggleClass("active", true);
                        }
                    } else {
                        for (let i = endIndex; i <= startIndex; i++) {
                            $("#" + category + "_" + itemList[i]).toggleClass("active", true);
                        }
                    }

                    selectStart = null;

                }
            } else {
                selectStart = null;
            }
        }
        target.addClass("active");
        // $(this).attr('draggable', true);
    } else {
        target.removeClass("active");
        // $(this).attr('draggable', false);
    }

};

/**
 * item button click actions
 * @param {*} e 
 */
var btnClick = function (e) {
    if (!$(this).hasClass('toggle2-btn')) {
        e.stopPropagation();
        $(this).parents('.window').find('.list-group-item').each(clearClassName);
        $(this).parents('.list-group-item').addClass('highlight');
        switch ($(this).parents('.window').attr("id")) {
            case "div_A":
                if ($('#div_D').find('.highlight').length != 0)
                    $('#div_D').find('.highlight').each(function (i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function (i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;
            case "div_B":
                if ($('#div_C').find('.highlight').length != 0 && activedTab == '#groups')
                    $('#div_C').find('.highlight').each(function (i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function (i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;
            case "div_C":
                if ($('#div_B').find('.highlight').length != 0 && activedTab == '#groups')
                    $('#div_B').find('.highlight').each(function (i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function (i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;
            case "div_D":
                if ($('#div_A').find('.highlight').length != 0)
                    $('#div_A').find('.highlight').each(function (i, e) {
                        $(e).removeClass("highlight");
                        $(e).find('.btn').each(function (i, item) {
                            $(item).removeClass('active');
                        });
                    });
                break;

            default:
                break;
        }

    } else {
        $(this).parents('.window').find('.list-group-item').each(clearClassName);
        $(this).parents('.list-group').children(".list-group-item").each(function (i, e) {
            if ($(e).hasClass("active")) {
                $(e).removeClass("active");
            }
        });
    }
    $(this).parents('.list-group').find('.btn.active').removeClass('active');
    $(this).addClass("active");
};

/**
 * clear table data
 * @param {*} element 
 */
var clearTable = function (element) {
    element.each(function (i, em) {
        if ($(em).find('.list-group-item').length != 0) {
            $(em).find('.list-group-item').detach();
        }
    });
};

/**
 * clear form data
 * @param {*} element 
 */
var clearFrom = function (element) {
    element.find('input, select').each(function (i, forminput) {
        if ($(forminput).attr('name') != '_token' && $(forminput).attr('name') != '_method') {
            $(forminput).val('');
        }
    });
    if (element.has('#preview').length != 0) {
        element.find('#preview').attr('src', '');
    }

};

//@param : div_b | div_d
/**
 * toggle form or table 
 * @param {*} element 
 * @param {*} flag 
 * @param {*} flag1 
 * @returns 
 */
var toggleFormOrTable = function (element, flag = null, flag1 = true) {
    var form = element.find('form');
    var table = element.find('.second-table');
    clearFrom(form);
    clearTable(table);
    if (flag1) {
        if (flag) {
            if (form.css('display') == "none") {

                form.css('display', 'block');
                table.each(function (i, em) {
                    $(em).css('display', 'none');
                });
                return form;
            }
        } else if (!flag) {
            if (table.css('display') == "none") {
                form.css('display', 'none');
                table.each(function (i, em) {
                    $(em).css('display', 'block');
                });
                return table;
            }
        } else if (flag == null) {
            if ($(table[0]).css('display') == "block") {
                table.each(function (i, em) {
                    $(em).css('display', 'none');
                });
                form.css('display', 'block');

                return form;
            } else {
                if (form.css('display') == "block") {
                    form.css('display', 'none');
                    table.each(function (i, em) {
                        $(em).css('display', 'block');
                    });

                    return table;
                }
            }
        }
    } else {
        form.toggle(false);
        table.each(function (i, em) {
            $(em).toggle(false);
        });
        return null;
    }

};

/**
 * force to move to any tab
 * @param {*} name 
 */
var goTab = function (name) {
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

/**
 * toolkit expand or collaspe
 * @param {*} event 
 */
var filterToggleShow = function (event) {
    var parent = $(this).parents('.toolkit');
    parent.children(".toolkit-filter").toggle();
    if (parent.attr('id') == 'user-toolkit') {
        var leftActiveTab = $('#LeftPanel .ui-state-active a').attr('href').split('#')[1];
        if ( /* leftActiveTab == 'teachers' ||  */ leftActiveTab == 'authors') {
            parent.find('.filter-function-btn').toggle(false);
        } else {
            parent.find('.filter-function-btn').toggle(true);
        }

    }

    parent.children('.toolkit-filter input').each(function (i, e) {
        $(e).attr('checked', false);
    });
    parent.children('.search-filter').val('');
    parent.children('.filter-company-btn').html('company +<i></i>');
    parent.children('.filter-function-btn').html('function +<i></i>');

    parent.find('.search-filter').val('')
    parent.find('input[name=status]').each(function (i, e) {
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

    parent.find('.filter-name-btn i').toggleClass('fa-sort-alpha-down', false);
    parent.find('.filter-name-btn i').toggleClass('fa-sort-alpha-up', false);
    parent.find('.filter-date-btn i').toggleClass('fa-sort-numeric-up', false);
    parent.find('.filter-date-btn i').toggleClass('fa-sort-numeric-down', false);
};

/**
 * company | function filter mode when we click toolkit filter button
 * @param {*} event 
 */
var secondShow1 = function (event) {
    var parent = $(this).parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];

    if ($(this).parents('fieldset').attr('id') == "RightPanel") {
        var item_group = parent.find('input[name="item-group"]').val();
        var arr_group = item_group.split(',');
        arr_group.map(function (group) {
            $('#groups').find('.list-group-item').each(function (i, e) {
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
                        element.find('.btn.active').each(function (i, e) {
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
                    element.find('.item-edit').bind('click', function () {
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
        // var activetab = $("#LeftPanel").find(".ui-state-active:first a").attr('href').split('#')[1];
        // var items = $('#' + activetab).find('.list-group-item input[name="item-group"]');
        // items.map(function(i, e) {
        //     // var item = $(e).parents('.list-group-item');
        //     var arr_group = $(e).val().split('_');
        //     var unlinkbtn = null;
        //     arr_group.map(function(group) {
        //         // console.log(group);
        //         if (id == group) {
        //             var element = $(e).parents('.list-group-item').clone(false);
        //             var sectId = $(event.target).parents('.window').attr('id');
        //             if (sectId == 'div_B' || sectId == 'div_D') {
        //                 unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkFrom);
        //             } else {
        //                 unlinkbtn = $('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').on('click', detachLinkTo);
        //             }
        //             if (element.hasClass('highlight')) {
        //                 element.removeClass('highlight');
        //                 element.find('.btn.active').each(function(i, e) {
        //                     $(e).removeClass('active');
        //                 });
        //             }
        //             if (element.hasClass('active')) {
        //                 element.removeClass('active');
        //             }
        //             element.find('button.btn').click(btnClick);
        //             element.find('.btn-group').append(unlinkbtn);
        //             element.find('.item-show').bind('click', divBDshow);
        //             element.find('.item-show').bind('click', secondShow1);
        //             element.find('.item-edit').bind('click', function() {
        //                 item_edit($(this));
        //             });
        //             element.find('.item-delete').click(itemDelete);

        //             element.toggle(true);
        //             element.attr('data-src', parent.attr('id'));
        //             element.parents('.list-group').attr('data-src', parent.attr('id'));
        //             element.removeClass('active');
        //             $("#category-form-tags .list-group").append(element);
        //         }
        //     });
        // });
        heightToggleRight = true;
        $('#member-count').html("0 members");
        $('#div_right').dblclick();
        var parent = $(this).parents('.list-group-item');
        var id = parent.attr('id').split('_')[1];
        var cate = parent.attr('id').split('_')[0];
        var activetab = $("#LeftPanel").find(".ui-state-active:first a").attr('href').split('#')[1];
        var items = $('#' + activetab).find('.list-group-item input[name="item-' + cate + '"]');
        $('#show-toolkit input[name="status"]:checked').prop('checked', false);
        var nameIcon = $('show-toolkit').find('.filter-name-btn i');
        var dateIcon = $('show-toolkit').find('.filter-date-btn i');
        nameIcon.toggleClass('fa-sort-alpha-down', false);
        nameIcon.toggleClass('fa-sort-alpha-up', false);
        dateIcon.toggleClass('fa-sort-numeric-down', false);
        dateIcon.toggleClass('fa-sort-numeric-up', false);
        items.map(function (i, e) {
            var item = $(e).parents('.list-group-item');
            if (cate == 'group') {
                var arr_group = $(e).val().split(',');
                arr_group.map(function (group) {
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
                            element.find('.btn.active').each(function (i, e) {
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
                        element.find('.btn.active').each(function (i, e) {
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
                $('.second-table .toolkit>div').css('background-color', 'var(--student-h)');
                $("#category-form-tags .list-group-item").css('background-color', 'var(--student-c)');
                $("#category-form-tags .list-group-item.active").css('background-color', 'var(--student-h)');
                $('#show-toolkit .filter-function-btn').toggle(true);
                break;
            case '#teachers':
                $('.second-table .toolkit>div').css('background-color', 'var(--teacher-h)');
                $("#category-form-tags .list-group-item").css('background-color', 'var(--teacher-c)');
                $("#category-form-tags .list-group-item.active").css('background-color', 'var(--teacher-h)');
                $('#show-toolkit .filter-function-btn').toggle(true);
                break;
            case '#authors':
                $('.second-table .toolkit>div').css('background-color', 'var(--author-h)');
                $("#category-form-tags .list-group-item").css('background-color', 'var(--author-c)');
                $("#category-form-tags .list-group-item.active").css('background-color', 'var(--author-h)');
                $('#show-toolkit .filter-function-btn').toggle(false);
                break;
            default:
                break;
        }
    }
};

/**
 * div_B |div_D show button action
 * @param {} event 
 */
var divBDshow = function (event) {
    event.preventDefault();
    var parent = $(this).parents('fieldset');
    if (parent.attr('id') == "LeftPanel") {
        toggleFormOrTable($('#RightPanel'), false);
        $('.second-table .toolkit>div').css('background-color', 'var(--student-h)');
        $("#category-form-tags .list-group-item").css('background-color', 'var(--student-c)');
        $("#category-form-tags .list-group-item.active").css('background-color', 'var(--student-h)');
    } else {
        toggleFormOrTable($('#LeftPanel'), false);
    }
};

/**
 * div_A | div_C show button action
 * @param {*} event 
 */
var divACshow = function (event) {
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, false);
    var userItem = $(this).closest(".list-group-item");
    $.post({
        url: baseURL + "/getSessionFromUser",
        data: {
            data: userItem.attr("id").split("_")[1]
        }
    }).done(function (data) {
        data.map ? .(function (item, i) {
            $("#table-session .list-group").append(createSessionItem(item[0]));
        })
    }).fail(function (err) {
        notification("You got error during getting data of session.", 2);
    })
};

/**
 * toolkit multi delete button action
 * @param {} event 
 */
var toolkitMultiDelete = function (event) {
    var parent = $(event.target).parents(".toolkit");
    var target = parent.attr("data-target");
    var selectedItem = $(target).find(".list-group-item.active");
    if (selectedItem.length != 0) {
        var category = $(selectedItem[0]).attr("id").split("_")[0];
        var selectedItemStr = selectedItem.map(function (i, item) {
            return $(item).attr("id").split("_")[1];
        }).toArray().join(",");
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
            text: ' This user and all his historic and reports will be permanently deleted',
            icon: 'warning',
            showCancelButton: !0,
            customClass: {
                confirmButton: 'btn btn-danger m-1',
                cancelButton: 'btn btn-secondary m-1'
            },
            confirmButtonText: 'Yes, delete it!',
            html: !1,
            preConfirm: function (e) {
                return new Promise((function (e) {
                    setTimeout((function () {
                        e();
                    }), 50);
                }));
            }
        }).then((function (n) {
            if (n.value) {
                $.post({
                        url: baseURL + "/" + category + "/multidelete",
                        data: {
                            data: selectedItemStr
                        }
                    })
                    .done(function () {
                        e.fire('Deleted!', 'Your ' + category + ' has been deleted.', 'success');
                        selectedItem.map(function (i, item) {
                            if (!$(item).is(".drag-disable"))
                                $(item).remove();
                        });
                    })
                    .fail(function () {
                        e.fire('Not deleted!', 'You have an error.', 'error');
                    })
            } else {
                'cancel' === n.dismiss && e.fire('Cancelled', 'Your data is safe :)', 'error');
            }
        }));
    }
}

/**
 * toolkit add button action
 * @param {*} event 
 */
var toolkitAddItem = function (event) {
    event.preventDefault();
    event.stopPropagation();
    toggleFormOrTable($(this).parents('fieldset'), true);
    if ($(this).parents("fieldset").is("#LeftPanel")) {
        $("#language").val($("#clientlang").val());
    }
    $("#csv-import-form").css("display", "none");
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
        $("#send-email-input").toggle(true);
        activeTagName = $('#LeftPanel').find('.ui-state-active:first a').attr('href');
        $('#div_A').find('.list-group-item').each(clearClassName);
        $('#user_form').attr('action', baseURL + '/user');
        $("#send_email").prop("checked", false);
        $('#user_form').attr('data-item', '');

        $("#user_form .method-select").val('POST');

        // $('#password').attr('disabled', false);
        $('#password').attr('placeholder', '');
        $('#preview').attr('src', baseURL + '/assets/media/default.png');
        $('#generatepassword').prop('checked', false);
        var expired_date_val = (() => {
            var date = new Date().toLocaleDateString("ja").split("/");
            date[0] = parseInt(date[0]) + 1;
            return date.join("-");
        })();
        $("#expired_date").val(expired_date_val);
        switch (activeTagName) {
            case '#students':
                $('#user_type').val('4');
                $('#login-label').html('Login Student');

                if ($('#expired_date_input .input-group').length == 0) {
                    expired_date.appendTo($('#expired_date_input'));
                }

                $("#permission_input").toggle(false);
                break;
            case '#teachers':
                $('#user_type').val('3');
                $('#login-label').html('Login Teacher');

                if ($('#expired_date_input .input-group').length != 0) {
                    expired_date.detach();
                }
                $("#permission_input").toggle(true);
                $("#permission").val('3');
                break;
            case '#authors':
                $('#user_type').val('2');
                $('#login-label').html('Login Author');

                if ($('#expired_date_input .input-group').length != 0) {
                    expired_date.detach();
                }
                $("#permission_input").toggle(false);
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

var csvImportItem = function (event) {
    toggleFormOrTable($("#div_B"), null, false);
    $("#csv-import-form").css('display', 'block');
    $("#csv-user-list").css('display', 'none');
}

function csvImportOpen() {
    $("#import-file").trigger('click');
}

$("#import-file").on('change', function () {
    $("#import-file-name").val($(this).val().split('\\').pop());
    $("#csv-import-cancel").css("display", "block");
});

$("input[name=separator_man]").on("keyup", function () {
    if ($(this).val() != "") {
        $.each($("input[name=separator]"), function (i) {
            $(this).prop("checked", false);
        });
    } else {
        var already = false;
        $.each($("input[name=separator]"), function (i) {
            if ($(this).prop("checked") == true) {
                already = true;
            }
        });
        if (!already) {
            $("input[name=separator][value=auto]").prop("checked", true);
        }
    }
});

$("#csv-import-cancel").click(function () {
    $("#import-file").val('');
    $("#import-file-name").val('');
    $("#csv-import-cancel").css("display", "none");
})

$("input[name=separator]").on("click", function () {
    $("input[name=separator_man]").val("");
});

$("input[name=changepw]").on("change", function () {
    var changepw = $(this);
    if (changepw.val() == 1) {
        $.each($("input[name=generate]"), function () {
            var generate = $(this);
            if (generate.val() == 1) {
                generate.prop("checked", true)
            } else {
                generate.prop("checked", false);
            }
        });
    }
});

var csvSubmitBtn = function (event) {
    if ($("#import-file").val() == "") {
        swal.fire({
            title: "Warning",
            text: "Please select file.",
            icon: "warning",
            confirmButtonText: `OK`
        });
        return;
    }

    var datas = {};

    var separator = $("input[name=separator_man]").val();
    datas.separator = separator == "" ? $("input[name=separator]:checked").attr('data-value') : separator;
    // datas.codage = $("#codage option:selected").text();
    datas.pw = $("input[name=changepw]:checked").attr('data-value');
    datas.generate = $("input[name=generate]:checked").attr('data-value');
    datas.header = $("input[name=header]:checked").attr('data-value');

    // datas.importtype = $("select[name=import-type]").val()
    datas.language = $("select[name=import-tongue]").val();
    datas.group = $("select[name=import-group]").val();
    datas.company = $("select[name=import-company]").val();
    datas.position = $("select[name=import-position]").val();
    console.log(datas);

    $("#csv-import-form").ajaxSubmit({
        type: "POST",
        url: "getCSV",
        data: datas,
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $("#csv-import-form").css("display", "none");

                $("#csv-user-tbl").html('');
                if (res.data) {
                    if (res.data[0]) {
                        let html = '<thead>';
                        html += '<th></th>';
                        for (let i = 0; i < res.data[0].length; i++) {
                            html += ('<th>\
                                <div class="form-group mb-0">\
                                    <select class="select-col form-control">\
                                        <option value="-1">Do not import</option>\
                                        <option value="login">Login</option>\
                                        <option value="password">Password</option>\
                                        <option value="name">First Name</option>\
                                        <option value="surname">Last Name</option>\
                                        <option value="address">Address</option>\
                                        <option value="email">Email</option>\
                                    </select>\
                                </div>\
                                </th>');
                        }
                        html += '</thead>';
                        $("#csv-user-tbl").append(html);
                    }
                    $("#csv-user-tbl").append('<tbody>');
                    res.data.forEach((line, index) => {
                        if (index != 0 || datas.header == "0") {
                            let html = '<tr>';
                            html += `<td class='line-index'>${datas.header == "0" ? index + 1 : index}</td>`;
                            if (Array.isArray(line)) {
                                line.forEach(field => {
                                    html += `<td>${field}</td>`;
                                })
                            }
                            html += '</tr>';
                            $("#csv-user-tbl").append(html);
                        }
                    });
                    $("#csv-user-tbl").append('</tbody>');
                }
                $("#csv-user-list").css("display", "block");

            } else {
                swal.fire({
                    title: "Error",
                    text: res.message,
                    icon: "error",
                    confirmButtonText: `OK`
                });
            }
        },
        error: function (xhr, status, error) {
            console.log("status:" + status);
            console.log("xhr.status:" + xhr.status);
        }
    });
}

$("#import_cancel_button").click(function () {
    $("#csv-user-list").css('display', 'none');
});

var csvImportBtn = function (event) {
    var fields = [];
    $(".select-col").each(function () {
        fields.push($(this).val());
    });

    if (fields.indexOf('name') == -1) {
        swal.fire({
            title: "Warning",
            text: "Please select First Name field.",
            icon: "warning",
            confirmButtonText: `OK`
        });
        return;
    }
    if (fields.indexOf('surname') == -1) {
        swal.fire({
            title: "Warning",
            text: "Please select Last Name field.",
            icon: "warning",
            confirmButtonText: `OK`
        });
        return;
    }
    if (fields.indexOf('email') == -1) {
        swal.fire({
            title: "Warning",
            text: "Please select Email field.",
            icon: "warning",
            confirmButtonText: `OK`
        });
        return;
    }

    var userdatas = [];
    $("#csv-user-tbl tbody tr").each(function () {
        let user = [];
        $(this).children('td').each(function () {
            if ($(this).attr('class') != 'line-index')
                user.push($(this).html());
        });
        userdatas.push(user);
    });

    var datas = {};
    datas.pw = $("input[name=changepw]:checked").attr('data-value');
    datas.generate = $("input[name=generate]:checked").attr('data-value');
    datas.header = $("input[name=header]:checked").attr('data-value');

    // datas.importtype = $("select[name=import-type]").val()
    datas.language = $("select[name=import-tongue]").val();
    datas.group = $("select[name=import-group]").val();
    datas.company = $("select[name=import-company]").val();
    datas.position = $("select[name=import-position]").val();

    $.ajax({
        type: "POST",
        url: "importCSV",
        data: {
            fields: fields,
            users: userdatas,
            forceupdate: $("#force-update")[0].checked,
            options: datas
        },
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                if (res.message)
                    swal.fire({
                        title: "Warning",
                        text: res.message,
                        icon: "info",
                        confirmButtonText: `OK`
                    });
                else
                    swal.fire({
                        title: "Success",
                        text: "Users are imported successfully.",
                        icon: "success",
                        confirmButtonText: `OK`
                    });
                $("#csv-user-list").css('display', 'none');
            } else {
                swal.fire({
                    title: "Error",
                    text: res.message,
                    icon: "error",
                    confirmButtonText: `OK`
                });
            }
        },
        error: function (xhr, status, error) {
            console.log("status:" + status);
            console.log("xhr:" + xhr);
        }
    });
}

/** 
 * div_a edit button action
 */
var divACedit = function (event) {
    // event.stopPropagation();
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, true);
    $("#csv-import-form").toggle(false);
};

/**
 * B & D item edit
 * @param {*} event 
 */
var divBDedit = function (event) {
    // event.stopPropagation();
    var parent = $(this).parents('fieldset');
    if (parent.attr('id') == "LeftPanel") {
        toggleFormOrTable($('#RightPanel'), true);
        // if ($(this).attr('data-content') == 'group') {
        //     $('#cate-status-icon').toggle(true);
        // } else {
        //     $('#cate-status-icon').toggle(false);
        // }
    } else {
        toggleFormOrTable($('#LeftPanel'), true);
    }
};

/**
 * div a show action
 *
 * @param {*} event 
 */
var divAshow = function (event) {
    heightToggleLeft = true;
    $('#div_left').dblclick();
    var parent = $(this).parents('.list-group-item');
    // var id = parent.attr('id').split('_')[1];

    var item_group = parent.find('input[name="item-group"]').val();
    var arr_group = item_group.split(',');

    arr_group.map(function (group) {
        $('#groups').find('.list-group-item').each(function (i, e) {
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
                    element.find('.btn.active').each(function (i, e) {
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

/**
 * show button action in div c
 * @param {*} event 
 */
var divCshow = function (event) {
    heightToggleRight = true;
    $('#member-count').html("0 members");
    $('#div_right').dblclick();
    var parent = $(this).parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];
    var cate = parent.attr('id').split('_')[0];
    var activetab = $("#LeftPanel").find(".ui-state-active:first a").attr('href').split('#')[1];
    var items = $('#' + activetab).find('.list-group-item input[name="item-' + cate + '"]');
    $('#show-toolkit input[name="status"]:checked').prop('checked', false);
    var nameIcon = $('show-toolkit').find('.filter-name-btn i');
    var dateIcon = $('show-toolkit').find('.filter-date-btn i');
    nameIcon.toggleClass('fa-sort-alpha-down', false);
    nameIcon.toggleClass('fa-sort-alpha-up', false);
    dateIcon.toggleClass('fa-sort-numeric-down', false);
    dateIcon.toggleClass('fa-sort-numeric-up', false);
    items.map(function (i, e) {
        var item = $(e).parents('.list-group-item');
        if (cate == 'group') {
            var arr_group = $(e).val().split(',');
            arr_group.map(function (group) {
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
                        element.find('.btn.active').each(function (i, e) {
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
                    element.find('.btn.active').each(function (i, e) {
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
            $('.second-table .toolkit>div').css('background-color', 'var(--student-h)');
            $("#category-form-tags .list-group-item").css('background-color', 'var(--student-c)');
            $("#category-form-tags .list-group-item.active").css('background-color', 'var(--student-h)');
            $('#show-toolkit .filter-function-btn').toggle(true);
            break;
        case '#teachers':
            $('.second-table .toolkit>div').css('background-color', 'var(--teacher-h)');
            $("#category-form-tags .list-group-item").css('background-color', 'var(--teacher-c)');
            $("#category-form-tags .list-group-item.active").css('background-color', 'var(--teacher-h)');
            $('#show-toolkit .filter-function-btn').toggle(true);
            break;
        case '#authors':
            $('.second-table .toolkit>div').css('background-color', 'var(--author-h)');
            $("#category-form-tags .list-group-item").css('background-color', 'var(--author-c)');
            $("#category-form-tags .list-group-item.active").css('background-color', 'var(--author-h)');
            $('#show-toolkit .filter-function-btn').toggle(false);
            break;
        default:
            break;
    }

};

/**
 * form input change action
 * @param {*} event 
 */
var formInputChange = function (event) {
    console.log($(event.target).val());
};

/**
 * item edit button action
 * @param {*} element 
 */
var item_edit = function (element) {
    var parent = element.parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];

    if (parent.find('.item-edit').attr('data-content') == 'group') {
        $('#status-form-group').css('display', 'block');
    } else {
        $('#status-form-group').css('display', 'none');
    }

    if (parent.parents(".window").is("#div_A") || parent.parents(".window").is("#div_D")) {
        if ($("#permission_input").length != 0) {
            if (parent.attr('id').split('_')[0] == "student" || parent.attr("id").split("_")[0] == "author") {
                $("#permission_input").toggle(false);
            } else {
                $("#permission_input").toggle(true);
            }
        }
    }

    switch (element.attr('data-content')) {
        case 'student':
        case 'teacher':
        case 'author':
            $("#send-email-input").toggle(false);
            $("#send-email-template").toggle(false);
            $('#user_form .method-select').val('PUT');
            // $('#password').attr('disabled', false);
            toggleFormOrTable($('#LeftPanel'), true);
            clearFrom($('LeftPanel'));
            switch (element.attr('data-content')) {
                case 'student':
                case 'teacher':
                    if ($('#expired_date_input .input-group').length == 0) {
                        expired_date.appendTo($('#expired_date_input'));
                    }
                    break;
                case 'author':
                    if ($('#expired_date_input .input-group').length != 0) {
                        expired_date = $('#expired_date_input .input-group');
                        $('#expired_date_input .input-group').detach();
                    }
                    break;

                default:
                    break;
            }
            $('#user_form').attr('data-item', parent.attr('id'));
            $.get({
                url: baseURL + '/user/' + id,
                success: function (data, state) {
                    notification('We got user data successfully!', 1);
                    console.log(state);
                    if (data.user_info.interface_icon == null || data.user_info.interface_icon == "") {
                        $('#preview').attr('src', baseURL + '/assets/media/default.png');
                    } else {
                        $('#preview').attr('src', data.user_info.interface_icon);
                        $('#base64_img_data').val(data.user_info.interface_icon);
                    }

                    $('#login').val(data.user_info.login);
                    var expired_date = data.user_info.expired_date ? data.user_info.expired_date : (() => {
                        var date = new Date().toLocaleDateString("ja").split("/");
                        date[0] = parseInt(date[0]) + 1;
                        return date.join("-")
                    })();

                    $('#expired_date').val(expired_date);
                    $('#password').attr('placeholder', "Private password");
                    $('#generatepassword').prop('checked', false);
                    $('#firstname').val(data.user_info.first_name);
                    $('#lastname').val(data.user_info.last_name);
                    $('#language').val(data.user_info.lang);
                    $('#company').val(data.user_info.company);
                    $('#position').val(data.user_info.function);
                    $("#permission").val(data.user_info.permission_id);
                    $("#user_form").attr('action', baseURL + '/user/' + id);
                    $('#status-form-group').css('display', 'block !important');
                    if (data.user_info.auto_generate) {
                        $('#generatepassword').prop('checked', true);
                    }
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
                error: function (err) {
                    notification("Sorry, You can't get user data!", 2);
                }
            });

            break;

        case 'group':
            toggleFormOrTable($('#RightPanel'), true);
            clearFrom($('RightPanel'));
            $('#category_form').attr('data-item', parent.attr('id'));
            $.get({
                url: baseURL + '/group/' + id,
                success: function (data, state) {
                    notification('We got group data successfully!', 1);
                    console.log(state);
                    $('#category_name').val(data.name);
                    $('#category_description').val(data.description);
                    $('#status_checkbox').css('display', 'block');
                    $('#cate-status-icon').prop("checked", data.status == 1).change();
                    $('#cate-status').val(data.status);


                    $("#category_form").attr('action', baseURL + '/group/' + id);

                    $('#category_form .method-select').val('PUT');
                },
                error: function (err) {
                    notification("Sorry, You can't get group data!", 2);
                }
            });
            break;

        case 'company':
            $('#category_form').attr('data-item', parent.attr('id'));
            $.get({
                url: baseURL + '/company/' + id,
                success: function (data, state) {
                    notification('We got company data successfully!', 1);
                    console.log(state);
                    toggleFormOrTable($('#RightPanel'), true);
                    clearFrom($('RightPanel'));
                    $('#category_name').val(data.name);
                    $('#category_description').val(data.description);
                    $('#status_checkbox').css('display', 'none');

                    $("#category_form").attr('action', baseURL + '/company/' + id);

                    $('#category_form .method-select').val('PUT');

                },
                error: function (err) {
                    notification("Sorry, You can't get company data!", 2);
                }
            });
            break;

        case 'position':
            $('#category_form').attr('data-item', parent.attr('id'));
            $.get({
                url: baseURL + '/function/' + id,
                success: function (data, state) {
                    notification('We got position data successfully!', 1);
                    console.log(state);
                    toggleFormOrTable($('#RightPanel'), true);
                    clearFrom($('RightPanel'));

                    $('#category_name').val(data.name);
                    $('#category_description').val(data.description);
                    $('#status_checkbox').css('display', 'none');

                    $("#category_form").attr('action', baseURL + '/function/' + id);

                    $('#category_form .method-select').val('PUT');

                },
                error: function (err) {
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

/**
 * email button action
 */
var emailBtn = function (event) {
    var category = $(event.target).attr("data-content");
    var id = $(event.target).attr("data-id");
    window.location.href = baseURL + "/sendmail?" + category + "Id=" + id;
}

/**
 * item edit action
 * @param {*} event 
 */
var itemEdit = function (event) {
    item_edit($(this));
};

/**
 * form item change action
 * @param {} e 
 */
var formStatusChange = function (e) {
    $(this).val($(this).prop('checked'));
};

/**
 * item delete action
 * @param {*} element 
 */
var item_delete = function (element) {
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
                success: function (result) {
                    console.log(result);
                    parent.detach();
                    notification('Successfully deleted!', 1);
                },
                error: function (err) {
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
                success: function (result) {
                    console.log(result);
                    parent.detach();
                    $(`#div_B #group_${id}`).remove();
                    $(`#div_C #group_${id}`).remove();
                    toggleFormOrTable($("#RightPanel"), false, false);
                    notification('Successfully deleted!', 1);
                },
                error: function (err) {
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
                success: function (result) {
                    console.log(result);
                    parent.detach();
                    notification('Successfully deleted!', 1);
                },
                error: function (err) {
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
                success: function (result) {
                    console.log(result);
                    parent.detach();
                    notification('Successfully deleted!', 1);
                },
                error: function (err) {
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
                success: function (result) {
                    console.log(result);
                    parent.detach();
                    notification('Successfully deleted!', 1);
                },
                error: function (err) {
                    console.log(err);
                    notification("Sorry, You can't delete!", 2);
                }
            });
            break;

        default:
            break;
    }
};

/**
 * item delete action
 * @param {*} event 
 */
var itemDelete = function (event) {
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
        preConfirm: function (e) {
            return new Promise((function (e) {
                setTimeout((function () {
                    e();
                    item_delete(elem);
                }), 50);
            }));
        }
    }).then((function (n) {
        if (n.value) {
            e.fire('Deleted!', 'Your ' + cate + ' has been deleted.', 'success');
            $(elem).parents('.list-group-item').remove();
        } else {
            'cancel' === n.dismiss && e.fire('Cancelled', 'Your data is safe :)', 'error');
        }
    }));


};

/**
 * the action before the submit action
 * @param {} event 
 * @returns 
 */
var submitFunction = function (event) {
    console.log($(this).attr('action'));
    console.log($("#cate-status").attr("checked"));

    return false;
};

/**
 * detach link item 
 * @param {*} e 
 */
var detachLinkTo = function (e) {
    var parent = $(this).parents('.list-group-item');
    var showeditem = parent.attr('data-src');
    var id = parent.attr('id').split('_')[1];
    var cate = parent.attr('id').split('_')[0];
    var value = $("#" + showeditem).find('input[name="item-' + cate + '"]').val();
    if (cate == 'group') {
        $("#div_A #" + showeditem).find('input[name="item-' + cate + '"]').val(combine(value, id).join(','));
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

/**
 * detach button action 
 * @param {*} e 
 */
var detachLinkFrom = function (e) {
    var parent = $(this).parents('.list-group-item');
    var divAitem = $("#div_A #" + parent.attr('id'));
    var showeditem = parent.attr('data-src');
    var id = $("#" + showeditem).attr('id').split('_')[1];
    var cate = $("#" + showeditem).attr('id').split('_')[0];
    var value = divAitem.find('input[name="item-' + cate + '"]').val();
    if (cate == 'group') {
        divAitem.find('input[name="item-' + cate + '"]').val(combine(value, id).join(','));
    } else {
        divAitem.find('input[name="item-' + cate + '"]').val('');
    }

    var result = divAitem.find('input[name="item-' + cate + '"]').val();
    var parent_id = parent.attr('id').split('_')[1];

    detachCall(cate, {
        id: parent_id,
        target: result,
        flag: false
    }, $(this));
};

/**
 * json array combine
 * @param {*} value 
 * @param {*} id 
 * @returns 
 */
var combine = function (value, id) {
    var combineArray = value.split(',').filter(function (item, i, d) {
        return item != id && item != null;
    });
    return combineArray;
};

/**
 * detach action api call
 */
var detachCall = function (cate, connectiondata, element) {
    $.post({
        url: baseURL + '/userjointo' + cate,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'data': JSON.stringify(Array(connectiondata))
        }
    }).then(function (data) {
        notification('Successfully unliked!', 1);
        if (element.parents('fieldset').attr('id') == 'RightPanel') {
            toggleFormOrTable($("#LeftPanel"), false, false);
        } else {
            toggleFormOrTable($("#RightPanel"), false, false);
        }
        element.parents('.list-group-item').detach();
        return true;
    }).fail(function (err) {
        notification("Sorry, Your action brocken!", 2);
        return false;
    }).always(function (data) {
        // console.log(data);
    });
};

/**
 * "save" button action
 */
var submitBtn = function (event) {
    var formname = $(this).attr('data-form');
    var inputpassword = document.getElementById('password');
    if ($("#" + formname).attr('data-item')) {
        $("#" + $(this).parents('form').attr('data-item')).toggleClass('highlight', false);
        $("#" + $(this).parents('form').attr('data-item') + " .btn").each(function (i, em) {
            $(em).toggleClass('active', false);
        });
    }
    var validate = true;
    document.getElementById(formname).checkValidity();
    //TODO: We have to check this function again after a while;
    var regularExpression = new RegExp("^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[!%&@#$^*?_~+={}().,\/<>-]).*$");
    var password = $('#password').val();
    if (formname == 'user_form') {
        validate = validate && $("#login")[0].checkValidity();
        validate = validate && $("#user-email")[0].checkValidity();
        validate = validate && $("#lastname")[0].checkValidity();
        validate = validate && $("#firstname")[0].checkValidity();
        if ($("#send-email-template").is(":visible")) {
            validate = validate && $("#email_template")[0].checkValidity();
        }
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

        if (($('#expired_date').val() == '' || $('#expired_date').val() == null) && $('#expired_date_input .input-group').length != 0) {
            validate = false;
            validate = validate && $("#expired_date")[0].checkValidity();
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

        $('#' + formname).find('input, switch').each(function (i, e) {
            submit_data[$(e).attr('name')] = $(e).val();
        });

        // console.log($('#' + formname).serializeArray());
        // var serialval = $('#' + formname).serializeArray().map(function(item) {
        //     var arr = {};
        //     if (item.name == 'user-status-icon') {
        //         item.value = $('#user-status-icon').prop('checked') == true ? 1 : 0;
        //     } else if (item.name == 'cate-status-icon') {
        //         item.value = $('#cate-status-icon').prop("checked") == true ? 1 : 0;
        //     } else if (item.name == 'generatepassword') {
        //         item.value = $('#generatepassword').prop("checked") == true ? 1 : 0;
        //     }
        //     return item;
        // });
        // if (!serialval.filter(function(em, t, arr) {
        //         return em.name == 'user-status-icon' || em.name == 'cate-status-icon';
        //     }).length) {
        //     if (formname == 'user_form') {
        //         serialval.push({
        //             name: 'user-status-icon',
        //             value: $('#user-status-icon').prop('checked') == true ? 1 : 0
        //         });
        //         serialval.push({
        //             name: 'generatepassword',
        //             value: $('#generatepassword').prop('checked') == true ? 1 : 0
        //         });
        //     } else if (formname == 'cate_form') {
        //         serialval.push({
        //             name: 'cate-status-icon',
        //             value: $('#cate-status-icon').prop('checked') == true ? 1 : 0
        //         });
        //     }
        // }
        // if (!$("#" + formname).find('input[type=checkbox]').prop('checked')) {
        //     if (formname == 'user_form') {
        //         serialval.push({
        //             name: 'user-status-icon',
        //             value: 0
        //         });
        //         if ($('#generatepassword').prop('checked') == false) {
        //             serialval.push({
        //                 name: 'generatepassword',
        //                 value: 0
        //             });
        //         }
        //     } else if (formname == 'cate_form') {
        //         serialval.push({
        //             name: 'cate-status-icon',
        //             value: 0
        //         });
        //     }
        // }

        if ($(event.target).parents("form").attr("id") == "user_form") {
            var serialval = $("#user_form").find("select, input").map(function () {
                return {
                    name: this.name,
                    value: $(this).is(":checkbox") ? this.checked ? 1 : 0 : this.value
                }
            });
        } else {
            var serialval = $("#category_form").find("select, input").map(function () {
                return {
                    name: this.name,
                    value: $(this).is(":checkbox") ? this.checked ? 1 : 0 : this.value
                }
            });
        }

        console.log(serialval);
        $.ajax({
            url: $('#' + formname).attr('action'),
            method: $('#' + formname).find('.method-select').val(),
            data: serialval,
            success: function (data) {
                console.log(data);
                if ($("#" + formname).attr('data-item') == '' || $("#" + formname).attr('data-item') == null) {
                    var arr_url = $('#' + formname).attr('action').split('/');
                    var groupName = arr_url[arr_url.length - 1];
                    switch (groupName) {
                        case 'user':
                            if (data ? .mail_success) {
                                notification('Success to send mail to User!', 1);
                            } else if (data ? .mail_success == false) {
                                notification('Fail to send mail to User!', 2);
                            }
                            notification('User added successfully!', 1);
                            switch ($("#user_type").val()) {
                                case '4':
                                    notification('A student has been registered sucessfully!', 1);
                                    $('#students .list-group').append(createUserData(data, 'student'));
                                    break;

                                case '3':
                                    notification('A teacher has been registered sucessfully!', 1);
                                    $('#teachers .list-group').append(createUserData(data, 'teacher'));
                                    break;

                                case '2':
                                    notification('An author has been registered sucessfully!', 1);
                                    $('#authors .list-group').append(createUserData(data, 'author'));
                                    break;

                                default:
                                    break;
                            }
                            $("#div_A")[0].scrollTop = $("#div_A")[0].scrollHeight;
                            break;
                        case 'group':
                            notification('The group has been saved sucessfully!', 1);
                            $('#groups .list-group').append(createGroupData(data, 'group'));
                            $("#div_C")[0].scrollTop = $("#div_C")[0].scrollHeight;
                            break;
                        case 'company':
                            var email_btn = $('<button class="btn item-mail toggle1-btn" data-content="company" data-id="' + data.id + '">' +
                                '<i class="px-2 fa fa-envelope"></i>' +
                                '</button>');
                            email_btn.click(btnClick);
                            email_btn.click(emailBtn);
                            notification('The company has been saved sucessfully!', 1);
                            var company_item = createCategoryData(data, 'company');
                            company_item.find(".btn-group").prepend(email_btn);
                            $('#companies .list-group').append(company_item);
                            $('#company').append('<option value="' + data.id + '">' + data.name + '</option>');
                            $("#div_C")[0].scrollTop = $("#div_C")[0].scrollHeight;
                            break;
                        case 'function':
                            notification('The position has been saved sucessfully!', 1);
                            $('#positions .list-group').append(createCategoryData(data, 'function'));
                            $('#position').append('<option value="' + data.id + '">' + data.name + '</option>');
                            $("#div_C")[0].scrollTop = $("#div_C")[0].scrollHeight;
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
            error: function (err) {
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

/**
 * create session item contained for user
 * @param {*} data 
 * @returns 
 */
var createSessionItem = function (data) {
    var status_temp = data.status == 1 ?
        '<i class="fa fa-circle m-2" style="color:green"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2" style="color:red"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var session_item = $('<a class="list-group-item list-group-item-action p-1 border-0 session_' + data.id + '" id="session_' + data.id + ' data-date="' + data.create_date + '"">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.name + '">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '</div>' +
        '</a>');
    var editBtn = $('<button class="btn  item-session-button" data-content="session_' + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>');
    editBtn.click(function (e) {
        if ($("#content").attr("data-session-edit") == 1) {
            window.open(baseURL + "/session", '_blank');
        }
    })
    session_item.find(".btn-group").append(editBtn);
    return session_item;
}


/**
 * creaet user item data
 * @param {*} data 
 * @param {*} category 
 * @returns 
 */
var createUserData = function (data, category) {
    var status_temp = data.user.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var userItem = $('<a class="list-group-item list-group-item-action p-0 border-transparent border-5x ' + category + '_' + data.user.id + '" id="' + category + '_' + data.user.id + '" data-date="' + data.user.creation_date + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.user.first_name + '&nbsp;' + data.user.last_name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.user.first_name + data.user.last_name + '">' +
        '<input type="hidden" name="item-group" value="' + data.user.linked_groups + '">' +
        '<input type="hidden" name="item-company" value="' + data.user.company + '">' +
        '<input type="hidden" name="item-function" value="' + data.user.function+'">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '<span class=" p-2 font-weight-bolder item-lang">' + data.lang.toUpperCase() + '</span>' +
        '</div>' +
        '</a>');
    var email_btn = $('<button class="btn item-mail toggle1-btn" data-content="' + category + '" data-id="' + data.user.id + '">' +
        '<i class="px-2 fa fa-envelope"></i>' +
        '</button>');

    var showbtn = $('<button class="btn  item-show" data-content="' + category + '">' +
        '<i class="px-2 fa fa-eye"></i>' +
        '</button>');

    var editbtn = $('<button class="btn item-edit" data-content="' + category + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>');

    var deletebtn = $('<button class="btn item-delete" data-content="' + category + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>');

    email_btn.click(btnClick);
    email_btn.click(emailBtn);

    userItem.attr('drag', false);

    showbtn.click(btnClick);
    showbtn.click(divACshow);
    showbtn.click(divAshow);

    editbtn.click(btnClick);
    editbtn.click(itemEdit);
    editbtn.click(divACedit);

    deletebtn.click(btnClick);
    deletebtn.click(itemDelete);

    // userItem.dblclick(itemDBClick);
    userItem.find('.btn-group').append(email_btn).append(showbtn).append(editbtn).append(deletebtn);
    userItem.click(leftItemClick);

    userItem.find('.item-name').val(data.user.first_name + data.user.last_name);
    userItem.bind('dragstart', dragStart);
    userItem.bind('dragend', dragEnd);
    userItem.attr('draggable', true);

    return userItem;

};

/**
 * create group item data
 */
var createGroupData = function (data, category) {
    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var groupItem = $('<a class="list-group-item list-group-item-action p-1 border-0 border-transparent border-5x ' + category + '_' + data.id + '" id="' + category + '_' + data.id + '" data-date="' + data.creation_date + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.name + '">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '<button class="btn item-mail toggle1-btn" data-content="' + category + '" data-id="' + data.id + '">' +
        '<i class="px-2 fa fa-envelope"></i>' +
        '</button>' +
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

    groupItem.find(".item-mail").click(emailBtn);
    groupItem.find('button.btn').click(btnClick);
    groupItem.find('.item-edit').click(itemEdit);
    groupItem.find('.item-edit').click(divACedit);
    groupItem.find('.item-delete').click(itemDelete);
    groupItem.find('.item-show').click(divACshow);
    groupItem.find('.item-show').click(divCshow);

    return groupItem;
};

/**
 * create category data (company |position)
 * @param {} data 
 * @param {*} category 
 * @returns 
 */
var createCategoryData = function (data, category) {
    var cateItem = $(' <a class="list-group-item list-group-item-action p-1 border-0 border-transparent border-5x ' + category + '_' + data.id + '" id="' + category + '_' + data.id + '" data-date="' + data.creation_date + '">' +
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

/**
 * update user item data
 */
var updateUserData = function (data, target) {
    $('.' + target).each(function (i, im) {
        $(im).find('.item-name').html(data.user.first_name + "&nbsp;" + data.user.last_name);
        $(im).find('.status-notification').val(data.user.status);
        $(im).find('.status-notification').prev().css('color', data.user.status == '1' ? 'green' : 'red');
        $(im).find('input[name="item-name"]').val(data.user.name);
        $(im).find('input[name="item-group"]').val(data.user.linked_groups);
        $(im).find('input[name="item-company"]').val(data.user.company);
        $(im).find('input[name="item-function"]').val(data.user.function);
        $(im).find('.item-lang').html(data.lang.toUpperCase());
        if ($(im).attr('data-src')) {
            switch ($(im).attr('data-src').split('_')[0]) {
                case 'company':
                    if ($(im).attr('data-src').split('_')[1] != data.user.company) {
                        $(im).detach();
                    }
                    break;
                case 'function':
                    if ($(im).attr('data-src').split('_')[1] != data.user.function) {
                        $(im).detach();
                    }
                    break;

                default:
                    break;
            }
        }
    });

};

/**
 * update group item
 */
var updateGroupData = function (data, target) {
    $('.' + target).each(function (i, im) {
        $(im).find('.item-name').html(data.name);
        $(im).find('input[name="item-name"]').html(data.name);
        $(im).find('.status-notification').val(data.status);
        $(im).find('.status-notification').prev().css('color', data.status == '1' ? 'green' : 'red');
    });
};

/**
 * update category data(company | position)
 */
var updateCategoryData = function (data, target) {
    $('.' + target).each(function (i, im) {
        $(im).find('.item-name').html(data.name);
        $(im).find('input[name="item-name"]').val(data.name);
    });
};

/**
 * cancel toggle filter
 * @param {*} event 
 */
var cancelBtn = function (event) {
    var parent = $(this).parents('fieldset');
    if ($(this).parents('form').attr('data-item')) {
        $("#" + $(this).parents('form').attr('data-item')).toggleClass('highlight');
        $("#" + $(this).parents('form').attr('data-item') + " .btn").each(function (i, em) {
            $(em).toggleClass('active', false);
        });
    }
    toggleFormOrTable(parent, null, false);
};

/**
 * toggle filter mode for company
 * @param {*} event 
 */
var filterCompanyBtn = function (event) {
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

/**
 * filter toggle for position button action
 * @param {*} event 
 */
var filterFunctionBtn = function (event) {
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

/**
 * clear filter mode
 * @param {*} element 
 * @param {*} category 
 * @param {*} defaultStr 
 */
var clearFilterCategory = function (element, category, defaultStr) {
    $(element).val('');
    $(element).html(defaultStr);
    $(element).change();
    $('#' + category).find('.list-group-item').each(clearClassName);
    $('#' + category).find('.toggle1-btn').toggle(true);
    $('#' + category).find('.toggle2-btn').toggle(false);
};

/**
 *  toggle filter mode
 * @param {*} element 
 * @param {*} category //company or position 
 * @param {*} defaultStr //"company X" or "position X": the toggle button inner html
 */
var toggleAndSearch = function (element, category, defaultStr) {
    if ($('#' + category).find('.list-group-item.active').length) {
        var items = [],
            itemVal = [];
        $('#' + category).find('.list-group-item.active').each(function (i, el) {
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
        $(activedTab).find('.toggle2-btn').each(function (i, e) {
            $(e).toggle(false);
            $(e).siblings('.toggle1-btn').toggle(true);
            $(e).parents('.list-group-item').toggleClass('active', false);
        });
    }
};

/**
 * identify whether the category of filter item is company or position and show the filter items on the right side list with check box
 * @param {*} element 
 * @param {*} category 
 */
var getFilterCategory = function (element, category) {
    $(activedTab).fadeOut(1);
    $('#' + category).fadeIn(1);
    $('#' + category + " .list-group").attr('data-filter', $(element).parents('.toolkit').attr('id'));
    $(element).html('Cancel');
    $("#" + category).find('.toggle2-btn').each(function (i, e) {
        $(e).toggle(true);
    });
    $("#" + category).find('.toggle1-btn').each(function (i, e) {
        $(e).toggle(false);
    });
    $('#' + category).find('.list-group-item').each(clearClassName);
};

/**
 * cancel filter mode of user by company or position
 */
var cancelFilterCategoryAll = function () {
    $('.filter-function-btn').each(function (i, e) {
        if ($(e).html() != 'function +<i></i>') {
            $(e).html('function +<i></i>');
            $(e).val('');
            $('#positions').fadeOut(1);
            $(activedTab).fadeIn(1);
        }
    });
    $('.filter-company-btn').each(function (i, e) {
        if ($(e).html() != 'company +<i></i>') {
            $(e).html('company +<i></i>');
            $(e).val('');
            $('#companies').fadeOut(1);
            $(activedTab).fadeIn(1);
        }
    });
};
/**
 * when we click filter by company or position, we can see the check button at end of company or position item
 * This is action when that buttons are clicked 
 * @param {*} evt 
 */
var toggle2Btn = function (evt) {
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

/**
 * Search the data of selected tag
 * @param {event} event 
 */
var searchfilter = function (event) {
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

    items.map(function (i, e) {
        var item_name = $(e).find('input[name="item-name"]').val();
        var item_status = $(e).find('input[name="item-status"]').val();
        var item_company = $(e).find('input[name="item-company"]').val();
        var item_function = $(e).find('input[name="item-function"]').val();

        // console.log(item_name);

        if (str == null || str == '' || item_name.toLowerCase().indexOf(str.toLowerCase().replace(/\s+/g, '')) >= 0) {
            if (ctgc == '' || ctgc.split("_").filter(function (iem, i, d) {
                    return iem == item_company;
                }).length) {
                if (ctgf == '' || ctgf.split("_").filter(function (iem, i, d) {
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
        // $('#div_left').dblclick();
    } else if ($(this).parents('fieldset').attr('id') == "RightPanel") {
        heightToggleRight = true;
        // $('#div_right').dblclick();
    }
};

/**
 * Sort the items in the selected tag
 * @param {*} event 
 */
var sortfilter = function (event) {
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
                $items.sort(function (a, b) {
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
                $items.sort(function (a, b) {
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
                $items.sort(function (a, b) {
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
                $items.sort(function (a, b) {
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
                $items.sort(function (a, b) {
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
                $items.sort(function (a, b) {
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

/**
 * Give check item value 1 or 0 
 * @param {event} e 
 */
var cateStateIcon = function (e) {
    var el = $(this);
    if (el.is(':checked')) {
        $("#cate-status").val(1);
    } else {
        $("#cate-status").val(0);
    }
};

/**
 * Tag click action
 * @param {*} event 
 */
var tabClick = function (event) {
    $(this).parents(".nav.nav-tabs").find(".ui-state-active").toggleClass("ui-state-active", false);
    $(this).parents(".nav-item").toggleClass("ui-state-active", true);
    if ($(this).parents('fieldset').attr('id') == 'LeftPanel') {

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
                $('#div_A').find('.list-group-item').each(clearClassName);
                toggleFormOrTable($('#LeftPanel'), null, false);
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

                if (activedTab != '#positions' || activedTab != '#companies') {
                    $('#companies-tab').click();
                }

                $('#user-toolkit .filter-function-btn').toggle(true);
                toggleFormOrTable($('#LeftPanel'), null, false);
                $('#div_A').find('.list-group-item').each(clearClassName);

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
                if (activedTab != '#companies') {
                    $('#companies-tab').click();
                }
                toggleFormOrTable($('#LeftPanel'), null, false);
                $('#div_A').find('.list-group-item').each(clearClassName);

                break;

            default:
                break;
        }
        $("#LeftPanel").find(".list-group-item").each(function () {
            $(this).removeClass("active");
        });
        cancelFilterCategoryAll();
        if ($('#cate-toolkit .search-filter').val() == '') {
            $('#user-toolkit .search-filter').change();
        } else {
            $('#user-toolkit .search-filter').val('');
        }
        $('#user-toolkit input[name="status"]:checked').prop('checked', false);
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

        toggleFormOrTable($('#RightPanel'), null, false);
        cancelFilterCategoryAll();
        $("#RightPanel").find(".list-group-item").each(function () {
            $(this).removeClass("active");
        });
        $('#div_C').find('.list-group-item').each(clearClassName);
        if ($('#cate-toolkit .search-filter').val() == '') {
            $('#cate-toolkit .search-filter').change();
        } else {
            $('#cate-toolkit .search-filter').val('');
        }
        var nameIcon = $('#cate-toolkit').find('.filter-name-btn i');
        var dateIcon = $('#cate-toolkit').find('.filter-date-btn i');
        nameIcon.toggleClass('fa-sort-alpha-down', false);
        nameIcon.toggleClass('fa-sort-alpha-up', false);
        dateIcon.toggleClass('fa-sort-numeric-down', false);
        dateIcon.toggleClass('fa-sort-numeric-up', false);
        $('#cate-toolkit input[name="status"]:checked').prop('checked', false)
    }
};

/**
 * action when height controller dbClicked  
 * @param {} event 
 */
var handlerDBClick = function (event) {
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
        var activeTabHeight = parseInt($($(this).parents('fieldset').find('.ui-state-active a').first().attr('href')).innerHeight());
        var newHeight = (h - parseInt($('.toolkit').css('height')) - divHight) / 2 - 90;
        if (newHeight > activeTabHeight) {
            $(this).prev().css('height', activeTabHeight + "px");
        } else {
            $(this).prev().css('height', newHeight + "px");
        }
    }
};
//////////////////////////////////
///////////////////////////////////
//////////////////////////////////

var dragitem = null;

/**
 * action when user item started to drag
 * @param {*} event 
 */
function dragStart(event) {
    dragitem = Array();
    $(this).parents(".list-group").children('.active.list-group-item').each(function (i, dragelem) {
        if (!$(dragelem).is(".drag-disable"))
            dragitem.push($(dragelem).attr("id"));
    });
    if (dragitem.indexOf($(this).attr('id')) == -1) {
        if (!$(dragitem).is(".drag-disable"))
            dragitem.push($(this).attr('id'));
    }
}

/**
 * hover action when user item is dragged 
 * @param {*} event 
 */
function dragOver(event) {
    $(event.target).css('opacity', '50%');
    event.preventDefault();
}

/**
 * lost hover action when user item is dragged
 * @param {*} event 
 */
function dragLeave(event) {
    $(event.target).css('opacity', '100%');
    event.preventDefault();
}


/**
 * action when user item drag is over
 * @param {*} event 
 */
function dragEnd(event) {
    $('main').css('cursor', 'default');
}

/**
 * action when user item is draged into an category item
 * api call
 * @param {*} event 
 * @param {*} item 
 */
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
        dragitem.map(function (droppeditem) {

            // console.log(droppeditem.split('_')[1]);
            if (cate == "group") {
                var cate_items = $("#" + droppeditem).find('input[name="item-group"]').val();
                if (cate_items.indexOf(cate_id) == -1) {
                    cate_items += "," + cate_id;
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
        }).done(function (data) {
            console.log('after join', data);

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
        }).fail(function (err) {
            notification("Sorry, You have an error!", 2);
            requestData = [];
        }).always(function (data) {
            // console.log(data);
            dragitem = null;
        });
    }
    $("#LeftPanel").find('.list-group-item').each(function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
    });
}

function companyDropEnd(event, item) {
    $(event.target).css('opacity', '100%');
    if (dragitem != null && dragitem[0].split('_')[0] == 'company') {
        $(this).html(dragitem.map(function (om, t, rr) {
            return $('#' + om + " .item-name").html();
        }).join(', ') + "&nbsp <i>X</i>");
        var companyName = dragitem.map(function (e, i, r) {
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
        $(this).html(dragitem.map(function (om, t, rr) {
            return $('#' + om + " .item-name").html();
        }).join(', ') + "&nbsp <i>X</i>");
        var companyName = dragitem.map(function (e, i, r) {
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
/**
 * initialization of the user interface and quote the actions
 */
$(document).ready(function () {

    // var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));
    // $("#content").css({
    //     'max-height': h - $('#div-left').height() - $('.content-header').height() - $('.nav-tab').height()
    // });

    // if ($('#div_A, #div_C').css('height') > $('#content').css('height') * 0.7) {
    //     $('#div_A, #div_C').css('height', $('#content').css('height') * 0.7);
    // }

    $("#send-email-template").toggle(false);

    $('#LeftPanel .toolkit>div').css('background-color', 'var(--student-h)');
    $('#RightPanel .toolkit:first>div').css('background-color', 'var(--group-h)');
    $('.second-table .toolkit>div').css('background-color', 'var(--student-h)');



    $("#RightPanel .list-group-item").each(function (i, elem) {
        $(elem).attr('draggable', false);
        $(elem).on('drop', dropEnd);

        elem.addEventListener('dragover', dragOver);
        elem.addEventListener('dragleave', dragLeave);
    });

    $("#LeftPanel .list-group-item").each(function (i, elem) {
        if (($(elem).attr('data-creator') == $("#content").attr("data-authed-user") && $("#content").attr("data-authed-user-type") == 3) || ($("#content").attr("data-authed-user-type") != 3)) {
            elem.addEventListener('dragstart', dragStart);
            elem.addEventListener('dragend', dragEnd);
            $(elem).attr('draggable', true);
        }
    });

    $(".filter-company-btn").on('drop', companyDropEnd);
    $(".filter-function-btn").on('drop', functionDropEnd);

    if ($("input[name='routeOfUser']").length) {
        var value = $("input[name='routeOfUser']").val();
        var cate = value.split("_")[0];
        var id = value.split("_")[1];
        switch (cate) {
            case "student":
                $("#students-tab").parents('li.nav-item').addClass("ui-state-active");
                $('#students-tab').click();
                $("#student_" + id + " .item-edit").click();
                break;
            case "teacher":
                $("#teachers-tab").parents('li.nav-item').addClass("ui-state-active");
                $('#teachers-tab').click();
                $("#teacher_" + id + " .item-edit").click();
                break;

            default:
                break;
        }
    }


    // $('#students .list-group').multiSelect({
    //     unselectOn: 'body',
    //     keepSelection: false,
    //     filter:" > .list-group-item"
    // });

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
$('.csv-import-item').click(csvImportItem);
$('.toolkit-multi-delete').click(toolkitMultiDelete);
$('form').submit(submitFunction);
$('form input, form select').change(formInputChange);
$('#user-status-icon, #cate-status-icon').change(formStatusChange);
$('.submit-btn').click(submitBtn);
$('.cancel-btn').click(cancelBtn);
$('.csv-submit-btn').click(csvSubmitBtn);
$('.user-import-btn').click(csvImportBtn);

$(".toolkit-show-filter").click(filterToggleShow);
$('.filter-company-btn').click(filterCompanyBtn);
$('.filter-function-btn').click(filterFunctionBtn);
$('.filter-name-btn').click(sortfilter);
$('.filter-date-btn').click(sortfilter);
$("#cate-status-icon").change(cateStateIcon);

$('.toggle2-btn').click(toggle2Btn);
$('#table-user').on('DOMSubtreeModified', countDisplayUser);
$('.nav-link').click(tabClick);

$('.handler_horizontal').dblclick(handlerDBClick);

$('#generatepassword').change(function (event) {
    if ($(this).prop('checked') == true) {
        $.get({
            url: baseURL + "/usercreate",
            success: function (data) {
                notification('Initializing login and password success!', 1);
                $('#password').val(data.password);
                $('#password').attr('data-password', data.password);
                $('#login').val(data.name);
            },
            error: function (err) {
                notification('You have a problem getting new password!');
            }
        });
        // $('#password').attr('disabled', true);
    } else {
        // $('#password').attr('disabled', false);
    }
});
$("#password-input .input-group-append>span.input-group-text").click(function (event) {
    var item = $(event.target).closest("span.input-group-text").find("i");
    var target_elem = item.parents(".form-group").find('.pr-password');
    var type = target_elem.attr("type");
    if (type == "password") {
        target_elem.attr("type", "text");
        item.toggleClass("fa-eye-slash", true).toggleClass("fa-eye", false);
    } else {
        target_elem.attr("type", "password");
        item.toggleClass("fa-eye-slash", false).toggleClass("fa-eye", true);
    }
});
$("#div_A, #div_C").on("DOMSubtreeModified", function () {
    if ($(this).attr("id") == "div_A") {
        heightToggleLeft = true;
    } else {
        heightToggleRight = true;
    }
    $(this).parents("fieldset").find(".handler_horizontal").dblclick();
    // $(this).find(".handler_horizontal").dblclick();
});
$("#send-email-input").click(function (event) {
    $("#send-email-template").toggle($(event.target).prop('checked'));
});

// $.fn.multiSelect = function(o) {
//     var defaults = {
//         multiselect: true,
//         selected: 'active',
//         filter:        ' > *',
//         unselectOn:    false,
//         keepSelection: true,
//         list:            $(this).selector,
//         e:                null,
//         element:    null,
//         start: false,
//         stop: false,
//         unselecting: false
//     }
//     return this.each(function(k,v) {
//         var options = $.extend({}, defaults, o || {});
//         // selector - parent, assign listener to children only
//         $(document).on('mousedown', options.list+options.filter, function(e) {
//             if (e.which == 1){
//                 if (options.handle != undefined && !$(e.target).is(options.handle)) {
//                     // TODO:
//                     // keep propagation?
//                     // return true;
//                 }
//                 options.e = e;
//                 options.element = $(this);
//                 multiSelect(options);
//             }
//             return true;
//         });

//         if (options.unselectOn) {
//             // event to unselect

//             $(document).on('mousedown', options.unselectOn, function(e) {
//                 if (!$(e.target).parents().is(options.list) && e.which != 3) {
//                     $(options.list+' .'+options.selected).removeClass(options.selected);
//                     if (options.unselecting != false) {
//                         options.unselecting();
//                     }
//                 }
//             });

//         }

//     });


// }

// function multiSelect(o) {

//     var target = o.e.target;
//     var element = o.element;
//     var list = o.list;

//     if ($(element).hasClass('ui-sortable-helper')) {
//         return false;
//     }

//     if (o.start != false) {
//         var start = o.start(o.e, $(element));
//         if (start == false) {
//             return false;
//         }
//     }

//     if (o.e.shiftKey && o.multiselect) {
//         // get one already selected row
//         $(element).addClass(o.selected);
//         first = $(o.list).find('.'+o.selected).first().index();
//         last = $(o.list).find('.'+o.selected).last().index();

//         // if we hold shift and try to select last element that is upper in the list
//         if (last < first) {
//             firstHolder = first;
//             first = last;
//             last = firstHolder;
//         }

//         if (first == -1 || last == -1) {
//             return false;
//         }

//         $(o.list).find('.'+o.selected).removeClass(o.selected);

//         var num = last - first;
//         var x = first;

//         for (i=0;i<=num;i++) {
//             $(list).find(o.filter).eq(x).addClass(o.selected);
//             x++;
//         }
//     } else if ((o.e.ctrlKey || o.e.metaKey) && o.multiselect) {
//         // reset selection
//         if ($(element).hasClass(o.selected)) {
//             $(element).removeClass(o.selected);
//         } else {
//             $(element).addClass(o.selected);
//         }
//     } else {
//         // reset selection
//         if (o.keepSelection && !$(element).hasClass(o.selected)) {
//            $(list).find('.'+o.selected).removeClass(o.selected);
//            $(element).addClass(o.selected);
//         } else {
//            $(list).find('.'+o.selected).removeClass(o.selected);
//            $(element).addClass(o.selected);
//         }

//     }

//     if (o.stop != false) {
//         o.stop($(list).find('.'+o.selected), $(element));
//     }

// }

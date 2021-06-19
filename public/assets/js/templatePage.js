// const { nodeName } = require("jquery");

// const { parseHTML } = require("jquery");

// const { forEach } = require("lodash");

var h = (window.innerHeight || (window.document.documentElement.clientHeight || window.document.body.clientHeight));


// const VIEWMODE = 1,
//     EDITMODE = 2,
//     SAVEMODE = 3,

//     UPDATEMODE = 1,
//     ADDMODE = 2;

// let tmpbtnmode = VIEWMODE,
//     sendmode = UPDATEMODE;

// let selecteditem;


// var baseURL = window.location.protocol + "//" + window.location.host;
var baseURL = window.location.protocol + "//" + window.location.host + '/newlms';
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

var templateDateSort = false,
    templateNameSort = false,
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

var leftItemClick = function(e) {
    $(this).parents('.list-group').find('.list-group-item').each(function(i, em) {
        $(em).toggleClass('active', false);
    });
    if (!$(this).hasClass("active")) {
        $(this).addClass("active");
    } else {
        $(this).removeClass("active");
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
                table.each(function(i, em) {
                    $(em).css('display', 'none');
                });
                return form;
            }
        } else if (!flag) {
            if (table.css('display') == "none") {
                form.css('display', 'none');
                table.each(function(i, em) {
                    $(em).css('display', 'block');
                });
                return table;
            }
        } else if (flag == null) {
            if ($(table[0]).css('display') == "block") {
                table.each(function(i, em) {
                    $(em).css('display', 'none');
                });
                form.css('display', 'block');

                return form;
            } else {
                if (form.css('display') == "block") {
                    form.css('display', 'none');
                    table.each(function(i, em) {
                        $(em).css('display', 'block');
                    });

                    return table;
                }
            }
        }
    } else {
        form.toggle(false);
        table.each(function(i, em) {
            $(em).toggle(false);
        });
        return null;
    }

};

var goTab = function(name) {
    // console.log($('#' + name + '-tab')[0]);
    $('#' + name + '-tab').click();
};

var filterToggleShow = function(event) {
    var parent = $(this).parents('.toolkit');
    parent.children(".toolkit-filter").toggle();
    // if (parent.attr('id') == 'template-toolkit') {
    //     var leftActiveTab = $('#LeftPanel .ui-state-active a').attr('href').split('#')[1];
    //     if ( /* leftActiveTab == 'teachers' ||  */ leftActiveTab == 'authors') {
    //         parent.find('.filter-function-btn').toggle(false);
    //     } else {
    //         parent.find('.filter-function-btn').toggle(true);
    //     }

    // }

    parent.children('.toolkit-filter input').each(function(i, e) {
        $(e).attr('checked', false);
    });
    parent.children('.search-filter').val('');
    parent.children('.filter-company-btn').html('company +<i></i>');
    parent.children('.filter-function-btn').html('function +<i></i>');

    parent.find('.search-filter').val('');
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

    parent.find('.filter-name-btn i').toggleClass('fa-sort-alpha-down', false);
    parent.find('.filter-name-btn i').toggleClass('fa-sort-alpha-up', false);
    parent.find('.filter-date-btn i').toggleClass('fa-sort-numeric-up', false);
    parent.find('.filter-date-btn i').toggleClass('fa-sort-numeric-down', false);
};

var divACshow = function(event) {
    var parent = $(this).parents('.list-group-item');
    $.post({
            url: baseURL + '/gettemplatefromcate',
            data: {
                data: parent.attr('id')
            }
        })
        .then(function(data) {
            if (data) {
                data = data.data;
            }
            if (data.name) {
                notification("Getting Data Success", 1);
                var showedcomp = createTemplateData(data, 'template');
                showedcomp.attr("data-src", parent.attr('id'));
                showedcomp.find('.item-duplicate').detach();
                showedcomp.find('.btn-group').append($('<button class="btn toggle1-btn"><i class="px-2 fas fa-unlink"></i></button>').click(detachLink));
                $("#div_D .list-group").append(showedcomp);
            }
        }).fail(function(err) {
            notification("You got an error getting data", 2);
        });
    toggleFormOrTable($("#RightPanel"), false);
};

var itemTemplate = function(event) {
    window.open(baseURL + "/template_editor/" + $(this).attr('data-template'), '_blank');
};

var itemDuplicate = function(event) {
    var parent = $(this).parents('.list-group-item');
    $.post({
            url: baseURL + '/templateduplicate',
            data: {
                id: parent.attr('id').split('_')[1]
            }
        })
        .then(function(data) {
            console.log(data);
            // var data = {
            //     id: parent.attr('id').split('_')[1],
            //     creation_date: parent.attr('data-date'),
            //     status: parent.find('.float-left i').css('color') == 'green' ? 1 : 0,
            //     name: parent.find('.item-name').html(),
            //     alpha_id: parent.find('button.item-template').attr('data-template').split('/')[2]
            // }
            createTemplateData(data, "template").insertAfter(parent);
        }).fail(function(err) {

        });

}

var toolkitAddItem = function(event) {
    event.preventDefault();
    event.stopPropagation();
    toggleFormOrTable($(this).parents('fieldset'), true);
    var parent = $(this).parents('fieldset');
    var parent_id = parent.attr('id');
    var activeTagName;
    if (parent_id == 'RightPanel') {
        activeTagName = $('#RightPanel').find('.ui-state-active:first a').attr('href');
        $('#div_B').find('.list-group-item').each(clearClassName);
        switch (activeTagName) {
            case '#training':
                $("#category_form").attr('action', baseURL + '/training');
                $('#status_checkbox').css('display', 'block');
                $('#cate-status-icon').attr("checked", 'checked');
                break;
            case '#companies':
                $("#category_form").attr('action', baseURL + '/company');
                $('#status_checkbox').css('display', 'none');
                break;
            case '#session':
                $("#category_form").attr('action', baseURL + '/session');
                $('#status_checkbox').css('display', 'none');

                break;

            default:
                console.log('There is some error adding new component');
                break;
        }
        $('#category_form').attr('data-item', '');
        $("#category_form .method-select").val('POST');

    } else {
        $('#template_name').val('');
        $('#template_description').val('');
        $('#template-status-icon').prop('checked', true);
        $("#template_form").attr('action', baseURL + '/template');
        $('#template_form').attr('data-item', '');
        $("#template_form .method-select").val('POST');
    }
};

var divACedit = function(event) {
    var parent = $(this).parents('fieldset');
    toggleFormOrTable(parent, true);
};

// var divBDedit = function (event) {
//     var parent = $(this).parents('fieldset');
//     if (parent.attr('id') == "LeftPanel") {
//         toggleFormOrTable($('#RightPanel'), true);
//     } else {
//         toggleFormOrTable($('#LeftPanel'), true);
//     }
// };

var formInputChange = function(event) {
    console.log($(event.target).val());
};

var item_edit = function(element) {
    var parent = element.parents('.list-group-item');
    var id = parent.attr('id').split('_')[1];

    if (parent.find('.item-edit').attr('data-content') == 'training') {
        $('#status-form-group').css('display', 'block');
    } else {
        $('#status-form-group').css('display', 'none');
    }
    switch (element.attr('data-content')) {
        case 'template':
            toggleFormOrTable($('#LeftPanel'), true);
            clearFrom($('#LeftPanel'));
            $.get({
                url: baseURL + '/template/' + id,
                success: function(data, state) {
                    notification('We got group data successfully!', 1);
                    console.log(state);
                    $('#template_name').val(data.name);
                    $('#template_description').val(data.description);
                    $('#template-status-icon').prop("checked", data.status == 1).change();
                    $("#template_form").attr('action', baseURL + '/template/' + id);
                    $('#template_form .method-select').val('PUT');
                    $('#template_form').attr('data-item', parent.attr('id'));
                },
                error: function(err) {
                    notification("Sorry, You can't get template data!", 2);
                }
            });

            break;

        case 'training':
            toggleFormOrTable($('#RightPanel'), true);
            clearFrom($('#RightPanel'));
            $('#category_form').attr('data-item', parent.attr('id'));
            $.get({
                url: baseURL + '/training/' + id,
                success: function(data, state) {
                    notification('We got training data successfully!', 1);
                    console.log(state);
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#status_checkbox').css('display', 'block');
                    $('#cate-status-icon').prop("checked", data.status == 1).change();
                    $('#cate-status').val(data.status);

                    $('#category_form').attr('data-item', parent.attr('id'));

                    $("#category_form").attr('action', baseURL + '/training/' + id);

                    $('#category_form .method-select').val('PUT');
                },
                error: function(err) {
                    notification("Sorry, You can't get group data!", 2);
                }
            });
            break;

        case 'company':
            $('#category_form').attr('data-item', parent.attr('id'));
            $.get({
                url: baseURL + '/company/' + id,
                success: function(data, state) {
                    notification('We got company data successfully!', 1);
                    console.log(state);
                    toggleFormOrTable($('#RightPanel'), true);
                    clearFrom($('RightPanel'));
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#status_checkbox').css('display', 'none');

                    $("#category_form").attr('action', baseURL + '/company/' + id);

                    $('#category_form').attr('data-item', parent.attr('id'));

                    $('#category_form .method-select').val('PUT');

                },
                error: function(err) {
                    notification("Sorry, You can't get company data!", 2);
                }
            });
            break;

        case 'session':
            $('#category_form').attr('data-item', parent.attr('id'));
            $.get({
                url: baseURL + '/session/' + id,
                success: function(data, state) {
                    notification('We got session data successfully!', 1);
                    console.log(state);
                    toggleFormOrTable($('#RightPanel'), true);
                    clearFrom($('RightPanel'));

                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#status_checkbox').css('display', 'none');

                    $("#category_form").attr('action', baseURL + '/session/' + id);

                    $('#category_form').attr('data-item', parent.attr('id'));

                    $('#category_form .method-select').val('PUT');

                },
                error: function(err) {
                    notification("Sorry, You can't get position data!", 2);
                }
            });
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
        case 'template':
            $.ajax({
                type: "DELETE",
                url: baseURL + '/template/' + id,
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

        case 'training':
            $.ajax({
                type: "DELETE",
                url: baseURL + '/training/' + id,

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
        text: cate == 'student' ? ' This item and all his historic and reports will be permanently deleted' : '',
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


var detachLink = function(e) {
    var id, cate, parent = $(this).parents('.list-group-item');
    if ($(this).parents('fieldset').attr("id") == "LeftPanel") {
        cate = parent.attr('id').split("_")[0];
        id = parent.attr('id').split("_")[1];
    } else if ($(this).parents('fieldset').attr("id") == "RightPanel") {
        cate = parent.attr('data-src').split('_')[0];
        id = parent.attr('data-src').split('_')[1];
    }
    detachCall({
        id: id,
        data: cate,
        template: '',
    }, $(this));
};

var detachCall = function(connectiondata, element) {
    $.post({
        url: baseURL + '/templatelinktocate',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'data': JSON.stringify(connectiondata)
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
    if ($("#" + formname).attr('data-item')) {
        $("#" + $(this).parents('form').attr('data-item')).toggleClass('highlight', false);
        $("#" + $(this).parents('form').attr('data-item') + " .btn").each(function(i, em) {
            $(em).toggleClass('active', false);
        });
    }
    var validate = true;
    document.getElementById(formname).checkValidity();
    //TODO: We have to check this function again after a while;
    var regularExpression = new RegExp("^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[!%&@#$^*?_~+={}().,\/<>-]).*$");
    var password = $('#password').val();
    if (formname == 'template_form') {
        // validate = validate && $("#login")[0].checkValidity();
    } else if (formname == 'cate_form') {
        validate = validate && $("#description")[0].checkValidity();
        validate = validate && $("#name")[0].checkValidity();
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
            if (item.name == 'template-status-icon') {
                item.value = $('#template-status-icon').prop('checked') == true ? 1 : 0;
            } else if (item.name == 'cate-status-icon') {
                item.value = $('#cate-status-icon').prop("checked") == true ? 1 : 0;
            } else if (item.name == 'generatepassword') {
                item.value = $('#generatepassword').prop("checked") == true ? 1 : 0;
            }
            return item;
        });
        if (!serialval.filter(function(em, t, arr) {
                return em.name == 'template-status-icon' || em.name == 'cate-status-icon';
            }).length) {
            if (formname == 'template_form') {
                serialval.push({
                    name: "template-status-icon",
                    value: $('#template-status-icon').prop('checked') == true ? 1 : 0
                });
            } else if (formname == 'cate_form') {
                serialval.push({
                    name: "cate-status-icon",
                    value: $('#cate-status-icon').prop('checked') == true ? 1 : 0
                });
            }
        }
        if (!$("#" + formname).find('input[type=checkbox]').prop('checked')) {
            if (formname == 'template_form') {
                serialval.push({
                    name: "template-status-icon",
                    value: 0
                });
            } else if (formname == 'cate_form') {
                serialval.push({
                    name: "cate-status-icon",
                    value: 0
                });
            }
        }
        console.log(serialval);
        $.ajax({
            url: $('#' + formname).attr('action'),
            method: $('#' + formname).find('.method-select').val(),
            // contentType: 'application/json; charset=utf-8',
            data: serialval,
            success: function(data) {
                console.log(data);
                if ($("#" + formname).attr('data-item') == '' || $("#" + formname).attr('data-item') == null) {
                    var arr_url = $('#' + formname).attr('action').split('/');
                    var groupName = arr_url[arr_url.length - 1];
                    switch (groupName) {
                        case 'template':
                            notification('The template has been saved sucessfully!', 1);
                            $('#div_A .list-group').append(createTemplateData(data, 'template'));
                            break;
                        case 'training':
                            notification('The training has been saved sucessfully!', 1);
                            $('#training .list-group').append(createTrainingData(data, 'training'));
                            break;
                        case 'company':
                            notification('The company has been saved sucessfully!', 1);
                            $('#company .list-group').append(createCategoryData(data, 'company'));
                            break;
                        case 'session':
                            notification('The position has been saved sucessfully!', 1);
                            $('#positions .list-group').append(createCategoryData(data, 'session'));
                            break;

                        default:
                            break;
                    }
                } else {
                    var target = $("#" + formname).attr('data-item');
                    switch (target.split('_')[0]) {
                        case 'template':
                            notification('The template has been saved sucessfully!', 1);
                            updateTemplateData(data, target);
                            break;
                        case 'training':
                            notification('The training has been saved sucessfully!', 1);
                            updateTrainingData(data, target);
                            break;
                        case 'company':
                            notification('The company has been saved sucessfully!', 1);
                            updateCategoryData(data, target);
                            break;
                        case 'session':
                            notification('The position has been saved sucessfully!', 1);
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
        submit_data = null;
        toggleFormOrTable($(this).parents('fieldset'), true, false);
    }
    if ($("#" + formname).attr('data-item') != '' && $("#" + formname).attr('data-item') != null) {
        var targetName = $("#" + formname).attr('data-item').split('_')[0],
            sourceId;
        if (targetName == 'template') {
            sourceId = $("#template_form").attr('data-item');
        } else {
            sourceId = $("#cate_form").attr('data-item');
        }
    }
};

var createTemplateData = function(data, category) {

    var status_temp = data.status == 1 ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var templateItem = $('<a class="list-group-item list-group-item-action  p-1 border-0 template_' + data.id + '" id="template_' + data.id + '" data-date="' + data.creation_date + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.name + '">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '</div>' +
        '</a>');

    var editbtn = $('<button class="btn item-edit" data-content="' + category + '" data-item-id="' + data.id + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>');

    var deletebtn = $('<button class="btn item-delete" data-content="' + category + '" data-item-id="' + data.id + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>');

    var templatebtn = $('<button class="btn item-template" data-content="' + category + '"  data-template="#/template-generator/' + data.alpha_id + '">' +
        '<i class="px-2 fa fa-cube"></i>' +
        '</button>');

    var duplicatebtn = $('<button class="btn item-duplicate" data-content="' + category + '" data-item-id="' + data.id + '">' +
        '<i class="px-2 far fa-copy"></i>' +
        '</button>');

    editbtn.click(btnClick);
    editbtn.click(itemEdit);
    // editbtn.click(divACedit);

    deletebtn.click(btnClick);
    deletebtn.click(itemDelete);

    templatebtn.click(btnClick);
    templatebtn.click(itemTemplate);

    duplicatebtn.click(btnClick);
    duplicatebtn.click(itemDuplicate);

    templateItem.dblclick(itemDBClick);
    templateItem.find('.btn-group')
        .append(editbtn)
        .append(deletebtn)
        .append(templatebtn)
        .append(duplicatebtn);
    templateItem.click(leftItemClick);

    templateItem.find('.item-name').val(data.name);
    templateItem.bind('dragstart', dragStart);
    templateItem.bind('dragend', dragEnd);
    templateItem.attr('draggable', true);

    return templateItem;

};

var createTrainingData = function(data, category) {
    var status_temp = data.status == '1' ?
        '<i class="fa fa-circle m-2"  style="color:green;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="1">' :
        '<i class="fa fa-circle m-2"  style="color:red;"></i>' +
        '<input type="hidden" name="item-status" class="status-notification" value="0">';
    var groupItem = $('<a class="list-group-item list-group-item-action p-1 border-0 ' + category + '_' + data.id + '" id="' + category + '_' + data.id + '" data-date="' + data.creation_date + '">' +
        '<div class="float-left">' +
        status_temp +
        '<span class="item-name">' + data.name + '</span>' +
        '<input type="hidden" name="item-name" value="' + data.name + '">' +
        '</div>' +
        '<div class="btn-group float-right">' +
        '<button class="btn  toggle1-btn  item-show" data-content="training"' +
        'data-item-id="' + data.id + '">' +
        '<i class="px-2 fa fa-eye"></i>' +
        '</button>' +
        '<button class="btn item-edit toggle1-btn" data-content="training"' +
        'data-item-id="' + data.id + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>' +
        '<button class="btn item-delete toggle1-btn" data-content="training"' +
        'data-item-id="' + data.id + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
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

    return groupItem;
};

var createCategoryData = function(data, category) {
    var cateItem = $(' <a class="list-group-item list-group-item-action p-1 border-0 ' + category + '_' + data.id + '" id="' + category + '_' + data.id + '" data-date="' + data.creation_date + '">' +
        ' <div class="float-left">' +
        '<span class="item-name">' + data.name + '</span>' +
        '<input type="hidden" name="item-status" value="">' +
        '<input type="hidden" name="item-name" value="' + data.name + '">' +
        ' </div>' +
        '<div class="btn-group float-right">' +
        '<button class="btn  toggle1-btn  item-show" data-content="training"' +
        'data-item-id="' + data.id + '">' +
        '<i class="px-2 fa fa-eye"></i>' +
        '</button>' +
        '<button class="btn item-edit toggle1-btn" data-content="training"' +
        'data-item-id="' + data.id + '">' +
        '<i class="px-2 fa fa-edit"></i>' +
        '</button>' +
        '<button class="btn item-delete toggle1-btn" data-content="training"' +
        'data-item-id="' + data.id + '">' +
        '<i class="px-2 fa fa-trash-alt"></i>' +
        '</button>' +
        '</div>' +
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

    return cateItem;
};

var updateTemplateData = function(data, target) {
    $('.' + target).each(function(i, im) {
        $(im).find('.item-name').html(data.name);
        $(im).find('.status-notification').val(data.status);
        $(im).find('.status-notification').prev().css('color', data.status == '1' ? 'green' : 'red');
        $(im).find('input[name="item-name"]').val(data.name);
    });

};

var updateTrainingData = function(data, target) {
    $('.' + target).each(function(i, im) {
        $(im).find('.item-name').html(data.name);
        $(im).find('input[name="item-name"]').html(data.name);
        $(im).find('.status-notification').val(data.status);
        $(im).find('.status-notification').prev().css('color', data.status == '1' ? 'green' : 'red');
    });
};

var updateCategoryData = function(data, target) {
    $('.' + target).each(function(i, im) {
        $(im).find('.item-name').html(data.name);
        $(im).find('input[name="item-name"]').val(data.name);
    });
};

var cancelBtn = function(event) {
    var parent = $(this).parents('fieldset');
    if ($(this).parents('form').attr('data-item')) {
        $("#" + $(this).parents('form').attr('data-item')).toggleClass('highlight');
        $("#" + $(this).parents('form').attr('data-item') + " .btn").each(function(i, em) {
            $(em).toggleClass('active', false);
        });
    }
    toggleFormOrTable(parent, null, false);
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

    if ($(event.target).is('input.search-filter')) {
        str = event.target.value;
        console.log(str);
    }

    if (parent.attr('id') == 'cate-toolkit') {
        var selector = parent.prev().find('.ui-state-active a').attr('href').split('#')[1];
        items = $("#" + selector).find('.list-group .list-group-item');
    } else if (parent.attr('id') == 'template-toolkit') {
        items = $('#div_A .list-group').find('.list-group-item');
    }
    // console.log(items);

    items.map(function(i, e) {
        var item_name = $(e).find('input[name="item-name"]').val();
        var item_status = $(e).find('input[name="item-status"]').val();

        if (str == null || str == '' || item_name.toLowerCase().indexOf(str.replace(/\s+/g, '')) >= 0) {

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

    if (parent.attr('id') == 'cate-toolkit') {
        var selector = parent.prev().find('.ui-state-active a').attr('href').split('#')[1];
        $itemgroup = $("#" + selector).find('.list-group');
        // items = $("#" + selector).find('.list-group .list-group-item');
    } else {
        // items = parent.next('.list-group').find('.list-group-item');
        $itemgroup = $('#div_A .list-group');
    }
    $items = $itemgroup.children('.list-group-item');
    switch ($(this).parents('.toolkit').attr('id')) {
        case 'template-toolkit':
            if ($(this).is('.filter-name-btn')) {
                templateNameSort = !templateNameSort;
                $items.sort(function(a, b) {
                    var an = $(a).find('span.item-name').html().split('&nbsp;').join('').toLowerCase(),
                        bn = $(b).find('span.item-name').html().split('&nbsp;').join('').toLowerCase();

                    if (templateNameSort) {
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
                templateDateSort = !templateDateSort;
                $items.sort(function(a, b) {
                    var an = new Date(a.dataset.date),
                        bn = new Date(b.dataset.date);
                    if (templateDateSort) {
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

var cateStateIcon = function(e) {
    var el = $(this);
    if (el.is(':checked')) {
        $("#cate-status").val(1);
    } else {
        $("#cate-status").val(0);
    }
};

var tabClick = function(event) {
    switch ($(this).attr('id')) {
        case 'training-tab':
            $('#RightPanel .toolkit:first>div').css('background-color', 'var(--training-c)');
            activedTab = '#training';
            $('#toolkit-tab-name').html('TRAINS');
            $('#cate-toolkit .status-switch').toggle(true);
            $('#status_checkbox').toggle(true);
            break;
        case 'company-tab':
            $('#RightPanel .toolkit:first>div').css('background-color', 'var(--company-c)');
            activedTab = '#company';
            $('#toolkit-tab-name').html('COMPANIES');
            $('#cate-toolkit .status-switch').toggle(false);
            $('#status_checkbox').toggle(false);
            break;
        case 'session-tab':
            $('#RightPanel .toolkit:first>div').css('background-color', 'var(--session-c)');
            activedTab = '#session';
            $('#toolkit-tab-name').html('SESSIONS');
            $('#cate-toolkit .status-switch').toggle(false);
            $('#status_checkbox').toggle(false);
            break;

        default:
            break;
    }
    $('#RightPanel').find('.list-group-item').each(toggleBtnChange);
    toggleFormOrTable($('#RightPanel'), null, false);
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
//////////////////////////////////
///////////////////////////////////
//////////////////////////////////

var dragitem = null;

function dragStart(event) {
    dragitem = Array();
    $(this).parents(".list-group").children('.active.list-group-item').each(function(i, dragelem) {
        dragitem.push($(dragelem).attr("id"));
    });
    if (dragitem.indexOf($(this).attr('id')) == -1) {
        dragitem = [$(this).attr('id')];
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
        requestData = {
            id: cate_id,
            data: cate,
            template: dragitem[0].split('_')[1]
        }

        $.post({
            url: baseURL + '/templatelinktocate',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                'data': JSON.stringify(requestData)
            }
        }).then(function(data) {

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
////

$(document).ready(function() {

    $('#RightPanel').tabs();
    $('#LeftPanel .toolkit>div').css('background-color', 'var(--template-c)');
    $('#RightPanel .toolkit:first>div').css('background-color', 'var(--training-c)');

    $("#RightPanel .list-group-item").each(function(i, elem) {
        $(elem).attr('draggable', false);
        $(elem).on('drop', dropEnd);

        elem.addEventListener('dragover', dragOver);
        elem.addEventListener('dragleave', dragLeave);
    });

    $("#LeftPanel .list-group-item").each(function(i, elem) {
        elem.addEventListener('dragstart', dragStart);
        elem.addEventListener('dragend', dragEnd);
        $(elem).attr('draggable', true);
    });
});
$('input[name=status], input.search-filter, button.filter-company-btn, button.filter-function-btn').change(searchfilter);
$('input.search-filter').on('keydown change keyup', searchfilter);
$("button.filter-company-btn, button.filter-function-btn").on('drop', searchfilter);

$("#div_A .item-show, #div_C .item-show").click(divACshow);

$(".list-group-item").dblclick(itemDBClick);
$("#LeftPanel .list-group-item").click(leftItemClick);

$(".list-group-item button.btn").click(btnClick);

$('.item-delete').click(itemDelete);
$('.item-duplicate').click(itemDuplicate);

$('.item-edit').click(itemEdit);
$('#div_A .fa.fa-edit, #div_C .fa.fa-edit').click(divACedit);
// $('#div_B .fa.fa-edit, #div_D .fa.fa-edit').click(divBDedit);
$('#div_A .item-template').click(itemTemplate);

$('.toolkit-add-item').click(toolkitAddItem);
$('form').submit(submitFunction);
$('form input, form select').change(formInputChange);
$('#template-status-icon, #cate-status-icon').change(formStatusChange);
$('.submit-btn').click(submitBtn);
$('.cancel-btn').click(cancelBtn);

$(".toolkit-show-filter").click(filterToggleShow);
$('.filter-name-btn').click(sortfilter);
$("#cate-status-icon").change(cateStateIcon);

$('.toggle2-btn').click(toggle2Btn);
// $('#table-user').on('DOMSubtreeModified', countDisplayUser);
$('.nav-link').click(tabClick);

$('.handler_horizontal').dblclick(handlerDBClick);

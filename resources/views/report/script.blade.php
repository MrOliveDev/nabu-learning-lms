<script>
    var evalUniqueId = 0;

    $(document).ready(function() {
        $(".content-side.content-side-full").find(".active").toggleClass("active", false);
        $("#rapports").toggleClass("active", true);

        $("#ReportPanel").tabs({
            active: 0
        });

        $("#sendcheck_all").on('click', function() {
            if ($(this)[0].checked)
                $(".sendcheck").prop('checked', true);
            else
                $(".sendcheck").prop('checked', false);
        })

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
        jQuery.resizable('horizSplit2', "h");
        jQuery.resizable('horizSplit3', "h");
        jQuery.resizable('horizSplit4', "h");

        $("#modelDragItems").tabs({
            active: 0
        });

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

        var table = $('#historic-table').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "orderCellsTop": true,
            "pageLength": 50,
            "ajax": {
                "url": "{{ url('getReportList') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    "data": "checked",
                    "orderable": false
                },
                {
                    "data": "session"
                },
                {
                    "data": "student"
                },
                {
                    "data": "filename"
                },
                {
                    "data": "type"
                },
                {
                    "data": "created_time"
                },
                {
                    "data": "actions",
                    "orderable": false
                }
            ],
            pageLength: 5,
            lengthMenu: false,
            searching: false,
            autoWidth: false,
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-6'i><'col-sm-6'p>>",
            "order": [
                [1, "desc"]
            ]
        });

        $("#model-trumb-pane").on("click", function() {
            $(".model-drag-item").each(function() {
                if ($(this).hasClass("active")) {
                    if ($(this).html() == "#Header") {
                        $.ajax({
                            url: 'getBlockHTML',
                            method: 'post',
                            data: {
                                name: "header"
                            },
                            success: function(res) {
                                if (res.success && res.html) {
                                    $('#model-trumb-pane').trumbowyg('execCmd', {
                                        cmd: 'insertHTML',
                                        param: res.html,
                                        forceCss: false,
                                    });
                                    $('#rep_header').css('float', 'right');
                                    if($('.trumbowyg-editor').find('img').length != 0){
                                        console.log('image exist');
                                        $('#rep_header').css('width', '60%');
                                    }
                                } else
                                    notification(res.message, 2);
                            },
                            error: function(err) {
                                notification("Sorry, You have an error!", 2);
                            }
                        });
                    } else if ($(this).html() == "#Training_Synthetic_details_bloc") {
                        $.ajax({
                            url: 'getBlockHTML',
                            method: 'post',
                            data: {
                                name: "training_synthetic"
                            },
                            success: function(res) {
                                if (res.success && res.html) {
                                    $('#model-trumb-pane').trumbowyg('execCmd', {
                                        cmd: 'insertHTML',
                                        param: res.html,
                                        forceCss: false,
                                    });
                                } else
                                    notification(res.message, 2);
                            },
                            error: function(err) {
                                notification("Sorry, You have an error!", 2);
                            }
                        });
                    } else if ($(this).html() == "#Training_lessons_list_bloc") {
                        $.ajax({
                            url: 'getBlockHTML',
                            method: 'post',
                            data: {
                                name: "training_lessons"
                            },
                            success: function(res) {
                                if (res.success && res.html) {
                                    $('#model-trumb-pane').trumbowyg('execCmd', {
                                        cmd: 'insertHTML',
                                        param: res.html,
                                        forceCss: false,
                                    });
                                } else
                                    notification(res.message, 2);
                            },
                            error: function(err) {
                                notification("Sorry, You have an error!", 2);
                            }
                        });
                    } else if ($(this).html() == "#Training_Complete_details_bloc") {
                        $.ajax({
                            url: 'getBlockHTML',
                            method: 'post',
                            data: {
                                name: "training_complete_details"
                            },
                            success: function(res) {
                                if (res.success && res.html) {
                                    $('#model-trumb-pane').trumbowyg('execCmd', {
                                        cmd: 'insertHTML',
                                        param: res.html,
                                        forceCss: false,
                                    });
                                } else
                                    notification(res.message, 2);
                            },
                            error: function(err) {
                                notification("Sorry, You have an error!", 2);
                            }
                        });
                    } else if ($(this).html() == "#Training_Evaluation_details_bloc") {
                        $.ajax({
                            url: 'getBlockHTML',
                            method: 'post',
                            data: {
                                name: "training_evaluation_details"
                            },
                            success: function(res) {
                                if (res.success && res.html) {
                                    $('#model-trumb-pane').trumbowyg('execCmd', {
                                        cmd: 'insertHTML',
                                        param: res.html,
                                        forceCss: false,
                                    });
                                } else
                                    notification(res.message, 2);
                            },
                            error: function(err) {
                                notification("Sorry, You have an error!", 2);
                            }
                        });
                    } else if ($(this).html() == "#Training_Complete_Evaluation_details_bloc") {
                        $.ajax({
                            url: 'getBlockHTML',
                            method: 'post',
                            data: {
                                name: "training_complete_evaluation"
                            },
                            success: function(res) {
                                if (res.success && res.html) {
                                    $('#model-trumb-pane').trumbowyg('execCmd', {
                                        cmd: 'insertHTML',
                                        param: res.html,
                                        forceCss: false,
                                    });
                                } else
                                    notification(res.message, 2);
                            },
                            error: function(err) {
                                notification("Sorry, You have an error!", 2);
                            }
                        });
                    } else if ($(this).html() == "#Signature_bloc") {
                        $.ajax({
                            url: 'getBlockHTML',
                            method: 'post',
                            data: {
                                name: "signature_bloc"
                            },
                            success: function(res) {
                                if (res.success && res.html) {
                                    $('#model-trumb-pane').trumbowyg('execCmd', {
                                        cmd: 'insertHTML',
                                        param: res.html,
                                        forceCss: false,
                                    });
                                } else
                                    notification(res.message, 2);
                            },
                            error: function(err) {
                                notification("Sorry, You have an error!", 2);
                            }
                        });
                    } else if ($(this).html() == "#Footer") {
                        $.ajax({
                            url: 'getBlockHTML',
                            method: 'post',
                            data: {
                                name: "footer"
                            },
                            success: function(res) {
                                if (res.success && res.html) {
                                    $('#model-trumb-pane').trumbowyg('execCmd', {
                                        cmd: 'insertHTML',
                                        param: res.html,
                                        forceCss: false,
                                    });
                                } else
                                    notification(res.message, 2);
                            },
                            error: function(err) {
                                notification("Sorry, You have an error!", 2);
                            }
                        });
                    } else if ($(this).is('img')) {
                        $('#rep_header').css('width', '60%');
                        if ($(this).attr('src') != '') {
                            $('#model-trumb-pane').trumbowyg('execCmd', {
                                cmd: 'insertImage',
                                param: $(this).attr('src'),
                                prefix: 'report_image',
                                forceCss: false,
                                skipTrumbowyg: true,
                                class: 'report_image',
                            });
                        }
                        $('.report_image').css('display', 'inline-block');
                        // $('.trumbowyg-editor').find('img').css('width', '30%');
                        $('.trumbowyg-editor').find('p').css('display', 'inline-block');
                    } else {
                        $('#model-trumb-pane').trumbowyg('execCmd', {
                            cmd: 'insertText',
                            param: $(this).html(),
                            forceCss: false,
                        });
                    }

                    $(this).removeClass("active");
                }
            })
        });

        $('#model-trumb-pane').trumbowyg().on('tbwchange', () => {
            trumbowygChanged++;
        });

        $("#type-filter").on('keyup', function() {
            $(".doc-type-item").each(function() {
                let html = $(this).children('span').html();
                if (html && html.includes($("#type-filter").val())) {
                    $(this).css("display", "flex");
                } else
                    $(this).css("display", "none");
            });
        });

        $(".session-filter").on('keyup', function() {
            $(".session-item").each(function() {
                let sessionName = $(this).children()[0].innerHTML;
                let sessionDate = $(this).children()[1].innerHTML;
                if ((sessionName && sessionName.includes($(".session-filter").val())) || (
                        sessionDate && sessionDate.includes($(".session-filter").val()))) {
                    $(this).css("display", "table-row");
                } else
                    $(this).css("display", "none");
            });
        });

        $(".learner-filter").on('keyup', function() {
            $(".learner-item").each(function() {
                let html = $(this).children()[0].innerHTML;
                if (html && html.includes($(".learner-filter").val())) {
                    $(this).css("display", "table-row");
                } else
                    $(this).css("display", "none");
            });
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

    function toggleActive(e) {
        $(".model-drag-item").each(function() {
            if (e != this)
                $(this).removeClass('active');
            else
                $(this).toggleClass('active');
        });
    }

    var trumbowygChanged = -1;
    var modelSelectedId = -1;

    function alertChanged() {
        return new Promise((resolve, reject) => {
            swal.fire({
                    title: "Warning",
                    html: "You have unsaved model contents. <br> Continue?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: `Yes`,
                    cancelButtonText: `No`,
                })
                .then((result) => {
                    if (result.value)
                        resolve(true);
                    else
                        resolve(false);
                });
        })
    }

    async function editTemplate(id) {
        if (trumbowygChanged >= 1) {
            if (await alertChanged() == false)
                return;
        }

        $.ajax({
            url: 'getTemplateData',
            method: 'post',
            data: {
                id: id
            },
            success: function(res) {
                if (res.success) {
                    trumbowygChanged = -1;
                    modelSelectedId = id;
                    $('#model-name').val(res.name);
                    $('#model-trumb-pane').trumbowyg('html', res.data);
                } else
                    notification(res.message, 2);
            },
            error: function(err) {
                notification("Sorry, You have an error!", 2);
            }
        });
    }

    function saveTemplate() {
        if ($("#model-name").val() == '') {
            swal.fire({
                title: "Warning",
                text: "Please input the model name.",
                icon: "info",
                confirmButtonText: `OK`
            });
            return;
        }

        $.ajax({
            url: 'saveTemplateData',
            method: 'post',
            data: {
                id: modelSelectedId,
                data: $('#model-trumb-pane').trumbowyg('html'),
                name: $("#model-name").val()
            },
            success: function(res) {
                if (res.success) {
                    if (modelSelectedId == -1) {
                        $("#model-item-list").append('<div class="model-item" id="model-item-' + res.id +
                            '">' +
                            '<div>' +
                            '<i class="fa fa-circle mr-4" style="color: green;"></i>' +
                            '<span id="model-title-' + res.id + '">' + $("#model-name").val() +
                            '</span>' +
                            '</div>' +
                            '<div>' +
                            '<i class="fa fa-edit mr-4 actionBtn" onclick="editTemplate(' + res.id +
                            ')"></i>' +
                            '<i class="fa fa-trash mr-3 dangerBtn" onclick="delTemplate(' + res.id +
                            ')"></i>' +
                            '</div>' +
                            '</div>');
                        $("#doc-type-list").append('<div class="doc-type-item" onclick="selectModel(' + res
                            .id + ')" id="doc-type-item-' + res.id + '">' +
                            '<span id="doc-type-item-title-' + res.id + '">' + $("#model-name").val() +
                            '</span>' +
                            '</div>');
                    } else {
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

    async function addTemplate() {
        if (trumbowygChanged >= 1) {
            if (await alertChanged() == false)
                return;
        }

        modelSelectedId = -1;
        trumbowygChanged = -1;
        $('#model-name').val('');
        $('#model-trumb-pane').trumbowyg('html', '');
    }

    function delTemplate(id) {
        swal.fire({
                title: "Warning",
                html: "Are you sure delete this template?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: `Yes`,
                cancelButtonText: `No`,
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'delTemplate',
                        method: 'post',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            if (res.success) {
                                notification('Successfully deleted.', 1);
                                $('#model-item-' + id).remove();
                                $('#doc-type-item-' + id).remove();
                                if (modelSelectedId == id) {
                                    modelSelectedId = -1;
                                    trumbowygChanged = -1;
                                    $("#model-name").val('');
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

    async function cancelTemplate() {
        if (trumbowygChanged >= 1) {
            if (await alertChanged() == false)
                return;
        }

        modelSelectedId = -1;
        trumbowygChanged = -1;
        $('#model-name').val('');
        $('#model-trumb-pane').trumbowyg('html', '');
    }

    var curModel = 0,
        curSession = 0,
        curStudent = 0;

    function selectModel(templateId) {
        curModel = templateId;
        $(".doc-type-item").each(function() {
            $(this).removeClass("active");
        });
        $("#doc-type-item-" + templateId).addClass("active");
        if (curModel && curSession && curStudent) {
            overviewReport(curStudent);
        }
    }

    function selectSession(sessionId) {
        curSession = sessionId;
        $("#overviewPane").html('');
        $(".session-item").each(function() {
            $(this).removeClass("active");
        });
        $("#session-" + sessionId).addClass("active");
        $("#studentsList").html('');
        swal.fire({
            title: "Please wait...",
            showConfirmButton: false
        });
        swal.showLoading();
        $.ajax({
            url: 'getStudentsList',
            method: 'post',
            data: {
                sessionId: sessionId
            },
            success: function(res) {
                swal.close();
                if (res.success && res.students) {
                    res.students.forEach(student => {
                        $("#studentsList").append('<tr class="learner-item">' +
                            '<td class="font-w600 learnerName">' + student.first_name + ' ' +
                            student.last_name + '</td>' +
                            '<td class="font-w600 text-center learnerAction" onclick="downloadReport(' +
                            student.id + ')"><i class="fa fa-download"></i></td>' +
                            '<td class="font-w600 text-center learnerAction" onclick="overviewReport(' +
                            student.id + ')">Overview <i class="fa fa-eye"></i></td>' +
                            '</tr>');
                    });
                    $("#studentsPane").css("height", "150px");
                } else
                    notification(res.message, 2);
            },
            error: function(err) {
                swal.close();
                notification("Sorry, You have an error!", 2);
            }
        });
    }

    function getReportData() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'getReportData',
                method: 'post',
                data: {
                    sessionId: curSession,
                    studentId: curStudent
                },
                success: function(res) {
                    if (res.success) {
                        resolve(res.data);
                    } else {
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

    function getTemplateData() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'getTemplateData',
                method: 'post',
                data: {
                    id: curModel
                },
                success: function(res) {
                    if (res.success) {
                        resolve(res.data);
                    } else {
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

    function getStudentsList() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: 'getStudentsList',
                method: 'post',
                data: {
                    sessionId: curSession
                },
                success: function(res) {
                    if (res.success && res.students) {
                        resolve(res.students);
                    } else
                        resolve(null);
                },
                error: function(err) {
                    resolve(null);
                }
            });
        })
    }

    async function overviewReport(studentId) {
        curStudent = studentId;
        if (!curModel) {
            swal.fire({
                title: "Warning",
                text: "Please select document type.",
                icon: "info",
                confirmButtonText: `OK`
            });
            return;
        }
        if (!curSession) {
            swal.fire({
                title: "Warning",
                text: "Please select session.",
                icon: "info",
                confirmButtonText: `OK`
            });
            return;
        }

        swal.fire({
            title: "Please wait...",
            showConfirmButton: false
        });
        swal.showLoading();

        var info = await getReportData();
        if (info == null) {
            swal.fire({
                title: "Warning",
                text: "Error while getting report data.",
                icon: "error",
                confirmButtonText: `OK`
            });
            return;
        }

        var template = await getTemplateData();
        if (template == null) {
            swal.fire({
                title: "Warning",
                text: "Error while getting template data.",
                icon: "error",
                confirmButtonText: `OK`
            });
            return;
        }

        buildTemplateInfo(info, template);

        swal.close();
    }

    function buildTemplateInfo(info, template) {
        // Change variables to real values
        if (template.includes('#last_name')) {
            if (info && info.student && info.student.last_name)
                template = template.split('#last_name').join(info.student.last_name);
            else
                template = template.split('#last_name').join('');
        }
        if (template.includes('#first_name')) {
            if (info && info.student && info.student.first_name)
                template = template.split('#first_name').join(info.student.first_name);
            else
                template = template.split('#first_name').join('');
        }
        if (template.includes('#student_company')) {
            if (info && info.student && info.student.company_name)
                template = template.split('#student_company').join(info.student.company_name);
            else
                template = template.split('#student_company').join('');
        }
        if (template.includes('#training_name')) {
            if (info && info.trainings && info.trainings[0] && info.trainings[0].training && info.trainings[0].training
                .name)
                template = template.split('#training_name').join(info.trainings[0].training.name);
            else
                template = template.split('#training_name').join('');
        }
        if (template.includes('#total_time_spent_on_training')) {
            if (info && info.trainings && info.trainings[0] && info.trainings[0].totalTime)
                template = template.split('#total_time_spent_on_training').join(info.trainings[0].totalTime);
            else
                template = template.split('#total_time_spent_on_training').join('00:00:00');
        }
        if (template.includes('#session_begin_Date')) {
            if (info && info.trainings && info.trainings[0] && info.trainings[0].training && info.trainings[0].training
                .date_begin)
                template = template.split('#session_begin_Date').join(info.trainings[0].training.date_begin);
            else
                template = template.split('#session_begin_Date').join('');
        }
        if (template.includes('#session_end_Date')) {
            if (info && info.trainings && info.trainings[0] && info.trainings[0].training && info.trainings[0].training
                .date_end)
                template = template.split('#session_end_Date').join(info.trainings[0].training.date_end);
            else
                template = template.split('#session_end_Date').join('');
        }
        if (template.includes('#session_teacher_complete_name')) {
            if (info && info.teachers && info.teachers[0])
                template = template.split('#session_teacher_complete_name').join(info.teachers[0]);
            else
                template = template.split('#session_teacher_complete_name').join('');
        }
        if (template.includes('#evaluation_pc_result')) {
            if (info && info.are_eval_there && info.are_eval_there.evals && info.are_eval_there.evals.length > 0) {
                let result = '';
                if (info.are_eval_there.evals.length > 1) {
                    info.are_eval_there.evals.forEach((eval, i) => {
                        result += ((i == 0 ? '' : ', ') + eval.note + '% (' + eval.module + ')');
                    });
                } else
                    result = info.are_eval_there.evals[0].note + '%';
                template = template.split('#evaluation_pc_result').join(result);
            } else
                template = template.split('#evaluation_pc_result').join('');
        }
        if (template.includes('#evaluation_num_result')) {
            if (info && info.are_eval_there && info.are_eval_there.evalnums && info.are_eval_there.evalnums.length >
                0) {
                let result = '';
                if (info.are_eval_there.evalnums.length > 1) {
                    info.are_eval_there.evalnums.forEach((eval, i) => {
                        result += ((i == 0 ? '' : ', ') + eval.num + ' (' + eval.module + ')');
                    });
                } else
                    result = info.are_eval_there.evalnums[0].num;
                template = template.split('#evaluation_num_result').join(result);
            } else
                template = template.split('#evaluation_num_result').join('');
        }

        $("#overviewPane").html(template);

        // training_lessons bloc
        if ($("#overviewPane #training_lessons").length > 0) {
            $("#overviewPane #training_lessons .removable").remove();
            if (info && info.trainings && info.trainings.length > 0) {
                for (let i = 0; i < info.trainings.length; i++) {
                    if (info.trainings[i].training) {
                        let html = $("#overviewPane #training_lessons").clone();
                        html.attr('id', "training_lessons_" + i);
                        html.insertAfter("#overviewPane #training_lessons");

                        $(`#overviewPane #training_lessons_${i} #training_title`).html(
                            `<b>${info.trainings[i].training.name}</b>`);
                        if (info.background)
                            $(`#overviewPane #training_lessons_${i} #training_title`).css("background", info
                                .background);

                        if (info.trainings[i].lessons && info.trainings[i].lessons.length > 0) {
                            info.trainings[i].lessons.forEach(lessonData => {
                                if (lessonData && lessonData.lesson && lessonData.lesson.name)
                                    $(`#overviewPane #training_lessons_${i}`).append(
                                        `<tr><td style="color:#000000; border:1px solid #000000;">${lessonData.lesson.name}</td></tr>`
                                    );
                                else {
                                    console.log('Empty lesson name:', lessonData);
                                    $(`#overviewPane #training_lessons_${i}`).append(
                                        `<tr><td style="color:#000000; border:1px solid #000000;"></td></tr>`
                                    );
                                }
                            })
                        }
                    }
                }
            }
            $("#overviewPane #training_lessons").remove();
        }

        // training_synthetic bloc
        if ($("#overviewPane #training_synthetic").length > 0) {
            if (info && info.trainings && info.trainings.length > 0) {
                let i = 0;
                info.trainings.forEach(trainingData => {
                    if (trainingData && trainingData.lessons && trainingData.lessons.length > 0) {
                        trainingData.lessons.forEach(lessonData => {
                            if (lessonData && lessonData.lesson) {
                                let html = $("#overviewPane #training_synthetic").clone();
                                html.attr('id', "training_synthetic_" + i);
                                html.insertAfter("#overviewPane #training_synthetic" + (i == 0 ? "" :
                                    "_" + (i - 1)));

                                $(`#overviewPane #training_synthetic_${i} #lesson_title`).html(
                                    `<b>${lessonData.lesson.name}</b>`);
                                if (info.background)
                                    $(`#overviewPane #training_synthetic_${i} #lesson_title`).css(
                                        "background", info.background);

                                if (lessonData.optim && lessonData.lesson.threshold_score <= lessonData
                                    .optim.progress_screen_optim)
                                    $(`#overviewPane #training_synthetic_${i} #lesson_status`).html(
                                        `Completed`);
                                else
                                    $(`#overviewPane #training_synthetic_${i} #lesson_status`).html(
                                        `Not Completed`);
                                if (lessonData.optim)
                                    $(`#overviewPane #training_synthetic_${i} #lesson_progress`).html(
                                        `${lessonData.optim.progress_screen_optim}%`);
                                else
                                    $(`#overviewPane #training_synthetic_${i} #lesson_progress`).html(
                                        `0%`);
                                $(`#overviewPane #training_synthetic_${i} #screens_count`).html(
                                    `${lessonData.screensCount}`);
                                $(`#overviewPane #training_synthetic_${i} #chapters_count`).html(
                                    `${lessonData.chaptersCount}`);
                                $(`#overviewPane #training_synthetic_${i} #visited_count`).html(
                                    `${lessonData.visitedScreens}`);
                                $(`#overviewPane #training_synthetic_${i} #time_spent`).html(
                                    `${lessonData.time_module}`);
                                if (lessonData.last_eval) {
                                    $(`#overviewPane #training_synthetic_${i} #eval_score`).html(
                                        `${lessonData.last_eval.note}% (${lessonData.last_eval.status})`
                                    );
                                    if (lessonData.last_eval.status == 'failed')
                                        $(`#overviewPane #training_synthetic_${i} #eval_score`).css(
                                            "background", "red");
                                    else
                                        $(`#overviewPane #training_synthetic_${i} #eval_score`).css(
                                            "background", "green");
                                } else if (lessonData.first_eval) {
                                    $(`#overviewPane #training_synthetic_${i} #eval_score`).html(
                                        `${lessonData.first_eval.note}% (${lessonData.first_eval.status})`
                                    );
                                    if (lessonData.first_eval.status == 'failed')
                                        $(`#overviewPane #training_synthetic_${i} #eval_score`).css(
                                            "background", "red");
                                    else
                                        $(`#overviewPane #training_synthetic_${i} #eval_score`).css(
                                            "background", "green");
                                } else
                                    $(`#overviewPane #training_synthetic_${i} #synthetic_eval_score`)
                                    .remove();

                                // if(i != 0) html.prepend('<br>');
                                i++;
                            } else {
                                console.log('Empty lesson data:', lessonData);
                            }
                        })
                    }
                })
            }

            $("#overviewPane #training_synthetic").remove();
        }

        // training_complete_details bloc
        if ($("#overviewPane #training_complete").length > 0) {
            $("#overviewPane #training_complete_screens .removable").remove();
            if (info && info.trainings && info.trainings.length > 0) {
                let i = 0;
                let lastHtmlId = '#overviewPane #training_complete';
                info.trainings.forEach(trainingData => {
                    if (trainingData && trainingData.lessons && trainingData.lessons.length > 0) {
                        trainingData.lessons.forEach(lessonData => {
                            if (lessonData && lessonData.lesson) {
                                let html = $("#overviewPane #training_complete").clone();
                                html.attr('id', "training_complete_" + i);
                                html.insertAfter(lastHtmlId);
                                lastHtmlId = "#overviewPane #training_complete_" + i;

                                $(`#overviewPane #training_complete_${i} #lesson_title`).html(
                                    `<b>${lessonData.lesson.name}</b>`);
                                if (info.background)
                                    $(`#overviewPane #training_complete_${i} #lesson_title`).css(
                                        "background", info.background);

                                if (lessonData.optim && lessonData.lesson.threshold_score <= lessonData
                                    .optim.progress_screen_optim)
                                    $(`#overviewPane #training_complete_${i} #lesson_status`).html(
                                        `Completed`);
                                else
                                    $(`#overviewPane #training_complete_${i} #lesson_status`).html(
                                        `Not Completed`);
                                if (lessonData.optim)
                                    $(`#overviewPane #training_complete_${i} #lesson_progress`).html(
                                        `${lessonData.optim.progress_screen_optim}%`);
                                else
                                    $(`#overviewPane #training_complete_${i} #lesson_progress`).html(
                                        `0%`);
                                $(`#overviewPane #training_complete_${i} #screens_count`).html(
                                    `${lessonData.screensCount}`);
                                $(`#overviewPane #training_complete_${i} #chapters_count`).html(
                                    `${lessonData.chaptersCount}`);
                                $(`#overviewPane #training_complete_${i} #visited_count`).html(
                                    `${lessonData.visitedScreens}`);
                                $(`#overviewPane #training_complete_${i} #time_spent`).html(
                                    `${lessonData.time_module}`);
                                if (lessonData.last_eval) {
                                    $(`#overviewPane #training_complete_${i} #eval_score`).html(
                                        `${lessonData.last_eval.note}% (${lessonData.last_eval.status})`
                                    );
                                    if (lessonData.last_eval.status == 'failed')
                                        $(`#overviewPane #training_complete_${i} #eval_score`).css(
                                            "background", "red");
                                    else
                                        $(`#overviewPane #training_complete_${i} #eval_score`).css(
                                            "background", "green");
                                } else if (lessonData.first_eval) {
                                    $(`#overviewPane #training_complete_${i} #eval_score`).html(
                                        `${lessonData.first_eval.note}% (${lessonData.first_eval.status})`
                                    );
                                    if (lessonData.first_eval.status == 'failed')
                                        $(`#overviewPane #training_complete_${i} #eval_score`).css(
                                            "background", "red");
                                    else
                                        $(`#overviewPane #training_complete_${i} #eval_score`).css(
                                            "background", "green");
                                } else
                                    $(`#overviewPane #training_complete_${i} #complete_eval_score`)
                                    .remove();

                                if (lessonData.lessonCourse && lessonData.lessonCourse
                                    .module_structure) {
                                    let structure = JSON.parse(lessonData.lessonCourse
                                        .module_structure);
                                    let progress_details = (lessonData.optim && lessonData.optim
                                        .progress_details_screen_optim) ? JSON.parse(lessonData
                                        .optim.progress_details_screen_optim) : {};
                                    let screen_titles = (lessonData.lessonCourse.screens_titles ? JSON
                                        .parse(lessonData.lessonCourse.screens_titles) : []);
                                    if (structure && structure.length > 0) {
                                        // html.append('<br>');
                                        let screensHtml = $("#overviewPane #training_complete_screens")
                                            .clone();
                                        screensHtml.attr('id', `training_complete_screens_${i}`);
                                        screensHtml.insertAfter(lastHtmlId);
                                        lastHtmlId = "#overviewPane #training_complete_screens_" + i;
                                        structure.forEach(screen => {
                                            if (screen) {
                                                if (screen.type == "item" || screen.nav ==
                                                    "true") {
                                                    let screentitle = '',
                                                        screenstatus = '',
                                                        viewcount = 0,
                                                        viewtime = '00:00:00';
                                                    if (progress_details[screen.id]) {
                                                        screenstatus = progress_details[screen
                                                            .id]['status'];
                                                        viewcount = progress_details[screen.id][
                                                            'visu'
                                                        ];
                                                        viewtime = progress_details[screen.id][
                                                            'time'
                                                        ];
                                                    }
                                                    let found = screen_titles.find(screenitem =>
                                                        screenitem && screenitem.id ==
                                                        screen.id);
                                                    if (found)
                                                        screentitle = found.title;

                                                    $(`#overviewPane #training_complete_screens_${i}`)
                                                        .append("<tr>" +
                                                            `<td style="width:50%;color:#000000; border:1px solid #000000;">${screentitle}</td>` +
                                                            `<td style="width:15%;color:#000000; border:1px solid #000000;">${screenstatus}</td>` +
                                                            `<td style="width:20%;color:#000000; border:1px solid #000000;">${viewtime}</td>` +
                                                            `<td style="width:15%;color:#000000; border:1px solid #000000;">${viewcount}</td>` +
                                                            "</tr>");
                                                }
                                            }
                                        })
                                    } else
                                        console.log('Empty lessonCourse data:', lessonData
                                            .lessonCourse);
                                }

                                // if(i != 0) html.prepend('<br>');
                                i++;
                            } else {
                                console.log('Empty lesson data:', lessonData);
                            }
                        })
                    }
                })
            }

            $("#overviewPane #training_complete").remove();
            $("#overviewPane #training_complete_screens").remove();
        }

        // training_evaluation_details
        if ($("#overviewPane #training_evaluation").length > 0) {
            $("#overviewPane #complete_evaldetails .removable").remove();
            $("#overviewPane #evaluation_details .removable").remove();
            $("#overviewPane #evaluation_details_removable").remove();
            if (info && info.trainings && info.trainings.length > 0) {
                let i = 0;
                let lastHtmlId = '#overviewPane #training_evaluation';
                info.trainings.forEach(trainingData => {
                    if (trainingData && trainingData.lessons && trainingData.lessons.length > 0) {
                        trainingData.lessons.forEach(lessonData => {
                            if (lessonData && lessonData.lesson) {
                                let html = $("#overviewPane #training_evaluation").clone();
                                html.attr('id', "training_evaluation_" + i);
                                html.insertAfter(lastHtmlId);
                                lastHtmlId = "#overviewPane #training_evaluation_" + i;

                                $(`#overviewPane #training_evaluation_${i} #lesson_title`).html(
                                    `<b>${lessonData.lesson.name}</b>`);
                                if (info.background)
                                    $(`#overviewPane #training_evaluation_${i} #lesson_title`).css(
                                        "background", info.background);

                                if (lessonData.optim && lessonData.lesson.threshold_score <= lessonData
                                    .optim.progress_screen_optim)
                                    $(`#overviewPane #training_evaluation_${i} #lesson_status`).html(
                                        `Completed`);
                                else
                                    $(`#overviewPane #training_evaluation_${i} #lesson_status`).html(
                                        `Not Completed`);
                                if (lessonData.optim)
                                    $(`#overviewPane #training_evaluation_${i} #lesson_progress`).html(
                                        `${lessonData.optim.progress_screen_optim}%`);
                                else
                                    $(`#overviewPane #training_evaluation_${i} #lesson_progress`).html(
                                        `0%`);
                                $(`#overviewPane #training_evaluation_${i} #screens_count`).html(
                                    `${lessonData.screensCount}`);
                                $(`#overviewPane #training_evaluation_${i} #chapters_count`).html(
                                    `${lessonData.chaptersCount}`);
                                $(`#overviewPane #training_evaluation_${i} #visited_count`).html(
                                    `${lessonData.visitedScreens}`);
                                $(`#overviewPane #training_evaluation_${i} #time_spent`).html(
                                    `${lessonData.time_module}`);
                                if (lessonData.last_eval) {
                                    $(`#overviewPane #training_evaluation_${i} #eval_score`).html(
                                        `${lessonData.last_eval.note}% (${lessonData.last_eval.status})`
                                    );
                                    if (lessonData.last_eval.status == 'failed')
                                        $(`#overviewPane #training_evaluation_${i} #eval_score`).css(
                                            "background", "red");
                                    else
                                        $(`#overviewPane #training_evaluation_${i} #eval_score`).css(
                                            "background", "green");
                                } else if (lessonData.first_eval) {
                                    $(`#overviewPane #training_evaluation_${i} #eval_score`).html(
                                        `${lessonData.first_eval.note}% (${lessonData.first_eval.status})`
                                    );
                                    if (lessonData.first_eval.status == 'failed')
                                        $(`#overviewPane #training_evaluation_${i} #eval_score`).css(
                                            "background", "red");
                                    else
                                        $(`#overviewPane #training_evaluation_${i} #eval_score`).css(
                                            "background", "green");
                                } else
                                    $(`#overviewPane #training_evaluation_${i} #complete_eval_score`)
                                    .remove();

                                if (lessonData.eval_questions && lessonData.eval_questions.length > 0) {
                                    // html.append('<br>');
                                    lessonData.eval_questions.forEach((questionData) => {
                                        let questionHtml = $(
                                            "#overviewPane #evaluation_details").clone();
                                        questionHtml.attr('id', "evaluation_details_" + evalUniqueId);
                                        questionHtml.insertAfter(lastHtmlId);
                                        lastHtmlId = "#overviewPane #evaluation_details_" + evalUniqueId;

                                        $(`#overviewPane #evaluation_details_${evalUniqueId} #question_title`)
                                            .html(`<b>${questionData.title}</b>`);
                                        if (questionData.options && questionData.options
                                            .length > 0) {
                                            questionData.options.forEach((option, k) => {
                                                $(`#overviewPane #evaluation_details_${evalUniqueId}`)
                                                    .append("<tr>" +
                                                        `<td style="width: 30%; color:#000000; border:1px solid #000000;" >Option ${k + 1}</td>` +
                                                        `<td style="width: 50%; color:#000000; border:1px solid #000000;" >${option.intitule}</td>` +
                                                        `<td style="width: 10%;` + (
                                                            option.attendu == "1" ?
                                                            ` background: lightgreen;` :
                                                            ``) +
                                                        ` border:1px solid #000000;" ></td>` +
                                                        `<td style="width: 10%;` + (
                                                            option.recu == "1" ? (option
                                                                .ok ?
                                                                ` background: lightgreen;` :
                                                                ` background: red;`) :
                                                            ``) +
                                                        ` border:1px solid #000000;" ></td>` +
                                                        "</tr>");
                                            });
                                            $(`#overviewPane #evaluation_details_${evalUniqueId}`).append(
                                                "<tr>" +
                                                `<td style="width: 30%; color:#000000; border:1px solid #000000; background: ` +
                                                (questionData.result ? 'lightgreen' :
                                                    'red') + `;">Result</td>` +
                                                `<td colspan="3" style="width: 70%; color:#000000; border:1px solid #000000; background: ` +
                                                (questionData.result ? 'lightgreen' :
                                                    'red') + `;">` + (questionData.result ?
                                                    'Correct Answer' : 'Wrong Answer') +
                                                `</td>` +
                                                "</tr>");
                                        }
                                        // if(j != 0) questionHtml.prepend('<br>');
                                        evalUniqueId ++;
                                    })
                                }

                                // if(i != 0) html.prepend('<br>');
                                i++;
                            } else {
                                console.log('Empty lesson data:', lessonData);
                            }
                        })
                    }
                })
            }

            $("#overviewPane #training_evaluation").remove();
            $("#overviewPane #evaluation_details").remove();
        }

        // training_complete_evaluation bloc
        if ($("#overviewPane #complete_evaluation").length > 0) {
            $("#overviewPane #complete_evalscreens .removable").remove();
            $("#overviewPane #complete_evaldetails .removable").remove();
            $("#overviewPane #complete_evaldetails_removable").remove();
            if (info && info.trainings && info.trainings.length > 0) {
                let i = 0;
                let lastHtmlId = '#overviewPane #complete_evaluation';
                info.trainings.forEach(trainingData => {
                    if (trainingData && trainingData.lessons && trainingData.lessons.length > 0) {
                        trainingData.lessons.forEach(lessonData => {
                            if (lessonData && lessonData.lesson) {
                                let html = $("#overviewPane #complete_evaluation").clone();
                                html.attr('id', "complete_evaluation_" + i);
                                html.insertAfter(lastHtmlId);
                                lastHtmlId = "#overviewPane #complete_evaluation_" + i;

                                $(`#overviewPane #complete_evaluation_${i} #lesson_title`).html(
                                    `<b>${lessonData.lesson.name}</b>`);
                                if (info.background)
                                    $(`#overviewPane #complete_evaluation_${i} #lesson_title`).css(
                                        "background", info.background);

                                if (lessonData.optim && lessonData.lesson.threshold_score <= lessonData
                                    .optim.progress_screen_optim)
                                    $(`#overviewPane #complete_evaluation_${i} #lesson_status`).html(
                                        `Completed`);
                                else
                                    $(`#overviewPane #complete_evaluation_${i} #lesson_status`).html(
                                        `Not Completed`);
                                if (lessonData.optim)
                                    $(`#overviewPane #complete_evaluation_${i} #lesson_progress`).html(
                                        `${lessonData.optim.progress_screen_optim}%`);
                                else
                                    $(`#overviewPane #complete_evaluation_${i} #lesson_progress`).html(
                                        `0%`);
                                $(`#overviewPane #complete_evaluation_${i} #screens_count`).html(
                                    `${lessonData.screensCount}`);
                                $(`#overviewPane #complete_evaluation_${i} #chapters_count`).html(
                                    `${lessonData.chaptersCount}`);
                                $(`#overviewPane #complete_evaluation_${i} #visited_count`).html(
                                    `${lessonData.visitedScreens}`);
                                $(`#overviewPane #complete_evaluation_${i} #time_spent`).html(
                                    `${lessonData.time_module}`);
                                if (lessonData.last_eval) {
                                    $(`#overviewPane #complete_evaluation_${i} #eval_score`).html(
                                        `${lessonData.last_eval.note}% (${lessonData.last_eval.status})`
                                    );
                                    if (lessonData.last_eval.status == 'failed')
                                        $(`#overviewPane #complete_evaluation_${i} #eval_score`).css(
                                            "background", "red");
                                    else
                                        $(`#overviewPane #complete_evaluation_${i} #eval_score`).css(
                                            "background", "green");
                                } else if (lessonData.first_eval) {
                                    $(`#overviewPane #complete_evaluation_${i} #eval_score`).html(
                                        `${lessonData.first_eval.note}% (${lessonData.first_eval.status})`
                                    );
                                    if (lessonData.first_eval.status == 'failed')
                                        $(`#overviewPane #complete_evaluation_${i} #eval_score`).css(
                                            "background", "red");
                                    else
                                        $(`#overviewPane #complete_evaluation_${i} #eval_score`).css(
                                            "background", "green");
                                } else
                                    $(`#overviewPane #complete_evaluation_${i} #complete_eval_score`)
                                    .remove();

                                if (lessonData.lessonCourse && lessonData.lessonCourse
                                    .module_structure) {
                                    let structure = JSON.parse(lessonData.lessonCourse
                                        .module_structure);
                                    let progress_details = (lessonData.optim && lessonData.optim
                                        .progress_details_screen_optim) ? JSON.parse(lessonData
                                        .optim.progress_details_screen_optim) : {};
                                    let screen_titles = (lessonData.lessonCourse.screens_titles ? JSON
                                        .parse(lessonData.lessonCourse.screens_titles) : []);
                                    if (structure && structure.length > 0) {
                                        // html.append('<br>');
                                        let screensHtml = $("#overviewPane #complete_evalscreens")
                                            .clone();
                                        screensHtml.attr('id', `complete_evalscreens_${i}`);
                                        screensHtml.insertAfter(lastHtmlId);
                                        lastHtmlId = "#overviewPane #complete_evalscreens_" + i;
                                        structure.forEach(screen => {
                                            if (screen) {
                                                if (screen.type == "item" || screen.nav ==
                                                    "true") {
                                                    let screentitle = '',
                                                        screenstatus = '',
                                                        viewcount = 0,
                                                        viewtime = '00:00:00';
                                                    if (progress_details[screen.id]) {
                                                        screenstatus = progress_details[screen
                                                            .id]['status'];
                                                        viewcount = progress_details[screen.id][
                                                            'visu'
                                                        ];
                                                        viewtime = progress_details[screen.id][
                                                            'time'
                                                        ];
                                                    }
                                                    let found = screen_titles.find(screenitem =>
                                                        screenitem && screenitem.id ==
                                                        screen.id);
                                                    if (found)
                                                        screentitle = found.title;

                                                    $(`#overviewPane #complete_evalscreens_${i}`)
                                                        .append("<tr>" +
                                                            `<td style="width:50%;color:#000000; border:1px solid #000000;">${screentitle}</td>` +
                                                            `<td style="width:15%;color:#000000; border:1px solid #000000;">${screenstatus}</td>` +
                                                            `<td style="width:20%;color:#000000; border:1px solid #000000;">${viewtime}</td>` +
                                                            `<td style="width:15%;color:#000000; border:1px solid #000000;">${viewcount}</td>` +
                                                            "</tr>");
                                                }
                                            }
                                        })
                                    } else
                                        console.log('Empty lessonCourse data:', lessonData
                                            .lessonCourse);
                                }

                                if (lessonData.eval_questions && lessonData.eval_questions.length > 0) {
                                    // $(lastHtmlId).append('<br>');
                                    lessonData.eval_questions.forEach((questionData) => {
                                        let questionHtml = $(
                                            "#overviewPane #complete_evaldetails").clone();
                                        questionHtml.attr('id', "complete_evaldetails_" + evalUniqueId);
                                        questionHtml.insertAfter(lastHtmlId);
                                        lastHtmlId = "#overviewPane #complete_evaldetails_" + evalUniqueId;

                                        $(`#overviewPane #complete_evaldetails_${evalUniqueId} #question_title`)
                                            .html(`<b>${questionData.title}</b>`);
                                        if (questionData.options && questionData.options
                                            .length > 0) {
                                            questionData.options.forEach((option, k) => {
                                                $(`#overviewPane #complete_evaldetails_${evalUniqueId}`)
                                                    .append("<tr>" +
                                                        `<td style="width: 30%; color:#000000; border:1px solid #000000;" >Option ${k + 1}</td>` +
                                                        `<td style="width: 50%; color:#000000; border:1px solid #000000;" >${option.intitule}</td>` +
                                                        `<td style="width: 10%;` + (
                                                            option.attendu == "1" ?
                                                            ` background: lightgreen;` :
                                                            ``) +
                                                        ` border:1px solid #000000;" ></td>` +
                                                        `<td style="width: 10%;` + (
                                                            option.recu == "1" ? (option
                                                                .ok ?
                                                                ` background: lightgreen;` :
                                                                ` background: red;`) :
                                                            ``) +
                                                        ` border:1px solid #000000;" ></td>` +
                                                        "</tr>");
                                            });
                                            $(`#overviewPane #complete_evaldetails_${evalUniqueId}`)
                                                .append("<tr>" +
                                                    `<td style="width: 30%; color:#000000; border:1px solid #000000; background: ` +
                                                    (questionData.result ? 'lightgreen' :
                                                        'red') + `;">Result</td>` +
                                                    `<td colspan="3" style="width: 70%; color:#000000; border:1px solid #000000; background: ` +
                                                    (questionData.result ? 'lightgreen' :
                                                        'red') + `;">` + (questionData.result ?
                                                        'Correct Answer' : 'Wrong Answer') +
                                                    `</td>` +
                                                    "</tr>");
                                        }
                                        // if(j != 0) questionHtml.prepend('<br>');
                                        evalUniqueId ++;
                                    })
                                }

                                // if(i != 0) html.prepend('<br>');
                                i++;
                            } else {
                                console.log('Empty lesson data:', lessonData);
                            }
                        })
                    }
                })
            }

            $("#overviewPane #complete_evaluation").remove();
            $("#overviewPane #complete_evalscreens").remove();
            $("#overviewPane #complete_evaldetails").remove();
        }
    }

    const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

    async function download(url, name) {
        const a = document.createElement('a');
        a.download = name;
        a.href = url;
        a.style.display = 'none';
        document.body.append(a);
        a.click();

        // Chrome requires the timeout
        await delay(100);
        a.remove();
    };

    async function downloadReport(studentId) {
        curStudent = studentId;
        if (!curModel) {
            swal.fire({
                title: "Warning",
                text: "Please select document type.",
                icon: "info",
                confirmButtonText: `OK`
            });
            return;
        }
        if (!curSession) {
            swal.fire({
                title: "Warning",
                text: "Please select session.",
                icon: "info",
                confirmButtonText: `OK`
            });
            return;
        }

        swal.fire({
            title: "Please wait...",
            showConfirmButton: false
        });
        swal.showLoading();

        var info = await getReportData();
        if (info == null) {
            swal.fire({
                title: "Warning",
                text: "Error while getting report data.",
                icon: "error",
                confirmButtonText: `OK`
            });
            return;
        }

        var template = await getTemplateData();
        if (template == null) {
            swal.fire({
                title: "Warning",
                text: "Error while getting template data.",
                icon: "error",
                confirmButtonText: `OK`
            });
            return;
        }

        $("#overviewPane").css("display", "none");
        buildTemplateInfo(info, template);

        let header = '',
            footer = '';
        if ($("#overviewPane #rep_header")[0])
            header = $("#overviewPane #rep_header")[0].outerHTML;
        $("#overviewPane #rep_header").remove();
        if ($("#overviewPane #rep_footer")[0])
            footer = $("#overviewPane #rep_footer")[0].outerHTML;
        $("#overviewPane #rep_footer").remove();

        $.ajax({
            url: 'downloadReportPDF',
            method: 'post',
            data: {
                sessionId: curSession,
                studentId: curStudent,
                header: header,
                footer: footer,
                content: $("#overviewPane").html(), 
                model: $("#doc-type-list").find(".active span").text()
            },
            success: function(res) {
                swal.close();
                if (res.success && res.filename) {
                    // download("{{ url('pdf') }}" + "/" + res.filename, res.filename);
                    let link = "{{ url('pdf') }}" + "/" + res.filename;
                    window.open(link, '_blank');
                    $('#historic-table').DataTable().ajax.reload();
                } else
                    notification(res.message, 2);
            },
            error: function(err) {
                swal.close();
                notification("Sorry, You have an error!", 2);
            }
        });

        $("#overviewPane").html('');
        $("#overviewPane").css("display", "block");
    }

    async function downloadAllReports() {
        if (!curModel) {
            swal.fire({
                title: "Warning",
                text: "Please select document type.",
                icon: "info",
                confirmButtonText: `OK`
            });
            return;
        }
        if (!curSession) {
            swal.fire({
                title: "Warning",
                text: "Please select session.",
                icon: "info",
                confirmButtonText: `OK`
            });
            return;
        }

        swal.fire({
            title: "Please wait...",
            showConfirmButton: false
        });
        swal.showLoading();

        var students = await getStudentsList();
        var postdata = [];

        var template = await getTemplateData();
        if (template == null) {
            swal.fire({
                title: "Warning",
                text: "Error while getting template data.",
                icon: "error",
                confirmButtonText: `OK`
            });
            return;
        }

        var header = '',
            footer = '';
        $("#overviewPane").css("display", "none");

        if (students && students.length > 0) {
            for (let i = 0; i < students.length; i++) {
                curStudent = students[i].id;
                var info = await getReportData();
                if (info == null) {
                    swal.fire({
                        title: "Warning",
                        text: "Error while getting report data.",
                        icon: "error",
                        confirmButtonText: `OK`
                    });
                    break;
                }

                buildTemplateInfo(info, template);
                if ($("#overviewPane #rep_header")[0])
                    header = $("#overviewPane #rep_header")[0].outerHTML;
                $("#overviewPane #rep_header").remove();
                if ($("#overviewPane #rep_footer")[0])
                    footer = $("#overviewPane #rep_footer")[0].outerHTML;
                $("#overviewPane #rep_footer").remove();
                postdata.push({
                    studentId: curStudent,
                    header: header,
                    footer: footer,
                    content: $("#overviewPane").html(),
                    model: $("#doc-type-list").find(".active span").text()
                });
                $("#overviewPane").html('');
            }

            $.ajax({
                url: 'downloadReportZip',
                method: 'post',
                data: {
                    sessionId: curSession,
                    data: postdata
                },
                success: function(res) {
                    swal.close();
                    if (res.success && res.filename) {
                        download("{{ url('zip') }}" + "/" + res.filename, res.filename);
                        $('#historic-table').DataTable().ajax.reload();
                    } else
                        notification(res.message, 2);
                },
                error: function(err) {
                    swal.close();
                    notification("Sorry, You have an error!", 2);
                }
            });
        } else
            swal.fire({
                title: "Warning",
                text: "No students at the moment.",
                icon: "info",
                confirmButtonText: `OK`
            });

        $("#overviewPane").css("display", "block");
    }

    function delReport(id) {
        swal.fire({
                title: "Warning",
                html: "Are you sure delete this report?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: `Yes`,
                cancelButtonText: `No`,
            })
            .then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'delReport',
                        method: 'post',
                        data: {
                            id: id
                        },
                        success: function(res) {
                            if (res.success) {
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

    function delReports() {
        if ($(".sendcheck:checked").length == 0) {
            swal.fire({
                title: "Warning",
                html: "Please select report",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: `Yes`,
                cancelButtonText: `No`,
            })
        } else {
            swal.fire({
                    title: "Warning",
                    html: "Are you sure delete these reports?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: `Yes`,
                    cancelButtonText: `No`,
                })
                .then((result) => {
                    var ids = [];
                    if (result.value) {
                        $(".sendcheck:checked").map(function(index, item) {
                            ids.push($(item).attr("id").split("_")[1])
                        })

                        $.ajax({
                            url: 'delReports',
                            method: 'post',
                            data: {
                                ids: ids
                            },
                            success: function(res) {
                                if (res.success) {
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
        }
</script>

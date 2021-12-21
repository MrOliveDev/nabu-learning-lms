var h =
    window.innerHeight ||
    window.document.documentElement.clientHeight ||
    window.document.body.clientHeight;

var clearRightField = function () {
    $("#div_C .push").find(".accordion").detach();
};

var evalUniqueId = 0;

var playBtn = function (event) {
    event.preventDefault();
    var session_id = $(this).parents(".accordion").attr("data-session");
    var course_id = $(this).parents(".accordion").attr("data-course");
    if($(this).css("opacity") == "0.2") {
        swal.fire({
            title: "Warning",
            text: "The session is ended, access to lesson is not allowed",
            icon: "info",
            confirmButtonText: `OK`,
        });
    }else if ($(this).css("opacity") == "0.3") {
        swal.fire({
            title: "Warning",
            text: "You must finish the previous lesson first",
            icon: "info",
            confirmButtonText: `OK`,
        });
    } else {
        window.open(
            baseURL +
                "/player_editor" +
                "/#/open/fr/fabrique/" +
                session_id +
                "/0/" +
                $(this).attr("data-fabrica") +
                "/"+course_id+"/dae8efee8afc1994204d76ee963bcfb1","_self"
        );
    }
    // if ($(this).css("opacity") != "0.3") {
    //     window.open(
    //         baseURL +
    //             "/player_editor" +
    //             "/#/open/fr/fabrique/" +
    //             session_id +
    //             "/0/" +
    //             $(this).attr("data-fabrica") +
    //             "/"+course_id+"/dae8efee8afc1994204d76ee963bcfb1","_self"
    //     );
    // } else {
    //     // alert("You have to cross the prev lesson first.");
    //     swal.fire({
    //         title: "Warning",
    //         text: "You must finish the previous lesson first",
    //         icon: "info",
    //         confirmButtonText: `OK`,
    //     });
    //     // notification("You have to cross the prev lesson first.", 2);
    // }
};

var showContent = function(e) {
            $('html, body').animate({
                scrollTop: $(e).parents(".accordion").offset().top
            }, 500);
    }

var createLessonItem = function (data) {
    if (data["lesson"] != null) {
        if (
            data["lesson"].status == 5 &&
            $("#accordion" + data["lesson"]["id"]).length == 0
        ) {
            var eval;
            var progress;
            if(data["eval"] == ""){
                eval = '<i class="fa fa-check-circle"></i>' + 
                        '<span class="pl-1">-</span>'
            } else if(data["lesson"]['threshold_score'] > data["eval"]) {
                eval = '<i class="fa fa-check-circle text-danger"></i>' +
                        '<span class="pl-1 text-danger">' +
                        data["eval"] +
                        "%" +
                        "</span>"
            } else {
                eval = '<i class="fa fa-check-circle text-success"></i>' +
                        '<span class="pl-1 text-success">' +
                         data["eval"] +
                        "%" +
                        "</span>"
            }

            if(data["progress"] == 0){
                progress = '<i class="fa fa-chart-line align-middle">' +
                            "</i>" +
                            '<span class=" align-middle pl-1">' +
                            data["progress"] +
                            "%" +
                            "</span>"
            } else if (data["progress"] < 100) {
                progress = '<i class="fa fa-chart-line align-middle text-warning">' +
                            "</i>" +
                            '<span class=" align-middle pl-1 text-warning">' +
                            data["progress"] +
                            "%" +
                            "</span>"
            } else if (data["progress"] == 100) {
                progress = '<i class="fa fa-chart-line align-middle text-success">' +
                            "</i>" +
                            '<span class=" align-middle pl-1 text-success">' +
                            data["progress"] +
                            "%" +
                            "</span>"
            }
            var component = $(
                '<div class="accordion" role="tablist" aria-multiselectable="true" id="accordion' +
                    data["lesson"]["id"] +
                    '" data-progress="' +
                    data["progress"] +
                    '" data-eval="' +
                    data["eval"] +
                    '" data-course="' +
                    data["course_id"] +
                    '">' +
                    '<div class="block block-rounded mb-1 bg-transparent shadow-none">' +
                    '<div class="block-header block-header-default border-transparent border-0 bg-transparent p-0" role="tab" id="accordion_h1">' +
                    '<div class=" col-md-3 text-white align-self-stretch d-flex text-center  flex-md-row" style="border-right:3px solid white;">' +
                    '<span class="col-md-6 align-middle py-2">' +
                    progress +
                    "</span>" +
                    '<span class="col-md-6 py-2">' +
                    eval +
                    "</span>" +
                    "</div>" +
                    '<div class="  col-md-9 border-transparent border-left-1 align-self-stretch d-flex flex-row justify-content-between">' +
                    '<div class="float-left py-2">' +
                    '<span class="item-name align-middle">' +
                    data["lesson"]["name"] +
                    "</span>" +
                    "</div>" +
                    '<div class="btn-group float-right d-flex">' +
                    '<button class="btn  item-show" data-content="teacher">' +
                    '<a class="font-w600 collapsed" data-toggle="collapse" data-parent="#accordion' +
                    data["lesson"]["id"] +
                    '" href="#lesson_' +
                    data["lesson"]["id"] +
                    '" aria-expanded="false" aria-controls="accordion_q1" onclick="showContent(this)">' +
                    '<i class="fas fa-exclamation-circle m-0 p-2"></i>' +
                    "</a>" +
                    "</button>" +
                    '<button class="btn  item-play" data-content="teacher" data-fabrica="' +
                    data["lesson"].idFabrica +
                    '">' +
                    '<i class="fa fa-play m-0 p-2 align-middle"></i>' +
                    "</button>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    '<div id="lesson_' +
                    data["lesson"]["id"] +
                    '" class="collapse" role="tabpanel" aria-labelledby="accordion_h1" data-parent="#accordion' +
                    data["lesson"]["id"] +
                    '">' +
                    '<div class="block-content bg-white mt-2  pb-3 text-black">' +
                    (data["lesson"]["duration"]
                        ? "<p><b>Duration: </b> " + data["lesson"]["duration"]
                        : "") +
                    "</p>" +
                    
                    (data["lesson"]["publicAudio"]
                        ? "<p><b>Public Target: </b>" + data["lesson"]["publicAudio"]
                        : "" ) +
                    "</p>" +
                    
                    (data["lesson"]["description"]
                        ? "<p><b>Description: </b>" + data["lesson"]["description"]
                        : "") +
                    "</p>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
            );
            component.find(".item-play").click(playBtn);
            //             if(!data["lesson"]['duration']&&!data["lesson"]['publicAudio']&&!data["lesson"]['description']){
            //                 component.find('.item-show').detach();
            //             }
            return component;
        }
    } else return null;
    // if (data['description'] == "" || data['description' == null]) {
    //     component.find('.item-show').detach();
    // }
};

$(document).ready(function () {
    Dashmix.helpers(['notify']);
    $('#content').find('.lessons_group').map(function(i, item) {
        if ($(item).find('.push').attr("data-type") != 2) {
            $(item)
             .find(".accordion")
                .map(function (i, item) {
                   if ($(item).prev(".accordion").length != 0) {
                     if (
                        $(item)
                        .prev(".accordion")
                        .attr("data-progress") != "100" && $(item).find(".item-play").css("opacity") != 0.2
                        ) {
                        $(item)
                            .find(".item-play")
                            .css("opacity", "30%");
                    }
                }
            });
        }
    })
    // $(window).scroll(function () {
    //     var height = $(window).scrollTop();
    //     if (height > 50) {
    //         console.log("height > 50 ==== ", "true");
    //     } else {
    //         console.log("height > 50 ==== ", "false");
    //     }
    // });
    // console.log('scrolltop', $(window).scrollTop())

    // var divHight = 20 + parseInt($(".content-header").height());
    // $("#div_A").css("height", h - divHight + "px");
    // $("#div_A").css("height", h - divHight + "px");
    $(".item-play").click(playBtn);
    $(".training-show").click(function (event) {
        var parent = $(this).parents(".card");
        parent.parents("#content").find(".card").removeClass("active");
        parent.addClass("active");
       $(this).parents("#content").find(".push").css('display', 'none');
       $(this).parents(".row").find("#div_C .push").css('display', 'block');
    });
    var isBreakPoint = function (bp) {
        var bps = [768, 1024],
            w = $(window).width(),
            min,
            max;
        for (var i = 0, l = bps.length; i < l; i++) {
            if (bps[i] === bp) {
                min = bps[i - 1] || 0;
                max = bps[i];
                break;
            }
        }
        return w > min && w <= max;
    };

    // Usage
    if (isBreakPoint(768)) {
        $(".training-show").css("display", "none");
        $(".items-push").click(function (event) {
            var parent = $(this).parents(".card");
            parent.parents("#content").find(".card").removeClass("active");
            parent.addClass("active");
            $(this).parents("#content").find(".push").css('display', 'none');
            $(this).parents(".row").find("#div_C .push").css('display', 'block');

            $(".row").animate(
                {
                    scrollTop: $(".accordion").offset().top,
                },
                500
            );
            var target = $(this).parents(".row").find("#div_C" );

            if( target.length ) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 500);
            }
                    
        });
    }
    $("main .card:first").addClass("active");
    $("main .card:first .training-show").click();
});

async function downloadReport(studentId, curModel, curSession) {
    curStudent = studentId;

    swal.fire({
        title: "Please wait...",
        showConfirmButton: false
    });
    swal.showLoading();

    var info = await getReportData(curSession);
    if (info == null) {
        swal.fire({
            title: "Warning",
            text: "Error while getting report data.",
            icon: "error",
            confirmButtonText: `OK`
        });
        return;
    }

    var template = await getTemplateData(curModel);
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
            modelId: curModel
        },
        success: function(res) {
            swal.close();
            if (res.success && res.filename) {
                // download("{{ url('pdf') }}" + "/" + res.filename, res.filename);
                let link = "pdf" + "/" + res.filename;
                window.open(link, '_blank');
                window.location.reload();

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

function getReportData(curSession) {
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

function getTemplateData(curModel) {
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
var h =
    window.innerHeight ||
    window.document.documentElement.clientHeight ||
    window.document.body.clientHeight;

var clearRightField = function () {
    $("#div_C .push").find(".accordion").detach();
};

var playBtn = function (event) {
    event.preventDefault();
    var session_id = $(this).parents(".accordion").attr("data-session");
    var course_id = $(this).parents(".accordion").attr("data-course");
    if ($(this).css("opacity") != "0.3") {
        window.open(
            baseURL +
                "/player_editor" +
                "/#/open/fr/fabrique/" +
                session_id +
                "/0/" +
                $(this).attr("data-fabrica") +
                "/"+course_id+"/dae8efee8afc1994204d76ee963bcfb1"
        );
    } else {
        // alert("You have to cross the prev lesson first.");
        swal.fire({
            title: "Warning",
            text: "You must finish the previous lesson first",
            icon: "info",
            confirmButtonText: `OK`,
        });
        // notification("You have to cross the prev lesson first.", 2);
    }
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
    $('#content').find('.lessons_group').map(function(i, item) {
        if ($(item).find('.push').attr("data-type") != 2) {
            $(item)
             .find(".accordion")
                .map(function (i, item) {
                   if ($(item).prev(".accordion").length != 0) {
                     if (
                        $(item)
                        .prev(".accordion")
                        .attr("data-progress") != "100"
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

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
    if ($(this).css("opacity") != "0.3") {
        window.open(
            baseURL +
                "/player_editor" +
                "/#/open/fr/fabrique/" +
                session_id +
                "/0/" +
                $(this).attr("data-fabrica") +
                "/0/dae8efee8afc1994204d76ee963bcfb1"
        );
    } else {
        alert("You have to cross the prev lesson first.");
    }
};

function showContent(e) {
    $("#div_A").animate(
        {
            scrollTop: $(e).parents(".accordion").offset().top,
        },
        500
    );
    console.log("id", $(e).parents(".accordion").attr("id"));
}

var createLessonItem = function (data) {
    if (data["lesson"] != null) {
        if (
            data["lesson"].status == 5 &&
            $("#accordion" + data["lesson"]["id"]).length == 0
        ) {
            var component = $(
                '<div class="accordion" role="tablist" aria-multiselectable="true" id="accordion' +
                    data["lesson"]["id"] +
                    '" data-progress="' +
                    data["progress"] +
                    '" data-eval="' +
                    data["eval"] +
                    '">' +
                    '<div class="block block-rounded mb-1 bg-transparent shadow-none">' +
                    '<div class="block-header block-header-default border-transparent border-0 bg-transparent p-0" role="tab" id="accordion_h1">' +
                    '<div class=" col-md-3 text-white align-self-stretch d-flex text-center  flex-md-row" style="border-right:2px solid #9a6cb0;">' +
                    '<span class="col-md-6 align-middle py-2">' +
                    '<i class="fa fa-chart-line align-middle">' +
                    "</i>" +
                    '<span class=" align-middle pl-1">' +
                    data["progress"] +
                    "%" +
                    "</span>" +
                    "</span>" +
                    '<span class="col-md-6 py-2">' +
                    '<i class="fa fa-check-circle">' +
                    "</i>" +
                    '<span class=" align-middle  pl-1">' +
                    data["eval"] +
                    "%" +
                    "</span>" +
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
                    "<p><b>Duration: </b> " +
                    (data["lesson"]["duration"]
                        ? data["lesson"]["duration"]
                        : "") +
                    "</p>" +
                    "<p><b>Public Target: </b>" +
                    data["lesson"]["publicAudio"] +
                    "</p>" +
                    "<p><b>Description: </b>" +
                    data["lesson"]["description"] +
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
    // $(window).scroll(function () {
    //     var height = $(window).scrollTop();
    //     if (height > 50) {
    //         console.log("height > 50 ==== ", "true");
    //     } else {
    //         console.log("height > 50 ==== ", "false");
    //     }
    // });
    // console.log('scrolltop', $(window).scrollTop())

    var divHight = 20 + parseInt($(".content-header").height());
    $("#div_A").css("height", h - divHight + "px");
    $("#div_A").css("height", h - divHight + "px");

    $(".font-w600").click(function (event) {
        console.log("here");
    });
    $(".training-collapse").click(function (event) {
        var parent = $(this).parents(".card");
        parent.find(".card-img-top").toggle("slow");
        parent.find(".card-body").toggle("slow");
    });
    $(".item-play").click(playBtn);
    $(".training-show").click(function (event) {
        var parent = $(this).parents(".card");
        parent.parents("fieldset").find("card").removeClass("active");
        parent.addClass("active");
        $.post({
            url:
                baseURL +
                "/getlessonsforstudent/" +
                parent.attr("id").split("_")[1] +
                "/" +
                parent.parents(".training-item").attr("data-session"),
        })
            .then(function (data) {
                $("#div_A .content-training").find(".accordion").detach();
                $("#div_A .content-training").attr(
                    "data-type",
                    parent.parents(".training-item").attr("data-type")
                );
                $("#div_C .push").attr(
                    "data-type",
                    parent.parents(".training-item").attr("data-type")
                );
                clearRightField();
                data.map(function (dataItem, i) {
                    var new_comp = createLessonItem(dataItem);
                    var new_comp1 = createLessonItem(dataItem);
                    new_comp1.attr(
                        "data-session",
                        parent.parents(".training-item").attr("data-session")
                    );
                    new_comp.attr(
                        "data-session",
                        parent.parents(".training-item").attr("data-session")
                    );
                    $("#div_C .push").append(new_comp);
                    $(event.target)
                        .parents(".training-item")
                        .find(".content-training")
                        .append(new_comp1);
                });
                if ($("#div_C .push").attr("data-type") != 2) {
                    $("#div_C")
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
            .fail(function (err) {})
            .always(function () {});
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
            parent.parents("fieldset").find("card").removeClass("active");
            parent.addClass("active");
            $.post({
                url:
                    baseURL +
                    "/getlessonsforstudent/" +
                    parent.attr("id").split("_")[1] +
                    "/" +
                    parent.parents(".training-item").attr("data-session"),
            })
                .then(function (data) {
                    $("#div_A .content-training").find(".accordion").detach();
                    $("#div_A .content-training").attr(
                        "data-type",
                        parent.parents(".training-item").attr("data-type")
                    );
                    $("#div_C .push").attr(
                        "data-type",
                        parent.parents(".training-item").attr("data-type")
                    );
                    clearRightField();
                    data.map(function (dataItem, i) {
                        var new_comp = createLessonItem(dataItem);
                        var new_comp1 = createLessonItem(dataItem);
                        new_comp1.attr(
                            "data-session",
                            parent
                                .parents(".training-item")
                                .attr("data-session")
                        );
                        new_comp.attr(
                            "data-session",
                            parent
                                .parents(".training-item")
                                .attr("data-session")
                        );
                        $("#div_C .push").append(new_comp);
                        $(event.target)
                            .parents(".training-item")
                            .find(".content-training")
                            .append(new_comp1);
                    });
                    if ($("#div_C .push").attr("data-type") != 2) {
                        $(".h-100")
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

                    $("#div_A").animate(
                        {
                            scrollTop: $(".accordion").offset().top,
                        },
                        500
                    );
                    
                })
                .fail(function (err) {})
                .always(function () {});
        });
    }
    $("main .card:first").addClass("active");
    $("main .card:first .training-show").click();
});

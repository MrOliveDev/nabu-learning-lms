$(document).ready(function(e){
    $("#sidebar .nav-main-link").hover(function(event){$("#sidebar").css("zIndex", "10000000")}, function(){$("#sidebar").css("zIndex", "30")});
    $("main").css("zIndex", "300");
    $("#sidebar").css("zIndex", "30");
    $("header #client_"+$("header").attr("data-client")).toggleClass("active", true);
    $('#sidebar-control').click(function(event) {
        event.preventDefault();
        event.stopPropagation();
        console.log($(".simplebar-content").find(".nav-main-link-name").css('display'));
        if ($(".simplebar-content").find(".nav-main-link-name").css('display') == "none") {

            $("#page-header, #page-container").addClass("page-header-trigger");

            $(".simplebar-content").find(".nav-main-link-name").css({
                'display': 'inline-block'
            });
            $(".simplebar-content").css({
                'width': '300px'
            });
            $("#sidebar-content-header").css({
                'width': '300px',
                'flex-direction': 'row'
            });

            $('.sidetitle').removeClass('pb-4');

        } else {
            $("#page-header, #page-container").removeClass("page-header-trigger");

            $(".simplebar-content").find(".nav-main-link-name").css({
                'display': 'none'
            });
            $(".simplebar-content").css({
                'width': '150px'
            });
            $("#sidebar-content-header").css({
                'width': '150px',
                'flex-direction': 'column'
            });
            $('.sidetitle').addClass('pb-4');
        }

        $("#RightPanel").css({
            "width": $("#content").width() - $("#LeftPanel").width() - $("#div_vertical").width() + "px"
            // "width": $("#RightPanel").width() - 150 + "px"
        });

    });
    $(".client-item").click(function(event){
        event.preventDefault();
        var item = $(this);
        if(!$(this).is(".client-item")) {
            item = $(this).parents(".client-item");
        }
        var id = item.attr("id").split("_")[1];
        $.post({url:baseURL + "/switchclient", data:{id}})
        .done(function(data){
            console.log("Successed");
            location.reload();
        })
        .fail(function(err){
            console.log("You have an error", err);
        })
    });
    $(".language-item").click(function(event){
        event.preventDefault();
        var item = $(this);
        if(!$(this).is(".language-item")) {
            item = $(this).parents(".language-item");
        }
        var id = item.attr("id").split("_")[1];
        $.post({url:baseURL + "/updatelanguage", data:{id}})
        .done(function(data){
            console.log("Successed");
            location.reload();
        })
        .fail(function(err){
            console.log("You have an error", err);
        })
    });
    if($("header").attr("data-user-type")=="1") {
        var menuBackground = $("header").attr("data-menuBackground");
        var pageBackground = $("header").attr("data-pageBackground");
        var iconOverColor = $("header").attr("data-iconOverColor");
        var iconDefaultColor = $("header").attr("data-iconDefaultColor");

        $(".simplebar-content").css("background-color", menuBackground);
        $("body").css("background-color", pageBackground);
        $(".nav-main-link").hover(function(){
            $(this).css("color", iconOverColor);
            $(this).css("background-color", menuBackground);
        }, function() {
            $(this).css("color", iconDefaultColor);
        });
        $(".nav-main-link.active").css("color", iconOverColor)

        $(".nav-main-link").css("color", iconDefaultColor);

    }
})


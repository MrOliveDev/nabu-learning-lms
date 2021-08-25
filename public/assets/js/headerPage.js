$(document).ready(function(e){
    $("#sidebar .nav-main-link").hover(function(event){$("#sidebar").css("zIndex", "10000000")}, function(){$("#sidebar").css("zIndex", "none")});
    $("main").css("zIndex", "300");
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
})
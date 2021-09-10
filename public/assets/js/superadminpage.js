$(document).ready(function() {
    $(".item-edit").click(itemEdit);

    $(".item-delete").click(itemDelete);

    $("#search_str").keydown(searchTranslate);

    $("#translate_save_btn").click(submitBtn);
    // $("translate_cancel_btn").click(cancelBtn);
    $("#LeftPanel1 .toolkit-add-item").click(toolkitAddItem);
});

var toolkitAddItem = function(event) {
    formClear();
    $("#translateForm").attr("method", "post");
    $("#translateForm").attr("action", baseURL+"/clientmanage");
    $("#translateForm").attr('data-id', "");
}

// var cancelBtn = function() {
//     // $("translate")
// }

var submitBtn = function(event) {
    var submitData = $("#translateForm").serializeArray();
    var method = $("#translateForm").attr("method");
    var url = $("#translateForm").attr("action");
    $.ajax({url:url, type:method, data:submitData, 
        success:function(data) {
            console.log(data);
            if(method=="put") {
                updateTranslate(data);
            } else {
                // window.location.reload();
            }
        },
        error:function(err) {
            console.log(err);
        } 
    })
}

var searchTranslate = function(event){
    if(event.key === 'Enter') {
        var searchVal = $(event.target).val();        
        $.get({url:baseURL+"/superadminsettings", data:{search:searchVal}}).done(function(data){
            console.log(data);
            $("#translate-list-group").empty();
            data.result.data.map(function(item_data) {
                var translateItem = createTranslate(item_data);
                $("#translate-list-group").append(translateItem);
            })
            $(".pagination.pagination").empty().append(createPageNav(data));
            $(".page_nav").attr("data-last", data.result.last_page);
        }).fail(function(err) {
            console.log(err);
        })
    }
};

var createPageNav = function(data) {
    var pageNav = "";
    var urlArr = data.result.first_page_url.split('=');
    urlArr.splice(-1);
    var url = urlArr.join("=");
    if (data.last_page>1)
        pageNav+='<ul class="pagination pagination">';
            if (data.result.current_page==1) { 
                pageNav +='<li class="disabled page-item">'+
                    '<a href="" class="page-link">'+
                        '<span>«</span>'+
                    '</a>'+
                '</li>';
            }
            else {
                pageNav +='<li class="page-item">'+
                '<a class="page-link" href="'+url+'='+(data.result.current_page-1)+'" rel="prev">«</a>'+
                '</li>';
            }
            if(data.result.current_page > 3){
                pageNav +='<li class="page-item">'+
                '<a class="page-link" href="'+data.result.first_page_url+'">1</a>'+
                '</li>';
            }
            if(data.result.current_page > 4){
                pageNav +='<li class="page-item">'+
                    '<a href="" class="page-link">'+
                        '<span>...</span>'+
                    '</a>'+
                '</li>';
            }
            for(var i=1; i<=data.result.last_page; i++) {
                if(i >= data.result.current_page - 2 && i <= data.result.current_page + 2){
                    if (i == data.result.current_page) {
                        pageNav +='<li class="active page-item">'+
                            '<a href="" class="page-link">'+
                                '<span>'+i+'</span>'+
                            '</a>'+
                        '</li>';
                    }
                    else {
                        pageNav +='<li class="page-item"><a class="page-link" href="'+url+'='+i+'">'+i+'</a></li>';
                    }
                }
            }
            if(data.result.current_page < data.result.last_page - 3) {
                pageNav +='<li class="page-item">'+
                    '<a href="" class="page-link">'+
                        '<span>...</span>'+
                    '</a>'+
                '</li>';
            }
            if(data.result.current_page < data.result.last_page - 2) {
                pageNav +='<li class="page-item">'+
                '<a class="page-link" href="'+data.result.last_page_url+'">'+data.result.last_page+'</a>';
                '</li>';
            }

            if (data.result.current_page < data.result.last_page) {
                pageNav +='<li class="page-item"><a class="page-link" href="'+url+'='+(data.result.current_page+1)+'" rel="next">»</a></li>';
            }
            else {
                pageNav +='<li class="disabled page-item">'+
                    '<a href="" class="page-link">'+
                        '<span>»</span>'+
                    '</a>'+
                '</li>';
            }
        pageNav+='</ul>';
    return pageNav;
};

var createTranslate = function(data) {
    var translateItem = 
        $('<a class="list-group-item list-group-item-action p-1 border-0" id="translate_'+data.translation_id+'" data-toggle="list" href="#list-home" role="tab" aria-controls="home"  data-value="'+data.translation_value+'" data-lang-iso="'+data.language_id+'" data-string="'+data.translation_string+'">'+
        '<div class="float-left">'+
        data.translation_string+
        '</div>'+
        '<div class="btn-group float-right">'+
        '<span class="language_span text-white p-1">'+data.lang_iso.toUpperCase()+'</span>'+
        '<button class="btn text-white px-2 item-edit" data-id="'+data.translation_id+'" href="#list-home">'+
        '<i class="fa fa-edit"></i>'+
        '</button>'+
        '<button class="btn text-white px-2 item-delete" data-id="'+data.translation_id+'">'+
        '<i class="fa fa-trash-alt"></i>'+
        '</button>'+
        '</div>'+
        '</a>');
    translateItem.find(".item-edit").click(itemEdit);
    translateItem.find(".item-delete").click(itemDelete);
return translateItem;
};

var updateTranslate = function(data) {
    if($("#translateForm").attr("data-id")){
        var id = $("#translateForm").attr("data-id");
        $("#translate_"+id).attr("data-string", data.result.translation_value);
        $("#translate_"+id).attr("data-lang-iso", data.result.language_id);
        $("#translate_"+id).attr("data-value", data.result.translation_string);
        $("#translate_"+id).find(".float-left").html(data.result.translation_value);
        $("#translate_"+id).find(".language_span").html(data.lang_iso.toUpperCase());
    }
}

var formClear = function() {
    $("#RightPanel1 input, #RightPanel1 select").val('');
}

var itemEdit = function(event) {
    var item = $(event.target).parents(".list-group-item");
    var id = item.find(".item-delete").attr("data-id");
    var translate_value = item.attr("data-value");
    var translate_string = item.attr("data-string");
    var lang_iso = item.attr("data-lang-iso");
    $("#currenLanguage").val(translate_string);
    $("#interfaceLanguage").val(translate_value);
    $("#selectLanguage").val(lang_iso);
    $("#translateForm").attr("method", "put");
    $("#translateForm").attr("action", baseURL+"/clientmanage/"+id);
    $("#translateForm").attr('data-id', id);
}

var itemDelete = function() {
    var id = $(this).closest(".btn").attr("data-id");
    if(confirm("Are you really delete this item?")==true){
        $.ajax({url:baseURL+"/clientmanage/"+id, 
            type:"delete",
            async:true,
            success:function(data) {
                alert("You deleted language successfully!");
            }, 
            error:function(err) {
                alert("You have an error during deleting translate item");
            },
        });
    }
}
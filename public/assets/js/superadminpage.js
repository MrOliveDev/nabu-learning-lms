var searchValue = "";
$(document).ready(function() {
    $(".item-edit").click(itemEdit);

    $(".item-delete").click(itemDelete);

    $("#search_str").keydown(searchTranslate);

    $("#translate_save_btn").click(submitBtn);
    // $("translate_cancel_btn").click(cancelBtn);
    $("#LeftPanel1 .toolkit-add-item").click(toolkitAddItem);
    $("#page-nav a.page-link").click(pageNavClick);
});

var pageNavClick = function(event) {
    event.preventDefault();
    event.stopPropagation();
    url = $(this).attr("data-href");
    if(url)
    fetchData(url+"&search="+searchValue);
}

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
        searchValue = $(event.target).val();        
        fetchData(baseURL+"/superadminsettings?search="+searchValue+"&page=1");
    }
};

var fetchData = function(url) {
    $.get({url}).done(function(data){
        console.log(data);
        $("#translate-list-group").empty();
        data.result?.map(function(item_data) {
            var translateItem = createTranslate(item_data);
            $("#translate-list-group").append(translateItem);
        })
        $(".pagination.pagination").empty().append(createPageNav(data.link));
        $("#page-nav a.page-link").click(pageNavClick);
        $(".page_nav").attr("data-last", data.result.last_page);
    }).fail(function(err) {
        console.log(err);
        alert("You have an error!");
    });
}

var createPageNav = function(data) {
    var pageNav = "";
    var urlArr = data.first_page_url.split('=');
    urlArr.splice(-1);
    var url = urlArr.join("=");
    if (data.last_page>1)
        pageNav+='<ul class="pagination pagination">';
            if (data.current_page==1) { 
                pageNav +='<li class="disabled page-item">'+
                    '<a href="javascript:void(0)" data-href="" class="page-link">'+
                        '<span>«</span>'+
                    '</a>'+
                '</li>';
            }
            else {
                pageNav +='<li class="page-item">'+
                '<a class="page-link" href="javascript:void(0)" data-href="'+url+'='+(data.current_page-1)+'" rel="prev">«</a>'+
                '</li>';
            }
            if(data.current_page > 3){
                pageNav +='<li class="page-item">'+
                '<a class="page-link" href="javascript:void(0)" data-href="'+data.first_page_url+'">1</a>'+
                '</li>';
            }
            if(data.current_page > 4){
                pageNav +='<li class="page-item">'+
                    '<a href="javascript:void(0)" data-href="" class="page-link">'+
                        '<span>...</span>'+
                    '</a>'+
                '</li>';
            }
            for(var i=1; i<=data.last_page; i++) {
                if(i >= data.current_page - 2 && i <= data.current_page + 2){
                    if (i == data.current_page) {
                        pageNav +='<li class="active page-item">'+
                            '<a href="javascript:void(0)" data-href="" class="page-link">'+
                                '<span>'+i+'</span>'+
                            '</a>'+
                        '</li>';
                    }
                    else {
                        pageNav +='<li class="page-item"><a class="page-link" href="javascript:void(0)" data-href="'+url+'='+i+'">'+i+'</a></li>';
                    }
                }
            }
            if(data.current_page < data.last_page - 3) {
                pageNav +='<li class="page-item">'+
                    '<a href="javascript:void(0)" data-href="" class="page-link">'+
                        '<span>...</span>'+
                    '</a>'+
                '</li>';
            }
            if(data.current_page < data.last_page - 2) {
                pageNav +='<li class="page-item">'+
                '<a class="page-link" href="javascript:void(0)" data-href="'+data.last_page_url+'">'+data.last_page+'</a>';
                '</li>';
            }

            if (data.current_page < data.last_page) {
                pageNav +='<li class="page-item"><a class="page-link" href="javascript:void(0)" data-href="'+url+'='+(data.current_page+1)+'" rel="next">»</a></li>';
            }
            else {
                pageNav +='<li class="disabled page-item">'+
                    '<a href="javascript:void(0)" data-href="" class="page-link">'+
                        '<span>»</span>'+
                    '</a>'+
                '</li>';
            }
        pageNav+='</ul>';
        $(pageNav).find("a.page-link").click(pageNavClick);
    return pageNav;
};

var createTranslate = function(data) {
    var translateItem = 
        $('<a class="list-group-item list-group-item-action p-1 border-0" id="translate_'+data.translation_id+'" data-toggle="list"  role="tab" aria-controls="home"  data-value="'+data.translation_value=='null'?'':data.translation_value+'" data-lang-iso="'+data.language_id+'" data-string="'+data.translation_string+'">'+
        '<div class="float-left">'+
        data.translation_string+
        '</div>'+
        '<div class="btn-group float-right">'+
        '<span class="language_span text-white p-1">'+data.lang_iso.toUpperCase()+'</span>'+
        '<button class="btn text-white px-2 item-edit" data-id="'+data.translation_id+'" >'+
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
        $("#translate_"+id).attr("data-string", data.result.translation_string);
        $("#translate_"+id).attr("data-lang-iso", data.result.language_id);
        $("#translate_"+id).attr("data-value", data.result.translation_value);
        $("#translate_"+id).find(".float-left").html(data.result.translation_string);
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
    $("#translation_string").val(translate_string);
    $("#translation_value").val(translate_value);
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
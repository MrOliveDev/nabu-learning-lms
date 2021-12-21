var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];
var $modal = $('#image-crop-modal');
var filename = '';
var file;
var active_item;
$("body").on("change", "#group_document", function (e) {
    var files = e.target.files;
    var done = function (url) {
        $('.img-container').addClass('w-100');
        var list = $('.img-container')[0];
        var content = document.createElement("h1");
        content.id = 'doc_url';
        list.prepend(content);
        $('#doc_url').text(files[0].name);
        filename = files[0].name;

        $('#drag-comment').remove();
    };
    var reader;
    var url;
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});

$("body").on("change", "#person_document", function (e) {
    var files = e.target.files;
    var done = function (url) {
        $('.img-container').addClass('w-100');
        var list = $('.img-container')[0];
        var content = document.createElement("h1");
        content.id = 'doc_url';
        list.prepend(content);
        $('#doc_url').text(files[0].name);
        filename = files[0].name;

        $('#drag-comment').remove();
    };
    var reader;
    var url;
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});

$modal.on('shown.bs.modal', function () {
    $('#image-crop-modal .modal-body').prepend('<div id="drag-comment" class="w-100"><div class="text-center mt-3" id="drop-text">Drop your file here!</div><div class="text-center my-1" id="drop-text1">or</div><div class="row"  id="browse-btn"><button type="button" class="btn btn-hero-primary float-right mx-auto" id="browse">Browse</button></div></div>');
    $('.img-container').removeClass('w-100');
    $('#document').val('');
    $('#doc_url').remove();

}).on('hidden.bs.modal', function () {
    $('#drag-comment').remove()
    $('#document').val('');
    $('.upload-action').find('.active').removeClass('active');
});

$('#cancel').click(function () {
    if (active_item == "upload_document_person") {
        $('.upload-action').find('.active').find('#person_document').val("");
    } else {
        $('.upload-action').find('.active').find('#group_document').val("");
    }
})

$("#confirm").click(function () {
    var myformData = new FormData();
    myformData.append("file", file);
    if (active_item == "upload_document_person") {
        myformData.append('type', "person");
    } else {
        myformData.append('type', "group");
    }
    myformData.append("lessonId", $('.upload-action').find('.active').parents('.upload-action').attr('data-lesson'));
    myformData.append("sessionId", $('.upload-action').find('.active').parents('.upload-action').attr('data-session'));
    $.post({
            url: "upload_document",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            // data: {
            //     filename: filename,
            //     file: myformData,
            // },
            data: myformData,
            processData: false,
            contentType: false
        })
        .done(function (data) {
            if (data.success == true) {
                swal.fire({
                    title: "Success",
                    text: "We have received your document. Thank you!",
                    icon: "success",
                    confirmButtonText: `OK`,
                });
                var date = data.document.created_date.split("-");
                var text = data.document.filename + "- file sended on " + monthNames[date[1] - 1] + " " + date[2] + " of " + date[0] + " by " + data.user.first_name + " " + data.user.last_name;
                if (active_item == "upload_document_person") {
                    $("#session_" + data.document.session_id).find('#lesson_' + data.document.lesson_id).find('.document_detail_person').text(text);
                } else if (active_item == "upload_document_group") {
                    $("#session_" + data.document.session_id).find('#lesson_' + data.document.lesson_id).find('.document_detail_group').text(text);
                }
            }
        })
        .fail(function (err) {
            notification("Sorry, You have an error!", 2);
        })
        .always(function (data) {});
    $modal.modal('hide');
})


function upload(type, lessonId, sessionId) {
    if (type == "group") {
        $("#session_" + sessionId).find('#accordion' + lessonId).find('#upload_document_group').addClass("active");
    } else if (type == "person") {
        $("#session_" + sessionId).find('#accordion' + lessonId).find('#upload_document_person').addClass("active");
    }
    active_item = "upload_document_" + type;
    $modal.modal({
        backdrop: 'static',
        keyboard: false
    });
    // $("input.image")[0].click();
}

// if (window.FileReader) {
//     var drop;
//     addEventHandler(window, 'load', function () {
//         drop = document.getElementById('drop');
//         var list = $('.img-container')[0];

//         function cancel(e) {
//             if (e.preventDefault) {
//                 e.preventDefault();
//             }
//             return false;
//             $('.modal').removeClass('dropover');
//             $('.modal-content').removeClass('modal_dropover');
//         }

//         // Tells the browser that we *can* drop on this target
//         addEventHandler(drop, 'dragover', function (e) {
//             e = e || window.event; // get window.event if e argument missing (in IE)
//             if (e.preventDefault) {
//                 e.preventDefault();
//             }
//             $('.modal').addClass('dropover');
//             $('.modal-content').addClass('modal_dropover');

//             return false;
//         });
//         addEventHandler(drop, 'dragleave', function (e) {
//             e = e || window.event; // get window.event if e argument missing (in IE)
//             if (e.preventDefault) {
//                 e.preventDefault();
//             }
//             $('.modal').removeClass('dropover');
//             $('.modal-content').removeClass('modal_dropover');
//             return false;
//         });
//         addEventHandler(drop, 'dragenter', cancel);
//         addEventHandler(drop, 'drop', function (e) {
//             $('.modal-content').removeClass('modal_dropover');
//             $('.modal').removeClass('dropover');
//             $('#drag-comment').remove()
//             e = e || window.event; // get window.event if e argument missing (in IE)
//             if (e.preventDefault) {
//                 e.preventDefault();
//             } // stops the browser from redirecting off to the image.

//             var dt = e.dataTransfer;
//             var files = dt.files;
//             // for (var i = 0; i < files.length; i++) {
//             var file = files[0];
//             var reader = new FileReader();

//             //attach event handlers here...

//             reader.readAsDataURL(file);
//             addEventHandler(reader, 'loadend', function (e, file) {
//                 var bin = this.result;
//                 // var img = document.createElement("img");
//                 // img.file = file;
//                 // img.src = bin;
//                 // img.id = 'image';
//                 $('#doc_url').remove();
//                 var content = document.createElement("h1");
//                 content.id = 'doc_url';
//                 list.prepend(content);
//                 $('#doc_url').text(bin);

//                 $('#drop-text').remove();

//             }.bindToEventHandler(file));
//             // }
//             return false;
//         });
//         Function.prototype.bindToEventHandler = function bindToEventHandler() {
//             var handler = this;
//             var boundParameters = Array.prototype.slice.call(arguments);
//             console.log(boundParameters);
//             //create closure
//             return function (e) {
//                 e = e || window.event; // get window.event if e argument missing (in IE)
//                 boundParameters.unshift(e);
//                 handler.apply(this, boundParameters);
//             }
//         };
//     });
// } else {
//     console.log('Your browser does not support the HTML5 FileReader.');
// }

// function addEventHandler(obj, evt, handler) {
//     if (obj.addEventListener) {
//         // W3C method
//         obj.addEventListener(evt, handler, false);
//     } else if (obj.attachEvent) {
//         // IE method.
//         obj.attachEvent('on' + evt, handler);
//     } else {
//         // Old school method.
//         obj['on' + evt] = handler;
//     }
// }

$('#drop').click(function (e) {
    if (active_item == "upload_document_person") {
        if ($('.upload-action').find('.active').find('#person_document').val() == "") {
            e.preventDefault();
            $('.upload-action').find('.active').find('#person_document').click();
        }
    } else {
        if ($('.upload-action').find('.active').find('#group_document').val() == "") {
            e.preventDefault();
            $('.upload-action').find('.active').find('#group_document').click();
        }
    }
})

var notification = function (str, type) {
    switch (type) {
        case 1:
            Dashmix.helpers("notify", {
                type: "info",
                icon: "fa fa-info-circle mr-1",
                message: str,
            });
            break;

        case 2:
            Dashmix.helpers("notify", {
                type: "danger",
                icon: "fa fa-times mr-1",
                message: str,
            });
            break;

        default:
            break;
    }
};

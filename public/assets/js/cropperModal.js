var $modal = $('#image-crop-modal');
var previewimg = document.getElementById('image');
var cropper;
var zoomscale = 50;
$("body").on("change", ".image", function(e) {
    var files = e.target.files;
    var done = function(url) {
        var list = $('.img-container')[0];
        var img = document.createElement("img");
        // img.file = file;
        img.src = url;
        img.id = 'image';
        list.prepend(img);

        previewimg = document.getElementById('image');
        previewimg.src = url;
        cropper = new Cropper(previewimg, {
            aspectRatio: 1,
            "container": {
                "width": "100%",
                "height": 400
            },
            "viewport": {
                "width": 200,
                "height": 200,
                "type": "circle",
                "border": {
                    "width": 2,
                    "enable": true,
                    "color": "#fff"
                }
            },
            "zoom": {
                "enable": true,
                "mouseWheel": true,
                "slider": true
            },
            "rotation": {
                "slider": true,
                "enable": true,
                "position": "left"
            },
            "transformOrigin": "viewport"

        });

        $("#zoom-rangeslider-group").css('display', 'block');
        $('#drag-comment').remove();
        // $('#drop').unbind('click');
        let my_range = $(".js-rangeslider").data("ionRangeSlider");
        my_range.reset();
    };
    var reader;
    var file;
    var url;
    if (files && files.length > 0) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function(e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
});

$modal.on('shown.bs.modal', function() {
    $('#image-crop-modal .modal-body').prepend('<div id="drag-comment"><div class="text-center mt-3" id="drop-text">Drop your file here!</div><div class="text-center my-1" id="drop-text1">or</div><div class="row"  id="browse-btn"><button type="button" class="btn btn-hero-primary float-right mx-auto" id="browse">Browse</button></div></div>');
    $('#image').remove();
    $("#zoom-rangeslider-group").css('display', 'none');
    if (cropper != null) {
        cropper.destroy();
        cropper = null;
    }
}).on('hidden.bs.modal', function() {
    // $("#zoom-rangeslider-group").remove();
    $('#drag-comment').remove()
    $('#image').remove();
    $("#zoom-rangeslider-group").css('display', 'none');

    if (cropper != null) {
        cropper.destroy();
        cropper = null;
    }
});
$("#crop").click(function() {

    if (cropper != null) {

        // var range_slider_template = '<div class="form-group mb-5" id="zoom-rangeslider-group">' +
        //     '<input type="text" class="js-rangeslider" id="zoom-rangeslider" value="50"> </div>';

        // $("#img-range-slider").append(range_slider_template);
        canvas = cropper.getCroppedCanvas({
            width: 150,
            height: 150,
        });
        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                $("#preview").attr('src', base64data);
                $modal.modal('hide');
                $("input#base64_img_data").val(base64data);
                // console.log(base64data);
            }
        });
        $('#drag-comment').remove()
        $('#image').remove();
        $("#zoom-rangeslider-group").css('display', 'none');
        cropper.destroy();
        cropper = null;
    } else {
        $modal.modal('hide');
    }
})
$("#zoom-rangeslider").change(function() {
    // if (zoomscale < $(this).val()) {
    //     cropper.zoom(0.9);
    // } else if(zoomscale > $(this).val()) {
    //     cropper.zoom(-0.8);
    // }
    if (cropper != null) {
        zoomvalue = 1 - (50 - $(this).val()) * 0.02;
        cropper.zoomTo(zoomvalue);
    }
    // zoomscale = $(this).val();
})
$('#upload_button').click(function(evt) {
    evt.stopPropagation();
    // alert($('#menuBackground').css('background-color'));
    // var interface_color={
    //     'menuBackground':RGBToHex($('#menu-background').css('background-color')),
    //     'pageBackground':RGBToHex($('#page-background').css('background-color')),
    //     'iconOverColor':RGBToHex($('#icon-over-color').css('background-color')),
    //     'iconDefaultColor':RGBToHex($('#icon-default-color').css('background-color'))
    // }
    // $('#interface_color').val(JSON.stringify(interface_color));
    // alert($('#interface_color').val());
    // $(this).children("input[type='file']")[0].click();
    // if ($(".uploadcare--link.uploadcare--widget__file-name").length == 0) {
    $("#zoom-rangeslider").val(50);
    $modal.modal({
        backdrop: 'static',
        keyboard: false
    });
    // $("input.image")[0].click();
});
if (window.FileReader) {
    var drop;
    addEventHandler(window, 'load', function() {
        drop = document.getElementById('drop');
        var list = $('.img-container')[0];

        function cancel(e) {
            if (e.preventDefault) {
                e.preventDefault();
            }
            return false;
            $('.modal').removeClass('dropover');
            $('.modal-content').removeClass('modal_dropover');
        }

        // Tells the browser that we *can* drop on this target
        addEventHandler(drop, 'dragover', function(e) {
            e = e || window.event; // get window.event if e argument missing (in IE)
            if (e.preventDefault) {
                e.preventDefault();
            }
            $('.modal').addClass('dropover');
            $('.modal-content').addClass('modal_dropover');

            return false;
        });
        addEventHandler(drop, 'dragleave', function(e) {
            e = e || window.event; // get window.event if e argument missing (in IE)
            if (e.preventDefault) {
                e.preventDefault();
            }
            $('.modal').removeClass('dropover');
            $('.modal-content').removeClass('modal_dropover');
            return false;
        });
        addEventHandler(drop, 'dragenter', cancel);
        addEventHandler(drop, 'drop', function(e) {
            $('.modal-content').removeClass('modal_dropover');
            $('.modal').removeClass('dropover');
            $('#drag-comment').remove()
            e = e || window.event; // get window.event if e argument missing (in IE)
            if (e.preventDefault) {
                e.preventDefault();
            } // stops the browser from redirecting off to the image.

            var dt = e.dataTransfer;
            var files = dt.files;
            // for (var i = 0; i < files.length; i++) {
            var file = files[0];
            var reader = new FileReader();

            //attach event handlers here...

            reader.readAsDataURL(file);
            addEventHandler(reader, 'loadend', function(e, file) {
                var bin = this.result;
                var img = document.createElement("img");
                img.file = file;
                img.src = bin;
                img.id = 'image';
                $('#image').remove();
                list.prepend(img);

                $('#drop-text').remove();

                if (cropper != null) {
                    cropper.destroy();
                    cropper = null;
                }
                previewimg = document.getElementById('image');
                cropper = new Cropper(previewimg, {
                    aspectRatio: 1,
                    "container": {
                        "width": "100%",
                        "height": 400
                    },
                    "viewport": {
                        "width": 200,
                        "height": 200,
                        "type": "circle",
                        "border": {
                            "width": 2,
                            "enable": true,
                            "color": "#fff"
                        }
                    },
                    "zoom": {
                        "enable": true,
                        "mouseWheel": true,
                        "slider": true
                    },
                    "rotation": {
                        "slider": true,
                        "enable": true,
                        "position": "left"
                    },
                    "transformOrigin": "viewport"

                });

                // var range_slider_template = '<div class="form-group mb-5" id="zoom-rangeslider-group">' +
                //     '<input type="text" class="js-rangeslider" id="zoom-rangeslider" value="50"> </div>';

                // //////////
                // var temp = 1;
                // $("#img-range-slider").append(range_slider_template);
                $("#zoom-rangeslider-group").css('display', 'block');
                let my_range = $(".js-rangeslider").data("ionRangeSlider");
                my_range.reset();

            }.bindToEventHandler(file));
            // }
            return false;
        });
        Function.prototype.bindToEventHandler = function bindToEventHandler() {
            var handler = this;
            var boundParameters = Array.prototype.slice.call(arguments);
            console.log(boundParameters);
            //create closure
            return function(e) {
                e = e || window.event; // get window.event if e argument missing (in IE)
                boundParameters.unshift(e);
                handler.apply(this, boundParameters);
            }
        };
    });
} else {
    console.log('Your browser does not support the HTML5 FileReader.');
}

function addEventHandler(obj, evt, handler) {
    if (obj.addEventListener) {
        // W3C method
        obj.addEventListener(evt, handler, false);
    } else if (obj.attachEvent) {
        // IE method.
        obj.attachEvent('on' + evt, handler);
    } else {
        // Old school method.
        obj['on' + evt] = handler;
    }
}
$('#drop').click(function(e) {
    if (cropper == null) {
        e.preventDefault();
        console.log('jaljdlf');
        $(".image")[0].click();
    }
})

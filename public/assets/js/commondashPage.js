var baseURL = window.location.protocol + "//" + window.location.host + '/newlms';
// var baseURL = window.location.protocol + "//" + window.location.host;

var clearRightField = function() {
    $('#div_C .push').find('.block').detach();
}

var playBtn = function(event) {
    event.preventDefault();
    window.open(baseURL + "/player_editor" + "/#/open/fr/fabrique/0/" + $(this).attr('data-fabrica') + "/0/dae8efee8afc1994204d76ee963bcfb1");
};

var createLessonItem = function(data) {
    if (data != null) {
        var component = $(
            '<div id="accordion" role="tablist" aria-multiselectable="true">' +
            '<div class="block block-rounded mb-1 bg-transparent shadow-none">' +
            '<div class="block-header block-header-default border-transparent border-0 bg-transparent p-0" role="tab" id="accordion_h1">' +
            '<div class=" col-md-3 text-white align-self-stretch d-flex text-center  flex-md-row" style="border-right:2px solid #9a6cb0;">' +
            '<span class="col-md-6">' +
            '<i class="fa fa-chart-line">' +
            '</i>' +
            '<span>' +
            '75%' +
            '</span>' +
            '</span>' +
            '<span class="col-md-6">' +
            '<i class="fa fa-check-circle">' +
            '</i>' +
            '<span>' +
            '75%' +
            '</span>' +
            '</span>' +
            '</div>' +
            '<div class="  col-md-9 border-transparent border-left-1 align-self-stretch d-flex flex-row justify-content-between">' +
            '<div class="float-left">' +
            '<span class="item-name">' + data['name'] + '</span>' +
            '</div>' +
            '<div class="btn-group float-right d-flex">' +
            '<button class="btn  item-show" data-content="teacher">' +
            '<a class="font-w600 collapsed" data-toggle="collapse" data-parent="#accordion" href="#lesson_' + data['id'] + '" aria-expanded="false" aria-controls="accordion_q1">' +
            '<i class="fas fa-exclamation-circle text-white m-0 p-2"></i>' +
            '</a>' +
            '</button>' +
            '<button class="btn  item-play" data-content="teacher" data-fabrica="' + data.idFabrica + '">' +
            '<i class="fa fa-play text-white m-0 p-2"></i>' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div id="lesson_' + data['id'] + '" class="collapse" role="tabpanel" aria-labelledby="accordion_h1" data-parent="#accordion">' +
            '<div class="block-content bg-white mt-2  pb-3">' +
            '<p>' + data['description'] + '</p>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    }
    component.find('.item-play').click(playBtn);
    return component;
}

$(document).ready(function() {
    $('main .card:first').addClass('active');
    $('.training-collapse').click(function(event) {
        var parent = $(this).parents('.card');
        parent.find('.card-img-top').toggle('slow');
        parent.find('.card-body').toggle('slow');
    });
    $('.training-show').click(function(event) {
        var parent = $(this).parents('.card');
        parent.parents('fieldset').find('card').removeClass('active');
        parent.addClass('active');
        $.post({
            url: baseURL + '/getlessonsforstudent/' + parent.attr('id').split('_')[1],
        }).then(function(data) {
            clearRightField();
            data.map(function(dataItem) {
                $('#div_C .push').append(createLessonItem(dataItem));
            })
        }).fail(function(err) {

        }).always(function() {

        });
    });
    $('.item-play').click(playBtn);
});
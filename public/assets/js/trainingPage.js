// var baseURL = window.location.protocol + "//" + window.location.host + '/newlms';
var baseURL = window.location.protocol + "//" + window.location.host;

$(document).ready(function() {
    loadLessons();
});

var loadLessons = function() {
    $.get(baseURL + '/lesson').then(function(data) {
        console.log(data);
    }).error(function(err) {
        console.log(err);
    }).always(function(data) {
        console.log();
    });
}

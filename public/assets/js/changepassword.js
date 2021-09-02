$(document).ready(function () {
    Dashmix.helpers('validation');
    if($("#change-password-form").attr("data-success")) {
        alert("Reset password successfully!");
    }
});
$("#show-password").click(function (event) {
    if ($(event.target).prop("checked") != false) {
        $("#new_password").attr("type", "text");
        $("#confirm_password").attr("type", "text");
    } else {
        $("#new_password").attr("type", "password");
        $("#confirm_password").attr("type", "password");
    }
});
$("#cancel_button").click(function (event) {
    window.location.href = baseURL + "/";
});
$("#save_button").click(function (event) {
    var validator = $("#change-password-form").validate({
        rules: {
            new_password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                equalTo: "#new_password"
            }
        },
        messages: {
            new_password:{
                require: " Enter Password",
                minlength:"Enter at least 5 letter"
            },
            confirm_password: " Confirm Password Same as Confirm Password"
        }
    });
    $("#change-password-form").submit();

        // $("change-password-form").validate();
        return false;
    
});


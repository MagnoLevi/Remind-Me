$(".forgot-password").on("click", function () {
    $("#login_div, #register_div").css("display", "none");
    $("#forget_pass_div").css("display", "flex");
})

$(".register-or-login").on("click", function () {
    $("#forget_pass_div").css("display", "none");

    if ($("#login_div").is(":visible")) {
        $("#login_div").css("display", "none");
        $("#register_div").css("display", "flex");

    } else {
        $("#login_div").css("display", "flex");
        $("#register_div").css("display", "none");
    }
})

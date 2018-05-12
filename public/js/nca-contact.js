$(function() {
    "use strict";

    $("#nca-form").submit(function (e) {
        e.preventDefault();
        var url = "/api/messages"; // the script where you handle the form input.

        var message = $('#reason').val() + '|' + $('#phone').val() + '|' + $('#message').val();

        var data = JSON.stringify(
            {
                "name": $('#name').val(),
                "email": $('#email').val(),
                "message": message,
                "ip": window.location.host
            }
        );

        $.ajax({
            type: "POST",
            url: url,
            contentType: "application/json",
            dataType: "json",
            data: data,
        }).done(function (data) {
            $("#nca-form").html("<div class='successMessage'>Danke wir melden uns</div>");
        }).fail(function (data) {

        });

        return false;
    });
}

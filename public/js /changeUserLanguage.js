$(document).ready(function () {
    $("#userLanguage").on('change', function () {
        let userLanguage = $(this).val();
        let language = $.ajax({
            type: "POST",
            url: "/user/change/language",
            data: {
                'userLanguage': userLanguage
            },
            dataType: "text",
            async: true,
            success: function() {
                location.reload();
            }
        });
    });
});
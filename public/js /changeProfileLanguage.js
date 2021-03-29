$(document).ready(function () {
    $("#interfaceLanguage").on('change', function () {
        let interfaceLanguage = $(this).val();
        let subtitles = $.ajax({
            type: "GET",
            url: "/change-profile-language",
            data: {
                'interfaceLanguage': interfaceLanguage
            },
            dataType: "text",
            async: true,
            success: function(msg) {
                location.reload();
            }
        });
    });
});
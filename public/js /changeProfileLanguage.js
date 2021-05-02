$(document).ready(function () {
    $("#interfaceLanguage").on('change', function () {
        let interfaceLanguage = $(this).val();
        let language = $.ajax({
            type: "POST",
            url: "/profile/change/language",
            data: {
                'interfaceLanguage': interfaceLanguage
            },
            dataType: "text",
            async: true,
            success: function() {
                location.reload();
            }
        });
    });
});
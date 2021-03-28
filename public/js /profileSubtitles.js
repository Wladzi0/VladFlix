$(document).ready(function () {
    $("#preferredSubtitles").on('change', function () {
        let preferredSubtitles = $(this).val();
        let subtitles = $.ajax({
            type: "GET",
            url: "/profile-preferences",
            data: {
                'subtitles': preferredSubtitles
            },
            dataType: "text",
            async: true,
        });
    });
});
$(document).ready(function () {
    $("#preferredSubtitles").on('change', function () {
        let preferredSubtitles = $(this).val();
        let subtitles = $.ajax({
            type: "POST",
            url: "/profile/preferences",
            data: {
                'subtitles': preferredSubtitles
            },
            dataType: "JSON",
            async: true,
        });
    });
});
$(document).ready(function () {
    $("#preferredAudio").on('change', function () {
        let preferredAudio = $(this).val();
        let audio = $.ajax({
            type: "POST",
            url: "/profile/preferences",
            data: {
                'audio': preferredAudio
            },
            dataType: "JSON",
            async: true,

        });
    });
});
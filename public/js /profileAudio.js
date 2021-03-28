$(document).ready(function () {
    $("#preferredAudio").on('change', function () {
        let preferredAudio = $(this).val();
        let audio = $.ajax({
            type: "GET",
            url: "/profile-preferences",
            data: {
                'audio': preferredAudio
            },
            dataType: "text",
            async: true,
        });
    });
});
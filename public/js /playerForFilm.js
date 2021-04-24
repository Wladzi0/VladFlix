document.addEventListener('DOMContentLoaded', function () {
    let curStarTime = document.querySelector('#js-cur-time').dataset.startTime;
    let isPlaying = false;
    let duration = new Date(0);
    let videoHistoryData;
    let time = new Date(0);
    let data = [0o0, 0o0, 30, 0];
    const paramsString = window.location.search;
    const urlParams = new URLSearchParams(paramsString);
    const filmId = urlParams.get("filmId");
    let durTime = document.querySelector('#js-duration-time').dataset.durationTime;
    let splitDurTime=durTime.split(':');
    duration.setUTCHours(splitDurTime[0], splitDurTime[1], splitDurTime[2],0);
    let start = document.getElementById('start');
    document.getElementById("max_time").innerHTML = duration.toUTCString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");

    if (start) {
        start.addEventListener('click', function () {
            if (isPlaying === true) {

                pauseTime();
            } else {
                startTime();
            }


        });
    }

    function startTime() {
        $.ajax({
            type: "POST",
            url: "/log-start-video",
            data: {
                'filmId': filmId
            },
            dataType: "text",
            async: true,

        });
        if (curStarTime === "0") {
            time.setMilliseconds(0);
        } else {
            let r = confirm("Do you want to continue watching?");
            if (r === true) {
                time.setMilliseconds(curStarTime);
            } else {
                time.setMilliseconds(0);
            }
        }

        setInterval(updateTime, 1000);
        videoHistoryData = setInterval(videoSavingData, 4000);
        start.classList.replace('fa-play', 'fa-pause');
        isPlaying = true;
    }

    function updateTime() {
        if (time.toUTCString() === duration.toUTCString()) {
            videoSavingData(true);
            stopTime();
        }
        if (isPlaying === true) {
            document.getElementById("current_time").innerHTML = time.toUTCString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
            document.getElementById("duration_slider").value = time.getSeconds() + 1;
            time.setSeconds(time.getSeconds() + 1);
            document.getElementById("max_time").value = time.getTime();
        }
    }

    function pauseTime() {

        start.classList.replace('fa-pause', 'fa-play');
        clearInterval(videoHistoryData);
        isPlaying = false;

    }

    function stopTime() {
        time.setUTCHours(0, 0, 0, 0);
        start.classList.replace('fa-pause', 'fa-play');
        document.getElementById("current_time").innerHTML = time.toUTCString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
        isPlaying = false;
        clearInterval(videoHistoryData);
        document.getElementById("duration_slider").value = 0;
    }

    function videoSavingData(isFinished = false, isSerial= false) {
        let curTime = time.getTime();
        if (isFinished) {
            curTime = 0;
        }
        $.ajax({
            type: "POST",
            url: "/time-data-file-saving",
            data: {
                'isSerial': isSerial,
                'filmOrEpisodeId': filmId,
                'isFinished': isFinished,
                'curTime': curTime,
            },
            dataType: "JSON",
            async: true,

        });
    }

});





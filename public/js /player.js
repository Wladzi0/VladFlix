let playing_song=false;
let previous= document.querySelector('#previous');
let next= document.querySelector('#next');
let duration= new Date(0);
let timer;
let autoplay =false;
let track= document.createElement('audio');


function justPlay()
{
    track.src="http://media.w3.org/2010/05/sound/sound_90.mp3";
    alert(track.src);
    track.load();
    if(playing_song===false){
        playSong();
    }
    else{
        pauseSong();
    }
    // document.getElementById("play").style.display = "none";
    // document.getElementById("pause").style.display = "block";
    // track.play();
    // isPaused = false;
}
// function pause()
// {
//     track.play();
//     document.getElementById("play").style.display = "block";
//     document.getElementById("pause").style.display = "none";
//     isPaused = true;
// }
function playSong(){
    track.play();
    playing_song=true;
}
function pauseSong(){
    track.pause();
    playing_song=true;
}

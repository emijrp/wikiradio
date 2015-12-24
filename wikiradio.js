var totalLength = 0;
for (var i=0;i<ArrayTracks.length;i++) {
    totalLength += ArrayTracks[i][3];
}
var date = new Date();
var dateutc = date.toUTCString();
var data = document.getElementById('data');
var epoch = Math.round(new Date() / 1000);
var diffsec = epoch % totalLength;
//data.innerHTML = 'UTC: ' + dateutc + '<br/>Epoch: ' + epoch + '<br/>Total length: ' + totalLength + '<br/>%: ' + diffsec;

var audioPlayer = document.getElementById('audioPlayer');
var audioDescription = document.getElementById('audioDescription');
var audioPlayerAux = document.getElementById('audioPlayerAux');

var trackID = 0;
for (var i=0;i<ArrayTracks.length;i++) {
    trackID = i;
    if (diffsec <= ArrayTracks[i][3]) {
        playTrackFrom();
        break;
    }
    
    diffsec -= ArrayTracks[i][3];
    
}

hourlySignal();

function playTrack(){
    audioDescription.innerHTML = '<a href="https://commons.wikimedia.org/wiki/File:' + ArrayTracks[trackID][1].replace(/ /g,'_') + '">' + ArrayTracks[trackID][0] + '</a>';
    audioPlayer.src = 'https://upload.wikimedia.org/wikipedia/commons/' + ArrayTracks[trackID][2][0] + '/' + ArrayTracks[trackID][2] + '/' + ArrayTracks[trackID][1].replace(/ /g,'_');
    audioPlayer.play();
    audioPlayer.ondurationchange = function() {
        audioPlayer.pause();
        audioPlayer.currentTime = 0;
        audioPlayer.play();
    }
    audioPlayer.onended = function(){
        if (trackID < ArrayTracks.length - 1) {
            trackID++;
        } else {
            trackID = 0;
        }
        playTrack();
    }
}

function playTrackFrom(){
    playTrack();
    audioPlayer.ondurationchange = function() {
        audioPlayer.pause();
        audioPlayer.currentTime = diffsec;
        audioPlayer.play();
    }
}

function playHourlySignal(){
    audioPlayerAux.src = 'https://upload.wikimedia.org/wikipedia/commons/2/26/Busy_tone_%28France%29.ogg';
    audioPlayerAux.play();
    setTimeout(hourlySignal, 5000);
}

function hourlySignal(){
    var d = new Date();
    var min = d.getMinutes();
    var sec = d.getSeconds();

    if ((min == '59') && (sec == '59')) {
        playHourlySignal();
    }else{
        setTimeout(playHourlySignal,(60*(59-min)+(59-sec))*1000);
    }
}
//Volume control
volumeslider = document.getElementById("volumeslider");
function setvolume(){
	audioPlayer.volume = volumeslider.value / 100;
}
volumeslider.addEventListener("change",setvolume,false);

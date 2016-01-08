var defaultList = 'classic';
var audioPlayer = document.getElementById('audioPlayer');
var audioDescription = document.getElementById('audioDescription');
var audioPlayerAux = document.getElementById('audioPlayerAux');
var listening = document.getElementById('listening');
var commonsdomain = "https://commons.wikimedia.org";
//Volume control
volumeslider = document.getElementById("volumeslider");

//Get param from url
$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null)
       return null;
    
    return results[1] || 0;
}

//Get duration of all tracks to play
function getTotalDuration(JsonTracks)
{
    var totalLength = 0;
    $.each(JsonTracks, function(i, item) {
    	totalLength +=item.duration;
    });	
    return totalLength;
}

//Get difference time of local UTC time
function getDiffsec(totalLength)
{
	var date = new Date();
	var dateutc = date.toUTCString();
	var data = document.getElementById('data');
	var epoch = Math.round(new Date() / 1000);
	var diffsec = epoch % totalLength;
	return diffsec;
}

function playCurrent(diffsec,JsonTracks) {
    
	for (var trackID=0;trackID<JsonTracks.length;trackID++) {
	    
	    if (diffsec <= JsonTracks[trackID].duration) {
	        playTrackFrom(trackID,JsonTracks,diffsec);
	        break;
	    }
	    
	    diffsec -= JsonTracks[trackID].duration;
	}
	
	//hourlySignal();
}
//Create file link
function createLink (title)
{
   return '<a href="'+ commonsdomain +'/wiki/' + title + '" target="_blank">' + 
	            	  title.replace(/\.[^/.]+$/, "").replace("File:","")
	+ '</a>';

}

function addDescription(JsonTrack)
{

     $("#audioTitle" ).html(createLink (JsonTrack.title));
	            	 
      //Loading track description from commons
      $.get('playlist.php?getCommonsHtmlPage='+JsonTrack.title, function(data) {
      	   //Fixing commons links
      	   data = data.replace('"/wiki/','"'+commonsdomain+'/wiki/');
      	   data = data.replace('"/w/','"'+commonsdomain+'/w/');
           $(".content").html(data);
      });
}
function playTrack(trackID,JsonTracks){
   
    addDescription(JsonTracks[trackID]);
    audioPlayer.src = JsonTracks[trackID].url;
    audioPlayer.play();
    audioPlayer.ondurationchange = function() {
        audioPlayer.pause();
        audioPlayer.currentTime = 0;
        audioPlayer.play();
    }
    audioPlayer.onended = function(){
        if (trackID < JsonTracks.length - 1) {
            trackID++;
        } else {
            trackID = 0;
        }
        playTrack(trackID,JsonTracks);
    }
}

function playTrackFrom(trackID,JsonTracks,diffsec){
    playTrack(trackID,JsonTracks);
    audioPlayer.ondurationchange = function() {
        audioPlayer.pause();
        audioPlayer.currentTime = diffsec;
        audioPlayer.play();
    }
}

function playHourlySignal(){
    audioPlayerAux.src = 'https://upload.wikimedia.org/wikipedia/commons/0/0f/Gts_%28bbc%29_pips.ogg';
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

function setvolume(){
	audioPlayer.volume = volumeslider.value / 100;
}

var getList = ($.urlParam('channel') == null) ? (defaultList) : $.urlParam('channel');
//var getList = 'test';

volumeslider.addEventListener("change",setvolume,false);

$.getJSON( "playlist.php", { getList: getList} )
  .done(function( JsonTracks ) {
    
    var totalLength = getTotalDuration(JsonTracks);
    
    var diffsec = getDiffsec(totalLength);
    
    playCurrent(diffsec,JsonTracks);
    
    $("#youare" ).html('You are listening');
    
  })
  .fail(function( jqxhr, textStatus, error ) {
    var err = textStatus + ", " + error;
    console.log( "Request Failed: " + err );
});

//Loading stations
$.get('playlist.php?getHtmlPageContent=Template:Wikiradio_(tool)/stations', function(data) {
           $("#channels" ).html(data);
        }
      );
        
$(".header").click(function () {

    $header = $(this);
    //getting the next element
    $content = $header.next();
    //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
    $content.slideToggle(500, function () {
        //execute this after slideToggle is done
        //change text of header based on visibility of content div
        $header.text(function () {
            //change text based on condition
            return $content.is(":visible") ? "<< Hide" : "More details >>";
        });
    });

});

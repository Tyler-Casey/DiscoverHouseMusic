// This is the first JS app I have ever written. It's probably horrible, don't shoot me.


function nextSong(startup){

	var audioPlayer = document.getElementsByTagName('audio')[0];
	audioPlayer.pause();

	// if (startup){
	// 	audio.currentTime = 0;
	// }


	$.ajax({
		url: "get.php",
		dataType: "text",
		success: function(data) {

			var json = $.parseJSON(data);

			$( ".title" ).text(json.title.replace(/&amp;/g, '&'));
			$( ".artist" ).text(json.artist.replace(/&amp;/g, '&'));
			$( ".external" ).attr({href: json.link});
			$( ".image" ).attr({src: json.coverArt});
			audio.src = json.stream;
		}
	});

	audio.play();

}

document.getElementById('audio').addEventListener("ended",function() {

	// call function which gets streaming URL. Pass return value to this.src
	this.pause();
	nextSong();

});
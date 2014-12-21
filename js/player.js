function nextSong(){

	var audioPlayer = document.getElementsByTagName('audio')[0];
	audioPlayer.pause();
	audio.currentTime = 0;

	$( ".title" ).text("Waves");
	$( ".artist" ).text("Mr. Probz");
	$( ".image" ).attr({src: "https://i1.sndcdn.com/artworks-000046994348-5e13ox-large.jpg"});
	audio.src = "https://api.soundcloud.com/tracks/90390073/stream?client_id=cbcbab13c65251b27d8cd1b527dbbd0f";

	audio.play();

}

document.getElementById('audio').addEventListener("ended",function() {

	// call function which gets streaming URL. Pass return value to this.src
	nextSong();

});
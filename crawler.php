<?php
include 'simplehtmldom.php';
include 'credentials.php';

$mysql = new PDO($mydqldns, $mysqlusername, $mysqlPassword);
$mysql->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



function cleanString($string){
	$bad = array("\t", "\n", "  ");
	$string = str_replace($bad, "", $string);
	return $string;
}


$html = file_get_html("http://www.shazam.com/charts/genre/dance-us");
foreach($html->find('article[class=ti__container]') as $article) {

	$title = cleanString($article->find('p', 0)->plaintext);
	$artist = cleanString($article->find('p[class=ti__artist]', 0)->plaintext);
	$search = "https://api.soundcloud.com/tracks.json?q=". rawurlencode($title) ."-". rawurlencode($artist) ."&client_id=".$clientID;
	$search = json_decode(file_get_contents($search), true);
	$coverArt = $search[0]['artwork_url'];
	$link = $search[0]['permalink_url'];
	$stream = $search[0]['stream_url']; //."?client_id=".$clientID;


	try {
		$query = $mysql->prepare('INSERT INTO songs(title, artist, coverArt, stream, link) VALUES (:title, :artist, :coverArt, :stream, :link)');
		$query->execute(array('title' => $title, 'artist' => $artist, 'coverArt' => $coverArt, 'stream' => $stream, 'link' => $link));
	} catch (Exception $e) {
		echo 'Caught exception for '. $title ." ".  $e->getMessage() ."\n";
	}


}


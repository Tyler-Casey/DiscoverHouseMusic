<?php
include 'credentials.php';

$mysql = new PDO($mydqldns, $mysqlusername, $mysqlPassword);
$mysql->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = $mysql->prepare('SELECT * FROM songs ORDER BY RAND() LIMIT 1');
$query->execute();
	foreach ($query as $song) {

		$stream = $song['stream'];
		// echo $stream;

		$ch = curl_init();
		$timeout = 1;
		curl_setopt($ch, CURLOPT_URL, $stream."?client_id=".$clientID);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($data, true);
		$stream = $response['location'];


		echo json_encode(array("title" => $song['title'], "artist" => $song['artist'], "coverArt" => $song['coverArt'], "stream" => $stream, "link" => $song['link']));
	}
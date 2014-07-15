<!doctype html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9"> <![endif]-->
<!--[if IE 9]>         <html class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<title>Basic Soundcloud HTML5 Audio Player</title>
		<meta name="description" content="This is some stripped down code that will allow you to access tracks from a Soundcloud playlist and play them in an HTML5 audio player." />
	</head>
	<body>
		<audio controls>
			<source class="mp3" src="#" type="audio/mpeg">
		Your browser does not support the audio element.
		</audio>			
		<?php
		define("CLIENT_ID", "Add client ID here");
		define("USER_ID", "Add user ID here");

		$url = "https://api.soundcloud.com/users/".USER_ID."/playlists.json?client_id=".CLIENT_ID;
		
		$curlHandler = curl_init();
		curl_setopt($curlHandler, CURLOPT_HTTPHEADER, array('Accept: application/xml'));
		curl_setopt_array($curlHandler,array(CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_TIMEOUT => 90,
		CURLOPT_HEADER => true));
		curl_setopt($curlHandler, CURLOPT_URL, $url);
		
		$response = curl_exec($curlHandler);
		$info = curl_getinfo($curlHandler);
		$errno = curl_errno($curlHandler);
		$errorString = curl_error($curlHandler);
		curl_close($curlHandler);
		$response = preg_split('/\[/',$response,2);
		$response =  "[".$response[1];
		$response = json_decode($response,true);
		$response =  $response[0]['tracks'];
		echo "<ul>\r\n";
		foreach($response as $song){
				echo "<li><a href=\"{$song['uri']}/stream?client_id=".CLIENT_ID."\">{$song['title']}</a></li>\r\n"; 
		}
		echo "</ul>\r\n";
		?>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<script>
		var a = $('audio');      
		$(function(){
			$(document).on('click','.music a',function(el) {
				el.preventDefault();
			    $('.mp3').attr('src',$(this).attr('href'));
			    a[0].pause();
			    a[0].load();
			    a[0].play();
			});
		});
		</script>
	</body>
</html>
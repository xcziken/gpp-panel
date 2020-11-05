<?php
	error_reporting(0);
	require_once('config/db.php');

	$player_name = $_GET[ 'uid' ];

	$player_name = trim($player_name);
	$player_name = mysqli_real_escape_string($connection, $player_name);

	$query = "SELECT `login`, `exp`, `pieniadze`, `godziny`, `minuty`, `top-hs`, `walizka`, `bear`, `kills`, `deaths` FROM `samp_players` WHERE id = '$player_name'";  
	$result = mysqli_query($connection, $query );

	if(mysqli_num_rows($result) == 1) 
	{
		header('Content-Type: image/png;');
		$im = imagecreatefrompng('img/signature.png'); 
	   
		$text_color = imagecolorallocate($im, 255, 255, 255);//color black
		
		$font = realpath('Roboto.ttf');
		
		$row = mysqli_fetch_array($result);
		
		imagettftext($im, 14, 0, 50, 30, $text_color, $font, 	$row['login']);
		imagettftext($im, 11, 0, 50, 60, $text_color, $font, 	"EXP: ".$row['exp']);
		imagettftext($im, 11, 0, 50, 80, $text_color, $font, 	"PIENIADZE: ".$row['pieniadze']);
		imagettftext($im, 11, 0, 50, 100, $text_color, $font, 	"CZAS ONLINE: ".$row['godziny']."h ".$row['minuty']." min");
		imagettftext($im, 11, 0, 50, 120, $text_color, $font, 	"HEADSHOTY: ".$row['top-hs']);
		
		imagettftext($im, 11, 0, 300, 60, $text_color, $font, 	"WALIZKI: ".$row['walizka']);
		imagettftext($im, 11, 0, 300, 80, $text_color, $font, 	"MISIE: ".$row['bear']);
		imagettftext($im, 11, 0, 300, 100, $text_color, $font, 	"ZABOJSTW: ".$row['kills']);
		imagettftext($im, 11, 0, 300, 120, $text_color, $font, 	"ZGONOW: ".$row['deaths']);
		
		imagettftext($im, 9, 0, 390, 145, $text_color, $font, "www.gpp-samp.pl");
		
		imagepng($im);
		imagedestroy($im);
	} 

?>

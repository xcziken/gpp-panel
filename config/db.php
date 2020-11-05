<?php
	error_reporting(0);
	
	$connection = mysqli_connect('host', 'uzytkownik', 'haslo'); 
	$dbSelector = mysqli_select_db($connection, 'baza'); 
	mysqli_query($connection, "set names 'utf8'");
?>
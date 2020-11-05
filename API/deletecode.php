<?php
	session_start();
	require_once('../config/functions.php');	
    if(!amIAdmin()) { die(); } if($_SESSION['rank'] < 3) { die(); }
	require_once('../config/db.php');
	
	

	$id = mysqli_real_escape_string($connection, $_POST['delete_id']);

						

	$select = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe` WHERE id='".$id."'");

	$queryRes = mysqli_fetch_array($select);

			

	if(mysqli_num_rows($select)) {

		mysqli_query($connection, 'DELETE FROM `panel_kody_rabatowe` WHERE id='.$id);

	}	

?>
<?php
	session_start();
	require_once('../config/functions.php');	
	if(!amIAdmin()) { die(); } if($_SESSION['rank'] < 2) { die(); }
	require_once('../config/db.php');
	
	

	$uid = mysqli_real_escape_string($connection, $_POST['delete_id']);

						

	$select = mysqli_query($connection, "SELECT * FROM samp_bans WHERE id='".$uid."'");

	$queryRes = mysqli_fetch_array($select);

			

	if(mysqli_num_rows($select)) {

		mysqli_query($connection, 'DELETE FROM samp_bans WHERE id='.$uid);

	}	

?>
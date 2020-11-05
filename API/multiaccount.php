<?php	
session_start();
require_once('../config/functions.php');
if(!amIAdmin()) { die(); } 

require_once('../config/db.php');



if(isset($_GET['name']))

{

			
	$query = mysqli_query($connection, "SELECT t2.login, t2.register, IFNULL(t3.id, -1) ban, t3.admin, t3.powod FROM samp_players t1 LEFT OUTER JOIN samp_players t2 ON t2.pass = t1.pass AND t2.serial = t1.serial OR t2.logged_ip = t1.logged_ip LEFT OUTER JOIN samp_bans t3 ON nick = t2.login WHERE t1.login = '".$_GET['name']."' ORDER BY t2.id DESC");

				

	while($queryRes = mysqli_fetch_array($query)) {
	

	if($queryRes['ban'] != -1) { 
		$banned = 1; 
	} else { 
		$banned = 0;
	}
	?>

	<div class="row">

	<?php

		echo '<div class="col"><p class="text-left">'.$queryRes['login']; 
		if($banned == 1) { 
			echo ' <span class="badge badge-danger">Zbanowany</span>';
		}
		echo '</p></div>';

		echo '<div class="col">'.$queryRes['register'].'</div>';

	?>

	</div>

	<?php

	}

}



?>


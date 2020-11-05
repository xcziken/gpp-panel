<?php
	if(isset($_SESSION['logged']))
	{
		if($_SESSION['logged'])
		{
			session_unset();
			session_destroy();
			header("Location: index.php"); 
		}
	}
?>
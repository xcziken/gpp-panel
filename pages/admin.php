<?php
	require("config/SampRcon.class.php");
	
	if(isset($_SESSION['logged']) and $_SESSION['logged'])
	{
		if($_SESSION['rank'] < 2)
		{
			echo '
				<div class="alert alert-warning" role="alert">
				Nie jesteś vice head adminem.
				</div>
			';
			header('Refresh: 1; URL=index.php');
		}
		else
		{
			if(!isset($_GET['id']) || !isset($_GET['action'])) {
				echo '
				<div class="alert alert-warning" role="alert">
					Nieprawidłowe dane.
				</div>
				';
				header('Refresh: 1; URL=index.php');
			}
			else
			{
				$query = new SampRcon("80.72.41.158", 7765, "z2OyX3Ci");
				
				if ($query->connect()) {
					if($_GET['action'] == 1) 
					{
						$query->kick($_GET['id']);
						
						echo '<div class="alert alert-success" role="alert">
						Wyrzucono gracza z serwera.
						</div>';
						header('Refresh: 1; URL=index.php');
					}
					else if($_GET['action'] == 2)
					{
						$query->ban($_GET['id']);
						$query->reloadBans();
						
						echo '<div class="alert alert-success" role="alert">
						Gracz został zbanowany.
						</div>';
						
						header('Refresh: 1; URL=index.php');
					}
				}
				else
				{
					echo '
					<div class="alert alert-warning" role="alert">
						Wystąpił błąd podczas połączenia z serwerem.
					</div>
					';
					header('Refresh: 1; URL=index.php');
				}
				
				$query->close();
			}
		}
	}
	else
	{
		echo '
			<div class="alert alert-warning" role="alert">
			Nie jesteś zalogowany na konto administratora.
		</div>
		';
		header('Refresh: 1; URL=index.php');
	}
?>
		 
	
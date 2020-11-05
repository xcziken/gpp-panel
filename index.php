<!DOCTYPE html>

<?php
	error_reporting(0);

	require_once('config/db.php');

	ob_start();

	session_start();

	ini_set('display_errors', 0);



	require_once('config/functions.php');

	if(getPanelConfig($connection, 'devmode') == 1) { if(!isset($_SESSION['devlogin'])) { header("Location: maintenance.php"); }} 

	if(!isset($_GET['page'])) { 
		unset($_SESSION['redirectionFile']);
	} else { 
		if($_GET['page'] != 'login') { 
			unset($_SESSION['redirectionFile']);
		}
	}

	if(isLoggedIn()) { 
	//powiadomienia queries
	$usernameSess = $_SESSION['nick']; 
		$powiadomieniaCounter = 0;
		if(amIAdmin()) { 
		$getSkladka = mysqli_query($connection, "SELECT skladka FROM `samp_admins` WHERE login = '".$usernameSess."' AND skladka between now() AND now() + INTERVAL 3 DAY OR login = '".$usernameSess."' AND skladka < now()");
		if(mysqli_num_rows($getSkladka) !=0) { 
			$powiadomieniaCounter++;
		}
		}

		$amIWinner = mysqli_query($connection, "SELECT * FROM `panel_loteria_old` WHERE lastwinnerid = '".$_SESSION['uid']."'");
		if(mysqli_num_rows($amIWinner) !=0) { 
			$powiadomieniaCounter++;
		}

		$getVIP = mysqli_query($connection, "SELECT viptime FROM `samp_players` WHERE login = '".$usernameSess."' AND viptime between now() AND now() + INTERVAL 3 DAY"); 
		if(mysqli_num_rows($getVIP) !=0) { 
			$powiadomieniaCounter++;
		}
		if(isset($_SESSION['devlogin'])) { 
			$powiadomieniaCounter++;
		}
	}

	

?>



<html lang="pl-PL">

<head>

	<!-- Required meta tags -->

	<meta charset="UTF-8">
		

	<meta name=”description” content=”Gold Party Polska - Polski serwer multiplayera SA:MP dla gry Grand Theft Auto San Andreas”>

	<meta name="distribution" content="global" />

	<meta name="keywords" content="samp,sa-mp,san,andreas,multiplayer,gta,grand,theft,auto,gpp,server,polski,gold,party,polska,server,dm,deathmatch,freeroam,mp,forum,strona,polskie" />



	<!-- Bootstrap CSS -->

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		

	<link rel="canonical" href="https://getbootstrap.com/docs/4.3/examples/sign-in/">



	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>



	<link href="https://forum.gpp-samp.pl/jscripts/fontawesome/css/all.css" rel="stylesheet">

	<script defer src="https://forum.gpp-samp.pl/jscripts/fontawesome/js/all.js"></script>

		

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css">



	<link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/navbar-fixed/">



	<link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Roboto:300&display=swap" rel="stylesheet">

	

	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>



	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


	<script src="https://www.google.com/recaptcha/api.js?render=6LcW78EUAAAAAIvCxU9WnM9DpVmwaQcQ0usfNyOm"></script>

	<script>

    grecaptcha.ready(function() {

    // do request for recaptcha token

    // response is promise with passed token

        grecaptcha.execute('6LcW78EUAAAAAIvCxU9WnM9DpVmwaQcQ0usfNyOm', {action:'validate_captcha'})

                  .then(function(token) {

            // add token value to form

            document.getElementById('g-recaptcha-response').value = token;

        });

    });

	</script>
	
	<link href="css/style.css?<?php echo time();?>" rel="stylesheet">

</head>



<body>

	<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark-transparent">



      <div class="collapse navbar-collapse" id="navbarCollapse">

       

	    <ul class="navbar-nav mr-auto">

			<li class="nav-item active">

				<a class="nav-link" href="index.php?page=glowna"><i class="fas fa-home"></i> Główna</a>

			</li>



			<li class="nav-item active">

				<a class="nav-link" href="https://forum.gpp-samp.pl/" target="_blank"><i class="fas fa-user-tie"></i> Forum</a>

			</li>



			

			<div class="btn-group">

				<li class="nav-item active">

					<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"><i class="fas fa-trophy"></i> TOP</a>



					<ul class="dropdown-menu">

						<a class="dropdown-item" href="index.php?page=top"><i class="fas fa-cubes"></i> Najlepsi gracze</a>

						<a class="dropdown-item" href="index.php?page=gangs"><i class="fas fa-book-dead"></i> Najlepsze Gangi</a>

						<div class="dropdown-divider"></div>

						<a class="dropdown-item" href="index.php?page=races"><i class="fas fa-car"></i> Wyścigi [/ws]</a>

					</ul>

				</li>

			</div>


			
			<?php if(getPanelConfig($connection, 'challengeoff') == 0) { ?>
			<li class="nav-item active">

				<a class="nav-link" href="index.php?page=challenge"><i class="fas fa-award"></i> Challenge</a>

			</li>
			<?php } ?>


					
			<li class="nav-item active">

			<a class="nav-link" href="index.php?page=sklep"><i class="fas fa-shopping-cart"></i> Sklep</a>

			</li>
						

			<?php if(isLoggedIn()) { if(checkAdmin($connection, $_SESSION['nick']) == true && !isset($_SESSION['admin'])) { ?>
			<li class="nav-item active">

			<a class="nav-link" href="index.php?page=alogin"><i class="fas fa-award"></i> Admin</a>

			</li>
			<?php
			} }
			?>
			
			<?php
			//dla admina
			if(isset($_SESSION['logged']) && isset($_SESSION['admin'])) {

			?>

			<div class="btn-group">

			<li class="nav-item active">



				<a class="btn btn-danger dropdown-toggle" href="#" id="acp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-tools"></i> ACP</a>



				<div class="dropdown-menu" aria-labelledby="acp">
				<a class="dropdown-item" href="index.php?page=bl"><i class="fas fa-skull-crossbones"></i> Czarna lista</a>
					<a class="dropdown-item" href="index.php?page=bans"><i class="fas fa-ban"></i> Lista banów</a>
					<?php
					if($_SESSION['rank'] > 1) { 
					?>
					<a class="dropdown-item" href="index.php?page=checkbanlist"><i class="fas fa-ban"></i> Oczekujący na banicje</a>
					
					<?php } ?>


					<a class="dropdown-item" href="index.php?page=admins"><i class="fas fa-list"></i> Administracja</a>
					<?php
					if($_SESSION['rank'] > 2) { ?>
					<a class="dropdown-item" href="index.php?page=head"><i class="fas fa-user-shield"></i> Panel Head-Admina</a>	
					<?php } ?>
					

				</div>



			</li>

			</div>

			<?php

			}

			?>

			
        </ul>
		



		<div id="search-container">

		<div class="row">

		<div class="input-group">

			<input type="text" style="width:180px;" onKeyUp="fx(this.value)" name="qu" id="qu" class="form-control ui-autocomplete-input" autocomplete="on" placeholder="Wprowadź nick.." tabindex="1">

  			<div class="input-group-append">

			

			<ul class="dropdown-menu" role="menu" id="fetch" style="width:200px;">

				<div id="livesearch"></div>

			</ul>

  			</div>

		</div>

		</div>

		</div>



		<form class="form-inline my-2 my-lg-0">

		<?php

			if(isset($_SESSION['logged'])){
			?>
				<li class="nav-item active navbartext">

				
				
				<div class="btn-group">

					<div class="dropdown">

						<a class="btn btn-danger dropdown-toggle" href="#" id="usercp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

							<i class="fas fa-user"></i> <?php echo $_SESSION['nick']; ?>

						</a>

						

						<div class="dropdown-menu <?php if(amIAdmin()) { echo 'admin'; } ?>" aria-labelledby="usercp">
							<a class="dropdown-item"><i class="fas fa-coins"> </i> <?php echo getPlayerStats($connection, $_SESSION['uid'], 'portfel'); ?>GP</a> 
							<a class="dropdown-item" href=index.php?page=sklep><i class="fas fa-shopping-cart"></i> Kup GP</a>
						<div class="dropdown-divider"></div>
							<a class="dropdown-item" href=index.php?page=profile&uid=<?php echo $_SESSION['uid']; ?>><i class="fas fa-id-card"></i> Mój profil</a>
							<?php
							if(amIAdmin()) { 
							?>
							<a class="dropdown-item" href=index.php?page=warns><i class="fas fa-exclamation-circle"></i> Ostrzeżenia i pochwały</a>
							<?php
							}
							?>
							<a class="dropdown-item" href=index.php?page=profilesettings><i class="fas fa-cog"></i> Ustawienia</a>
							<a class="dropdown-item" href="index.php?page=paymenthistory"><i class="fas fa-list"></i> Wpłaty</a>
							<div class="dropdown-divider"></div>

							<a class="dropdown-item" href="index.php?page=logout"><i class="fas fa-sign-out-alt"></i> Wyloguj się</a>

						</div>

					</div>

				</div>

				</li>
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active navbartext">
						<a class="nav-link" href="#"  data-toggle="modal" data-target="#powiadomienia"><i class="fas fa-bell"></i> <?php if($powiadomieniaCounter>0) { ?><span class="badge badge-danger"><?php echo $powiadomieniaCounter; ?></span><?php } ?></a>
					</li>
				</ul>
	

			<?php } else {

				echo '<li class="nav-item active"><a class="badge badge-success" href="index.php?page=login"><i class="fas fa-sign-in-alt"></i> Zaloguj się</a></li>';

			}

		?>

		</form>

      </div>

    </nav>

	

	<div id="page-content">

	<?php
	$getOgloszenie = getPanelConfig($connection, 'ogloszenie');
	if(!empty($getOgloszenie)) { 
			echo '<div class="alert alert-info">' . $getOgloszenie. '</div>';
	}
	?>

	<?php

		if (isset($_GET['page']))

			$page = $_GET['page'];

		else

			$page = 'glowna';

			

		if (preg_match('/^[a-z0-9\-]+$/', $page))

		{

			if(file_exists('pages/' . $page . '.php'))

			{ 

				$inserted = include('pages/' . $page . '.php');

				if (!$inserted)

					echo('Requested page was not found.');

			}

			else

			{

				die();

			}

		}

		else

		{

			echo('Invalid parameter.');

		}

	?>


	</div>



	<footer id="sticky-footer" class="py-4 bg-dark text-white-50">

	<div class="container">

		<div class="container text-center">

			<small>© 2020 Copyright <a href="https://gpp-samp.pl"> Gold Party Polska</a></small><br />
			<small>Wersja 1.07.3</small>

		</div>

	</div>

	</footer>

	

	<script type="text/javascript" id="cookieinfo"

		src="//cookieinfoscript.com/js/cookieinfo.min.js">

	</script>



</body>

</html>



<?php ob_end_flush(); ?>



<script>

function lightbg_clr() {

	$('#qu').val("");

	$('#livesearch').css({"display":"none"});	

	$("#qu").focus();

 };

 

function fx(str)

{

	var s1=document.getElementById("qu").value;

	var xmlhttp;



	if (str.length==0) {

		document.getElementById("livesearch").innerHTML="";

		document.getElementById("livesearch").style.border="0px";

		document.getElementById("livesearch").style.display="block";

		$('#fetch').hide();

		return;

	}

	if (window.XMLHttpRequest)

	{// code for IE7+, Firefox, Chrome, Opera, Safari

		xmlhttp=new XMLHttpRequest();

	}

	else

	{// code for IE6, IE5

		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

	}

	xmlhttp.onreadystatechange=function()

	{

		if (xmlhttp.readyState==4 && xmlhttp.status==200)

		{

			document.getElementById("livesearch").innerHTML=xmlhttp.responseText;

			document.getElementById("livesearch").style.display="block";

		}

	}

	xmlhttp.open("GET","API/search_ajax.php?n="+s1,true);

	xmlhttp.send();	

	$('#fetch').show();

}

</script>  


<?php 
if(isLoggedIn()) { ?>
<div class="modal fade" id="powiadomienia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

	<div class="modal-dialog" role="document">

    <div class="modal-content" style="width: 400px; height:auto; max-height: 400px;">

		<div class="modal-header">

        	<h5 class="modal-title" id="exampleModalLabel">Powiadomienia</h5>

        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">

          		<span aria-hidden="true">&times;</span>

        	</button>

     	</div>

		<div class="modal-body" style="overflow-y: auto;">

		<?php
	if(isset($_SESSION['admin'])) { 
		$skladka = mysqli_fetch_assoc($getSkladka);
		if(mysqli_num_rows($getSkladka) !=0) { 
			echo '<div class="alert alert-danger"><b>Uwaga!</b> Twoja składka traci ważność dnia ' . $skladka['skladka'] . '. Nie zapomnij o opłaceniu jej!</div>';
		}
	}
	if(isset($_SESSION['devlogin'])) { 
		echo '<div class="alert alert-warning"><b>Uwaga!</b> Jesteś w trybie developera. Strona jest widoczna tylko dla Ciebie. Uważaj co robisz! Testuj skrypt lokalnie.</div>';
	}
	if(isLoggedIn()) { 
		$vip = mysqli_fetch_assoc($getVIP); 
		if(mysqli_num_rows($getVIP) !=0) { 
			echo '<div class="alert alert-danger"><b>Uwaga!</b> Usługa VIP kończy ważność dnia ' . $vip['viptime'] . '</div>';
		}
		if(mysqli_num_rows($amIWinner) != 0) { 
			$winnerRes = mysqli_fetch_assoc($amIWinner); 
			echo '<div class="alert alert-success"><b>Gratulacje!</b> Wygrałeś ostatnią loterię! ' . $winnerRes['lastwinnergp']. 'GP zostało przypisane do Twojego konta.</div>';
		}
	}
	?>

      	</div>

	</div>
<?php } ?>
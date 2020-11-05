
<head>

	<title>Logowanie</title>



	<style>

		.form-signin {

		  width: 100%;

		  max-width: 330px;

		  padding: 15px;

		  margin: auto;

		}

		.form-signin .checkbox {

		  font-weight: 400;

		}

		.form-signin .form-control {

		  position: relative;

		  box-sizing: border-box;

		  height: auto;

		  padding: 10px;

		  font-size: 16px;

		}

		.form-signin .form-control:focus {

		  z-index: 2;

		}

		.form-signin input[type="email"] {

		  margin-bottom: -1px;

		  border-bottom-right-radius: 0;

		  border-bottom-left-radius: 0;

		}

		.form-signin input[type="password"] {

		  margin-bottom: 10px;

		  border-top-left-radius: 0;

		  border-top-right-radius: 0;

		}

	</style>

</head>



<body class="d-flex flex-column text-center">
<div class="alert alert-success">Logowanie dostępne także dla graczy! Zaloguj się używając swoich danych z serwera.</div>
<div class="starter-template">

<?php

	if(isset($_SESSION['logged'])) {
		echo 'Już jesteś zalogowany!';
	} else {
?>
<div class="container">
<div class="napis"><h1>Logowanie</h1></div>
		<form id="loginForm" class="form-signin" action="index.php?page=login" method="POST">

			

			<label for="inputEmail" class="sr-only">Email address</label>

			<input name="nick" id="inputEmail" class="form-control" placeholder="Nick na serwerze" required autofocus>

			<label for="inputPassword" class="sr-only">Password</label>

			<input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Hasło" required>


			<button class="btn btn-lg btn-primary btn-block" type="submit" name="ok">Zaloguj się</button>



			<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

    		<input type="hidden" name="action" value="validate_captcha">

		</form>

			

<?php
	if(isset($_GET['redirectto'])) { 
		if($_GET['redirectto'] == 'sklep') { 
			$_SESSION['redirectionFile'] = 'index.php?page=sklep';
		} elseif($_GET['redirectto'] == 'profilesettings') { 
			$_SESSION['redirectionFile'] = 'index.php?page=profilesettings';
		} elseif($_GET['redirectto'] == 'loteria') { 
			$_SESSION['redirectionFile'] = 'index.php?page=loteria';
		} else { 
			$_SESSION['redirectionFile'] = 'index.php';
		}
	}

		if(isset($_POST['ok'])) {

			if (isset($_POST['g-recaptcha-response'])) {

				$captcha = $_POST['g-recaptcha-response'];

			} else {

				$captcha = false;

			}

			

			if (!$captcha) {

				echo 'Błąd captcha';

				exit;

			} else {

				$secret   = '6LcW78EUAAAAAMgHoEMyGhFLhrahCJSvKkzH5IGn';

				$response = file_get_contents(

					"https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']

				);

				// use json_decode to extract json response

				$response = json_decode($response);

			

				if ($response->success === false) {

					echo 'Sprawdź poprawność captcha';

					exit;

				}

			}



			$nick = trim($_POST['nick']);

			$pass = trim($_POST['pass']);


			

		 

			if(empty($nick) || empty($pass) || $tryblogowania == '0') { 
				echo '<p>Uzupełnij wszystkie pola!</p>';
			} else {
				$nick = mysqli_real_escape_string($connection, $_POST['nick']);
				$pass = mysqli_real_escape_string($connection, $_POST['pass']);


			
				$pass = hash('whirlpool', $pass); 
				$result = mysqli_query($connection, "SELECT id, login, pass FROM samp_players WHERE login = '".$nick."' AND pass = '".$pass."'");
				

				if(mysqli_num_rows($result)==0) { 
					echo '<div class="alert alert-danger">Niestety podałeś niepoprawne dane!</p></div>'; 
				} else {

					$row = mysqli_fetch_array($result);

					$_SESSION['logged'] = true;

					$_SESSION['uid'] = $row['id'];

					$_SESSION['nick'] = $row['login'];
					
					$_SESSION['game'] = 'samp';
				


					$row = mysqli_fetch_array($result);
					


				

		 
					
					mysqli_free_result($result); 



					$redirectionDest = $_SESSION['redirectionFile'];
					if(isset($_SESSION['redirectionFile'])){
						header("Location: $redirectionDest"); 
					} else { 
						header("Location: index.php");
					}
		


				}

			}

		}

	}

?>

</div>
</div>


</body>



</body>


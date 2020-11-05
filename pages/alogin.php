
<?php
	if(!isLoggedIn()) { die(); }
	if(!checkAdmin($connection, $_SESSION['nick'])) { die(); }
?>
<head>

	<title>Logowanie administratora</title>



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

<div class="starter-template">

<?php

	if(isset($_SESSION['admin'])) {
		echo 'Już jesteś zalogowany!';
	} else {
?>
<div class="container">
		<form id="loginForm" class="form-signin" action="index.php?page=alogin" method="POST">

			<div class="napis"><h1 class="h3 mb-3 font-weight-normal">Logowanie administratora</h1></div>


			<label for="inputPassword" class="sr-only">Password</label>

			<input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Hasło" required>


			<button class="btn btn-lg btn-primary btn-block" type="submit" name="ok">Zaloguj się</button>



			<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">

    		<input type="hidden" name="action" value="validate_captcha">

		</form>

			

<?php

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




			$pass = trim($_POST['pass']);


			

		 

			if(empty($pass)) { 
				echo '<p>Uzupełnij wszystkie pola!</p>';
			} else {
				$pass = mysqli_real_escape_string($connection, $_POST['pass']);


				$mynickname = $_SESSION['nick'];
				$result = mysqli_query($connection, "SELECT id, login, rank FROM samp_admins WHERE login = '".$mynickname."' AND haslo = '".$pass."'");
				

				if(mysqli_num_rows($result)==0) { 
					echo '<div class="alert alert-danger">Niestety podałeś niepoprawne dane!</div>'; 
				} else {

					$row = mysqli_fetch_array($result);

					$_SESSION['admin'] = true;

					$_SESSION['id'] = $row['id'];
					$_SESSION['rank'] = $row['rank'];



				

		 

					header("Location: index.php"); 

					mysqli_free_result($result); 

				}

			}

		}

	}

?>
</div>
</div>

</body>


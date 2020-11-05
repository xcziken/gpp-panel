<?php
	echo '
		<html><head></head>
		<body>
			<form action="" method="post">
				Id klienta:
				<input type="text" name="client_id" /></br>
				PIN:
				<input type="text" name="pin" /><br/>
				Kod zwrotny:
				<input type="text" name="code" /><br/>
				<input type="submit" value="Sprawdź" />
			</form>
			<div id="output">
	';

	if(!strlen($_POST['client_id']) || !strlen($_POST['pin']) || !strlen($_POST['code']))
	{
		echo 'Pola nie zostały wypełnione.';
	}
	else
	{
		$client_id	= (INT)$_POST['client_id'];
		$pin 		= $_POST['pin'];
		$code		= $_POST['code'];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://rec.liveserver.pl/api?channel=sms&return_method=seperator');
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id='. $client_id .'&pin='. urlencode($pin) .'&code='. urlencode($code) .'');
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if($httpcode >= 200 && $httpcode < 300)
		{
			$recData = explode(' ', $data, 8);

			if(count($recData) < 8)
			{
				echo 'Błędnie podane dane.';
			}
			else
			{
				echo '
					Status: '. $recData[0] .'<br/>
					Numer Klienta: '. $recData[1] .'<br/>
					Kod zwrotny: '. $recData[2] .'<br/>
					Numer docelowy: '. $recData[4] .'<br/>
					Numer telefonu: '. $recData[3] .'<br/>
					UnixTime: '. $recData[5] .'<br/>
					Ilosc uzyc: '. $recData[6] .'<br/>
					Dodatkowy tekst: '. $recData[7] .'<br/>
				';
			}
		}
		else
		{
			echo 'Błąd połaczenia.';
		}
	}

	echo '</div></body></html>';
?>
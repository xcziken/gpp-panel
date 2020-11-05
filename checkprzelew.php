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
		curl_setopt($ch, CURLOPT_URL, 'https://rec.liveserver.pl/api?channel=online&return_method=http');
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id='. $client_id .'&pin='. urlencode($pin) .'&code='. urlencode($code));
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if($httpcode >= 200 && $httpcode < 300)
		{
			parse_str($data, $recData);

			if($recData['status'] == 'OK')
			{
				echo '
					Status: '. $recData['status'] .'<br/>
					Kod zwrotny: '. $recData['code'] .'<br/>
					Kwota: '. $recData['amount'] .'<br/>
					E-mail: '. $recData['email'] .'<br/>
					Unixtime: '. $recData['time'] .'<br/>
					Ilosc uzyc: '. $recData['read_count'] .'<br/>
				';
			}
			else
			{
				echo 'Kod niepoprawny';
			}
		}
		else
		{
			echo 'Błąd połaczenia.';
		}
	}

	echo '</div></body></html>';
?>
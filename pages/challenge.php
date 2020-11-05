<html>

<head>

	<title>Gold Party Polska - Challenge</title>

</head>



<body class="d-flex flex-column text-center">

<div class="container">
	<div class="napis"><h1>Aktualny status podium</h1></div>

	<?php
	$getChallengePodium = mysqli_query($connection, "SELECT * FROM `samp_players` WHERE challenge > 0 ORDER BY `challenge` DESC LIMIT 3");
	if(mysqli_num_rows($getChallengePodium) < 3) { 
		echo '<div class="alert alert-warning">Wyniki jeszcze niedostępne</div>';
	} else { 
	$challengePodiumPlace = 0; 
	$thirdChallengeWynik = 0;
	$thirdChallengenickname = 0;
	while($challengePodium = mysqli_fetch_array($getChallengePodium)) { 
	$challengePodiumPlace++
	?> <!-- row open --> 
	<?php
	if($challengePodiumPlace == 1) { 
		?>
			<div class="row">
		<div class="col">
		</div>
		<div class="col"> <!-- srodek strona --> 
			<?php
			if($challengePodium['skin'] > 299) { 
				$skinPodiumFirst = 0; 
			} else { 
				$skinPodiumFirst = $challengePodium['skin'];
			}
				echo '<img src="/img/skins/'.$skinPodiumFirst.'.png"" style="width: 500px; height: 400px;" /><img src="/img/first_place.png" />' . '<h1 class="text-white">' . $challengePodium['login'] . '</h1>';
				echo '<div class="alert alert-success" role="alert"><b>Aktualny wynik:</b> ' . $challengePodium['challenge'] . '</div>';
				echo '<div class="alert alert-info" role="alert"><b>Oczekiwana nagroda:</b> ' . getPanelConfig($connection, 'challenge_prize_1') . '</div>';
			?>
		</div>
		<div class="col">
		</div>
		</div> <!-- row close --> 
		<?php
	}
	if($challengePodiumPlace == 2) { 
		$challengePodiumSecondPlaceLogin = $challengePodium['login'];
		$challengePodiumSecondPlaceSkin = $challengePodium['skin']; 
		if($challengePodiumSecondPlaceSkin > 299) { 
			$challengePodiumSecondPlaceSkin = 0; 
		}
		$challengePodiumSecondPlaceWynik = $challengePodium['challenge'];
	}
	if($challengePodiumPlace == 3) { 
		$challengePodiumThirdPlaceLogin = $challengePodium['login'];
		$challengePodiumThirdPlaceSkin = $challengePodium['skin']; 
		if($challengePodiumThirdPlaceSkin > 299) { 
			$challengePodiumThirdPlaceSkin = 0; 
		}
		$challengePodiumThirdPlaceWynik = $challengePodium['challenge'];
	}
	?>
<?php } ?>
	<div class="row">
	<div class="col">
	<?php
		echo '<img src="/img/skins/'.$challengePodiumSecondPlaceSkin.'.png"" style="width: 500px; height: 400px;" /><img src="/img/second_place.png" />' . '<h1 class="text-white">' . $challengePodiumSecondPlaceLogin . '</h1>';
		echo '<div class="alert alert-success" role="alert"><b>Aktualny wynik:</b> ' . $challengePodiumSecondPlaceWynik . '</div>';
		echo '<div class="alert alert-info" role="alert"><b>Oczekiwana nagroda:</b> ' . getPanelConfig($connection, 'challenge_prize_2') . '</div>';
	?>
	</div>
	<div class="col">
	</div>

	<div class="col">
	<?php
		echo '<img src="/img/skins/'.$challengePodiumThirdPlaceSkin.'.png"" style="width: 500px; height: 400px;" /><img src="/img/third_place.png" />' . '<h1 class="text-white">' . $challengePodiumThirdPlaceLogin . '</h1>';
		echo '<div class="alert alert-success" role="alert"><b>Aktualny wynik:</b> ' . $challengePodiumThirdPlaceWynik . '</div>';
		echo '<div class="alert alert-info" role="alert"><b>Oczekiwana nagroda:</b> ' . getPanelConfig($connection, 'challenge_prize_3') . '</div>';
	?>
	</div>
	</div>
	<div class="row">
		<div class="textplace_soft">
			<h3>Pozostałe miejsca</h3>
			
			<div class="table-responsive">

            <div class="table-wrapper-scroll-y nowosci-scrollbar">

            <table data-toggle="table" 

            data-classes="table table-hover table-condensed"

            data-striped="true"

            data-search="false"

            >
            <thead class="thead-dark">
            <tr>
				<th>#</th>
				<th>Nick</th>
				<th>Wynik</th>
            </tr>
            </thead>
            <tbody>
			<?php $getRest = mysqli_query($connection, "SELECT * FROM `samp_players` WHERE challenge > 0 ORDER BY `challenge` DESC LIMIT 3, 30"); 
			$startFrom = 4; 
			while($rest = mysqli_fetch_array($getRest)) { 
				?>
			<tr>
				<td><?php echo $startFrom; ?></td>
				<td><?php echo $rest['login']; ?></td>
				<td><?php echo $rest['challenge']; ?></td>
			</tr>
				<?php
			$startFrom++;
			}
			?>


			</tbody>
			</table>
			</div>
			</div>

		</div>
	</div>

	
	

		<?php } ?>

</div>

</body>

</html>
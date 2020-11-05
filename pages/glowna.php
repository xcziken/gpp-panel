<html>

<head>

	<title>Gold Party Polska - Strona głowna</title>

</head>

<body class="d-flex flex-column text-center">

<div class="container">


<div class="textplace_soft">

	<div class="row d-flex justify-content-between">

		<div class="col-sm">

			<?php 

				require "config/SampQuery.class.php";



				$query = new SampQuery("80.72.41.158", 7765);



				if ($query->connect()) { // If a successful connection has been made



					$aTotalPlayers = $query->getDetailedPlayers();

					$aInformation = $query->getInfo();



					$query->close(); // Close the connection
					

			?>

			<p class="h4">Gracze</p>

			<div class="table-responsive">

				<div class="table-wrapper-scroll-y my-custom-scrollbar">

					<table data-toggle="table" 

					   data-classes="table table-hover table-condensed"

					   data-striped="true"

					   data-search="false"

					>

					<thead class="thead-dark">

						<tr>

							<th scope="col">ID</th>

							<th scope="col">Nick</th>

							<th scope="col">Level</th>

						</tr>

					</thead>

					<tbody>



			<?php

					foreach($aTotalPlayers AS $id => $value){

			?>

					<tr>	
						<td><?php echo $value['playerid']; ?></td>

						<td><?php echo htmlentities($value['nickname']); ?></a></td>

						<td><?php echo $value['score']; ?></td>

					</tr>

			<?php

					}

			?>

					</tbody>

					</table>

				</div>

			</div>

			<?php

				} else {

					echo "Server did not respond!";

				}

			?>

		</div>



		<div class="col-sm">

			<p class="h4">Discord</p>

			<iframe src="https://discordapp.com/widget?id=582183422957715457&theme=dark" height="500" allowtransparency="true" frameborder="0"></iframe>

		</div>

		<div class="col-sm">
			<p class="h4">Loteria</p>
			<div class="card border-info mb-3" style="width: 18rem;">
			<div class="card-body">
			<?php
			$getLoteriaDetails = mysqli_query($connection, "SELECT count(id) AS ilosc FROM `panel_loteria_wpisy`");
			if(isLoggedIn()) { 
				$getmojudzial = mysqli_query($connection, "SELECT * FROM `panel_loteria_wpisy` WHERE userid = '".$_SESSION['uid']."'");
				$mojudzial = mysqli_num_rows($getmojudzial) * 10;
			}
			$getOldLoteriaDetails = mysqli_query($connection, "SELECT * FROM `panel_loteria_old`"); 
			$loteriaDetails = mysqli_fetch_assoc($getLoteriaDetails);
			$oldLoteriaDetails = mysqli_fetch_assoc($getOldLoteriaDetails); 
			?>
				<h5 class="card-title">Aktualna pula: <?php echo $loteriaDetails['ilosc']*10;?>GP
				<?php if(isLoggedIn()) { if(mysqli_num_rows($getmojudzial)!=0) { ?> 
				<br />
				Twój udział: <?php echo mysqli_num_rows($getmojudzial)*10;?>GP<br>
				Możliwa wygrana: 
				<?php 
				$udzial = mysqli_num_rows($getmojudzial)*10;
				$pula = $loteriaDetails['ilosc']*10; 
				$zysk = $pula-$udzial;
				$podatek_od_zysku = ($zysk/100) * 15;
				$opodatkowany_zysk = $zysk - $podatek_od_zysku;
				$getGPToWin = $opodatkowany_zysk + $udzial;
				echo (int)$getGPToWin;
				?>GP<br />
				Szansa na wygraną: <?php echo round((mysqli_num_rows($getmojudzial)/$loteriaDetails['ilosc'])*100); ?>%
				<?php } } ?></h1>
				<h6 class="card-subtitle mb-2 text-muted">Kończy się: każdej nocy o 0:40</h6>
				<h6 class="card-subtitle mb-2 text-muted">Ostatni zwycięzca: <?php echo getPlayerStats($connection, $oldLoteriaDetails['lastwinnerid'], 'login'); ?></h6>
				<h6 class="card-subtitle mb-2 text-muted">Ostatnia wygrana: <?php echo $oldLoteriaDetails['lastwinnergp']; ?>GP</h6>
				<p class="card-text">Po zakończeniu loterii zostanie wybrana jedna osoba która wygra całą pulę pomniejszoną o podatek od zysku wynoszący 15%</p>
				<a href="index.php?page=loteria" class="btn btn-success">Wyślij los</a>
			</div>
			</div>
		</div>


		</div>
		<div class="row">
		<div class="col-sm">
		<p class="h4">Nowości <?php if(isLoggedIn()) { if(amIAdmin()) { if($_SESSION['rank'] >= 2) { ?><a href="index.php?page=managenowe"><button class="btn btn-primary">Zarządzaj</button></a> <?php } } }?></p>
		<div class="table-responsive">

			<div class="table-wrapper-scroll-y nowosci-scrollbar">

			<table data-toggle="table" 

			data-classes="table table-hover table-condensed"

			data-striped="true"

			data-search="false"

			>
			<thead class="thead-dark">
			<tr>
			<th></th>
			<th></th>
			<th>Co zostało dodane?</th>
			</tr>
			</thead>
			<tbody>
			<?php 
			$getNews = mysqli_query($connection, "SELECT `author`, `text`, `date`, (SELECT login FROM samp_players WHERE id = web_news.author) as author_name FROM `web_news` ORDER BY `id` DESC LIMIT 15");
			while($news = mysqli_fetch_array($getNews)){  ?>
			<tr>
			<td title="<?php echo $news['date']; ?>"><i class="fas fa-clock"></i></td>
			<td title="<?php echo $news['author_name']; ?>"><i class="fas fa-user"></i></td>
			<td title="<?php echo $news['date']; ?>"><?php echo $news['text']; if(strtotime($news['date']) > strtotime('-3 days')) { echo ' <span class="badge badge-success">Nowość!</span>'; }?></td>
			</tr>
			<?php } ?>
			</tbody>
			</table>

		</div>
		</div>
		

		</div>

	</div>

</div>

	

	<div class="container">



			<?php		

			$pos = 0;

			$dataPoints = array();



			$query = mysqli_query($connection, 'SELECT `gang1`, `score1`, `gang2`, `score2`, `time`, (SELECT name FROM gangs WHERE uid = samp_spar.gang1) as gangname1, (SELECT name FROM gangs WHERE uid = samp_spar.gang2) as gangname2 FROM `samp_spar` ORDER BY `id` DESC LIMIT 3');

		

			while($queryRes = mysqli_fetch_array($query)) { 

			$pos++;

			?>

			<div class="nk-match">

				<div class="nk-match-team-left">

					<a href=index.php?page=gang&uid=<?php echo $queryRes['gang1']; ?>>

						<span class="nk-match-team-name">

							<?php echo $queryRes['gangname1']; ?>

						</span>

					</a>

				</div>

				<div class="nk-match-status">

					<span class="nk-match-status-vs"><span class="badge badge-danger"><?php echo $queryRes['score1'].' : '.$queryRes['score2'] ?></span></span>

					<span class="nk-match-score bg-dark-1"><i class="fas fa-history"></i> <?php echo $queryRes['time']; ?></span>

				</div>

				<div class="nk-match-team-right">

					<a href=index.php?page=gang&uid=<?php echo $queryRes['gang2']; ?>>

						<span class="nk-match-team-name">

							<?php echo $queryRes['gangname2']; ?>

						</span>

					</a>

				</div>

			</div>

			<?php

				}

			?>

	</div>

</div>
</body>

</html>
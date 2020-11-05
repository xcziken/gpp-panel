<head>

    <script>

        $(document).ready(function ()

        {

            $("#fixTable").tableHeadFixer({"head": false, "left": 1});

            $("#fixTable2").tableHeadFixer({"head": false, "left": 1});

        });

    </script>

</head>



<body class="d-flex flex-column">

	<div class="container">

	<br />

	<?php

		

		if(isset($_GET['uid']))

		{

			$uid = mysqli_real_escape_string($connection, $_GET['uid']);

			

			$select = mysqli_query($connection, "SELECT 1 from gangs WHERE uid='".$uid."'");

			$data = mysqli_fetch_array($select);

			

			if(!mysqli_num_rows($select))

			{

				echo '

					<div class="alert alert-warning" role="alert">

						Gang o takim uid nie istnieje.

					</div>

				';

			}

			else 

			{

	?>

		<?php	

			$select = mysqli_query($connection, "SELECT name, tag, points, kills, deaths, date_created, max_slot, spar_win, spar_lose, expires from gangs WHERE uid='".$uid."'");

				

			$data = mysqli_fetch_array($select);

		?>

		<title>Gold Party Polska - Profil <?php echo $data['name'];?></title>

		


		
		<div class="container">
		<div class="napis"><p class="h1"><?php echo $data['name'].' ['.$data['tag'].']';?></p></div>
		<div class="textplace_soft">
		<div class="row">

			<div class="col-8">



				<div class="table-responsive">

				<div class="table-wrapper-scroll-y my-custom-scrollbar">

				<table  data-toggle="table" 

					data-classes="table table-hover table-condensed"

					data-striped="true"

					data-search="false"

				>

					<tbody>

						<tr><td>Punktów</td> <td><?php echo $data['points']; ?></td></tr>

						<tr><td>Zabójstw</td> <td><?php echo $data['kills']; ?></td></tr>

						<tr><td>Śmierci</td> <td><?php echo $data['deaths']; ?></td></tr>

						<tr><td>K/D</td> <td><?php if($data['kills'] > 0 && $data['deaths'] > 0) echo number_format($data['kills']/$data['deaths'], 2); else echo '0.0';?></td></tr>

						<tr><td>Data założenia</td> <td><?php echo $data['date_created']; ?></td></tr>

						<tr><td>Ilość slotów</td> <td><?php echo $data['max_slot']; ?></td></tr>

						<tr><td>Wygrane sparingi</td> <td><?php echo $data['spar_win']; ?></td></tr>

						<tr><td>Przegrane sparingi</td> <td><?php echo $data['spar_lose']; ?></td></tr>

						<tr><td>Ważność</td> <td><?php echo $data['expires']; ?></td></tr>

					</tbody>

				</table>

				</div>

				</div>



			</div>



			<div class="col">



				<div class="table-wrapper-scroll-y my-custom-scrollbar">

				<ul class="list-group">

					<?php		



					$rangi = [

						"0" => "Członek",

						"1" => "Elitarny Czlonek",

						"2" => "Vice Lider",

						"3" => "Lider",

						"4" => "Założyciel",

					];



					$query = mysqli_query($connection, "SELECT id, login, gang_rank from samp_players WHERE gang='".$uid."' ORDER BY `gang_rank` DESC");

					

					while($queryRes = mysqli_fetch_array($query)) { 

					?>



					<li class="list-group-item d-flex justify-content-between align-items-center">

						<a href=index.php?page=profile&uid=<?php echo $queryRes['id']; ?>><?php echo $queryRes['login']; ?></a>

						<span class="badge badge-primary badge-pill"><?php echo $rangi[$queryRes['gang_rank']]; ?></span>

					</li>



					<?php

					}

					?>

				</ul>

				</div>



			</div>

		</div>

		<?php

			}

		}

	?>

	</div>

	</div>
	</div>

	<br />



	<div class="container">

	<?php		

		$pos = 0;



		$query = mysqli_query($connection, 'SELECT `gang1`, `score1`, `gang2`, `score2`, `time`, (SELECT name FROM gangs WHERE uid = samp_spar.gang1) as gangname1, (SELECT name FROM gangs WHERE uid = samp_spar.gang2) as gangname2 FROM `samp_spar` WHERE gang1='.$uid.' OR gang2='.$uid.' ORDER BY `id` DESC LIMIT 3');

		

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

</body>
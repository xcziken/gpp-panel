<html>

<head>

	<title>Gold Party Polska - Challenge</title>

</head>



<body class="d-flex flex-column text-center">

	<div class="container">
	<div class="napis"><h1>Challenge</h1></div>

    <div class="textplace_soft">

	<h1 class="display-4"><i class="fas fa-crown"></i> Challenge <i class="fas fa-crown"></i></h1>



	<div class="row">

	<div class="col" >

	<p class="h4">Top</p>

	<div class="table-responsive">

	<div class="table-wrapper-scroll-y my-custom-scrollbar">

		<table data-toggle="table" 

		   data-classes="table table-hover table-condensed"

		   data-striped="true"

		>

		<thead class="thead-dark">

		<tr>

			<th class="col-xs-4" data-field="Nr" data-sortable="true">#</th>

			<th class="col-xs-4" data-field="Nazwa" data-sortable="true">Nick</th>

			<th class="col-xs-2" data-field="Punkty" data-sortable="true">Ilość</th>

		</tr>

		</thead>

		<tbody>



		<?php		

			$pos = 0;



			$query = mysqli_query($connection, 'SELECT `id`, `login`, `challenge` FROM `samp_players` ORDER BY `challenge` DESC LIMIT 20');

		

			while($queryRes = mysqli_fetch_array($query)) { 

			$pos++;

		?>

			<tr id="tr-id-2" class="tr-class-2">

				<td><?php echo $pos ?></td>

				<td><a href=index.php?page=profile&uid=<?php echo $queryRes['id']; ?>><?php echo $queryRes['login']; ?></a></td>

				<td><?php echo $queryRes['challenge']; ?></td>

			</tr>

		<?php



			}

		?>

		</tbody>    

		</table>

	</div>

	</div>

	</div>

	

	<div class="col">

		<p class="h4">Nagrody</p>


		<?php 
		$getNagrody = mysqli_query($connection, "SELECT * FROM `panel_settings`"); 
		$nagroda = mysqli_fetch_assoc($getNagrody); ?>
		<div class="alert alert-primary" role="alert">Miejsce pierwsze: <?php echo $nagroda['challenge_prize_1']; ?></div>

		<div class="alert alert-secondary" role="alert">Miejsce drugie: <?php echo $nagroda['challenge_prize_2']; ?></div>

		<div class="alert alert-danger" role="alert">Miejsce trzecie: <?php echo $nagroda['challenge_prize_3']; ?></div>

	</div>

	</div>

</div>

</div>

</div>

</body>

</html>
<head>

	<title>Gold Party Polska - Wyścigi</title>

</head>



<body class="d-flex flex-column text-center">

<main role="main" class="container">

<div class="napis"><h1>Wyścigi</h1></div>
<div class="textplace_soft">

	<div class="table-responsive">

	<div class="table-wrapper-scroll-y my-custom-scrollbar">

	<table data-toggle="table" 

		   data-classes="table table-hover table-condensed"

		   data-striped="true"

		   data-search="true"

	>

	<thead class="thead-dark">

		<tr>

			<th class="col-xs-4" data-field="Trasa" data-sortable="true">Trasa</th>

			<th class="col-xs-2">Pojazd</th>

			<th class="col-xs-2" data-field="Rekordzista" data-sortable="true">Rekordzista</th>

			<th class="col-xs-2" data-field="Czas" data-sortable="true">Czas</th>

		</tr>

	</thead>

	<tbody>

		

<?php		

	$query = mysqli_query($connection, 'SELECT id, name, model, winner, topsec, (SELECT login FROM samp_players WHERE id = samp_funre.winner) as topnick FROM `samp_funre` ORDER BY `id` ASC');

	while($queryRes = mysqli_fetch_array($query)) { 

?>

		<tr id="tr-id-2" class="tr-class-2">

			<td><?php echo $queryRes['name']; ?></td>

			<td><?php echo '<img src="img/vehicles/'.$queryRes['model'].'.jpg" class="w-25 p-3">' ?></td>

			<td><?php echo is_null($queryRes['topnick']) ? 'Brak' : '<i class="fas fa-trophy"></i> <a href=index.php?page=profile&uid='.$queryRes['winner'].'>'.$queryRes['topnick'].'</a>'; ?></td>

			<td><?php echo ($queryRes['topsec'] == 999) ? 'Brak' : hoursandmins($queryRes['topsec'], '%02d minut, %02d sekund'); ?></td>

		</tr>

<?php

	}

?>

	</tbody>

	</table>

	</div>

	</div>
</div>
</main>

</body>


<html>

<head>

	<title>Gold Party Polska - Lista gangów</title>

</head>



<body class="d-flex flex-column text-center">

	<div class="container">

	<div class="napis"><h1>Gangi</h1></div>
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

			<th class="col-xs-4" data-field="ID" data-sortable="true">ID</th>

			<th class="col-xs-4" data-field="Nazwa" data-sortable="true">Nazwa</th>

			<th class="col-xs-2" data-field="Punkty" data-sortable="true">Punkty</th>

			<th class="col-xs-2" data-field="Zalozyciel" data-sortable="true">Założyciel</th>

		</tr>

		</thead>

		<tbody>



		<?php		

			$query = mysqli_query($connection, 'SELECT uid, name, points, owner, (SELECT login FROM samp_players WHERE id = gangs.owner) as ownername FROM `gangs` ORDER BY `points` DESC');

		

			while($queryRes = mysqli_fetch_array($query)) { 

		?>

			<tr id="tr-id-2" class="tr-class-2">

				<td><?php echo $queryRes['uid']; ?></td>

				<td><a href=index.php?page=gang&uid=<?php echo $queryRes['uid']; ?>><?php echo $queryRes['name']; ?></a></td>

				<td><?php echo $queryRes['points']; ?></td>

				<td><a href=index.php?page=profile&uid=<?php echo $queryRes['owner']; ?>><?php echo $queryRes['ownername']; ?></a></td>

			</tr>

		<?php



			}

		?>

		</tbody>    

		</table>

	</div>

	</div>
		</div>
</div>

</body>

</html>
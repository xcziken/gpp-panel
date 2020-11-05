<?php if(!isLoggedIn()) { die(); } if(!amIAdmin()) { die(); } ?>
<head>

	<title>Administracja</title>

</head>



<body class="d-flex flex-column text-center">

<main role="main" class="container">

<?php

	if(isset($_SESSION['logged']) and $_SESSION['logged'])

	{

?>

<div class="napis"><h1>Administracja</h1></div>
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

			<th>Nick</th>

			<th>Ostatnia wizyta</th>

			<th>Czas miesiąc</th>

			<th>Punkty miesiąc</th>

			<th>Czas tydzień</th>

			<th>Punkty tydzień</th>

		</tr>

	</thead>

	<tbody>

		

<?php		

	$query = mysqli_query($connection, 'SELECT * FROM `samp_admins` ORDER BY `month_points` DESC');
	

	while($queryRes = mysqli_fetch_array($query)) { 
?>

		<tr>

			<td><?php echo $queryRes['login']; ?></a></td>

			<td><?php echo $queryRes['lastvisit']; ?></td>

			<td><?php echo hoursandmins($queryRes['month_minute'], '%02d godzin, %02d minut'); ?></td>

			<td><?php echo $queryRes['month_points']; ?></td>

			<td><?php echo hoursandmins($queryRes['week_minute'], '%02d godzin, %02d minut'); ?></td>

			<td><?php echo $queryRes['week_points']; ?></td>

		</tr>

<?php

	}

?>

	</tbody>

	</table>

	</div>

	</div>
</div>
<?php

	}

	else

	{

		echo '

			<div class="alert alert-warning" role="alert">

			Nie jesteś zalogowany na konto administratora.

		</div>

		';	

	}

?>

</main>

</body>


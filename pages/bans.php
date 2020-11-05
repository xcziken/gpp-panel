<!DOCTYPE html>
<?php if(!isLoggedIn()) { die(); } if(!amIAdmin()) { die(); } ?>
<head>

	<title>Lista banów</title>



	<script>

		function fetchData(clicked_id)

		{

			  $("#test").load("API/multiaccount.php?name="+clicked_id);

		}

	</script>


	<?php if($_SESSION['rank'] > 1) { ?>
	<script>

		function deleteBan(clicked_id)

		{

			if(confirm('Na pewno chcesz odbanować to konto?')) {



				$.ajax({



					type: "post",

					url: "API/deleteban.php",

					data:{delete_id:clicked_id},

					success:function(data) {



						$('#delete'+clicked_id).hide('slow');

						alert("Odbanowano konto");

					}

				});

			}

		}

	</script>

	<?php } ?>
</head>



<body class="d-flex flex-column text-center">

<main role="main" class="container">
<div class="napis"><h1>Lista banów</h1></div>
<div class="textplace_soft">
<div class="row">

<div class="col-sm">

<?php

	if(isset($_SESSION['logged']) and $_SESSION['logged'])

	{

?>

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

			<th class="col-xs-4" data-field="Nick" data-sortable="true">Nick</th>

			<th class="col-xs-4">Data</th>

			<th class="col-xs-2" data-field="Powod" data-sortable="true">Powod</th>

			<th class="col-xs-2" data-field="Admin" data-sortable="true">Admin</th>

			<th class="col-xs-2" data-field="Czas" data-sortable="true">Czas</th>

			<th class="col-xs-2" >MK</th>

			<?php

				if(isset($_SESSION['logged']) and $_SESSION['logged'])

				{

					if($_SESSION['rank'] > 1)

					{

			?>

			<th class="col-xs-2" >Akcja</th>

			<?php

					}

				}

			?>

		</tr>

	</thead>

	<tbody>

		

<?php		

	$query = mysqli_query($connection, 'SELECT * FROM `samp_bans` ORDER BY `id` DESC');

	while($queryRes = mysqli_fetch_array($query)) { 

?>

		<tr id="delete<?php echo $queryRes['id']; ?>" class="tr-class-2">

			<td><?php echo $queryRes['id']; ?></td>

			<td><?php echo $queryRes['nick']; ?></a></td>

			<td><?php echo $queryRes['data'] . ' ' . $queryRes['czas']?></td>

			<td><?php echo $queryRes['powod']; ?></td>

			<td><?php echo $queryRes['admin']; ?></a></td>

			<td><?php echo ($queryRes['unban'] == 0) ? 'Perm' : $queryRes['dni']; ?></td>

			<td><button id=<?php echo $queryRes['nick']; ?> onClick="fetchData(this.id)" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalLong">MK</button></td>

			<?php

				if(isset($_SESSION['logged']) and $_SESSION['logged'])

				{

					if($_SESSION['rank'] > 1)

					{

			?>

			<td><button onClick="deleteBan(<?php echo $queryRes['id']; ?>)" class="btn btn-danger btn-sm">UB</button></td>

			<?php

					}

				}

			?>

		</tr>

<?php

	}

?>

	</tbody>

	</table>

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





<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Multikonto</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div id="test" class="modal-body" style="height: 400px;overflow-y: auto;">

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

      </div>

    </div>

  </div>

</div>

</div>
</div>
</div>

</main>



</body>


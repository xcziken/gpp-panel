<?php 
	if(!isLoggedIn()) { die(); } if(!amIAdmin()) { die(); } if($_SESSION['rank'] < 2) { die(); } 
	$myusername = $_SESSION['nick'];
?>
<head>

<title>Gold Party Polska - Oczekujący na bana</title>	

<script>

		function deleteCheckBan(clicked_id)

		{

			if(confirm('Na pewno chcesz usunąć tego użytkownika z listy oczekujących na bana?')) {



				$.ajax({



					type: "post",

					url: "API/deletecheckban.php",

					data:{delete_id:clicked_id},

					success:function(data) {



						$('#delete'+clicked_id).hide('slow');

						alert("Odbanowano konto");

					}

				});

			}

		}

	</script>

</head>



<body class="d-flex flex-column text-center">

<div class="container">
<div class="napis"><h1>Oczekujący na banicje</h1></div>
<div class="textplace_soft">
<div class="row">

    <div class="col-sm">
	<div class="table-responsive">

				<div class="table-wrapper-scroll-y my-custom-scrollbar">
				<table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"data-search="false">
				<thead class="thead-dark">
					<tr>
					<th scope="col">Nick</th>
					<th scope="col">Czas trwania</th>
                    <th scope="col">Powód</th>
					<th scope="col">Dodany przez</th>
                    <th scope="col">Akcja</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$getcheckbans = mysqli_query($connection, "SELECT * FROM `samp_receivebans` ORDER BY `id` DESC"); 
					while($checkban = mysqli_fetch_array($getcheckbans)) { 
						?>
						<tr id="delete<?php echo $checkban['id'];?>">
							<td><?php echo $checkban['nick'];?></td>
							<td><?php echo $checkban['dni'];?></td>
							<td><?php echo $checkban['powod'];?></td>
							<td><?php echo $checkban['admin'];?></td>
							<td><button onClick="deleteCheckBan(<?php echo $checkban['id']; ?>)" class="btn btn-danger btn-sm">Usuń</button></td>
						</tr>
						<?php
					}
					?>
                </tbody>
                </table>
        </div><br /><br />



    <div class="table-responsive">

				<form method="POST">
				<table class="table table-striped">
				<thead class="thead-dark">
					<tr>
					<th scope="col">Nick</th>
					<th scope="col">Czas trwania</th>
                    <th scope="col">Powód</th>
                    <th scope="col">Akcja</th>
					</tr>
				</thead>
				<tbody>
                    <tr>
                        <td><input type="text" name="nick" placeholder="np. Arek_Kosmita" /></td>
						<td><input type="text" name="czas" placeholder="np. 3 lub 0 (0=perm)" /></td>
						<td><input type="text" name="powod" placeholder="np. Omijanie" /></td>
						<td><button class="btn btn-success">Dodaj</td>
                    </tr>
                </tbody>
                </table>
		</div>
		</div>
					<?php if(!empty($_POST['nick']) && !empty($_POST['powod'])) { 
						$nick = mysqli_real_escape_string($connection, $_POST['nick']); 
						$powod = mysqli_real_escape_string($connection, $_POST['powod']); 
						if(is_numeric($_POST['czas'])) { 
							$dni = mysqli_real_escape_string($connection, $_POST['czas']); 
							if($nick && $powod) { 
								if(empty($dni)) { 
									$dni = '0'; 
								}
								mysqli_query($connection, "INSERT INTO `samp_receivebans` (nick, dni,admin,powod) VALUES ('".$nick."', '".$dni."', '".$myusername."','".$powod."')");
								header("Location: index.php?page=checkbanlist");
							}	
						} else { 
							echo '<br /><span class="alert alert-danger">Czas trwania to nie cyfra</span>';
						}
					}
					?>
				</form>
   
   



	</div>

	</div>
	</div>
	</div>
</body>
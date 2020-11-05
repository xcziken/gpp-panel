<?php 
    if(!isLoggedIn()) { die(); } if(!amIAdmin()) { die(); } 
?>
<head>

<title>Gold Party Polska - Czarna lista</title>	

<?php if($_SESSION['rank'] > 2) { ?>
<script>

		function deleteBl(clicked_id)

		{

			if(confirm('Na pewno chcesz usunąć tego użytkownika z blacklisty?')) {



				$.ajax({



					type: "post",

					url: "API/deletebl.php",

					data:{delete_id:clicked_id},

					success:function(data) {



						$('#delete'+clicked_id).hide('slow');

						alert("Usunięto z blacklisty");

					}

				});

			}

		}

	</script>
<?php } ?>
</head>



<body class="d-flex flex-column text-center">

<div class="container">
<div class="napis"><h1>Czarna lista</h1></div>
<div class="textplace_soft">
<div class="row">

    <div class="col-sm">
    <div class="table-responsive">

				<div class="table-wrapper-scroll-y my-custom-scrollbar">
				<table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"data-search="false">
				<thead class="thead-dark">
					<tr>
					<th scope="col">Nick</th>
                    <th scope="col">Powód</th>
                    <th scope="col">Data</th>
                    <?php if($_SESSION['rank'] > 2) { ?>
                    <th scope="col">Akcja</th>
                    <?php } ?>
					</tr>
				</thead>
				<tbody>
                   <?php
                    $getbl = mysqli_query($connection, "SELECT * FROM `panel_bl` ORDER BY `id` DESC");
                    while($bl = mysqli_fetch_array($getbl)) { 
                        ?>
                        <tr id="delete<?php echo $bl['id'];?>">
                            <td><?php echo $bl['nick'];?></td>
                            <td><?php echo $bl['powod'];?></td>
                            <td><?php echo $bl['data'];?></td>
                            <?php if($_SESSION['rank'] > 2) { ?>
                            <td><button onClick="deleteBl(<?php echo $bl['id']; ?>)" class="btn btn-danger btn-sm">Usuń</button></td>
                            <?php } ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                </table>
        </div>
    </div><br><br>
    <?php 
    if($_SESSION['rank'] > 2) { ?>
    <form method="POST">
    <div class="table-responsive">
				<table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"data-search="false">
				<thead class="thead-dark">
					<tr>
					<th scope="col">Nick</th>
                    <th scope="col">Powód</th>
                    <th scope="col">Akcja</th>
					</tr>
				</thead>
				<tbody>
                
                   <tr>
                        <td><input type="text" name="nicki" class="form-control" placeholder="np. nick1, nick2, nick3" /></td>
                        <td><input type="text" name="powod" class="form-control" placeholder="np. Omijanie"/></td>
                        <td><button class="btn btn-success btn-sm">Dodaj</button></td>
                   </tr>
                
                </tbody>
                </table>
    </div>
    <?php
        if(!empty($_POST['nicki']) && !empty($_POST['powod'])) { 
            $nicki = mysqli_real_escape_string($connection, $_POST['nicki']); 
            $powod = mysqli_real_escape_string($connection, $_POST['powod']); 
            if($nicki && $powod) { 
                mysqli_query($connection, "INSERT INTO `panel_bl` (nick, powod) VALUES ('".$nicki."', '".$powod."')");
                header("Location: index.php?page=bl");
            }
        }        
    ?>
    </form>
    <?php } ?>
    
   

    </div>

</div>
</div>
</div>

</body>
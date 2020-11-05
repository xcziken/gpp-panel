<?php 
    if(!isLoggedIn()) { die(); } if(!amIAdmin()) { die(); } if($_SESSION['rank'] < 2) { die(); }
?>
<head>

<title>Gold Party Polska - Czarna lista</title>	

<?php if($_SESSION['rank'] >= 2) { ?>
<script>

		function deleteNowosci(clicked_id)

		{

			if(confirm('Na pewno chcesz usunąć ten wpis?')) {



				$.ajax({



					type: "post",

					url: "API/deletenowosci.php",

					data:{delete_id:clicked_id},

					success:function(data) {



						$('#delete'+clicked_id).hide('slow');

						alert("Usunięto z nowości");

					}

				});

			}

		}

	</script>
<?php } ?>
</head>



<body class="d-flex flex-column text-center">

<div class="container">

<div class="row">
<div class="textplace_soft">
<h3>Dodaj nowość</h1>
    <div class="col-sm">
    <form method="POST">
    <div class="table-responsive">
				<table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"data-search="false">
				<thead class="thead-dark">
					<tr>
					<th scope="col">Nowość</th>
					</tr>
				</thead>
				<tbody>
                    <tr>
                        <td><input name="nowosc" class="form-control"></textarea></td>
                    </tr>
                    <tr>
                        <td><button class="btn btn-success">Dodaj nowość</button></td>
                    </tr>
                </tbody>
                </table>
    </div>
    </form>
                    <?php 
                        if(!empty($_POST['nowosc'])) { 
                            $nowoscInput = mysqli_real_escape_string($connection, $_POST['nowosc']);
                            $uid = $_SESSION['uid'];
                            if($nowoscInput) { 
                                mysqli_query($connection, "INSERT INTO `web_news` (text,author) VALUES ('".$nowoscInput."','".$uid."')");
                                header("Location: index.php?page=managenowe");
                            }
                        }

                    ?><br /><br />
    <div class="table-responsive">

				<div class="table-wrapper-scroll-y my-custom-scrollbar">
				<table data-toggle="table" data-classes="table table-hover table-condensed" data-striped="true"data-search="false">
				<thead class="thead-dark">
					<tr>
					<th scope="col">Tekst</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Data</th>
                    <th scope="col">Akcja</th>
					</tr>
				</thead>
				<tbody>
                   <?php
                    $getnowosci = mysqli_query($connection, "SELECT `id`,`author`, `text`, `date`, (SELECT login FROM samp_players WHERE id = web_news.author) as author_name FROM `web_news` ORDER BY `id` DESC");
                    while($nowosc = mysqli_fetch_array($getnowosci)) { 
                        ?>
                        <tr id="delete<?php echo $nowosc['id'];?>">
                            <td><?php echo $nowosc['text'];?></td>
                            <td><?php echo $nowosc['author_name'];?></td>
                            <td><?php echo $nowosc['date'];?></td>
                            <?php if($_SESSION['rank'] >= 2) { ?>
                            <td><button onClick="deleteNowosci(<?php echo $nowosc['id']; ?>)" class="btn btn-danger btn-sm">Usuń</button></td>
                            <?php } ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                </table>
        </div>
    </div><br><br>


    </div>
    </div>
</div>

</div>

</body>
<?php 
    if(!isLoggedIn()) { die(); } if(!amIAdmin()) { die(); }  if($_SESSION['rank'] < 3) { die(); } $id = mysqli_real_escape_string($connection, $_GET['id']); $mynickname = $_SESSION['nick']; $nickname = getPlayerStats($connection, $id, 'login');
    
?>
<head>

<title>Gold Party Polska - Ostrzeżenia</title>	
<?php if($_SESSION['rank'] > 2) { ?>
	<script>

		function deleteWarn(clicked_id)

		{

			if(confirm('Na pewno chcesz usunąć to ostrzeżenie?')) {



				$.ajax({



					type: "post",

					url: "API/deletewarn.php",

					data:{delete_id:clicked_id},

					
					success:function(data) {



                    $('#delete'+clicked_id).hide('slow');


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

    <div class="col-sm">

    <h1>Ostrzeżenia <?php echo $nickname; ?></h1>
        <div class="textplace_soft">
            <div class="progress">
            <?php 
            $getWarns = mysqli_query($connection, "SELECT * FROM `panel_adminwarns` WHERE adminlogin = '".$nickname."' AND type = '1' ORDER BY `id` DESC");
            $getPochwaly = mysqli_query($connection, "SELECT * FROM `panel_adminwarns` WHERE adminlogin = '".$nickname."' AND type = '2' ORDER BY `id` DESC");
            $warnLow = 0; $warnMiddle = 0; $warnHigh = 0; $pochwalaLow = 0; $pochwalaMiddle = 0; $pochwalaHigh = 0; 
            while($warn = mysqli_fetch_array($getWarns)) { 
                if($warn['waga'] == 1) { 
                    $warnLow++;
                } elseif($warn['waga'] == 2) { 
                    $warnMiddle++;
                } else { 
                    $warnHigh++;
                }
            }
            $warnLowFactor = $warnLow * 15; 
            $warnMiddleFactor = $warnMiddle * 30; 
            $warnHighFactor = $warnHigh * 50; 
            $getProgressBarLength = $warnLowFactor + $warnMiddleFactor + $warnHighFactor;
            $pochwalyCounter = mysqli_num_rows($getPochwaly); 
            while($pochwala = mysqli_fetch_array($getPochwaly)) { 
                if($pochwala['waga'] == 1) { 
                    $pochwalaLow++;
                } elseif($pochwala['waga'] == 2) { 
                    $pochwalaMiddle++;
                } else { 
                    $pochwalaHigh++;
                }
            }
            $pochwalaLowFactor = $pochwalaLow * 10;
            $pochwalaMiddleFactor = $pochwalaMiddle * 25;
            $pochwalaHighFactor = $pochwalaHigh * 45;
            $getProgressBarReductorLength = $pochwalaLowFactor + $pochwalaMiddleFactor + $pochwalaHighFactor;
            $getProgressBarWholeLength = $getProgressBarLength-$getProgressBarReductorLength;

            ?>
                <div class="progress-bar" role="progressbar" style="width: <?php echo $getProgressBarWholeLength;?>%;  <?php if($getProgressBarLength < 40) { ?> background-color: green; <?php } elseif ($getProgressBarLength >= 40 && $getProgressBarLength < 70) { ?> background-color: orange; <?php } else { ?> background-color: red; <?php } ?>" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
                <div style="margin-left: 5%; position: absolute; font-size: 18px;<?php if($getProgressBarWholeLength < 40) { echo 'color:green;'; } ?>">Ranga bezpieczna</div>
                <div style="margin-left: 40%; position: absolute; font-size: 18px;<?php if($getProgressBarWholeLength >= 40 && $getProgressBarWholeLength <= 70) { echo 'color:orange;'; } ?>">Ranga średnio-zagrożona</div>
                <div style="margin-left: 75%; position: absolute; font-size: 18px; <?php if($getProgressBarWholeLength > 70) { echo 'color:red;'; } ?>">Ranga zagrożona</div><br /><br />

               </div><br />

            <div class="textplace_soft">
                <table class="table table-striped">
				<thead class="thead-dark">
                <tr>
                    <th scope="col">Treść</th>
                    <th scope="col">Typ</th>
                    <th scope="col">Data</th>
                    <th scope="col">Dodane przez</th>
                    <th scope="col">Waga</th>
                    <th scope="col">Akcja</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $myAdminID = $_SESSION['id'];
                $getWarns = mysqli_query($connection, "SELECT * FROM `panel_adminwarns` WHERE adminlogin = '".$nickname."' ORDER BY `id` DESC");
                while($warn = mysqli_fetch_array($getWarns)) { 
                ?>
                <tr id="delete<?php echo $warn['id']; ?>">
                <td><?php echo $warn['tekst']; ?></td>
                    <td><?php if($warn['type'] == 1) { echo '<span class="badge badge-danger">Ostrzeżenie</span>'; } else { echo '<span class="badge badge-success">Pochwała</span>'; } ?></td>
                    <td><?php echo $warn['data']; ?></td>
                    <td><?php echo $warn['addedby']; ?></td>
                    <td>
                    <?php
                    if($warn['type'] == 1) { 
                        if($warn['waga'] == 1) { 
                            echo '<font color="green"><b>Ostrzeżenie wagi lekkiej</b></font>';
                        } elseif($warn['waga'] == 2) { 
                            echo '<font color="orange"><b>Ostrzeżenie wagi średniej</b></font>';
                        } else { 
                            echo '<font color="green"><b>Ostrzeżenie wagi wysokiej</b></font>';
                        }
                    } else { 
                        if($warn['waga'] == 1) { 
                            echo '<font color="green"><b>Pochwała wagi lekkiej</b></font>';
                        } elseif($warn['waga'] == 2) { 
                            echo '<font color="orange"><b>Pochwała wagi średniej</b></font>';
                        } else { 
                            echo '<font color="red"><b>Pochwała wagi wysokiej</b></font>';
                        }
                    }
                    ?>
                    </td>
                    <td><button onClick="deleteWarn(<?php echo $warn['id']; ?>)" class="btn btn-danger">Usuń</button></td>
                </tr> 
                <?php } ?>
                </tbody>
                </table>
                <br />
                <h5>Dodaj ostrzeżenie</h5>
                <form method="POST">
                    <table border="0">
                        <tr>
                            <td><input class="form-control" name="tresc" style="width: 600px;" placeholder="Treść ostrzeżenia"/></td>
                            <td><select name="waga" class="form-control">
                                <option value="0" selected>
                                    Waga ostrzeżenia
                                 </option>
                                 <option value="1">
                                    Ostrzeżenie lekkie
                                 </option>
                                 <option value="2">
                                    Ostrzeżenie średnie
                                 </option>
                                 <option value="3">
                                    Ostrzeżenie znaczne
                                 </option>
                                 <option value="4">
                                    Pochwała lekka
                                 </option>
                                 <option value="5">
                                    Pochwała średnia
                                 </option>
                                 <option value="6">
                                    Pochwała znaczna
                                 </option>
                            </select></td>
                            <td><button type="submit" class="btn btn-success">Dodaj</button></td>
                    </tr>
                    </table>

                    <?php 
                    if($_POST['tresc'] && $_POST['waga']) { 
                        $tresc = mysqli_real_escape_string($connection, $_POST['tresc']); 
                        $waga = mysqli_real_escape_string($connection, $_POST['waga']); 
                        if($tresc && $waga) { 
                            if($waga >= 1 && $waga <= 3) { 
                                $type = 1; 
                            } else { 
                                $type = 2;
                                if($waga == 4) { 
                                    $waga = 1; 
                                } elseif($waga == 5) { 
                                    $waga = 2;
                                } else { 
                                    $waga = 3;
                                }
                            }
                            mysqli_query($connection, "INSERT INTO `panel_adminwarns` (tekst,type,data,waga,addedby,adminlogin) VALUES ('".$tresc."','".$type."',now(),'".$waga."','".$mynickname."','".$nickname."')");
                            header("Location: index.php?page=showwarnings&id=".$id);
                        }    
                    }
                    ?>
                </form>
            </div>


    </div>



</div>

</div>
</div>
</body>
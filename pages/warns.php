<?php 
    if(!isLoggedIn()) { die(); } if(!amIAdmin()) { die(); }  $mynickname = $_SESSION['nick'];
    
?>
<head>

<title>Gold Party Polska - Ostrzeżenia</title>	

</head>



<body class="d-flex flex-column text-center">

<div class="container">

<div class="row">

    <div class="col-sm">

    <div class="napis"><h1>Moje ostrzeżenia</h1></div>
        <div class="textplace_soft">
            <div class="progress">
            <?php 
            $getWarns = mysqli_query($connection, "SELECT * FROM `panel_adminwarns` WHERE adminlogin = '".$mynickname."' AND type = '1' ORDER BY `id` DESC");
            $getPochwaly = mysqli_query($connection, "SELECT * FROM `panel_adminwarns` WHERE adminlogin = '".$mynickname."' AND type = '2' ORDER BY `id` DESC");
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
        <div class="alert alert-success"><b>Czy wiesz że?</b> Dzięki pochwałom Twoje ostrzeżenia tracą na wartości. <?php if($getProgressBarReductorLength > 0) { ?>Dzięki Twoim pochwałom pasek ostrzeżeń zmniejsza się automatycznie o <?php echo $getProgressBarReductorLength; ?>% <?php } ?></div>
            <div class="textplace_soft">
                <table class="table table-striped">
				<thead class="thead-dark">
                <tr>
                    <th scope="col">Treść</th>
                    <th scope="col">Typ</th>
                    <th scope="col">Data</th>
                    <th scope="col">Waga</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $myAdminID = $_SESSION['id'];
                $getWarns = mysqli_query($connection, "SELECT * FROM `panel_adminwarns` WHERE adminlogin = '".$mynickname."' ORDER BY `id` DESC");
                while($warn = mysqli_fetch_array($getWarns)) { 
                ?>
                <tr>
                    <td><?php echo $warn['tekst']; ?></td>
                    <td><?php if($warn['type'] == 1) { echo '<span class="badge badge-danger">Ostrzeżenie</span>'; } else { echo '<span class="badge badge-success">Pochwała</span>'; } ?></td>
                    <td><?php echo $warn['data']; ?></td>
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
                </tr> 
                <?php } ?>
                </tbody>
                </table>
            </div>


    </div>



</div>

</div>
</div>
</body>
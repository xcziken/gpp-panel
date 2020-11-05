<?php 
    if(!isLoggedIn()) { header("Location: index.php?page=login&redirectto=loteria"); } $usernameuid = $_SESSION['uid'];
    
?>
<head>

<title>Gold Party Polska - Loteria</title>	

</head>



<body class="d-flex flex-column text-center">

<div class="container">

<div class="row">

    <div class="col-sm">

    <div class="napis"><h1>Loteria</h1></div>
    <div class="textplace_soft">
    <div class="row">
    <div class="col-sm">
        <h3>Loteria</h3>
        <p>Aby wziąć udział w loterii wybierz ilość losów i potwierdź przyciskiem:</p>
        <table border="0">
        <form method="POST">
            <tr>
            <td><b>Ilość losów:</b></td>
            <td><input name="ilosclosow" type="text" class="form-control" placeholder="max. 20" /></td>
            </tr>
            <tr>
                <td><b>Koszt jednego losu:</b></td>
                <td>10GP</td>
            </tr>
            <tr>
                <td><b>Dzienny limit GP:</b></td>
                <td><?php echo getPanelConfig($connection, 'loteria_daily_limit'); ?>GP</td>
            </tr>
            <tr>
                <td><b>Wykorzystane GP dzisiaj:</b></td>
                <td><?php $getMyGP = mysqli_query($connection, "SELECT kupionailosc FROM `panel_loteria_limits` WHERE userid = '".$usernameuid."'"); $myGP = mysqli_fetch_assoc($getMyGP); if(empty($myGP['kupionailosc'])) { echo '<font color="green"><b>Jeszcze nie zakupiłeś losów</b></font>'; } elseif($myGP['kupionailosc'] == getPanelConfig($connection, 'loteria_daily_limit')) { echo '<font color="red"><b>Limit dzienny wyczerpany</b></font>'; } else { echo $myGP['kupionailosc'] . 'GP'; }; ?></td>
            </tr>
            </table>
            <button class="btn btn-success">Kup los</button><br />
            <?php
            if($_POST['ilosclosow']) { 
            $ilosclosow = mysqli_real_escape_string($connection, $_POST['ilosclosow']); 
                if($ilosclosow > 0) { 
                if($ilosclosow <= 20) { 
                    $payGP = $ilosclosow * 10; 
                    $checkGP = mysqli_query($connection, "SELECT `portfel` FROM `samp_players` WHERE id = '".$usernameuid."'");
                    $gp = mysqli_fetch_assoc($checkGP);
                    
                    $checkDailyLimit = mysqli_query($connection, "SELECT kupionailosc FROM `panel_loteria_limits` WHERE userid = '".$usernameuid."'");
                    if(mysqli_num_rows($checkDailyLimit)==0) { 
                        mysqli_query($connection, "INSERT INTO `panel_loteria_limits` (userid, kupionailosc) VALUES ('".$usernameuid."', '".$payGP."')");
                    } else { 
                        $dailyLimit = mysqli_fetch_assoc($checkDailyLimit);
                        if($dailyLimit['kupionailosc']+$payGP > getPanelConfig($connection, 'loteria_daily_limit')) { 
                            echo '<br /><br /><span class="alert alert-danger">Kupując tą ilość losów przekroczysz swój dzienny limit wydanych GP.</span>';
                            $_SESSION['buyingNotAllowed'] = 1;
                        } elseif($dailyLimit['kupionailosc'] >= getPanelConfig($connection, 'loteria_daily_limit')) {
                            echo '<br /><br /><span class="alert alert-danger">Kupując tą ilość losów przekroczysz swój dzienny limit wydanych GP.</span>';
                            $_SESSION['buyingNotAllowed'] = 1;
                        } else {  
                            mysqli_query($connection, "UPDATE `panel_loteria_limits` SET kupionailosc = kupionailosc+'".$payGP."' WHERE userid = '".$usernameuid."'");
                        }
                    }
                
                if(!isset($_SESSION['buyingNotAllowed'])) { 
                    if($gp['portfel'] >= $payGP) { 
                        for($i=0; $i < $ilosclosow; $i++) { 
                            mysqli_query($connection, "INSERT INTO `panel_loteria_wpisy` (userid) VALUES ('".$usernameuid."')");
                        }
                        mysqli_query($connection, "UPDATE `samp_players` SET portfel = portfel-'".$payGP."' WHERE id = '".$usernameuid."'");
                        header("Location: index.php?page=loteria&g=success&gp=".$payGP);
                    } else { 
                        echo '<br /><br /><span class="alert alert-danger">Nie masz wystarczającej ilości GP aby wziąć udział w loterii. <a href="index.php">Powrót na stronę główną</a></span>'; 
                    }
                } else { 
                    unset($_SESSION['buyingNotAllowed']);
                }
                } else { 
                    echo '<br /><br /><span class="alert alert-danger">Ilość losów przy jednej wpłacie nie może być wyższa niż 20</span>';
                }
               } else { 
                echo '<br /><br /><span class="alert alert-danger">Ilość losów nie może wynosić 0</span>';
               } 
            }
            ?>
        </form><br />

        <?php
        if(isset($_GET['g'])) { 
            if($_GET['g'] == 'success') { 
                if(isset($_GET['gp'])) { 
                    $gpBought = $_GET['gp']; 
                    echo '<br /><br /><span class="alert alert-success">Dziękujemy za wzięcie udziału w loterii. Pobrano z Twojego konta ' . $gpBought . 'GP. <a href="index.php">Powrót na stronę główną</a></span>'; 
                }
            }
        }
        ?>
        <br /><br />
        <div class="alert alert-info" role="alert">
            Pamiętaj, że po kupnie losu nie możesz go z powrotem wycofać. Po wciśnięciu przycisku "Kup los" zostanie natychmiastowo pobrana wymagana ilość GP. W przypadku przegranej nie oferujemy zwrotów. Skrypt wybiera zwycięzcę losowo, a większa ilość losów pomaga w wygranej. 
        </div>
    </div>
    </div>
    </div>

    </div>



</div>

</div>
</div>
</body>
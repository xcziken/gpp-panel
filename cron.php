<?php 

    require_once('config/db.php');

    require_once('config/functions.php');

    date_default_timezone_set('Europe/Warsaw');


//LOSOWANIE LOTERII CODZIENNIE O 00:40
if(date('H') == '00') { 
    $getCount = mysqli_query($connection, "SELECT count(id) AS liczbawpisow FROM `panel_loteria_wpisy`"); 
    $losy = mysqli_fetch_assoc($getCount);
    if($losy['liczbawpisow']>0) { 
        $zwyciezcaWpis = rand(1,$losy['liczbawpisow']);
        $getWinner = mysqli_query($connection, "SELECT * FROM `panel_loteria_wpisy` WHERE id = '".$zwyciezcaWpis."'");
        $winner = mysqli_fetch_assoc($getWinner);
        $idwinner = $winner['userid'];
        $winnerLogin = getPlayerStats($connection, $winner['userid'],'login');
        $getudzial = mysqli_query($connection, "SELECT * FROM `panel_loteria_wpisy` WHERE userid = '".$idwinner."'");
        $u = mysqli_num_rows($getudzial);
        $udzial = $u * 10;
        $pula = $losy['liczbawpisow'] * 10; 
        $zysk = $pula-$udzial;
        $podatek_od_zysku = ($zysk/100) * 15;
        $opodatkowany_zysk = $zysk - $podatek_od_zysku;
        $GPToWin = $opodatkowany_zysk + $udzial;
        $getGPToWin = (int)$GPToWin;
        mysqli_query($connection, "UPDATE `samp_players` SET portfel = portfel+$getGPToWin WHERE id = '".$idwinner."'");
        $checkExistance_ol = mysqli_query($connection, "SELECT * FROM `panel_loteria_old`"); 
        if(mysqli_num_rows($checkExistance_ol) == 0) { 
            mysqli_query($connection, "INSERT INTO `panel_loteria_old` (lastwinnerid, lastwinnergp) VALUES ('".$idwinner."','".$getGPToWin."')");
        } else { 
            mysqli_query($connection, "UPDATE `panel_loteria_old` SET lastwinnerid = '".$winner['userid']."', lastwinnergp = '".$getGPToWin."'");
        }
        mysqli_query($connection, "TRUNCATE TABLE `panel_loteria_wpisy`"); 
        mysqli_query($connection, "DELETE FROM `panel_loteria_limits`");
    }    
}
//KONIEC LOSOWANIA

?>
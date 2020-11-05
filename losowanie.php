<?php
require_once('config/db.php');

require_once('config/functions.php');

$getGodzina = date('H');
    $getCount = mysqli_query($connection, "SELECT count(id) AS liczbawpisow FROM `panel_loteria_wpisy`"); 
    $losy = mysqli_fetch_assoc($getCount);
    if($losy['liczbawpisow']>0) { 
        $zwyciezcaWpis = rand(8,$losy['liczbawpisow']);
        $getWinner = mysqli_query($connection, "SELECT * FROM `panel_loteria_wpisy` WHERE id = '".$zwyciezcaWpis."'");
        $winner = mysqli_fetch_assoc($getWinner);
        $idwinner = $winner['userid'];
        $winnerLogin = getPlayerStats($connection, $winner['userid'],'login');
        $getGPToWin = $losy['liczbawpisow'] * 10; 
        echo 'Wygrałby: '. $idwinner . ' ' . $winnerLogin. ' '. $getGPToWin;
    }



?>
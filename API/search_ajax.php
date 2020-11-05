<?php
    require_once('../config/db.php');

    $s1 = mysqli_real_escape_string($connection, $_REQUEST["n"]);

    $sql = mysqli_query($connection, "SELECT `id`, `login` FROM `samp_players` WHERE `login` LIKE '%".$s1."%' ORDER BY `wizyt` DESC LIMIT 5") or die (mysqli_error());
   
    $s = "";

    while($row=mysqli_fetch_array($sql))
    {
        $s = $s."
        <li><a href='index.php?page=profile&uid=".$row['id']."'><button class='dropdown-item' type='button'>".$row['login']."</button></a></li>
        ";
    }

    $sql = mysqli_query($connection, "SELECT `uid`, `name` FROM gangs WHERE `name` LIKE '%".$s1."%' ORDER BY `points` DESC LIMIT 5");

    if(mysqli_num_rows($sql))
    {
        $s = $s.'<div class="dropdown-divider"></div>';

        while($row=mysqli_fetch_array($sql))    
        {
            $s = $s."
            <li><a href='index.php?page=gang&uid=".$row['uid']."'><button class='dropdown-item' type='button'>".$row['name']."</button></a></li>
            ";
        }
    }

    echo $s;
?>
<?php 
    if(!isLoggedIn()) { header("Location: index.php?page=login&redirectto=profilesettings"); }
    
?>
<head>

<title>Gold Party Polska - Ustawienia konta</title>	

</head>



<body class="d-flex flex-column text-center">

<div class="container">

<div class="row">

    <div class="col-sm">

    <div class="napis"><h1>Ustawienia konta</h1></div>
    <div class="textplace_soft">
    <div class="row">
    <div class="col-sm">
        <h3>Zmiana hasła</h2>
            <form method="POST">
                <table border="0">
                <tr>
                    <td><input type="password" name="haslocurrent" placeholder="Aktualne hasło" /></td>
                </tr>
                <tr>
                    <td><input type="password" name="haslofirst" placeholder="Hasło" /></td>
                </tr>
                <tr>
                    <td><input type="password" name="haslotwo" placeholder="Potwierdź hasło" /></td>
                </tr>
                </table><br>
                <button type="submit" class="btn btn-success">Zmień hasło</button>
                <?php 
                $usernickname = $_SESSION['nick'];
                if(isset($_POST['haslocurrent']) && isset($_POST['haslofirst']) && isset($_POST['haslotwo'])) { 
                    if(empty($_POST['haslocurrent']) || empty($_POST['haslofirst']) || empty($_POST['haslotwo'])) {
                        echo '<br /><br /><span class="alert alert-danger">Nie wypełniłeś wymaganych pól.</span>';
                    } else {  
                        $haslocurrent = hash('whirlpool', $_POST['haslocurrent']); 
                        $haslofirst = mysqli_real_escape_string($connection, trim($_POST['haslofirst'])); 
                        $haslotwo = mysqli_real_escape_string($connection, trim($_POST['haslotwo'])); 
                        $checkPasswordCorrect = mysqli_query($connection, "SELECT * FROM `samp_players` WHERE login = '".$usernickname."' AND pass = '".$haslocurrent."'");
                        if(mysqli_num_rows($checkPasswordCorrect) == 0) { 
                            echo '<br /><br /><span class="alert alert-danger">Aktualne hasło jest niepoprawne.</span>';
                        } else { 
                        if($haslofirst == $haslotwo) { 
                            $hashpass = strtoupper(hash('whirlpool', $haslofirst)); 
                            
                            mysqli_query($connection, "UPDATE `samp_players` SET pass = '".$hashpass."' WHERE login = '".$usernickname."'");
                            echo '<br /><br /><span class="alert alert-success">Hasło zostało zmienione</span>';
                        } else { 
                            echo '<br /><br /><span class="alert alert-danger">Wprowadzone hasła nie są takie same.</span>';
                        }
                    } 
                    }
                }
                
                ?>
            </form>
        </div>
        <?php if(isset($_SESSION['admin'])) { 
        $getAdminDetails = mysqli_query($connection, "SELECT * FROM `samp_admins` WHERE login = '".$usernickname."'");
        $adminDetails = mysqli_fetch_assoc($getAdminDetails);
        ?>
        <div class="col-sm">
        <form method="POST">
            <h3>Konto administratora</h3>
            <table border="0">
            <tr>
                <td><b>Składka ważna do: </b></td>
                <td><?php echo $adminDetails['skladka']; ?></td>
            </tr> 
            <tr>
                <td><b>Zmiana hasła admina: </b></td>
                <td><input type="password" name="hasloadm" placeholder="Nowe hasło" /></td>
            </tr>
            <tr>
                <td></td>
                <td><button type="submit" class="btn btn-success">Zmień</button></td>
            </tr>
            </table>
            
            <?php
            if(!empty($_POST['hasloadm'])) { 
                $hasloadm = mysqli_real_escape_string($connection, $_POST['hasloadm']); 
                if($hasloadm) { 
                    mysqli_query($connection, "UPDATE `samp_admins` SET haslo = '".$hasloadm."' WHERE login = '".$usernickname."'");
                    echo '<span class="alert alert-success">Hasło administratora zmienione</span>';
                }
            }
        ?>
        </form>
        </div>
        </div>
        <?php } ?>
    </div>

    </div>



</div>

</div>
</div>
</body>
<?php
require_once('config/db.php');
?>
<html>
<head>
<title>Devlogin - GPP</title>
</head>
<body style="background-color: #000; color: #fff;">
<form method="POST">
    <table border="0">
        <tr>
            <td>Login: </td>
            <td><input type="text" name="login" /></td>
        </tr>
        <tr>
            <td>Hasło: </td>
            <td><input type="password" name="haslo" /></td>
        </tr>
    </table>
    <input type="submit" value="Stwórz sesje" />
    <?php
        if(!empty($_POST['login']) && !empty($_POST['haslo'])) { 
            $login = mysqli_real_escape_string($connection, $_POST['login']); 
            $haslo = mysqli_real_escape_string($connection, $_POST['haslo']);
            if($login && $haslo) { 
                $checkcred = mysqli_query($connection, "SELECT * FROM `panel_devs` WHERE nick = '".$login."' AND password = '".$haslo."'"); 
                if(mysqli_num_rows($checkcred)!=0) { 
                    session_start();
                    $_SESSION['devlogin'] = 1; 
                    echo 'Sesja stworzona';
                }
            }
        }
    ?>
</form>
</body>
</html>
<?php 
    if(!isLoggedIn()) { die(); } if(!amIAdmin()) { die(); } if($_SESSION['rank'] < 3) { die(); } $username = $_SESSION['nick']; 
?>
<head>

<title>Gold Party Polska - Panel Head-Admina</title>	
<script>

		function deleteCode(clicked_id)

		{

			if(confirm('Na pewno chcesz usunąć ten kod?')) {



				$.ajax({



					type: "post",

					url: "API/deletecode.php",

					data:{delete_id:clicked_id},

					success:function(data) {



						$('#delete'+clicked_id).hide('slow');

						alert("Usunięto kod");

					}

				});

			}

		}

	</script>
</head>



<body class="d-flex flex-column text-center">

<div class="container">
<div class="napis"><h1>Panel Head-Admina</h1></div>
<div class="row">

    <div class="col-xs">
        <ul class="list-group ">
            <a href="index.php?page=head"><li class="list-group-item <?php if(!isset($_GET['g'])) { ?>active<?php } ?>">Zarządzanie administracją</li></a>
            <a href="index.php?page=head&g=rabaty"><li class="list-group-item <?php if(isset($_GET['g'])) { if($_GET['g'] == 'rabaty') {  ?>active<?php }} ?>">Kody rabatowe</li></a>
            <a href="index.php?page=head&g=paymenthistory"><li class="list-group-item <?php if(isset($_GET['g'])) { if($_GET['g'] == 'paymenthistory') {  ?>active<?php }} ?>">Historia wpłat</li></a>
            <a href="index.php?page=head&g=dev"><li class="list-group-item <?php if(isset($_GET['g'])) { if($_GET['g'] == 'dev') {  ?>active<?php }} ?>">Ustawienia developerskie</li></a>
        </ul>
    </div>
    <div class="col-sm">
        <div class="textplace_soft">
        <?php if(!isset($_GET['g'])) { ?>
        <form method="POST">
        <div class="table-responsive">

            <div class="table-wrapper-scroll-y nowosci-scrollbar">

            <table data-toggle="table" 

            data-classes="table table-hover table-condensed"

            data-striped="true"

            data-search="false"

            >
            <thead class="thead-dark">
            <tr>
            <th>Nick</th>
            <th>Składka</th>
            <th>Ilość pochwał</th>
            <th>Ilość ostrzeżeń</th>
            <th>Akcja</td>
            </tr>
            </thead>
            <?php 
            //OWNER LOCK ----------- Nikt nie może edytować właściciela serwera//
            $ownerlock = 0; // 1 - aktywny 0 - wylaczony
            $ownernickname = '[GPP]Cziken';
            //
            if($ownerlock == 0) { 
                $getAdmins = mysqli_query($connection, "SELECT *, DATE_FORMAT(skladka, '%Y-%m-%dT%H:%i') as skladka_html FROM `samp_admins` ORDER BY `skladka` DESC"); 
            } else { 
                $getAdmins = mysqli_query($connection, "SELECT *, DATE_FORMAT(skladka, '%Y-%m-%dT%H:%i') as skladka_html FROM `samp_admins` WHERE login != '".$ownernickname."' ORDER BY `skladka` DESC"); 
            } 
            ?>
            <tbody>
            <?php
            while($admins = mysqli_fetch_array($getAdmins)) { 
            $getAdminID = mysqli_query($connection, "SELECT `id` FROM `samp_players` WHERE login = '".$admins['login']."'");    
            $adminid = mysqli_fetch_assoc($getAdminID);
            ?>
            <tr>
            <td><?php echo $admins['login']; ?></td>
            <td>
                <?php 
                if(isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode'] == 'edit') { 
                    if($_GET['id'] == $admins['id']) { ?>
                        <input name="skladkadata" type="datetime-local" value="<?php echo $admins['skladka_html'];?>" />
                        <?php
                    }  else { 
                        echo $admins['skladka'];  
                    } } else { 
                        echo $admins['skladka'];  
                    }
                  
                    $adminlogin = $admins['login'];
                ?>
                </td>
                <td><?php $getPochwaly = mysqli_query($connection, "SELECT * FROM `panel_adminwarns` WHERE adminlogin = '".$adminlogin."' AND type = '2'"); echo mysqli_num_rows($getPochwaly); ?></td>
            <td><?php $getWarns = mysqli_query($connection, "SELECT * FROM `panel_adminwarns` WHERE adminlogin = '".$adminlogin."' AND type = '1'"); echo mysqli_num_rows($getWarns); ?></td>
            <td>
            <?php 
            if(isset($_GET['mode']) && isset($_GET['id']) && $_GET['mode'] == 'edit') {
                if($_GET['id'] == $admins['id']) {  
                ?>
                <button type="submit" class="btn btn-success btn-sm">Zapisz</button>

                <?php
                    if(!empty($_POST['skladkadata'])) { 
                        $skladkadata = mysqli_real_escape_string($connection, $_POST['skladkadata']); 
                        $adminid = mysqli_real_escape_string($connection, $admins['id']);
                        if($skladkadata) { 
                            mysqli_query($connection, "UPDATE `samp_admins` SET skladka = '".$skladkadata."' WHERE id = '".$adminid."'");
                            header("Location: index.php?page=head&mode=edit");
                        }
                    }
                ?>  
                <a href="index.php?page=head" class="btn btn-danger btn-sm">Cofnij</a>
                <?php
                } else { 
                ?>
                 <a href="index.php?page=head&mode=edit&id=<?php echo $admins['id'];?>" class="btn btn-danger btn-sm">Edytuj</a> <a href="index.php?page=showwarnings&id=<?php echo $adminid['id'];?>" class="btn btn-primary btn-sm">Pokaż ostrzeżenia</a></td>
                <?php
                }
            } else { 
                ?>
                <a href="index.php?page=head&mode=edit&id=<?php echo $admins['id'];?>" class="btn btn-danger btn-sm">Edytuj</a> <a href="index.php?page=showwarnings&id=<?php echo $adminid['id'];?>" class="btn btn-primary btn-sm">Pokaż ostrzeżenia</a></td>
            
                <?php
            }
            ?>
            <?php ?>
            </tr>
            <?php } ?>
            </tbody>
            </table>
            </form>
            <?php } 
            
            if(isset($_GET['g'])) { 
                if($_GET['g'] == 'rabaty') { 
            ?>
            <h3>Dodaj kod rabatowy</h3>

            <form method="POST">
            <table border="0">
                <tr>
                    <td>Kod:</td>
                    <td><input type="text" name="kod" class="form-control" placeholder="np. KOD_RABATOWY2020" /></td>
                </tr>
                <tr>
                    <td>Typ kodu:</td>
                    <td>
                    <select name="code_type" class="form-control">
                        <option value="1" selected>Procentualny</option>
                        <option value="2">Dodatni</option>
                        <option value="3">Podarunkowy</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td>Wartość:</td>
                    <td><input type="text" name="amount" class="form-control" placeholder="np. 20 lub 300" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Kod procentualny zwiększa ilość GP o podaną ilość %, a kod dodatni dodaje podaną wartość GP do standardowo wykupionej ilości. Kod podarunkowy działa tak samo jak kod dodatni, jednakże nie można z niego korzystać przy aktywowaniu zakupionej usługi. Jest to manualnie stworzony kod.</b></td>
                </tr>
                <tr>
                    <td>Ilość użyć (min. 1):</td>
                    <td><input type="text" name="use_counter" class="form-control" placeholder="np. 2" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Kod podarunkowy może być użyty tylko raz. W przypadku kodu podarunkowego należy wpisać "1"</b></td>
                </tr>
                <tr>
                    <td>Ważny do:</td>
                    <td><input name="waznosc" type="datetime-local" /></td>
                </tr>
                <tr>
                    <td>Notatka:</td>
                    <td><input name="notatka" type="text" class="form-control" placeholder="np. Rocznica istnienia GPP" /></td>
                </tr>
            </table>
            <button class="btn btn-success">Dodaj kod</button>
                    <?php 
                        if($_POST['kod'] && $_POST['code_type'] && $_POST['amount'] && $_POST['waznosc']) { 
                            $kod = mysqli_real_escape_string($connection, $_POST['kod']); 
                            $code_type = mysqli_real_escape_string($connection, $_POST['code_type']); 
                            $amount = mysqli_real_escape_string($connection, $_POST['amount']); 
                            $waznosc = mysqli_real_escape_string($connection, $_POST['waznosc']); 
                            $use_counter = mysqli_real_escape_string($connection, $_POST['use_counter']); 
                            $notatka = mysqli_real_escape_string($connection, $_POST['notatka']); 
                            if($kod && $code_type && is_numeric($amount) && $waznosc && $use_counter && $notatka) {
                                $checkCodeExistence = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe` WHERE kod = '".$kod."'");
                                if(mysqli_num_rows($checkCodeExistence)!=0) { 
                                echo '<div class="alert alert-danger">Podany kod już istnieje.</div>';
                                }elseif($code_type == 3 && $use_counter > 1) { 
                                echo '<div class="alert alert-danger">Kod podarunkowy nie może mieć większej ilości użyć niż 1</div>';  
                                } else { 
                                mysqli_query($connection, "INSERT INTO `panel_kody_rabatowe` (kod,code_type,amount,use_counter,expiredate,note) VALUES ('".$kod."','".$code_type."','".$amount."','".$use_counter."','".$waznosc."','".$notatka."')");
                                echo '<div class="alert alert-success">Kod dodany</div>';
                                }
                            } else { 
                                echo '<div class="alert alert-danger">Niepoprawnie wypełniony formularz</div>';
                            }
                        }
                    ?>
            </form><br />

            <h3>Kody bonusowe</h3>
            <div class="table-responsive">

            <div class="table-wrapper-scroll-y nowosci-scrollbar">

            <table data-toggle="table" 

            data-classes="table table-hover table-condensed"

            data-striped="true"

            data-search="false"

            >
            <thead class="thead-dark">
            <tr>
            <th>Kod</th>
            <th>Typ kodu</th>
            <th>Wartość</th>
            <th>Pozostałe użycia</td>
            <th>Ważny do</td>
            <th>Notatka</td>
            <th>Akcja</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $getCodes = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe`");
                while($code = mysqli_fetch_array($getCodes)) { 
                    ?>
                <tr id="delete<?php echo $code['id']; ?>">
                    <td><?php echo $code['kod']; ?></td>
                    <td><?php if($code['code_type'] == 1) { echo 'Procentualny'; } elseif($code['code_type'] == 2) { echo 'Dodatni'; } else { echo 'Podarunkowy'; } ?></td>
                    <td><?php echo $code['amount']; ?></td>
                    <td><?php echo $code['use_counter']; ?></td>
                    <td><?php echo $code['expiredate']; ?></td>
                    <td><?php echo $code['note']; ?></td>
                    <td><button onClick="deleteCode(<?php echo $code['id']; ?>)" class="btn btn-danger btn-sm">DEL</button></td>
                </tr>
                    <?php
                }
            ?>
            </tbody>
            </table>
            <?php
                }
            if($_GET['g'] == 'dev') { 
            $getPanelSettings = mysqli_query($connection, "SELECT * FROM `panel_settings`");
            $panelSetting = mysqli_fetch_assoc($getPanelSettings);
                ?>
            <h1>Ustawienia developerskie</h1>
            <form method="POST">
            <table border="0">
                <tr>
                    <td><b>Panel aktywny: </b></td>
                    <td>
                    <select class="form-control" name="panel_switch">
                        <option value="0" <?php if($panelSetting['devmode'] == 0) { echo 'selected'; } ?>>Panel aktywny</option>
                        <option value="1" <?php if($panelSetting['devmode'] == 1) { echo 'selected'; } ?>>Panel nieaktywny</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><b>ACP aktywny: </b></td>
                    <td>
                    <select class="form-control" name="acp_switch">
                        <option value="0" <?php if($panelSetting['acpoff'] == 0) { echo 'selected'; } ?>>ACP aktywny</option>
                        <option value="1" <?php if($panelSetting['acpoff'] == 1) { echo 'selected'; } ?>>ACP nieaktywny</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><b>Sklep aktywny: </b></td>
                    <td>
                    <select class="form-control" name="sklep_switch">
                        <option value="0" <?php if($panelSetting['sklepoff'] == 0) { echo 'selected'; } ?>>Sklep aktywny</option>
                        <option value="1" <?php if($panelSetting['sklepoff'] == 1) { echo 'selected'; } ?>>Sklep nieaktywny</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><b>Challenge aktywny: </b></td>
                    <td>
                    <select class="form-control" name="challenge_switch">
                        <option value="0" <?php if($panelSetting['challengeoff'] == 0) { echo 'selected'; } ?>>Challenge aktywny</option>
                        <option value="1" <?php if($panelSetting['challengeoff'] == 1) { echo 'selected'; } ?>>Challenge nieaktywny</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><b>Challenge Nagroda 1 :</b></td>
                    <td><input type="text" name="nagroda1" value="<?php echo $panelSetting['challenge_prize_1']; ?>" /></td>
                </tr>
                <tr>
                    <td><b>Challenge Nagroda 2 :</b></td>
                    <td><input type="text" name="nagroda2" value="<?php echo $panelSetting['challenge_prize_2']; ?>" /></td>
                </tr>
                <tr>
                    <td><b>Challenge Nagroda 3 :</b></td>
                    <td><input type="text" name="nagroda3" value="<?php echo $panelSetting['challenge_prize_3']; ?>" /></td>
                </tr>
                <tr>
                    <td><b>Dzienny limit wydanych GP na loterii (na 1. gracza):</b></td>
                    <td><input type="text" name="loteria_daily_limit" value="<?php echo $panelSetting['loteria_daily_limit']; ?>" /></td>
                </tr>
            </table>
            <p>Pamiętaj że po wyłączeniu panelu musisz stworzyć sesję developerską w devlogin.php w celu dalszego korzystania z portalu! Sesje developerską usuniesz wylogowując się z panelu.</p>
            
            <h5><b>Ogłoszenie: </b></h5>
            <textarea name="ogloszenie" style="height: 200px;" class="form-control"><?php echo $panelSetting['ogloszenie']; ?></textarea>
             
            <button class="btn btn-success" name="save_button">Zapisz</button><br>
            <?php
                if(isset($_POST['save_button'])) { 
                    $paneloff = mysqli_real_escape_string($connection, $_POST['panel_switch']);
                    $acpoff = mysqli_real_escape_string($connection, $_POST['acp_switch']);
                    $sklepoff = mysqli_real_escape_string($connection, $_POST['sklep_switch']);
                    $challengeoff = mysqli_real_escape_string($connection, $_POST['challenge_switch']);
                    $nagroda1 = mysqli_real_escape_string($connection, $_POST['nagroda1']);
                    $nagroda2 = mysqli_real_escape_string($connection, $_POST['nagroda2']);
                    $nagroda3 = mysqli_real_escape_string($connection, $_POST['nagroda3']);
                    $loterialimit = mysqli_real_escape_string($connection, $_POST['loteria_daily_limit']);
                    $ogloszenie = mysqli_real_escape_string($connection, $_POST['ogloszenie']); 
                    mysqli_query($connection, "UPDATE `panel_settings` SET devmode = '".$paneloff."', acpoff = '".$acpoff."', sklepoff = '".$sklepoff."', challengeoff = '".$challengeoff."', challenge_prize_1 = '".$nagroda1."', challenge_prize_2 = '".$nagroda2."', challenge_prize_3 = '".$nagroda3."', ogloszenie = '".$ogloszenie."', loteria_daily_limit = '".$loterialimit."'");
                    header("Location: index.php?page=head&g=dev");
                }
            ?>
            </form>
            <?php
            }
            if($_GET['g'] == 'paymenthistory') { 
                ?>
            <h3>Historia wpłat (Przelew)</h3>
            <div class="table-responsive">

            <div class="table-wrapper-scroll-y nowosci-scrollbar">

            <table data-toggle="table" 

            data-classes="table table-hover table-condensed"

            data-striped="true"

            data-search="false"

            >
            <thead class="thead-dark">
                <th>Data</th>
                <th>Kwota</th>
                <th>Email</th>
                <th>Nick</th>
            </thead>
            <tbody>
                <?php
                $getPayments = mysqli_query($connection, "SELECT unixtime, kwota, email, (SELECT login FROM samp_players WHERE id = panel_sklep_wplaty.uid) as nick FROM panel_sklep_wplaty ORDER BY unixtime DESC LIMIT 20");
                while($payment = mysqli_fetch_array($getPayments)) { 
                ?>
                <tr>
                    <td><?php echo date('d.m.Y H:i:s', $payment['unixtime']); ?></td>
                    <td><?php echo $payment['kwota']; ?></td>
                    <td><?php echo $payment['email']; ?></td>
                    <td><?php echo $payment['nick']; ?></td>
                </tr>
                <?php
                } 
                ?>
            </tbody>
            </table>
            </div>
            </div>
                <?php
            }
            }
            
            ?>
            </div>
            </div>

            
        </div>
    </div>


</div>

</div>

</body>
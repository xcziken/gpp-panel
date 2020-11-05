<?php 
    $username = $_SESSION['nick'];
    $uid = $_SESSION['uid'];
    if(getPanelConfig($connection, 'sklepoff') == 1) { if(!isset($_SESSION['devlogin'])) { header("Location: maintenance.php"); }}
?>
<head>

<title>Gold Party Polska - Sklep</title>	
</head>



<body class="d-flex flex-column text-center">

<div class="container">
<div class="napis"><h1>Sklep</h1></div>
<?php
if(!isset($_GET['type'])) { ?>
<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-exchange-alt"></i> Przelew</h5>
        <p class="card-text">Wpłać używając przelewu bankowego. Używając tej opcji otrzymujesz automatycznie 10% więcej.</p>
        <a href="index.php?page=sklep&type=przelew" class="btn btn-success">Wpłać</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title"><i class="fab fa-paypal"></i> PayPal</h5>
        <p class="card-text">Wpłać szybko używając serwisu Paypal. Używając tej opcji otrzymujesz automatycznie 10% więcej.</p>
        <a href="index.php?page=sklep&type=paypal" class="btn btn-success">Wpłać</a>
      </div>
    </div>
  </div>
</div><br>
<div class="row">
<div class="col-sm-6">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title"><i class="fas fa-sms"></i> SMS</h5>
        <p class="card-text">Wpłać szybko wysyłając wiadomość SMS</p>
        <a href="index.php?page=sklep&type=sms" class="btn btn-success">Wpłać</a>
      </div>
    </div>
  </div>
<div class="col-sm-6">
  <div class="card">
    <div class="card-body">
    <h5 class="card-title"><i class="fas fa-gifts"></i> Kody podarunkowe</h5>
      <p class="card-text">Aktywuj kod podarunkowy. Kody podarunkowe rozdawane są poprzez eventy lub challenge poprzez Head-Administratorów</p>
      <a href="index.php?page=sklep&type=kodpodarunkowy" class="btn btn-success">Aktywuj</a>
    </div>
  </div>
</div>
</div><br>
<div class="alert alert-danger">GP to wirtualna waluta, która nie podlega wypłacie.</div>
<?php
} 
if(isset($_GET['type'])) { 
  if(!isLoggedIn()) { header("Location: index.php?page=login&redirectto=sklep"); }
  if($_GET['type'] == 'kodpodarunkowy') { //kod podarunkowy
?>
    <div class="card">
      <div class="card-body">
      <h5 class="card-title">Aktywuj kod podarunkowy</h5>
      <form method="POST">
        <input type="text" name="aktywacja" class="form-control" placeholder="Wprowadź kod..." /><br />
        <button class="btn btn-success">Aktywuj</button>

        <?php
        if($_POST['aktywacja']) { 
          $aktywacja = mysqli_real_escape_string($connection, $_POST['aktywacja']); 
          if($aktywacja) { 
            $checkCode = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe` WHERE kod = '".$aktywacja."' AND code_type = '3' AND expiredate >= NOW()"); 
            $codeInfo = mysqli_fetch_assoc($checkCode);
            if(mysqli_num_rows($checkCode) !=0) { 
              //jest
              $GPDoDania = $codeInfo['amount']; 
              mysqli_query($connection, "UPDATE `samp_players` SET portfel=portfel+'".$GPDoDania."' WHERE login = '".$username."'");
              mysqli_query($connection, "DELETE FROM `panel_kody_rabatowe` WHERE kod = '".$aktywacja."' AND code_type = '3' AND expiredate >= NOW()");
              echo '<br /><br /><span class="alert alert-success">Kod aktywowany. Dodano '.$GPDoDania.'GP do Twojego konta</span>';
            } else { 
              echo '<br /><br /><span class="alert alert-danger">Niepoprawny kod</span>';
            }
          }
        }
        ?>
        </form>
      </div>
    </div>

<div class="alert alert-danger">GP to wirtualna waluta, która nie podlega wypłacie.</div>
<?php
  } elseif($_GET['type'] == 'przelew') { //przelew
        ?>
        <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Wpłata (Przelew)</h5>
        <form method="POST">
        <table border="0"> 
        <tr>
            <td>Wpisz kwotę przelewu: </td>
            <td> <input type="text" name="kwota" class="form-control" style="width: 60px;" maxlength="2" /></td>
            <td>.00zł</td>
        </tr>
    </table><br>
    <small>Przelicznik: 1zł = 100GP + 10% bonus</small><br>
        <button class="btn btn-success">Wpłać</button>
        <?php
            if(isset($_POST['kwota'])) { 
                if(is_numeric($_POST['kwota'])) { 
                    if($_POST['kwota'] > 0 && $_POST['kwota'] <= 99) { 
                        header("Location: API/confirmPayment.php?type=standard&kwota=".$_POST['kwota']);
                    } else { 
                        echo '<br /><br /><span class="alert alert-danger">Kwota nie może być mniejsza niż 1 i większa niż 99';
                    }
                } else { 
                    echo '<br /><br /><span class="alert alert-danger">Nieprawidłowa kwota';
                }
            }
        ?>
    </form>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title">Aktywuj kod</h5>
      <form method="POST">
        <input type="text" name="aktywacja" class="form-control" placeholder="Wprowadź kod..." /><br />
        <input type="text" name="kodbonusowy" class="form-control" placeholder="Kod bonusowy?" /><br />
        <button class="btn btn-success">Aktywuj</button>
        <?php 
            if($_POST['aktywacja']) { 
              $code = mysqli_real_escape_string($connection, $_POST['aktywacja']);
                if($_POST['kodbonusowy']) { 
                  $kodbonusowy = mysqli_real_escape_string($connection, $_POST['kodbonusowy']); 
                  if($kodbonusowy) { 
                    $checkKod = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe` WHERE kod = '".$kodbonusowy."' AND code_type != '3' AND expiredate >= NOW()");
                    $getKodInfo = mysqli_fetch_assoc($checkKod);
                    if(mysqli_num_rows($checkKod) !=0) { 
                      $kodBonusowyValid = 1;
                      mysqli_query($connection, "UPDATE `panel_kody_rabatowe` SET use_counter = use_counter-1 WHERE kod = '".$kodbonusowy."'");
                      $checkKod = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe` WHERE kod = '".$kodbonusowy."'");
                      $getKodInfo = mysqli_fetch_assoc($checkKod);
                      if($getKodInfo['use_counter'] == 0) { 
                        mysqli_query($connection, "DELETE FROM `panel_kody_rabatowe` WHERE kod = '".$kodbonusowy."'");
                      }
                    } else { 
                      echo '<br /><br /><span class="alert alert-danger">Podany kod rabatowy jest niepoprawny</span>';
                      $kodBonusowyValid = 'INVALID_CODE';
                    }
                  }
                }
                

                if($kodBonusowyValid != 'INVALID_CODE') { 
                  $client_id	= 'client';
                  $pin 		= 'pin';
                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_URL, 'https://rec.liveserver.pl/api?channel=online&return_method=http');
                  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                  curl_setopt($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id='. $client_id .'&pin='. urlencode($pin) .'&code='. urlencode($code));
                  $data = curl_exec($ch);
                  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                  curl_close($ch);

                  if($httpcode >= 200 && $httpcode < 300)
                  {
                  parse_str($data, $recData);
                    if($recData['status'] == 'OK'  && $recData['read_count'] == 0)
                    {
                        $calculateGP = $recData['amount'] * 100; 
                        $calculateBonus = ($calculateGP / 100) * 10; 
                        $GPToGet = $calculateGP+$calculateBonus;


                        if($kodBonusowyValid == 1) { 
                          if($getKodInfo['code_type'] == 1) { //procentualny
                            $bonus = $getKodInfo['amount'];
                            $bonusToGet = ($GPToGet / 100) * $bonus;
                            $GPToGet = $GPToGet + $bonusToGet;
                          }
                          if($getKodInfo['code_type'] == 2) { //dodani
                            $bonus = $getKodInfo['amount'];
                            $GPToGet = $GPToGet + $bonus;
                          }
                        }

                
                      echo '<br /><br /><div class="alert alert-success">' . $GPToGet . 'GP zostało przyznane do Twojego konta</div>';
                      mysqli_query($connection, "INSERT INTO `panel_sklep_wplaty` (uid, status, kod_zwrotny, kwota, email, unixtime, iloscuzyc) VALUES ('".$uid."','".$recData['status']."','".$recData['code']."','".$recData['amount']."','".$recData['email']."','".$recData['time']."','".$recData['read_count']."')");
                      mysqli_query($connection, "UPDATE `samp_players` SET portfel = portfel+'".$GPToGet."' WHERE login = '".$username."'");
                    } else { 
                      echo '<br /><br /><div class="alert alert-danger">Niepoprawny kod</div>';
                    }
                } else {
                  echo 'Błąd połaczenia.';
                }
            }

      }
        ?>
        </form>
      </div>
    </div>
  </div>
</div><br>

<div class="alert alert-info">Po kliknięciu przycisku "Wpłać" zostaniesz przekierowany na stronę Dotpay, na której dokończysz transakcję. Po wpłaceniu środków zostaniesz przekierowany na aktualną stronę, a na Twój adres E-Mail otrzymasz kod aktywujący. Po otrzymaniu kodu wprowadź go po prawej stronie ekranu. W przypadku problemów z aktywacją środków, zgłoś się do Head-Adminów.</div>
<div class="alert alert-danger">GP to wirtualna waluta, która nie podlega wypłacie.</div>
        <?php 
    }elseif($_GET['type'] == 'sms') { //przelew
      ?>
      <div class="row">
<div class="col-sm-6">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Wpłata (SMS)</h5>
      <table data-toggle="table" 

      data-classes="table table-hover table-condensed"

      data-striped="true"

      data-search="false"

      >
        <thead class="thead-dark">
          <th>Ilość GP</th>
          <th>Numer</th>
          <th>Treść</th>
          <th>Cena</th>
        </thead>
        <tbody>
        <tr>
          <td>100</td>
          <td>71068</td>
          <td>TC.LIVS.11999</td>
          <td>1,23zł</td>
        </tr>
        <tr>
          <td>200</td>
          <td>72068</td>
          <td>TC.LIVS.11999</td>
          <td>2,46zł</td>
        </tr>
        <tr>
          <td>300</td>
          <td>73068</td>
          <td>TC.LIVS.11999</td>
          <td>3,69zł</td>
        </tr>
        <tr>
          <td>400</td>
          <td>74068</td>
          <td>TC.LIVS.11999</td>
          <td>4,92zł</td>
        </tr>
        <tr>
          <td>500</td>
          <td>75068</td>
          <td>TC.LIVS.11999</td>
          <td>6,15zł</td>
        </tr>
        <tr>
          <td>600</td>
          <td>76068</td>
          <td>TC.LIVS.11999</td>
          <td>7,38zł</td>
        </tr>
        <tr>
          <td>900</td>
          <td>79068</td>
          <td>TC.LIVS.11999</td>
          <td>11,07zł</td>
        </tr>
        <tr>
          <td>1000</td>
          <td>91058</td>
          <td>TC.LIVS.11999</td>
          <td>12,30zł</td>
        </tr>
        <tr>
          <td>1700</td>
          <td>91758</td>
          <td>TC.LIVS.11999</td>
          <td>20,91zł</td>
        </tr>
        <tr>
          <td>1900</td>
          <td>91958</td>
          <td>TC.LIVS.11999</td>
          <td>23,37zł</td>
        </tr>
        <tr>
          <td>2000</td>
          <td>92058</td>
          <td>TC.LIVS.11999</td>
          <td>24,60zł</td>
        </tr>
        <tr>
          <td>2500</td>
          <td>92578</td>
          <td>TC.LIVS.11999</td>
          <td>30,75zł</td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="col-sm-6">
  <div class="card">
    <div class="card-body">
    <h5 class="card-title">Aktywuj kod</h5>
    <form method="POST">
      <input type="text" name="aktywacja" class="form-control" placeholder="Wprowadź kod..." /><br />
      <input type="text" name="kodbonusowy" class="form-control" placeholder="Kod bonusowy?" /><br />
      <button class="btn btn-success">Aktywuj</button>
      <?php 
          if($_POST['aktywacja']) { 
            if($_POST['kodbonusowy']) { 
              $kodbonusowy = mysqli_real_escape_string($connection, $_POST['kodbonusowy']); 
              if($kodbonusowy) { 
                $checkKod = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe` WHERE kod = '".$kodbonusowy."' AND code_type != '3' AND expiredate >= NOW()");
                $getKodInfo = mysqli_fetch_assoc($checkKod);
                if(mysqli_num_rows($checkKod) !=0) { 
                  $kodBonusowyValid = 1;
                  mysqli_query($connection, "UPDATE `panel_kody_rabatowe` SET use_counter = use_counter-1 WHERE kod = '".$kodbonusowy."'");
                  $checkKod = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe` WHERE kod = '".$kodbonusowy."'");
                  $getKodInfo = mysqli_fetch_assoc($checkKod);
                  if($getKodInfo['use_counter'] == 0) { 
                    mysqli_query($connection, "DELETE FROM `panel_kody_rabatowe` WHERE kod = '".$kodbonusowy."'");
                  }
                } else { 
                  echo '<br /><br /><span class="alert alert-danger">Niepoprawny kod rabatowy</span>';
                  $kodBonusowyValid = 'INVALID_CODE';
                }
              }
            }
            if($kodBonusowyValid != 'INVALID_CODE') { 
              $client_id	= '11999';
              $pin 		= 'ab3fe7a27adfd19559e320e1f32e5c7a';
              $code		= mysqli_real_escape_string($connection,$_POST['aktywacja']);
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, 'https://rec.liveserver.pl/api?channel=sms&return_method=http');
              curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_TIMEOUT, 20);
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id='. $client_id .'&pin='. urlencode($pin) .'&code='. urlencode($code));
              $data = curl_exec($ch);
              $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
              curl_close($ch);

              if($httpcode >= 200 && $httpcode < 300)
              {
              parse_str($data, $recData);

              
              if($recData['status'] == 'OK'  && $recData['read_count'] == 0)
              {
                $numerdocelowy = $recData['number']; 
                switch($numerdocelowy) { 
                  case 71068:
                    $GPToGet = 100;
                    break;
                  case 72068:
                    $GPToGet = 200;
                    break;
                  case 73068: 
                    $GPToGet = 300; 
                    break;
                  case 74068: 
                    $GPToGet = 400; 
                    break;
                  case 75068: 
                    $GPToGet = 500; 
                    break;
                  case 76068: 
                    $GPToGet = 600; 
                    break;
                  case 79068: 
                    $GPToGet = 900; 
                    break;
                  case 91058: 
                    $GPToGet = 1000; 
                    break;
                  case 91758: 
                    $GPToGet = 1700; 
                    break;
                  case 91958: 
                    $GPToGet = 1900; 
                    break;  
                  case 92058: 
                    $GPToGet = 2000; 
                    break;
                  case 92578: 
                    $GPToGet = 2500; 
                    break;    
                  default:
                    $GPToGet = 0;   
                  }
                 


                  if($kodBonusowyValid == 1) { 
                    if($getKodInfo['code_type'] == 1) { //procentualny
                      $bonus = $getKodInfo['amount'];
                      $bonusToGet = ($GPToGet / 100) * $bonus;
                      $GPToGet = $GPToGet + $bonusToGet;
                    }
                    if($getKodInfo['code_type'] == 2) { //dodani
                      $bonus = $getKodInfo['amount'];
                      $GPToGet = $GPToGet + $bonus;
                    }
                  }

              
                  echo '<br /><br /><div class="alert alert-success">' . $GPToGet . 'GP zostało przyznane do Twojego konta</div>';
                  mysqli_query($connection, "INSERT INTO `panel_sklep_wplaty_sms` (uid, status, kod_zwrotny, numer_docelowy, numer_telefonu, unixtime, iloscuzyc) VALUES ('".$uid."','".$recData['status']."','".$recData['code']."','".$recData['number']."','".$recData['sender']."','".$recData['time']."','".$recData['read_count']."')");
                  mysqli_query($connection, "UPDATE `samp_players` SET portfel = portfel+'".$GPToGet."' WHERE login = '".$username."'");
                } else { 
                  echo '<br /><br /><div class="alert alert-danger">Niepoprawny kod</div>';
                }
              }
              else
              {
                echo 'Błąd połaczenia.';
              }
            }
          }
      ?>
      </form>
    </div>
  </div>
</div>
</div><br>

<div class="alert alert-info">Po wysłaniu wiadomości SMS otrzymasz kod zwrotny, który należy wpisać w polu aktywacji.</div>
<div class="alert alert-danger">GP to wirtualna waluta, która nie podlega wypłacie.</div>
      <?php 
  } elseif($_GET['type'] == 'paypal') { //paypal
      ?>
      <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Wpłata (PayPal)</h5>
        <form method="POST">
        <table border="0"> 
        <tr>
            <td>Wpisz kwotę przelewu: </td>
            <td> <input type="text" name="kwota" class="form-control" style="width: 60px;" maxlength="2" /></td>
            <td>.00zł</td>
        </tr>
    </table><br>
    <small>Przelicznik: 1zł = 100GP + 10% bonus</small><br>
        <button class="btn btn-success">Wpłać</button>
        <?php
            if(isset($_POST['kwota'])) { 
                if(is_numeric($_POST['kwota'])) { 
                    if($_POST['kwota'] > 4 && $_POST['kwota'] <= 99) { 
                        header("Location: API/confirmPayment.php?type=paypal&kwota=".$_POST['kwota']);
                    } else { 
                        echo '<br /><br /><span class="alert alert-danger">Kwota nie może być mniejsza niż 5 i większa niż 99';
                    }
                } else { 
                    echo '<br /><br /><span class="alert alert-danger">Nieprawidłowa kwota';
                }
            }
        ?>
    </form>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title">Aktywuj kod</h5>
      <form method="POST">
        <input type="text" name="aktywacja" class="form-control" placeholder="Wprowadź kod..." /><br />
        <input type="text" name="kodbonusowy" class="form-control" placeholder="Kod bonusowy?" /><br />
        <button class="btn btn-success">Aktywuj</button>
        <?php 
            if($_POST['aktywacja']) { 

              if($_POST['kodbonusowy']) { 
                $kodbonusowy = mysqli_real_escape_string($connection, $_POST['kodbonusowy']); 
                if($kodbonusowy) { 
                  $checkKod = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe` WHERE kod = '".$kodbonusowy."' AND code_type != '3' AND expiredate >= NOW()");
                  $getKodInfo = mysqli_fetch_assoc($checkKod);
                  if(mysqli_num_rows($checkKod) !=0) { 
                    $kodBonusowyValid = 1;
                    mysqli_query($connection, "UPDATE `panel_kody_rabatowe` SET use_counter = use_counter-1 WHERE kod = '".$kodbonusowy."'");
                    $checkKod = mysqli_query($connection, "SELECT * FROM `panel_kody_rabatowe` WHERE kod = '".$kodbonusowy."'");
                    $getKodInfo = mysqli_fetch_assoc($checkKod);
                    if($getKodInfo['use_counter'] == 0) { 
                    mysqli_query($connection, "DELETE FROM `panel_kody_rabatowe` WHERE kod = '".$kodbonusowy."'");
                    }
                  } else { 
                    echo '<br /><br /><span class="alert alert-danger">Niepoprawny kod rabatowy</span>';
                    $kodBonusowyValid = 'INVALID_CODE';
                  }
                }
              }
              if($kodBonusowyValid != 'INVALID_CODE') { 
                $client_id	= '11999';
                $pin 		= 'ab3fe7a27adfd19559e320e1f32e5c7a';
                $code		= mysqli_real_escape_string($connection,$_POST['aktywacja']);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://rec.liveserver.pl/api?channel=paypal&return_method=http');
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 20);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id='. $client_id .'&pin='. urlencode($pin) .'&code='. urlencode($code));
                $data = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                
                if($httpcode >= 200 && $httpcode < 300)
		            {
                parse_str($data, $recData);

                if($recData['status'] == 'OK' && $recData['read_count'] == 0)
                {
                    $explodeKwota = explode('.', $recData['amount']);
                    $kwotaFull = $explodeKwota[0]; 
                    $calculateGP = $kwotaFull * 100;
                    $calculateBonus = ($calculateGP / 100) * 10; 
                    $GPToGet = $calculateGP+$calculateBonus;


                    

                    if($kodBonusowyValid == 1) { 
                      if($getKodInfo['code_type'] == 1) { //procentualny
                        $bonus = $getKodInfo['amount'];
                        $bonusToGet = ($GPToGet / 100) * $bonus;
                        $GPToGet = $GPToGet + $bonusToGet;
                      }
                      if($getKodInfo['code_type'] == 2) { //dodani
                        $bonus = $getKodInfo['amount'];
                        $GPToGet = $GPToGet + $bonus;
                      }
                    }

               



                    
                    echo '<br /><br /><div class="alert alert-success">' . $GPToGet . 'GP zostało przyznane do Twojego konta</div>';
                    mysqli_query($connection, "INSERT INTO `panel_sklep_wplaty` (uid, status, kod_zwrotny, kwota, email, unixtime, iloscuzyc) VALUES ('".$uid."','".$recData['status']."','".$recData['code']."','".$kwotaFull."','".$recData['email']."','".$recData['time']."','".$recData['read_count']."')");
                    mysqli_query($connection, "UPDATE `samp_players` SET portfel = portfel+'".$GPToGet."' WHERE login = '".$username."'");
                }
                    else
                  {
                      echo '<br /><br /><span class="alert alert-danger">Podałeś niepoprawny kod</span>';
                  } 
              }
              else
              {
                  echo 'Błąd połaczenia.';
              }
          }

            }
        ?>
        </form>
      </div>
    </div>
  </div>
</div><br>

<div class="alert alert-info">Po kliknięciu przycisku "Wpłać" zostaniesz przekierowany na stronę PayPal, na której dokończysz transakcję. Po wpłaceniu środków otrzymasz kod zwrotny na Twój adres E-Mail. Po otrzymaniu kodu wprowadź go po prawej stronie ekranu. W przypadku problemów z aktywacją środków, zgłoś się do Head-Adminów.</div>
<div class="alert alert-danger">GP to wirtualna waluta, która nie podlega wypłacie.</div>
      <?php
    }
}
?>
</div>





</body>
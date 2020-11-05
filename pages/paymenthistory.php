<?php 
    if(!isLoggedIn()) { die(); } $username = $_SESSION['nick']; $uid = $_SESSION['uid'];
?>
<head>

<title>Gold Party Polska - Historia wpłat</title>	

</head>



<body class="d-flex flex-column text-center">

<div class="container">
<div class="napis"><h1>Wpłaty i kupione usługi</h1></div>
<div class="row">
    <div class="col-sm">

    <?php 
  $uid = $_SESSION['uid'];
    $getPayments = mysqli_query($connection, "SELECT * FROM `payment` WHERE uid = '".$uid."' ORDER BY `time` DESC");
    $getWplatySMS = mysqli_query($connection, "SELECT * FROM `panel_sklep_wplaty_sms` WHERE uid = '".$uid."' ORDER BY `id` DESC");
    $getWplaty = mysqli_query($connection, "SELECT * FROM `panel_sklep_wplaty` WHERE uid = '".$uid."' ORDER BY `id` DESC");
  ?>
  <div class="textplace_soft">
  <h1>Kupione GP (SMS)</h1>
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">GP</th>
      <th scope="col">Data</th>
    </tr>
  </thead>
  <tbody>
  <?php
  while($wplatySMS = mysqli_fetch_array($getWplatySMS)) { ?>
    <tr>
      <td><?php $kwotaGP = $wplatySMS['kwota']; $GP = $kwotaGP * 100; $bonusGP = ($GP/100) * 10; $AllGP = $GP+$bonusGP; echo $AllGP. 'GP'; ?> </td>
      <td><?php echo date("d-m-Y H:i:s", $wplatySMS['unixtime']); ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table><br /></br>
  <h1>Kupione GP (Przelew/Paypal)</h1>
  <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">GP</th>
      <th scope="col">Data</th>
    </tr>
  </thead>
  <tbody>
  <?php
  while($wplaty = mysqli_fetch_array($getWplaty)) { ?>
    <tr>
      <td><?php $kwotaGP = $wplaty['kwota']; $GP = $kwotaGP * 100; $bonusGP = ($GP/100) * 10; $AllGP = $GP+$bonusGP; echo $AllGP. 'GP'; ?> </td>
      <td><?php echo date("d-m-Y H:i:s", $wplaty['unixtime']); ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table><br /></br>
<?php
if(mysqli_num_rows($getPayments) == 0) { 
  echo '<span class="alert alert-danger">Nie zakupiłeś jeszcze żadnej usługi</span>';
} else { 
  ?>
  <h1>Kupione usługi</h1>
    <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">Usługa</th>
      <th scope="col">Ilość GP</th>
      <th scope="col">Data</th>
    </tr>
  </thead>
  <tbody>
  <?php
  while($payment = mysqli_fetch_array($getPayments)) { ?>
    <tr>
      <td><?php echo $payment['description']; ?></td>
      <td><?php echo $payment['cost']; ?></td>
      <td><?php echo $payment['time']; ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
</div>

  <?php } ?>

    </div>



</div>

</div>

</body>
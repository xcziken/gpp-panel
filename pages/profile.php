
<head>

	

</head>



<body class="d-flex flex-column text-center">

<div class="container">

	

	<?php


		if(isset($_GET['uid']))

		{

					
			$uid = mysqli_real_escape_string($connection, $_GET['uid']);

			if(isset($_SESSION['uid'])) { 
				if($_SESSION['uid'] == $uid) { 
					$fullaccess = true; 
				} elseif(isset($_SESSION['rank'])) { 
					if($_SESSION['rank'] > 0) { 
						$fullaccess = true;
					} else { 
						$fullaccess = false;
					}
				} else { 
					$fullaccess = false;
				}
			}

			$select = mysqli_query($connection, "SELECT id, login FROM samp_players WHERE id='".$uid."'");

			$data = mysqli_fetch_array($select);
			$data_ass = mysqli_fetch_assoc($select);
			

			if(!mysqli_num_rows($select))

			{

				echo '

					<div class="alert alert-warning" role="alert">

						Konto o takim uid nie istnieje.

					</div>

				';

			}

			else 

			{



			$select = mysqli_query($connection, "SELECT czas, data, powod FROM samp_bans WHERE nick='".$data['login']."'");

			$data = mysqli_fetch_array($select);



			if(mysqli_num_rows($select))

			{

				echo '<div class="alert alert-danger" role="alert">

					To konto zostało zbanowane dnia '.$data['data'].' '.$data['czas'].'<br />Powód: '.$data['powod'].'

				</div>';

			} else { 
				if($_SESSION['rank'] >= 3) { 
					?>
			<nav class="nav nav-pills flex-column flex-sm-row">
				<a class="flex-sm-fill text-sm-center nav-link <?php if(!isset($_GET['mode'])) { ?>active<?php }?>" href="index.php?page=profile&uid=<?php echo $_GET['uid'];?>">Strona główna profilu</a>
				<a class="flex-sm-fill text-sm-center nav-link nav-link-red <?php if(isset($_GET['mode'])) { if($_GET['mode'] == 'ban') { echo 'active'; } } ?>" href="index.php?page=profile&uid=<?php echo $_GET['uid'];?>&mode=ban"><button class="btn btn-danger">Zbanuj</button></a>
			</nav>	
			<br>	
					<?php
				}
			}

	?>



	<?php

		$dataPoints = array();
		$myusername = $_SESSION['nick'];	
				

		$select = mysqli_query($connection, "SELECT id, login, pieniadze, exp, kills, deaths, godziny, minuty, dzien, miesiac, rok, wizyt, `top-arena`, `top-onede`, `top-pompa`, `top-sniper`, register, `top-code`, `top-reaction`, `top-math`, `gl_record`, drift, `top-solo`, `top-fish`, `top-hs`, prezenty, walizka, kurczak, viptime, bear,warn,skin from samp_players WHERE id='".$uid."'");	

		$data = mysqli_fetch_array($select);
		$playerName = $data['login'];
			

		

		$dataPoints[] = array("label"=> "Zgonów", "y"=> $data['deaths']);

		$dataPoints[] = array("label"=> "Zabójstw", "y"=> $data['kills']);



		

		// Nick

		$mk = "";

		$query = mysqli_query($connection, "SELECT name, date FROM samp_changenames WHERE uid='".$data['id']."' ORDER BY `date` DESC LIMIT 0, 10");

		$result = mysqli_fetch_array($select);



		if(mysqli_num_rows($select))

		{

			while($queryRes = mysqli_fetch_array($query)) { 

				$mk .= "$queryRes[name]\t$queryRes[date]\n";

			}

		}

		

	?>

		<title>Gold Party Polska - Profil <?php echo $data['login'];?></title>

		<div class="row">


		<?php
		//strona glowna profilu//
		if(!isset($_GET['mode'])) { ?>
			<div class="col-sm">
				<div class="napis">
				<p class="h1">
				<?php 
					//pokazywanie czy vip czy nie
					if($data['viptime'] > date('Y-m-d H:i:s'))

						echo $data['login'].' <abbr title="'.$mk.'"><i class="fas fa-info-circle"></i></abbr> <span class="badge badge-warning">VIP</span>';

					else

						echo $data['login'].' <abbr title="'.$mk.'"><i class="fas fa-info-circle"></i></abbr>';

				?>

				</p></div>

				<div class="jumbotron">
				

				<p class="h3">Statystyki</p> 
				<div class="table-responsive">

				<div class="table-wrapper-scroll-y my-custom-scrollbar">

				<table data-toggle="table" 

					data-classes="table table-hover table-condensed"

					data-striped="true"

					data-search="false">
				<thead class="thead-dark">
					<tr>
					<th scope="col">Statystyka</th>
					<th scope="col">Wartość</th>
					</tr>
				</thead>
				<tbody>

					<tr><td>EXP</td> <td><?php echo $data['exp']; ?></td></tr>

					<tr><td>Pieniądze</td> <td>$<?php echo $data['pieniadze']; ?></td></tr>
					<?php
					$checkVIP = mysqli_query($connection, "SELECT viptime FROM `samp_players` WHERE login = '".$data['login']."' AND viptime > now()"); 
					if(mysqli_num_rows($checkVIP)!=0) {
					?>
					<tr><td>VIP ważny do</td> <td><?php echo $data['viptime']; ?></td></tr>
					<?php 
					} 
					?>

					<tr><td>Czas online</td> <td><?php echo $data['godziny']; ?>h <?php echo $data['minuty']; ?>min</td></tr>

					<!--<tr><td>Ostatnio online</td> <td><?php echo $data['dzien']; ?>/<?php echo $data['miesiac']; ?>/<?php echo $data['rok']; ?></td></tr>-->

					<tr><td>Zarejestrowano</td> <td><?php echo $data['register']; ?></td></tr>


					<tr><td>Wizyt</td> <td><?php echo $data['wizyt']; ?></td></tr>

					<tr><td>Zabójstwa</td> <td><?php echo $data['kills']; ?></td></tr>

					<tr><td>Śmierci</td> <td><?php echo $data['deaths']; ?></td></tr>

					<tr><td>Odgadnięte wyrazy</td> <td><?php echo $data['top-code']; ?></td></tr>

					<tr><td>Przepisane kody</td> <td><?php echo $data['top-reaction']; ?></td></tr>

					<tr><td>Zadania matematyczne</td> <td><?php echo $data['top-math']; ?></td></tr>

					<tr><td>Glitch</td> <td><?php echo $data['gl_record']; ?>s</td></tr>

					<tr><td>Drift</td> <td><?php echo $data['drift']; ?> pkt</td></tr>

					<tr><td>Wygrane duele</td> <td><?php echo $data['top-solo']; ?></td></tr>

					<tr><td>Headshoty</td> <td><?php echo $data['top-hs']; ?></td></tr>

					<tr><td>Złowione ryby</td> <td><?php echo $data['top-fish']; ?></td></tr>

					<tr><td>Znalezione walizki</td> <td><?php echo $data['walizka']; ?></td></tr>

					<tr><td>Znalezione prezenty</td> <td><?php echo $data['prezenty']; ?></td></tr>

					<tr><td>Zabite kurczaki</td> <td><?php echo $data['kurczak']; ?></td></tr>

					<tr><td>/onede</td> <td><?php echo $data['top-onede']; ?></td></tr>

					<tr><td>/pompa</td> <td><?php echo $data['top-pompa']; ?></td></tr>

					<tr><td>/sniper</td> <td><?php echo $data['top-sniper']; ?></td></tr>

					<tr><td>/mini</td> <td><?php echo $data['top-arena']; ?></td></tr>

					<tr><td>Zalezione misie</td> <td><?php echo $data['bear']; ?></td></tr>

				</tbody>

			</table>

			

					</div>

					</div>

					<br />
					
					<p class="h3">Statystyki administratorskie</p>
					<table class="table table-striped my-0">
					<thead class="thead-dark">
						<tr>
						<th scope="col">Statystyka</th>
						<th scope="col">Wartość</th>
						</tr>
					</thead>	
					<tbody>			
						<tr>
							<td>Ilość ostrzeżeń</td>
							<td class="">
							<?php if($data['warn'] > 0) { ?>
								<div class="progress">
									<div class="progress-bar bg-<?php if($data['warn'] >= 1 && $data['warn'] < 4){ echo 'warning'; } else { echo 'danger'; } ?>" role="progressbar" style="width: <?php echo ($data['warn']/5)*100; ?>%;" aria-valuenow="<?php echo $data['warn']; ?>" aria-valuemin="0" aria-valuemax="6"><?php echo $data['warn'];?></div>
								</div>
							<?php
							} else { 
							?>
								Brak
								<?php
							} 
							?>
							</td>
						</tr>
						</tbody>		
						</table>
					
						<br><br>
						<p class="h3">Domy</p>
						<?php
						
							$getPlayerHouses = mysqli_query($connection, "SELECT name, days, expprice FROM `samp_houses` WHERE owner = '".$playerName."'");
						?>
						<table class="table">
						<thead class="thead-dark">
							<tr>
							<th scope="col">Nazwa domu</th>
							<th scope="col">Przedłużony na</th>
							<th scope="col">Cena utrzymania</th>
							</tr>
						</thead>
						<?php if(mysqli_num_rows($getPlayerHouses) !=0) { ?>
						<tbody>
						<?php 
						while($playerHouse = mysqli_fetch_array($getPlayerHouses)) { ?>
							<tr>
							<td><?php echo $playerHouse['name']; ?></td>
							<td><?php echo $playerHouse['days']; ?> dni</td>
							<td><?php echo $playerHouse['expprice']; ?> EXP</td>
							</tr>
						<?php } ?>
						</tbody>
						<?php } ?>
						</table>

						<?php
						if(isset($_SESSION['rank'])) { 
						?>
						<br />
						<p class="h3">Multikonta</p>
						<div class="table-responsive">

						<div class="table-wrapper-scroll-y my-custom-scrollbar">

						<table data-toggle="table" 

							data-classes="table table-hover table-condensed"

							data-striped="true"

							data-search="false">
						<thead class="thead-dark">
							<tr>
							<th scope="col">Nick</th>
							<th scope="col">Status</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							$selectmk = mysqli_query($connection, "SELECT `pass`, `serial`, `logged_ip` from samp_players WHERE login='".$playerName."'");
							$datamk = mysqli_fetch_assoc($selectmk);
							$querymk = mysqli_query($connection, "SELECT `id`,`login`, `register` from samp_players WHERE `logged_ip`='".$datamk['logged_ip']."' OR `pass`='".$datamk['pass']."' AND `serial`='".$datamk['serial']."' ORDER BY `wizyt` DESC LIMIT 30");
							
							while($queryData = mysqli_fetch_array($querymk)) { 
								$loginFound = $queryData['login'];
								$checkBan = mysqli_query($connection, "SELECT `nick` FROM samp_bans WHERE nick = '".$loginFound."'");
								if(mysqli_num_rows($checkBan) != 0 ) { 
									$banned = 1; 
								} else { 
									$banned = 0;
								}
								echo '<tr>';
								echo '<td><a href="index.php?page=profile&uid=' . $queryData['id'] . '">' . $queryData['login'] . '</a></td>';
								echo '<td>';
								if($banned) { 
									echo '<span class="badge badge-danger">Zbanowany</span>';
								} else { 
									echo '<span class="badge badge-success">Niezbanowany</span>';
								}
								echo '</td>';
								echo '</tr>';
							}
						?>
						</tbody>
						</table>
						</div>
						</div>
						<?php
						}
						?>
						
								</div>
											
							</div>
						

							<div class="col-sm">
							<?php 
							if($data['skin'] > 299) { 
								$skinShow = 0; 
							} else { 
								$skinShow = $data['skin']; 
							}
							?>
								<img src="https://gpp-samp.pl/img/skins/<?php echo $skinShow;?>.png" style="width: 500px; height: 350px;"/>


								<?php 
								
									$getPlayerVehicles = mysqli_query($connection, "SELECT * FROM `samp_vehicles` WHERE owner = '".$playerName."'");
									if(mysqli_num_rows($getPlayerVehicles)!=0) {
									?>
										<br />
										<div class="napis"><p class="h3">Pojazdy prywatne</p></div>
									<?php 
										while($playerVehicle = mysqli_fetch_array($getPlayerVehicles)) { 
											
											echo '<div class="card"><div class="card-body"><b>' . getCarName($playerVehicle['model']) . '</b></div><img src="https://gpp-samp.pl/img/vehicles/' . $playerVehicle['model'] . '.jpg" class="card-img-top" />';
											echo '<div class="card-body"><b>Przebieg: </b> ' . $playerVehicle['przebieg'] .' km</div></div><br />';
										}
										?>
									<?php
									}
									?>
							
						

				<?php } //koniec strony glownej profilu
				
				if(isset($_GET['mode'])) { 
					if($_GET['mode'] == 'ban') { 
						if(amIAdmin()) { 
							if($_SESSION['rank'] == 3) {
								?>
								<div class="textplace">
								<form method="POST">
									<table border="0">
									<tr>
										<td><b>Powód</b>:</td>
										<td><input type="text" name="powodbana" class="form-control" /></td>
									</tr>
									<tr>
										<td><b>Czas trwania (0 = perm)</b>:</td>
										<td><input type="text" name="czastrwania" class="form-control" /></td>
									</tr>
									</table>
									<button class="btn btn-success">Zbanuj</button>
									<?php
										if(!empty($_POST['powodbana']) && isset($_POST['czastrwania'])) { 
											$powodbana = mysqli_real_escape_string($connection, $_POST['powodbana']); 
											if(is_numeric($_POST['czastrwania'])) { 
											$czastrwania = mysqli_real_escape_string($connection, $_POST['czastrwania']); 
											if($powodbana && isset($czastrwania)) { 
													$getBanDetails = mysqli_query($connection, "SELECT * FROM `samp_players` WHERE id = '".$uid."'");
													$bandetail = mysqli_fetch_assoc($getBanDetails); 
													$bandetail_ip = $bandetail['logged_ip'];
													$bandetail_nick = $bandetail['login'];
													$czas = date("H:i");
													$databana = date("d/m/Y");
													if($czastrwania == '0') { 
														mysqli_query($connection, "INSERT INTO `samp_bans` (ip, nick, czas, data, powod, admin, dni, unban, loss, ping) VALUES ('".$bandetail_ip."','".$bandetail_nick."','".$czas."','".$databana."','".$powodbana."','".$myusername."','0','0','0','0')");
														header("Location: index.php?page=profile&uid=".$uid);
													} else { 
														mysqli_query($connection, "INSERT INTO `samp_bans` (ip, nick, czas, data, powod, admin, dni, unban, loss, ping) VALUES ('".$bandetail_ip."','".$bandetail_nick."','".$czas."','".$databana."','".$powodbana."','".$myusername."','".$czastrwania."','1','0','0')");
														header("Location: index.php?page=profile&uid=".$uid);
													}
											}
										} else { 
											echo '<br /><br /><span class="alert alert-danger">Czas trwania to nie cyfra</span>';
										}	
									}
									?>
								</form>
							
							<?php
							}
						}
					}
				}
				
				?>
			</div>
			
		</div>

		
		<br />



		<br /><br />




		<div class="w-100"><div class="napis"><p class="h3">Sygnatura</p></div></div>



		<div class="row d-flex">



			<div class="col">

			<div class="input-group mb-3">

				<img src="signature.php?uid=<?php echo $uid;?>">

				<textarea class="form-control" id="exampleFormControlTextarea1" readonly>[url=https://gpp-samp.pl/index.php?page=profile&uid=<?php echo $uid;?>][img]https://gpp-samp.pl/signature.php?uid=<?php echo $uid;?>[/img][/url]</textarea>

			</div>

			</div>

			

		</div>

		

		<?php

			}

		}

	?>

	</div>

	</div>

</body>
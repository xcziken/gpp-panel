<?php


	// Discord Bot

	function sendDiscord($hookUrl, $text) {

		$json_data = array ('content'=>"$text");

		$make_json = json_encode($json_data);

		$ch = curl_init( $hookUrl );



		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

		curl_setopt( $ch, CURLOPT_POST, 1);

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $make_json);

		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);

		curl_setopt( $ch, CURLOPT_HEADER, 0);

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec( $ch );

		return 1;

	}



	// Czas



	function hoursandmins($time, $format = '%02d:%02d')

	{

		if ($time < 1) {

			return;

		}

		$hours = floor($time / 60);

		$minutes = ($time % 60);

		return sprintf($format, $hours, $minutes);

	}

	// nazwy aut

	function getCarName($id) { 
		$VehicleName = Array(
			400 => 'landstalker', 401 => 'bravura', 402 => 'buffalo', 403 => 'linerunner', 404 => 'perenail', 405 => 'sentinel', 406 => 'dumper', 407 => 'firetruck', 408 => 'trashmaster', 409 => 'stretch', 410 => 'manana', 411 => 'infernus', 412 => 'voodoo', 413 => 'pony', 414 => 'mule', 415 => 'cheetah', 416 => 'ambulance', 417 => 'levetian', 418 => 'moonbeam', 419 => 'esperanto', 420 => 'taxi', 421 => 'washington', 422 => 'bobcat', 423 => 'mr whoopee', 424 => 'bf injection', 425 => 'hunter', 426 => 'premier', 427 => 'enforcer', 428 => 'securicar', 429 => 'banshee', 430 => 'predator', 431 => 'bus', 432 => 'rhino', 433 => 'barracks', 434 => 'hotknife', 435 => 'artic trailer 1', 436 => 'previon', 437 => 'coach', 438 => 'cabbie', 439 => 'stallion', 440 => 'rumpo', 441 => 'rc bandit',
			442 => 'romero', 443 => 'packer', 444 => 'monster', 445 => 'admiral', 446 => 'squalo', 447 => 'seasparrow', 448 => 'pizza boy', 449 => 'tram', 450 => 'artic trailer 2', 451 => 'turismo', 452 => 'speeder', 453 => 'reefer', 454 => 'tropic', 455 => 'flatbed', 456 => 'yankee', 457 => 'caddy', 458 => 'solair', 459 => 'top fun', 460 => 'skimmer', 461 => 'pcj 600', 462 => 'faggio', 463 => 'freeway', 464 => 'rc baron', 465 => 'rc raider', 466 => 'glendale', 467 => 'oceanic', 468 => 'sanchez', 469 => 'sparrow', 470 => 'patriot', 471 => 'quad', 472 => 'coastgaurd', 473 => 'dinghy', 474 => 'hermes', 475 => 'sabre', 476 => 'rustler', 477 => 'zr 350', 478 => 'walton', 479 => 'regina', 480 => 'comet', 481 => 'bmx', 482 => 'burriro', 483 => 'camper', 484 => 'marquis', 485 => 'baggage', 
			486 => 'dozer', 487 => 'maverick', 488 => 'vcn maverick', 489 => 'rancher', 490 => 'fbi rancher', 491 => 'virgo', 492 => 'greenwood', 493 => 'jetmax', 494 => 'hotring', 495 => 'sandking', 496 => 'blistac', 497 => 'police maverick', 498 => 'boxville', 499 => 'benson', 500 => 'mesa', 501 => 'rc goblin', 502 => 'hotring a', 503 => 'hotring b', 504 => 'blood ring banger', 505 => 'rancher (lure)', 506 => 'super gt', 507 => 'elegant', 508 => 'journey', 509 => 'bike', 510 => 'mountain bike', 511 => 'beagle', 512 => 'cropduster', 513 => 'stuntplane', 514 => 'petrol', 515 => 'roadtrain', 516 => 'nebula', 517 => 'majestic', 518 => 'buccaneer', 519 => 'shamal', 520 => 'hydra', 521 => 'fcr 900', 522 => 'nrg 500', 523 => 'hpv 1000', 524 => 'cement', 525 => 'towtruck', 526 => 'fortune',
			527 => 'cadrona', 528 => 'fbi truck', 529 => 'williard', 530 => 'fork lift', 531 => 'tractor', 532 => 'combine', 533 => 'feltzer', 534 => 'remington', 535 => 'slamvan', 536 => 'blade', 537 => 'freight', 538 => 'streak', 539 => 'vortex', 540 => 'vincent', 541 => 'bullet', 542 => 'clover', 543 => 'sadler', 544 => 'firetruck la', 545 => 'hustler', 546 => 'intruder', 547 => 'primo', 548 => 'cargobob', 549 => 'tampa', 550 => 'sunrise', 551 => 'merit', 552 => 'utility van', 553 => 'nevada', 554 => 'yosemite', 555 => 'windsor', 556 => 'monster a', 557 => 'monster b', 558 => 'uranus', 559 => 'jester', 560 => 'sultan', 561 => 'stratum', 562 => 'elegy', 563 => 'raindance', 564 => 'rc tiger', 565 => 'flash', 566 => 'tahoma', 567 => 'savanna', 568 => 'bandito', 569 => 'freight flat',
			570 => 'streak', 571 => 'kart', 572 => 'mower', 573 => 'duneride', 574 => 'sweeper', 575 => 'broadway', 576 => 'tornado', 577 => 'at 400', 578 => 'dft 30', 579 => 'huntley', 580 => 'stafford', 581 => 'bf 400', 582 => 'news van', 583 => 'tug', 584 => 'petrol tanker', 585 => 'emperor', 586 => 'wayfarer', 587 => 'euros', 588 => 'hotdog', 589 => 'club', 590 => 'freight box', 591 => 'artic trailer 3', 592 => 'andromada', 593 => 'dodo', 594 => 'rc cam', 595 => 'launch', 596 => 'cop car ls', 597 => 'cop car sf', 598 => 'cop car lv', 599 => 'ranger', 600 => 'picador', 601 => 'swat tank', 602 => 'alpha', 603 => 'phoenix', 604 => 'glendale (damage)', 605 => 'sadler (damage)', 606 => 'bag box a', 607 => 'bag box b', 608 => 'stairs', 609 => 'boxville (black)', 610 => 'farm trailer', 611 => 'utility van trailer'
		);
		
		return ucfirst($VehicleName[$id]);
	}

	//sprawdzenie czy gracz jest zalogowanym adminem
	function amIAdmin() { 
		if(isset($_SESSION['admin'])) { 
			return true;
		} else { 
			return false;
		}
	}

	//sprawdzenie czy gracz jest adminem, niewazne czy zalogowany czy nie
	function checkAdmin($connection,$nickname) { 
		$checkadmin = mysqli_query($connection, "SELECT * FROM `samp_admins` WHERE login = '".$nickname."'");
		if(mysqli_num_rows($checkadmin) != 0) { 
			return true;
		} else { 
			return false;
		}
	}

	function getPlayerStats($connection, $uid, $row) { 
		$getData = mysqli_query($connection, "SELECT $row FROM `samp_players` WHERE id = '".$uid."'");
		$data = mysqli_fetch_assoc($getData);
		return $data[$row];
	}
	
	function isLoggedIn() { 
		if(isset($_SESSION['logged'])) { 
			return true;
		} else { 
			return false;
		}
	}
//rangi 

	function getAdminRank($rank) { 
		$array = array('Moderator','Admin', 'Vice Head-Admin','Head-Admin');
		if($rank == 'getCount') { 
			return count($array);
		}
		if($rank == 'test') { 
			var_dump($array);
		}
		return $array[$rank];
	}
//konfiguracja panelu

	function getPanelConfig($connection, $configname) { 
		$getConfig = mysqli_query($connection, "SELECT * FROM `panel_settings`"); 
		$config = mysqli_fetch_assoc($getConfig); 
		return $config[$configname];
	}
?>

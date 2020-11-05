<?php
    require_once('../config/db.php');
    
    $topInfo = array (
        "1" => array("exp",             "EXP"           ), 
        "2" => array("kills",           "Zabójstw"      ), 
        "3" => array("deaths",          "Zgonów"        ),
        "4" => array("godziny",         "Godzin"        ), 
        "5" => array("wizyt",           "Wizyt"         ),
        "6" => array("bank",            "Bank"          ), 
        "7" => array("drift",           "Punkty"        ),
        "8" => array("top-fish",        "Ryby"          ), 
        "9" => array("top-solo",        "Duele"         ),
        "10" => array("top-hs",         "Headshotów"    ),

        "11" => array("top-killstreak", "Killstreak"    ), 
        "12" => array("top-code",       "Rozsypanek"    ), 
        "13" => array("top-reaction",   "Kodów"         ),
        "14" => array("top-math",       "Rozwiązań"     ), 
        "15" => array("top-arena",      "Minigun"       ),
        "16" => array("top-onede",      "Onede"         ), 
        "17" => array("top-pompa",      "Pompa"         ),
        "18" => array("top-sniper",     "Sniper"        ), 
        "19" => array("kurczak",        "Zabite kurczaki"),
        "20" => array("top-truck",      "Spedycja"       ),

        "21" => array("prezenty",       "Prezenty"       ),
        "22" => array("walizka",        "Walizki"        ), 
        "23" => array("pula",           "Wygrane pule"   ),
        "24" => array("zolwie",         "Żółwie"          ), 
        "25" => array("MVP",            "MVP"            ),
        "26" => array("top-loteria",    "Wygrane loterie"),
        "27" => array("bear",           "Znalezione misie"),

    );

    $pos = 0;
    $id = mysqli_real_escape_string($connection, $_POST['type']);
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css">

	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>

	<style>
	.my-custom-scrollbar {
		position: relative;
		max-height: 500px;
		overflow: auto;
	}
		
	.table-wrapper-scroll-y {
		display: block;
	}
	</style>
</head>

<body class="d-flex flex-column text-center">
<div class="table-responsive">
    <div class="table-wrapper-scroll-y my-custom-scrollbar text-center">
		
        <table data-toggle="table" 
		   data-classes="table table-hover table-condensed"
		   data-striped="true"
		   data-search="false"
		>
		<thead class="thead-dark">
		<tr>
			<th class="col-xs-4" data-field="Nr" data-sortable="true">#</th>
			<th class="col-xs-4" data-field="Nazwa" data-sortable="true">Nick</th>
			<th class="col-xs-2" data-field="Punkty" data-sortable="true"><?php echo $topInfo[$id][1]; ?></th>
		</tr>
		</thead>
		<tbody>

<?php
    $query = mysqli_query($connection, 'SELECT `id`, `login`, `'.$topInfo[$id][0].'` FROM `samp_players` ORDER BY `'.$topInfo[$id][0].'` DESC LIMIT 20');
		
    while($queryRes = mysqli_fetch_array($query)) { 
        $pos++;
    ?>
        <tr id="tr-id-2" class="tr-class-2">
			<td><?php echo $pos ?></td>
			<td><a href=index.php?page=profile&uid=<?php echo $queryRes['id']; ?>><?php echo $queryRes['login']; ?></a></td>
			<td><?php echo $queryRes[$topInfo[$id][0]]; ?></td>
		</tr>

    <?php
    }
?>

</tbody>
</table>
</div>
</div>
</body>
</html>
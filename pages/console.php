<!DOCTYPE html>
<head>
	<title>Konsola</title>

    <script src="http://creativecouple.github.com/jquery-timing/jquery-timing.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    
    <script>
    $(function() {
        $.repeat(1000, function() {
            $.get('API/fetchconsole.php?ajax', function(data) {
                $('#tail').html(data);
            });
        });
    });
    </script>

    <style>
    .konsola {
		position: relative;
		max-height: 500px;
		overflow: auto;
        font-family: 'Lato', sans-serif;
        letter-spacing: 2px;
	}
    </style>

</head>

<body class="d-flex flex-column">
    <main role="main" class="container">
    <?php
	if(isset($_SESSION['logged']) and $_SESSION['logged'] and $_SESSION['rank'] > 2)
	{
    ?>
        <h1 class="display-4">Konsola</h1>
        <div id="tail" class="konsola">
            <div class="spinner-border text-primary" role="status"></div>
        </div>
    <?php
	}
	else
	{
		echo '
		<div class="alert alert-warning" role="alert">
            Nie posiadasz uprawnień do przeglądania tej strony.
		</div>
		';	
	}
    ?>
</main>
</body>
<!DOCTYPE html>

<head>
	<title>Gold Party Polska - TOP</title>

    <style>
    .list-group{
        position: relative;
		max-height: 500px;
		overflow: auto;
    }
    </style>

    <script>
	function fetchData(clicked_id)
	{
         $.ajax({

            type: "post",
            url: "API/fetchtop.php",
            data:{type:clicked_id},

            success:function(data) {

                $('#toplist').html(data);
            }
        });
	}
	</script>

    <script>
    var body = document.getElementsByTagName("body")[0];
       
    body.onload = function() {
       fetchData("1");
    };
    </script>
</head>


<body class="d-flex flex-column text-center">
<div class="container">
<div class="napis"><h1>TOP</h1></div>
<div class="textplace_soft">
<div class="row">
    <div class="col-md-auto">

    <select class="browser-default custom-select" onchange="fetchData(this.value)">
        <option value="1" selected>EXP</option>
        <option value="2">Zabójstw</option>
        <option value="3">Zgonów</option>
        <option value="4">Online</option>
        <option value="5">Wizyt</option>
        <option value="6">Bank</option>
        <option value="7">Driftscore</option>
        <option value="8">Złowione ryby</option>
        <option value="9">Wygrane duele</option>
        <option value="10">Headshot</option>

        <option value="11">Killstreak</option>
        <option value="12">Rozsypanki</option>
        <option value="13">Kody</option>
        <option value="14">Matematyka</option>
        <option value="15">/mini</option>
        <option value="16">/onede</option>
        <option value="17">/pompa</option>
        <option value="18">/sniper</option>
        <option value="19">Kurczaki</option>
        <option value="20">Spedycja</option>

        <option value="21">Prezenty</option>
        <option value="22">Walizka</option>
        <option value="23">Pula</option>
        <option value="24">Żółwie</option>
        <option value="25">MVP</option>
        <option value="26">Loteria</option>
        <option value="27">Znalezione misie</option>
    </select>

    </div>
    <div class="col">
        <div id="toplist"></div>
    </div>
</div>
</div>
</div>
</body>


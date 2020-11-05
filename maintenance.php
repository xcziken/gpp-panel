<?php 
require_once('config/functions.php'); 
require_once('config/db.php'); 
if(getPanelConfig($connection, 'devmode') == 0 && getPanelConfig($connection, 'sklepoff') == 0) { 
    header("Location: index.php");
}

?>
<html>
<head>
    <meta charset="utf-8" />
    <title>GPP - Przerwa techniczna</title>
</head>
<body>
Aktualnie odbywa się przerwa techniczna. Spróbuj ponownie później. Jeżeli chcesz, odwiedź nasze <a href="http://forum.gpp-samp.pl">forum</a>
</body>
</html>
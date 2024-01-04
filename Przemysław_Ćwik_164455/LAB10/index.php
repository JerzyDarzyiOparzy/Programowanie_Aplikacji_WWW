<?php
session_start();
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Przemysław Ćwik" />
    <title>Europę da się lubić</title>
    
    <link rel="stylesheet" href="../css/style.css" type="text/css" />
    <link rel="stylesheet" href="../css/menu.css" type="text/css" />
    
    <link href='http://fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    
    <script src="../js/timedate.js" type="application/javascript"></script>
    <script src="../js/zmien_tlo.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="startclock()">
    
    <div class="menu">
        <ul>
            <li><a href="index.php">Strona Główna</a></li>
            <li><a href="index.php?idp=2">Ciekawostki</a></li>
            <li><a href="index.php?idp=3">Galeria</a></li>
            <li><a href="index.php?idp=4">Polska</a></li>
            <li><a href="index.php?idp=5">Kontakt</a></li>
            <li><a href="index.php?idp=6">Filmy</a></li>
            <div style="color: black; font-size: 30px; margin-top: 9px" id="zegarek"></div>
            <div style="color: black; font-size: 30px; margin-top: 9px" id="data"></div>
        </ul>
        <button onclick="changeBackgroundColor()">Zmień Kolor</button>
        <button onclick="changeBackgroundImage()">Zmień Obrazek</button>
    </div>

<?php
include 'cfg.php';
include 'showpage.php';
include 'admin/admin.php';


if (isset($_GET['idp'])) {
	if ($_GET['idp'] == -1) {
		echo LoginAdmin();
	}
	else if ($_GET['idp'] == -2) {
		echo CreatePage();
	}
	else if ($_GET['idp'] == -3) {
		echo EditPage();
	}
	else if ($_GET['idp'] == -4) {
		echo DeletePage();
	}
	else {
		echo PokazPodstrone($_GET['idp']);
	}
}
else {
	$_GET['idp']=1;
	echo PokazPodstrone($_GET['idp']);
}

if ($_GET['idp'] == 1) {
	$_GET["user"] = 'Przemysław Ćwik';
	$nr_indeksu = '164455';
	echo '<br /><br />Autor: '.htmlspecialchars($_GET["user"]).'; id '.$nr_indeksu.' <br />';
}

?>


</body>
</html>

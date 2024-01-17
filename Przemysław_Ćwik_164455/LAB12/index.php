<!DOCTYPE HTML>
<html lang="pl">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Przemysław Ćwik" />
    <title>Europę da się lubić</title>
    
    <link rel="stylesheet" href="./css/style.css" type="text/css" />
    <link rel="stylesheet" href="./css/menu.css" type="text/css" />
    
    <link href='http://fonts.googleapis.com/css?family=Lato:400,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    
    <script src="./js/timedate.js" type="application/javascript"></script>
    <script src="./js/zmienTlo.js" type="application/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="startclock()">
    
    <div class="menu">
        <ul>
            <li><a href="index.php?idp=1">Strona Główna</a></li>
            <li><a href="index.php?idp=2">Ciekawostki</a></li>
            <li><a href="index.php?idp=3">Galeria</a></li>
            <li><a href="index.php?idp=4">Polska</a></li>
            <li><a href="index.php?idp=5">Kontakt</a></li>
            <li><a href="index.php?idp=6">Filmy</a></li>
            <li><a href="admin/sklepik.php">Sklepik</a></li>
            <div style="color: black; font-size: 30px; margin-top: 9px" id="zegarek"></div>
            <div style="color: black; font-size: 30px; margin-top: 9px" id="data"></div>
        </ul>
        <button onclick="changeBackgroundColor()">Zmień Kolor</button>
        <button onclick="changeBackgroundImage()">Zmień Obrazek</button>
    </div>

		<?php
		include('./admin/cfg.php');
		include('./admin/showpage.php');
		
		if (empty($_GET['idp'])) {
			$strona_id = 1;
		} else {
			$strona_id = $_GET['idp'];
		}
		
		$tresc_strony = PokazPodstrone($strona_id);
		
		if ($tresc_strony === '[nie_znaleziono_strony]') {
			echo 'UPS strony nie ma';
		} else {
			echo $tresc_strony;
		}
     $nr_indeksu = '164455';
     $nrGrupy = '2';

     echo'Przemysław Ćwik'.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
    ?>


</body>
</html>

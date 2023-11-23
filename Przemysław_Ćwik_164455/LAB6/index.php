<?php
include('./cfg.php');

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$strona = "./html/glowna.html";

if (isset($_GET['idp'])) {
    switch ($_GET['idp']) {
        case 'ciekawostki':
            $strona = "./html/ciekawostki.html";
            break;
        case 'galeria':
            $strona = "./html/galeria.html";
            break;
        case 'Polska':
            $strona = "./html/polska.html";
            break;        
        case 'kontakt':
            $strona = "./html/kontakt.html";
            break;
        case 'filmy':
            $strona = "./html/filmy.html";
            break;

    }
}

?>

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
    <script src="./js/zmien_tlo.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="startclock()">
    
    <div class="menu">
        <ul>
            <li><a href="index.php">Strona Główna</a></li>
            <li><a href="index.php?idp=ciekawostki">Ciekawostki</a></li>
            <li><a href="index.php?idp=galeria">Galeria</a></li>
            <li><a href="index.php?idp=Polska">Polska</a></li>
            <li><a href="index.php?idp=kontakt">Kontakt</a></li>
            <li><a href="index.php?idp=filmy">Filmy</a></li>
            <div style="color: black; font-size: 30px; margin-top: 9px" id="zegarek"></div>
            <div style="color: black; font-size: 30px; margin-top: 9px" id="data"></div>
        </ul>
        <button onclick="changeBackgroundColor()">Zmień Kolor</button>
        <button onclick="changeBackgroundImage()">Zmień Obrazek</button>
    </div>

    <div id="content">
        <?php
        if (file_exists($strona)) {
            include($strona);
        } else {
            echo "<p>Strona nie istnieje.</p>";
        }
        ?>
    </div>
    <?php
     $nr_indeksu = '164455';
     $nrGrupy = '2';

     echo'Przemysław Ćwik'.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
    ?>


</body>
</html>

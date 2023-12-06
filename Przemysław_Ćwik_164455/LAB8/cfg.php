<?php

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';
    $login = 'admin';
    $pass = 'admin';

    $link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);

    if (!$link) {
        die('Błąd połączenia z bazą danych: ' . mysqli_connect_error());
    }
?>

<?php
require('cfg.php');

try {
if (isset($_POST['title']) && isset($_POST['opis']) && isset($_POST['data']) && isset($_POST['netto']) && isset($_POST['vat']) && isset($_POST['number']) && isset($_POST['category']) && isset($_POST['weight']) && isset($_POST['photo'])) {
    $tytul = htmlspecialchars($_POST['title']);
    $opis = htmlspecialchars($_POST['opis']);
    $data_utworzenia = date('Y-m-d');
    $data_modyfikacji = date('Y-m-d');
    $data_wygasniecia = htmlspecialchars($_POST['data']);
    $cena_netto = htmlspecialchars($_POST['netto']);
    $podatek_vat = htmlspecialchars($_POST['vat']);
    $ilosc = htmlspecialchars($_POST['number']);
    if ($ilosc > 0 && $data_wygasniecia >= date('Y-m-d')) {
        $dostepnosc = true;
    } else {
        $dostepnosc = false;
    }
    $kategoria = htmlspecialchars($_POST['category']);
    $gabaryt = htmlspecialchars($_POST['weight']);
    $zdjecie = htmlspecialchars($_POST['photo']);

    $query = "INSERT INTO produkty (tytul, opis, data_utworzenia, data_modyfikacji, data_wygasniecia, cena_netto, podatek_vat, ilosc, dostepnosc, kategoria, gabaryt, zdjecie ) VALUES ('$tytul', '$opis',  '$data_utworzenia', '$data_modyfikacji', '$data_wygasniecia', '$cena_netto', '$podatek_vat', '$ilosc', '$dostepnosc', '$kategoria', '$gabaryt', '$zdjecie')";
    $result = mysqli_query($link, $query);
    header('Location: produkty.php');
}   
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
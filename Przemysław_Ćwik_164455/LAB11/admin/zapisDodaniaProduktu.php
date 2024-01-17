<?php
require('cfg.php');

if (isset($_POST['zapisz'])) {
    if (isset($_POST['title']) && isset($_POST['opis']) && isset($_POST['data']) && isset($_POST['netto']) && isset($_POST['vat']) && isset($_POST['number']) && isset($_POST['category']) && isset($_POST['weight']) && isset($_POST['photo'])) {
        $id = htmlspecialchars($_GET['id']);
        $tytul = htmlspecialchars($_POST['title']);
        $opis = htmlspecialchars($_POST['opis']);
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

     $query = "UPDATE produkty SET tytul = '$title', opis = '$opis', data_modyfikacji = '$data_modyfikacji', data_wygasniecia = '$data_wygasniecia', cena_netto = '$cena_netto', podatek_vat = '$podatek_vat', ilosc = '$ilosc', dostepnosc = '$dostepnosc', kategoria = '$kategoria', gabaryt = '$gabaryt', zdjecie = '$zdjecie' WHERE id = '$id' LIMIT 1";
     $result = mysqli_query($link, $query);

     if ($result) {
        echo "Zaktualizowano produkt :)";
        header("Location: produkty.php");
    } else {
        echo "Błąd aktualizacji produktu :(";
    }
 }
}
else {
    echo "Dane nie zostały przesłane :(";
}
?>
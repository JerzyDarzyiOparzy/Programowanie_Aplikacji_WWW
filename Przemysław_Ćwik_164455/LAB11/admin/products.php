<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admincss.css">
    <title>Produkty | Sklep</title>
</head>
<body>
<?php
session_start();
// Dodanie parametrów z pliku cfg.php w celu połączenia z bazą danych
require('cfg.php');

function PokazProduktID() {
    global $link;
    $id = htmlspecialchars($_GET['id']);

    // Pobranie danych z bazy danych
    $query = "SELECT id, tytul, opis, cena_netto, data_wygasniecia, podatek_vat, ilosc, dostepnosc, kategoria, gabaryt, zdjecie FROM produkty WHERE id = '$id'";
    $result = mysqli_query($link, $query);

    // Sprawdzenie czy zapytanie zwróciło wyniki
    if ($result) {
        // Iteracja po wynikach zapytania
        while ($row = mysqli_fetch_assoc($result)) {
            $tytul = $row['tytul'];
            $opis = $row['opis'];
            $cena_netto = $row['cena_netto'];
            $data_wygasniecia = $row['data_wygasniecia'];
            $podatek_vat = $row['podatek_vat'];
            $ilosc = $row['ilosc'];
            $dostepnosc = $row['dostepnosc'] == 1 ? "Dostępne" : "Niedostępne";
            $kategoria = $row['kategoria'];
            $gabaryt = $row['gabaryt'];
            $zdjecie = $row['zdjecie'];

            if ($row['kategoria'] == 1) {
                $kategoria = "Mangi";
            } else if ($row['kategoria'] == 2) {
                $kategoria = "Filmy";
            } else if ($row['kategoria'] == 3) {
                $kategoria = "Ubrania";
            }

            $cena = $cena_netto + ($podatek_vat * $cena_netto)/100;

            $wynik = '<a href="products.php">Powrót</a><h2>Kategoria: '.$kategoria.'</h2>';
            // Dodanie wiersza odpowiadającego produktowi do tabeli
            $wynik .= '<h3>Produkt: '.$tytul.'</h3><br /><br /><div style="display: flex; flex-direction: row; gap:20px;"><img width="20%" height="20%" src="'.$zdjecie.'"/>';
            $wynik .= '<div style="display: flex; flex-direction:column; gap:20px;"><p style="font-size: 1.2em;">Opis: '.$opis.'</p><h2>Cena: '.$cena.'zł</h2><p>Status dostępności: '.$dostepnosc.'!</p>';
            $wynik .= '<form action="cart.php" method="POST">';
            $wynik .= '<input type="hidden" name="id" value="'.$id.'">';
            $wynik .= '<input type="hidden" name="title" value="'.$tytul.'">';
            $wynik .= '<input type="hidden" name="description" value="'.$opis.'">';
            $wynik .= '<input type="hidden" name="price" value="'.$cena.'">';
            $wynik .= '<input type="hidden" name="weight" value="'.$gabaryt.'">';
            $wynik .= '<input type="hidden" name="photo" value="'.$zdjecie.'">';
            $wynik .= '<button type="submit" style="width: 200px; height: 30px; background-color: red; outline: none; border: none; cursor: pointer;">Dodaj do koszyka!</button></form></div></div>';
        }
    } else {
        // Wyświetlenie komunikatu o braku profuktów
        $wynik = '<tr><td colspan="3">Brak produktów do wyświetlenia.</td></tr>';
    }

    echo $wynik;
}

function PokazProdukty() {
    global $link;
    if (isset($_GET['kategoria'])) {
        $category = htmlspecialchars($_GET['kategoria']);
    } else {
        $category = "Mangi";
    }
    $wynik = '<a href="./sklepik.php">Powrót</a><h3>Produkty:</h3>'.'<table class="tabela_akcji" style="width: 1400px;">'.'<tr><th>ID</th><th>Tytuł</th><th>Opis</th><th>Cena</th><th>Ilosc</th><th>Dostepnosc</th><th>Kategoria</th><th>Gabaryt</th><th>Zdjecie</th></tr>';

    // Pobranie danych z bazy danych
    $query = "SELECT produkty.id, tytul, opis, cena_netto, data_wygasniecia, podatek_vat, ilosc, dostepnosc, kategoria, gabaryt, zdjecie FROM produkty JOIN shop WHERE produkty.kategoria = shop.id AND shop.nazwa = '$category'";
    $result = mysqli_query($link, $query);

    // Sprawdzenie czy zapytanie zwróciło wyniki
    if ($result) {
        // Iteracja po wynikach zapytania
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $tytul = $row['tytul'];
            $opis = $row['opis'];
            $cena_netto = $row['cena_netto'];
            $data_wygasniecia = $row['data_wygasniecia'];
            $podatek_vat = $row['podatek_vat'];
            $ilosc = $row['ilosc'];
            $dostepnosc = $row['dostepnosc'] == 1 ? "Dostępne" : "Niedostępne";
            $kategoria = $row['kategoria'];
            $gabaryt = $row['gabaryt'];
            $zdjecie = $row['zdjecie'];

            $cena = $cena_netto + ($podatek_vat * $cena_netto)/100;

            if ($ilosc > 0 && $data_wygasniecia > date('d-m-Y')) {
                $dostepnosc = true;
            } else {
                $dostepnosc = false;
            }

            // Dodanie wiersza odpowiadającego produktowi do tabeli
            $wynik .= '<tr>'.'<td>' . $id . '</td>'.'<td><a href="products.php?id='.$id.'">'. $tytul . '</a></td>'.'<td>' . $opis . '</td>'.'<td>' . $cena . '</td>'.'<td>' . $ilosc . '</td>'.'<td>' . $dostepnosc . '</td>'.'<td>' . $kategoria . '</td>'.'<td>' . $gabaryt . '</td>'.'<td style="width: 10%; max-height: 100%;"><img style="width: 65px; height: 100px;" src="'.$zdjecie.'"/></td>'.'</tr>';
        }
    } else {
        // Wyświetlenie komunikatu o braku profuktów
        $wynik .= '<tr><td colspan="3">Brak produktów do wyświetlenia.</td></tr>';
    }

    $wynik .= '</table>';

    echo $wynik;
}

if (!isset($_GET['id'])) {
    echo PokazProdukty();
} else if (!isset($_GET['action'])) {
    echo PokazProduktID();
}
?>
</body>
</html>
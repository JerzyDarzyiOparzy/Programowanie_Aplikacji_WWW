<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkty | Sklep</title>
</head>
<body>
<?php
require('cfg.php');

function DodajProdukt() {
    $wynik = '<h3>Dodaj produkt:</h3>'.'<form method="POST" action="dodanieProduktu.php">';
    $wynik .= 'Tytul: <input class="tytul" type="text" name="title" value=""><br /> <br />';
    $wynik .= 'Opis: <textarea class="tresc" rows=20 cols=100 name="opis"></textarea><br /> <br />';
    $wynik .= 'Data wygaśnięcia: <input class="tytul" type="date" name="data" value=""><br /> <br />';
    $wynik .= 'Cena netto: <input class="tytul" type="text" name="netto" value=""><br /> <br />';
    $wynik .= 'Podatek VAT: <input class="tytul" type="number" name="vat" value=""><br /> <br />';
    $wynik .= 'Ilość sztuk w magazynie: <input class="tytul" type="number" name="number" value=""><br /> <br />';
    $wynik .= 'Kategoria: <input class="tytul" type="number" name="category" value=""><br /> <br />';
    $wynik .= 'Gabaryt produktu: <input class="tytul" type="text" name="weight" value=""><br /> <br />';
    $wynik .= 'Zdjęcie: <input class="tytul" type="text" name="photo" value=""><br /> <br />';
    $wynik .= '<input class="zapisz" type="submit" value="Dodaj">'.'</form>';
    
    return $wynik;
}

function UsunProdukt() {
    global $link;

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
    } else {
        echo "Nie ma produktu danym ID :(";
        exit;
    }

    $query = "DELETE FROM produkty WHERE id = $id LIMIT 1";
    $result = mysqli_query($link, $query);

    if ($result) {
        echo "Usunięto produkt :)";
        header("Location: produkty.php");
    } else {
        echo "Produktu nie usunięto :(";
        exit;
    }
}

function EdytujProdukt() {
    global $link;

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
    } else {
        echo "Nie ma produktu danym ID :(";
        exit;
    }

    $query = "SELECT tytul, opis, data_wygasniecia, cena_netto, podatek_vat, ilosc, kategoria, gabaryt, zdjecie FROM produkty WHERE id = '$id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0 && $result) {
        $row = mysqli_fetch_assoc($result);
        $tytul = $row['tytul'];
        $opis = $row['opis'];
        $data_wygasniecia = $row['data_wygasniecia'];
        $cena_netto = $row['cena_netto'];
        $podatek_vat = $row['podatek_vat'];
        $ilosc = $row['ilosc'];
        $kategoria = $row['kategoria'];
        $gabaryt = $row['gabaryt'];
        $zdjecie = $row['zdjecie'];

        $wynik = '<h3>Edycja Produktu o id:'.$id.'</h3>'.'<form method="POST" action="zapisDodaniaProduktu.php?id='.$id.'">';
        $wynik .= 'Tytul: <input class="tytul" type="text" name="title" value="'.$tytul.'"><br /> <br />';
        $wynik .= 'Opis: <textarea class="tresc" rows=20 cols=100 name="opis">'.$opis.'</textarea><br /> <br />';
        $wynik .= 'Data wygaśnięcia: <input class="tytul" type="date" name="data" value="'.$data_wygasniecia.'"><br /> <br />';
        $wynik .= 'Cena netto: <input class="tytul" type="text" name="netto" value="'.$cena_netto.'"><br /> <br />';
        $wynik .= 'Podatek VAT: <input class="tytul" type="number" name="vat" value="'.$podatek_vat.'"><br /> <br />';
        $wynik .= 'Ilość sztuk w magazynie: <input class="tytul" type="number" name="number" value="'.$ilosc.'"><br /> <br />';
        $wynik .= 'Kategoria: <input class="tytul" type="number" name="category" value="'.$kategoria.'"><br /> <br />';
        $wynik .= 'Gabaryt produktu: <input class="tytul" type="text" name="weight" value="'.$gabaryt.'"><br /> <br />';
        $wynik .= 'Zdjęcie: <input class="tytul" type="text" name="photo" value="'.$zdjecie.'"><br /> <br />';
        $wynik .= '<input class="zapisz" type="submit" name="zapisz" value="zapisz">'.'</form>';

        return $wynik;
    }
}

function PokazProduktID() {
    global $link;
    $id = htmlspecialchars($_GET['id']);

    $query = "SELECT id, tytul, opis, cena_netto, data_wygasniecia, podatek_vat, ilosc, dostepnosc, kategoria, gabaryt, zdjecie FROM produkty WHERE id = '$id'";
    $result = mysqli_query($link, $query);

    if ($result) {
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
                $kategoria = "Czechy";
            } else if ($row['kategoria'] == 2) {
                $kategoria = "Hiszpania";
            } else if ($row['kategoria'] == 3) {
                $kategoria = "Szwajcaria";
            }

            $cena = $cena_netto + ($podatek_vat * $cena_netto)/100;

            $wynik = '<a href="produkty.php">Powrót</a><h2>Kategoria: '.$kategoria.'</h2>';
            $wynik .= '<h3>Produkt: '.$tytul.'</h3><br /><br /><div style="display: flex; flex-direction: row; gap:20px;"><img width="20%" height="20%" src="'.$zdjecie.'"/>';
            $wynik .= '<div style="display: flex; flex-direction:column; gap:20px;"><p style="font-size: 1.2em;">Opis: '.$opis.'</p><h2>Cena: '.$cena.'zł</h2><p>Status dostępności: '.$dostepnosc.'!</p>';
            $wynik .= '<button style="width: 100px; height: 30px; background-color: red; outline: none; border: none; cursor: pointer;">Kup!</button></div></div>';
        }
    } else {
        $wynik = '<tr><td colspan="3">Brak produktów do wyświetlenia.</td></tr>';
    }

    echo $wynik;
}
function PokazProdukty() {
    global $link;
    $category = htmlspecialchars($_GET['kategoria']);

    $wynik = '<a href="./sklepik.php">Powrót</a><h3>Produkty:</h3>'.'<table class="tabela_akcji" style="width: 1400px;">'.'<tr><th>ID</th><th>Tytuł</th><th>Opis</th><th>Cena</th><th>Ilosc</th><th>Dostepnosc</th><th>Kategoria</th><th>Gabaryt</th><th>Zdjecie</th><th>Akcje</th></tr>';
    $wynik .= '<a href="'.$_SERVER['PHP_SELF'].'?action=dodaj">Dodaj produkt</a> <br /> <br />';

    $query = "SELECT produkty.id, tytul, opis, cena_netto, data_wygasniecia, podatek_vat, ilosc, dostepnosc, kategoria, gabaryt, zdjecie FROM produkty JOIN shop WHERE produkty.kategoria = shop.id AND shop.nazwa = '$category'";
    $result = mysqli_query($link, $query);

    if ($result) {
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

            $wynik .= '<tr>'.'<td>' . $id . '</td>'.'<td><a href="produkty.php?id='.$id.'">'. $tytul . '</a></td>'.'<td>' . $opis . '</td>'.'<td>' . $cena . '</td>'.'<td>' . $ilosc . '</td>'.'<td>' . $dostepnosc . '</td>'.'<td>' . $kategoria . '</td>'.'<td>' . $gabaryt . '</td>'.'<td style="width: 10%; max-height: 100%;"><img style="width: 65px; height: 100px;" src="'.$zdjecie.'"/></td>'.'<td><a href="'.$_SERVER['PHP_SELF'].'?action=edytuj&id='.$id.'">Edytuj</a> | <a href="'.$_SERVER['PHP_SELF'].'?action=usun&id='.$id.'">Usuń</a></td>'.'</tr>';
        }
    } else {
        $wynik .= '<tr><td colspan="3">Brak produktów do wyświetlenia.</td></tr>';
    }

    $wynik .= '</table>';

    echo $wynik;

    if (isset($_GET['action'])) {
        $action = htmlspecialchars($_GET['action']);
        if ($action === 'edytuj' && isset($_GET['id'])) {
            echo EdytujProdukt();
        } else if ($action === 'usun' && isset($_GET['id'])) {
            echo UsunProdukt();
        } else if ($action === 'dodaj') {
            echo DodajProdukt();
        }
    }
}

if (!isset($_GET['id'])) {
    echo PokazProdukty();
} else if (!isset($_GET['action'])) {
    echo PokazProduktID();
} else {
     if (isset($_GET['action'])) {
        $action = htmlspecialchars($_GET['action']);
        if ($action === 'edytuj' && isset($_GET['id'])) {
            echo EdytujProdukt();
        } else if ($action === 'usun' && isset($_GET['id'])) {
            echo UsunProdukt();
        } else if ($action === 'dodaj') {
            echo DodajProdukt();
        }
}
}

?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produkty w Sklepie</title>
</head>
<body>
<?php
session_start();

$full_price = 0;
$full_weight = 0;

if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['weight']) && isset($_POST['photo'])) {
    if (!isset($_SESSION['count'])) {
        $_SESSION['count'] = 1;
    } else {
        $_SESSION['count']++;
    }

    $id = htmlspecialchars($_POST['id']);
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $price = htmlspecialchars($_POST['price']);
    $weight = htmlspecialchars($_POST['weight']);
    $photo = htmlspecialchars($_POST['photo']);
    $ile_sztuk = 1;

    for ($i = 1; $i <= $_SESSION['count']; $i++) {
        if ($_SESSION[$i.'_1'] == $id) {
            $_SESSION[$i.'_2']++;
            header('Location: koszyk.php');
            exit();
        }
    }

    $nr = $_SESSION['count'];

    $prod[$nr]['id_prod'] = $id;
    $prod[$nr]['ile_sztuk'] = $ile_sztuk;
    $prod[$nr]['tytul'] = $title;
    $prod[$nr]['opis'] = $description;
    $prod[$nr]['cena'] = $price;
    $prod[$nr]['waga'] = $weight;
    $prod[$nr]['zdjecie'] = $photo;
    $prod[$nr]['data'] = time();

    $nr_0 = $nr.'_0';
    $nr_1 = $nr.'_1';
    $nr_2 = $nr.'_2';
    $nr_3 = $nr.'_3';
    $nr_4 = $nr.'_4';
    $nr_5 = $nr.'_5';
    $nr_6 = $nr.'_6';
    $nr_7 = $nr.'_7';
    $nr_8 = $nr.'_8';

    $_SESSION[$nr_0] = $nr;
    $_SESSION[$nr_1] = $prod[$nr]['id_prod'];
    $_SESSION[$nr_2] = $prod[$nr]['ile_sztuk'];
    $_SESSION[$nr_3] = $prod[$nr]['tytul'];
    $_SESSION[$nr_4] = $prod[$nr]['opis'];
    $_SESSION[$nr_5] = $prod[$nr]['cena'];
    $_SESSION[$nr_6] = $prod[$nr]['waga'];
    $_SESSION[$nr_7] = $prod[$nr]['zdjecie'];
    $_SESSION[$nr_8] = $prod[$nr]['data'];
    
    header('Location: koszyk.php');
}

function ShowCart() {
    global $full_price;
    global $full_weight;
    $wynik = '<a href="sklepik.php">Powrót</a><table><tr><th>Zdjęcie</th><th>Tytuł</th><th>Opis</th><th>Waga</th><th>Cena</th><th>Sztuk</th><th>Data</th><th>Usuń</th></tr>';

    for ($i = 1; $i <= $_SESSION['count']; $i++) {
        if (isset($_SESSION[$i.'_0'])) {
            $wynik .= ShowProduct($i);
            $full_price += $_SESSION[$i.'_5'] * $_SESSION[$i.'_2'];
            $full_weight += $_SESSION[$i.'_6'] * $_SESSION[$i.'_2'];
        }
    }

    $wynik .= '</table>';
    $wynik .= '<p>Całkowita cena: '.$full_price.' zł</p>';
    $wynik .= '<p>Całkowita waga: '.$full_weight.' g</p>';
    $wynik .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="POST">';
    $wynik .= '<input type="hidden" name="order" value="order">';
    $wynik .= '<button type="submit" style="width: 200px; height: 100px; background-color: blue; outline: none; border: none; cursor: pointer;">Zamów</button>';
    $wynik .= '</form>';
    echo $wynik;
}

function ShowProduct($nr) {
    $wynik = '<tr><td><img style="width:20px; height:30px;" src="'.$_SESSION[$nr.'_7'].'" /></td>';
    $wynik .= '<td>'.$_SESSION[$nr.'_3'].'</td>';
    $wynik .= '<td>'.$_SESSION[$nr.'_4'].'</td>';
    $wynik .= '<td>'.$_SESSION[$nr.'_6'].'</td>';
    $wynik .= '<td>'.$_SESSION[$nr.'_5'].'</td>';
    $wynik .= '<td>'.$_SESSION[$nr.'_2'].'</td>';
    $wynik .= '<td>'.$_SESSION[$nr.'_8'].'</td>';
    $wynik .= '<td><form action="'.$_SERVER['REQUEST_URI'].'" method="POST"><button style="border: none; outline: none; cursor:pointer; font-size:2em" type="submit" name="usun" value="'.$_SESSION[$nr.'_0'].'">Usun</button></form></td></tr>';

    return $wynik;
}

function Order() {
        session_destroy();
        echo "Złożono zamówienie :)";
        header('Location: ./sklepik.php');
}

function RemoveFromCart($id) {
    unset($_SESSION[$id.'_0']);
    unset($_SESSION[$id.'_1']);
    unset($_SESSION[$id.'_2']);
    unset($_SESSION[$id.'_3']);
    unset($_SESSION[$id.'_4']);
    unset($_SESSION[$id.'_5']);
    unset($_SESSION[$id.'_6']);
    unset($_SESSION[$id.'_7']);
    unset($_SESSION[$id.'_8']);

    header('Refresh: 0;');
}

if (isset($_SESSION['count'])) {
    ShowCart();

}

if (isset($_POST['order'])) {
    Order();
    exit();
}

if (isset($_POST['usun'])) {
    RemoveFromCart($_POST['usun']);

}
?>
</body>
</html>
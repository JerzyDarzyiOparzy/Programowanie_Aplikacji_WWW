<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorie        |          Sklep</title>
</head>
<body>
<?php
require('cfg.php');

function DodajKategorie() {
    $wynik = '<h3>Dodaj kategorię:</h3>'.'<form method="POST" action="dodanieKategorii.php">';
    $wynik .= 'Matka: <input class="tytul" type="text" name="mother" value=""><br /> <br />';
    $wynik .= 'Nazwa: <input class="tytul" type="text" name="name" value=""><br /> <br />';
    $wynik .= '<input class="zapisz" type="submit" value="Dodaj">'.'</form>';
    
    return $wynik;
}

function UsunKategorie() {
    global $link;

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
    } else {
        echo "Nie ma podstrony o danym ID :(";
        exit;
    }

    $query = "DELETE FROM shop WHERE id = $id LIMIT 1";
    $result = mysqli_query($link, $query);

    if ($result) {
        echo "Usunięto kategorię :)";
        header("Location: sklepik.php");
    } else {
        echo "Nie usunięto kategorii :(";
        exit;
    }
}

function EdytujKategorie() {
    global $link;

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
    } else {
        echo "Nie ma kategorii o danym ID :(";
        exit;
    }

    $query = "SELECT matka, nazwa FROM shop WHERE id = '$id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0 && $result) {
        $row = mysqli_fetch_assoc($result);
        $matka = $row['matka'];
        $nazwa = $row['nazwa'];

        $wynik = '<h3>Edycja Kategorii o id:'.$id.'</h3>'.'<form method="POST" action="zapisDodaniaKategorii.php?id='.$id.'">';
        $wynik .= '<input class="tytul" type="text" name="mother" value="'.$matka.'"><br />';
        $wynik .= '<input class="tytul" type="text" name="name" value="'.$nazwa.'"><br />';
        $wynik .= '<input class="zapisz" type="submit" name="zapisz" value="zapisz">'.'</form>';

        return $wynik;
    }
}

function PokazKategorie() {
    global $link;

    $wynik = '<h3>Kategorie:</h3>' . '<ul class="kategorie">';
    $wynik .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?action=dodaj">Dodaj Kategorię</a></li>';

    $query = "SELECT id, matka, nazwa FROM shop ORDER BY matka, id";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $kategorie = array();
        $matki = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $matka = $row['matka'];
            $nazwa = $row['nazwa'];

            if ($matka == 0) {
                $matki[$id] = array('nazwa' => $nazwa, 'id' => $id, 'podkategorie' => array());
            } else {
                $kategorie[$id] = array('nazwa' => $nazwa, 'id' => $id, 'matka' => $matka);
                $matki[$matka]['podkategorie'][] = &$kategorie[$id];
            }
        }

        foreach ($matki as $matka) {
            $wynik .= '<br /><li>ID: '. $matka['id'].' <span style="font-size: 1.6em; margin-bottom: 20px; font-weight: bold;">'. $matka['nazwa'] . '</span>' . '    <a href="' . $_SERVER['PHP_SELF'] . '?action=edytuj&id=' . $matka['id'] . '">Edytuj</a> | <a href="' . $_SERVER['PHP_SELF'] . '?action=usun&id=' . $matka['id'] . '">Usuń</a></li>';
            $wynik .= '<ul>';

            foreach ($matka['podkategorie'] as $podkategoria) {
                $wynik .= '<li>ID: '. $podkategoria['id'].' ' .' <span style="font-size: 1.3em; margin-bottom: 20px;">'. $podkategoria['nazwa'] . '</span>' . '    <a href="' . $_SERVER['PHP_SELF'] . '?action=edytuj&id=' . $podkategoria['id'] . '">Edytuj</a> | <a href="' . $_SERVER['PHP_SELF'] . '?action=usun&id=' . $podkategoria['id'] . '">Usuń</a></li>';
            }

            $wynik .= '</ul></li>';
        }

    } else {
        $wynik .= '<li style="font-size:2.0em">Brak kategorii</li>';
    }

    $wynik .= '</ul>';

    echo $wynik;

    if (isset($_GET['action'])) {
        $action = htmlspecialchars($_GET['action']);
        if ($action === 'edytuj' && isset($_GET['id'])) {
            echo EdytujKategorie();
        } else if ($action === 'usun' && isset($_GET['id'])) {
            echo UsunKategorie();
        } else if ($action === 'dodaj') {
            echo DodajKategorie();
        }
    }
}

echo PokazKategorie();

?>

</body>
</html>
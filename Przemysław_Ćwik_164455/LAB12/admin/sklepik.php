<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorie | Sklep</title>
</head>
<body>
<?php
require('cfg.php');

function PokazKategorie() {
    global $link;

    $wynik = '<a href="../index.php">Strona Główna</a> <h3>Kategorie:</h3>' . '<ul class="kategorie">';

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
            $wynik .= '<br /><li>ID: '. $matka['id'].' <a href="./produkty.php?kategoria='.$matka['nazwa'].'" style="text-decoration: none; font-size: 2em; margin-bottom: 30px; font-weight: bold;">'. $matka['nazwa'] . '</a>' .'</li>';
            $wynik .= '<ul>';

            foreach ($matka['podkategorie'] as $podkategoria) {
                $wynik .= '<li>ID: '. $podkategoria['id'].' ' .' <span style="font-size: 1.6em; margin-bottom: 40px;">'. $podkategoria['nazwa'] . '</span>' . '</li>';
            }

            $wynik .= '</ul></li>';
        }

    } else {
        $wynik .= '<li style="font-size:2em">Brak kategorii</li>';
    }

    $wynik .= '</ul>';

    echo $wynik;
}

echo PokazKategorie();

?>

</body>
</html>
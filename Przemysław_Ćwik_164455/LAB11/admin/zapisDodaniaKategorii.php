<?php
require('cfg.php');

if (isset($_POST['zapisz'])) {
    if (isset($_POST['mother']) && isset($_POST['name'])) {
     $matka = htmlspecialchars($_POST['mother']);
     $nazwa = htmlspecialchars($_POST['name']);
     $id = htmlspecialchars($_GET['id']);
     $query = "UPDATE shop SET matka = '$matka', nazwa = '$nazwa' WHERE id = '$id' LIMIT 1";
     $result = mysqli_query($link, $query);

     if ($result) {
        echo "Pomyślnie zaktualizowano kategorię";
        header("Location: sklepik.php");
    } else {
        echo "Błąd podczas aktualizacji kategorii";
    }
 }
}
else {
    echo "Nie przesłano danych";
}
?>
<?php
require('cfg.php');

if (isset($_POST['mother']) && isset($_POST['name'])) {
    $matka = htmlspecialchars($_POST['mother']);
    $nazwa = htmlspecialchars($_POST['name']);
    $query = "INSERT INTO shop (matka, nazwa) VALUES ('$matka', '$nazwa')";
    $result = mysqli_query($link, $query);
    if ($result) {
        echo "Dodano kategorię :)";
        header("refresh:2;url=index.php");
    } else {
        echo "Nie dodano kategorii :(";
    }
}
?>
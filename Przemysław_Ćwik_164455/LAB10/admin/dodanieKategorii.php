<?php
require('cfg.php');

if (isset($_POST['mother']) && isset($_POST['name'])) {
    $matka = htmlspecialchars($_POST['mother']);
    $nazwa = htmlspecialchars($_POST['name']);
    $query = "INSERT INTO shop (matka, nazwa) VALUES ('$matka', '$nazwa')";
    $result = mysqli_query($link, $query);
    header('Location: sklepik.php');
}
?>
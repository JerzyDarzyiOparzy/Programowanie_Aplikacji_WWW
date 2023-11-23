<?php
echo "a) Metoda include(), require_once():<br>";

echo "Przykład użycia include():<br>";
include('zad_1.php');
echo "<br>";

echo "Przykład użycia require_once():<br>";
require_once('zad_1.php');
echo "<br>";

echo "b) Warunki if, else, elseif, switch:<br>";

$ocena = 90;

if ($ocena >= 60) {
    echo "Nie Zaliczone<br>";
} else {
    echo "Zaliczone<br>";
}

if ($ocena >= 90) {
    echo "Bardzo Dobry<br>";
} elseif ($ocena >= 75) {
    echo "Dobry<br>";
} else {
    echo "Dostateczny<br>";
}

$kolor = "zielony";

switch ($kolor) {
    case "czerwony":
        echo "Twój ulubiony kolor to czerwony.";
        break;
    case "zielony":
        echo "Twój ulubiony kolor to zielony.";
        break;
    default:
        echo "Twój ulubiony kolor jest inny.";
}
echo "<br>";

echo "c) Pętla while() i for():<br>";

$i = 1;
echo "Pętla while: ";
while ($i <= 5) {
    echo $i . " ";
    $i++;
}
echo "<br>";

echo "Pętla for: ";
for ($j = 1; $j <= 5; $j++) {
    echo $j . " ";
}
echo "<br>";

echo "Przykład korzystania z \$_GET:<br>";
if (isset($_GET['parametr'])) {
    $parametr = $_GET['parametr'];
    echo "Wartość parametru z \$_GET: $parametr<br>";
} else {
    echo "Parametr nie został przekazany za pomocą \$_GET.<br>";
}

echo "Przykład korzystania z \$_POST:<br>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['form_field'])) {
        $formField = $_POST['form_field'];
        echo "Wartość pola formularza z \$_POST: $formField<br>";
    } else {
        echo "Pole formularza nie zostało przesłane za pomocą \$_POST.<br>";
    }
}

echo "Przykład korzystania z \$_SESSION:<br>";
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    echo "Zalogowany użytkownik z \$_SESSION: $user<br>";
} else {
    echo "Brak zalogowanego użytkownika w \$_SESSION.<br>";
}

echo 'Hello ' . htmlspecialchars($_POST["name"]) . '!';
?>



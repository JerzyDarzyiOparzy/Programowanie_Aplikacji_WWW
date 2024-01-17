<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu pracuje Admin</title>
</head>
<body>
<?php
session_start();
require('cfg.php');

function FormularzLogowania() {
    $wynik = '
    <div class="login-wrapper">
    <h1 class="heading">Panel CMS:</h1>
    <form class="formularz_logowania" method="POST" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'"
    <table class="logowanie">
    <tr><td class="log4_t">[login]</td><td><input type="text" name="login_email" class="logowanie"/></td></tr>
    <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie"/></td></tr>
    <tr><td><br/></td><td><input type="submit" name="xl_submit" class="logowanie" value="Zaloguj"/></td></tr>
    </table>
    </form>
    </div>
    
    ';
    return $wynik;
}

function ListaPodstron() {
    global $link;

    $wynik = '<h3>Podstrony:</h3>'.'<table class="tabela_akcji">'.'<tr><th>ID</th><th>Tytuł podstrony</th><th>Akcje</th></tr>';
    $wynik .= '<a href="'.$_SERVER['PHP_SELF'].'?action=dodaj">Dodaj podstronę</a> <br /> <br />';

    $query = "SELECT id, page_title FROM page_list";
    $result = mysqli_query($link, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $page_title = $row['page_title'];

            $wynik .= '<tr>'.'<td>' . $id . '</td>'.'<td>' . $page_title . '</td>'.'<td><a href="'.$_SERVER['PHP_SELF'].'?action=edytuj&id='.$id.'">Edytuj</a> | <a href="'.$_SERVER['PHP_SELF'].'?action=usun&id='.$id.'">Usuń</a></td>'.'</tr>';
        }
    } else {
        $wynik .= '<tr><td colspan="3">Brak podstron do wyświetlenia.</td></tr>';
    }

    $wynik .= '</table>';

    echo $wynik;

    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'edytuj' && isset($_GET['id'])) {
            echo EdytujPodstrone();
        } else if ($_GET['action'] === 'usun' && isset($_GET['id'])) {
            echo UsunPodstrone();
        } else if ($_GET['action'] === 'dodaj') {
            echo DodajNowaPodstrone();
        }
}
}

function EdytujPodstrone() {
    global $link;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        echo "Brak podstrony z tym ID";
        exit;
    }

    $query = "SELECT page_title, page_content, status FROM page_list WHERE id = '$id'";
    $result = mysqli_query($link, $query);

    if (mysqli_num_rows($result) > 0 && $result) {
        $row = mysqli_fetch_assoc($result);
        $page_title = $row['page_title'];
        $page_content = $row['page_content'];
        $page_is_active = $row['status'];

        $wynik = '<h3>Edycja Podstrony o id:'.$id.'</h3>'.'<form method="POST" action="zapiszEdytowany.php?id='.$id.'">';
        $wynik .= '<input class="tytul" type="text" name="page_title" value="'.$page_title.'"><br />';
        $wynik .= '<textarea class="tresc" rows=20 cols=100 name="page_content">'.$page_content.'</textarea><br />';
        $wynik .= 'Podstrona aktywna: <input class="aktywna" type="checkbox" name="page_is_active" value="1"'.($page_is_active == 1 ? 'checked="checked"' : '').'><br />';
        $wynik .= '<input class="zapisz" type="submit" name="zapisz" value="zapisz">'.'</form>';

        return $wynik;
    }
}

function DodajNowaPodstrone() {
    global $link;

        $wynik = '<h3>Dodaj podstronę:</h3>'.'<form method="POST" action="dodajStrone.php">';
        $wynik .= 'Tytuł: <input class="tytul" type="text" name="page_title" value=""><br /> <br />';
        $wynik .= 'Treść: <textarea class="tresc" rows=20 cols=100 name="page_content"></textarea><br /> <br />';
        $wynik .= 'Podstrona aktywna: <input class="aktywna" type="checkbox" name="page_is_active" value="1"><br /> <br />';
        $wynik .= '<input class="zapisz" type="submit" value="Dodaj">'.'</form>';

        return $wynik;
 }

function UsunPodstrone() {
    global $link;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        echo "Brak podstrony z tym ID";
        exit;
    }


    $query = "DELETE FROM page_list WHERE id = $id LIMIT 1";
    $result = mysqli_query($link, $query);

    if ($result) {
        echo "Usunięto podstronę";
        header("Location: admin.php");
    } else {
        echo "Błąd usuwania podstrony";
        exit;
    }
}


if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    echo 'Tu pracuje Admin';
    echo '<a href="wylogowanie.php">Wyloguj</a>';
    echo ListaPodstron();
} else {
    echo'<a href="../index.php">Strona Główna</a>';
    echo FormularzLogowania();
}

if (isset($_POST['login_email']) && isset($_POST['login_pass'])) {
    $formLogin = $_POST['login_email'];
    $formPass = $_POST['login_pass'];

    if ($formLogin === $login && $formPass === $pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Refresh:0");
    } else {
        echo 'Wpisz hasło jeszcze raz albo login';
        echo FormularzLogowania();
    }
}
?>

</body>
</html>
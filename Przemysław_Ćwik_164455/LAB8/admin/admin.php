<?php

function FormularzLogowania()
{
    $wynik = '
    <div class="logowanie">
        <h1 class="heading">Panel CMS:</h1?
            <div class="logowanie">
                <form method="post" name="LoginForm" enctype="multipart/form-data" action"'.$_SERVER['REQUEST_URI'].'">
                    <table class="logowanie">
                        <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
                        <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie" /></td></tr>
                        <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="zaloguj" /></td></tr>
                    </table>
                </form>
            </div>
    </div>
    ';
    
  return $wynik;
}


function ListaPodstron()
{
    $query="SELECT * FROM page_list WHERE id='$id_clear' ORDER BY data DESC LIMIT 100";
    $result = mysql_query($query);
        
        while($row = mysql_fetch_array($result))
        {
            $row['id'].' '.$row['tytul'].' <br />';
            echo '<td><button>Edytuj</button> <button>Usuń</button></td>';
        }

}


function EdytujPodstrone($id)
{

    $query = "SELECT * FROM page_list WHERE id = $id";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);

    echo '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">';
    echo '<input type="text" name="tytul" value="'.$row['page_title'].'"><br>';
    echo '<textarea name="tresc">'.$row['page_content'].'</textarea><br>';
    echo '<input type="checkbox" name="aktywna" '.($row['status'] == 1 ? 'checked' : '').'> Aktywna<br>';
    echo '<input type="hidden" name="id" value="'.$id.'">';
    echo '<input type="submit" name="zapisz" value="Zapisz">';
    echo '</form>';
}


function DodajNowaPodstrone()
{
    echo '<h2>Dodaj Nową Podstronę</h2>';
    EdytujPodstrone(0);
}

function UsunPodstrone($id)
{
    $query = "SELECT * FROM page_list WHERE id = $id LIMIT 1";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $deleteQuery = "DELETE FROM page_list WHERE id = $id";
        $deleteResult = mysqli_query($link, $deleteQuery);

        if ($deleteResult) {
            echo "Podstrona o ID $id została pomyślnie usunięta.";
        } else {
            echo "Błąd podczas usuwania podstrony.";
        }
    } else {
        echo "Podstrona o ID $id nie istnieje.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['x1_submit'])) {
    $login = $_POST['login_email'];
    $pass = $_POST['login_pass'];

    if ($login === 'poprawny_login' && $pass === 'poprawne_haslo') {
        $_SESSION['zalogowany'] = true;
        header('Location: '.$_SERVER['REQUEST_URI']);
        exit;
    } else {
        echo FormularzLogowania();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zapisz'])) {
    $id = $_POST['id'];
    $tytul = $_POST['tytul'];
    $tresc = $_POST['tresc'];
    $aktywna = isset($_POST['aktywna']) ? 1 : 0;

    $query = "UPDATE page_list SET page_title='$tytul', page_content='$tresc', status=$aktywna WHERE id=$id";
    mysql_query($query);
    
    header('Location: '.$_SERVER['REQUEST_URI']);
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dodaj_nowa'])) {
    $tytul = $_POST['tytul'];
    $tresc = $_POST['tresc'];
    $aktywna = isset($_POST['aktywna']) ? 1 : 0;

    $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$tytul', '$tresc', $aktywna)";
    mysql_query($query);

    header('Location: '.$_SERVER['REQUEST_URI']);
    exit;
} elseif ($_SESSION['zalogowany'] === true) {
    ListaPodstron();
} else {
    echo FormularzLogowania();
}

?>
    
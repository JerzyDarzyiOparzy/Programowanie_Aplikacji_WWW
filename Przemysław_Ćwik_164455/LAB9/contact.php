<?php

function PokazKontakt()
{
    echo '<h2>Skontaktuj się z nami</h2>';
    echo '<form action="contact.php" method="post">';
    echo '    <label for="temat">Temat:</label><br>';
    echo '    <input type="text" id="temat" name="temat"><br>';
    echo '    <label for="tresc">Treść wiadomości:</label><br>';
    echo '    <textarea id="tresc" name="tresc" rows="4" cols="50"></textarea><br>';
    echo '    <label for="email">Twój adres email:</label><br>';
    echo '    <input type="email" id="email" name="email"><br>';
    echo '    <input type="submit" value="Wyślij">';
    echo '</form>';
}

function WyslijMailKontakt($odbiorca)
{
    if(empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email']))
    {
        echo '[nie_wypelniles_pola]';
        echo PokazKontakt();
    }
    else
    {
        $mail['subject']        = $_POST['temat'];
        $mail['body']           = $_POST['tresc'];
        $mail['sender']         = $_POST['email'];
        $mail['recipient']     = $odbiorca;
        
        $header = "From: Formularz kontaktowy <".$mail['sender'].">\n";
        $header = "MIME-version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding:";
        $header = "X-Sender: <".$mail['sender'].">\n";
        $header = "X-Mailer: PRapWWW mail 1.2\n";
        $header = "X-Priority: 3\n";
        $header = "Return-Path <".$mail['sender'].">\n";
        
        mail($mail['recipient'],$mail['subject'],$mail['body'],$header);
        
        echo '[wiadomosc_wyslana]';
    }
    
}

function PrzypomnijHaslo($haslo, $adminEmail)
{
    if (empty($adminEmail)) {
        echo 'Brak skonfigurowanego adresu email administratora.';
        return;
    }

    $mail['subject']        = 'Przypomnienie hasła';
    $mail['body']           = 'Twoje hasło: ' . $haslo;
    $mail['sender']         = 'noreply@example.com';
    $mail['recipient']      = $adminEmail;

    $header = "From: System przypominania hasła <" . $mail['sender'] . ">\n";
    $header .= "MIME-version: 1.0\n";
    $header .= "Content-Type: text/plain; charset=utf-8\n";
    $header .= "Content-Transfer-Encoding: 8bit\n";
    $header .= "X-Sender: <" . $mail['sender'] . ">\n";
    $header .= "X-Mailer: PRapWWW mail 1.2\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: <" . $mail['sender'] . ">\n";

    mail($mail['recipient'], $mail['subject'], $mail['body'], $header);

    echo 'Email z hasłem został wysłany do administratora.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu pracuje Admin</title>
</head>
<body>
<?php
require('./cfg.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function PokazKontakt() {

    //odkomentowac jesli chcemy uzyc tego formularza

    $formularz = '<form class="contact-form" method="POST" action="'.$_SERVER['REQUEST_URI'].'">';
    $formularz .= '<label for="email">Email:</label><br />';
    $formularz .= '<input class="inp-text" type="email" name="email" id="email" required /><br />';
    $formularz .= '<label for="temat">Temat:</label><br />';
    $formularz .= '<input class="inp-text" type="text" name="temat" id="temat" required /><br />';
    $formularz .= '<label for="tresc">Treść:</label><br />';
    $formularz .= '<textarea class="content-input" type="tresc" name="tresc" id="tresc" required></textarea><br />';
    $formularz .= '<input class="inp-btn" type="submit" name="send" value="Wyślij"></form>';

    if (isset($_POST['send'])) {
        WyslijMailKontakt();
    } else {
        echo "Nie udało się wysłać wiadomości";
        //ponizsze linijki nalezy zakomentowac jesli chcemy uzyc formularza powyzej
        //sleep(2);
        //header('Location: ../index.php?idp=5');
    }
    return $formularz;
}

//odkomentowac jesli uzywamy formularza powyzej

echo PokazKontakt();

if (isset($_POST['send'])) {
    echo PokazKontakt();
} else {
    echo PrzypomnijHaslo();
}

function WyslijMailKontakt() {
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo '[puste_pole]';
        header('Location: ../index.php?idp=5');
    } else {
        $subject = $_POST['temat'];
        $body = $_POST['tresc'];
        $sender = $_POST['email'];

        $mail = new PHPMailer(true);
        $mail -> isSMTP();
        $mail -> Host = "smtp.gmail.com";
        $mail -> SMTPAuth = true;
        $mail -> SMTPSecure = 'ssl';
        $mail -> Port = 465;

        $mail -> Username = "pszemtak@gmail.com";
        $mail -> Password = "xrre gsex wrrb sijs";

        $mail -> setFrom($sender);
        $mail -> addAddress('pszemtak@gmail.com');

        $mail -> Subject = $subject;
        $mail -> Body = $body."\n\nSent by: ".$sender;

        $mail -> send();
        echo "Wysłano wiadomość email\n\n";
        header('Location: ../index.php?idp=5');
}
}

function PrzypomnijHaslo() {
    global $pass;

    $formularz = '<form method="POST" action="">';
    $formularz .= '<input class="inp-btn" type="submit" value="Przypomnij haslo" name="przypomnij"/><br />';
    $formularz .= '</form>';

    if (isset($_POST['przypomnij'])) {
        $subject = "Przypomnienie Hasla";
        $body = "Hasło do panelu admina to: ".$pass;
        $sender = "pszemtak@gmail.com";

        $mail = new PHPMailer(true);
        $mail -> isSMTP();
        $mail -> Host = "smtp.gmail.com";
        $mail -> SMTPAuth = true;
        $mail -> SMTPSecure = 'ssl';
        $mail -> Port = 465;

        $mail -> Username = "pszemtak@gmail.com";
        $mail -> Password = "xrre gsex wrrb sijs";

        $mail -> setFrom($sender);
        $mail -> addAddress('pszemtak@gmail.com');

        $mail -> Subject = $subject;
        $mail -> Body = $body;

        $mail -> send();

        echo "Wiadomość wysłano :)\n\n";
        header('Location: ../index.php');
    }

    echo $formularz;
}

?>
</body>
</html>
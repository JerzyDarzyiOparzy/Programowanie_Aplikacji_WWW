<?php
session_start();

if (isset($_SESSION['admin_logged_in'] ) && $_SESSION['admin_logged_in'] === true) {
    session_destroy();
    header('Location: ./admin.php');
} else {
    header('Location: ./admin.php');
}
?>
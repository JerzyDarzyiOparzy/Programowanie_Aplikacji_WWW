<?php
require('cfg.php');

if (isset($_POST['page_title']) && isset($_POST['page_content'])) {
    $page_title = htmlspecialchars($_POST['page_title']);
    $page_content = htmlspecialchars($_POST['page_content']);
    $page_is_active = isset($_POST['page_is_active']) ? 1 : 0;

    $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$page_title', '$page_content', '$page_is_active')";
    $result = mysqli_query($link, $query);
    if ($result) {
        echo "Dodano podstronę :)";
        header("refresh:2;url=index.php");
    } else {
        echo "Nie dodano podstrony :(";
    }
}
?>
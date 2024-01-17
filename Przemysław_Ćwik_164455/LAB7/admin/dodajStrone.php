<?php
require('./cfg.php');

if (isset($_POST['page_title']) && isset($_POST['page_content'])) {
    $page_title = $_POST['page_title'];
    $page_content = $_POST['page_content'];
    $page_is_active = isset($_POST['page_is_active']) ? 1 : 0;

    $query = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$page_title', '$page_content', '$page_is_active')";
    $result = mysqli_query($link, $query);

    header('Location: ./admin.php');
}
?>
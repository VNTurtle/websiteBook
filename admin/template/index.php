<?php

    require 'layout/menu.php';
    require 'layout/header.php';
    $page = isset($_GET['admin/template']) ? $_GET['admin/template'] : 'home';
    $pageFile = "admin/template/{$page}.php";
    $pageName = basename($pageFile, '.php');

    if (file_exists($pageFile)) {
        require $pageFile;
    } else {
        echo "Page not found!";
    }

    require 'layout/footer.php';
?>
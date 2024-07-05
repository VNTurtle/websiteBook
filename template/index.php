<?php

$excludedPages = ['login', 'register', 'checkout'];


$page = isset($_GET['template']) ? $_GET['template'] : 'home';
$pageFile = "template/{$page}.php";
$pageName = basename($pageFile, '.php');
// Kiểm tra nếu trang không thuộc danh sách loại trừ
if (file_exists($pageFile) && !in_array($pageName, $excludedPages)) {
    require 'layout/header.php';
}

if (file_exists($pageFile)) {
    require $pageFile;
} else {
    echo "Page not found!";
}

// Kiểm tra nếu trang không thuộc danh sách loại trừ
if (file_exists($pageFile) && !in_array($pageName, $excludedPages)) {
    require 'layout/footer.php';
}
?>
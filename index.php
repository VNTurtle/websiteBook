<?php

$excludedPages = ['login', 'register', 'checkout', 'otp_checkout'];

// Lấy thông tin thư mục và trang từ tham số GET
$folder = isset($_GET['folder']) ? $_GET['folder'] : '';
$page = isset($_GET['template']) ? $_GET['template'] : 'home';

// Xác định thư mục con
if ($folder === 'admin') {
    $subfolder = 'admin/template';
    $headerFile = 'admin/template/layout/header.php';
    $menuFile = 'admin/template/layout/menu.php';
    $footerFile = 'admin/template/layout/footer.php';
} else {
    $subfolder = 'template';
    $headerFile = 'template/layout/header.php';
    $menuFile = '';
    $footerFile = 'template/layout/footer.php';
}

// Xây dựng đường dẫn đến tệp
$pageFile = "{$subfolder}/{$page}.php";
$pageName = basename($pageFile, '.php');

// Kiểm tra nếu trang không thuộc danh sách loại trừ
if (file_exists($pageFile) && !in_array($pageName, $excludedPages)) {
    if (!empty($menuFile) && file_exists($menuFile)) {
        require $menuFile;
    }
    require $headerFile;
}

if (file_exists($pageFile)) {
    require $pageFile;
} else {
    echo "Page not found!";
}

// Kiểm tra nếu trang không thuộc danh sách loại trừ
if (file_exists($pageFile) && !in_array($pageName, $excludedPages)) {
    require $footerFile;
}
?>

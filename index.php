<?php
$excludedPages = ['login', 'register', 'checkout', 'otp_checkout','comment'];

// Lấy thông tin thư mục và trang từ tham số GET
$folder = isset($_GET['folder']) ? $_GET['folder'] : '';
$page = isset($_GET['template']) ? $_GET['template'] : 'home';

// Xác định thư mục con và các tệp layout
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

// Kiểm tra nếu trang không thuộc danh sách loại trừ và file tồn tại
if (!in_array($pageName, $excludedPages)) {
    if (!empty($menuFile) && file_exists($menuFile)) {
        require $menuFile;
    }
    if (file_exists($headerFile)) {
        require $headerFile;
    }
}

// Kiểm tra nếu trang không thuộc danh sách loại trừ và file tồn tại
if (file_exists($pageFile)) {
    require $pageFile;
} else {
    echo "Page not found!";
}

// Bao gồm footer nếu trang không thuộc danh sách loại trừ và file tồn tại
if (!in_array($pageName, $excludedPages) && file_exists($footerFile)) {
    require $footerFile;
}
?>
<?php
require_once('API/db.php');
require_once('template/layout/layout.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" href="assets/img/logo-web.jpg">
    <link rel="stylesheet" href="assets/css/layout.css">
    <?php
    // Bao gồm tệp tin JavaScript riêng của từng trang nếu có
    if (isset($page)) {
        $pageCSS = "assets/css/{$pageName}.css";

        if (file_exists($pageCSS)) {
            echo '<link rel="stylesheet" href="' . $pageCSS . '">';
        }
    }
    ?>
    <link rel="stylesheet" href="assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/sclick/css/slick.min.css">
    <script>
        function toggleButton() {
            const input = document.getElementById('timkiem');
            const button = document.getElementById('btn');
            button.disabled = input.value.trim() === '';
        }
    </script>
</head>

<body>
    <div class="opacity-menu" onclick="CLoseMenu()"></div>
    <header class="header">
        <div class="container">
            <div class="row row-header align-items-center">
                <div class="menu-bar " onclick="toggeleMenu()">
                    <i style="color: #fff; margin-top: 3px; margin-left: -2px;" class="fa-solid fa-bars"></i>
                </div>
                <div class="col-lg-3">
                    <a href="/" class="logo" title="Logo">
                        <img class="Logo-header" src="assets/img/logo-bookstore-header.jpg" alt="Logo">
                    </a>
                </div>
                <form class="col-lg-4 search-header" method="get">
                    <div class="InputContainer">
                        <input type="hidden" name="template" value="search/search">
                        <input placeholder="Search.." id="timkiem" class="input" name="timkiem" type="text" onkeyup="toggleButton()">
                        <button class="btn btn-search" style="border-color: #fff; border-radius: 25px; margin: 13px; color: #09bfff;" type="submit" id="btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>

                <?php
                if (isset($_GET['timkiem'])) {
                    $noidung = $_GET['timkiem'];
                } else {
                    $noidung = false;
                }
                if ($noidung) {
                    $querySearch = "SELECT * FROM book WHERE Name LIKE '%$noidung%' ";
                    $ketqua = DP::run_query($querySearch, $parameters, $resultType);
                }
                ?>

                <div class="col-lg-5 header-control">
                    <ul class="ul-control">

                        <li class="header-favourite d-n">
                            <i style="width: 25px; height: 25px;" class="fa-solid fa-heart"></i>
                        </li>
                        <li class="header-cart ">
                            <a href="index.php?template=cart/cart">
                                <i style="width: 25px; height: 25px; color: #000;" class="fa-solid fa-cart-shopping"></i>
                            </a>

                        </li>
                        <li class="header-account d-n">
                            <i style="width: 25px; height: 25px; color: #000;" class="fa-regular fa-user"></i>
                            <ul class="Show-account">
                                <?php
                                if (isset($_SESSION['email'])) {
                                    // Người dùng đã đăng nhập
                                    echo '
                                            <li>
                                                <a href="index.php?template=user/profile">Cá nhân</a>
                                            </li>
                                            <li>
                                                <a href="index.php?template=invoice/invoice">Đơn hàng</a>
                                            </li>
                                            <li>
                                                <a href="">Register</a>
                                            </li>
                                            <li>
                                                <a href="index.php?logout=true">Logout</a>
                                            </li>';
                                } else {
                                    // Người dùng chưa đăng nhập
                                    echo '
                                            <li>
                                                <a href="index.php?template=user/login">Login</a>
                                            </li>
                                            <li>
                                                <a href="index.php?template=user/register">Register</a>
                                            </li>
                                            ';
                                }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="header-menu">
                <div class="header-menu-des">
                    <nav class="header-nav">
                        <ul class="item-big">
                            <li>
                                <a href="index.php" class="logo-sitenav d-block d-lg-none">
                                    <img src="assets/img/logo-bookstore-header.jpg" width="172" height="50" alt="">
                                </a>
                            </li>
                            <li class="d-lg-none d-block account-mb">
                                <ul>
                                    <?php
                                    if (isset($_SESSION['user'])) {
                                        // Người dùng đã đăng nhập
                                        echo '
                                            <li>
                                                <a href="">Cá nhân</a>
                                            </li>
                                            <li>
                                                <a href="">Quản lý đơn hàng</a>
                                            </li>
                                            <li>
                                                <a href="">Register</a>
                                            </li>
                                            <li>
                                                <form method="post" action="">
                                                    <input type="submit" name="logout" value="Logout">
                                                </form>
                                            </li>';
                                    } else {
                                        // Người dùng chưa đăng nhập
                                        echo '
                                            <li>
                                                <a href="index.php?template=user/login">Login</a>
                                            </li>
                                            <li>
                                                <a href="index.php?template=user/register">Register</a>
                                            </li>
                                            ';
                                    }
                                    ?>

                                </ul>
                            </li>
                            <li class="d-block d-lg-none title-danhmuc">
                                <span>Menu chính</span>
                            </li>
                            <li class="nav-item">
                                <a href="index.php">
                                    <i class="fa-solid fa-house"></i>
                                    Trang chủ
                                </a>
                            </li>
                            <li class="nav-item has-mega">
                                <a href="index.php?template=product/lst_product" class="caret-down">Sản phẩm</a>
                                <div class="mega-content">
                                    <div class="lst-Type-main">
                                        <ul class="level0">
                                            <?php
                                            foreach ($bookTypeIds as $key => $lst_type) {

                                            ?>
                                                <li class="level1 item parent">
                                                    <a href="index.php?template=product/lst_product&lst_id=<?= $lst_type['Id'] ?>" class="hmega"><?php echo $lst_type['Name'] ?></a>
                                                    <ul class="level1">

                                                        <?php
                                                        foreach ($typedetailList as $key => $lst_typedetail) {
                                                            if ($lst_typedetail['TypeId'] == $lst_type['Id']) {
                                                        ?>
                                                                <li class="level2">
                                                                    <a href="index.php?template=product/lst_product&lst_id2=<?php echo $lst_typedetail['Id'] ?>"><?php echo $lst_typedetail['Name'] ?></a>
                                                                </li>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <li class="level2">
                                                            <a href="index.php?template=product/lst_product" style="color: #09bfff;">Xem thêm</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="">Hệ thống</a>
                            </li>
                            <li class="nav-item">
                                <a href="introduce.html">Giới thiệu</a>
                            </li>
                            <li class="nav-item">
                                <a href="contact.html">Liên Hệ</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main>

</body>

</html>
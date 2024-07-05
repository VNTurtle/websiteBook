<?php


$queryCoverType = "SELECT * FROM `covertype` WHERE 1";
$Lst_CoverType = DP::run_query($queryCoverType, $parameters, $resultType);

$queryPublisher = "SELECT * FROM `publisher` WHERE 1";
$Lst_Publisher = DP::run_query($queryPublisher, $parameters, $resultType);
?>
<div class="bodywrap">
        <section class="bread-crumb">
            <div class="container">
                <ul class="breadcrumb">
                    <li class="home">
                        <a href="index.html">
                            <span>Trang chủ</span>
                        </a>
                        <span class="mr-lr">
                            &nbsp;
                            <i class="fa-solid fa-angle-right"></i>
                            &nbsp;
                        </span>
                    </li>
                    <li>
                        <strong>
                            <span>
                                Danh sách sản phẩm
                            </span>
                        </strong>
                    </li>
                </ul>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-3 col-sm-0 col-0">
                    <div class="left-category">
                        <div class="product-category">
                            <div class="product-category-title">
                                Lọc theo
                            </div>
                        </div>
                        <div class="aside-item">
                            <div class="aside-heading">
                                Chọn mức giá
                            </div>
                            <div class="aside-content">
                                <ul>
                                    <li class="aside-content-item">
                                        <input class="aside-item-input" type="checkbox">
                                        <label class="aside-item-name" for="">Dưới 10.000đ</label>
                                    </li>
                                    <li class="aside-content-item">
                                        <input class="aside-item-input" type="checkbox">
                                        <label class="aside-item-name" for="">Từ 10.000đ - 50.000đ</label>
                                    </li>
                                    <li class="aside-content-item">
                                        <input class="aside-item-input" type="checkbox">
                                        <label class="aside-item-name" for="">Từ 50.000đ - 100.000đ</label>
                                    </li>
                                    <li class="aside-content-item">
                                        <input class="aside-item-input" type="checkbox">
                                        <label class="aside-item-name" for="">Từ 200.000đ - 300.000đ</label>
                                    </li>
                                    <li class="aside-content-item">
                                        <input class="aside-item-input" type="checkbox">
                                        <label class="aside-item-name" for="">Từ 300.000đ - 500.000đ</label>
                                    </li>
                                    <li class="aside-content-item">
                                        <input class="aside-item-input" type="checkbox">
                                        <label class="aside-item-name" for=""> Trên 1 triệu</label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="aside-item">
                            <div class="aside-heading">
                                Loại bìa
                            </div>
                            <div class="aside-content">
                                <ul>
                                    <?php
                                    foreach ($Lst_CoverType as $key => $lst_cv) {
                                    ?>
                                        <li class="aside-content-item">
                                            <input class="aside-item-input" type="checkbox">
                                            <label class="aside-item-name" for=""><?php echo $lst_cv['Name'] ?></label>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="aside-item">
                            <div class="aside-heading">
                                Nhà xuất bản
                            </div>
                            <div class="aside-content">
                                <ul>
                                    <?php
                                    foreach ($Lst_Publisher as $key => $lst_pl) {
                                    ?>
                                        <li class="aside-content-item">
                                            <input class="aside-item-input" type="checkbox">
                                            <label class="aside-item-name" for=""><?php echo $lst_pl['Name'] ?></label>
                                        </li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-9 col-sm-12 col-12">

                    <div class="container">
                        <div class="row">
                            <?php
                            if (isset($_GET['timkiem'])) {
                                $noidung = $_GET['timkiem'];

                                $tukhoa = explode(' ', $noidung);
                                $sql =
                                "SELECT b.Name, b.Price, i.Path 
                                        FROM book b
                                        JOIN image i ON b.ID = i.BookID 
                                        WHERE 
                                        i.Id = (
                                            SELECT MIN(i2.Id)
                                            FROM `image` i2
                                            WHERE i2.BookId = b.Id
                                        )";

                                $conditions = [];
                                $placeholders = [];
                                foreach ($tukhoa as $index => $keyword) {
                                    $conditions[] = "AND b.Name LIKE ?";
                                    $placeholders[] = "%$keyword%";
                                }
                                
                                $sql .= implode(" OR ", $conditions);
                                
                                $ketqua = DP::run_query($sql, $placeholders, $resultType);
                               
                                foreach ($ketqua as $key => $lst_search)
                                {
                                ?>
                                        <div class="product__panel-item col-lg-3 col-md-4 col-sm-6">
                                            <div class="product__panel-item-wrap">
                                                <div class="product__panel-img-wrap">
                                                    <img src="img/Products/<?php echo $lst_search['Path']; ?>" alt="" class="product__panel-img">
                                                </div>
                                                <div class="product__panel-heading">
                                                    <a href="product.html" class="product__panel-link"><?php echo $lst_search['Name']; ?></a>
                                                </div>
                                                <div class="product__panel-rate-wrap">
                                                    <i class="fas fa-star product__panel-rate"></i>
                                                    <i class="fas fa-star product__panel-rate"></i>
                                                    <i class="fas fa-star product__panel-rate"></i>
                                                    <i class="fas fa-star product__panel-rate"></i>
                                                    <i class="fas fa-star product__panel-rate"></i>
                                                </div>
                                                <div class="product__panel-price">
                                                    <span class="product__panel-price-current">
                                                        <?php echo $lst_search['Price']; ?> đ
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                            }
                                        }
                                    ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
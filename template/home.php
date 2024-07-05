<?php

// Kiểm tra trạng thái đăng nhập

$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)
// Kết nối đến cơ sở dữ liệu và thực hiện truy vấn
$query = "SELECT 
b.Id,
b.Name AS BookName, 
b.Price, 
b.TypeId, 
bt.Name AS BookTypeName,
i.Path
FROM 
`book` b
JOIN 
`Type` bt ON b.TypeId = bt.Id
LEFT JOIN 
`image` i ON b.Id = i.BookId
WHERE 
i.Id = (
    SELECT MIN(i2.Id)
    FROM `image` i2
    WHERE i2.BookId = b.Id
);
";


$lst_bv = DP::run_query($query, $parameters, $resultType);

?>

<div class="bodywrap">
    <section class="sliderShow container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div id="carouselExample" class="carousel slide" style="margin: 0 0px 25px 12px; ">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="assets/img/banner/bannerBk.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/hinh-nen-lamborghini-aventador-1.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/HinhCute/hinh-cute-anh-cute.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- <canvas width="450" height="590" id="Book-index" class="3D-book-index"></canvas> -->
            </div>
        </div>


    </section>


    <section class="section-danhmuc">
        <div class="container">
            <div class="group-title-index">
                <h3 class="title">
                    <a class="title-name" href="">Sách bán chạy
                        <img src="assets/img/book-icon.png" alt="">
                    </a>
                </h3>
            </div>
            <div class="product-flash-swiper swiper-container">
                <button class="btn-pre btn-pre-slider"><i class='fa fa-angle-left' aria-hidden='true'></i></button>
                <div class="swiper-wrapper  slick-slider">
                    <?php

                    foreach ($lst_bv as $key => $bv) {
                        if ($bv['TypeId'] == 7) {
                    ?>
                            <div class="swiper-slider">
                                <div class="card">
                                    <a href="index.php?template=product/product_detail&id=<?php echo $bv['Id']; ?>" class="card-img" title="<?php echo $bv['BookName']; ?>">
                                        <img src="assets/img/products/<?php echo $bv['Path'] ?>" alt="">
                                    </a>
                                    <a class="card-info" href="index.php?template=product/product_detail&id=<?php echo $bv['Id']; ?>">
                                        <p class="text-title" title="<?php echo $bv['BookName']; ?>"><?php echo $bv['BookName']; ?> </p>
                                    </a>
                                    <div class="card-footer">
                                        <span class="text-title"><?php echo $bv['Price'] ?> Đ</span>
                                        <div class="card-button">
                                            <svg class="svg-icon" viewBox="0 0 20 20">
                                                <path d="M17.72,5.011H8.026c-0.271,0-0.49,0.219-0.49,0.489c0,0.271,0.219,0.489,0.49,0.489h8.962l-1.979,4.773H6.763L4.935,5.343C4.926,5.316,4.897,5.309,4.884,5.286c-0.011-0.024,0-0.051-0.017-0.074C4.833,5.166,4.025,4.081,2.33,3.908C2.068,3.883,1.822,4.075,1.795,4.344C1.767,4.612,1.962,4.853,2.231,4.88c1.143,0.118,1.703,0.738,1.808,0.866l1.91,5.661c0.066,0.199,0.252,0.333,0.463,0.333h8.924c0.116,0,0.22-0.053,0.308-0.128c0.027-0.023,0.042-0.048,0.063-0.076c0.026-0.034,0.063-0.058,0.08-0.099l2.384-5.75c0.062-0.151,0.046-0.323-0.045-0.458C18.036,5.092,17.883,5.011,17.72,5.011z"></path>
                                                <path d="M8.251,12.386c-1.023,0-1.856,0.834-1.856,1.856s0.833,1.853,1.856,1.853c1.021,0,1.853-0.83,1.853-1.853S9.273,12.386,8.251,12.386z M8.251,15.116c-0.484,0-0.877-0.393-0.877-0.874c0-0.484,0.394-0.878,0.877-0.878c0.482,0,0.875,0.394,0.875,0.878C9.126,14.724,8.733,15.116,8.251,15.116z"></path>
                                                <path d="M13.972,12.386c-1.022,0-1.855,0.834-1.855,1.856s0.833,1.853,1.855,1.853s1.854-0.83,1.854-1.853S14.994,12.386,13.972,12.386z M13.972,15.116c-0.484,0-0.878-0.393-0.878-0.874c0-0.484,0.394-0.878,0.878-0.878c0.482,0,0.875,0.394,0.875,0.878C14.847,14.724,14.454,15.116,13.972,15.116z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <button class="btn-next btn-next-slider"><i class='fa fa-angle-right' aria-hidden='true'></i></button>
            </div>
        </div>
    </section>
    <?php
    foreach ($bookTypeIds as $key => $BookType) {
    ?>
        <!-- <section class="section-1-banner">
                <div class="container">
                    <a class="image-effect" href="">
                        <img width="1920" height="500" src="assets/img/banner/muonkiepnhansinh_resize_920x420.jpg" alt="">
                    </a>
                </div>
            </section> -->
        <section class="section-product section-product1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-xl-3 col-sm-5 d-none d-sm-block">
                        <!-- <canvas id="<?php echo $BookType['Name'] ?>" class="3D-booktype" height="400" width="330"></canvas> -->
                    </div>
                    <div class="col-lg-8 col-xl-9 col-sm-7">
                        <div class="group-title-index">
                            <h3 class="title">
                                <a class="title-name" href=""><?php echo $BookType['Name']  ?>
                                    <img src="assets/img/book-icon.png" alt="">
                                </a>
                                <span class=""></span>
                            </h3>
                        </div>
                        <div class="product-flash-swiper swiper-container">
                            <button class="btn-pre btn-pre-slider<?php echo $BookType['Id'] ?>"><i class='fa fa-angle-left' aria-hidden='true'></i></button>
                            <div class="swiper-wrapper  slick-slider<?php echo $BookType['Id'] ?>">
                                <?php
                                foreach ($lst_bv as $key => $bv) {
                                    if ($bv['TypeId'] == $BookType['Id']) {
                                ?>
                                        <div class="swiper-slider">
                                            <div class="card">
                                                <a href="index.php?template=product/product_detail&id=<?php echo $bv['Id']; ?>" class="card-img" title="<?php echo $bv['BookName'] ?>">
                                                    <img src="assets/img/Products/<?php echo $bv['Path'] ?>" alt="">
                                                </a>
                                                <a class="card-info" href="index.php?template=product/product_detail&id=<?php echo $bv['Id']; ?>" title="<?php echo $bv['BookName'] ?>">
                                                    <p class="text-title"><?php echo $bv['BookName'] ?></p>
                                                </a>
                                                <div class="card-footer">
                                                    <span class="text-title"><?php echo $bv['Price'] ?> Đ</span>
                                                    <div class="card-button">
                                                        <svg class="svg-icon" viewBox="0 0 20 20">
                                                            <path d="M17.72,5.011H8.026c-0.271,0-0.49,0.219-0.49,0.489c0,0.271,0.219,0.489,0.49,0.489h8.962l-1.979,4.773H6.763L4.935,5.343C4.926,5.316,4.897,5.309,4.884,5.286c-0.011-0.024,0-0.051-0.017-0.074C4.833,5.166,4.025,4.081,2.33,3.908C2.068,3.883,1.822,4.075,1.795,4.344C1.767,4.612,1.962,4.853,2.231,4.88c1.143,0.118,1.703,0.738,1.808,0.866l1.91,5.661c0.066,0.199,0.252,0.333,0.463,0.333h8.924c0.116,0,0.22-0.053,0.308-0.128c0.027-0.023,0.042-0.048,0.063-0.076c0.026-0.034,0.063-0.058,0.08-0.099l2.384-5.75c0.062-0.151,0.046-0.323-0.045-0.458C18.036,5.092,17.883,5.011,17.72,5.011z"></path>
                                                            <path d="M8.251,12.386c-1.023,0-1.856,0.834-1.856,1.856s0.833,1.853,1.856,1.853c1.021,0,1.853-0.83,1.853-1.853S9.273,12.386,8.251,12.386z M8.251,15.116c-0.484,0-0.877-0.393-0.877-0.874c0-0.484,0.394-0.878,0.877-0.878c0.482,0,0.875,0.394,0.875,0.878C9.126,14.724,8.733,15.116,8.251,15.116z"></path>
                                                            <path d="M13.972,12.386c-1.022,0-1.855,0.834-1.855,1.856s0.833,1.853,1.855,1.853s1.854-0.83,1.854-1.853S14.994,12.386,13.972,12.386z M13.972,15.116c-0.484,0-0.878-0.393-0.878-0.874c0-0.484,0.394-0.878,0.878-0.878c0.482,0,0.875,0.394,0.875,0.878C14.847,14.724,14.454,15.116,13.972,15.116z"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <button class="btn-next btn-next-slider<?php echo $BookType['Id'] ?>"><i class='fa fa-angle-right' aria-hidden='true'></i></button>
                        </div>
                        <div class="see-more">
                            <a href="" title="xem tất cả">Xem tất cả</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php
    }
    ?>
</div>
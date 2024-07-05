<?php
$lst_Id=null;
$lst_Id2=null;
if (isset($_GET['lst_id'])) {
    $lst_Id = $_GET['lst_id'];
}else if(isset($_GET['lst_id2'])){
    $lst_Id2 = $_GET['lst_id2'];
}

$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)

if($lst_Id ==null && $lst_Id2==null){
    $selectedValue = 24; 
    $query = "SELECT 
    b.Id AS BookId,
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
        )
    LIMIT   $selectedValue";
    $lst_bv = DP::run_query($query, $parameters, $resultType);
}
else if($lst_Id!==null && $lst_Id2==null){
    $query = "SELECT 
	b.Id AS BookId,
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
            WHERE i2.BookId = b.Id  AND b.TypeId=$lst_Id
        )
   ";
    $lst_bv = DP::run_query($query, $parameters, $resultType);
}
else {
    $query = "SELECT 
	b.Id AS BookId,
    b.Name AS BookName, 
    b.Price, 
    b.TypeId, 
    t.Name AS BookTypeName,
    i.Path,
    bt.Id AS bttypeId
    FROM 
    `book` b
    JOIN 
        `Type` t ON b.TypeId = t.Id
    LEFT JOIN 
        `image` i ON b.Id = i.BookId
    LEFT JOIN 
        `booktype` bt  ON bt.Id = i.BookId
    WHERE 
        i.Id = (
            SELECT MIN(i2.Id)
            FROM `image` i2
            WHERE i2.BookId = b.Id  AND bt.TypeDetailId=$lst_Id2
        )
   ";
    $lst_bv = DP::run_query($query, $parameters, $resultType);
}



$queryBookTypes = "SELECT Id, Name FROM `Type` ORDER BY Id ASC";

$bookTypeIds = DP::run_query($queryBookTypes, $parameters, $resultType);

$queryLst_Types = "SELECT * FROM `typedetail` WHERE 1";
$Lst_Type = DP::run_query($queryLst_Types, $parameters, $resultType);

$queryCoverType = "SELECT * FROM `covertype` WHERE 1";
$Lst_CoverType = DP::run_query($queryCoverType, $parameters, $resultType);

$queryPublisher = "SELECT * FROM `publisher` WHERE 1";
$Lst_Publisher = DP::run_query($queryPublisher, $parameters, $resultType);

$typedetailList = array();

foreach ($bookTypeIds as $bookType) {
    $typeId = $bookType['Id'];

    $Top4queryTypeDetail = "SELECT * FROM typedetail WHERE TypeId = $typeId LIMIT 4";
    $Top4typeDetails = DP::run_query($Top4queryTypeDetail, $parameters, $resultType);

    // Hợp nhất kết quả truy vấn vào danh sách
    $typedetailList = array_merge($typedetailList, $Top4typeDetails);
}

// Giá trị đã chọn (có thể là giá trị được lấy từ người dùng)



?>

<link rel="stylesheet" href="assets/css/lst_product.css">

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
                                Danh mục sản phẩm
                            </div>
                            <ul class="product-category-list">
                                <?php
                                foreach ($bookTypeIds as $key => $lst_type) {
                                ?>
                                    <li class="product-category-item">
                                        <a class="nav-link" href="index.php?template=product/lst_product&lst_id=<?php echo $lst_type['Id'] ?>"><?php echo $lst_type['Name'] ?></a>
                                        <i id="category-code-<?php echo $lst_type['Id'] ?>" class="open-menu category-code icon-menu" onclick="ShowMenu(this)" data-target="Menu-detail-<?php echo $lst_type['Id'] ?>"></i>
                                        <ul class="menu-down" id="Menu-detail-<?php echo $lst_type['Id'] ?>">
                                            <?php
                                            foreach ($Lst_Type as $key => $lst_typedetail) {
                                                if ($lst_typedetail['TypeId'] == $lst_type["Id"]) {
                                            ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="index.php?template=product/lst_product&lst_id2=<?php echo $lst_typedetail['Id'] ?>"><?php echo $lst_typedetail['Name'] ?></a>
                                                    </li>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
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
                    <div class="sort-product">
                        <h3 class="sort-heading">
                            <i class="fa-solid fa-arrow-down-z-a"></i>
                            Xếp theo
                        </h3>
                        <div class="d-flex">
                            <select class="sort-arrange" name="select-item" id="sort-arr">
                                <option class="sort-item" value="1">Bán chạy tuần</option>
                                <option class="sort-item" value="2">Bán chạy tháng</option>
                                <option class="sort-item" value="3">Bán chạy năm</option>
                                <option class="sort-item" value="4">Mới nhất</option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        foreach ($lst_bv as $key => $bv) {
                        ?>
                            <div class="product__panel-item col-lg-3 col-md-4 col-sm-6">
                                <div class="product__panel-item-wrap">
                                    <div class="product__panel-img-wrap">
                                        <img src="assets/img/Products/<?php echo $bv['Path'] ?>" alt="" class="product__panel-img">
                                    </div>
                                    <div class="product__panel-heading">
                                        <a href="product.html" class="product__panel-link"><?php echo $bv['BookName'] ?></a>
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
                                            <?php echo $bv['Price'] ?>0 đ
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <nav class="page-book" aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

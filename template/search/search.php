<?php
require_once('API/db.php');
require_once('template/layout/layout.php');

$queryCoverType = "SELECT * FROM `covertype` WHERE 1";
$Lst_CoverType = DP::run_query($queryCoverType, $parameters, $resultType);

$queryPublisher = "SELECT * FROM `publisher` WHERE 1";
$Lst_Publisher = DP::run_query($queryPublisher, $parameters, $resultType);

?>

<link rel="stylesheet" href="assets/css/search.css">

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
                                    <input class="aside-item-input" type="checkbox" name="price[]" value="0-10000">
                                    <label class="aside-item-name" for="">Dưới 10.000đ</label>
                                </li>
                                <li class="aside-content-item">
                                    <input class="aside-item-input" type="checkbox" name="price[]" value="10000-50000">
                                    <label class="aside-item-name" for="">Từ 10.000đ - 50.000đ</label>
                                </li>
                                <li class="aside-content-item">
                                    <input class="aside-item-input" type="checkbox" name="price[]" value="50000-100000">
                                    <label class="aside-item-name" for="">Từ 50.000đ - 100.000đ</label>
                                </li>
                                <li class="aside-content-item">
                                    <input class="aside-item-input" type="checkbox" name="price[]" value="200000-300000">
                                    <label class="aside-item-name" for="">Từ 200.000đ - 300.000đ</label>
                                </li>
                                <li class="aside-content-item">
                                    <input class="aside-item-input" type="checkbox" name="price[]" value="300000-500000">
                                    <label class="aside-item-name" for="">Từ 300.000đ - 500.000đ</label>
                                </li>
                                <li class="aside-content-item">
                                    <input class="aside-item-input" type="checkbox" name="price[]" value="1000000-">
                                    <label class="aside-item-name" for="">Trên 1 triệu</label>
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
                            $noidung = trim($_GET['timkiem']);
                            $tukhoa = explode(' ', $noidung);

                            // Tính tổng số kết quả tìm kiếm
                            $query_count = "
                                    SELECT COUNT(*) AS total
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
                            foreach ($tukhoa as $index => $noidung) {
                                $conditions[] = "b.Name LIKE ?";
                                $placeholders[] = "%$noidung%";
                            }

                            if (!empty($conditions)) {
                                $query_count .= " AND (" . implode(" OR ", $conditions) . ")";
                            }

                            $total_results = DP::run_query($query_count, $placeholders, PDO::FETCH_ASSOC);
                            if ($total_results !== false) {
                                $total = $total_results[0]['total'];
                                $results_per_page = 24; // Số kết quả mỗi trang
                                $total_pages = ceil($total / $results_per_page);

                                $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $start_from = ($current_page - 1) * $results_per_page;

                                // Khởi tạo câu lệnh SQL để lấy kết quả phân trang
                                $sql = "
                                        SELECT b.Id, b.Name, b.Price, i.Path 
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
                                foreach ($tukhoa as $index => $noidung) {
                                    $conditions[] = "b.Name LIKE ?";
                                    $placeholders[] = "%$noidung%";
                                }

                                if (!empty($conditions)) {
                                    $sql .= " AND (" . implode(" OR ", $conditions) . ")";
                                }

                                $sql .= " LIMIT ? OFFSET ?";
                                $placeholders[] = $results_per_page;
                                $placeholders[] = $start_from;

                                $ketqua = DP::run_query($sql, $placeholders, PDO::FETCH_ASSOC);

                                if ($ketqua !== false && is_array($ketqua)) {
                                    echo "<h6> KẾT QUẢ TÌM KIẾM CHO: " . htmlspecialchars($noidung) . " (" . $total . " Kết quả) </h6>"; // Hiển thị tổng số kết quả tìm thấy

                                    foreach ($ketqua as $key => $lst_search) {
                        ?>
                                        <div class="product__panel-item col-lg-3 col-md-4 col-sm-6">
                                            <div class="product__panel-item-wrap">
                                                <div class="product__panel-img-wrap">
                                                    <a href="index.php?template=product/product_detail&id=<?php echo $lst_search['Id']; ?>">
                                                        <img src="assets/img/Products/<?php echo htmlspecialchars($lst_search['Path']); ?>" alt="" class="product__panel-img">
                                                    </a>
                                                </div>
                                                <div class="product__panel-heading">
                                                    <a href="index.php?template=product/product_detail&id=<?php echo $lst_search['Id']; ?>" class="product__panel-link"><?php echo htmlspecialchars($lst_search['Name']); ?></a>
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
                                                        <?php echo htmlspecialchars($lst_search['Price']); ?> đ
                                                    </span>
                                                </div>
                                            </div>

                                        </div>
                        <?php
                                    }
                                } else {
                                    echo "<h6> Không có kết quả nào cho từ khóa: " . htmlspecialchars($noidung) . "</h6>";
                                }
                            } else {
                                echo "<h6> Lỗi trong quá trình truy vấn cơ sở dữ liệu.</h6>";
                            }
                        }
                        ?>
                        <nav class="page-book" aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php
                                if ($total_pages > 1) {
                                    if ($current_page > 1) {
                                        echo '<li class="page-item"><a class="page-link" href="index.php?template=search/search&timkiem=' . htmlspecialchars($noidung) . '&page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>';
                                    }
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        if ($i == $current_page) {
                                            echo '<li class="page-item active"><a class="page-link" href="index.php?template=search/search&timkiem=' . htmlspecialchars($noidung) . '&page=' . $i . '">' . $i . '</a></li>';
                                        } else {
                                            echo '<li class="page-item"><a class="page-link" href="index.php?template=search/search&timkiem=' . htmlspecialchars($noidung) . '&page=' . $i . '">' . $i . '</a></li>';
                                        }
                                    }
                                    if ($current_page < $total_pages) {
                                        echo '<li class="page-item"><a class="page-link" href="index.php?template=search/search&timkiem=' . htmlspecialchars($noidung) . '&page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>';
                                    }
                                }
                                ?>
                            </ul>
                        </nav>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
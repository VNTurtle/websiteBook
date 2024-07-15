<?php

$items_per_page = 10; // Số sản phẩm mỗi trang
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$parameters = [];
$resultType = 2;
// Truy vấn để đếm tổng số sản phẩm
$query_count = "SELECT COUNT(*)as sl FROM book";
$count_product = DP::run_query($query_count, $parameters, 2); // Giả sử `run_query` trả về mảng kết quả
$total_items = $count_product[0]['sl'];
$total_pages = ceil($total_items / $items_per_page);
$offset = ($current_page - 1) * $items_per_page;
$adjacents = 2;


$query_lstproduct = "SELECT b.*, bt.Name AS BookTypeName, s.Name AS SizeName, p.Name AS PublisherName, cv.Name AS CovertypeName, i.Path
                        FROM book b
                        LEFT JOIN Type bt ON b.TypeId = bt.Id
                        JOIN Size s ON b.SizeId = s.Id
                        JOIN Publisher p ON b.PublisherId = p.Id
                        JOIN covertype cv ON b.CoverTypeId = cv.Id
                        JOIN 
                            `image` i ON b.Id = i.BookId
                            WHERE 
                            i.Id = (
                                SELECT MIN(i2.Id)
                                FROM `image` i2
                                WHERE i2.BookId = b.Id
                            ) LIMIT $offset, $items_per_page";
$lst_product = DP::run_query($query_lstproduct, $parameters, $resultType);

?>

<link rel="stylesheet" href="admin/css/lst_product.css">
<div class="content-wrapper">

    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">



        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Sản Phẩm /</span> Danh Sách Sản Phẩm
        </h4>

        <!-- Product List Widget -->

        <div class="card mb-4">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                <div>
                                    <h6 class="mb-2">In-store Sales</h6>
                                    <h4 class="mb-2">$5,345.43</h4>
                                    <p class="mb-0"><span class="text-muted me-2">5k orders</span><span class="badge bg-label-success">+5.7%</span></p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-store-alt bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                <div>
                                    <h6 class="mb-2">Website Sales</h6>
                                    <h4 class="mb-2">$674,347.12</h4>
                                    <p class="mb-0"><span class="text-muted me-2">21k orders</span><span class="badge bg-label-success">+12.4%</span></p>
                                </div>
                                <div class="avatar me-lg-4">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-laptop bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none">
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                <div>
                                    <h6 class="mb-2">Discount</h6>
                                    <h4 class="mb-2">$14,235.12</h4>
                                    <p class="mb-0 text-muted">6k orders</p>
                                </div>
                                <div class="avatar me-sm-4">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-gift bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-2">Affiliate</h6>
                                    <h4 class="mb-2">$8,345.23</h4>
                                    <p class="mb-0"><span class="text-muted me-2">150 orders</span><span class="badge bg-label-danger">-3.5%</span></p>
                                </div>
                                <div class="avatar">
                                    <span class="avatar-initial rounded bg-label-secondary">
                                        <i class="bx bx-wallet bx-sm"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product List Table -->
        <div class="card">
            <div class="card-datatable ">
                <table class="datatables-products table border-top">
                    <div class="card-header d-flex border-top rounded-0 flex-wrap py-md-0">
                        <div class="me-5 ms-n2 pe-5">
                            <div class="dataTables_filter">
                                <label>
                                    <input type="search" class="form-control" placeholder="Search Product" aria-controls="DataTables_Table_0">
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                            <div class="add-product dt-action-buttons d-flex align-items-start align-items-md-center justify-content-sm-center mb-3 mb-sm-0">
                                <div class="dt-buttons btn-group flex-wrap d-flex">
                                    <div class="btn-group">
                                        <button class="btn buttons-collection dropdown-toggle btn-label-secondary me-3" tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog" aria-expanded="false">
                                            <span>
                                                <i class="bx bx-export me-1"></i>Export
                                            </span>
                                        </button>
                                    </div>
                                    <button class="btn btn-secondary add-new btn-primary" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                                        <a href="index.php?folder=admin&template=product/add_product" style="color: #fff;">
                                            <i class="bx bx-plus me-0 me-sm-1"></i>
                                            <span class="d-none d-sm-inline-block">Add Product</span>
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <thead>
                        <tr style="background-color: aqua;">
                            <th>STT</th>
                            <th>product</th>
                            <th>category</th>
                            <th>Author</th>
                            <th>price</th>
                            <th>qty</th>
                            <th>status</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($lst_product as $key => $lst) {
                        ?>
                            <tr class="odd">
                                <td>
                                    <?= $offset + $key + 1 ?>
                                </td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar me-2 rounded-2 bg-label-secondary">
                                                <img class="rounded-2" src="assets/img/products/<?php echo $lst['Path'] ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="name-product" style="width: 315px;">
                                            <h6 class="text-body text-nowrap mb-0" style="white-space: normal !important; overflow-wrap: break-word;"><?php echo $lst['Name'] ?> </h6>
                                        </div>

                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center">
                                        <?php echo $lst['BookTypeName'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate align-items-center" style="white-space: normal !important;
                                                                                            overflow-wrap: break-word;">
                                        <?php echo $lst['Author'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate align-items-center">
                                        <?php echo $lst['Price'] ?> đ
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate align-items-center">
                                        <?php echo $lst['Stock'] ?>
                                    </span>
                                </td>
                                <td>
                                    <label>
                                        <input class="toggle-checkbox" type="checkbox" data-book-id="<?php echo $lst['Id']; ?>" <?php echo ($lst['Status'] == 1) ? 'checked' : ''; ?>>
                                        <div class="toggle-slot">
                                            <div class="sun-icon-wrapper">
                                                <div class="iconify sun-icon" data-icon="feather-sun" data-inline="false"></div>
                                            </div>
                                            <div class="toggle-button"></div>
                                            <div class="moon-icon-wrapper">
                                                <div class="iconify moon-icon" data-icon="feather-moon" data-inline="false"></div>
                                            </div>
                                        </div>
                                    </label>
                                </td>
                                <td>
                                    <div class="d-inline-block text-nowrap">
                                        <button class="btn btn-sm btn-icon">
                                            <a href="index.php?folder=admin&template=product/edit_product&id=<?php echo $lst['Id'] ?>">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                        </button>
                                        <button class="btn btn-sm btn-icon">
                                            <a href="index.php?folder=admin&template=product/product_detail&id=<?php echo $lst['Id'] ?>">
                                                <i class="bx bx-show"></i>
                                            </a>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="row mx-2">
                    <div class="col-sm-12 col-md-6 shows-stt">
                        <div class="data-info">Hiển thị từ <?php echo $offset + 1 ?> đến <?php echo $offset + count($lst_product) ?> của <?php echo $total_items ?> sản phẩm</div>
                    </div>
                    <div class="col-sm-12 col-md-6 show-page">
                        <nav class="page-book" aria-label="Page navigation example" style="margin-top: 12px;">
                            <ul class="pagination">
                                <?php if ($current_page > 1) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?folder=admin&template=product/lst_product&page=<?php echo $current_page - 1 ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>

                                <?php
                                // Hiển thị trang đầu
                                if ($current_page > ($adjacents + 1)) {
                                    echo '<li class="page-item"><a class="page-link" href="index.php?folder=admin&template=product/lst_product&page=1">1</a></li>';
                                    if ($current_page > ($adjacents + 2)) {
                                        echo '<li class="page-item"><span class="page-link">...</span></li>';
                                    }
                                }

                                // Hiển thị các trang xung quanh trang hiện tại
                                $start = max(1, $current_page - $adjacents);
                                $end = min($total_pages, $current_page + $adjacents);
                                for ($i = $start; $i <= $end; $i++) {
                                    if ($i == $current_page) {
                                        echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                                    } else {
                                        echo '<li class="page-item"><a class="page-link" href="index.php?folder=admin&template=product/lst_product&page=' . $i . '">' . $i . '</a></li>';
                                    }
                                }

                                // Hiển thị trang cuối
                                if ($current_page < ($total_pages - $adjacents)) {
                                    if ($current_page < ($total_pages - $adjacents - 1)) {
                                        echo '<li class="page-item"><span class="page-link">...</span></li>';
                                    }
                                    echo '<li class="page-item"><a class="page-link" href="index.php?folder=admin&template=product/lst_product&page=' . $total_pages . '">' . $total_pages . '</a></li>';
                                }

                                if ($current_page < $total_pages) : ?>
                                    <li class="page-item">
                                        <a class="page-link" href="index.php?folder=admin&template=product/lst_product&page=<?php echo $current_page + 1 ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>

                    </div>
                </div>

            </div>

        </div>
    </div>


</div>
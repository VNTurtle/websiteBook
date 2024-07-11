<?php

$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)
$query_invoice = "SELECT iv.*, b.Name, i.Path, os.Name AS NameOrder 
FROM `invoicedetail` iv
LEFT JOIN book b ON iv.BookId = b.Id
JOIN orderstatus os ON iv.OrderStatusId = os.Id
JOIN `image` i ON b.Id = i.BookId
WHERE i.Id = (
    SELECT MIN(i2.Id)
    FROM `image` i2
    WHERE i2.BookId = b.Id
);";
$invoice = DP::run_query($query_invoice, $parameters, $resultType);

$query_Order = "SELECT * FROM `orderstatus` WHERE 1";
$Order = DP::run_query($query_Order, $parameters, $resultType);
?>

<link rel="stylesheet" href="admin/css/lst_invoice.css">

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
        <div class="card">
            <div class="card-datatable ">
                <table class="datatables-products table border-top">
                    <thead>
                        <tr style="background-color: aqua;">
                            <th>STT</th>
                            <th>product</th>
                            <th>price</th>
                            <th>qty</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($invoice as $key => $lst) {
                        ?>
                            <tr class="odd">
                                <td>
                                    <?php echo $key + 1 ?>
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
                                    <span class="text-truncate align-items-center">
                                        <?php echo $lst['UnitPrice'] ?> đ
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate align-items-center">
                                        <?php echo $lst['Quantity'] ?>
                                    </span>
                                </td>
                                    <td>
                                        <select name="order_status" id="order_status" class="custom-select order_status" data-order-id="<?php echo $lst['Id']; ?>" >
                                            <?php
                                            foreach ($Order as $key => $item) {
                                                $selected = ($lst['OrderStatusId'] == $item['Id']) ? 'selected' : '';
                                                echo '<option value="' . ($item['Id']) . '" ' . $selected . '>' . $item['Name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div class="row mx-2">
                    <div class="col-sm-12 col-md-6 shows-stt">
                        <div class="data-info">Hiển thị từ 1 đến 10 của 100 sản phẩn</div>
                    </div>
                    <div class="col-sm-12 col-md-6 show-page">
                        <nav class="page-book" aria-label="Page navigation example " style="margin-top: 12px;">
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
</div>
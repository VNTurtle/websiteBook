<?php
$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)
$query_product = "SELECT b.*, m.Model, m.ModelBin, i.Path
FROM book b
LEFT JOIN model m ON b.Id = m.BookId
JOIN `image` i ON b.Id = i.BookId
WHERE i.Id = (
        SELECT MIN(i2.Id)
        FROM `image` i2
        WHERE i2.BookId = b.Id
    ) LIMIT 10";
$lst_product = DP::run_query($query_product, $parameters, $resultType);

$query_IMG = "SELECT * FROM `image`";
$lst_IMG = DP::run_query($query_IMG, $parameters, $resultType);
?>

<link rel="stylesheet" href="admin/css/lst_img_product.css">

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Sản Phẩm /</span> Danh sách hình ảnh
        </h4>
        <!-- Model List Table -->
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <thead>
                        <tr style="background-color: aqua;">
                            <th>STT</th>
                            <th>IMG</th>
                            <th>product</th>
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
                                    <?php echo $key + 1 ?>
                                </td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar me-2 rounded-2 bg-label-secondary">
                                                <?php
                                                foreach ($lst_IMG as $key => $item_img) {
                                                    if ($item_img['BookId'] === $lst['Id']) {
                                                ?>
                                                        <img class="rounded-2" src="assets/img/products/<?= $item_img['Path'] ?>" alt="">
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="name-product" style="width: 315px;">
                                        <h6 class="text-body text-nowrap mb-0"><?php echo $lst['Name'] ?> </h6>
                                    </div>
                                </td>
                                <td>
                                    <label>
                                        <input class="toggle-checkbox" type="checkbox" <?php echo ($lst['Status'] == 1) ? 'checked' : ''; ?>>
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
                                            <a href="index.php?folder=admin&template=model/edit_model_product&id=<?php echo $lst['Id']; ?>">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                        </button>
                                        <button class="btn btn-sm btn-icon">
                                            <a href="index.php?folder=admin&template=model/model_detail_product&id=<?php echo $lst['Id']; ?>">
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
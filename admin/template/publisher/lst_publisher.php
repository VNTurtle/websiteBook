<?php
$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)
$query_lstpls = "SELECT * FROM `publisher` LIMIT 10";
$lst_publisher = DP::run_query($query_lstpls, $parameters, $resultType)
?>

<link rel="stylesheet" href="admin/css/model_product.css">

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Sản Phẩm /</span> Nhà xuất bản
        </h4>
        <!-- Model List Table -->
        <div class="card">
            <div class="card-datatable ">
                <table class="datatables-products table border-top">
                    <div class="card-header d-flex border-top rounded-0 flex-wrap py-md-0">
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
                                        <span>
                                            <i class="bx bx-plus me-0 me-sm-1"></i>
                                            <span class="d-none d-sm-inline-block">Add Publisher</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <thead>
                        <tr style="background-color: aqua;">
                            <th>STT</th>
                            <th>Name</th>
                            <th>status</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($lst_publisher as $key => $lst) {
                        ?>
                            <tr class="odd">
                                <td>
                                    <?php echo $key + 1 ?>
                                </td>
                                <td>
                                    <span class="text-truncate d-flex align-items-center">
                                        <?php echo $lst['Name'] ?>
                                    </span>
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
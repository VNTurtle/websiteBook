<?php

$joinedTables = [
    'cb' => 'Combo',
    's' => 'Size',
    'p' => 'Publisher',
    'cv' => 'Covertype'
];

$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)


$query_Combo = "SELECT * FROM `combobook` ";
$Combo = DP::run_query($query_Combo, $parameters, $resultType);

$query_Type = "SELECT * FROM `type` ";
$Type = DP::run_query($query_Type, $parameters, $resultType);

$query_Size = "SELECT * FROM `size` ";
$Size = DP::run_query($query_Size, $parameters, $resultType);

$query_Publisher = "SELECT * FROM `publisher` ";
$Publisher = DP::run_query($query_Publisher, $parameters, $resultType);

$query_CoverType = "SELECT * FROM `coverType` ";
$CoverType = DP::run_query($query_CoverType, $parameters, $resultType);
?>
<link rel="stylesheet" href="admin/css/add_product.css">

<div id="opacity"></div>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Sản Phẩm /</span> Chỉnh sửa Sản Phẩm
        </h4>
        <div class="card">
            <h4 class="py-3 mb-4" style="color: #656cf9;">
                <span class="text-muted fw-light"> - Sản Phẩm /</span>
            </h4>
            <div class="edit_product">
                <form id="add_Product"  onsubmit="add_Product(event)" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Tên sản phẩm</label>
                        <input type="text" name="Name" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Theo Bộ</label>
                        <select name="<?= $joinedTables['cb'] ?>">
                            <option value="0">Không có</option>
                            <?php
                            foreach ($Combo as $key => $lst_combo) {
                                echo '<option  value="' . $lst_combo['Id'] . '">' . $lst_combo['Name'] . '</option>';
                            }
                            ?>
                        </select>
                        <button class="btn btn-secondary add-new btn-primary" type="button" onclick="openForm('<?= $joinedTables['cb'] ?>')">
                            <span>
                                <i class="bx bx-plus me-0 me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">Thêm Bộ</span>
                            </span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="">Tác giả</label>
                        <input type="text" name="Author" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Loại sản phẩm</label>
                        <select name="TypeId">
                            <?php
                            foreach ($Type as $key => $lst_type) {
                                echo '<option value="' . $lst_type['Id'] . '">' . $lst_type['Name'] . '</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="">Số trang</label>
                        <input type="number" name="NumberPage" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Kích thước</label>
                        <select name="<?= $joinedTables['s'] ?>">
                            <?php
                            foreach ($Size as $key => $lst_size) {
                                echo '<option value="' . $lst_size['Id'] . '" >' . $lst_size['Name'] . ' cm</option>';
                            }
                            ?>
                        </select>
                        <button class="btn btn-secondary add-new btn-primary" type="button" onclick="openForm('<?= $joinedTables['s'] ?>')">
                            <span>
                                <i class="bx bx-plus me-0 me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">Thêm Kích thước</span>
                            </span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="">Tồn kho</label>
                        <input type="number" name="Stock" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Giá sản phẩm</label>
                        <input type="number" name="Price" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Ngày sản xuất</label>
                        <input type="date" name="Date" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Tên nhà xuất bản</label>
                        <select name="<?= $joinedTables['p'] ?>">
                            <?php
                            foreach ($Publisher as $key => $lst_publisher) {
                                echo '<option value="' . $lst_publisher['Id'] . '" >' . $lst_publisher['Name'] . '</option>';
                            }
                            ?>
                        </select>
                        <button class="btn btn-secondary add-new btn-primary" type="button" onclick="openForm('<?= $joinedTables['p'] ?>')">
                            <span>
                                <i class="bx bx-plus me-0 me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">Thêm NXB</span>
                            </span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="">Loại bìa</label>
                        <select name="<?= $joinedTables['cv'] ?>">
                            <?php
                            foreach ($CoverType as $key => $lst_coverType) {

                                echo '<option value="' . $lst_coverType['Id'] . '">' . $lst_coverType['Name'] . '</option>';
                            }
                            ?>
                        </select>
                        <button class="btn btn-secondary add-new btn-primary" type="button" onclick="openForm('<?= $joinedTables['cv'] ?>')">
                            <span>
                                <i class="bx bx-plus me-0 me-sm-1"></i>
                                <span class="d-none d-sm-inline-block">Thêm bìa</span>
                            </span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="">Nội dung</label>
                        <textarea name="Description" id="Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="coverImage">Ảnh Bìa:</label>
                        <input type="file" id="coverImage" name="coverImage" accept="image/*" required>
                    </div>
                    <div class="form-group">
                        <label for="additionalImages">Các Hình Phụ:</label>
                        <input type="file" id="additionalImages" name="additionalImages[]" accept="image/*" multiple>
                    </div>
                    <div class="form-group">
                        <label for="imagePreview">Xem Trước Hình:</label>
                        <div id="imagePreview"></div>
                    </div>
                    <button class="btn btn-primary">Lưu</button>
                </form>
            </div>
            <div id="loading_update" class="title-pay hidden">
                <div class="dot-spinner ">

                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                    <div class="dot-spinner__dot"></div>
                </div>
                <div class="title-loading">
                    <h4>Đang xử lý</h4>
                </div>
            </div>
            <?php foreach ($joinedTables as $key => $lst_bv) { ?>
                <div id="<?= $lst_bv ?>" class="form-popup">
                    <div class="form-popup-content">
                        <span class="close-btn" onclick="closeForm('<?= $lst_bv ?>')">&times;</span>
                        <h2>Thêm <?= $lst_bv ?></h2>
                        <form id="form-<?= $lst_bv ?>" action="process_form.php" method="post">
                            <label for="<?= $lst_bv ?>Name">Tên <?= $lst_bv ?>:</label>
                            <input type="text" id="<?= $lst_bv ?>Name" name="<?= $lst_bv ?>" required>
                            <button type="button" class="btn btn-primary" onclick="submitForm('<?= $lst_bv ?>')">Thêm <?= $lst_bv ?></button>
                            <div id="mess_<?= $lst_bv ?>" class="mess hidden"> Đã thêm <?= $lst_bv ?></div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
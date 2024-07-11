<?php

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
}

$query = "SELECT b.*, m.Model, m.ModelBin,m.Alpha,m.Beta,m.Radius,m.Target_x,m.Target_y,m.Target_z, bt.Name AS BookTypeName, s.Name AS SizeName, p.Name AS PublisherName, cv.Name AS CovertypeName
FROM book b
LEFT JOIN model m ON b.Id = m.BookId
JOIN Type bt ON b.TypeId = bt.Id
JOIN Size s ON b.SizeId = s.Id
JOIN Publisher p ON b.PublisherId = p.Id
JOIN covertype cv ON b.CoverTypeId = cv.Id
WHERE b.Id = $bookId;";
$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)

$book = DP::run_query($query, $parameters, $resultType);

if (count($book) > 0) {
    $NameBook = $book[0]['Name'];
    $model = $book[0]['Model'];
    $modelBin = $book[0]['ModelBin'];
    $comboBookId = $book[0]['ComboBookId'];
    $typeId = $book[0]['TypeId'];
    $cameraState = [
        'alpha' => $book[0]['Alpha'],
        'beta' => $book[0]['Beta'],
        'radius' => $book[0]['Radius'],
        'target' => [
            'x' => $book[0]['Target_x'],
            'y' => $book[0]['Target_y'],
            'z' => $book[0]['Target_z']
        ]
    ];
    // Gửi dữ liệu cameraState từ PHP xuống JavaScript
    echo "<script>";
    echo "var cameraState2 = " . json_encode($cameraState) . ";";
    echo "</script>";
} else {
    echo "Không tìm thấy kết quả.";
    $model = null;
    $modelBin = null;
}
$queryImage = "SELECT * FROM `image` WHERE BookId=$bookId;";

$lst_Image = DP::run_query($queryImage, $parameters, $resultType);


//  Hàm chuyển đổi Tên có dấu
function removeAccents($str)
{
    $accentedChars = ['á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'đ', 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'í', 'ì', 'ỉ', 'ĩ', 'ị', 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Đ', 'É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ'];
    $unaccentedChars = ['a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'd', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'y', 'y', 'y', 'y', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'D', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'Y', 'Y', 'Y', 'Y', 'Y'];

    // Đảm bảo cả hai mảng có cùng số phần tử
    if (count($accentedChars) == count($unaccentedChars)) {
        return $str; // Trả về chuỗi ban đầu nếu số lượng ký tự không khớp
    }
    return str_replace($accentedChars, $unaccentedChars, $str);
}
// Function to sanitize filenames
function sanitizeFilename($filename)
{
    // Loại bỏ các ký tự đặc biệt
    $filename = preg_replace('/[^\pL\d.]+/u', '', $filename);
    // Loại bỏ các ký tự không hợp lệ
    $filename = preg_replace('/[^\x20-\x7E]/', '', $filename);
    // Chuyển đổi tiếng Việt có dấu thành tiếng Việt không dấu
    $filename = mb_convert_encoding($filename, 'ASCII', 'UTF-8');
    // Loại bỏ các ký tự đặc biệt còn lại
    $filename = preg_replace('/[^-\w.]+/', '', $filename);
    return $filename;
}

$modelName = sanitizeFilename(removeAccents($NameBook));
if ($book[0]['Model'] != null) {
    $gltfFilePath = 'assets/model/' . $modelName . $bookId . '/' . $model;
    $binFilePath = 'assets/model/' . $modelName . $bookId . '/' . $modelBin;

    // Đọc nội dung của tệp gltf
    $gltfContent = file_get_contents($gltfFilePath);

    // Thay thế đường dẫn "uri":"$modelBin" bằng "uri":"Model/$modelBin"
    if (strpos($gltfContent, 'assets/model/') === false) {
        // Thay thế đường dẫn "uri":"$modelBin" bằng "uri":"assets/model/' . $modelName . '/$modelBin"
        $modifiedGltfContent = preg_replace('/"uri"\s*:\s*"(?!assets\/model\/)([^"]+)"/', '"uri":"assets/model/' . $modelName . $bookId . '/$1"', $gltfContent);

        // Ghi lại nội dung đã sửa đổi vào tệp gltf gốc
        file_put_contents($gltfFilePath, $modifiedGltfContent);
    }
}
?>
<link rel="stylesheet" href="admin/css/product_detail.css">
<link rel="stylesheet" href="assets/sclick/css/slick.min.css">

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Sản Phẩm /</span> Chi tiết Sản Phẩm
        </h4>
        <div class="card">
            <h4 class="py-3 mb-4" style="color: #656cf9;">
                <span class="text-muted fw-light"> - Sản Phẩm /</span>
            </h4>
            <div class="row">
                <div class="product-detail-lef product-images col-3 col-md-6 col-lg-4">
                    <div class="product-image-block relative">
                        <div class="swiper-container gallery-top ">
                            <?php
                            if ($book[0]['Model'] != null) {
                            ?>
                                <input id="Model" type="hidden" name="model" value="<?php echo $gltfFilePath ?>">
                                <input id="Model_bin" type="hidden" name="modelbin" value="<?php echo $binFilePath ?>">
                            <?php
                            }
                            ?>
                            <div class="swiper-wrapper slider-for" style="justify-content: center;">
                                <?php
                                if ($book[0]['Model'] != null) {
                                ?>
                                    <div class="swiper-slide swiper-slide-active" href="" style="width: 330px; justify-content: center;">
                                        <canvas id="3D-Book" class="3DImage" height="400" width="400"></canvas>
                                    </div>
                                <?php
                                }

                                ?>
                                <?php
                                foreach ($lst_Image as $key => $img) {
                                ?>
                                    <a class="swiper-slide swiper-slide-active" href="" style="width: 330px; justify-content: center;">
                                        <img height="400" width="400" src="assets/img/products/<?php echo $img['Path'] ?>" alt="">
                                    </a>
                                <?php
                                }
                                ?>

                            </div>

                        </div>
                        <div class="swiper-container gallery-thumb ">
                            <div class="swiper-wrapper slider-nav">
                                <?php
                                if ($book[0]['Model'] != null) {
                                ?>
                                    <div class="swiper-slide swiper-slide-visible">
                                        <img src="assets/img/model_3D.jpg" alt="">
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                foreach ($lst_Image as $key => $img) {
                                ?>
                                    <div class="swiper-slide swiper-slide-visible">
                                        <img class="img-product" src="assets/img/products/<?php echo $img['Path'] ?>" title="<?php echo $img['Path'] ?>" alt="">
                                    </div>
                                <?php
                                }
                                ?>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-8 product-detail">
                    <div class="details-pro">
                        <input id="Id-product" type="text" value="<?php echo $book[0]['Id'] ?>" style="display: none;">
                        <h1 id="name-product" class="title-product"><?php echo $book[0]['Name'] ?></h1>
                        <div class="col-12 product-detail-table">
                            <div class="title">
                                <span>Thông tin chi tiết </span>
                            </div>
                            <div class="content">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th style="color: #007bff;">Công ty phát hành</th>
                                            <td><?php echo $book[0]['PublisherName'] ?></td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">Ngày xuất bản</th>
                                            <td><?php echo $book[0]['Date'] ?></td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">Kích thước</th>
                                            <td><?php echo $book[0]['SizeName'] ?></td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">Loại bìa</th>
                                            <td><?php echo $book[0]['CovertypeName'] ?></td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">Số trang</th>
                                            <td><?php echo $book[0]['NumberPage'] ?></td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">SKU</th>
                                            <td><?php echo $book[0]['SKU'] ?></td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">Tác giả</th>
                                            <td><?php echo $book[0]['Author'] ?></td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">Giá</th>
                                            <td><?php echo $book[0]['Price'] ?> Đ</td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">Tồn hàng</th>
                                            <td><?php echo $book[0]['Stock'] ?></td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">Thể loại</th>
                                            <td><?php echo $book[0]['BookTypeName'] ?></td>
                                        </tr>
                                        <tr>
                                            <th style="color: #007bff;">Ngày phát hành</th>
                                            <td><?php echo $book[0]['Date'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="noidung">
                        <h4>Nội dung</h4>
                        <div>
                            <?php echo $book[0]['Description'] ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="edit_product">
                <button class="btn btn-primary">
                    <a href="index.php?folder=admin&template=product/edit_product&id=<?= $bookId ?>"
                    style="color: #fff;">Chỉnh sửa</a>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="assets/babylon/babylon.js"></script>
<script src="assets/babylon/babylonjs.loaders.min.js"></script>
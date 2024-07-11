<?php

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
}


$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)
$query_lstmodel = "SELECT b.*,m.Id AS IdModel, m.Model, m.ModelBin,m.Alpha,m.Beta,m.Radius,m.Target_x,m.Target_y,m.Target_z, i.Path
FROM book b
LEFT JOIN model m ON b.Id = m.BookId
JOIN `image` i ON b.Id = i.BookId
WHERE i.Id = (
        SELECT MIN(i2.Id)
        FROM `image` i2
        WHERE i2.BookId = b.Id
    ) AND b.Id=$bookId";
$modelbook = DP::run_query($query_lstmodel, $parameters, $resultType);

if (count($modelbook) > 0) {
    $NameBook = $modelbook[0]['Name'];
    $model = $modelbook[0]['Model'];
    $modelBin = $modelbook[0]['ModelBin'];
    $cameraState = [
        'alpha' => $modelbook[0]['Alpha'],
        'beta' => $modelbook[0]['Beta'],
        'radius' => $modelbook[0]['Radius'],
        'target' => [
            'x' => $modelbook[0]['Target_x'],
            'y' => $modelbook[0]['Target_y'],
            'z' => $modelbook[0]['Target_z']
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
if ($modelbook[0]['Model'] != null) {
    $gltfFilePath = 'assets/model/' . $modelName . $bookId .'/' . $model;
    $binFilePath = 'assets/model/' . $modelName . $bookId .'/' . $modelBin;

    // Đọc nội dung của tệp gltf
    $gltfContent = file_get_contents($gltfFilePath);

    // Thay thế đường dẫn "uri":"$modelBin" bằng "uri":"Model/$modelBin"
    if (strpos($gltfContent, 'assets/model/') === false) {
        // Thay thế đường dẫn "uri":"$modelBin" bằng "uri":"assets/model/' . $modelName . '/$modelBin"
        $modifiedGltfContent = preg_replace('/"uri"\s*:\s*"(?!assets\/model\/)([^"]+)"/', '"uri":"assets/model/' . $modelName . $bookId .'/$1"', $gltfContent);

        // Ghi lại nội dung đã sửa đổi vào tệp gltf gốc
        file_put_contents($gltfFilePath, $modifiedGltfContent);
    }
}

?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <input id="ModelId" type="hidden" name="Model" value="<?php echo $modelbook[0]['IdModel'] ?>">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Sản Phẩm /</span> Edit Model Sản Phẩm
        </h4>
        <div class="card">
            <?php
            if ($modelbook[0]['Model'] != null) {
            ?>
                <input id="Model" type="hidden" name="model" value="<?php echo $gltfFilePath ?>">
                <input id="Model_bin" type="hidden" name="modelbin" value="<?php echo $binFilePath ?>">
            
            <h4 class="py-3 mb-4" style="color: #656cf9;">
                <span class="text-muted fw-light">  -  Tên Sản Phẩm /</span>  <?php echo $modelbook[0]['Name'] ?>
            </h4>
            <div class="model3D d-flex justify-content-center" >
                <canvas id="3D-Book" class="3DImage" height="400" width="400"></canvas>
            </div>
            <button id="Edit_model" class="btn btn-primary" style="margin: 1rem auto;">
                <a href="index.php?folder=admin&template=model/edit_model_product&id=<?php echo $bookId ?>" style="color: #fff;">
                    Sửa góc nhìn
                </a>
            </button>
            <?php
            }
            else{
            ?>
            <button id="add_model" class="btn btn-primary" style="margin: 1rem auto;">
                <a href="index.php?folder=admin&template=model/add_model_product&id=<?php echo $bookId ?>" style="color: #fff;">
                    Thêm model
                </a>
            </button>
            <button id="Edit_model" class="btn btn-primary" style="margin: 1rem auto;">
                <a href="index.php?folder=admin&template=model/add_modelIMG_product&id=<?php echo $bookId ?>" style="color: #fff;">
                    Thêm model IMG
                </a>
            </button>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<script src="assets/babylon/babylon.js"></script>
<script src="assets/babylon/babylonjs.loaders.min.js"></script>
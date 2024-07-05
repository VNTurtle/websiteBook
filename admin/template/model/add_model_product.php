<?php
// Fetch the book details

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
}

$query = "SELECT `Id`, `Name` FROM `book` WHERE Id =  $bookId;";
$parameters = [];
$resultType = 2;
$Book = DP::run_query($query, $parameters, $resultType);

if (is_array($Book) && count($Book) > 0) {
    $IdBook = $Book[0]['Id'];
    $NameBook = $Book[0]['Name'];
} else {
    echo "Không tìm thấy kết quả.";
    $IdBook = null;
    $NameBook = null;
}

?>

<link rel="stylesheet" href="admin/css/add_model_product.css">
<div class="container">
    <h1>Upload File</h1>
    <form id="uploadForm" method="POST" enctype="multipart/form-data">
        <input id="Id-product" name="Id" type="hidden" value="<?php echo $bookId ?>">
        <div class="input-group">
            <label for="gltfFile">File GLTF:</label>
            <input type="file" id="gltfFile" name="gltfFile" accept=".gltf">
        </div>
        <div class="input-group">
            <label for="binFile">File BIN:</label>
            <input type="file" id="binFile" name="binFile" accept=".bin">
        </div>
        <div class="input-group">
            <label for="imageFiles">Hình ảnh:</label>
            <input type="file" id="imageFiles" name="imageFiles[]" multiple accept="image/*">
        </div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
        <button type="submit" class="button" name="btn-upload">Upload</button>
    </form>
    <div class="message"></div>
    <button id="CheckModel" class="btn btn-primary hidden">
        <a href="index.php?admin/template=model/model_detail_product&id=<?php echo $bookId ?>">Xem Model 3D</a>
    </button>
</div>
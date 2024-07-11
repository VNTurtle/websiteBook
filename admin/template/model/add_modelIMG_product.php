<?php
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


<link rel="stylesheet" href="admin/css/add_modelIMG_product.css">
    <div class="container">
        <h1>Upload File</h1>
        <form id="uploadForm"  method="POST" enctype="multipart/form-data">
            <input id="Id-product" name="Id" type="hidden" value="<?php echo $bookId ?>">
            <div class="input-group">
                <label for="gltfFile">Chọn Size Book:</label>
                <select id="gltfFile" name="gltfFile">
                    <option value="13x18cm">13 x 18 cm</option>
                    <option value="file3.gltf">13 x 19 cm</option>
                    <option value="file1.gltf">11 x 17 cm</option>                                  
                </select>
            </div>
            <div class="input-group">
                <label for="imageFile1">Hình ảnh bìa:</label>
                <input type="file" id="imageFile1" name="imageFile1" accept="image/*">
            </div>
            <div class="input-group">
                <label for="imageFile2">Hình mặt sau:</label>
                <input type="file" id="imageFile2" name="imageFile2" accept="image/*">
            </div>
            <div class="input-group">
                <label for="imageFile3">Hình bên cạnh:</label>
                <input type="file" id="imageFile3" name="imageFile3" accept="image/*">
            </div>
            <div class="progress">
                <div class="progress-bar"></div>
            </div>
            <button type="submit" class="button" name="btn-upload">Upload</button>
        </form>
        <div class="message"></div>
        <button id="CheckModel" class="btn btn-primary hidden">
            <a href="index.php?folder=admin&template=model/model_detail_product&id=<?php echo $bookId ?>">Xem Model 3D</a>
        </button>
    </div>

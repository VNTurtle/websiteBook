<?php
require_once('../../API/db.php');

function generateRandomString($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Hàm xử lý tên file trùng lặp
function getUniqueFilename($uploadDir, $filename) {
    $fileExt = pathinfo($filename, PATHINFO_EXTENSION);
    $fileName = pathinfo($filename, PATHINFO_FILENAME);
    $newFilename = $filename;
    $counter = 1;

    while (file_exists($uploadDir . $newFilename)) {
        $newFilename = $fileName . '_' . $counter . '.' . $fileExt;
        $counter++;
    }

    return $newFilename;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị của trường username từ form
    $queryIdBook="SELECT MAX(id) AS max_id FROM book;";
    $parameters=[];
    $resultType=2;
    $BookId=DP::run_query($queryIdBook,$parameters,$resultType);
    $Id=$BookId[0]['max_id']+1;
    $Name= $_POST['Name'];
    $ComboId = $_POST['Combo'];
    if ($ComboId === '0') {
        $ComboId = null;
    }
    // Gọi hàm để tạo ra 12 ký tự ngẫu nhiên
    $SKU = generateRandomString();
    
    $Author = $_POST['Author'];   
    $TypeId = $_POST['TypeId'];
    $NumberPage = $_POST['NumberPage'];
    $SizeId = $_POST['Size'];
    $Stock = $_POST['Stock'];
    $Price = $_POST['Price'];
    $Date = $_POST['Date'];
    $PublisherId = $_POST['Publisher'];
    $CoverTypeId = $_POST['Covertype'];
    $Description = $_POST['Description'];

    $query="INSERT INTO `book`
    (`Id`, `ComboBookId`, `SKU`, `Name`, `Author`, `Description`, `TypeId`, `NumberPage`, `SizeId`, `Stock`, `Price`, `Date`, `PublisherId`, `CoverTypeId`, `Status`) 
    VALUES (?,?,'$SKU','$Name','$Author','$Description',?,?,?,?,?,'$Date',?,?,?)";
    $parameters=[
        $Id,
        $ComboId,  
        $TypeId,
        $NumberPage,
        $SizeId,
        $Stock,
        $Price,
        $PublisherId,
        $CoverTypeId,
        true
    ];
    $resultType=2;
    DP::run_query($query,$parameters,$resultType);

    // Đường dẫn thư mục lưu trữ hình ảnh
    $uploadDir = '../../assets/img/products/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    

    // Xử lý upload ảnh bìa
    $coverImageName = $_FILES['coverImage']['name'];
    $coverImageTmpName = $_FILES['coverImage']['tmp_name'];
    $coverImageName = getUniqueFilename($uploadDir, $coverImageName);
    $coverImagePath = $uploadDir . basename($coverImageName);
    $IS_Img = "INSERT INTO `image`(`Id`, `BookId`, `Path`, `TypeImgId`, `Status`) 
            VALUES (null,$Id,'$coverImageName',1,true)";
    $parameters = [];  
    $resultType=1;
    $check2=DP::run_query($IS_Img,$parameters,$resultType);
    move_uploaded_file($coverImageTmpName, $coverImagePath);

    // Xử lý upload các hình phụ
    $additionalImages = $_FILES['additionalImages'];
    $totalImages = count($additionalImages['name']);

    for ($i = 0; $i < $totalImages; $i++) {
        $imageTmpName = $additionalImages['tmp_name'][$i];
        $imageName = $additionalImages['name'][$i];
        $imageName = getUniqueFilename($uploadDir, $imageName);
        $imagePath = $uploadDir . basename($imageName);
        $IS_Img = "INSERT INTO `image`(`Id`, `BookId`, `Path`, `TypeImgId`, `Status`) 
            VALUES (null,$Id,'$imageName',1,true)";
        $parameters = [];
        $resultType = 1;
        $check2 = DP::run_query($IS_Img, $parameters, $resultType);
        move_uploaded_file($imageTmpName, $imagePath);
    }



    echo json_encode($Id);

} else {
    // Đoạn mã này sẽ được thực hiện nếu không phải là phương thức POST
    echo "Yêu cầu không hợp lệ!";
}

?>
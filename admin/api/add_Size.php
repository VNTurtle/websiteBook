<?php
require_once('../../API/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị của trường username từ form
    $SizeName = $_POST['Size'];
    $query="INSERT INTO `Size`(`Id`, `Name`, `Status`) VALUES (null,?,true)";
    $parameters = [ $SizeName];   
    $resultType = 1;
    DP::run_query($query,$parameters,$resultType);

    $query_Size = "SELECT * FROM `Size` ";
    $parameters=[];
    $resultType=2;
    $Size = DP::run_query($query_Size, $parameters, $resultType);

    // Trả về danh sách combo dưới dạng JSON để xử lý trong JavaScript (nếu cần)
    echo json_encode($Size);
} else {
    // Đoạn mã này sẽ được thực hiện nếu không phải là phương thức POST
    echo "Yêu cầu không hợp lệ!";
}
?>
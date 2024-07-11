<?php
require_once('../../API/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị của trường username từ form
    $CovertypeName = $_POST['Covertype'];
    $query="INSERT INTO `Covertype`(`Id`, `Name`, `Status`) VALUES (null,?,true)";
    $parameters = [ $CovertypeName];   
    $resultType = 1;
    DP::run_query($query,$parameters,$resultType);

    $query_CovertypeName = "SELECT * FROM `Covertype` ";
    $parameters=[];
    $resultType=2;
    $Covertype = DP::run_query($query_CovertypeName, $parameters, $resultType);

    // Trả về danh sách combo dưới dạng JSON để xử lý trong JavaScript (nếu cần)
    echo json_encode($Covertype);
} else {
    // Đoạn mã này sẽ được thực hiện nếu không phải là phương thức POST
    echo "Yêu cầu không hợp lệ!";
}
?>
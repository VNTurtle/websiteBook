<?php
require_once('../../API/db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị của trường username từ form
    $comboName = $_POST['Combo'];
    $query="INSERT INTO `combobook`(`Id`, `Name`, `Status`) VALUES (null,?,true)";
    $parameters = [ $comboName];   
    $resultType = 1;
    DP::run_query($query,$parameters,$resultType);

    $query_Combo = "SELECT * FROM `combobook` ";
    $parameters=[];
    $resultType=2;
    $Combo = DP::run_query($query_Combo, $parameters, $resultType);

    // Trả về danh sách combo dưới dạng JSON để xử lý trong JavaScript (nếu cần)
    echo json_encode($Combo);
} else {
    // Đoạn mã này sẽ được thực hiện nếu không phải là phương thức POST
    echo "Yêu cầu không hợp lệ!";
}
?>
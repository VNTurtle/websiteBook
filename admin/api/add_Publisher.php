<?php
require_once('../../API/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị của trường username từ form
    $PublisherName = $_POST['Publisher'];
    $query="INSERT INTO `Publisher`(`Id`, `Name`, `Status`) VALUES (null,?,true)";
    $parameters = [ $PublisherName];   
    $resultType = 1;
    DP::run_query($query,$parameters,$resultType);

    $query_Publisher = "SELECT * FROM `Publisher` ";
    $parameters=[];
    $resultType=2;
    $Publisher = DP::run_query($query_Publisher, $parameters, $resultType);

    // Trả về danh sách combo dưới dạng JSON để xử lý trong JavaScript (nếu cần)
    echo json_encode($Publisher);
} else {
    // Đoạn mã này sẽ được thực hiện nếu không phải là phương thức POST
    echo "Yêu cầu không hợp lệ!";
}
?>
<?php
require_once('../../API/db.php'); // Kết nối CSDL và định nghĩa lớp DP::run_query

// Lấy dữ liệu từ frontend (giả sử dữ liệu được gửi dưới dạng JSON)
$data = json_decode(file_get_contents('php://input'), true);

$ModelId = $data['Id'];

if (!$ModelId) {
    // Xử lý khi không có id được gửi từ frontend
    echo "Missing ModelId";
    exit;
}
// Thiết lập câu truy vấn UPDATE
$query_updateModel = "UPDATE model
                      SET alpha=?, beta=?, radius=?, target_x=?, target_y=?, target_z=?
                      WHERE id=$ModelId";

// Thiết lập tham số cho câu truy vấn
$parameters = [
    $data['alpha'],
    $data['beta'],
    $data['radius'],
    $data['target']['x'],
    $data['target']['y'],
    $data['target']['z']
];

// Loại kết quả mong muốn (2: Fetch All)
$resultType = 2;

// Thực thi câu truy vấn
$result = DP::run_query($query_updateModel, $parameters, $resultType);

// Kiểm tra và xử lý kết quả nếu cần
if ($result) {
    // Xử lý khi câu truy vấn thành công
    echo "Update successful";
} else {
    // Xử lý khi câu truy vấn thất bại
    echo "Update failed";
}
?>

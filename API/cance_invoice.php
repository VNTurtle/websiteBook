<?php
require_once('db.php');
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy trạng thái đơn hàng mới và ID đơn hàng từ yêu cầu AJAX
    $orderStatusId = $_POST['order_status'];
    $orderId = $_POST['order_id'];

    // Câu truy vấn cập nhật
    $query = "UPDATE invoicedetail SET OrderStatusId = ? WHERE Id = ?";
    $parameters = [$orderStatusId, $orderId];
    $resultType = 1;
    $check= DP::run_query($query, $parameters, $resultType);

    // Thực hiện câu truy vấn
    if ($check) {
        $response['status'] = 'success';
        $response['message'] = 'Đã thay đổi trạng thái thành công.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Đã xảy ra lỗi khi thay đổi trạng thái.';
    }
}
echo json_encode($response);
?>

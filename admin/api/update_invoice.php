<?php
require_once('../../API/db.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected order status and order ID from the AJAX request
    $orderStatusId = $_POST['order_status'];
    $orderId = $_POST['order_id'];


    // Update query
    $query = "UPDATE invoicedetail SET OrderStatusId = ? WHERE Id = ?";
    $parameters=[$orderStatusId,$orderId];
    $resultType=1;
    $check= DP::run_query($query,$parameters,$resultType);
    if ($check) {
        $response['status'] = 'success';
        $response['message'] = 'Đã thay đổi thành công';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'đã thất bại ';
    }

}
echo json_encode($response);
?>

<?php
require_once('../../API/db.php');
$response = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $orderStatusId = $_POST['order_status'];
    $orderId = $_POST['order_id'];


    $query = "UPDATE invoice SET is_read = 1 WHERE Code = ?";
    $parameters=[$orderId];
    $resultType=1;
    $UD_invoice= DP::run_query($query,$parameters,$resultType);

    $SQL_ivd="SELECT ivd.Id AS ivd_id, iv.IssuedDate, iv.Code, iv.Total
        FROM invoicedetail ivd
        JOIN invoice iv ON ivd.Parent_code = iv.code
        WHERE iv.Code='$orderId'";
    $SL_ivd= DP::run_query($SQL_ivd,[],2);
    foreach ($SL_ivd as $key => $value) {
        $SQL_UD_ivd = "UPDATE invoicedetail SET OrderStatusId = ? WHERE Id = ?";
        $parameters=[$orderStatusId,$value['ivd_id']];
        $resultType=1;
        $check= DP::run_query($SQL_UD_ivd,$parameters,$resultType);
    }
    
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

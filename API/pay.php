<?php
header('Content-Type: application/json');
require_once('db.php');
session_start();
if (isset($_POST['number1']) && isset($_POST['number2']) && isset($_POST['number3']) && isset($_POST['number4'])) {
$invoice = json_decode($_POST['invoice'], true);
$invoiceDetails = json_decode($_POST['invoiceDetails'], true);
$number1=$_POST['number1'];
$number2=$_POST['number2'];
$number3=$_POST['number3'];
$number4=$_POST['number4'];
$enteredOTP = $number1 . $number2 . $number3 . $number4;

$otpFromSession = $_SESSION["OTP"];
    if ($enteredOTP == $otpFromSession) {

        unset($_SESSION["OTP"]);
        $queryInvoice = "INSERT INTO `invoice` (`Code`, `Username`, `IssuedDate`, `ShippingAddress`, `ShippingPhone`, `ShippingEmail`, `UserId`, `Total`, `PaymethodId`, `Quantity`, `Status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $parameters = [$invoice['code'], $invoice['username'], $invoice['date'], $invoice['address'], $invoice['phone'], $invoice['email'], $invoice['userId'], $invoice['total'], $invoice['paymethodId'], $invoice['quantity'], $invoice['status']];
        $ISInvoice = DP::run_query($queryInvoice, $parameters, 1);
    
        
        if ($ISInvoice > 0) {
        $queryInvoiceDetail = "INSERT INTO `invoicedetail` (`Parent_code`, `BookId`, `UserId`, `UnitPrice`, `Quantity`, `OrderStatusId`, `Status`) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        foreach ($invoiceDetails as $invoiceDetail) {
            $parameters = [$invoiceDetail['parent_code'], $invoiceDetail['bookId'], $invoiceDetail['userId'], $invoiceDetail['price'], $invoiceDetail['quantity'], $invoiceDetail['orderStatusId'], $invoiceDetail['status']];
            $ISInvoiceDetail = DP::run_query($queryInvoiceDetail, $parameters, 1);
    
            if ($ISInvoiceDetail <= 0) {
                echo json_encode(["status" => "error", "message" => "Failed to insert invoice detail."]);
                exit;
            } else {
                $queryDeleteCart = "DELETE c FROM `cart` AS c WHERE c.`UserId` = ? AND c.`BookId` = ?";
                $parameters = [$invoiceDetail['userId'], $invoiceDetail['bookId']];
                DP::run_query($queryDeleteCart, $parameters, 1);
            }
        }
        }
        $response['status'] = 'success';
        
    }
    else {
        // Xác minh thất bại
        $response['status'] = 'error';
        $response['message'] = 'Invalid OTP. Please try again.';
    }
}else {
    // Nếu thiếu dữ liệu nhập từ form, trả về thông báo lỗi
    $response['status'] = 'error';
    $response['message'] = 'Incomplete data received.';
}

echo json_encode($response);
?>

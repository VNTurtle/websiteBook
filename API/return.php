<?php
require_once('db.php');
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
date_default_timezone_set('Asia/Ho_Chi_Minh');

$vnp_HashSecret = "7WGDGPIT62YT0NHSKJCP1OP3S775IQQB"; // Chuỗi bí mật

// Get all the VNPAY returned data
$vnp_SecureHash = $_GET['vnp_SecureHash'];
$inputData = array();
foreach ($_GET as $key => $value) {
    if (substr($key, 0, 4) == "vnp_") {
        $inputData[$key] = $value;
    }
}
unset($inputData['vnp_SecureHash']);
ksort($inputData);
$hashdata = "";
$i = 0;
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
}

$secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

// Verify the secure hash and check the payment response code
if ($secureHash == $vnp_SecureHash && $_GET['vnp_ResponseCode'] == '00') {
    // Payment is successful
    // Retrieve and decode invoice and invoiceDetails from the session or a temporary storage
    session_start();
    $invoice = $_SESSION['invoice'];
    $invoiceDetails = $_SESSION['invoiceDetails'];

    $queryInvoice = "INSERT INTO `invoice` (`Code`, `Username`, `IssuedDate`, `ShippingAddress`, `ShippingPhone`, `ShippingEmail`, `UserId`, `Total`, `PaymethodId`, `Quantity`, `Status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $parameters = [$invoice['code'], $invoice['username'], $invoice['date'], $invoice['address'], $invoice['phone'], $invoice['email'], $invoice['userId'], $invoice['total'], $invoice['paymethodId'], $invoice['quantity'], $invoice['status']];
    $ISInvoice = DP::run_query($queryInvoice, $parameters, 1);

    
    if ($ISInvoice > 0) {
    $queryInvoiceDetail = "INSERT INTO `invoicedetail` (`Parent_code`, `BookId`, `UserId`, `UnitPrice`, `Quantity`, `OrderStatusId`) VALUES (?, ?, ?, ?, ?, ?)";
    
    foreach ($invoiceDetails as $invoiceDetail) {
        $parameters = [$invoiceDetail['parent_code'], $invoiceDetail['bookId'], $invoiceDetail['userId'], $invoiceDetail['price'], $invoiceDetail['quantity'], $invoiceDetail['orderStatusId']];
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

    // Clear session data after inserting the invoice
    unset($_SESSION['invoice']);
    unset($_SESSION['invoiceDetails']);

    header("Location: ../index.php");
} else {
    echo "Payment failed or secure hash mismatch.";
}
?>

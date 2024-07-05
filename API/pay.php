<?php
header('Content-Type: application/json');
require_once('db.php');
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON input: " . json_last_error_msg()]);
    exit;
}

$invoice = $data['invoice'];
$invoiceDetails = $data['invoiceDetails']; // This should be an array of invoice details

// Insert invoice
$queryInvoice = "INSERT INTO `invoice` (`Code`, `Username`, `IssuedDate`, `ShippingAddress`, `ShippingPhone`, `ShippingEmail`, `UserId`, `Total`, `PaymethodId`, `Quantity`, `Status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$parameters = [$invoice['code'], $invoice['username'], $invoice['date'], $invoice['address'], $invoice['phone'], $invoice['email'], $invoice['userId'], $invoice['total'], $invoice['paymethodId'], $invoice['quantity'], $invoice['status']];
$ISInvoice = DP::run_query($queryInvoice, $parameters, 1); // 1: Không cần lấy kết quả trả về, chỉ cần số hàng bị ảnh hưởng

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

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to insert invoice."]);
}
?>

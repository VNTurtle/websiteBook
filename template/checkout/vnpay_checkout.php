<?php
    if (isset($_GET['selectedProducts'])) {
        $selectedProductsJSON = $_GET['selectedProducts'];
    $selectedProducts = json_decode($selectedProductsJSON, true); // Giải mã chuỗi JSON thành mảng PHP

    // Lặp qua mảng selectedProducts để lấy ra invoice và invoicedetail
    $invoice = null;
    $invoicedetail = [];

    foreach ($selectedProducts as $product) {
        if (isset($product['code'])) {
            // Đây là invoice
            $invoice = $product;
        } else {
            // Đây là invoicedetail
            $invoicedetail[] = $product;
        }
    }

    } else {
       
    }
    $total=0;
    foreach ($invoicedetail as $key => $value) {
        $total+=$value['price'];
    }
    
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Thanh Toán VNPAY</title>
    <link rel="stylesheet" href="assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="my-4">Form Thanh Toán VNPAY</h2>
        <form action="API/vnpay_create_payment.php" method="POST">
        <input type="hidden" name="invoice" value="<?php echo htmlspecialchars(json_encode($invoice)); ?>">
        <input type="hidden" name="invoiceDetails" value="<?php echo htmlspecialchars(json_encode($invoicedetail)); ?>">
            <div class="mb-3">
                <label for="language">Loại hàng hóa </label>
                <select name="order_type" id="vnp_OrderType" class="form-control">
                    <option value="topup">Nạp tiền điện thoại</option>
                    <option value="billpayment">Thanh toán hóa đơn</option>
                    <option value="fashion">Thời trang</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="vnp_Amount" class="form-label">Số tiền thanh toán (x100)</label>
                <input type="number" class="form-control" id="vnp_Amount" name="amount" value="<?= $total ?>000" required>
            </div>
            <div class="mb-3">
                <label for="bankcode">Ngân hàng</label>
                <select name="bank_code" id="bankcode" class="form-control">
                    <option value="">Không chọn </option>
                    <option value="QRONLY">Thanh toan QRONLY</option>
                    <option value="MBAPP">Ung dung MobileBanking</option>
                    <option value="VNPAYQR">VNPAYQR</option>
                    <option value="VNBANK">LOCAL BANK</option>
                    <option value="IB">INTERNET BANKING</option>
                    <option value="ATM">ATM CARD</option>
                    <option value="INTCARD">INTERNATIONAL CARD</option>
                    <option value="VISA">VISA</option>
                    <option value="MASTERCARD"> MASTERCARD</option>
                    <option value="JCB">JCB</option>
                    <option value="UPI">UPI</option>
                    <option value="VIB">VIB</option>
                    <option value="VIETCAPITALBANK">VIETCAPITALBANK</option>
                    <option value="SCB">Ngan hang SCB</option>
                    <option value="NCB">Ngan hang NCB</option>
                    <option value="SACOMBANK">Ngan hang SacomBank </option>
                    <option value="EXIMBANK">Ngan hang EximBank </option>
                    <option value="MSBANK">Ngan hang MSBANK </option>
                    <option value="NAMABANK">Ngan hang NamABank </option>
                    <option value="VNMART"> Vi dien tu VnMart</option>
                    <option value="VIETINBANK">Ngan hang Vietinbank </option>
                    <option value="VIETCOMBANK">Ngan hang VCB </option>
                    <option value="HDBANK">Ngan hang HDBank</option>
                    <option value="DONGABANK">Ngan hang Dong A</option>
                    <option value="TPBANK">Ngân hàng TPBank </option>
                    <option value="OJB">Ngân hàng OceanBank</option>
                    <option value="BIDV">Ngân hàng BIDV </option>
                    <option value="TECHCOMBANK">Ngân hàng Techcombank </option>
                    <option value="VPBANK">Ngan hang VPBank </option>
                    <option value="AGRIBANK">Ngan hang Agribank </option>
                    <option value="MBBANK">Ngan hang MBBank </option>
                    <option value="ACB">Ngan hang ACB </option>
                    <option value="OCB">Ngan hang OCB </option>
                    <option value="IVB">Ngan hang IVB </option>
                    <option value="SHB">Ngan hang SHB </option>
                    <option value="APPLEPAY">Apple Pay </option>
                    <option value="GOOGLEPAY">Google Pay </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="vnp_IpAddr" class="form-label">Địa chỉ khách hàng</label>
                <input type="text" class="form-control" id="vnp_IpAddr" name="REMOTE_ADDR" value="<?= $invoice['address'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="vnp_Locale" class="form-label">Ngôn ngữ</label>
                <select class="form-select" id="vnp_Locale" name="language" required>
                    <option value="vn">Tiếng Việt</option>
                    <option value="en">Tiếng Anh</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="vnp_OrderInfo" class="form-label">Thông tin đơn hàng</label>
                <input type="text" class="form-control" id="vnp_OrderInfo" name="order_desc" value="Thanh toan hoa don" required>
            </div>
            <div class="mb-3">
                <label for="vnp_TxnRef" class="form-label">Mã tham chiếu giao dịch</label>
                <input type="text" class="form-control" id="vnp_TxnRef" name="order_id" value="<?= $invoice['code'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Gửi yêu cầu thanh toán</button>
        </form>
    </div>
    <script src="assets/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>

</html>
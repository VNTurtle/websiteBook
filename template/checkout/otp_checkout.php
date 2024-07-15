<?php
    session_start();
    $_SESSION["OTP"];
    $mess="";
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
    var_dump($invoice);
    } else {
       
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/otp_checkout.css">
</head>

<body>
    <div id="opacity"></div>
    <form class="form" id="otpForm"  method="POST">
        <div class="title">OTP</div>
        <div class="title">Verification Code</div>
        <p class="message">We have sent a verification code to your mobile number</p>
        <div class="inputs">
            <input type="hidden" name="invoice" value="<?php echo htmlspecialchars(json_encode($invoice)); ?>">
            <input type="hidden" name="invoiceDetails" value="<?php echo htmlspecialchars(json_encode($invoicedetail)); ?>">
            <input id="input1" type="text" name="number1" maxlength="1" required> 
            <input id="input2" type="text" name="number2" maxlength="1" required>
            <input id="input3" type="text" name="number3" maxlength="1" required>
            <input id="input4" type="text" name="number4" maxlength="1" required>            
        </div> 
        <div id="messenger" class="hidden">Nhập sai OTP</div>
        <button class="action" type="submit" name="verify">Xác thực</button>
    </form>
    <div id="pay-loading" class="title-pay hidden">
            <div class="dot-spinner ">

                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
                <div class="dot-spinner__dot"></div>
            </div>
            <div class="title-loading">
                <h4>Đang xử lý</h4>
            </div>
        </div>
    <script>
    $(document).ready(function() {
        // Intercept form submission
        $('#otpForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            var payloading = document.getElementById('pay-loading');
            var opacity = document.getElementById('opacity');
            opacity.classList.add('hidden');
            payloading.classList.remove('hidden');
            var mess=document.getElementById('messenger');
            // Collect form data
            var formData = $(this).serialize();

            // Send Ajax request
            $.ajax({
                type: 'POST',
                url: 'API/pay.php', // Đường dẫn đến file xử lý PHP
                data: formData,
                dataType: 'json',
                success: function(response) {
                    // Xử lý phản hồi từ server
                    
                    if (response.status === 'success') {
                        window.location.href = 'index.php?';
                    } else {
                        mess.classList.remove('hidden');
                        opacity.classList.remove('hidden');
                        payloading.classList.add('hidden');
                    }
                },
                error: function(xhr, status, error) {
                    mess.classList.remove('hidden');
                }
            });
        });
    });
    </script>
</body>

</html>
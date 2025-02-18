<?php
require_once('API/db.php');
require_once('template/layout/layout.php');
$userId = $_SESSION['Id'];
$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)
$queryPaymethod = "SELECT * FROM `paymethod` WHERE 1";
$Paymethod = DP::run_query($queryPaymethod, $parameters, $resultType);

if (isset($_GET['selectedProducts'])) {
    $selectedProducts = json_decode($_GET['selectedProducts']);

    if (is_array($selectedProducts)) {
        // Xử lý danh sách sản phẩm đã chọn
        foreach ($selectedProducts as $product) {
            $productId = $product->id;
            $productPrice = $product->price;
            $productPrice2 = $product->price2;
            $productName = $product->name;
            $productImg = $product->img;
            $productQuantity = $product->quantity;
            // Thực hiện các xử lý khác với sản phẩm đã chọn
        }
    } else {
        // Xử lý khi giá trị 'selectedProducts' không đúng định dạng
        echo "Giá trị 'selectedProducts' không đúng định dạng.";
    }
} else {
    // Xử lý khi giá trị 'selectedProducts' không tồn tại
    echo "Giá trị 'selectedProducts' không tồn tại.";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckOut</title>
    <link rel="icon" href="assets/img/logo-web.jpg">
    <link rel="stylesheet" href="assets/css/checkout.css">
    <link rel="stylesheet" href="assets/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/sclick/css/slick.min.css">
</head>

<body>
    <div id="opacity"></div>
    <div class="bodywrap">


        <div class="container">

            <div class="row">
                <div class="col-xl-7">

                    <div class="card">
                        <div class="card-body">
                            <ol class="activity-checkout mb-0 px-4 mt-3">
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-receipt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Địa chỉ giao hàng</h5>
                                            <p class="text-muted text-truncate mb-4">Sed ut perspiciatis unde omnis iste</p>
                                            <div class="mb-3">
                                                <form id="check_out" method="POST">
                                                    <div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="billing-name">Họ tên người nhận</label>
                                                                    <input type="text" class="form-control" id="billing-name" placeholder="Enter name">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="billing-email-address">Email Address</label>
                                                                    <input type="email" class="form-control" name="email" id="billing-email-address" placeholder="Enter email">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="mb-3">
                                                                    <label class="form-label" for="billing-phone">Phone</label>
                                                                    <input type="text" class="form-control" id="billing-phone" placeholder="Enter Phone no.">
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="mb-4 mb-lg-0">
                                                                    <label class="form-label" for="province-select">Tỉnh / Thành phố</label>
                                                                    <select id="province-select" class="form-control form-select" title="Province">
                                                                        <option value="0">Select Province</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="mb-4 mb-lg-0">
                                                                    <label class="form-label" for="district-select">Quận / Huyện</label>
                                                                    <select id="district-select" class="form-control form-select" title="District" disabled>
                                                                        <option value="0">Select District</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <div class="mb-0">
                                                                    <label class="form-label" for="ward-select">Phường / Xã</label>
                                                                    <select id="ward-select" class="form-control form-select" title="Ward" disabled>
                                                                        <option value="0">Select Ward</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="billing-address">Địa chỉ nhận hàng</label>
                                                            <textarea class="form-control" id="billing-address" rows="3" placeholder="Enter full address"></textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="checkout-item">
                                    <div class="avatar checkout-icon p-1">
                                        <div class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bxs-wallet-alt text-white font-size-20"></i>
                                        </div>
                                    </div>
                                    <div class="feed-item-list">
                                        <div>
                                            <h5 class="font-size-16 mb-1">Payment Info</h5>
                                            <p class="text-muted text-truncate mb-4">Duis arcu tortor, suscipit eget</p>
                                        </div>
                                        <div>
                                            <h5 class="font-size-14 mb-3">Payment method :</h5>
                                            <div class="row">
                                                <div class="col-lg-3 col-sm-6">
                                                    <div data-bs-toggle="collapse">
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="pay-method" id="1" class="card-radio-input">
                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <img style="height: 40px;" src="assets/img/payment_1.webp" alt="">
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div data-bs-toggle="collapse">
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="pay-method" id="2" class="card-radio-input">
                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <img style="height: 40px;" src="assets/img/vnpay-logo.jpg" alt="">
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-6">
                                                    <div data-bs-toggle="collapse">
                                                        <label class="card-radio-label">
                                                            <input type="radio" name="pay-method" id="3" class="card-radio-input">
                                                            <span class="card-radio py-3 text-center text-truncate">
                                                                <img style="height: 40px;" src="assets/img/momo.webp" alt="">
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col">
                            <a href="cart.php" class="btn btn-link text-muted">
                                &nbsp;
                                <i class="fa-solid fa-angle-left"></i>
                                &nbsp; Continue Cart
                            </a>
                        </div> <!-- end col -->
                        <div class="col">
                            <div class="text-end mt-2 mt-sm-0">
                                <button id="btn-checkout" class="btn btn-success btn-checkout" disabled>
                                    <i class="fa-solid fa-cart-shopping"></i> Thanh toán
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-5">
                    <div class="card checkout-order-summary">
                        <div class="card-body">
                            <div class="p-3 bg-light mb-3">
                                <h5 class="font-size-16 mb-0">Order Summary <span class="float-end ms-2">#MN0124</span></h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-centered mb-0 table-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0" style="width: 110px;" scope="col">Product</th>
                                            <th class="border-top-0" style="width: 270px;" scope="col">Product Desc</th>
                                            <th class="border-top-0" scope="col">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        $count = 0;
                                        foreach ($selectedProducts as $key => $product) {
                                            $total += $product->price2;
                                            $count += 1;
                                        ?>
                                            <tr>
                                                <th scope="row"><img src="assets/img/products/<?php echo $product->img ?>" alt="product-img" title="product-img" class="avatar-lg rounded"></th>
                                                <td>
                                                    <h5 class="font-size-16 text-truncate2">
                                                        <a href="#" class="text-dark"><?php echo $product->name ?></a>
                                                    </h5>
                                                    <p class="text-muted mb-0">
                                                        <i class="bx bxs-star text-warning"></i>
                                                        <i class="bx bxs-star text-warning"></i>
                                                        <i class="bx bxs-star text-warning"></i>
                                                        <i class="bx bxs-star text-warning"></i>
                                                        <i class="bx bxs-star-half text-warning"></i>
                                                    </p>
                                                    <p class="text-muted mb-0 mt-1"><?php echo $product->price ?>0 đ x <?php echo $product->quantity ?></p>
                                                </td>
                                                <td><?php echo $product->price2 ?>.000 đ</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr class="bg-light">
                                            <td colspan="2">
                                                <h5 class="font-size-14 m-0">Total:</h5>
                                            </td>
                                            <td id="total">
                                                <?php echo $total;  ?>.000 đ
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>
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

    </div>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="assets/fontawesome/js/all.min.js"></script>
    <script>
        var provinceSelect = document.getElementById('province-select');
        var districtSelect = document.getElementById('district-select');
        var wardSelect = document.getElementById('ward-select');

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'API/data.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var responseData = JSON.parse(xhr.responseText);
                var provinceData = responseData.province;
                var districtData = responseData.district;
                var wardsData = responseData.wards;

                console.log(provinceData);
                console.log(districtData);
                console.log(wardsData);

                provinceData.forEach(function(province) {
                    var option = document.createElement('option');
                    option.value = province.code;
                    option.textContent = province.name;
                    provinceSelect.appendChild(option);
                });

                provinceSelect.addEventListener('change', function() {
                    var selectedProvince = provinceSelect.value;

                    // Xóa tất cả các tùy chọn quận/huyện hiện có
                    districtSelect.innerHTML = '<option value="0">Select District</option>';

                    if (selectedProvince !== '0') {
                        // Tạo các tùy chọn quận/huyện mới dựa trên danh sách quận/huyện của tỉnh/thành phố được chọn
                        districtData.forEach(function(district) {
                            if (district.parent_code == selectedProvince) {
                                var option = document.createElement('option');
                                option.value = district.code;
                                option.textContent = district.name_with_type;
                                districtSelect.appendChild(option);
                            };

                        });
                        districtSelect.disabled = false;
                    } else {
                        districtSelect.disabled = true;
                        wardSelect.disabled = true;
                    }
                });
                districtSelect.addEventListener('change', function() {
                    var selectedDistrict = districtSelect.value;

                    // Xóa tất cả các tùy chọn phường/xã hiện có
                    wardSelect.innerHTML = '<option value="0">Select Ward</option>';

                    if (selectedDistrict !== '0') {
                        // Lấy danh sách phường/xã của quận/huyện được chọn
                        wardsData.forEach(function(wards) {
                            if (wards.parent_code == selectedDistrict) {
                                var option = document.createElement('option');
                                option.value = wards.code;
                                option.textContent = wards.name_with_type;
                                wardSelect.appendChild(option);
                            };

                        });
                        wardSelect.disabled = false;
                    } else {
                        wardSelect.disabled = true;
                    }
                });
            }
        };
        xhr.send();
        // Hàm lấy ngày hiện tại dưới định dạng "YYYY-MM-DD"
        function getCurrentDate() {
            var today = new Date();
            var year = today.getFullYear();
            var month = String(today.getMonth() + 1).padStart(2, '0');
            var day = String(today.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }
        // Hàm tạo mã hóa đơn ngẫu nhiên
        function generateInvoiceCode(length) {
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var code = '';
            for (var i = 0; i < length; i++) {
                var randomIndex = Math.floor(Math.random() * characters.length);
                code += characters.charAt(randomIndex);
            }
            return code;
        }
        // Lấy thông tin từ các trường nhập liệu
        var billingName = document.getElementById('billing-name').value;
        var billingEmail = document.getElementById('billing-email-address').value;
        var billingPhone = document.getElementById('billing-phone').value;

        var selectedProvince = provinceSelect.options[provinceSelect.selectedIndex].text;
        var selectedDistrict = districtSelect.options[districtSelect.selectedIndex].text;
        var selectedWard = wardSelect.options[wardSelect.selectedIndex].text;
        var billingAddress = document.getElementById('billing-address').value;
        var fullAddress = billingAddress + ", " + selectedWard + ", " + selectedDistrict + ", " + selectedProvince;

        // Lấy tất cả các input radio của phương thức thanh toán
        var paymentMethods = document.querySelectorAll('input[name="pay-method"]');

        // Lấy nút "Thanh toán"
        var checkoutButton = document.getElementById('btn-checkout');

        // Gán sự kiện thay đổi cho từng radio button
        paymentMethods.forEach(function(paymentMethod) {
            paymentMethod.addEventListener('change', function() {
                checkoutButton.disabled = false; // Kích hoạt nút "Thanh toán" khi chọn phương thức thanh toán
            });
        });

        const selectedProducts = [];
        checkoutButton.addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
            // Lấy thông tin từ các trường nhập liệu
            var billingName = document.getElementById('billing-name').value;
            var billingEmail = document.getElementById('billing-email-address').value;
            var billingPhone = document.getElementById('billing-phone').value;
            var selectedProvince = provinceSelect.options[provinceSelect.selectedIndex].text;
            var selectedDistrict = districtSelect.options[districtSelect.selectedIndex].text;
            var selectedWard = wardSelect.options[wardSelect.selectedIndex].text;
            var billingAddress = document.getElementById('billing-address').value;
            var fullAddress = billingAddress + ", " + selectedWard + ", " + selectedDistrict + ", " + selectedProvince;



            // Tạo đối tượng invoice
            const invoice = {
                code: generateInvoiceCode(20), // Tạo mã hóa đơn ngẫu nhiên
                username: billingName,
                date: getCurrentDate(),
                phone: billingPhone,
                email: billingEmail,
                address: fullAddress,
                userId: <?php echo $userId ?>,
                total: <?php echo $total; ?>,
                paymethodId: getSelectedPaymentMethod(),
                quantity: <?php echo $count; ?>,
                status: 1
            };

            // Thêm đối tượng invoice vào mảng selectedProducts
            selectedProducts.push(invoice);

            // Vòng lặp để tạo và thêm các đối tượng invoiceDetail vào mảng selectedProducts
            <?php foreach ($selectedProducts as $key => $product) { ?>
                var invoiceDetail; // Reset biến invoiceDetail

                invoiceDetail = {
                    parent_code: invoice.code,
                    bookId: <?php echo $product->id ?>,
                    userId: <?php echo $userId; ?>,
                    price: <?php echo $product->price2 ?>,
                    quantity: <?php echo $product->quantity ?>,
                    orderStatusId: 1,
                    status: 1
                };

                selectedProducts.push(invoiceDetail);
            <?php } ?>

            // Chuyển đổi selectedProducts thành chuỗi JSON để truyền qua URL
            const selectedProductsJSON = JSON.stringify(selectedProducts);

            // Lựa chọn phương thức thanh toán
            if (document.getElementById('1').checked) {
                sendOtpAndRedirect();
            } else if (document.getElementById('2').checked) {
                // Chuyển hướng đến trang VNPAY và truyền selectedProducts qua URL
                window.location.href = 'index.php?template=checkout/vnpay_checkout&selectedProducts=' + encodeURIComponent(selectedProductsJSON);
            } else if (document.getElementById('3').checked) {
                window.location.href = 'payment_method_3_url.php'; // Đường dẫn đến trang thanh toán 3
            } else {
                alert('Vui lòng chọn phương thức thanh toán.'); // Thông báo nếu chưa chọn phương thức
            }
        });


        function sendOtpAndRedirect() {
            var payloading = document.getElementById('pay-loading');
            var opacity = document.getElementById('opacity');
            opacity.classList.toggle('hidden');
            payloading.classList.remove('hidden');
            const selectedProductsJSON = JSON.stringify(selectedProducts);
            var formData = $('#check_out').serialize();

            // Gửi email OTP
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "API/send_otp.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    console.log(xhr.responseText); // In ra phản hồi thô

                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                // Chuyển đến trang thanh toán
                                window.location.href = 'index.php?template=checkout/otp_checkout&selectedProducts=' + encodeURIComponent(selectedProductsJSON);
                            } else {
                                alert("Gửi OTP thất bại. Vui lòng thử lại.");
                            }
                        } catch (e) {
                            console.error("Lỗi khi phân tích JSON:", e);
                            alert("Đã xảy ra lỗi trong quá trình xử lý yêu cầu. Vui lòng thử lại.");
                        }
                    } else {
                        alert("Gửi OTP thất bại. Vui lòng thử lại.");
                    }
                }
            };

            // Gửi dữ liệu biểu mẫu đã tuần tự hóa
            xhr.send(formData);
        }
        // Thay đổi giá trị của trường "Ngày tạo hóa đơn" thành ngày hiện tại
        function processPayment() {
            var payloading = document.getElementById('pay-loading');
            var opacity = document.getElementById('opacity');
            opacity.classList.toggle('hidden');
            payloading.classList.remove('hidden');

            // Chuỗi ký tự có thể chứa trong mã hóa đơn

            // Sử dụng hàm generateInvoiceCode để tạo mã hóa đơn có 20 ký tự
            var invoiceCode = generateInvoiceCode(20);


            console.log(billingName);
            console.log(invoiceCode);
            // Tạo invoice
            const invoice = {
                code: invoiceCode, // Mã hóa đơn
                username: billingName, // Tên người dùng
                date: getCurrentDate(), // Ngày tạo hóa đơn
                phone: billingPhone, // Số điện thoại
                email: billingEmail, // Địa chỉ email
                address: billingAddress + ", " + selectedWard + ", " + selectedDistrict + ", " + selectedProvince, // Địa chỉ
                userId: <?php echo $userId ?>, // ID người dùng
                total: <?php echo $total;  ?>, // Tổng số tiền
                paymethodId: getSelectedPaymentMethod(), // ID phương thức thanh toán
                quantity: <?php echo $count;  ?>, // Số lượng
                status: 1
            };
            console.log(invoice);
            var invoiceDetails = [];

            <?php foreach ($selectedProducts as $key => $product) { ?>
                var invoiceDetail; // Reset biến invoiceDetail

                invoiceDetail = {
                    parent_code: invoiceCode,
                    bookId: <?php echo $product->id ?>,
                    userId: <?php echo $userId; ?>,
                    price: <?php echo $product->price2 ?>,
                    quantity: <?php echo $product->quantity ?>,
                    orderStatusId: 1,
                    status: 1
                };

                // Thêm chi tiết hóa đơn vào mảng
                invoiceDetails.push(invoiceDetail);
            <?php } ?>
            sendInvoiceToServer(invoice, invoiceDetails);
        }

        // Hàm lấy phương thức thanh toán được chọn
        function getSelectedPaymentMethod() {
            var paymentMethods = document.getElementsByName('pay-method');
            for (var i = 0; i < paymentMethods.length; i++) {
                if (paymentMethods[i].checked) {
                    return paymentMethods[i].id;
                }
            }
            return null;
        }

        // Hàm gửi yêu cầu AJAX tới server
        function sendInvoiceToServer(invoice, invoiceDetails) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "API/pay.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === "success") {
                        console.log("Invoice and invoice details saved successfully");
                        window.location.href = 'index.php?template=invoice/invoice';
                    } else {
                        console.error("Error saving invoice: " + response.message);
                    }
                }
            };

            var data = JSON.stringify({
                invoice: invoice,
                invoiceDetails: invoiceDetails
            });

            xhr.send(data);
        }
    </script>
</body>

</html>
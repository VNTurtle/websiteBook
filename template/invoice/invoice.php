<?php
$userId = $_SESSION['Id'];

$queryOrder = "SELECT * FROM `orderstatus` WHERE 1";
$OrderStatus = DP::run_query($queryOrder, $parameters, $resultType);

$queryInvoiceDT = "SELECT ivd.*, b.Name,b.Price, i.Path
FROM invoicedetail ivd
JOIN book b ON ivd.BookId = b.Id
LEFT JOIN `image` i ON b.Id = i.BookId
WHERE  i.Id = (
                SELECT MIN(i2.Id)
                FROM `image` i2
                WHERE i2.BookId = b.Id
            ) AND ivd.UserId = $userId";
$InvoiceDT = DP::run_query($queryInvoiceDT, $parameters, $resultType);
?>
<link rel="stylesheet" href="assets/css/invoice.css">

<div class="bodywrap container">
    <div class="product-tab e-tabs not-dqtab" id="tab-product">
        <ul class="tabs tabs-title clearfix">
            <?php
            foreach ($OrderStatus as $key => $lst_order) {
                if ($lst_order['Id'] == 1) {
                    echo '<li class="tab-link active" id="tab-link-' . $lst_order["Id"] . '">
                                    <h3>' . $lst_order["Name"] . '</h3>
                                  </li>';
                } else {
                    echo '<li class="tab-link" id="tab-link-' . $lst_order["Id"] . '">
                                    <h3>' . $lst_order["Name"] . '</h3>
                                </li>';
                }
            }
            ?>
            <li class="tab-link" id="tab-link-6">
                <h3>Hóa đơn đã mua</h3>
            </li>
        </ul>
        <div class="tab-float">
            <?php
            foreach ($OrderStatus as $key => $lst_order) {
                if ($lst_order['Id'] == 1 || $lst_order['Id'] == 2) {
                    echo '  <div id="tab' . $lst_order['Id'] . '" class="tab-content active">
                                    <div class="rte product_getcontent">';
                    foreach ($InvoiceDT as $key => $lst_invoiceDetail) {
                        if ($lst_invoiceDetail['OrderStatusId'] == $lst_order['Id']) {
                            echo '<div class="invoice-detail">
                                            <div class="ajaxcart-row">
                                                <div class="ajaxcart-product invoice-product">
                                                    <a href="" class="ajaxcart-product-image invoice-image">
                                                        <img src="assets/img/products/' . $lst_invoiceDetail['Path'] . '" alt="">
                                                    </a>
                                                    <div class="grid-item invoice-info">
                                                        <div class="invoice-name">
                                                           <div class="invoice-name">
                                                                        <a href="">' . $lst_invoiceDetail['Name'] . '</a>
                                                                        <span class="variant-title">' . $lst_invoiceDetail['Price'] . ' đ</span>
                                                                    </div>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="invoice-select">
                                                                <div class="input-number-product">
                                                                    <span class="stock-title">Số lượng</span>
                                                                    <div class="stock">' . $lst_invoiceDetail['Quantity'] . '</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid2">
                                                            <div class="invoice-prices">
                                                                <span class="price-title">Thành tiền</span>
                                                                <span class="invoice-price">' . $lst_invoiceDetail['UnitPrice'] . ' đ</span>
                                                            </div>
                                                        </div>
                                                        <div class="grid3">
                                                            <button class="btn-cancel-order btn-received" type="button" data-order-id="' . $lst_invoiceDetail['Id'] . '">Hủy đơn</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>';
                        }
                    }

                    echo ' </div>
                                    </div>';
                } else if ($lst_order['Id'] == 3) {
                    echo '  <div id="tab' . $lst_order['Id'] . '" class="tab-content">
                                    <div class="rte product_getcontent">';
                    foreach ($InvoiceDT as $key => $lst_invoiceDetail) {
                        if ($lst_invoiceDetail['OrderStatusId'] == $lst_order['Id']) {
                            echo '<div class="invoice-detail">
                                                        <div class="ajaxcart-row">
                                                            <div class="ajaxcart-product invoice-product">
                                                                <a href="" class="ajaxcart-product-image invoice-image">
                                                                    <img src="assets/img/products/' . $lst_invoiceDetail['Path'] . '" alt="">
                                                                </a>
                                                                <div class="grid-item invoice-info">
                                                                    <div class="invoice-name">
                                                                    <div class="invoice-name">
                                                                                    <a href="">' . $lst_invoiceDetail['Name'] . '</a>
                                                                                    <span class="variant-title">' . $lst_invoiceDetail['Price'] . ' đ</span>
                                                                                </div>
                                                                    </div>
                                                                    <div class="grid">
                                                                        <div class="invoice-select">
                                                                            <div class="input-number-product">
                                                                                <span class="stock-title">Số lượng</span>
                                                                                <div class="stock">' . $lst_invoiceDetail['Quantity'] . '</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="grid2">
                                                                        <div class="invoice-prices">
                                                                            <span class="price-title">Thành tiền</span>
                                                                            <span class="invoice-price">' . $lst_invoiceDetail['UnitPrice'] . ' đ</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="grid3">
                                                                        <button class="btn-received" type="button">Đã nhận hàng</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>';
                        }
                    }

                    echo ' </div>
                                    </div>';
                } else if ($lst_order['Id'] == 4) {
                    echo '  <div id="tab' . $lst_order['Id'] . '" class="tab-content">
                                    <div class="rte product_getcontent">';
                    foreach ($InvoiceDT as $key => $lst_invoiceDetail) {
                        if ($lst_invoiceDetail['OrderStatusId'] == $lst_order['Id']) {
                            echo '<div class="invoice-detail">
                                                        <div class="ajaxcart-row">
                                                            <div class="ajaxcart-product invoice-product">
                                                                <a href="" class="ajaxcart-product-image invoice-image">
                                                                    <img src="assets/img/products/' . $lst_invoiceDetail['Path'] . '" alt="">
                                                                </a>
                                                                <div class="grid-item invoice-info">
                                                                    <div class="invoice-name">
                                                                    <div class="invoice-name">
                                                                                    <a href="">' . $lst_invoiceDetail['Name'] . '</a>
                                                                                    <span class="variant-title">' . $lst_invoiceDetail['Price'] . ' đ</span>
                                                                                </div>
                                                                    </div>
                                                                    <div class="grid">
                                                                        <div class="invoice-select">
                                                                            <div class="input-number-product">
                                                                                <span class="stock-title">Số lượng</span>
                                                                                <div class="stock">' . $lst_invoiceDetail['Quantity'] . '</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="grid2">
                                                                        <div class="invoice-prices">
                                                                            <span class="price-title">Thành tiền</span>
                                                                            <span class="invoice-price">' . $lst_invoiceDetail['UnitPrice'] . ' đ</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="grid3">
                                                                        <button class="btn-received" type="button">Đánh giá</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>';
                        }
                    }

                    echo ' </div>
                                    </div>';
                } else {
                    echo '  <div id="tab' . $lst_order['Id'] . '" class="tab-content">
                                    <div class="rte product_getcontent">';
                    foreach ($InvoiceDT as $key => $lst_invoiceDetail) {
                        if ($lst_invoiceDetail['OrderStatusId'] == $lst_order['Id']) {
                            echo '<div class="invoice-detail">
                                                        <div class="ajaxcart-row">
                                                            <div class="ajaxcart-product invoice-product">
                                                                <a href="" class="ajaxcart-product-image invoice-image">
                                                                    <img src="assets/img/products/' . $lst_invoiceDetail['Path'] . '" alt="">
                                                                </a>
                                                                <div class="grid-item invoice-info">
                                                                    <div class="invoice-name">
                                                                    <div class="invoice-name">
                                                                                    <a href="">' . $lst_invoiceDetail['Name'] . '</a>
                                                                                    <span class="variant-title">' . $lst_invoiceDetail['Price'] . ' đ</span>
                                                                                </div>
                                                                    </div>
                                                                    <div class="grid">
                                                                        <div class="invoice-select">
                                                                            <div class="input-number-product">
                                                                                <span class="stock-title">Số lượng</span>
                                                                                <div class="stock">' . $lst_invoiceDetail['Quantity'] . '</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="grid2">
                                                                        <div class="invoice-prices">
                                                                            <span class="price-title">Thành tiền</span>
                                                                            <span class="invoice-price">' . $lst_invoiceDetail['UnitPrice'] . ' đ</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="grid3">
                                                                        <button class="btn-received" type="button">Mua lại</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>';
                        }
                    }

                    echo ' </div>
                                    </div>';
                }
            }
            ?>
            <div id="tab6" class="tab-content">
                <div class="rte product_getcontent">
                    <div class="invoice-page">
                        <div class="drawer-inner">
                            <div class="InvoicePageContainer">
                                <form action="" class="invoice ajaxcart">
                                    <div class="invoice-header-info">
                                        <div>Mã hóa đơn</div>
                                        <div>Ngày mua</div>
                                        <div>Số Lượng</div>
                                    </div>
                                    <div class="invoice-body">
                                        <div class="invoice-body-ajax">
                                            <div class="invoice-body-info" onclick="toggleInvoiceDetail(this)" data-target="invoice-detail-1">
                                                <div class="grid-item invoice-code" id="invoice-code-1">KJHJH545ASAA</div>
                                                <div class="grid-item invoice-date">17/07/2024</div>
                                                <div class="grid-item invoice-stock">5</div>
                                            </div>
                                            <div class="invoice-body-detail" id="invoice-detail-1">
                                                <div class="invoice-detail">
                                                    <div class="ajaxcart-row">
                                                        <div class="ajaxcart-product invoice-product">
                                                            <a href="" class="ajaxcart-product-image invoice-image">
                                                                <img src="assets/img/products/ThienSuNhaBenTap1_1.jpg" alt="">
                                                            </a>
                                                            <div class="grid-item invoice-info">
                                                                <div class="invoice-name">
                                                                    <a href="">Kim chi cải thảo cắt lát Bibigo Ông Kim's gói</a>
                                                                    <span class="variant-title">200g</span>
                                                                </div>
                                                                <div class="grid">
                                                                    <div class="invoice-select">
                                                                        <div class="input-number-product">
                                                                            <span class="stock-title">Số lượng</span>
                                                                            <div class="stock">5</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid2">
                                                                    <div class="invoice-prices">
                                                                        <span class="invoice-price">20.000đ</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="invoice-detail">
                                                    <div class="ajaxcart-row">
                                                        <div class="ajaxcart-product invoice-product">
                                                            <a href="" class="ajaxcart-product-image invoice-image">
                                                                <img src="assets/img/products/ThienSuNhaBenTap1_1.jpg" alt="">
                                                            </a>
                                                            <div class="grid-item invoice-info">
                                                                <div class="invoice-name">
                                                                    <a href="">Kim chi cải thảo cắt lát Bibigo Ông Kim's gói</a>
                                                                    <span class="variant-title">200g</span>
                                                                </div>
                                                                <div class="grid">
                                                                    <div class="invoice-select">
                                                                        <div class="input-number-product">
                                                                            <span class="stock-title">Số lượng</span>
                                                                            <div class="stock">5</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid2">
                                                                    <div class="invoice-prices">
                                                                        <span class="invoice-price">20.000đ</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="invoice-body-ajax">
                                            <div class="invoice-body-info" onclick="toggleInvoiceDetail(this)" data-target="invoice-detail-2">
                                                <div class="grid-item invoice-code">KJHJH545ASAA</div>
                                                <div class="grid-item invoice-date">17/07/2024</div>
                                                <div class="grid-item invoice-stock">5</div>
                                            </div>
                                            <div class="invoice-body-detail" id="invoice-detail-2">
                                                <div class="invoice-detail">
                                                    <div class="ajaxcart-row">
                                                        <div class="ajaxcart-product invoice-product">
                                                            <a href="" class="ajaxcart-product-image invoice-image">
                                                                <img src="assets/img/products/ThienSuNhaBenTap1_1.jpg" alt="">
                                                            </a>
                                                            <div class="grid-item invoice-info">
                                                                <div class="invoice-name">
                                                                    <a href="">Kim chi cải thảo cắt lát Bibigo Ông Kim's gói</a>
                                                                    <span class="variant-title">200g</span>
                                                                </div>
                                                                <div class="grid">
                                                                    <div class="invoice-select">
                                                                        <div class="input-number-product">
                                                                            <span class="stock-title">Số lượng</span>
                                                                            <div class="stock">5</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid2">
                                                                    <div class="invoice-prices">
                                                                        <span class="invoice-price">20.000đ</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="invoice-detail">
                                                    <div class="ajaxcart-row">
                                                        <div class="ajaxcart-product invoice-product">
                                                            <a href="" class="ajaxcart-product-image invoice-image">
                                                                <img src="assets/img/products/ThienSuNhaBenTap1_1.jpg" alt="">
                                                            </a>
                                                            <div class="grid-item invoice-info">
                                                                <div class="invoice-name">
                                                                    <a href="">Kim chi cải thảo cắt lát Bibigo Ông Kim's gói</a>
                                                                    <span class="variant-title">200.000 đ</span>
                                                                </div>
                                                                <div class="grid">
                                                                    <div class="invoice-select">
                                                                        <div class="input-number-product">
                                                                            <span class="stock-title">Số lượng</span>
                                                                            <div class="stock">5</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid2">
                                                                    <div class="invoice-prices">
                                                                        <span class="price-title">Thành tiền</span>
                                                                        <span class="invoice-price">20.000đ</span>
                                                                    </div>
                                                                </div>
                                                                <div class="grid3">
                                                                    <button class="btn-received" type="button">Đã nhận hàng</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="cancelModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Lý do hủy đơn</h2>
        <div id="cancelReasons">
            <div class="checkbox-wrapper-46">
                <input type="checkbox" id="cbx-1" class="inp-cbx" data-reason="Đổi ý" />
                <label for="cbx-1" class="cbx"><span>
                        <svg viewBox="0 0 12 10" height="10px" width="12px">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Đổi ý</span>
                </label>
            </div>
            <div class="checkbox-wrapper-46">
                <input type="checkbox" id="cbx-2" class="inp-cbx" data-reason="Đặt nhầm sản phẩm" />
                <label for="cbx-2" class="cbx"><span>
                        <svg viewBox="0 0 12 10" height="10px" width="12px">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Đặt nhầm sản phẩm</span>
                </label>
            </div>
            <div class="checkbox-wrapper-46">
                <input type="checkbox" id="cbx-3" class="inp-cbx" data-reason="Tìm thấy giá tốt hơn" />
                <label for="cbx-3" class="cbx"><span>
                        <svg viewBox="0 0 12 10" height="10px" width="12px">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Tìm thấy giá tốt hơn</span>
                </label>
            </div>
            <div class="checkbox-wrapper-46">
                <input type="checkbox" id="cbx-4" class="inp-cbx" data-reason="Vấn đề với phương thức thanh toán" />
                <label for="cbx-4" class="cbx"><span>
                        <svg viewBox="0 0 12 10" height="10px" width="12px">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Vấn đề với phương thức thanh toán</span>
                </label>
            </div>
            <div class="checkbox-wrapper-46">
                <input type="checkbox" id="cbx-5" class="inp-cbx" data-reason="Dịch vụ không tốt" />
                <label for="cbx-5" class="cbx"><span>
                        <svg viewBox="0 0 12 10" height="10px" width="12px">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Dịch vụ không tốt</span>
                </label>
            </div>
            <div class="checkbox-wrapper-46">
                <input type="checkbox" id="cbx-6" class="inp-cbx" data-reason="Thay đổi nhu cầu" />
                <label for="cbx-6" class="cbx"><span>
                        <svg viewBox="0 0 12 10" height="10px" width="12px">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Thay đổi nhu cầu</span>
                </label>
            </div>
            <div class="checkbox-wrapper-46">
                <input type="checkbox" id="cbx-7" class="inp-cbx" data-reason="Khác" />
                <label for="cbx-7" class="cbx"><span>
                        <svg viewBox="0 0 12 10" height="10px" width="12px">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span>Khác</span>
                </label>
            </div>
        </div>
        <textarea id="cancelReason" rows="4" cols="50" placeholder="Nhập lý do khác nếu có..."></textarea>
        <button id="confirmCancel" class="btn btn-primary">Xác nhận</button>
    </div>
</div>

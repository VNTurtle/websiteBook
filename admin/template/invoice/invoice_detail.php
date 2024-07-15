<?php
if (isset($_GET['id_invoice'])) {
    $invoice_id = $_GET['id_invoice'];
    $SL_iv = "SELECT iv.* , pay.Name as payname
            FROM `invoice` iv
            LEFT JOIN paymethod pay ON iv.PaymethodId= pay.Id 
            WHERE iv.Code=?";
    $parameters = [$invoice_id]; // Các tham số truy vấn (nếu có)
    $resultType = 2;
    $invoices = DP::run_query($SL_iv, $parameters, $resultType);
    $invoice = $invoices[0];

    $SL_ivd = "SELECT ivd.*, i.Path, b.Name, b.Price
        FROM invoicedetail ivd
        LEFT JOIN image i ON ivd.BookId = i.BookId
        JOIN invoice iv ON ivd.Parent_code = iv.code
        JOIN book b ON ivd.BookId = b.Id
        WHERE i.Id = (
                SELECT MIN(i2.Id)
                FROM `image` i2
                WHERE i2.BookId = ivd.BookId
            ) AND iv.Code=?";
    $ivd = DP::run_query($SL_ivd, $parameters, $resultType);
?>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Hóa đơn /</span> Xác nhận hóa đơn
        </h4>
        <h2>Chi tiết đơn hàng</h2>
        <div id="Confirm-invoice" class="invoice">
            <h5>Thông tin đơn hàng</h5>
            <p><strong>Mã đơn hàng:</strong> <?= $invoice['Code'] ?></p>
            <p><strong>Người đặt:</strong> <?= $invoice['Username'] ?></p>
            <p><strong>Địa chỉ nhận:</strong> <?= $invoice['ShippingAddress'] ?></p>
            <p><strong>Số điện thoại:</strong> <?= $invoice['ShippingPhone'] ?></p>
            <p><strong>Email:</strong> <?= $invoice['ShippingEmail'] ?></p>
            <p><strong>Ngày đặt:</strong> <?= $invoice['IssuedDate'] ?></p>
            <p><strong>Tổng tiền:</strong> <?= $invoice['Total'] ?> VNĐ</p>
            <p><strong>Phương thức thanh toán</strong> <?= $invoice['payname'] ?></p>
            <h3>Sản phẩm mua</h3>
            <div class="card">
                <div class="card-datatable ">
                    <table class="datatables-products table border-top">
                        <thead>
                            <tr style="background-color: aqua;">
                                <th>STT</th>
                                <th>product</th>
                                <th>price</th>
                                <th>qty</th>
                                <th>Unitprice</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($ivd as $key => $item) {
                            ?>
                                <tr class="odd">
                                    <td>
                                        <?php echo $key + 1 ?>
                                    </td>
                                    <td class="sorting_1">
                                        <div class="d-flex justify-content-start align-items-center product-name">
                                            <div class="avatar-wrapper">
                                                <div class="avatar me-2 rounded-2 bg-label-secondary">
                                                    <img class="rounded-2" src="assets/img/products/<?php echo $item['Path'] ?>" alt="">
                                                </div>
                                            </div>
                                            <div class="name-product" style="width: 400px;">
                                                <h6 class="text-body text-nowrap mb-0" style="white-space: normal !important; overflow-wrap: break-word;"><?php echo $item['Name'] ?> </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-truncate align-items-center">
                                            <?php echo $item['Price'] ?> đ
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-truncate align-items-center">
                                            <?php echo $item['Quantity'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-truncate align-items-center">
                                            <?php echo $item['UnitPrice'] ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                    </table>
                </div>
            </div>
            <div>
                <button class="btn btn-primary update-status-btn mt-2" data-order-status="2" data-order-id="<?= $invoice_id ?>">Xác nhận</button>
            </div>
        </div>

    </div>
</div>
<?php
}
else{
    
}
?>

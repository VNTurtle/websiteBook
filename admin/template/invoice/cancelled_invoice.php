<?php

$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)
$query_invoice = "SELECT iv.*, b.Name, i.Path, os.Name AS NameOrder 
FROM `invoicedetail` iv
LEFT JOIN book b ON iv.BookId = b.Id
JOIN orderstatus os ON iv.OrderStatusId = os.Id
JOIN `image` i ON b.Id = i.BookId
WHERE i.Id = (
    SELECT MIN(i2.Id)
    FROM `image` i2
    WHERE i2.BookId = b.Id
) AND iv.OrderStatusId=5;";
$invoice = DP::run_query($query_invoice, $parameters, $resultType);

$query_Order = "SELECT * FROM `orderstatus` WHERE 1";
$Order = DP::run_query($query_Order, $parameters, $resultType);
?>

<link rel="stylesheet" href="admin/css/lst_invoice.css">

<div class="content-wrapper">

    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">



        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Sản Phẩm /</span> Danh Sách Sản Phẩm
        </h4>

        <!-- Product List Widget -->
        <div class="card">
            <div class="card-datatable ">
                <table class="datatables-products table border-top">
                    <thead>
                        <tr style="background-color: aqua;">
                            <th>STT</th>
                            <th>product</th>
                            <th>price</th>
                            <th>qty</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($invoice as $key => $lst) {
                        ?>
                            <tr class="odd">
                                <td>
                                    <?php echo $key + 1 ?>
                                </td>
                                <td class="sorting_1">
                                    <div class="d-flex justify-content-start align-items-center product-name">
                                        <div class="avatar-wrapper">
                                            <div class="avatar me-2 rounded-2 bg-label-secondary">
                                                <img class="rounded-2" src="assets/img/products/<?php echo $lst['Path'] ?>" alt="">
                                            </div>
                                        </div>
                                        <div class="name-product" style="width: 315px;">
                                            <h6 class="text-body text-nowrap mb-0" style="white-space: normal !important; overflow-wrap: break-word;"><?php echo $lst['Name'] ?> </h6>
                                        </div>

                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate align-items-center">
                                        <?php echo $lst['UnitPrice'] ?> đ
                                    </span>
                                </td>
                                <td>
                                    <span class="text-truncate align-items-center">
                                        <?php echo $lst['Quantity'] ?>
                                    </span>
                                </td>
                                    <td>
                                        <select name="order_status" id="order_status" class="custom-select order_status" data-order-id="<?php echo $lst['Id']; ?>" >
                                            <?php
                                            foreach ($Order as $key => $item) {
                                                $selected = ($lst['OrderStatusId'] == $item['Id']) ? 'selected' : '';
                                                echo '<option value="' . ($item['Id']) . '" ' . $selected . '>' . $item['Name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
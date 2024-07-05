<?php
$userId = $_SESSION['Id'];
$query = "SELECT c.Id AS CartId, c.UserId, b.*, c.Quantity, i.Path
            FROM Cart c 
            JOIN Account a ON c.UserId = a.Id 
            JOIN Book b ON c.BookId = b.Id 
            LEFT JOIN `image` i ON b.Id = i.BookId 
            WHERE c.UserId = $userId AND i.Id = (
                SELECT MIN(i2.Id)
                FROM `image` i2
                WHERE i2.BookId = b.Id
            );";
$Lst_Cart = DP::run_query($query, $parameters, $resultType);
?>

<link rel="stylesheet" href="assets/css/cart.css">
<div class="bodywrap" style="margin-top: 30px;">
        <div class="cart container">
            <div class="page-title">
                <h1>Giỏ hàng</h1>
                <span class="cart-number-item">(2 sản phẩm)</span>
            </div>
            <div class="row cart-content">
                <div class="col-sm-8 col-xs-12">
                    <div class="header-cart-item">
                        <div class="checkbox-all-book">
                            <input id="checkbox-all-products" name="" class="checkbox-all-cart" type="checkbox" />
                        </div>
                        <div>
                            <span>
                                "Chọn tất cả ("
                                <span class="number-checkbox">2</span>
                                "sản phẩm)"
                            </span>
                        </div>
                        <div>
                            Số lượng
                        </div>
                        <div>
                            Thành tiền
                        </div>
                        <div></div>
                    </div>
                    <div class="book-cart-left">
                        <?php
                        foreach ($Lst_Cart as $key => $cart_item) {
                            $total_price = $cart_item['Price'] * $cart_item['Quantity'];
                        ?>
                            <div class="item-book-cart">
                                <div class="checkbox-book-cart">
                                    <input id="<?php echo $cart_item['Id'] ?>" name="checkbox_book-1919" class="checkbox-add-cart" type="checkbox"
                                     data-price="<?php echo $cart_item['Price'] ?>" data-name="<?php echo $cart_item['Name']; ?>" 
                                     data-img="<?php echo $cart_item['Path']; ?>" data-quantity="<?php echo $cart_item['Quantity']; ?>"
                                     data-price2="<?php echo $total_price ?>"/>
                                </div>
                                <div class="img-book-cart">
                                    <a class="book-image" href="">
                                        <img src="assets/img/products/<?php echo $cart_item['Path'] ?>" width="120" height="120" alt="">
                                    </a>
                                </div>
                                <div class="group-book-info">
                                    <div class="info-book-cart">
                                        <div class="name-book">
                                            <h2 class="book-name-full">
                                                <a href=""><?php echo $cart_item['Name'] ?></a>
                                            </h2>
                                        </div>
                                        <div class="price-original">
                                            <div class="cart-price">
                                                <span class="price"> <?php echo $cart_item['Price'] ?> đ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="number-book-cart">
                                        <div class="input-number-product">
                                            <button class="btn-num num-1">-</button>
                                            <input type="text" name="quantity" value="<?php echo $cart_item['Quantity'] ?>" maxlength="3" class="form-control prd-quantity">
                                            <button class="btn-num num-2">+</button>
                                        </div>
                                        <div class="cart-price-total">
                                            <span class="cart-price">
                                                <span class="price">
                                                    <?php

                                                    // In ra kết quả
                                                    echo $total_price;
                                                    ?>.000 đ
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="remove-cart">
                                    <img src="assets/img/recycle-bin_9983371.png" style="width: 22px; height: 30px;" alt="">
                                </div>
                            </div>
                            <div class="border-book"></div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-4 ">
                    <div class="block-total-cart">
                        <div class="total-cart-page">
                            <div class="title-cart-page-left">Thành tiền</div>
                            <div class="number-cart-page-right">
                                <span id="total-price" class="price">0 đ</span>
                            </div>
                        </div>
                        <div class="button-cart" style="text-align: center;">
                            <button id="checkoutButton" class="button btn-checkout">
                                <span>Thanh toán</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

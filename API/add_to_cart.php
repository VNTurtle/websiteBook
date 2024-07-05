<?php
require_once('db.php');
session_start();

$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)

$bookId = $_POST['Id'];
$userId = $_SESSION['Id'];
if($userId == null){
    header("Location: Login.php");
    exit;
}
echo $bookId;
echo $userId;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    // Lấy thông tin sản phẩm từ form
    $quantity = $_POST['quantity'];
    echo $quantity;
    $queryCheckCart = "SELECT `Quantity` FROM `cart` WHERE `UserId` = ? AND `BookId` = ?";
    $parameters = [$userId, $bookId];
    $quantityInCart = DP::run_query($queryCheckCart, $parameters, 2);

    if (!empty($quantityInCart)) {
        // Sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng
        $newQuantity = $quantityInCart[0]['Quantity'] + $quantity;
        $queryUpdateCart = "UPDATE `cart` SET `Quantity` = ? WHERE `UserId` = ? AND `BookId` = ?";
        $parameters = [$newQuantity, $userId, $bookId];
        DP::run_query($queryUpdateCart, $parameters, $resultType);
        exit;
    } else {
        // Sản phẩm chưa tồn tại trong giỏ hàng, thêm sản phẩm mới
        $queryAddtoCart = "INSERT INTO `cart`(`UserId`, `BookId`, `Quantity`, `Status`) VALUES (?, ?, ?, '1')";
        $parameters = [$userId, $bookId, $quantity];
        DP::run_query($queryAddtoCart, $parameters, $resultType);
        exit;
    }
}
?>
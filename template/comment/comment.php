<?php
session_start();
require_once('API/db.php');
include "assets/model/comment.php";

if (isset($_GET['idsp'])) {
    $productId = $_GET['idsp'];
} elseif (isset($_POST['productId'])) {
    $productId = $_POST['productId'];
} else {
    // Xử lý trường hợp không có productId
    echo "Không tìm thấy sản phẩm.";
    exit;
}

$loginUrl = "index.php?template=user/login&idsp=" . $productId;

if (isset($_SESSION['Id']) && ($_SESSION['Id']) > 0) {
    if (isset($_POST['guibinhluan']) && ($_POST['guibinhluan'])) {
        $iduser = $_SESSION['Id'];
        $idsp = $productId;
        $noidung = $_POST['noidung'];

        thembl($iduser, $idsp, $noidung);
    }
} else {
?>
    <div class="alert alert-warning">
        <h4 class="alert-heading">Bạn chưa đăng nhập!</h4>
        <p>Vui lòng đăng nhập để có thể bình luận về sản phẩm.</p>
        <hr>
        <p>
            <a href="<?php echo $loginUrl; ?>" target="_parent" class="btn btn-primary">Đăng nhập</a>
        </p>
    </div>
<?php
}
$dsbl = showbl($productId);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/comment.css">
</head>
<body>
    <div class="customer-reviews row pb-4 py-4">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?php
            if (isset($_SESSION['Id']) && ($_SESSION['Id']) > 0) {
                ?>
                <form method="post">
                    <div class="form-group">
                        <label for="formcontent">Nội dung: </label>
                        <textarea required rows="5" id="formcontent" name="noidung" class="form-control" placeholder="Viết bình luận..."></textarea>
                    </div>
                    <input type="hidden" name="productId" value="<?= $productId ?>">
                    <input class="btn btn-primary" type="submit" name="guibinhluan">
                </form>
                <hr>
                <?php
            }
            ?>
            <?php
            if (!empty($dsbl)) {
                foreach ($dsbl as $bl) {
                    // Bạn có thể thêm các biến để lưu trữ các giá trị từ cơ sở dữ liệu
                    $fullName = htmlspecialchars($bl['FullName']);
                    $content = ($bl['Content']);
                    // $date = htmlspecialchars($bl['Date']); // Cột lưu trữ thời gian bình luận
                    // $rating = htmlspecialchars($bl['Rating']); // Cột lưu trữ đánh giá, giả sử là số sao

                    echo '<div class="comment-item">';
                    echo '<ul class="item-reviewer">';
                    echo '<div class="comment-item-user">';
                    echo '<img src="assets/img/avatar/user.jpg" alt="" class="comment-item-user-img">'; // Thay thế "img/HinhCute/h4.jfif" bằng đường dẫn thực sự nếu cần
                    echo '<li><b>' . $fullName . '</b></li>';
                    echo '</div>';
                    echo '<br>';
                    // echo '<li>' . $date . '</li>';
                    echo '<li>';
                    echo '<p>' . $content . '</p>';
                    echo '</li>';
                    echo '</ul>';
                    echo '</div>';
                }
            }
            ?>
            <hr>
        </div>
    </div>

</body>

</html>
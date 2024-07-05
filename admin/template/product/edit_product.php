<?php

if (isset($_GET['id'])) {
    $bookId = $_GET['id'];
}

$query = "SELECT b.*, bt.Name AS BookTypeName, s.Name AS SizeName, p.Name AS PublisherName, cv.Name AS CovertypeName, cb.Name AS NameCombo
FROM book b
LEFT JOIN Type bt ON b.TypeId = bt.Id
JOIN Size s ON b.SizeId = s.Id
JOIN combobook cb ON b.ComboBookId=cb.Id
JOIN Publisher p ON b.PublisherId = p.Id
JOIN covertype cv ON b.CoverTypeId = cv.Id
WHERE b.Id = $bookId;";
$parameters = []; // Các tham số truy vấn (nếu có)
$resultType = 2; // Loại kết quả truy vấn (2: Fetch All)

$book = DP::run_query($query, $parameters, $resultType);

$query_Combo="SELECT * FROM `combobook` ";
$Combo = DP::run_query($query_Combo, $parameters, $resultType);

$query_Type="SELECT * FROM `type` ";
$Type = DP::run_query($query_Type, $parameters, $resultType);

$query_Size="SELECT * FROM `size` ";
$Size = DP::run_query($query_Size, $parameters, $resultType);

$query_Publisher="SELECT * FROM `publisher` ";
$Publisher = DP::run_query($query_Publisher, $parameters, $resultType);

$query_CoverType="SELECT * FROM `coverType` ";
$CoverType = DP::run_query($query_CoverType, $parameters, $resultType);
?>

<link rel="stylesheet" href="admin/css/edit_product.css">

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Sản Phẩm /</span> Chỉnh sửa Sản Phẩm
        </h4>
        <div class="card">
            <h4 class="py-3 mb-4" style="color: #656cf9;">
                <span class="text-muted fw-light"> - Sản Phẩm /</span>
            </h4>
            <div class="edit_product">
                <form action="">
                    <div class="for-group">
                        <label for="">Tên sản phẩm</label>
                        <input type="text" name="Name" value="<?php echo $book[0]['Name'] ?>">
                    </div>
                    <div class="for-group">
                        <label for="">Theo Bộ</label>
                        <select for=""> 
                        <option value="0">Không có</option>
                        <?php 
                            foreach ($Combo as $key => $lst_combo) {   
                                echo '<option value="'. $key+1 .'">'. $lst_combo['Name'] .'</option>';
                            }
                        ?>
                        </select>
                        
                    </div>
                    <div class="for-group">
                        <label for="">Tác giả</label>
                        <input type="text" name="Name" value="<?php echo $book[0]['Author'] ?>">
                    </div>
                    <div class="for-group">
                        <label for="">Loại sản phẩm</label>
                        <select for=""> 
                        <?php 
                            foreach ($Type as $key => $lst_type) {   
                                echo '<option value="'. $key .'">'. $lst_type['Name'] .'</option>';
                            }
                        ?>
                        </select>
                    </div>
                    <div class="for-group">
                        <label for="">Số trang</label>
                        <input type="number" name="Name" value="<?php echo $book[0]['NumberPage'] ?>">
                    </div>
                    <div class="for-group">
                        <label for="">Kích thước</label>
                        <select for=""> 
                        <?php 
                            foreach ($Size as $key => $lst_size) {   
                                echo '<option value="'. $key .'">'. $lst_size['Name'] .'</option>';
                            }
                        ?>
                        </select>
                    </div>
                    <div class="for-group">
                        <label for="">Tồn kho</label>
                        <input type="number" name="Name" value="<?php echo $book[0]['Stock'] ?>">
                    </div>
                    <div class="for-group">
                        <label for="">Giá sản phẩm</label>
                        <input type="number" name="Name" value="<?php echo $book[0]['Price'] ?>">
                    </div>
                    <div class="for-group">
                        <label for="">Ngày sản xuất</label>
                        <input type="date" name="Name" value="<?php echo $book[0]['Date'] ?>">
                    </div>
                    <div class="for-group">
                        <label for="">Tên nhà sản xuát</label>
                        <select for=""> 
                        <?php 
                            foreach ($Publisher as $key => $lst_publisher) {   
                                echo '<option value="'. $key .'">'. $lst_publisher['Name'] .'</option>';
                            }
                        ?>
                        </select>
                    </div>
                    <div class="for-group">
                        <label for="">Tên sản phẩm</label>
                        <select for=""> 
                        <?php 
                            foreach ($CoverType as $key => $lst_coverType) {   
                                echo '<option value="'. $key .'">'. $lst_coverType['Name'] .'</option>';
                            }
                        ?>
                        </select>
                    </div>
                    <div class="for-group">
                        <label for="">Nội dung</label>
                        <textarea name="Description" id="Description">
                            <?php echo $book[0]['Description'] ?>
                        </textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
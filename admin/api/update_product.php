<?php
require_once('../../API/db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị của trường username từ form
    $BookId= $_POST['Id'];
    $Name= $_POST['Name'];
    $ComboId = $_POST['Combo'];
    if ($ComboId === '0') {
        $ComboId = null;
    }
    $Author = $_POST['Author'];   
    $TypeId = $_POST['TypeId'];
    $NumberPage = $_POST['NumberPage'];
    $SizeId = $_POST['Size'];
    $Stock = $_POST['Stock'];
    $Price = $_POST['Price'];
    $Date = $_POST['Date'];
    $PublisherId = $_POST['Publisher'];
    $CoverTypeId = $_POST['Covertype'];
    $Description = $_POST['Description'];
    $query="UPDATE `book` 
    SET `ComboBookId`=$ComboId,`Name`='$Name',`Author`='$Author',`Description`= '$Description',
    `TypeId`=$TypeId,`NumberPage`=$NumberPage,`SizeId`=$SizeId,`Stock`=$Stock,`Price`=$Price,`Date`='$Date',
    `PublisherId`=$PublisherId,`CoverTypeId`=$CoverTypeId WHERE `Id`=$BookId";
    $parameters=[];
    $resultType=2;
    $check= DP::run_query($query,$parameters,$resultType);

} else {
    // Đoạn mã này sẽ được thực hiện nếu không phải là phương thức POST
    echo "Yêu cầu không hợp lệ!";
}

?>
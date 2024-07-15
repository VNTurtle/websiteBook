<?php
require_once('../../API/db.php');


$query = "SELECT iv.Code as invoice_id, iv.IssuedDate, iv.Code, iv.Total, COUNT(ivd.Id) AS ivd_count
FROM invoice iv
LEFT JOIN invoicedetail ivd ON iv.Code = ivd.Parent_code
WHERE iv.is_read=False
GROUP BY iv.Code;";
$new_orders = DP::run_query($query, [], 2); 

echo json_encode($new_orders);

?>
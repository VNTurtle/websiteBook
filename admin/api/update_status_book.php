<?php
require_once('../../API/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 0;

    if ($id > 0) {
        $query = "UPDATE book SET Status = ? WHERE Id = ?";
        $parameters = [$status, $id];
        $result = DP::run_query($query, $parameters, 1); // Giả sử `run_query` trả về số dòng bị ảnh hưởng

        if ($result > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update status']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid book ID']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
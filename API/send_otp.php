<?php
// Đường dẫn đến các file của PHPMailer
require '../assets/PHPMailer-master/src/Exception.php';
require '../assets/PHPMailer-master/src/PHPMailer.php';
require '../assets/PHPMailer-master/src/SMTP.php';

// Bắt đầu phiên làm việc
session_start();

// Đặt kiểu dữ liệu là JSON
header('Content-Type: application/json');

// Khởi tạo một mảng phản hồi
$response = array();

// Kiểm tra xem có dữ liệu email được gửi từ form POST hay không
if (isset($_POST['email'])) {
    $email = $_POST['email']; // Lấy địa chỉ email từ POST
    $otp = rand(1000, 9999);
    
    try {
        // Tạo một đối tượng PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);

        // Thiết lập các thông số máy chủ SMTP
        $mail->isSMTP(); // Sử dụng SMTP
        $mail->Host = 'smtp.gmail.com'; // Địa chỉ máy chủ SMTP của bạn
        $mail->SMTPAuth = true; // Bật xác thực SMTP
        $mail->Username = '0306211044@caothang.edu.vn'; // Tài khoản email của bạn
        $mail->Password = 'dtxyhliiqymifwrg'; // Mật khẩu ứng dụng của bạn
        $mail->SMTPSecure = 'ssl'; // Bật mã hóa SSL
        $mail->Port = 465; // Cổng SMTP - 465 cho SSL, 587 cho TLS

        // Thiết lập các thông tin email
        $mail->setFrom('0306211044@caothang.edu.vn', 'Helllo'); // Đặt email người gửi
        $mail->addAddress($email); // Thêm địa chỉ email người nhận
        $mail->isHTML(true); // Đặt định dạng email là HTML
        $mail->Subject = 'Test Email'; // Đặt tiêu đề email
        $mail->Body = 'Mã OTP của bạn là:' . $otp; // Đặt nội dung email

        // Gửi email
        if ($mail->send()) {
            $_SESSION["OTP"]=$otp;
            $response['status'] = 'success';
            $response['message'] = 'Email sent successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }

    // Trả về kết quả dưới dạng JSON
    echo json_encode($response);
}
?>

$(document).ready(function() {
    // Xử lý sự kiện click trên nút "Xác nhận"
    $('#Confirm-invoice').on('click', '.update-status-btn', function() {
        var orderId = $(this).data('order-id');
        var orderStatusId = $(this).data('order-status');
  
        // Gửi yêu cầu AJAX để cập nhật trạng thái của đơn hàng
        $.ajax({
            url: 'admin/api/confirm_invoice.php',
            method: 'POST',
            data: { order_id: orderId, order_status: orderStatusId },
            success: function(response) {
                // Xử lý phản hồi từ server nếu cần
                console.log('Đã cập nhật trạng thái đơn hàng');
                window.location.href="index.php?folder=admin&template=invoice/lst_invoice";
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi cập nhật trạng thái đơn hàng:', error);
            }
        });
    });
  });
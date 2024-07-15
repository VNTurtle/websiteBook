function toggleInvoiceDetail(element) {

    var target = element.dataset.target;
    var detail = document.getElementById(target);

    var codeElement = element.querySelector('.invoice-code');

    detail.classList.toggle("show");
    codeElement.classList.toggle("show");
}

var tabLinks = document.querySelectorAll('.tab-link');
var tabContents = document.querySelectorAll('.tab-content');

// Lặp qua mỗi tab link
tabLinks.forEach(function (tabLink, index) {
    // Gán sự kiện click cho mỗi tab link
    tabLink.addEventListener('click', function () {
        // Xóa lớp active khỏi tất cả các tab link và tab content
        tabLinks.forEach(function (link) {
            link.classList.remove('active');
        });
        tabContents.forEach(function (content) {
            content.classList.remove('active');
        });
        // Thêm lớp active cho tab link được chọn
        this.classList.add('active');
        // Hiển thị tab content tương ứng với tab link được chọn
        tabContents[index].classList.add('active');
    });
});

$(document).ready(function() {
    var modal = $('#cancelModal');
    var span = $('.close');
    var cancelButton;
    
    // Hiển thị modal khi nhấn nút "Hủy đơn"
    $(document).on('click', '.btn-cancel-order', function() {
        cancelButton = $(this);
        modal.show();
    });

    // Đóng modal khi nhấn nút close
    span.on('click', function() {
        modal.hide();
    });

    // Đóng modal khi nhấn bên ngoài modal
    $(window).on('click', function(event) {
        if (event.target.id == 'cancelModal') {
            modal.hide();
        }
    });

    // Xử lý sự kiện xác nhận hủy
    $('#confirmCancel').on('click', function() {
        var reason = $('#cancelReason').val();
        var orderId = cancelButton.data('order-id');

        if (reason.trim() == '') {
            alert('Vui lòng nhập lý do hủy.');
            return;
        }

        $.ajax({
            url: 'API/cance_invoice.php',
            method: 'POST',
            data: { order_id: orderId, reason: reason },
            success: function(response) {
                // Xử lý phản hồi từ server nếu cần
                console.log('Đã hủy đơn hàng');
                // Ẩn đơn hàng đã hủy
                cancelButton.closest('.invoice-detail').remove();
                // Đóng modal
                location.reload()
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi hủy đơn hàng:', error);
            }
        });
    });
});

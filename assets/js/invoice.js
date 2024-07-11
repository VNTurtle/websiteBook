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
    $('.btn-cancel-order').click(function() {
        var orderId = $(this).data('order-id');

        $.ajax({
            url: 'API/cance_invoice.php',
            type: 'POST',
            data: {
                order_status: 5, 
                order_id: orderId
            },
            success: function(response) {
                var res = JSON.parse(response);
                alert(res.message);
                if (res.status === 'success') {
                    location.reload();  // Tải lại trang sau khi cập nhật thành công
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });
});
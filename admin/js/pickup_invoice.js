$(document).ready(function() {
    $('.order_status').change(function() {
        var orderStatusId = $(this).val();
        var orderId = $(this).data('order-id');

        $.ajax({
            url: 'admin/api/update_invoice.php',
            type: 'POST',
            data: {
                order_status: orderStatusId,
                order_id: orderId
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + xhr.responseText);
            }
        });
    });
});
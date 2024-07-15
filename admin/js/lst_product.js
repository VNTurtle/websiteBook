$(document).ready(function () {
    $('.toggle-checkbox').change(function(){
        var bookId = $(this).data('book-id');
        var status = $(this).is(':checked') ? 1 : 0;
        $.ajax({
            url: 'admin/api/update_status_book.php',
            type: 'POST',
            data: {
                id: bookId,
                status: status
            },
            success: function(response) {
                console.log('Status updated successfully');
            },
            error: function(xhr, status, error) {
                console.error('Error updating status:', error);
            }
        });
    });
});
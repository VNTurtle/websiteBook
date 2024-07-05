var CheckModel=document.getElementById('CheckModel');

$(document).ready(function() {
    $('#uploadForm').submit(function(e) {
        e.preventDefault(); // Ngăn chặn form submit mặc định
        
        var formData = new FormData(this);
        var progressBar = $('.progress-bar');
        var progress = $('.progress');
        
        $.ajax({
            url: 'admin/api/add_model_product.php', // Địa chỉ xử lý form PHP
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        progressBar.width(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(data) {
                console.log('Upload thành công');
                $('.message').html('Upload thành công');
                CheckModel.classList.remove('hidden');
            },
            error: function(xhr, status, error) {
                console.error('Lỗi khi tải lên: ', error);
                $('.message').html('Lỗi khi tải lên: ' + error);
            },
            beforeSend: function() {
                progress.show(); // Hiển thị thanh tiến trình trước khi tải lên
            },
            complete: function() {
                progress.hide(); // Ẩn thanh tiến trình khi quá trình tải lên hoàn tất
            }
        });
    });
});

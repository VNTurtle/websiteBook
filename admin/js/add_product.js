
function openForm(formId) {
    var mess = document.getElementById('mess_'+formId);
    // Kiểm tra xem mess có class 'hidden' không
    if (!mess.classList.contains('hidden')) {
        // Nếu không có, thêm class 'hidden'
        mess.classList.add('hidden');
    }
    document.getElementById(formId).style.display = "block";
}

function closeForm(formId) {
    document.getElementById(formId).style.display = "none";
    
}

// Xử lý xem trước hình ảnh
document.getElementById('coverImage').addEventListener('change', previewImages);
document.getElementById('additionalImages').addEventListener('change', previewImages);

function previewImages(event) {
    const imagePreview = document.getElementById('imagePreview');
    imagePreview.innerHTML = '';
    const files = event.target.files;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '150px';
            img.style.margin = '10px';
            imagePreview.appendChild(img);
        }
        
        reader.readAsDataURL(file);
    }
}


function submitForm(formId) {
    var mess = document.getElementById('mess_'+formId);
    console.log(formId);
    var formData = $('#form-' + formId).serialize(); // Lấy dữ liệu từ form
    $.ajax({
        type: 'POST',
        url: 'admin/api/add_'+formId+'.php', // Đường dẫn xử lý form
        data: formData,
        success: function(response) {
            // Xử lý phản hồi từ server
            console.log(response); // Kiểm tra phản hồi từ server trong console
            mess.classList.remove('hidden');
            setTimeout(function() {
                mess.classList.add('hidden');
            }, 2000);   
            // Cập nhật lại danh sách combo trên giao diện nếu có sự thay đổi
            updateList(formId,response); // Hàm này để cập nhật danh sách combo
        },
        error: function(xhr, status, error) {
            // Xử lý lỗi nếu có
            console.error(xhr.responseText);
        }
    });
}

// Hàm để cập nhật lại danh sách combo sau khi thêm mới thành công
function updateList(formId, Data) {
    // Xử lý dữ liệu JSON nhận được từ server
    var newList = JSON.parse(Data);  
    
    var NameForm = "'" + formId + "'";
    // Xóa các option cũ trong select
    var selectList = document.querySelector('select[name='+ NameForm +']');
    selectList.innerHTML = '';

    // Thêm option mới vào select
    newList.forEach(function(List) {
        var option = document.createElement('option');
        option.value = List.Id; // Đây là giá trị cần thay đổi theo cấu trúc dữ liệu trả về từ server
        option.textContent = List.Name; // Tên combo, tùy theo cấu trúc dữ liệu trả về từ server
        selectList.appendChild(option);
    });
}

function add_Product(event) {
    
    event.preventDefault(); // Ngăn chặn form submit mặc định
    var loading = document.getElementById('loading_update');
    var opacity = document.getElementById('opacity');
    opacity.classList.toggle('hidden');
    loading.classList.remove('hidden');

    var formElement = document.getElementById('add_Product');
    var formData = new FormData(formElement);

    $.ajax({
        type: 'POST',
        url: 'admin/api/add_product.php', // Đường dẫn xử lý formId (thay thế 'formId' bằng giá trị thực)
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            console.log(response);
            window.location.href = 'index.php?admin/template=product/product_detail&id='+ response;

        },
        error: function(xhr, status, error) {
            // Xử lý lỗi nếu có
            console.error(xhr.responseText);
            alert('Đã xảy ra lỗi khi lưu dữ liệu!');
        }
    });
}
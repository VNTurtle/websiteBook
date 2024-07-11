$(document).ready(function() {
    function updateTotalPrice(element) {
        var parent = element.closest('.item-book-cart');
        var price = parseFloat(parent.data('price'));
        var quantity = parseInt(parent.find('.prd-quantity').val());
        var totalPriceElement = parent.find('.total-price');
        var totalPrice = price * quantity;
        totalPriceElement.text(totalPrice + '.000đ');
    }

    $('.input-number-product .num-1').on('click', function() {
        var quantityInput = $(this).siblings('.prd-quantity');
        var currentValue = parseInt(quantityInput.val());
        if (currentValue > 1) {
            quantityInput.val(currentValue - 1);
            updateTotalPrice($(this));
        }
    });

    $('.input-number-product .num-2').on('click', function() {
        var quantityInput = $(this).siblings('.prd-quantity');
        var maxStock = parseInt(quantityInput.data('max'));
        var currentValue = parseInt(quantityInput.val());
        if (currentValue < maxStock) {
            quantityInput.val(currentValue + 1);
            updateTotalPrice($(this));
        }
    });

    $('.prd-quantity').on('input', function() {
        var maxStock = parseInt($(this).data('max'));
        var value = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(value);

        var currentValue = parseInt(value);
        if (currentValue > maxStock) {
            $(this).val(maxStock);
        }
        updateTotalPrice($(this));
    });

    $('.prd-quantity').on('blur', function() {
        var currentValue = parseInt($(this).val());
        if (isNaN(currentValue) || currentValue < 1) {
            $(this).val(1);
        }
        updateTotalPrice($(this));
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const checkboxAll = document.getElementById('checkbox-all-products');
    const checkboxes = document.querySelectorAll('.checkbox-add-cart');
    const totalPriceElement = document.getElementById('total-price');

    function updateTotalPrice() {
        let totalPrice = 0;
        const selectedProducts = [];
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                const price2 = parseInt(checkbox.getAttribute('data-price2'));
                const name = checkbox.getAttribute('data-name');
                const img = checkbox.getAttribute('data-img');
                const price = checkbox.getAttribute('data-price');
                const quantity = checkbox.getAttribute('data-quantity');
                
                totalPrice += price2;

                const productId = checkbox.id; // ID của sản phẩm
                selectedProducts.push({
                    id: productId,
                    price: price,
                    price2: price2,
                    name: name,
                    img: img,
                    quantity: quantity
                });
                console.log(selectedProducts);
            }
        });
        totalPriceElement.textContent = totalPrice.toLocaleString('vi-VN') + '.000 đ';

         // Lưu danh sách sản phẩm đã chọn vào Local Storage
        localStorage.setItem('selectedProducts', JSON.stringify(selectedProducts));
    }

    checkboxAll.addEventListener('change', function() {
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = checkboxAll.checked;
        });
        updateTotalPrice();
        // Lưu danh sách sản phẩm đã chọn vào Local Storage
        localStorage.setItem('selectedProducts', JSON.stringify(selectedProducts));
        
        
    });

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            updateTotalPrice();
            if (!checkbox.checked) {
                checkboxAll.checked = false;
            } else {
                const allChecked = Array.from(checkboxes).every(function(cb) {
                    return cb.checked;
                });
                checkboxAll.checked = allChecked;
            }
        });
    });

    updateTotalPrice(); // Cập nhật giá trị ban đầu khi trang được tải
});

// Lắng nghe sự kiện khi nút "Thanh toán" được nhấp vào
var checkoutButton = document.getElementById('checkoutButton');
checkoutButton.addEventListener('click', function() {
    var selectedProducts = localStorage.getItem('selectedProducts');
    // Chuyển hướng đến trang thanh toán và truyền danh sách sản phẩm đã chọn qua tham số URL
    window.location.href = 'index.php?template=checkout/checkout&selectedProducts=' + encodeURIComponent(selectedProducts);
});
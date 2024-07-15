/**
 * Main
 */

'use strict';

let menu, animate;

(function () {
  // Initialize menu
  //-----------------

  let layoutMenuEl = document.querySelectorAll('#layout-menu');
  layoutMenuEl.forEach(function (element) {
    menu = new Menu(element, {
      orientation: 'vertical',
      closeChildren: false
    });
    // Change parameter to true if you want scroll animation
    window.Helpers.scrollToActive((animate = false));
    window.Helpers.mainMenu = menu;
  });

  // Initialize menu togglers and bind click on each
  let menuToggler = document.querySelectorAll('.layout-menu-toggle');
  menuToggler.forEach(item => {
    item.addEventListener('click', event => {
      event.preventDefault();
      window.Helpers.toggleCollapsed();
    });
  });

  // Display menu toggle (layout-menu-toggle) on hover with delay
  let delay = function (elem, callback) {
    let timeout = null;
    elem.onmouseenter = function () {
      // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
      if (!Helpers.isSmallScreen()) {
        timeout = setTimeout(callback, 300);
      } else {
        timeout = setTimeout(callback, 0);
      }
    };

    elem.onmouseleave = function () {
      // Clear any timers set to timeout
      document.querySelector('.layout-menu-toggle').classList.remove('d-block');
      clearTimeout(timeout);
    };
  };
  if (document.getElementById('layout-menu')) {
    delay(document.getElementById('layout-menu'), function () {
      // not for small screen
      if (!Helpers.isSmallScreen()) {
        document.querySelector('.layout-menu-toggle').classList.add('d-block');
      }
    });
  }

  // Display in main menu when menu scrolls
  let menuInnerContainer = document.getElementsByClassName('menu-inner'),
    menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
  if (menuInnerContainer.length > 0 && menuInnerShadow) {
    menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
      if (this.querySelector('.ps__thumb-y').offsetTop) {
        menuInnerShadow.style.display = 'block';
      } else {
        menuInnerShadow.style.display = 'none';
      }
    });
  }

  // Init helpers & misc
  // --------------------

  // Init BS Tooltip
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Accordion active class
  const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
      e.target.closest('.accordion-item').classList.add('active');
    } else {
      e.target.closest('.accordion-item').classList.remove('active');
    }
  };

  const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
  const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
  });

  // Auto update layout based on screen size
  window.Helpers.setAutoUpdate(true);

  // Toggle Password Visibility
  window.Helpers.initPasswordToggle();

  // Speech To Text
  window.Helpers.initSpeechToText();

  // Manage menu expanded/collapsed with templateCustomizer & local storage
  //------------------------------------------------------------------

  // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
  if (window.Helpers.isSmallScreen()) {
    return;
  }

  // If current layout is vertical and current window screen is > small

  // Auto update menu collapsed/expanded based on the themeConfig
  window.Helpers.setCollapsed(true, false);
})();

$(document).ready(function() {
  $('#notification-icon').on('click', function() {
      $('#notification-dropdown').toggle();

      if ($('#notification-dropdown').is(':visible')) {
          $.ajax({
              url: 'admin/api/get_new_invoice.php',
              method: 'GET',
              success: function(response) {
                  var orders = JSON.parse(response);
                  var notificationContent = '';

                  if (orders.length > 0) {
                      orders.forEach(function(order) {
                          notificationContent += '<div class="notification-item" id="notification-item-' + order.invoice_id + '">';
                          notificationContent += '<div class="notification-item">';
                          notificationContent += '<p><strong>Đơn hàng mới:</strong> ' + order.Code + '</p>';
                          notificationContent += '<p>Số hóa đơn con: ' + order.ivd_count + '</p>';
                          notificationContent += '<p>Ngày đặt: ' + order.IssuedDate + '</p>';
                          notificationContent += '<p>Tổng tiền: ' + order.Total + '</p>';
                          notificationContent += '<a href="index.php?folder=admin&template=invoice/invoice_detail&id_invoice=' + order.invoice_id + '" class="btn btn-sm btn-primary" style="margin-right: 20px;">Xem chi tiết</a>';
                          notificationContent += '<button class="btn btn-sm btn-primary update-status-btn" data-order-status="2" data-order-id="' + order.invoice_id + '">Xác nhận</button>';
                          notificationContent += '</div></div>';
                      });
                      $('#notification-content').html(notificationContent);
                  } else {
                      notificationContent = '<p>Không có thông báo mới</p>';
                      $('#notification-content').html(notificationContent);
                  }
              },
              error: function(xhr, status, error) {
                  console.error('Error fetching new orders:', error);
              }
          });
      }
  });

  // Đóng menu khi nhấn bên ngoài
  $(document).on('click', function(event) {
      if (!$(event.target).closest('#notification-icon, #notification-dropdown').length) {
          $('#notification-dropdown').hide();
      }
  });

  // Xử lý sự kiện click trên nút "Xác nhận"
  $('#notification-content').on('click', '.update-status-btn', function() {
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
              // Ẩn thông báo đã xác nhận
              $('#notification-item-' + orderId).remove();
          },
          error: function(xhr, status, error) {
              console.error('Lỗi khi cập nhật trạng thái đơn hàng:', error);
          }
      });
  });
});

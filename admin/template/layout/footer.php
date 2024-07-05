                </div>
              </div>
        </div>
    </div>
  <script src="admin/js/jquery.js"></script>
  
   <script src="admin/js/bst.js"></script>
   <script src="admin/js/menu.js"></script>
   <script src="admin/js/layout.js"></script>
   <?php
// Bao gồm tệp tin JavaScript riêng của từng trang nếu có
if (isset($page)) {
    $pageScript = "admin/js/{$pageName}.js";
    
    if (file_exists($pageScript)) {
        echo '<script src="assets/sclick/js/slick.min.js"></script>';
        echo "<script src='{$pageScript}'></script>";
       
    }
  }
  ?>
</body>
</html>
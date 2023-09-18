<?php
session_start();
require_once '../../db/connect.php';
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username= '$username' AND permission = '1'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) === 1) {
    require_once '../Admin/AdminHeadMenu.php';
?>

<div id="content" style="margin-left: 270px;
    width: 80%;
    padding: 0;">    
    <form class="form-inline mt-3 ml-3">
        <!-- <div class="btn-group mr-3" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio1" id="moban" data-id="0" autocomplete="off">
            <label class="btn btn-outline-primary" for="moban" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Mở Bán</label>

            <input type="radio" class="btn-check" name="btnradio1" id="dukien" data-id="1" autocomplete="off">
            <label class="btn btn-outline-primary" for="dukien" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Dự Kiến</label>

            <input type="radio" class="btn-check" name="btnradio1" id="dukien" data-id="1" autocomplete="off">
            <label class="btn btn-outline-primary" for="dukien" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;"><a href="" style="color: #fff;">Tổng</a></label>
        </div> -->
        <div class="input-group">
            <input class="form-control mr-3 border-end-0 border rounded-pill" type="search"
                id="search-input" placeholder="Search ...">
            <span class="input-group-append">
                <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5"
                    type="button" id="search-btn">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
        <a href="../Admin/Adminnewproduct.php"  type="button" class="ml-3 btn " style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Thêm Mới</a>
    </form>        
  <div class="row">
    <div class="col-md-12  ml-3">         
      <table id=""class="mt-3 table">
        <thead>
          <tr>
            <th scope="col">Mã</th>
            <th scope="col" class="col-2">Tên Sản Phẩm</th>
            <th scope="col">Giá</th>
            <th scope="col">Quantily</th>
            <th scope="col">Image</th>
            <th scope="col">Màu</th>
            <th scope="col">Ngày Tạo</th>
            <th scope="col">Trạng Thái</th>
            <th scope="col">Danh Mục</th>
            <th scope="col">Thao Tác</th>
          </tr>
        </thead>
        <tbody id="listproduct">
                
        </tbody>
      </table>
    </div> 
    <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customModalLabel">Xác Nhận</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="alert alert-danger">
                      <h3>Bạn muốn xóa Sản Phẩm này?</h1>
                      <p>Lưu ý: Bạn sẽ không thể xóa sản phẩm đã có đơn hàng!</p>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" id="confirm-delete-btn" data-bs-dismiss="modal" class="btn btn-success">Đồng Ý</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<?php
    require_once "../Admin/FooterAdmin.php"
?>
<script>
  function view_data(selectedValue,searchValue,categoryId){
      $.post('../../Authentication/Admin/adminlistproduct.php',{ selectedValue: selectedValue, searchValue: searchValue,categoryId}, function(data) {
      $("#listproduct").html(data);
  });
  }
  $(document).ready(function() {
    view_data();
    $(document).ready(function(){
        $('#tableSP').DataTable();
    });
    //radio
    $("input[name='btnradio1']").on("change", function() {
    var selectedValue = $(this).data("id");
    var searchValue = $("#search-input").val();
    view_data(selectedValue, searchValue); 
    });
    $("#search-btn").click(function(event) {
        event.preventDefault();
        var selectedValue = $("input[name='btnradio1']:checked").data("id");
        var searchValue = $("#search-input").val();
        view_data(selectedValue, searchValue);
    });
    //slider
    const slider = document.getElementById('slider');
    slider.addEventListener('input', function() {
        var selectedValue = $("input[name='btnradio1']:checked").data("id");
        var searchValue = $("#search-input").val();
        view_data(selectedValue, searchValue);
    });
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        $('#customModal').modal('show'); // Hiển thị hộp thoại xác nhận
        $('#confirm-delete-btn').click(function() {
            var requestData = {
                'id': id,
            };
            $.ajax({
                method: "POST",
                url: "../../Authentication/Admin/deleteproduct.php",
                data: requestData,
                success: function(response) {
                    view_data();
                }
            });
        });
    });
});

</script>
<?php
    } else {
        header('Location: ../../../Home.php');
        exit();
    }
} else {
    header('Location: ../../../LoginAndRegister.php');
    exit();
}
?>

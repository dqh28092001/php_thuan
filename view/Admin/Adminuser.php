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
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1"  data-id="1" autocomplete="off" >
            <label class="btn btn-outline-primary" for="btnradio1" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Quản Trị Viên</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2"  data-id="0"autocomplete="off">
            <label class="btn btn-outline-primary" for="btnradio2" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Khách Hàng</label>
        </div> -->
        <!-- <div class="input-group">
          <input class="form-control mr-3 border-end-0 border rounded-pill" type="search"
              id="search-input" placeholder="Search ...">
          <span class="input-group-append">
              <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5"
                  type="button" id="search-btn">
                  <i class="fa fa-search"></i>
              </button>
          </span>
        </div> -->
    </form>
  <div class="row">
    <div class="col-md-12  ml-3">         
      <table class="mt-3 table">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Tài Khoản</th>
            <th scope="col">Họ Tên</th>
            <th scope="col">Email</th>
            <th scope="col">Phân Quyền</th>
            <th scope="col">Ảnh Đại Diện</th>
            <th scope="col">Ngày Tạo</th>
            <th scope="col">Thao Tác</th>
          </tr>
        </thead>
        <tbody id="listuser">
                
        </tbody>
      </table>
    </div> 
  </div>
  <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customModalLabel" >Chỉnh Sửa Quyền</h5>
            </div>
            <div class="modal-body">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="permission" id="adminPermission" value="1">
                    <label class="form-check-label" for="adminPermission" >Quản trị viên</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="permission" id="customerPermission" value="0">
                    <label class="form-check-label" for="customerPermission">Khách hàng</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" id="confirm-permission-btn" data-dismiss="modal" class="btn btn-success">Đồng Ý</button>
            </div>
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
  function view_data(selectedValue, searchValue) {
    $.post('../../Authentication/Admin/adminlistuser.php', { selectedValue: selectedValue, searchValue: searchValue }, function(data) {
        $("#listuser").html(data);
    });
}

$(document).ready(function() {
    view_data(); //Tải ban đầu không có giá trị được chọn và giá trị tìm kiếm

  $(document).on("click", ".edit-btn", function() {
    var username = $(this).data("username");
    $("#confirm-permission-btn").off("click").on("click", function() {
      var permission = $("input[name='permission']:checked").val();
        if (permission === undefined) {
            Swal.fire({
                title: 'Lỗi',
                text: 'Vui lòng chọn một Quyền',
                icon: 'error',
                confirmButtonText: 'Đóng'
            });
            return;
        }
      $.ajax({
        url: '../../Authentication/Admin/adminedituser.php',
        type: 'POST',
        data: {
          username: username, 
          permission: permission
        },
        success: function(response) {
            if (response ==200) {
                Swal.fire({
                    title: 'Thành công',
                    text: "Thay Đổi Quyền Thành Công",
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                   window.location.href = '../Admin/Adminuser.php';
                }); 
            } else {
                console.log(response);
                Swal.fire({
                    title: 'Lỗi',
                    text: response,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
      });
    });
  });
});
</script>
<?php
    } else {
        header('Location: ../../../index.php');
        exit();
    }
} else {
    header('Location: ../../../LoginAndRegister.php');
    exit();
}
?>

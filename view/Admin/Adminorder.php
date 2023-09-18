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

<div id="content" style="margin-left: 270px;width: 80%;padding: 0;">
  <form class="form-inline mt-3 ml-3">
      <div class="btn-group mr-3" role="group" aria-label="Basic radio toggle button group">
          <!-- Nhóm thứ nhất -->
          <input type="radio" class="btn-check" name="btnradio1" id="ad0" data-id="ad0" autocomplete="off">
          <label class="btn btn-outline-primary" for="ad0" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Chưa Phê Duyệt</label>

          <input type="radio" class="btn-check" name="btnradio1" id="ad1" data-id="ad1" autocomplete="off">
          <label class="btn btn-outline-primary" for="ad1" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Đã Phê Duyệt</label>

          <input type="radio" class="btn-check" name="btnradio1" id="ad2" data-id="ad2" autocomplete="off">
          <label class="btn btn-outline-primary" for="ad2" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Đã Hủy</label>

          <input type="radio" class="btn-check" name="btnradio1" id="od1" data-id="od1" autocomplete="off">
          <label class="btn btn-outline-primary" for="od1" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Thành Công</label>
      </div>
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
  </form>
  <div class="row">
    <div class="col-md-12">
      <table class="ml-3 mt-3 table">
        <thead>
          <tr>
            <th scope="col">Mã</th>
            <th scope="col">Username</th>
            <th scope="col">Payment method</th>
            <th scope="col">Ngày Mua</th>
            <th scope="col">Trạng Thái</th>
            <th scope="col">Thao Tác</th>
          </tr>
        </thead>
        <tbody id="listorder"></tbody>
      </table>
    </div>
  </div>
</div>
<?php
    require_once "../Admin/FooterAdmin.php"
?>
<script>
  function view_data(selectedValue, searchValue) {
    $.post('../../Authentication/Admin/adminlistorder.php',{ selectedValue: selectedValue, searchValue: searchValue }, function(data) {
      $("#listorder").html(data);
    });
  }
  $(document).ready(function() {
  view_data();
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

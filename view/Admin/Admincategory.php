<?php
session_start();
require_once '../../db/connect.php';
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM users WHERE username= '$username' AND permission = '1'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        require_once '../Admin/AdminHeadMenu.php';
?>

        <div id="content" style="margin-left: 270px; width: 100%; padding: 0;margin-top: 4pc;">
            <form class="form-inline mt-3 ml-3">
                <!-- <div class="btn-group mr-3" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" data-id="1" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio1" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Dự Kiến</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" data-id="0" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio2" style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Mở Bán</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" data-id="0" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio3" style="background: #d98585;
    margin-right: 10px;
    border-radius: 8px;
    border: none;"><a href="" style="color:#fff;text-decoration:none;font-family: initial;">Tổng</a></label>

                </div> -->
                <div class="input-group">
                    <input class="form-control mr-3 border-end-0 border rounded-pill" type="search" id="search-input" placeholder="Search ...">
                    <span class="input-group-append">
                        <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button" id="search-btn">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <div>
                    <div class="col-md-2 ml-3">
                        <a href="../Admin/Adminnewcategory.php" class="ml-3 btn " style="background: #d98585;
    color: #fff;
    margin-right: 10px;
    border-radius: 8px;
    font-family: initial;
    border: none;">Thêm Mới</a>
                    </div>
                </div>
            </form>
            <div class="row ml-3">
                <div class="col-md-9">
                    <table id="" class="ml-3 mt-3 table">
                        <thead>
                            <tr>
                                <th scope="col">Mã</th>
                                <th scope="col">Tên Danh Mục</th>
                                <th scope="col">Thương Hiệu</th>
                                <th scope="col">Ngày Tạo</th>
                                <th scope="col">Trạng Thái</th>
                                <th scope="col">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody id="listcategory">

                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customoMdalLabel" aria-hidden="true">
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
                                    <h3>Bạn muốn xóa Danh Mục này?</h1>
                                        <p>Lưu ý: Bạn sẽ không thể xóa danh mục chứa sản phẩm!</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cancel" data-bs-dismiss="modal">Hủy</button>
                                <button type="button" id="confirm-delete-btn" data-bs-dismiss="modal" class="btn btn-success">Đồng Ý</button>
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
            $(document).ready(function() {
                // Đây là một hàm JavaScript được sử dụng để gửi yêu cầu AJAX 
                // đến máy chủ để lấy dữ liệu và cập nhật nội dung trang web mà không cần tải lại toàn bộ trang.
                view_data();

                // List sản phẩm ra  
                function view_data(searchValue) { //tham số
                    $.post('../../Authentication/Admin/adminlistcategory.php', {
                        // tham số được gửi đến tệp PHP thông qua yêu cầu POST.
                        searchValue: searchValue
                    }, function(data) {
                        $("#listcategory").html(data);
                    });
                }
                $("input[name='btnradio']").on("change", function() {
                    var searchValue = $("#search-input").val();
                    //   kích hoạtview_data với giá trị bộ lọc đã chọn và giá trị đầu vào tìm kiếm.
                    view_data(searchValue);
                });

                //  Search sản phẩm
                $("#search-btn").click(function(event) {
                    event.preventDefault();
                    var searchValue = $("#search-input").val();
                    view_data(searchValue);
                });
                $(document).on('click', '.delete-btn', function() {
                    var id = $(this).data('id');
                    $('#customModal').modal('show');
                    $('#confirm-delete-btn').click(function() {
                        var requestData = {
                            'id': id,
                        };
                        $.ajax({
                            method: "POST",
                            url: "../../Authentication/Admin/deletecategory.php",
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
        header('Location:../../../../Views/Home.php');
        exit();
    }
} else {
    header('Location: ../../../../Views/LoginAndRegister.php');
    exit();
}
?>
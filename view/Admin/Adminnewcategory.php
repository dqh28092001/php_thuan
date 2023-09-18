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
    width: 100%;
    padding: 0;">
            <div class="row mt-3 justify-content-center">
                <div class="col-8  rounded border">
                    <h1 class="text-center mb-4">Thêm mới Danh Mục</h1>
                    <form id="formnewcategory">
                        <div class="form-group">
                            <label for="tendanhmuc">Tên Danh Mục</label>
                            <label class="text-warning ml-3" id="ertendanhmuc"> </label>
                            <input type="text" class="form-control" id="tendanhmuc">
                        </div>
                        <div class="form-group">
                            <label for="thuonghieu">Thương Hiệu</label>
                            <label class="text-warning ml-3" id="erthuonghieu"> </label>
                            <input type="text" class="form-control" id="thuonghieu">
                        </div>
                        <div class="form-group">
                            <label for="ngaytao">Ngày Tạo</label>
                            <input type="text" class="form-control" id="ngaytao" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Trạng Thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="trangthai" value="0" checked>
                                <label class="form-check-label ml-2" for="mo-ban">
                                    Mở Bán
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="trangthai" value="1">
                                <label class="form-check-label ml-2" for="du-kien">
                                    Dự Kiến
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-primary text-white mb-3 mr-5" href="../Admin/Admincategory.php">Trở Về</a>
                            <button type="submit" id="themmoi" class="btn btn-success mb-3">Thêm Mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        require_once "../Admin/FooterAdmin.php"
        ?>
        <script>
            $(document).ready(function() {
                $("#formnewcategory").submit(function(event) {
                    event.preventDefault(); // Ngăn chặn gửi form thông qua trình duyệt
                    var tendanhmuc = $('#tendanhmuc').val();
                    var thuonghieu = $('#thuonghieu').val();
                    var ngaytao = $('#ngaytao').val();
                    // checkedtính. Điều này thường được sử dụng cho các nút radio hoặc hộp kiểm để chọn hộp kiểm hiện đang được chọn.
                    var trangthai = $('input[name="trangthai"]:checked').val();

                    if (trangthai === undefined) {
                        // thư viện SweetAlert
                        Swal.fire({
                            title: 'Lỗi',
                            text: 'Vui lòng chọn một trạng thái',
                            icon: 'error',
                            confirmButtonText: 'Đóng'
                        });
                        return;
                    }
                    $.ajax({
                        url: '../../Authentication/Admin/addnewcategory.php',
                        type: 'POST',
                        data: {
                            tendanhmuc: tendanhmuc,
                            thuonghieu: thuonghieu,
                            ngaytao: ngaytao,
                            trangthai: trangthai
                        },
                        success: function(response) {
                            if (response == "true") {
                                window.location.href = '../Admin/Admincategory.php';
                            } else if (response == "nulltendanhmuc") {
                                $("#ertendanhmuc").html("Vui lòng nhập tên danh mục!");
                            } else if (response == "nullthuonghieu") {
                                $("#erthuonghieu").html("Vui lòng nhập thương hiệu!");
                            } else {
                                Swal.fire({
                                    title: 'Lỗi',
                                    text: response,
                                    icon: 'error',
                                    confirmButtonText: 'Đóng'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Lỗi',
                                text: 'Có lỗi xảy ra. Vui lòng thử lại sau.',
                                icon: 'error',
                                confirmButtonText: 'Đóng'
                            });
                        }
                    });
                });
            });
        </script>
        </body>

        </html>
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
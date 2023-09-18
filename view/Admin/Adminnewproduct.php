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
    <div class="row justify-content-center">
        <div class="col-8 mt-3 rounded border mb-4">
            <h1 class="text-center mb-4">Thêm mới Sản Phẩm</h1>
            <form id="formnewproduct">
                <div class="form-group">
                    <label>Danh Mục</label>
                    <?php 
                    require_once '../../db/connect.php';
                    $sql = "SELECT * FROM category";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {                     
                    ?>
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Chọn danh mục</a>
                        <ul class="dropdown-menu md-2">
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id']; // Lấy id của danh mục
                                $name = $row['name']; // Lấy tên của danh mục
                            ?>
                            <li><a class="dropdown-item" href="#" data-category-id="<?php echo $id; ?>"><?php echo $name; ?></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label>Tên Sản Phẩm</label>
                    <label class="text-warning" id="ername"></label>
                    <input type="text" class="form-control" id="tensanpham">
                </div>
                <div class="form-group">
                    <label>Giá (USD)</label>
                    <label class="text-warning" id="ergia"></label>
                    <input type="text" class="form-control" id="gia">
                </div>
                <div class="form-group">
                    <label>Số Lượng</label>
                    <label class="text-warning" id="ersoluong"></label>
                    <input type="text" class="form-control" id="soluong">
                </div>
                <div class="form-group">
                    <label>Hình Ảnh</label>
                    <input type="file" id="anh" class="form-control-file">
                </div>
                <div class="form-group">
                    <label>Mô Tả</label>
                    <label class="text-warning" id="ermota"></label>
                    <textarea id="mota" cols="90" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Màu</label>
                    <label class="text-warning" id="ermau"></label>
                    <input type="text" class="form-control" id="mau">
                </div>
                <div class="form-group">
                    <label>Ngày Tạo</label>
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
                    <a class="btn btn-primary text-white mb-3 mr-5" href="../Admin/Adminproduct.php">Trở Về</a>
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
    var selectedCategoryId;
    $(document).on('click', '.dropdown-item', function() {
        selectedCategoryId = $(this).data('category-id');
        var selectedName = $(this).text();
        $('.dropdown-toggle').text(selectedName);
    });
    $('input[id="gia"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    }); 
    $('input[id="soluong"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    $("#formnewproduct").submit(function(event) {
        event.preventDefault();
        if (selectedCategoryId === undefined) {
            Swal.fire({
                title: 'Lỗi',
                text: 'Vui lòng chọn Danh Mục.',
                icon: 'error',
                confirmButtonText: 'Đóng'
            });
            return;
        }
        var formData = new FormData(); 
        formData.append('madanhmuc', selectedCategoryId);
        formData.append('tensanpham', $('#tensanpham').val());
        formData.append('gia', $('#gia').val());
        formData.append('soluong', $('#soluong').val());
        formData.append('anh', $('#anh')[0].files[0]);
        formData.append('mota', $('#mota').val());
        formData.append('mau', $('#mau').val());
        formData.append('ngaytao', new Date().toISOString());
        formData.append('trangthai', $('input[name="trangthai"]:checked').val());

        $.ajax({
            url: '../../Authentication/Admin/addnewproduct.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
                success: function(response) {
                if (response == 200) {
                    window.location.href = '../Admin/Adminproduct.php';
                }else if(response=="nullname"){
                    $("#ername").html("Vui lòng nhập tên");
                }else if(response=="nullgia"){
                    $("#ergia").html("Vui lòng nhập giá tiền");
                }else if(response=="nullsoluong"){
                    $("#ersoluong").html("Vui lòng nhập số lượng");
                }else if(response=="nullmota"){
                    $("#ermota").html("Vui lòng nhập mô tả");
                }else if(response=="nullmau"){
                    $("#ermau").html("Vui lòng nhập màu");
                }else {
                    console.log(response)
                    Swal.fire({
                        title: 'Lỗi',
                        text: response,
                        icon: 'error',
                        confirmButtonText: 'OK'
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

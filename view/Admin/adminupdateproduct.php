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
        <div class="col-8 rounded border mb-3">
            <h1 class="text-center mb-4">Sửa Thông Tin Sản Phẩm</h1>
            <form id="formupdateproduct" class="showinfo">
                
            </form>
        </div>
    </div>
</div>
<?php
    require_once "../Admin/FooterAdmin.php"
?>
<script>
    var url = window.location.href;
    var match = url.match(/[?&]id=(\d+)/);
    var id = match ? match[1] : null;

    function view_data() {
        $.post('../../Authentication/Admin/showinfoproduct.php', { id: id }, function(data) {
            $(".showinfo").html(data);
        });
    }

    $(document).ready(function() {
        view_data();

        $("#formupdateproduct").submit(function(event) {
            event.preventDefault();
            var selectedCategoryId = $("#tendanhmuc").val();
            var formData = new FormData();
            formData.append('id', id);
            formData.append('madanhmuc', selectedCategoryId);
            formData.append('tensanpham', $('#tensanpham').val());
            formData.append('gia', $('#gia').val());
            formData.append('soluong', $('#soluong').val());
            formData.append('anh', $('#anh')[0].files[0]);
            formData.append('anhcu', $('#anhcu').val());
            formData.append('mota', $('#mota').val());
            formData.append('mau', $('#mau').val());
            formData.append('ngayupdate', new Date().toISOString());
            formData.append('trangthai', $('input[name="trangthai"]:checked').val());
            $.ajax({
                url: '../../Authentication/Admin/updateproduct.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response === "200") {
                        window.location.href = '../Admin/Adminproduct.php';
                    }else if(response=="nullname"){
                        $("#ername").html(" Vui lòng nhập tên");
                    }else if(response=="nullgia"){
                        $("#ergia").html(" Vui lòng nhập giá tiền");
                    }else if(response=="amgia"){
                        $("#ergia").html(" Vui nhập số lớn hơn 0");
                    }else if(response=="ergia"){
                        $("#ergia").html(" Vui lòng nhập số");
                    }else if(response=="nullsoluong"){
                        $("#ersoluong").html(" Vui lòng nhập số lượng");
                    }else if(response=="ersoluong"){
                        $("#ersoluong").html(" Vui lòng nhập số");
                    }else if(response=="amsoluong"){
                        $("#ersoluong").html(" Vui lòng nhập số lớn hơn 0");
                    }else if(response=="nullmota"){
                        $("#ermota").html(" Vui lòng nhập mô tả");
                    }else if(response=="nullmau"){
                        $("#ermau").html(" Vui lòng nhập màu");
                    }else  {
                        Swal.fire({
                            title: 'Lỗi',
                            text: response,
                            icon: 'error',
                            confirmButtonText: 'Đóng'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
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

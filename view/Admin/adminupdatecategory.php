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
        <div class="col-8 rounded border">
            <h1 class="text-center mb-4">Sửa Danh Mục</h1>
            <form id="formupdatecategory" class="showinfo">
                
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

    function view_data(){     
        $.post('../../Authentication/Admin/showinforcategory.php', { id: id }, function(data) {
            $(".showinfo").html(data);
        });
    }
    $(document).ready(function() {
        view_data();
        $("#formupdatecategory").submit(function(event) {
            event.preventDefault();
            var tendanhmuc = $('#tendanhmuc').val();
            var thuonghieu = $('#thuonghieu').val();
            var ngaytao = $('#ngaytao').val();
            var trangthai = $('input[name="trangthai"]:checked').val();
            $.ajax({
                url: '../../Authentication/Admin/updatecategory.php',
                type: 'POST',
                data: {
                    tendanhmuc: tendanhmuc,
                    thuonghieu: thuonghieu,
                    ngaytao: ngaytao,
                    trangthai: trangthai,
                    id: id
                },
                success: function(response ) {
                    console.log(response)
                    if (response === "true") {
                        window.location.href = '../Admin/Admincategory.php';
                    }else if(response=="nullname"){
                        $("#ertendanhmuc").html(" Vui lòng nhập Tên Danh Mục");
                    }else if(response=="nullthuonghieu"){
                        $("#erthuonghieu").html("Vui lòng nhập thương hiệu");
                    }else {
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

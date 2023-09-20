<?php
    session_start();
    if(isset($_SESSION["username"])){ 
    $username = $_SESSION["username"];

    require_once '../View/header.php';
?>
   <div class="container mt-3">
        <h2 class="text-success">Quản Lí Đơn Hàng</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col" class="col-md-2">Ngày Order</th>
                    <th scope="col" class="col-md-3">Tên người nhận</th>
                    <th scope="col">Tổng</th>
                    <th scope="col" class="col-md-2">Thanh Toán</th>
                    <th scope="col" class="col-md-2">Trạng thái</th>
                    <th scope="col" class="col-md-3">Thao tác</th>
                </tr>
            </thead>
            <tbody id="listuseroder">

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
                      <h3 style="    font-size: 25px;">Bạn muốn Hủy Đơn Hàng Này?</h1>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-delete-btn" data-bs-dismiss="modal" class="btn btn-success">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    function view_data() {
        $.post('../Authentication/listuseroder.php', function(data) {
            $("#listuseroder").html(data);
        });
    }
    $(document).ready(function() {
        view_data();   
        $(document).on('click', '.cancel-btn', function() {
            var id = $(this).data('id');
            $('#customModal').modal('show');
            $('#confirm-delete-btn').click(function() {
                var action = "delete"; 
                $.ajax({
                    url: '../Authentication/approve_or_delete_order.php',
                    type: 'POST',
                    data: {id: id, action: action}, 
                    success: function(response) {
                        if (response === "Hủy Đơn Hàng Thành Công") {
                            Toastify({
                                text: "Hủy Đơn Hàng Thành Công",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top", 
                                position: "right", 
                                stopOnFocus: true, 
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                onClick: function () { } 
                            }).showToast();
                            view_data();                          
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
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });    
        });
    });

</script>

<?php
    require_once '../View/Footer.php';
?>
<?php
 }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ASHION</title>

    <link rel="stylesheet" href="../Public/css/templatemo.css">
    <link rel="stylesheet" href="../Public/css/bootstrapmin.css">
    <!-- <link rel="stylesheet" href="../Public/css/style.css"> -->
    <link rel="stylesheet" href="../Public/css/icon.css">
    <link rel="stylesheet" href="../Public/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="../Public/css/toastyfi.css">
    <link rel="stylesheet" href="../Public/css/usercss.css">
    <link rel="stylesheet" href="../Public/css/cdn.jsdelivr.net_npm_sweetalert2@11.1.5_dist_sweetalert2.min.css">
    <link rel="stylesheet" href="../display/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../display/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../display/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../display/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="../display/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="../display/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../display/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../display/css/style.css" type="text/css">

    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        .activecustom {
            background-color: pink;
            color: #000;
        }
    </style>

</head>
<!-- Header -->

<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand text-success logo h2 align-self-center" href="../view/index.php?page=1">
            <img src="../display/img/logo.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#templatemo_main_nav" aria-controls="templatemo_main_nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../view/index.php?page=1">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Categories
                        </a>
                        <div class="dropdown-menu" aria-labelledby="categoriesDropdown">
                            <?php
                            require_once '../db/connect.php';
                            $sql = "SELECT * FROM category WHERE status = 0";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $name = $row['name'];
                                $id = $row['id'];
                            ?>
                                <a class="dropdown-item idcategory" href="../View/Category.php?idcategory=<?php echo $id; ?>"><?php echo $name; ?></a>
                            <?php
                            }
                            ?>
                        </div>
                    </li>
                    <li class="nav-item">
                        <form class="form-inline" onsubmit="return false;">
                            <div class="input-group">
                                <input class="form-control mr-3 border-end-0 border rounded-pill" type="search" id="search-input" placeholder="Search ...">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="submit" id="search-btn">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">
                <?php if (isset($_SESSION['username'])) {
                    require_once '../db/connect.php';
                    $username = $_SESSION['username'];
                    $sql = "SELECT COUNT(*) AS cartItemCount FROM cart WHERE username = '$username'";
                    $result = mysqli_query($conn, $sql);
                    $cartItemCount = 0;
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $cartItemCount = $row['cartItemCount'];
                    }
                ?>
                    <a class="nav-icon position-relative text-decoration-none" href="../View/Cart.php">
                        <i class="fa fa-fw fa-cart-arrow-down mr-1"></i>
                        <?php if ($cartItemCount > 0) : ?>
                            <span class="badge badge-danger position-absolute rounded-circle"><?= $cartItemCount ?></span>
                        <?php endif; ?>
                    </a>
                <?php } else { ?>
                    <a class="nav-icon position-relative text-decoration-none" href="../View/LoginAndRegister/LoginAndRegister.php">
                        <i class="fa fa-fw fa-cart-arrow-down mr-1"></i>
                    </a>
                <?php } ?>
                <div class="dropdown">
                    <?php if (isset($_SESSION['username'])) {
                        require_once '../db/connect.php';
                        $username = $_SESSION['username'];
                        $sql = "SELECT image,permission FROM users WHERE username='$username'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $image = $row["image"];
                        $permission = $row["permission"];
                        if (empty($image)) {
                            $image = 'pngtree-businessman-user-avatar-free-vector-png-image_1538405.jpg';
                        }
                    ?>
                        <a class="nav-link" href="#" role="button" id="userDropdown" data-toggle="dropdown" aria-expanded="false">
                            <div class="avatar">
                                <img src="../Public/img/<?php echo $image; ?>" alt="User Avatar" style="max-width: 50px; max-height: 50px;" class="rounded-circle">
                            </div>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li class="dropdown-item"><b><?php echo $_SESSION['username']; ?></b></li>

                            <li><a class="dropdown-item" href="../view/Editprofile.php">Chỉnh Sửa Tài Khoản</a></li>
                            <li><a class="dropdown-item" href="../View/UserListOder.php">Quản Lí Đơn Hàng</a></li>
                            <li><a class="dropdown-item" href="../Authentication/LoginAndRegister/logout.php">Đăng xuất</a></li>

                        </ul>
                    <?php } else { ?>
                        <a class="dropdown-item" href="../View/LoginAndRegister/LoginAndRegister.php">Đăng Nhập</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</nav>
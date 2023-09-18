<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'],"/")+1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> ADMIN | Ashion</title>
    <!-- <link rel="apple-touch-icon" href="../../Public/img/apple-icon.png"> -->
    <!-- <link rel="shortcut icon" type="image/x-icon" href="../../Public/img/icon.png"> -->
    <link rel="stylesheet" href="../../Public/css/templatemo.css">
    <link href="../../Public/css/cdn.jsdelivr.net_npm_bootstrap@5.3.0_dist_css_bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../../Public/css/stackpath.bootstrapcdn.com_font-awesome_4.7.0_css_font-awesome.min.css">
    <link rel="stylesheet" href="../accest/css/style.css">
    <link href="../../Public/css/fonts.googleapis.com_css_family=Poppins_300,400,500,600,700,800,900.css" rel="stylesheet">
    <link rel="stylesheet" href="../../Public/css/fontawesome.min.css">
    <link rel="stylesheet" href="../../public/css/maxcdn.bootstrapcdn.com_bootstrap_4.0.0_css_bootstrap.min.css">
    <link rel="stylesheet" href="../../Public/css/cdn.jsdelivr.net_npm_sweetalert2@11.1.5_dist_sweetalert2.min.css">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css"> -->
</head>

<!-- Header -->
<body>
    <header class="header" style="position:fixed;top:
    0;width:100%;
    z-index:9;display:flex; justify-content: space-between; padding: 0 50px; height: 50px; align-items: center; background: #d98585;">
        <div class="logo">
            <h2 style="color:white;">Ashion</h2>
        </div>
        <div class="menu">
            <?php
                if(isset($_SESSION['username'])){
                    require_once '../../db/connect.php';
                    $username = $_SESSION['username'];
                    $sql = "SELECT image FROM users WHERE username='$username'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $image = $row["image"];    
                    if(empty($image)) {
                        $image = 'default-avatar.png';
                    }
                ?>
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../../Public/img/<?php echo $image;?>"  style="max-width: 50px; max-height: 40px;" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li class="dropdown-item"><b><?php echo $_SESSION['username']; ?></b></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../../view/Admin/Admincategory.php">Trang Chủ</a></li>
                            <li><a class="dropdown-item" href="../../Authentication/LoginAndRegister/logout.php">Đăng xuất</a></li>
                        </ul>
                    </li>
                 </ul>
            <?php
            }
            ?>           
        </div>
    </header>
    <div class="wrapper d-flex  align-items-stretch" style="margin-top: 50px;">
        <nav id="sidebar" style="height: 100vh;
    position: fixed;
    top: 50px;
    width: 15pc;
    bottom: 0;
    z-index: 2;
    background: #d98585; ">
            <div class="p-4">
                <ul class="list-unstyled components mb-5">
                    <li <?php if ($page == "Admincategory.php" or $page == "Adminnewcategory.php" or $page == "adminupdatecategory.php") echo 'class="active"'; ?>>
                        <a href="../Admin/Admincategory.php" style="display:flex;text-decoration: none;margin-top: 2pc;"><span class="fa fa-home mr-3" style="font-size: 22px;
    color: #fff;
    font-weight: 600;"></span><p style="color:#fff">Category</p></a>
                    </li>
                    <li <?php if ($page == "Adminproduct.php"  or $page == "Adminnewproduct.php" or $page == "adminupdateproduct.php") echo 'class="active"'; ?>>
                        <a href="../Admin/Adminproduct.php" style="display:flex;text-decoration: none;margin-top: 2pc;"><span class="fa fa-sticky-note mr-3" style="font-size: 22px;
    color: #fff;
    font-weight: 600;"></span ><p style="color:#fff">Product</p></a>
                    </li>
                    <li <?php if ($page == "Adminorder.php" or $page == "admin_show_detail_oder.php") echo 'class="active"'; ?>>
                        <a href="../Admin/Adminorder.php" style="display:flex;text-decoration: none;margin-top: 2pc;"><span class="fa fa-briefcase mr-3" style="font-size: 22px;
    color: #fff;
    font-weight: 600;"></span ><p style="color:#fff">Order</p></a>
                    </li>
                    <li <?php if ($page == "Adminuser.php") echo 'class="active"'; ?>>
                        <a href="../Admin/Adminuser.php" style="display:flex;text-decoration: none;margin-top: 2pc;"><span class="fa fa-user ml-1 mr-3" style="font-size: 22px;
    color: #fff;
    font-weight: 600;"></span ><p style="color:#fff">User</p></a>
                    </li>
                </ul>
            </div>
        </nav>
    <div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

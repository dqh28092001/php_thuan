<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="../Public/img/icon.png"> -->
    <title>Login And Register</title>
    <link rel="stylesheet" href="../../Public/css/logincss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>
    <h2>WELCOME TO ASHION</h2>
    <!-- Đăng Kí -->
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form id="signupForm">
                <h1>Create Account</h1>
                <div id="result" style="color:red; font-size:small"></div>
                <input name="username" id="username" type="text" placeholder="Name" />
                <div id="usernamecheck" style="color:red; font-size:small" class=""> </div>
                <input name="email" id="email" type="email" placeholder="Email" />
                <div id="emailcheck" style="color:red; font-size:small"> </div>
                <input name="password" id="password" type="password" placeholder="Password" />
                <div id="passwordcheck" style="color:red; font-size:small"> </div>
                <input name="rpassword" id="rpassword" type="password" placeholder="Nhập lại Password" />
                <div id="rpasswordcheck" style="color:red; font-size:small"> </div>
                <button type="submit" id="signupButton" name="signup">Sign Up</button>
            </form>
        </div>

        <!-- Đăng Nhập -->
        <div class="form-container sign-in-container">
            <form id="signinForm">
                <h1>Sign in</h1>
                <div class="social-container">
                </div>
                <div id="logcheck" style="color:red; font-size:small"> </div>
                <input name="usernamelog" id="usernamelog" type="text" placeholder="Username" />
                <input name="passwordlog" id="passwordlog" type="password" placeholder="Password" />
                <a href="../../view/LoginAndRegister/Forgot_Password.php">Forgot your password?</a>
                <button type="submit" id="signinButton" name="signin">Sign In</button>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>If you don't have an account, register here</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>


    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');
    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });

    $(document).ready(function() {
        $("#username").blur(function() {
            var username = $(this).val();
            $.get("../../Authentication/LoginAndRegister/register.php", {
                username: username
            }, function(data) {
                $("#usernamecheck").html(data);
            });
        });

        $("#email").blur(function() {
            var email = $(this).val();
            $.get("../../Authentication/LoginAndRegister/register.php", {
                email: email
            }, function(data) {
                $("#emailcheck").html(data);
            });
        });

        // Đăng kí Register
        const signupForm = document.getElementById('signupForm');
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn chặn sự kiện mặc định của form

            // Lấy dữ liệu từ form
            const username = document.getElementById('username').value; // .value để lấy giá trị của phần tử đó
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const rpassword = document.getElementById('rpassword').value;

            // Sử dụng AJAX để gửi dữ liệu đăng ký đến máy chủ
            $.ajax({
                type: "POST",
                url: "../../Authentication/LoginAndRegister/register.php",
                data: { // data là dữ liệu gửi đến máy chủ
                    username: username,
                    email: email,
                    password: password,
                    rpassword: rpassword
                },
                dataType: "json", // Loại dữ liệu trả về từ máy chủ
                success: function(response) {
                    // response chứa thông tin phản hồi từ máy chủ sau khi gửi một yêu cầu
                    if (response.success) {
                        window.location.href = '../../view/LoginAndRegister/vertifi.php?username=' + response.username;
                    } else {
                        $('#result').text(response.message);
                    }
                },
                error: function() {
                    $('#result').text('Đã xảy ra lỗi trong quá trình yêu cầu AJAX.');
                }
            });
        });

        // login
        $("#signinForm").submit(function(e) {
            e.preventDefault(); // Ngăn chặn sự kiện mặc định của form

            // Lấy dữ liệu từ form
            var usernamelog = $("#usernamelog").val(); // .value để lấy giá trị của phần tử đó
            var passwordlog = $("#passwordlog").val();
            // Sử dụng AJAX để gửi dữ liệu đăng ký đến máy chủ
            $.ajax({
                type: "POST",
                url: "../../Authentication/LoginAndRegister/login.php",
                data: { // data là dữ liệu gửi đến máy chủ
                    usernamelog: usernamelog,
                    passwordlog: passwordlog,
                },
                dataType: 'json',
                success: function(response) {
                    if (response.message === 'user') {
                        window.location.href = '../../view/index.php?page=1';
                    } else if (response.message === 'admin') {
                        window.location.href = '../../view/Admin/Admincategory.php';
                    } else
                        $('#logcheck').text(response.message);
                },
                error: function() {
                    $('#logcheck').text('Đã xảy ra lỗi trong quá trình yêu cầu AJAX.');
                }
            });
        });
    });
</script>

</html>
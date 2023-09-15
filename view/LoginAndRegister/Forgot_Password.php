<!DOCTYPE html>
<html>

<head>
    <!-- <link rel="shortcut icon" type="image/x-icon" href="../Public/img/icon.png"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Quên Mật Khẩu</title>
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 400;
                src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 700;
                src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 400;
                src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 700;
                src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
            }
        }

        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }


        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <!-- HIDDEN PREHEADER TEXT -->
    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We're thrilled to have you here! Get ready to dive into your new account. </div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="" align="center" style="background: #fff;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="" align="center" style="padding: 0px 10px 0px 10px;background: #fff;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px;    background: pink; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 48px;">
                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome to </h1>
                            <img src="../../display/img/logo.png" width="125" height="120" style="display: block; border: 0px; margin : 30px 20px 20px 20px" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;background: #fff;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666;    background: pink; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0; color:red;">Vui lòng nhập username để lấy lại mật khẩu.</p>
                        </td>
                    </tr>
                    <!-- form -->
                    <form id="forgotpassword">
                        <tr>
                            <td bgcolor="#ffffff" align="left">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td bgcolor="#ffffff" align="center" style="    background: pink;padding: 20px 30px 60px 30px;">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <div id="result" class="text-danger"></div>
                                                <tr>
                                                    <div class="input-group">
                                                        <label id="result"></label>
                                                        <span class="input-group-text">Username</span>
                                                        <input type="text" id="username" class="form-control"></input>
                                                    </div>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <button type="submit" id="btnsend" class="mt-3 btn btn-success">Gửi</button>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </form>
                    <tr>
                        <!-- <tr>
              <td bgcolor="#ffffff" align="left" style="    background: pink;padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                <p style="margin: 0;">CEO, <br>Lucas Bit </p>
              </td>
            </tr> -->
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;background: #fff;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#FFC9DD" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p><a href="../../view/index.php" class="link link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" style="text-decoration: none;font-size: 25px;
    font-weight: 900;color:black">
                                    <p>Trang Chủ</p>
                                </a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    // Đăng kí Register
    $(document).ready(function() {
        $("#forgotpassword").submit(function(e) {
            e.preventDefault(); // Ngăn chặn sự kiện mặc định của form

            // Lấy dữ liệu từ form
            const username = document.getElementById('username').value; // .value để lấy giá trị của phần tử đó

            // Sử dụng AJAX để gửi dữ liệu đăng ký đến máy chủ
            $.ajax({
                type: "POST",
                url: "../../Authentication/LoginAndRegister/Forgot_Password.php",
                data: { // data là dữ liệu gửi đến máy chủ
                    username: username,
                },
                dataType: "json", // Loại dữ liệu trả về từ máy chủ
                success: function(response) {
                    // response chứa thông tin phản hồi từ máy chủ sau khi gửi một yêu cầu
                    if (response.message === 'true') {
                        window.location.href = '../../view/LoginAndRegister/Forgor_pw_senddone.php';
                    }
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        position: "right",
                        stopOnFocus: true,
                        style: {
                            background: "#FF0000",
                        },
                        onClick: function() {}
                    }).showToast();
                },
                error: function() {
                    $('#result').text('Đã xảy ra lỗi trong quá trình yêu cầu AJAX.');
                }
            });
        });
    });
</script>
<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
$accountModel = new AccountModel();
if (isset($_POST['account'])) {
    $account = $_POST['account'];
    if ($account['account_password'] != $_POST['re_password']) {
        $_SESSION['messageLogin'] = "Xác nhận mật khẩu không hợp lệ";
        $_SESSION['successRegister'] = false;
    } else {
        $isAvailable = $accountModel->isAvailableAccount($account);
        if ( $isAvailable) {
            $_SESSION['messageLogin'] = "Tên tài khoản đã có người đăng ký";
            $_SESSION['successRegister'] = false;
        } else {
            $accountModel->register($account);
            $_SESSION['messageLogin'] = "Đăng ký thành công";
            $_SESSION['successRegister'] = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up </title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="public/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="public/css/stylelogin.css">
    <link rel="stylesheet" href="public/css/styles.css">

</head>

<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <?php if (isset($_SESSION['successRegister']) && isset($_SESSION['messageLogin'])) { ?>
                            <div class="col-md-12">
                                <div class="alert <?php echo $_SESSION['successRegister'] ? "alert-success" : "alert-danger" ?>  alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['messageLogin'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                            <?php echo $_SESSION['successRegister'] ? "<script>setTimeout(() => { location.replace(`login.php`); }, 2000);  </script>" : "" ?>

                        <?php
                            unset($_SESSION['messageLogin']);
                            unset($_SESSION['successRegister']);
                        } ?>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" pattern="[a-z0-9]{6,20}" title="Tên tài khoản chỉ số hoặc chữ và từ 6 đến 20 ký tự" name="account[account_username]" id="name" placeholder="Tên tài khoản" required />
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="account[account_email]" id="email" placeholder="Email" required />
                            </div>
                            <div class="form-group">
                                <label for="phone"><i class="zmdi zmdi-smartphone-android"></i></label>
                                <input type="tel" name="account[account_telephone]" id="phone" placeholder="Số điện thoại" pattern="[0-9]{10}" required />
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" pattern=".{6}" title="Mật khẩu dài ít nhất 6" name="account[account_password]" id="pass" placeholder="Mật khẩu" required />
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input pattern=".{6}" title="Mật khẩu dài ít nhất 6" type="password" name="re_password" id="re_pass" placeholder="Xác nhận mật khẩu" required />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Đăng ký" />
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="public/images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">Đã có tài khoản ?</a>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- JS -->
    <script src="public/vendor/jquery/jquery.min.js"></script>
</body>

</html>
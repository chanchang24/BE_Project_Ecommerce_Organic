<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$accountModel = new AccountModel();
if (isset($_COOKIE['rememberuser'])) {
    $cookie = $_COOKIE['rememberuser'];
    list($id, $token, $mac) = explode(':', $cookie);
    if (hash_equals(hash_hmac('sha256', $id . ':' . $token, "nhom1"), $mac)) {
        $usertoken = $accountModel->getTokenByIDAccount($id);
        $utoken = $usertoken['token'];
        if (hash_equals($utoken, $token)) {
            RememberUser($id);
            $user = $accountModel->getUserByID($id);
            $_SESSION['account'] = $user;
            header("Location: index.php");
            exit;
        } else {
            setcookie('rememberuser', $cookie, time() - 60);
          //  header("Location: Login.php");
        }
    }
}
if (isset($_POST['account'])) {
    $userLogin = $_POST['account'];
    $account = $accountModel->getUserByUsername($userLogin['account_username']);
    if (password_verify($userLogin['account_password'], $account['account_password'])) {
        $_SESSION['account'] = $account;
        if (isset($_POST['remember']) && $_POST['remember'] == 'true') {
           RememberUser($account['id']);
        }
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['messageLogin'] = "Tài Khoản hoặc Mật khẩu không hợp lệ";
        $_SESSION['successLogin'] = false;
    }
}
function RememberUser($accountID)
{
    $accountModel = new AccountModel();
    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);
    $cookie = $accountID.':' . $token;
    $accountModel->storeTokenForUser($accountID, $token);
    $mac = hash_hmac('sha256', $cookie, "nhom1");
    $cookie .= ':' . $mac;
    setcookie('rememberuser', $cookie, time() + 60 * 60 * 24 * 7);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani shop - Sign Up </title>
    <link rel="shortcut icon" href="./public/img/logo.png" type="image/x-icon">
    <!-- Font Icon -->
    <link rel="stylesheet" href="public/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="public/css/stylelogin.css">
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>

    <div class="main">

        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="public/images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Tạo tài khoản mới</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign up</h2>
                        <?php if (isset($_SESSION['successLogin']) && isset($_SESSION['messageLogin'])) { ?>
                            <div class="col-md-12">
                                <div class="alert <?php echo $_SESSION['successLogin'] ? "alert-success" : "alert-danger" ?>  alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['messageLogin'] ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        <?php
                            unset($_SESSION['messageLogin']);
                            unset($_SESSION['successLogin']);
                            
                        } ?>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="account[account_username]" id="your_name" placeholder="Tên tài khoản" />
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="account[account_password]" id="your_pass" placeholder="Mật khẩu" />
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember" value="true" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Ghi nhớ đăng nhập</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Đăng nhập" />
                            </div>
                        </form>
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
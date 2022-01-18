<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
if (!isset($_SESSION['account'])) {
    header("Location: login.php");
    exit;
}
$account = $_SESSION['account'];
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];
    if (password_verify($oldPassword, $account['account_password'])) {
        if ($newPassword == $confirmNewPassword) {
            $accountModel = new AccountModel();
            $accountModel->updatePassword($id, $newPassword);
            $_SESSION['successAcc'] = true;
            $_SESSION['messageAcc'] = 'Đổi mật khẩu thành công, đăng nhập lại sau ít phút';
        } else {
            $_SESSION['successAcc'] = false;
            $_SESSION['messageAcc'] = 'Xác nhận mật khẩu không chính xác';
        }
    } else {
        $_SESSION['successAcc'] = false;
        $_SESSION['messageAcc'] = ' Mật khẩu không hợp lệ';
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "Thông tin tài khoản";
    include("head.php");
    ?>
</head>


<body>
    <?php include("navbar.php"); ?>

    <!-- Hero Section Begin -->
    <?php include("hero-page.php"); ?>

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="card card-body">
                <?php if (isset($_SESSION['successAcc']) && isset($_SESSION['messageAcc'])) { ?>
                    <div class="col-md-12">
                        <div class="alert <?php echo $_SESSION['successAcc'] ? "alert-success" : "alert-danger" ?>  alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['messageAcc'];
                            if ($_SESSION['successAcc']) {
                                echo '<script>
                                setTimeout(() => {
                                    location.replace("login.php");
                                }, 3000);
                            </script>';
                            }
                            ?>
                        </div>
                    </div>
                <?php
                    unset($_SESSION['messageAcc']);
                    unset($_SESSION['successAcc']);
                } ?>
                <div class="d-block p-0">
                    <div class="row">
                        <div class="col-12 py-2  ">Tên tài khoản: <span class="fw-bolder"><b>
                                    <?php echo $account['account_username'] ?></b></span></div>
                        <div class="col-12 py-2 ">Số điện thoại:<span class="fw-bolder"> <b>
                                    <?php echo $account['account_telephone'] ?></b></span> </div>
                        <div class="col-12 py-2">Thư điện tử: <span class="fw-bolder"> <b>
                                    <?php echo $account['account_email'] ?></b></span> </div>
                    </div>

                    <button class="btn btn-info btn-sm mt-3 " type="button" data-toggle="collapse" data-target="#change-password" aria-expanded="false" aria-controls="collapseExample">
                        Đổi mật khẩu
                    </button>
                </div>
                </p>
                <div class="collapse" id="change-password">
                    <div class="card card-body">
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $account['id'] ?>">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mật khẩu cũ</label>
                                <input type="password" name="oldPassword" class="form-control" id="exampleInputPassword1" placeholder="Mật khẩu cũ" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">Mật khẩu mới</label>
                                <input type="password" name="newPassword" class="form-control" id="exampleInputPassword2" placeholder="Mật khẩu mới" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Xác mật khẩu mới</label>
                                <input type="password" name="confirmNewPassword" class="form-control" id="exampleInputPassword3" placeholder="Xác nhận mật khẩu mới" required>
                            </div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Đổi</button>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Thông báo </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn chắc chắn muốn đổi mật khẩu ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Footer Section Begin -->
    <?php include("footer.php"); ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="public/js/jquery-3.3.1.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/jquery.nice-select.min.js"></script>
    <script src="public/js/jquery-ui.min.js"></script>
    <script src="public/js/jquery.slicknav.js"></script>
    <script src="public/js/mixitup.min.js"></script>
    <script src="public/js/owl.carousel.min.js"></script>
    <script src="public/js/main.js"></script>

</body>

</html>
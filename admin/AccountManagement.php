<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$_SESSION['previousPageOrder'] = $_SERVER['REQUEST_URI'];

$accountModel = new AccountModel();
$accounts = $accountModel->getAccounts();
if (isset($_POST['id'])) {
    $accountModel->setAdmin($_POST['id']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "Quản trị tài khoản"  ?>
    <?php include("head-admin.php"); ?>
</head>

<body>
    <div class="sb-nav-fixed">
        <?php include("nav-admin.php");
        ?>
        <div id="layoutSidenav_content">
            <main>
            <div class="container-fluid px-4">
                            <h1 class="mt-4 text-capitalize">Quản trị tài khoản</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table"></i>
                                Danh sách người dùng
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered caption-top table-sm">
                                    <caption>
                                  
                                    </caption>

                                    <thead>
                                        <tr style="border-top: inherit;border-bottom: outset;">
                                            <th scope="col">id</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Số điện thoại</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Quyền</th>
                                            <th scope="col">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($accounts as $account){?>
                                            <tr>
                                                <th scope="row"><?php echo $account['id'] ?></th>
                                                <td class="text-wrap "  style="max-width: 70px;">
                                                    <span class="fs-4"><?php echo $account['account_username'] ?></span>
                                                </td>
                                                <td style="max-width: 70px;">
                                                    <span class="fs-4"><?php echo $account['account_telephone'] ?></span>
                                                </td>
                                                <td style="max-width: 150px;">
                                                    <span ><?php echo $account['account_email'] ?></span>
                                                </td>
                                                <td style="max-width: 50px; ">
                                                <?php echo $account['role_name'] ?>
                                                </td>
                                                <td>
                                                <?php if($account['account_role_id']<2){?>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning" data-bs-target="#tk-<?php echo $account['id'] ?>" data-bs-toggle="modal">
                                                            đặt quyền quản lý
                                                        </button>
                                                    </div>
                                                    <!-- Modal -->

                                                    
                                                        <div class="modal fade" id="tk-<?php echo $account['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="alert alert-success" role="alert">
                                                                            Bạn có chắc chắn thay đổi quyền tài khoản có tên tài khoản là :  <span class="fw-bold font-italic"><?php echo $account['account_username'] ?></span>  thành quyền <span class="fw-bold font-italic"> Quản lý ?</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                        <form  method="POST">
                                                                            <input type="hidden" name="id" value="<?php echo $account['id'] ?>"">
                                                                            <button type="submit" class="btn btn-primary"> OK </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                   <?php } ?>

                                                </td>
                                            </tr>
                                            <?php }?>
                                    </tbody>
                                </table>
            </main>
            <?php include("footer-admin.php"); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../public/js/scripts.js"></script>
</body>
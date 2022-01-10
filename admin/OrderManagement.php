<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$_SESSION['previousPageOrder'] = $_SERVER['REQUEST_URI'];
$perPage = 3;
$currentPage = 1;
$count = 0;
$query = "";
$q = "";
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
$orderModel = new OrderModel();
if (isset($_POST['idDelivered'])) {
    $orderModel->updateFinish($_POST['idDelivered']);
    $items = $orderModel->getOrderItems($_POST['idDelivered']);
    $productModel = new ProductModel();
    foreach ($items as $item ) {
        $productModel->updateQuantity($item['order_product_id'],$item['order_item_qty']);
    }
}
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
}
if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $query .= '&q=' . $q;
}
$orders = $orderModel->getOrdersByKey($currentPage, $perPage, $q);
$count = $orderModel->getCountOrdersByKey($q);
?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "Quản lý Đơn Hàng"  ?>
    <?php include("head-admin.php"); ?>
</head>

<body>
    <div class="sb-nav-fixed">
        <?php include("nav-admin.php");
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-capitalize"><?php echo $title ?></h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table"></i>
                            Danh sách đơn hàng
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="row g-6 align-items-center justify-content-md-center">
                                        <form method="get">
                                            <div class="input-group mb-3 input-group-sm">
                                                <input type="text" class="form-control " value="" name="q" required placeholder="Nhập mã đơn hàng cần tìm ">
                                                <button class="btn btn-outline-primary " type="submit" id="button-addon2"><i class="fas fa-search"></i>
                                                    Tìm </button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered caption-top table-sm">
                                <caption>
                                    Hiển thị các sản phẩm từ <?php $start =  ($currentPage - 1) * $perPage + 1;
                                                                echo $count != 0 ? $start : 0 ?> - <?php echo ($currentPage - 1) * $perPage + count($orders) ?>
                                    trong tổng số <?php echo $count ?> sản phẩm
                                </caption>

                                <thead>
                                    <tr style="border-top: inherit;border-bottom: outset;">
                                        <th scope="col">Mã</th>
                                        <th scope="col">Họ tên</th>
                                        <th scope="col">Điện thoại</th>
                                        <th scope="col">Địa chỉ </th>
                                        <th scope="col">Tổng tiền</th>
                                        <th scope="col">Ngày đặt hàng</th>
                                        <th scope="col">Trạng thái</th>
                                        <th scope="col">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order) { ?>

                                        <tr>
                                            <td>
                                                <?php echo $order['id'] ?>
                                            </td>
                                            <td>
                                                <?php echo $order['order_user_fullname'] ?>
                                            </td>
                                            <td>
                                                <?php echo $order['order_phone'] ?>
                                            </td>
                                            <td>
                                                <?php echo $order['order_adress'] ?>
                                            </td>
                                            <td>
                                                <?php echo numfmt_format_currency($fmt, $order['order_total_price'], "VND"); ?>
                                            </td>
                                            <td>
                                                <?php echo $order['order_create_at'] ?>
                                            </td>
                                            <td>
                                                <?php echo $order['order_status'] > 0 ? '<span class="text-success">Đã giao hàng</span>' : '<span class="text-danger">Chưa giao hàng</span>' ?>
                                            </td>
                                            <td>
                                                <!-- Button trigger modal -->

                                                <button type="button" class="btn btn-success btn-sm  <?php echo $order['order_status'] > 0 ? 'disabled' : '' ?> " data-bs-toggle="modal" data-bs-target="#cancel-<?php echo $order['id'] ?>">
                                                    Giao hàng
                                                </button>
                                                <a href="OrderDetail.php?id=<?php echo $order['id'] ?>" class="btn btn-info btn-sm">
                                                    Chi tiết
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="cancel-<?php echo $order['id'] ?>" tabindex="-1" aria-labelledby="cancel-<?php echo $order['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Bạn chắc chắn đã giao đơn hàng mã <span class="fw-bold"> <?php echo $order['id'] ?> </span> thành công?
                                                                <span><br>Họ tên: <?php echo $order['order_user_fullname'] ?> </span>
                                                                <span><br>Địa chỉ: <?php echo $order['order_adress'] ?> </span>
                                                                <span><br>Số điện thoại: <?php echo $order['order_phone'] ?> </span>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <form method="POST">
                                                                    <input type="hidden" value=" <?php echo $order['id'] ?>" name="idDelivered">
                                                                    <button type="submit" class="btn btn-primary">OK</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php  } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?php include("footer-admin.php"); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="../public/js/scripts.js"></script>
</body>
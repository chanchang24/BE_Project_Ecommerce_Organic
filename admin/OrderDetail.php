<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
$orderModel = new OrderModel();
$order = [];
$orderItems = [];
if (isset($_GET['id'])) {
    $order = $orderModel->getOrder($_GET['id']);
    $orderItems = $orderModel->getOrderItems($_GET['id']);
}
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
                    <h1 class="mt-4 text-capitalize">Thông tin chi tiết đơn hàng</h1>
                    <div class="card mb-4">
                        <div class="card-header border-bottom">
                            <div class="row ">
                                <div class="col-md-3">
                                    <div class="">
                                        <a class="btn btn-primary" href="<?php echo $_SESSION['previousPageOrder'] ?>" <i class="fas fa-backspace"></i> Trang quản lý đơn hàng</a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body mt-2 mb-5">
                                <div class="product-head">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h3>Danh sách mặt hàng</h3>
                                            <table class="table table-bordered caption-top table-sm">
                                                <caption>
                                                    <h5 class="text-danger"> Tổng tiền đơn hàng:
                                                        <?php echo numfmt_format_currency($fmt, $order['order_total_price'], "VND"); ?>
                                                    </h5>
                                                </caption>
                                                <thead>
                                                    <tr style="border-top: inherit;border-bottom: outset;">
                                                        <th scope="col">Tên</th>
                                                        <th scope="col">Ảnh</th>
                                                        <th scope="col">Giá</th>
                                                        <th scope="col">Số lượng</th>
                                                        <th scope="col">Thành tiền</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($orderItems as $item) { ?>
                                                        <tr>
                                                            <td class="text-wrap " style="max-width: 80px;">
                                                                <?php echo $item['order_product_name'] ?>
                                                            </td>
                                                            <td>
                                                                <div class="ratio ratio-4x3" style="max-width: 80px;">
                                                                    <div><img src="../public/images/products/<?php echo $item['order_product_image'] ?>" class="img-thumbnail" alt="" sizes=""></div>
                                                                </div>
                                                            </td>
                                                            <td style="max-width: 50px;">
                                                            <?php echo numfmt_format_currency($fmt, $item['order_product_price'], "VND"); ?>

                                                            </td>
                                                            <td style="max-width: 50px;">
                                                            <?php echo $item['order_item_qty'] ?>
                                                            </td>
                                                            <td style="max-width: 80px; ">
                                                            <?php echo numfmt_format_currency($fmt, $item['order_product_price']*$item['order_item_qty'], "VND"); ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>

                                            </table>
                                        </div>
                                        <div class="col-md-4">
                                            <h2>Thông tin đặt hàng</h2>
                                            <h4 class="my-3">
                                                Mã đơn hàng:  <?php echo $order['id'] ?>
                                            </h4>
                                            <h4 class="my-3">
                                                Họ tên : <span class="fw-bold"> <?php echo $order['order_user_fullname'] ?></span>
                                            </h4>
                                            <h4 class="my-3 ">
                                                Số điện thoại: <?php echo $order['order_phone'] ?>
                                            </h4>
                                            <h5 class=" my-4 fst-italic">
                                                Địa chỉ: <?php echo $order['order_adress'] ?>
                                            </h5>
                                            <h6 class="fw-light fst-italic">
                                                Thời gian đặt hàng: <span class="fw-normal">
                                                <?php echo $order['order_create_at'] ?>
                                                </span>
                                            </h6>
                                            <div>
                                            <?php echo $order['order_status']>0?'<span class="text-success fs-4">Đã giao hàng</span>':'<span class="text-danger fs-4">Chưa giao hàng</span>' ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
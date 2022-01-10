<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
$orderModel = new OrderModel();
if (isset($_POST['order'])) {
    $order = $_POST['order'];
    $order += ["order_account_id" => $_SESSION['account']['id']];
    $order += ["order_total_price" => $_SESSION['amount']];
    $idOrder =  $orderModel->insertOrder($order);
    foreach ($_SESSION['cart'] as $item) {
        $orderItem = [
            "order_id" => $idOrder,
            "order_product_id" => $item["id"],
            "order_product_name" => $item["product_name"],
            "order_product_image" => $item["product_main_image"],
            "order_product_price" => $item["product_promotional_price"],
            "order_item_qty" => $item["product_quantily"]
        ];
        $orderModel->insertOrderItem($orderItem);
    }
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "Đặt hàng";
    include("head.php");
    ?>
</head>

<body>
    <?php include("navbar.php"); ?>

    <!-- Hero Section Begin -->
    <?php include("hero-page.php"); ?>
    <section class="breadcrumb-section set-bg" data-setbg="./public/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>ĐẶT HÀNG</h2>
                        <div class="breadcrumb__option">
                            <a href="./">Home</a>
                            <span>Đặt hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
        <h1 class="text-success my-5 text-center"> ĐẶT HÀNG THÀNH CÔNG </h1> 
        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Footer Section Begin -->
    <jsp:include page="footer.jsp"></jsp:include>
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
    <script>
        setTimeout(() => {
            location.replace("/");
        }, 3000);
    </script>
</body>

</html>
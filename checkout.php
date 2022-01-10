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
    $_SESSION['amount'] = 0;
    header("Location : order-success.php");
    die;
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

            <div class="checkout__form">
                <h4>Thông tin đặt hàng</h4>
                <form method="post">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Họ tên <span>*</span></p>
                                        <input class="form-control" type="text" name="order[order_user_fullname]" title="Nhập đúng họ tên" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Số điện thoại<span>*</span></p>
                                        <input class="form-control" type="text" pattern="\d{10}" name="order[order_phone]" title="Số điện thoại phải 10 số" required>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Địa chỉ<span>*</span></p>
                                <input type="text" class="form-control" placeholder="Địa chỉ của bạn" name="order[order_adress]" class="checkout__input__add" required>
                            </div>
                            <div class="checkout__input">
                                <p>Chú thích</p>
                                <input type="text" class="form-control" placeholder="Ghi điều chúng tôi cần lưu ý" name="order[order_message]">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Danh sách đặt hàng</h4>
                                <div class="checkout__order__products">Sản phẩm <span>Thành tiền</span></div>
                                <ul>
                                    <?php foreach ($_SESSION['cart'] as $product) { ?>
                                        <li><?php echo $product['product_name'] . " x" . $product['product_quantily'] ?> <span>
                                                <?php echo numfmt_format_currency($fmt, $product['product_quantily'] * $product['product_promotional_price'], "VND"); ?>
                                            </span></li>
                                    <?php } ?>
                                </ul>
                                <div class="checkout__order__total">Tổng tiền <span>
                                        <?php echo numfmt_format_currency($fmt, $_SESSION['amount'], "VND"); ?>
                                    </span></div>
                                <button type="submit" class="site-btn">ĐẶT HÀNG</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
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
</body>

</html>
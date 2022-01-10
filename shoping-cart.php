<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
$productModel = new ProductModel();
$categoryModel = new CategoryModel();
$categories = $categoryModel->getCategories();
if (isset($_POST['id'])) {
    $cart = [];
    $ids = $_POST['id'];
    $total = $_POST['total'];
    for ($i = 0; $i < count($ids); $i++) {
        $item = $productModel->getProductByID($ids[$i]);
        if ($item['product_quantily'] > $total[$i]) {
            $item += ["max_quantily" => $item['product_quantily']];
            $item['product_quantily'] = $total[$i];
            array_push($cart, $item);
        }
    }
    $_SESSION['cart'] = $cart;
    $amount = 0;
    foreach ($cart as $item) {
        $amount += $item['product_quantily'] * $item['product_promotional_price'];
    }
    $_SESSION['amount'] = $amount;
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "Giỏ hàng";
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
                        <h2>Giỏ hàng</h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <span>Giỏ hàng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->


    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <form method="POST">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="shoping__product">Sản phẩm
                                        </th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($_SESSION['cart'])) foreach ($_SESSION['cart'] as $product) { ?>
                                        <tr id="close-<?php echo $product['id'] ?>">
                                            <input type="hidden" name="id[]" value="<?php echo $product['id'] ?>">
                                            <td class="shoping__cart__item">
                                                <img style="width: 100px" src="./public/images/products/<?php echo $product['product_main_image'] ?>" alt="">
                                                <h5><?php echo $product['product_name'] ?></h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                <?php if ($product['product_price'] > $product['product_promotional_price']) { ?>
                                                    <span>
                                                        <?php echo numfmt_format_currency($fmt, $product['product_promotional_price'], "VND"); ?>
                                                    </span><br><span class="text-muted" style="text-decoration-line: line-through;">
                                                        <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                                    </span>
                                                <?php } else { ?>
                                                    <h5>
                                                        <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                                    </h5>
                                                <?php } ?>
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity mx-5">
                                                    <input type="number" name="total[]" class="form-control text-center float-right" style="width: 100px" value="<?php echo $product['product_quantily'] ?>" min="1" max="<?php echo $product['max_quantily'] ?>">
                                                </div>
                                            </td>
                                            <td class="shoping__cart__total">
                                                <?php echo numfmt_format_currency($fmt, $product['product_quantily'] * $product['product_promotional_price'], "VND"); ?>
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <span class="btn-close-item icon_close" data-close="#close-<?php echo $product['id'] ?>"></span>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <!-- <button onclick=window".history.back()" class="btn btn-primary">CONTINUE SHOPPING</button> -->
                        <button href="#" class="btn btn-success float-right">
                            Cập nhật</button>
                    </div>
                    </form>
                </div>
                <div class="col-lg-6">
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Tổng tiền</h5>
                        <ul>
                            <li>Tổng <span>
                                    <?php if (isset($_SESSION['amount'])) {
                                        echo numfmt_format_currency($fmt, $_SESSION['amount'], "VND");
                                    } ?>
                                </span></li>
                        </ul>
                        <?php if (!isset($_SESSION['account'])) { ?>
                            <div class="alert alert-light" role="alert">
                                Vui lòng <a href="login.php" class="alert-link">Đăng nhập</a> để đặt hàng.
                            </div>
                            <?php } else {
                            if (isset($_SESSION['cart'])) {  ?>
                            
                                <a href="checkout.php" class="primary-btn">Đặt hàng</a>
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->

    <!-- Footer Section Begin -->
    <?php include("footer.php"); ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script type="text/javascript" src="public/js/hoadaoroi.js"></script>

    <script src="public/js/jquery-3.3.1.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/jquery.nice-select.min.js"></script>
    <script src="public/js/jquery-ui.min.js"></script>
    <script src="public/js/jquery.slicknav.js"></script>
    <script src="public/js/mixitup.min.js"></script>
    <script src="public/js/owl.carousel.min.js"></script>
    <script src="public/js/main.js"></script>
    <script>
        let btnCloseItem = document.querySelector('.btn-close-item');
        btnCloseItem.addEventListener("click", function() {
            let item = document.querySelector(this.dataset.close);
            item.remove();
        })
    </script>
</body>

</html>
<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
$orders = [];
$orderModel = new OrderModel();
if (isset($_SESSION['account'])) {
    $orders = $orderModel->getOrdersByIDAccount($_SESSION['account']['id']);
    for ($i = 0; $i < count($orders); $i++) {
        $orders[$i] += ["items" => $orderModel->getOrderItems($orders[$i]['id'])];
    }
} else {
    header('HTTP/1.0 404 Not Found');
    die;
}
?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "Lịch sử đơn hàng";
    include("head.php");
    ?>
</head>
<style>
    div.stars {
        width: 270px;
        display: inline-block;
    }

    input.star {
        display: none;
    }

    label.star {
        float: right;
        padding: 5px;
        font-size: 20px;
        color: #444;
        transition: all .2s;
    }

    input.star:checked~label.star:before {
        content: '\f005';
        color: #FD4;
        transition: all .25s;
    }

    input.star-5:checked~label.star:before {
        color: #FE7;
    }

    input.star-1:checked~label.star:before {
        color: #F62;
    }

    label.star:hover {
        transform: rotate(-15deg) scale(1.3);
    }

    label.star:before {
        content: '\f006';
        font-family: FontAwesome;
    }
</style>

<body>
    <?php include("navbar.php"); ?>

    <!-- Header Section End -->
    <?php include("hero-page.php"); ?>
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="./public/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>ĐƠN HÀNG</h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <span>Đơn hàng

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="my-3 pt-2">
        <div class="container">
            <?php foreach ($orders as $order) { ?>
                <div class="card card-body">
                    <div class="d-block p-0">
                        <div class="row">
                            <div class="col-6 ">Họ tên: <span class="fw-normal"><b>
                                        <?php echo $order['order_user_fullname'] ?></b></span></div>
                            <div class="col-6">Số điện thoại:<span class="fw-bolder"> <b>
                                        <?php echo $order['order_phone'] ?></b></span> </div>
                        </div>
                        <p> Địa chỉ: <?php echo $order['order_adress'] ?></p>
                        <div class="row">
                            <div class="col-4">
                                <p class="fw-light fst-italic">
                                    Thời gian đặt hàng: <span class="fw-normal">
                                        <?php echo $order['order_create_at'] ?>
                                    </span>
                                </p></span>
                            </div>
                            <div class="col-4">Tổng tiền:
                                <?php echo numfmt_format_currency($fmt, $order['order_total_price'], "VND"); ?>
                            </div>
                            <div class="col-4">Trạng thái:
                                <?php echo $order['order_status'] == 0 ? '<span class="text-danger">Chưa giao hàng</span>' : ' <span class="text-success">Đã giao hàng</span>' ?>
                            </div>
                        </div>
                        <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#detail-<?php echo $order['id'] ?>" aria-expanded="false" aria-controls="collapseExample">
                            Chi tiết
                        </button>
                        <?php echo $order['order_status'] == 0 ? '' : '<button class="btn btn-warning btn-sm  " type="button" data-toggle="collapse" data-target="#rating-' . $order['id'] . '" aria-expanded="false" aria-controls="collapseExample">
                                    Đánh giá
                                </button>' ?>
                    </div>
                    </p>
                    <div class="collapse" id="detail-<?php echo $order['id'] ?>">
                        <div class="card card-body">
                            <table class="table table-bordered caption-top table-sm">
                                <thead>
                                    <tr style="border-top: inherit;border-bottom: outset;">
                                        <th scope="col">Tên</th>
                                        <th scope="col">Hình</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Số lượng</th>
                                        <th scope="col">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <c:set var="index" scope="request" value="1" />
                                    <?php foreach ($order["items"] as $item) { ?>
                                        <tr>

                                            <td class="text-wrap " style="max-width: 150px;">
                                                <?php echo $item['order_product_name'] ?>
                                            </td>
                                            <td>
                                                <div class="ratio ratio-4x3" style="max-width: 80px;">
                                                    <div><img src="./public/images/products/<?php echo $item['order_product_image'] ?>" class="img-thumbnail" alt="" sizes="">
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="max-width: 50px;">
                                                <?php echo numfmt_format_currency($fmt, $item['order_product_price'], "VND"); ?>

                                            </td>
                                            <td style="max-width: 50px;">
                                                <?php echo $item['order_item_qty'] ?>
                                            </td>
                                            <td style="max-width: 80px; ">
                                                <?php echo numfmt_format_currency($fmt, $item['order_product_price'] * $item['order_item_qty'], "VND"); ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="collapse" id="rating-<?php echo $order['id'] ?>">
                        <?php foreach ($order["items"] as $item) { ?>
                            <div class="row py-2">

                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-8 ">
                                            <h5><?php echo $item['order_product_name'] ?></h5>
                                        </div>
                                        <div class="col-4">
                                            <div class="ratio ratio-4x3" style="max-width: 120px;width: 120px;">
                                                <img src="./public/images/products/<?php echo $item['order_product_image'] ?>" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <?php if ($item['order_rated'] == 0) { ?>
                                        <div class="row" id="rate-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>">
                                            <div class="col-5">

                                                <div class="form-group">
                                                    <textarea class="form-control comment-product" id="exampleFormControlTextarea1" placeholder="Nhập nội dung đánh giá" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-7 px-0">
                                                <div class="row">
                                                    <div class="stars col-7">
                                                        <input class="star star-5 star-rating" id="star-5-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" type="radio" value="5" name="star-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" />
                                                        <label class="star star-5" for="star-5-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>"></label>
                                                        <input class="star star-4 star-rating" id="star-4-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" type="radio" value="4" name="star-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" />
                                                        <label class="star star-4" for="star-4-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>"></label>
                                                        <input class="star star-3 star-rating" id="star-3-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" type="radio" value="3" name="star-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" />
                                                        <label class="star star-3" for="star-3-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>"></label>
                                                        <input class="star star-2 star-rating" id="star-2-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" type="radio" value="2" name="star-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" />
                                                        <label class="star star-2" for="star-2-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>"></label>
                                                        <input class="star star-1 star-rating" id="star-1-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" type="radio" value="1" name="star-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>" />
                                                        <label class="star star-1" for="star-1-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>"></label>
                                                    </div>
                                                    <div class="col-5">
                                                        <button class="btn btn-warning btn-sm btn-rating " data-user="<?php echo $_SESSION['account']['account_username'] ?>" data-product-id="<?php echo $item['order_product_id'] ?>" data-transaction-id="<?php echo $order['id'] ?>" data-target="#rate-<?php echo $item['order_id'] . '-' . $item['order_product_id'] ?>">Đánh
                                                            giá</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-center">
                                            <span class=" text-warning"> Sản phẩm đã đánh giá</span>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

        </div>
    </section>
    <!-- Checkout Section End -->

    <!-- Footer Section Begin -->
    <?php include("footer.php"); ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script type="text/javascript" src="public/js/hoadaoroi.js"></script>

    <!-- Js Plugins -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="public/js/jquery-3.3.1.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/jquery.nice-select.min.js"></script>
    <script src="public/js/jquery-ui.min.js"></script>
    <script src="public/js/jquery.slicknav.js"></script>
    <script src="public/js/mixitup.min.js"></script>
    <script src="public/js/owl.carousel.min.js"></script>
    <script src="public/js/main.js"></script>
    <script>
        let btnsRating = document.querySelectorAll('.btn-rating');
        btnsRating.forEach(element => {
            element.addEventListener('click', function() {
                let rate = document.querySelector(this.dataset.target);
                let ratingStar = 0;
                rate.querySelectorAll('.star-rating').forEach(el => {
                    if (el.checked) {
                        ratingStar = el.value;
                    }
                });
                let content = rate.querySelector(".comment-product").value;
                let username = this.dataset.user;
                let idProduct = this.dataset.productId;
                let idTransaction = this.dataset.transactionId;
                console.log(idTransaction);
                if (ratingStar != 0) {
                    RateProduct(username, idProduct, idTransaction, content, ratingStar)
                    rate.insertAdjacentHTML('beforebegin', '<div class="text-center"><span class=" text-warning"> Sản phẩm đã đánh giá</span></div>');
                    rate.remove();
                }
            })
        });

        function RateProduct(username, idProduct, idTransaction, content, ratingStar) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                Toastify({
                    text: "Đánh giá sản phẩm thành công",
                    duration: 4000,
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right",
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #7fad39, #96c93d)",
                    },
                }).showToast();
            }
            xhttp.open("POST", "./app/ajax/RateProduct.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("username=" + username + "&content=" + content + "&ratingStar=" + ratingStar + "&idProduct=" + idProduct + "&idTransaction=" + idTransaction);
        }
    </script>
</body>

</html>
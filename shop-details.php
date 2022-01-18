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
$product = [];
$reviews = [];
$avgStart = 0;
$relatedProducts = [];
$starRating = [0, 0, 0, 0, 0];
if (isset($_GET['id'])) {
    $product = $productModel->getProduct($_GET['id']);
    $reviews = $productModel->getReviews($_GET['id']);
    $relatedProducts = $productModel->getRelatedProducts($_GET['id']);
    foreach ($reviews as $review) {
        $starRating[$review['product_review_rating'] - 1] = $starRating[$review['product_review_rating'] - 1] + 1;
        $avgStart += $review['product_review_rating'];
    }
    if (count($reviews) != 0) {
        $avgStart = round($avgStart / count($reviews), 2);
    }
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    $cart = [];
    if (isset($_SESSION['cart'])) {
        $cart  = $_SESSION['cart'];
    }
    if (in_array($id, array_column($cart, 'id'))) {
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['id'] == $id) {
                $p = $cart[$i];
                if ($product['product_quantily'] >= $p['product_quantily']+$qty) {
                    $p['product_quantily'] = $p['product_quantily'] +  $qty;
                }
                $cart[$i] =  $p;
            }
        }
    } else {
        $p =$product;
        $p+=["max_quantily"=>$p['product_quantily']];
        $p['product_quantily'] = $qty;
        array_push($cart, $p);
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
    <?php $title = "Chi tiết sản phẩm";
    include("head.php");
    ?>
</head>

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
                        <h2><?php echo $product['product_name'] ?></h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <a href="shop.php">Shop</a>
                            <span>Chi tiết sản phẩm</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__pic">
                        <div class="product__details__pic__item">
                            <img class="product__details__pic__item--large" src="./public/images/products/<?php echo $product['product_main_image'] ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3><?php echo $product['product_name'] ?></h3>
                        <div class="product__details__rating">
                            <?php
                            for ($i = 0; $i < floor($avgStart); $i++) {
                                echo ' <i class="fa fa-star"></i>';
                            }
                            for ($i = 0; $i < 5 - floor($avgStart); $i++) {
                                echo ' <i class="fa fa-star-o"></i>';
                            }
                            ?>
                            <span>(<?php echo count($reviews) ?> reviews)</span>
                        </div>
                        <form method="POST">
                            <div class="product__details__price ">
                                <?php if ($product['product_price'] > $product['product_promotional_price']) { ?>
                                    <?php echo numfmt_format_currency($fmt, $product['product_promotional_price'], "VND"); ?><br><span class="text-muted fs-5" style="text-decoration-line: line-through;">
                                        <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                    </span> <?php } else { ?>
                                    <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                <?php } ?>
                            </div>
                            <?php if ($product['product_quantily'] <= 0) { ?>
                                <div class="text-danger fs-3 my-2 font-weight-bold">
                                    Hết Hàng
                                </div>
                            <?php } else { ?>
                                <div class="product__details__quantity">
                                    <div class="mb-3">
                                        Số Lượng còn : <?php echo $product['product_quantily'] ?>
                                    </div>
                                    <div class="quantity">
                                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                                        <input type="number" class="form-control total-input-product" name="qty" value="1" min="1" max="<?php echo $product['product_quantily'] ?>">
                                    </div>
                                </div>
                            <?php } ?>

                            <button class='primary-btn btn' aria-disabled="true" <?php echo $product['product_quantily'] > 0 ?'': 'style=" opacity: .6; cursor: no-drop;  pointer-events: none; "' ;?>> THÊM VÀO GIỎ</button>
                        </form>
                        <ul>
                            <li><b>Share on</b>
                                <div class="share">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="true">Mô tả chi tiết</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Đánh giá <span>(<?php echo count($reviews) ?>)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Mô tả chi tiết sản phẩm</h6>
                                    <div>
                                        <?php echo $product['product_description'] ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " id="tabs-3" role="tabpanel">
                                <div class="w-75 mx-auto card mt-2">
                                    <div class="row">
                                        <div class="col-6 card p-4">
                                            <h4 class="my-3">Trung bình: <?php echo $avgStart ?><br> </h4>
                                            <h3>
                                                <?php
                                                for ($i = 0; $i < floor($avgStart); $i++) {
                                                    echo '<i class="fa fa-star text-warning fs-1"></i>';
                                                }
                                                for ($i = 0; $i < 5 - floor($avgStart); $i++) {
                                                    echo ' <i class="fa fa-star-o text-warning fs-1"></i>';
                                                }
                                                ?>
                                            </h3>
                                            <p class="fw-light font-italic mt-3"> Trong tổng số <?php echo count($reviews) ?> lượt đánh giá </p>
                                        </div>
                                        <div class="col-6 card p-5">
                                            <div class="row">
                                                <div class="col-2 text-end">
                                                    5 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width:<?php echo count($reviews) > 0 ? (($starRating[4] / count($reviews)) * 100)  : '0' ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $starRating[4] ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-end">
                                                    4 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width:<?php echo count($reviews) > 0 ? (($starRating[3] / count($reviews)) * 100)  : '0' ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $starRating[3] ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-end">
                                                    3 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-info" role="progressbar" style="width:<?php echo count($reviews) > 0 ? (($starRating[2] / count($reviews)) * 100)  : '0' ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $starRating[2] ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-end">
                                                    2 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="width:<?php echo count($reviews) > 0 ? (($starRating[1] / count($reviews)) * 100)  : '0' ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $starRating[1] ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-end">
                                                    1 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="width:<?php echo count($reviews) > 0 ? (($starRating[0] / count($reviews)) * 100)  : '0' ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $starRating[0] ?></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="product__details__tab__desc">
                                    <?php foreach ($reviews as $review) { ?>
                                        <div class="px-5 w-75 mx-auto card">
                                            <div class="row py-3">
                                                <div class="col-sm-4">
                                                    <div class="review-block-name fs-5 fw-bold"><?php echo $review['product_review_username'] ?></div>
                                                    <div class="review-block-date">
                                                        <?php echo $review['product_review_create_at'] ?> <br>
                                                        <span class="fw-lighter fst-italic">
                                                            <script>
                                                                document.write(moment(" <?php echo $review['product_review_create_at'] ?>").fromNow());
                                                            </script>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="review-block-rate text-warning" style="font-size: 20px;">
                                                        <?php for ($i = 0; $i < $review['product_review_rating']; $i++) {
                                                            echo ' <i class="fa fa-star"></i>';
                                                        } ?>
                                                    </div>
                                                    <div class="review-block-description pt-2"> <span class="fw-bold"> Nhận xét:</span> <?php echo $review['product_review_content'] ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

    <!-- Related Product Section Begin -->
    <section class="related-product">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title related__product__title">
                        <h2>Sản phẩm cùng loại</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($relatedProducts as $p ){?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="./public/images/products/<?php echo $p['product_main_image'] ?>">
                                <ul class="product__item__pic__hover">
                                    <li><a href="shop-details.php?id=<?php echo $p['id'] ?>" title="Xem chi tiết"><i class="fa fa-info-circle"></i></a></li>
                                    <?php echo $p['product_quantily']>0? '<li><a data-id="'.$p['id'].'" title="Thêm vào giỏ" style="cursor: pointer" class="btn-add-to-cart"><i class="fa fa-shopping-cart"></i></a></li>':'' ?>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="shop-details.php?id=<?php echo $p['id'] ?>"><?php echo $p['product_name'] ?></a></h6>
                                <?php if ($p['product_promotional_price'] < $p['product_price']) { ?>
                                    <h5 class="text-danger fs-4">
                                    <?php echo numfmt_format_currency($fmt, $p['product_promotional_price'], "VND"); ?>
                                    </h5><span class="text-muted" style="text-decoration-line: line-through;">
                                    <?php echo numfmt_format_currency($fmt, $p['product_price'], "VND"); ?>
                                    </span>
                                <?php } else { ?>
                                    <h5 class="fs-4">
                                    <?php echo numfmt_format_currency($fmt, $p['product_price'], "VND"); ?>
                                    </h5>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

    <?php include("footer.php"); ?>
    <!-- Js Plugins -->
    <script type="text/javascript" src="public/js/hoadaoroi.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="public/js/jquery-3.3.1.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/jquery.nice-select.min.js"></script>
    <script src="public/js/jquery-ui.min.js"></script>
    <script src="public/js/jquery.slicknav.js"></script>
    <script src="public/js/mixitup.min.js"></script>
    <script src="public/js/owl.carousel.min.js"></script>
    <script src="public/js/main.js"></script>
    <script src="public/js/scriptsite.js"></script>
</body>

</html>
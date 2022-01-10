<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$isIndex = true;
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
$producModel = new ProductModel();
$categoryModel = new CategoryModel();
$categories = $categoryModel->getCategories();
$featuredProducts = $producModel->getFeaturedProducts();
?>

<!DOCTYPE html>
<html>

<head>
    <?php $title = "Ogani shop - Chuyên bán thực phẩm Organic";
    include("head.php");
    ?>
</head>

<body>
    <?php include("navbar.php"); ?>

    <!-- Hero Section Begin -->
    <?php include("hero.php"); ?>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <?php foreach ($categories as $category) { ?>
                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="./public/images/category/<?php echo $category["category_image"] ?>">
                                <h5><a href="shop?idcategory=<?php echo $category["id"] ?>"><?php echo $category["category_name"] ?></a></h5>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Sản phẩm nổi bật
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">
                <?php foreach ($featuredProducts as $product) { ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mix ">
                        <div class="featured__item">
                            <div class="featured__item__pic set-bg" style="border: 1px #d2cfcf61 solid;" data-setbg="./public/images/products/<?php echo $product['product_main_image'] ?>">
                                <ul class="featured__item__pic__hover">
                                    <li><a href="shop-details.php?id=<?php echo $product['product_id'] ?>" title="Xem chi tiết"><i class="fa fa-info-circle"></i></a></li>
                                    <?php if ($product['product_quantily'] > 0) { ?>
                                        <li>
                                            <a data-id="<?php echo $product['product_id'] ?>" title="Thêm vào giỏ" style="cursor: pointer" class="btn-add-to-cart"><i class="fa fa-shopping-cart">
                                                </i></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="featured__item__text">
                                <h6><a href="shop-details.php?id=<?php echo $product['product_id'] ?>"><?php echo $product['product_name'] ?></a></h6>
                                <?php if ($product['product_promotional_price'] < $product['product_price']) { ?>
                                    <h5 class="text-danger fs-4">
                                    <?php echo numfmt_format_currency($fmt, $product['product_promotional_price'], "VND"); ?>
                                    </h5><span class="text-muted" style="text-decoration-line: line-through;">
                                    <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                    </span>
                                <?php } else { ?>
                                    <h5 class="fs-4">
                                    <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                    </h5>
                                <?php } ?>
                                <div class="product__details__rating pt-1">
                                    <?php for ($i = 0; $i < floor($product['rating_average']); $i++) {
                                        echo '<i class="fa fa-star text-warning"></i>';
                                    } ?>
                                     <?php for ($i = 0; $i < 5- floor($product['rating_average']); $i++) {
                                        echo '  <i class="fa fa-star-o text-warning"></i>';
                                    } ?>
                                    <br>
                                    <span>(<?php echo $product['review_count'] ?> reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner ">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="./public/img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="./public/img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>Sản phẩm mới</h2>
                    </div>
                </div>
            </div>
            <div class="row list-new-product">
            </div>
            <div class="col-12 text-center">
                <button type="button" class="btn btn-outline-primary mx-auto btn-sm btn-loadmore-newproduct" aria-disabled="true">Xem
                    thêm</button>
            </div>
        </div>
    </section>

    <!-- Footer Section Begin -->
    <?php include("footer.php"); ?>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="public/js/hoadaoroi.js"></script>
    <script src="public/js/jquery-3.3.1.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/js/jquery.nice-select.min.js"></script>
    <script src="public/js/jquery-ui.min.js"></script>
    <script src="public/js/jquery.slicknav.js"></script>
    <script src="public/js/mixitup.min.js"></script>
    <script src="public/js/owl.carousel.min.js"></script>
    <script src="public/js/main.js"></script>
    <script src="public/js/scriptsite.js"></script>
    <script>

    </script>
</body>

</html>
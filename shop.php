<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
$_SESSION['previousPageShop'] = $_SERVER['REQUEST_URI'];
$perPage = 6;
$currentPage = 1;
$count = 0;
$query = "";
$q = "";
$productModel = new ProductModel();
$categoryModel = new CategoryModel();
$products = [];
if (isset($_GET['page'])) {
    $currentPage  = $_GET['page'];
}
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    $products = $productModel->getProductsByKey($currentPage, $perPage, $q);
    $count = $productModel->getProductsCountByKey($q);
} else {
    if (isset($_GET['idCategory']) && !empty($_GET['idCategory'])) {
        $idCategory = $_GET['idCategory'];
        $products =  $productModel->getProductsByIDCategory($currentPage, $perPage, $idCategory);
        $count =  $productModel->getProductsCountByIDCategory($idCategory);
    } else {
        $products = $productModel->getProducts($currentPage, $perPage);
        $count = $productModel->getProductCount();
    }
}
$categories = $categoryModel->getCategories();
$saletProducts = $productModel->getSaleProduct();
$queries = array();
$maxPage = ceil($count / $perPage);
parse_str($_SERVER['QUERY_STRING'], $queries);
// var_dump($queries);
// var_dump(http_build_query($queries));
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
    <?php include("hero-page.php"); ?>
    <!-- Hero Section End -->
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="./public/img/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shop</h2>
                        <div class="breadcrumb__option">
                            <a href="index.php">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item" style="    min-height: 550px; margin-top: 600px  ">
                            <h4>Danh mục</h4>
                            <ul>
                                <?php foreach ($categories as $category) {
                                    echo '<li><a href="?idCategory=' . $category['id'] . '">' . $category['category_name'] . '</a></li>';
                                } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        <div class="section-title product__discount__title">
                            <h2>Sale Off</h2>
                        </div>
                        <div class="row">
                            <div class="product__discount__slider owl-carousel">
                                <?php foreach ($saletProducts as $product) { ?>
                                    <div class="col-lg-4">
                                        <div class="product__discount__item">
                                            <div class="product__discount__item__pic set-bg" data-setbg="./public/images/products/<?php echo $product['product_main_image'] ?>">
                                                <div class="product__discount__percent"><?php echo $product['sale'] ?>%</div>
                                                <ul class="product__item__pic__hover">
                                                    <li><a href="shop-details.php?id=<?php echo $product['id'] ?>" title="Xem chi tiết"><i class="fa fa-info-circle"></i></a></li>
                                                    <?php if ($product['product_quantily'] > 0) { ?>
                                                        <li> <a data-id="<?php echo $product['id'] ?>" title="Thêm vào giỏ" style="cursor: pointer" class="btn-add-to-cart"><i class="fa fa-shopping-cart"></i></a> </li>
                                                                <?php } ?>
                                                       
                                                </ul>
                                            </div>
                                            <div class="product__discount__item__text">
                                                <h5><a href="shop-details.php?id=<?php echo $product['id'] ?>"><?php echo $product['product_name'] ?></a></h5>
                                                <div class="product__item__price">
                                                    <?php echo numfmt_format_currency($fmt, $product['product_promotional_price'], "VND"); ?>
                                                    <span>
                                                        <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                    <div class="filter__item">
                        <div class="row">
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sort By</span>
                                    <select>
                                        <option value="0">Default</option>
                                        <option value="0">Default</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <?php if (!empty($q)) {
                                        echo ' <h6><span> ' . count($products) . '</span> sản phẩm được tìm thấy</h6>';
                                    } ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-3">
                                <div class="filter__option">
                                    <span class="icon_grid-2x2"></span>
                                    <span class="icon_ul"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach ($products as $product) { ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" style="border: 1px solid #d2cfcf61;" data-setbg="./public/images/products/<?php echo  $product['product_main_image'] ?>">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="shop-details.php?id=<?php echo  $product['id'] ?>" title="Xem chi tiết"><i class="fa fa-info-circle"></i></a></li>
                                            <?php if ($product['product_quantily'] > 0) { ?>
                                                <li>
                                                    <a data-id="<?php echo  $product['id'] ?>" title="Thêm vào giỏ" style="cursor: pointer" class="btn-add-to-cart"><i class="fa fa-shopping-cart">
                                                        </i></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="shop-details.php?id=<?php echo  $product['id'] ?>"><?php echo  $product['product_name'] ?></a></h6>
                                        <?php if ($product['product_price'] > $product['product_promotional_price']) { ?>
                                            <h5 class="text-danger"> <?php echo numfmt_format_currency($fmt, $product['product_promotional_price'], "VND"); ?>
                                            </h5><span class="text-muted" style="text-decoration-line: line-through;">
                                                <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                            </span>
                                        <?php } else { ?>

                                            <h5>
                                                <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                            </h5>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php }; ?>
                    </div>
                    <div class="product__pagination">
                        <?php if ($currentPage > 1) {
                            $queries['page'] = $currentPage - 1;
                        ?>
                            <a href="?<?php echo http_build_query($queries) ?>"><i class="fa fa-long-arrow-left"></i></a>
                        <?php } ?>
                        <?php for ($i = 1; $i <= $maxPage; $i++) {
                            $queries['page'] = $i;
                            if ($currentPage == $i) {
                                echo '<a href="?' . http_build_query($queries) . '" class="page-active">' . $i . '</a> ';
                            } else {
                                echo '<a href="?' . http_build_query($queries) . '" >' . $i . '</a> ';
                            }
                        } ?>
                        <?php if ($currentPage < $maxPage) {
                            $queries['page'] = $currentPage + 1;
                        ?>
                            <a href="?<?php echo http_build_query($queries) ?>"><i class="fa fa-long-arrow-right"></i></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section Begin -->
    <?php include("footer.php"); ?>
    <!-- Footer Section End -->

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
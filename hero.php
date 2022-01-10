<?php
$categoriesForNav = $categoryModel->getCategoriesForNav();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>

<body>
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Danh mục</span>
                        </div>
                        <ul>
                            <?php foreach ($categoriesForNav as $category) { ?>
                                <li><a href="shop?idcategory=<?php echo $category['id'] ?>"><?php echo $category['category_name'] ?></a></li>
                            <?php } ?>
                            <li class="font-weight-bold "><a href="shop.php"><i class="fa fa-caret-right" aria-hidden="true"></i> Xem tất cả</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="shop" method="get">
                                <input name="q" type="text" placeholder="Nhập tên sản phẩm bạn cần tìm?">
                                <button type="submit" class="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>(+84) 0123456789</h5>
                                <span>hỗ trợ 24/7 </span>
                            </div>
                        </div>
                    </div>
                    <?php 
                    if (isset($isIndex)) { ?>
                        <div class="hero__item set-bg" data-setbg="./public/img/hero/banner.jpg">
                            <div class="hero__text">
                                <span>FRUIT FRESH</span>
                                <h2>Vegetable <br />100% Organic</h2>
                                <p>Free Pickup and Delivery Available</p>
                                <a href="shop.php" class="primary-btn">SHOP NOW</a>
                            </div>
                        </div>
                    <?php  } ?>

                </div>
            </div>
        </div>
    </section>
</body>

</html>
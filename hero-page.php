<?php
$categoryModel = new CategoryModel();
$categoriesForNav = $categoryModel->getCategoriesForNav();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    </head>
    <body>
        <!-- Hero Section Begin -->
        <section class="hero hero-normal">
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
                                <li class="font-weight-bold "><a href="shop"><i class="fa fa-caret-right" aria-hidden="true"></i> Xem tất cả</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="hero__search">
                            <div class="hero__search__form">
                                <form action="shop">
                                    <input type="text" name="q" value="" placeholder="Nhập tên sản phẩm bạn cần tìm?">
                                    <button type="submit" class="site-btn">SEARCH</button>
                                </form>
                            </div>
                            <div class="hero__search__phone">
                                <div class="hero__search__phone__icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="hero__search__phone__text">
                                    <h5>(+84) 0123456789</h5>
                                    <span>Hỗ trợ 24/7 </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Hero Section End -->
    </body>
</html>

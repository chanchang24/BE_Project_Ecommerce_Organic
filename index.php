<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY); ?>
<!DOCTYPE html>
<html>

    <head>
        <?php $title = "Ogani shop - Chuyên bán thực phẩm Organic";
        include("head.php");
        ?>
        </head>

        <body>
        <jsp:include page="navbar.jsp"></jsp:include>

            <!-- Header Section End -->

            <!-- Hero Section Begin -->
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
                                <c:forEach items="${categories}" var="category">
                                    <li><a href="shop?idcategory=${category.id}">${category.name}</a></li>
                                    </c:forEach>
                                <li class="font-weight-bold "><a href="shop"><i class="fa fa-caret-right" aria-hidden="true"></i> Xem tất cả</a></li>
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
                        <div class="hero__item set-bg" data-setbg="./public/img/hero/banner.jpg">
                            <div class="hero__text">
                                <span>FRUIT FRESH</span>
                                <h2>Vegetable <br />100% Organic</h2>
                                <p>Free Pickup and Delivery Available</p>
                                <a href="shop" class="primary-btn">SHOP NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Hero Section End -->

        <!-- Categories Section Begin -->
        <section class="categories">
            <div class="container">
                <div class="row">
                    <div class="categories__slider owl-carousel">
                        <c:forEach items="${categories}" var="category">
                            <div class="col-lg-3">
                                <div class="categories__item set-bg"
                                     data-setbg="./public/images/category/${category.image}">
                                    <h5><a href="shop?idcategory=${category.id}">${category.name}</a></h5>
                                </div>
                            </div>
                        </c:forEach>
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
                            <h2>Sản phẩm nổi bật</h2>
                        </div>
                    </div>
                </div>
                <div class="row featured__filter">
                    <c:forEach items="${featuredProducts}" var="product">
                        <div class="col-lg-3 col-md-4 col-sm-6 mix ">
                            <div class="featured__item">
                                <div class="featured__item__pic set-bg" style="border: 1px #d2cfcf61 solid;"
                                     data-setbg="./public/images/product/${product.image}">
                                    <ul class="featured__item__pic__hover">
                                        <li><a href="${pageContext.request.contextPath}/shop-details?id=${product.id}" title="Xem chi tiết"><i
                                                    class="fa fa-info-circle"></i></a></li>
                                                <c:if test = "${product.total!=0}">                       
                                            <li>
                                                <a data-id="${product.id}" title="Thêm vào giỏ" style="cursor: pointer" class="btn-add-to-cart"><i class="fa fa-shopping-cart">
                                                    </i></a></li>
                                                </c:if>
                                    </ul>
                                </div>
                                <div class="featured__item__text">
                                    <h6><a href="${pageContext.request.contextPath}/shop-details?id=${product.id}">${product.name}</a></h6>
                                        <c:choose>
                                            <c:when test = "${product.price!=product.sale}">
                                            <h5 class="text-danger"> <fmt:formatNumber value="${product.sale}"
                                                              type="currency" /></h5><span class="text-muted" style="text-decoration-line: line-through;"><fmt:formatNumber value="${product.price}"
                                                    type="currency" /></span>
                                            </c:when>
                                            <c:otherwise>
                                            <h5><fmt:formatNumber value="${product.price}"
                                                              type="currency" /></h5>
                                            </c:otherwise>
                                        </c:choose>
                                </div>
                            </div>
                        </div>
                    </c:forEach>
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

        <!-- Blog Section Begin -->
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
        <!-- Blog Section End -->

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
    </body>

</html>
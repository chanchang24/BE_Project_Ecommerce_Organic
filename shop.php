<?php
require_once './config/database.php';
spl_autoload_register(function ($classname) {
    require './app/models/' . $classname . '.php';
});
session_start();
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
$producModel = new ProductModel();
$categoryModel = new CategoryModel();
$categories = $categoryModel->getCategories();

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
                        <h2>${product.name}</h2>
                        <div class="breadcrumb__option">
                            <a href="./">Home</a>
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
                        <div class="sidebar__item" style="
                                 min-height: 550px; margin-top: 600px
                                 ">
                            <h4>Danh mục</h4>
                            <ul>
                                <c:forEach items="${categoriesAll}" var="category">
                                    <li><a href="?idcategory=${category.id}">${category.name}</a></li>
                                </c:forEach>
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
                                <c:forEach items="${saleOffProducts}" var="product">
                                    <div class="col-lg-4">
                                        <div class="product__discount__item">
                                            <div class="product__discount__item__pic set-bg" data-setbg="./public/images/product/${product.image}">
                                                <div class="product__discount__percent">${Math.ceil(100-(product.sale/product.price*100))}%</div>
                                                <ul class="product__item__pic__hover">
                                                    <li><a href="${pageContext.request.contextPath}/shop-details?id=${product.id}" title="Xem chi tiết"><i class="fa fa-info-circle"></i></a></li>
                                                    <c:if test="${product.total!=0}">
                                                        <li>
                                                            <a data-id="${product.id}" title="Thêm vào giỏ" style="cursor: pointer" class="btn-add-to-cart"><i class="fa fa-shopping-cart">
                                                                </i></a>
                                                        </li>
                                                    </c:if>
                                                </ul>
                                            </div>
                                            <div class="product__discount__item__text">
                                                <h5><a href="${pageContext.request.contextPath}/shop-details?id=${product.id}">${product.name}</a></h5>
                                                <div class="product__item__price">
                                                    <fmt:formatNumber value="${product.sale}" type="currency" /><span>
                                                        <fmt:formatNumber value="${product.price}" type="currency" />
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </c:forEach>
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
                                    <c:if test="${q!=null&&!q.isEmpty()}">
                                        <h6><span>${products.size()}</span> sản phẩm được tìm thấy</h6>
                                    </c:if>
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
                        <c:forEach items="${products}" var="product">
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" style="border: 1px solid #d2cfcf61;" data-setbg="./public/images/product/${product.image}">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="${pageContext.request.contextPath}/shop-details?id=${product.id}" title="Xem chi tiết"><i class="fa fa-info-circle"></i></a></li>
                                            <c:if test="${product.total!=0}">
                                                <li>
                                                    <a data-id="${product.id}" title="Thêm vào giỏ" style="cursor: pointer" class="btn-add-to-cart"><i class="fa fa-shopping-cart">
                                                        </i></a>
                                                </li>
                                            </c:if>

                                        </ul>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a href="${pageContext.request.contextPath}/shop-details?id=${product.id}">${product.name}</a></h6>
                                        <c:choose>
                                            <c:when test="${product.price!=product.sale}">
                                                <h5 class="text-danger">
                                                    <fmt:formatNumber value="${product.sale}" type="currency" />
                                                </h5><span class="text-muted" style="text-decoration-line: line-through;">
                                                    <fmt:formatNumber value="${product.price}" type="currency" />
                                                </span>
                                            </c:when>
                                            <c:otherwise>
                                                <h5>
                                                    <fmt:formatNumber value="${product.price}" type="currency" />
                                                </h5>
                                            </c:otherwise>
                                        </c:choose>
                                    </div>
                                </div>
                            </div>
                        </c:forEach>
                    </div>
                    <div class="product__pagination">
                        <c:if test="${currentPage!=1}">
                            <a href="?${qsearch}page=${currentPage-1}"><i class="fa fa-long-arrow-left"></i></a>
                        </c:if>
                        <c:forEach var="i" begin="1" end="${maxPage}">
                            <c:choose>
                                <c:when test="${currentPage==i}">
                                    <a href="?${qsearch}page=${i}" class="page-active">${i}</a>
                                </c:when>
                                <c:otherwise>
                                    <a href="?${qsearch}page=${i}">${i}</a>
                                </c:otherwise>
                            </c:choose>
                        </c:forEach>
                        <c:if test="${currentPage<maxPage}">
                            <a href="?${qsearch}page=${currentPage+1}"><i class="fa fa-long-arrow-right"></i></a>
                        </c:if>
                    </div>
                    <c:remove var="qsearch" />
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
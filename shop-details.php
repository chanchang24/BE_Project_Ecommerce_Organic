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
                        <h2>${product.name}</h2>
                        <div class="breadcrumb__option">
                            <a href="./">Home</a>
                            <a href="./index.php">Shop</a>
                            <span>${product.name}</span>
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
                            <img class="product__details__pic__item--large" src="./public/images/product/${product.image}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product__details__text">
                        <h3>${product.name}</h3>
                        <div class="product__details__rating">
                            <c:forEach begin="1" end="${averageStar}">
                                <i class="fa fa-star"></i>
                            </c:forEach>
                            <c:forEach begin="1" end="${5-Math.floor(averageStar)}">
                                <i class="fa fa-star-o"></i>
                            </c:forEach>
                            <span>(${productReviews.size()} reviews)</span>
                        </div>
                        <form action="AddToCart">
                            <div class="product__details__price ">
                                <c:choose>
                                    <c:when test="${product.price!=product.sale}">
                                        <fmt:formatNumber value="${product.sale}" type="currency" /><br><span class="text-muted fs-5" style="text-decoration-line: line-through;">
                                            <fmt:formatNumber value="${product.price}" type="currency" />
                                        </span>
                                    </c:when>
                                    <c:otherwise>
                                        <fmt:formatNumber value="${product.price}" type="currency" />
                                    </c:otherwise>
                                </c:choose>
                            </div>
                            <c:choose>
                                <c:when test="${product.total<=0}">
                                    <div class="text-danger fs-3 my-2 font-weight-bold">
                                        Hết Hàng
                                    </div>
                                </c:when>
                                <c:otherwise>
                                    <div class="product__details__quantity">
                                        <div class="mb-3">
                                            Số Lượng còn : ${product.total}
                                        </div>
                                        <div class="quantity">
                                            <input type="hidden" name="id" value="${product.id}">
                                            <input type="number" class="form-control total-input-product" name="total" value="1" min="1" max="${product.total}">
                                        </div>
                                    </div>
                                </c:otherwise>
                            </c:choose>

                            <button class='primary-btn btn' aria-disabled="true" <c:if test="${product.total==0}">style="
                                opacity: .6;
                                cursor: no-drop;
                                pointer-events: none;
                                "</c:if>> THÊM VÀO GIỎ</button>
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
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab" aria-selected="false">Đánh giá <span>(${productReviews.size()})</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__tab__desc">
                                    <h6>Mô tả chi tiết sản phẩm</h6>
                                    <div>
                                        ${product.description}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " id="tabs-3" role="tabpanel">
                                <div class="w-75 mx-auto card mt-2">
                                    <div class="row">
                                        <div class="col-6 card p-4">
                                            <h4 class="my-3">Trung bình: ${Math.round(averageStar*100.0)/100.0} <br> </h4>
                                            <h3>
                                                <c:forEach begin="1" end="${averageStar}">
                                                    <i class="fa fa-star text-warning fs-1"></i>
                                                </c:forEach>
                                                <c:forEach begin="1" end="${5-Math.floor(averageStar)}">
                                                    <i class="fa fa-star-o text-warning fs-1"></i>
                                                </c:forEach>
                                            </h3>
                                            <p class="fw-light font-italic mt-3"> Trong tổng số ${productReviews.size()} lượt đánh giá </p>
                                        </div>
                                        <div class="col-6 card p-5">
                                            <div class="row">
                                                <div class="col-2 text-end">
                                                    5 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-success" role="progressbar" style="" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">${statisticsReview[4]}</div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-end">
                                                    4 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">${statisticsReview[3]}</div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-end">
                                                    3 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-info" role="progressbar" style="" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">${statisticsReview[2]}</div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-end">
                                                    2 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-warning" role="progressbar" style="" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">${statisticsReview[1]}</div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-end">
                                                    1 <i class="fa fa-star text-warning"></i>
                                                </div>
                                                <div class="col-10" style=" padding: 5px 0; ">
                                                    <div class="progress ">
                                                        <div class="progress-bar bg-danger" role="progressbar" style="" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">${statisticsReview[0]}</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="product__details__tab__desc">
                                    <c:forEach items="${productReviews}" var="productReview">
                                        <div class="px-5 w-75 mx-auto card">
                                            <div class="row py-3">
                                                <div class="col-sm-4">
                                                    <div class="review-block-name fs-5 fw-bold">${productReview.user}</div>
                                                    <div class="review-block-date">
                                                        <fmt:formatDate pattern="hh:mma  yyyy-MM-dd" value="${productReview.date}" /><br />
                                                        <span class="fw-lighter fst-italic">
                                                            <script>
                                                                document.write(moment("${productReview.date}").fromNow());
                                                            </script>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7">
                                                    <div class="review-block-rate text-warning" style="font-size: 20px;">
                                                        <c:forEach begin="1" end="${productReview.rating}">
                                                            <i class="fa fa-star"></i>
                                                        </c:forEach>
                                                    </div>
                                                    <div class="review-block-description pt-2"> <span class="fw-bold"> Nhận xét:</span> ${productReview.content}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </c:forEach>
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
                <c:forEach items="${relatedProducts}" var="relatedProduct">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="./public/images/product/${relatedProduct.image}">
                                <ul class="product__item__pic__hover">
                                    <li><a href="${pageContext.request.contextPath}/shop-details?id=${relatedProduct.id}" title="Xem chi tiết"><i class="fa fa-info-circle"></i></a></li>
                                    <c:choose>
                                        <c:when test="${relatedProduct.total!=0}">
                                            <li><a data-id="${relatedProduct.id}" title="Thêm vào giỏ" style="cursor: pointer" class="btn-add-to-cart"><i class="fa fa-shopping-cart"></i></a></li>
                                        </c:when>
                                        <c:otherwise>
                                        </c:otherwise>
                                    </c:choose>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a href="${pageContext.request.contextPath}/shop-details?id=${relatedProduct.id}">${relatedProduct.name}</a></h6>
                                <h5>
                                    <fmt:formatNumber value="${relatedProduct.price}" type="currency" />
                                </h5>
                            </div>
                        </div>
                    </div>
                </c:forEach>
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

    <!-- Footer Section Begin -->
    <jsp:include page="footer.jsp"></jsp:include>
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

</html>
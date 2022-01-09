<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$categoryModel =  new CategoryModel();
$productModel = new ProductModel();
$product = [];
$categoryByProduct = [];
$fmt = numfmt_create( 'vi_VN', NumberFormatter::CURRENCY );
if (isset($_GET['id'])) {
    $product = $productModel->getProduct($_GET['id']);
    if (!isset($product)) {
        header("Location: ProductManagement.php");
        exit;
    }
    $categoryByProduct = $categoryModel->getCategoryByProduct($_GET['id']);
} else {
    header("Location: ProductManagement.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Chi tiết sản phẩm"  ?>
    <?php include("head-admin.php"); ?>
</head>
<style>
    .checked-star {
        color: orange;
    }
</style>

<body>
    <div class="sb-nav-fixed">
    <?php include("nav-admin.php");
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-capitalize">Thông tin chi tiết sản phẩm</h1>
                    <div class="card mb-4">
                        <div class="card-header border-bottom">
                            <div class="row justify-content-around">
                                <div class="col-md-3">
                                    <div class="">
                                        <a class="btn btn-primary" href="<?php echo isset($_SESSION["previousPageProduct"]) ? $_SESSION["previousPageProduct"] : "product-management"; ?>">
                                            <i class="fas fa-backspace"></i> Trang quản lý sản phẩm</a>
                                    </div>
                                </div>
                                <div class="col-md-9  justify-content-around">
                                    <div class="row justify-content-around">
                                        <div class="col-md-4 text-center">
                                            <a class="btn btn-warning" href="UpdateProduct.php?id=<?php echo $product['id'] ?>">
                                                Cập nhật sản phẩm <i class=" fas fa-edit"></i>
                                            </a>
                                        </div>

                                        <div class="col-md-4 text-center">
                                            <button class="btn btn-danger  " data-bs-toggle="modal" data-bs-target="#delete-product-<?php echo $product['id'] ?>" title="Xoá">
                                                Xoá sản phẩm <i class="fas fa-trash-alt"></i></button>
                                            <div class="modal fade" id="delete-product-<?php echo $product['id'] ?>" tabindex="-1" aria-labelledby="delete-product-<?php echo $product['id'] ?>" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                                                <div>
                                                                    <p class="fs-5">
                                                                        <i class="fas fa-exclamation-triangle"></i>
                                                                        Bạn muốn xoá sản phẩm này?
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <form action="DeleteProduct.php" method="post">
                                                                <input type="hidden" value="<?php echo $product['id'] ?>" name="id" />
                                                                <button type="submit" class="btn btn-danger">OK</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body mt-2">
                                <div class="product-head">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="../public/images/products/<?php echo $product['product_main_image'] ?>" alt="" class="img-fluid">
                                        </div>
                                        <div class="col-md-6">
                                            <h2 class=" my-4 fs-1 fw-bold">
                                            <?php echo $product['product_name'] ?>
                                            </h2>
                                            <h4 class="my-3">
                                                <i class="fas fa-tags"></i> Giá gốc:
                                                <?php  echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                            </h4>
                                            <h4 class="my-3 link-danger">
                                                <i class="fas fa-tags"></i> Giá khuyến mãi :
                                                <?php  echo numfmt_format_currency($fmt, $product['product_promotional_price'], "VND"); ?>
                                            </h4>
                                            <h5 class="fw-bold my-4 fst-italic">
                                            Số lượng: <?php echo $product['product_quantily'] ?>
                                            </h5>
                                            <h6 class="fw-light fst-italic">
                                                Thời gian thêm sản phẩm: <span class="fw-normal">
                                                <?php echo $product['product_create_at'] ?>
                                                </span>
                                            </h6>
                                            <div class=" mt-4">
                                                <h6>
                                                    Thuộc danh mục:
                                                </h6>
                                                <p>
                                                    <?php echo join(', ',  $categoryByProduct ) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-description">
                                    <h3 class="my-4 text-center border-bottom">
                                        Mô tả sản phẩm
                                    </h3>
                                    <div>
                                    <?php echo $product['product_description'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </main>
            <?php include("footer-admin.php"); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../public/js/scripts.js"></script>
</body>

</html>
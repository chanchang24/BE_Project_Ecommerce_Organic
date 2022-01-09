<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$_SESSION['previousPageProduct'] = $_SERVER['REQUEST_URI'];
$perPage = 3;
$currentPage = 1;
$productCount = 0;
$query = "";
$q = "";
$fmt = numfmt_create('vi_VN', NumberFormatter::CURRENCY);
$producModel = new ProductModel();
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
}
if (isset($_GET['q'])) {
    $q = $_GET['q'];
    $query .= '&q=' . $q;
    $products = $producModel->getProductsByKey($currentPage, $perPage, $q);
    $productCount = $producModel->getProductsCountByKey($currentPage, $perPage, $q);
} else {
    $products = $producModel->getProducts($currentPage, $perPage);
    $productCount = $producModel->getProductCount();
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "Quản lý sản phẩm"  ?>
    <?php include("head-admin.php"); ?>
</head>

<body>
    <div class="sb-nav-fixed">
        <?php include("nav-admin.php");
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-capitalize"><?php echo $title ?></h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table"></i>
                            Danh sách sản phẩm
                        </div>
                        <div>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_SESSION['success']) && isset($_SESSION['message'])) { ?>
                                <div class="col-md-12">
                                    <div class="alert <?php echo $_SESSION['success'] ? "alert-success" : "alert-danger" ?>  alert-dismissible fade show" role="alert">
                                        <?php echo $_SESSION['message'] ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            <?php
                                unset($_SESSION['message']);
                                unset($_SESSION['success']);
                            } ?>
                            <div class="row">
                                <div class="col-8">
                                    <div class="row g-6 align-items-center justify-content-md-center">
                                        <form method="get">
                                            <div class="input-group mb-3 input-group-sm">
                                                <input type="text" class="form-control " value="<?php echo $q ?>" name="q" required placeholder="Nhập tên sản phẩm cần tìm ">
                                                <button class="btn btn-outline-primary " type="submit" id="button-addon2"><i class="fas fa-search"></i>
                                                    Tìm </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="d-inline-block float-end"><a class="btn btn-success btn-sm" href="./add-product">Thêm sản
                                            phẩm</a></div>
                                </div>
                            </div>
                            <table class="table table-bordered caption-top table-sm">
                                <caption>
                                    Hiển thị các sản phẩm từ <?php $start =  ($currentPage - 1) * $perPage +1;  echo $productCount!=0?$start:0 ?> - <?php echo ($currentPage - 1) * $perPage + count($products) ?>
                                    trong tổng số <?php echo $productCount ?> sản phẩm
                                </caption>

                                <thead>
                                    <tr style="border-top: inherit;border-bottom: outset;">
                                        <th scope="col">Tên</th>
                                        <th scope="col">Ảnh</th>
                                        <th scope="col">Giá</th>
                                        <th scope="col">Số lượng </th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) { ?>
                                        <tr>
                                            <td class="text-wrap fs-5 " style="min-width: 120px;">
                                                <?php echo $product['product_name'] ?>
                                            </td>
                                            <td>
                                                <div class="ratio ratio-4x3" style="max-width: 80px;">
                                                    <div><img src="../public/images/products/<?php echo $product['product_main_image'] ?>" class="img-thumbnail" alt="" sizes=""></div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <?php echo numfmt_format_currency($fmt, $product['product_price'], "VND"); ?>
                                            </td>
                                            <td class="text-end">
                                                <?php echo $product['product_quantily'] ?>
                                            </td>
                                            <td style="max-width: 80px;">
                                                <?php echo $product['product_create_at'] ?>
                                            </td>
                                            <td style="max-width: 80px; ">
                                                <a href="ProductDetails.php?id=<?php echo $product['id'] ?> " class="btn btn-info btn-sm" title="Xem chi tiết"><i class="fas fa-info-circle"></i></a>
                                                <a href="UpdateProduct.php?id=<?php echo $product['id'] ?> " class="btn btn-warning  btn-sm" title="Sửa"><i class="fas fa-edit"></i></a>

                                                <button class="btn btn-danger  btn-sm" data-bs-toggle="modal" data-bs-target="#delete-product-<?php echo $product['id'] ?>" title="Xoá">
                                                    <i class="fas fa-trash-alt"></i></button>
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
                                                                            Bạn có muốn xoá sản phẩm <span class="fw-bold"><?php echo $product['product_name'] ?></span>?
                                                                        </p>
                                                                        <div class="ratio ratio-4x3 mx-auto" style="max-width: 150px;">
                                                                            <div><img src="../public/images/products/<?php echo $product['product_main_image'] ?>" class="img-thumbnail" alt="" sizes=""></div>
                                                                        </div>
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
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!--PHÂN TRANG-->
                            <?php include("Pagination.php") ?>
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
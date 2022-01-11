<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$categoryModel =  new CategoryModel();
$productModel = new ProductModel();
$productUpdate = [];
$categoriesProduct = [];
$categories = $categoryModel->getCategories();
if (isset($_POST['product'])) {
    $product = $_POST['product'];
    $product += ["product_main_image" => ""];
    if ($_FILES['product_main_image']) {
        move_uploaded_file($_FILES['product_main_image']['tmp_name'], "../public/images/products/" . $_FILES['product_main_image']['name']);
        $product['product_main_image'] = $_FILES['product_main_image']['name'];
    }
    var_dump($product);
    $productModel->deleteCategoryProduct($product['id']);
    if ($productModel->updateProduct($product) > 0) {
        $_SESSION['message'] = "Cập nhật sản phẩm thành công";
        $_SESSION['success'] = true;
        if (isset($_SESSION['previousPageProduct'])) {
            header("Location: " . $_SESSION['previousPageProduct']);
        } else {
            header("Location: ProductManagement.php");
        }
        exit;
    } else {
        $_SESSION['message'] = "Cập nhật sản phẩm thất bại";
        $_SESSION['success'] = false;
    }

}
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $productUpdate =  $productModel->getProduct($_GET['id']);
    if (!isset($productUpdate)) {
        header("Location: ProductManagement.php");
        exit;
    }
    $categoriesProduct = $productModel->getCategoriesProduct($_GET['id']);
} else {
    header("Location: ProductManagement.php");
    exit;
}

?>
<!DOCTYPE html>
<html>

<head>
    <?php $title = "Cập nhật sản phẩm"  ?>
    <?php include("head-admin.php"); ?>
</head>

<body>

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
                                <svg class="svg-inline--fa fa-table fa-w-16 me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor" d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM224 416H64v-96h160v96zm0-160H64v-96h160v96zm224 160H288v-96h160v96zm0-160H288v-96h160v96z">
                                    </path>
                                </svg>
                                Cập nhật sản phẩm
                            </div>
                            <div class="card-body">
                                <a href="<?php echo isset($_SESSION["previousPageProduct"]) ? $_SESSION["previousPageProduct"] : "product-management"; ?>" class="btn btn-primary btn-sm mb-4"><i class="fas fa-arrow-left"></i> Trang quản lí sản phẩm</a>
                                <form class="row g-3" enctype="multipart/form-data" method="post">
                                    <?php if (isset($_SESSION["message"])) { ?>
                                        <div class="col-md-12">
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $_SESSION["message"] ?>
                                            </div>
                                        </div>
                                    <?php
                                        unset($_SESSION['message']);
                                    } ?>
                                    <div class="col-md-12">
                                        <input type="hidden" name="product[id]" value="<?php echo $productUpdate['id'] ?>">
                                        <label for="nameProduct" class="form-label">Tên Sản Phẩm</label>
                                        <input type="text" class="form-control" name="product[product_name]" id="nameProduct" value="<?php echo $productUpdate['product_name'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="priceProduct" class="form-label">Giá gốc</label>
                                        <input type="number" name="product[product_price]" step="0.1" min="0" value="<?php echo $productUpdate['product_price'] ?>" class="form-control" id="priceProduct" value="0" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="saletProduct" class="form-label">Giá khuyến
                                            mãi</label>
                                        <input type="number" class="form-control" name="product[product_promotional_price]" min="0" value="<?php echo $productUpdate['product_promotional_price'] ?>" placeholder="0" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="amountProduct" class="form-label">Số Lượng Sản
                                            Phẩm</label>
                                        <input type="number" class="form-control" name="product[product_quantity]" min="0" value="<?php echo $productUpdate['product_quantity'] ?>" id="amountProduct" step="1" value="0" placeholder="0" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Danh Mục Sản Phẩm</label>
                                        <div class="overflow-auto" style="max-height: 80px;">
                                            <?php foreach ($categories as $category) { ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" name="product[category_id][]" type="checkbox" value="<?php echo $category['id'] ?>" <?php echo in_array($category['id'],  $categoriesProduct) ? "checked" : ""  ?> id="labelCategory<?php echo $category['id'] ?>">
                                                    <label class="form-check-label" for="labelCategory<?php echo $category['id'] ?>">
                                                        <?php echo $category['category_name'] ?>
                                                    </label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Ảnh Đại Diện Sản
                                            Phẩm</label>
                                        <br>
                                        <label for="formFile" class="btn btn-success"> Upload</label>
                                        <input class="form-control" type="file" id="formFile" name="product_main_image" onchange="readURL(this)" hidden>
                                        <div style="max-width: 200px" class="mt-3 position-relative" id="ratio-image">
                                            <div class="position-absolute top-0 end-0" style="z-index: 3">
                                                <button type="button" class="btn-close btn-lg" id="btn-close-image" aria-label="Close"></button>
                                            </div>
                                            <div class="ratio ratio-1x1">
                                                <img id="input-image" src="../public/images/products/<?php echo $productUpdate['product_main_image'] ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <span>Chi Tiết Sản Phẩm</span>
                                            <textarea class="form-control" name="product[product_description]" placeholder="Leave a comment here" id="chi-tiet-editor" style="height: 100px" autocomplete="off">
                                            <?php echo $productUpdate['product_description'] ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#product-update" class="btn btn-primary  btn-sm"> Cập Nhật</button>
                                        <div class="modal fade" id="product-update" tabindex="-1" aria-labelledby="product-${product.id}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Thông báo
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert alert-info d-flex align-items-center" role="alert">
                                                            <div>
                                                                <p class="fs-5">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                    Bạn muốn cập nhật thông tin sản phẩm này ?
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">OK</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include("footer-admin.php"); ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../public/js/scripts.js"></script>
        <script>
            CKEDITOR.replace('chi-tiet-editor');
            let btnCloseImage = document.querySelector('#btn-close-image');
            let imageProduct = document.querySelector('#input-image')
            let ratioImage = document.querySelector('#ratio-image');
            let defaultImage = true;
            btnCloseImage.addEventListener("click", function() {
                if (defaultImage) {
                    ratioImage.classList.add("d-none");
                    imageProduct.disabled = true;
                }
            })
            let btnUploadImage = document.querySelector('#btn-upload-image')

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        imageProduct.src = e.target.result;
                        ratioImage.classList.remove("d-none");
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    </body>

</html>
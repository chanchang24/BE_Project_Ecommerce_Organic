<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$categoryModel =  new CategoryModel();
$ProductModel = new ProductModel();
$categories = $categoryModel->getCategories();
if (isset($_POST['product'])) {
    $productModel = new ProductModel();
    $product = $_POST['product'];
    move_uploaded_file($_FILES['product_main_image']['tmp_name'], "../public/images/products/" . $_FILES['product_main_image']['name']);
    $product += ["product_main_image" => $_FILES['product_main_image']['name']];
    if ($productModel->insertProduct($product) > 0) {
        $_SESSION['message'] = "Thêm sản phẩm thành công";
        $_SESSION['success'] = true;
        if (isset($_SESSION['previousPageProduct'])) {
            header("Location: " . $_SESSION['previousPageProduct']);
        } else {
            header("Location: ProductManagement.php");
        }
        exit;
    } else {
        $_SESSION['message'] = "Thêm sản phẩm thất bại";
        $_SESSION['success'] = false;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Thêm sản phẩm"  ?>
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
                            <svg class="svg-inline--fa fa-table fa-w-16 me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="table" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                <path fill="currentColor" d="M464 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V80c0-26.51-21.49-48-48-48zM224 416H64v-96h160v96zm0-160H64v-96h160v96zm224 160H288v-96h160v96zm0-160H288v-96h160v96z">
                                </path>
                            </svg>
                            Thêm sản phẩm mới vào kho
                        </div>
                        <div class="card-body">
                            <a href="<?php echo isset($_SESSION["previousPageProduct"]) ? $_SESSION["previousPageProduct"] : "product-management"; ?>" class="btn btn-primary btn-sm mb-4"><i class="fas fa-arrow-left"></i> Trang quản lí sản phẩm</a>
                            <form class="row g-3" action="add-product" enctype="multipart/form-data" method="post">
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
                                    <label for="nameProduct" class="form-label">Tên Sản Phẩm</label>
                                    <input type="text" class="form-control" name="product[product_name]" id="nameProduct" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="priceProduct" class="form-label">Giá Sản Phẩm</label>
                                    <input type="number" name="product[product_price]" step="0.1" min="0" class="form-control" id="priceProduct" value="0" required>
                                </div>
                                <div class="col-6">
                                    <label for="amountProduct" class="form-label">Số Lượng Sản Phẩm</label>
                                    <input type="number" class="form-control" name="product[product_quantily]" min="0" id="amountProduct" value="0" placeholder="0" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Danh Mục Sản Phẩm</label>
                                    <div class="overflow-auto" style="max-height: 80px;">
                                        <?php foreach ($categories as $category) { ?>
                                            <div class="form-check">
                                                <input class="form-check-input" name="product[category_id][]" type="checkbox" value="<?php echo $category['id'] ?>" id="labelCategory<?php echo $category['id'] ?>">
                                                <label class="form-check-label" for="labelCategory<?php echo $category['id'] ?>">
                                                    <?php echo $category['category_name'] ?>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress2" class="form-label">Ảnh Đại Diện Sản
                                        Phẩm</label>
                                    <input class="form-control" type="file" id="formFile" name="product_main_image" onchange="readURL(this);" required>
                                    <img id="input-image" class="mt-3" width="200px" />
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <span>Chi Tiết Sản Phẩm</span>
                                        <textarea class="form-control" name="product[product_description]" placeholder="Leave a comment here" id="chi-tiet-editor" style="height: 100px" autocomplete="off"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success">Thêm</button>
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

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    document.querySelector('#input-image').src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
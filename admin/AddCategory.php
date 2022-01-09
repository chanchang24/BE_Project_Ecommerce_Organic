<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$categoryModel = new CategoryModel();
if (isset($_POST['category'])) {
    $category = $_POST['category'];
    move_uploaded_file($_FILES['category_image']['tmp_name'], "../public/images/category/" . $_FILES['category_image']['name']);
    $category += ["category_image" => $_FILES['category_image']['name']];
    if ($categoryModel->insert($category) > 0) {
        $_SESSION['message'] = "Thêm danh mục thành công";
        $_SESSION['success'] = true;
            header("Location: CategoryManagement.php");
        exit;
    } else {
        $_SESSION['message'] = "Thêm danh mục thất bại";
        $_SESSION['success'] = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Thêm Danh mục"  ?>
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
                            Thêm Danh mục mới
                        </div>
                        <div class="card-body">
                            <a href="CategoryManagement.php" class="btn btn-primary btn-sm mb-4"><i class="fas fa-arrow-left"></i> Trang quản lí danh mục</a>
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
                                    <label for="nameProduct" class="form-label">Tên Danh mục</label>
                                    <input type="text" class="form-control" name="category[category_name]" id="nameProduct" required>
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress2" class="form-label">Ảnh Danh mục</label>
                                    <input class="form-control" type="file" id="formFile" name="category_image" onchange="readURL(this);" required>
                                    <img id="#input-image" class="mt-3" width="200px" />
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <span>Chú thích danh mục</span>
                                        <input type="text" class="form-control" name="category[category_title]" id="category_title" >
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
    <script src="./public/js/scripts.js"></script>
    <script>

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
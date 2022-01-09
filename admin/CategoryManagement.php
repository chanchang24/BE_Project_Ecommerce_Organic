<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$categoryModel = new CategoryModel();
$categories = $categoryModel->getCategories();
?>
<!DOCTYPE html>
<html>

    <head>
    <?php $title = "Quản lý Danh mục"  ?>
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
                                Danh sách danh mục
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
                                    </div>
                                    <div class="col-4">
                                        <div class="d-inline-block float-end"><a class="btn btn-success btn-sm"
                                                                                 href="AddCategory">Thêm danh mục</a></div>
                                    </div>
                                </div>
                                <table class="table table-bordered caption-top table-sm">
                                    <caption>
                                       Tổng danh mục : <?php echo count($categories) ?>
                                    </caption>

                                    <thead>
                                        <tr style="border-top: inherit;border-bottom: outset;">
                                            <th scope="col">Tên</th>
                                            <th scope="col">Ảnh</th>
                                            <th scope="col">Chú thích</th>
                                            <th scope="col">Ngày tạo</th>
                                            <th scope="col">Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach($categories as $category){ ?>
                                            <tr>
                                                <td class="text-wrap "  style="max-width: 100px;">
                                                    <span class="fs-4"><?php echo $category['category_name']; ?></span>
                                                </td>
                                                <td>
                                                    <div class="ratio ratio-4x3" style="max-width: 80px;">
                                                        <div><img src="../public/images/category/<?php echo $category['category_image']; ?>"
                                                                  class="img-thumbnail" alt="" sizes=""></div>
                                                    </div>
                                                </td>
                                                <td class="text-wrap "  style="max-width: 100px;">
                                                <?php echo $category['category_title']; ?>
                                                </td>
                                                <td style="max-width: 30px;">
                                                <?php echo $category['category_create_at']; ?>
                                                </td>
                                                <td style="max-width: 20px; ">
                                                    <a href="UpdateCategory.php?id=<?php echo $category['id']; ?>" class="btn btn-warning  btn-sm" title="Sửa"><i
                                                            class="fas fa-edit"></i></a>

                                                    <button class="btn btn-danger  btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete-category-<?php echo $category['id']; ?>"
                                                            title="Xoá">
                                                        <i class="fas fa-trash-alt"></i></button>
                                                    <div class="modal fade" id="delete-category-<?php echo $category['id']; ?>"
                                                         tabindex="-1"
                                                         aria-labelledby="delete-category-<?php echo $category['id']; ?>"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="exampleModalLabel">Thông báo</h5>
                                                                    <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="alert alert-warning d-flex align-items-center"
                                                                         role="alert">
                                                                        <div>
                                                                            <p class="fs-5">
                                                                                <i
                                                                                    class="fas fa-exclamation-triangle"></i>
                                                                                Bạn có muốn xoá danh mục  <span
                                                                                    class="fw-bold"><?php echo $category['category_name']; ?></span>?
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="DeleteCategory.php" method="post">
                                                                        <input type="hidden"
                                                                               value="<?php echo $category['id']; ?>" name="id" />
                                                                        <button type="submit"
                                                                                class="btn btn-danger">OK</button>
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
                            </div>
                        </div>
                    </div>
                </main>
                <?php include("footer-admin.php"); ?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
                crossorigin="anonymous">
        </script>
        <script src="../public/js/scripts.js"></script>
    </body>
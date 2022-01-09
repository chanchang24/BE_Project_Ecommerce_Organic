<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$ProductModel = new ProductModel();
if (isset($_POST['id'])) {
    $productModel = new ProductModel();
    $id = $_POST['id'];
    $productModel->deleteCategoryProduct($id);
    if ($productModel->deleteProduct($id) > 0) {
        $_SESSION['message'] = "Xoá sản phẩm thành công";
        $_SESSION['success'] = true;
    } else {
        $_SESSION['message'] = "Xoá sản phẩm thất bại";
        $_SESSION['success'] = false;
    }
    header("Location: " . $_SESSION['previousPageProduct']);
    exit;
}

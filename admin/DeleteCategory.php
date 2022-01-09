<?php
require_once '../config/database.php';
spl_autoload_register(function ($classname) {
    require '../app/models/' . $classname . '.php';
});
session_start();
$categoryModel = new CategoryModel();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $categoryModel->deleteRelationshipProduct($id);
    if ($categoryModel->deleteCategory($id) > 0) {
        $_SESSION['message'] = "Xoá danh mục thành công";
        $_SESSION['success'] = true;
    } else {
        $_SESSION['message'] = "Xoá danh mục thất bại";
        $_SESSION['success'] = false;
    }
    header("Location: CategoryManagement.php");
    exit;
}

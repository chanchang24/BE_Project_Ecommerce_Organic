<?php
require_once '../../config/database.php';
spl_autoload_register(function ($classname) {
    require '../models/' . $classname . '.php';
});
session_start();
if (isset($_POST['idProduct'])) {
    $orderModel = new OrderModel();
    $productModel = new ProductModel();
    $productModel->insertReview($_POST['username'], $_POST['content'], $_POST['ratingStar'], $_POST['idProduct']);
    $orderModel->updateRated($_POST['idTransaction'], $_POST['idProduct']);
}

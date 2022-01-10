<?php
require_once '../../config/database.php';
spl_autoload_register(function ($classname) {
    require '../models/' . $classname . '.php';
});
session_start();
$producModel = new ProductModel();
if (isset($_POST['pageNewProduct'])) {
   $products =  $producModel->getNewProducts($_POST['pageNewProduct'], $_POST['numProduct']);
   echo json_encode($products);
}
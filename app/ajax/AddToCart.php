<?php
require_once '../../config/database.php';
spl_autoload_register(function ($classname) {
    require '../models/' . $classname . '.php';
});
session_start();
$product = [];
if (isset($_POST['idadd'])) {
    $id = $_POST['idadd'];
    $cart = [];
    if (isset($_SESSION['cart'])) {
        $cart  = $_SESSION['cart'];
    }
    $productModel = new ProductModel();
    $product = $productModel->getProductByID($id);
    if (in_array($id, array_column($cart, 'id'))) {
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['id'] == $id) {
                $p = $cart[$i];
                if ($product['product_quantily'] > $p['product_quantily']) {
                    $p['product_quantily'] = $p['product_quantily'] + 1;
                }
                $cart[$i] =  $p;
            }
        }
    } else {
        $product+=["max_quantily"=>$product['product_quantily']];
        $product['product_quantily'] = 1;
        array_push($cart, $product);
    }
    $_SESSION['cart'] = $cart;
    $amount = 0;
    foreach ($cart as $item) {
        $amount += $item['product_quantily'] * $item['product_promotional_price'];
    }
    $_SESSION['amount'] = $amount;
    $obj = [
        "productName" => $product['product_name'],
        "amount" => $amount,
        "total" => count($cart)
    ];
    echo json_encode($obj);
}

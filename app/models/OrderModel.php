<?php
class OrderModel extends DB
{
    public function getCountOrdersByKey($key)
    {
        $key  = $key . "%";
        $sql = parent::$connection->prepare("SELECT COUNT(id) FROM `orders` WHERE id LIKE ?");
        $sql->bind_param("s", $key);
        return parent::select_one($sql)['COUNT(id)'];
    }
    public function insertOrder($order)
    {
        $sql = parent::$connection->prepare("INSERT INTO `orders`( `order_account_id`, `order_user_fullname`, `order_phone`, `order_adress`, `order_total_price`) VALUES (?,?,?,?,?);");
        $sql->bind_param("issss", $order['order_account_id'], $order['order_user_fullname'], $order['order_phone'], $order['order_adress'], $order['order_total_price']);
        $sql->execute();
        return parent::$connection->insert_id;
    }
    public function getOrderItems($id)
    {
        $sql = parent::$connection->prepare("SELECT * FROM `order_item` WHERE order_id =?;");
        $sql->bind_param("i", $id);
        return parent::select($sql);
    }
    public function insertOrderItem($orderItem)
    {
        //
        $sql = parent::$connection->prepare("INSERT INTO `order_item`(`order_id`, `order_product_id`, `order_product_name`, `order_product_image`, `order_product_price`, `order_item_qty`) VALUES (?,?,?,?,?,?);");
        $sql->bind_param("iissss", $orderItem['order_id'], $orderItem['order_product_id'], $orderItem['order_product_name'], $orderItem['order_product_image'], $orderItem['order_product_price'], $orderItem['order_item_qty']);
        return  $sql->execute();
    }
    public function updateFinish($id)
    {
        $sql = parent::$connection->prepare("UPDATE `orders` SET `order_status`=2 WHERE id = ? LIMIT 1;;");
        $sql->bind_param("i", $id);
        return  $sql->execute();
    }
    public function getOrder($id)
    {
        $sql = parent::$connection->prepare("SELECT * FROM `orders` WHERE id = ? LIMIT 1");
        $sql->bind_param("i", $id);
        return parent::select_one($sql);
    }
    public function getOrdersByKey($numberPage, $perPage, $key)
    {
        $numberPage = ($numberPage - 1) * $perPage;
        $key  = "%" . str_replace(" ", "%", $key) . "%";
        $sql = parent::$connection->prepare("SELECT * FROM `orders` WHERE id LIKE ?  LIMIT ? , ?;");
        $sql->bind_param("sii", $key, $numberPage, $perPage);
        return  parent::select($sql);
    }
    public function getOrdersByIDAccount($id)
    {
        $sql = parent::$connection->prepare("SELECT * FROM `orders` WHERE order_account_id = ? ;");
        $sql->bind_param("i", $id);
        return  parent::select($sql);
    }
    public function updateRated($idOrder, $idProduct)
    {
        $sql = parent::$connection->prepare("UPDATE `order_item` SET `order_rated`= 1 WHERE order_id = ? AND order_product_id = ? LIMIT 1;;");
        $sql->bind_param("ii", $idOrder, $idProduct);
        return  $sql->execute();
    }
   
}

<?php
class ProductModel extends DB
{
    //lấy tất cả sản phẩm
    public function getCategories()
    {
        //2.Viết câu SQL
        $sql = parent::$connection->prepare("SELECT * FROM categories");
        return parent::select($sql);
    }
    public function insertProduct($product)
    {
        $sql = parent::$connection->prepare("INSERT INTO `products`(`product_name`, `product_price`, `product_promotional_price`, `product_quantily`, `product_main_image`, `product_description`) VALUES (?,?,product_price,?,?,?);");
        $sql->bind_param('sdiss', $product['product_name'],  $product['product_price'],  $product['product_quantily'],  $product['product_main_image'], $product['product_description']);
        if (!$sql->execute()) {
            return -1;
        }
        $idProduct = parent::$connection->insert_id;
        foreach ($product['category_id'] as $category_id) {
            $sqlPC = parent::$connection->prepare("INSERT INTO `category_product`(`category_id`, `product_id`) VALUES (?,?)");
            $sqlPC->bind_param('dd', $category_id, $idProduct);
            if (!$sqlPC->execute()) {
                return -1;
            }
        }
        return $idProduct;
    }
    public function updateProduct($product) // 
    {
        $sql = parent::$connection->prepare("UPDATE `products` SET`product_name`=?,`product_price`=?,`product_promotional_price`=?,`product_quantily`=?,`product_main_image`=IF(?='', product_main_image,?),`product_description`=? WHERE id = ?;");
        $sql->bind_param('sddisssi', $product['product_name'],  $product['product_price'],  $product['product_promotional_price'],  $product['product_quantily'], $product['product_main_image'],$product['product_main_image'], $product['product_description'],$product['id']);
        if (!$sql->execute()) {
            return -1;
        }
        $idProduct = $product['id'];
        if (isset($product['category_id']))
        foreach ($product['category_id'] as $category_id) {
            $sqlPC = parent::$connection->prepare("INSERT INTO `category_product`(`category_id`, `product_id`) VALUES (?,?)");
            $sqlPC->bind_param('dd', $category_id, $idProduct);
            if (!$sqlPC->execute()) {
                return -1;
            }
        }
        return $idProduct;
    }
    public function getProducts($numberPage, $perPage)
    {
        $numberPage = ($numberPage - 1) * $perPage;
        $sql = parent::$connection->prepare("SELECT `id`, `product_name`, `product_price`, `product_quantily`, `product_main_image`,  `product_create_at` FROM `products`LIMIT ? , ?;");
        $sql->bind_param("ii", $numberPage, $perPage);
        return parent::select($sql);
    }
    public function getProductsByKey($numberPage, $perPage,$key)
    {
        $numberPage = ($numberPage - 1) * $perPage;
        $key  = "%".str_replace(" ", "%",$key)."%";
        $sql = parent::$connection->prepare("SELECT * FROM `products` WHERE product_name LIKE ?  LIMIT ? , ?;");
        $sql->bind_param("sii",$key, $numberPage, $perPage);
        return parent::select($sql);
    }
    public function getProductsCountByKey($numberPage, $perPage,$key)
    {
        $numberPage = ($numberPage - 1) * $perPage;
        $key  = "%".str_replace(" ", "%",$key)."%";
        $sql = parent::$connection->prepare("SELECT Count(id) FROM `products` WHERE product_name LIKE ?  LIMIT ? , ?;");
        $sql->bind_param("sii",$key, $numberPage, $perPage);
        return parent::select_one($sql)['Count(id)'];
    }
    public function getCategoriesProduct($idProduct)
    {
        $sql = parent::$connection->prepare("SELECT `category_id` FROM `category_product` WHERE product_id = ?;");
        $sql->bind_param("i", $idProduct);
        return array_column(parent::select($sql), 'category_id');
    }
    public function getProduct($id)
    {
        $sql = parent::$connection->prepare("SELECT * FROM `products` WHERE id = ?;");
        $sql->bind_param("i", $id);
        return parent::select_one($sql);
    }
    public function getProductCount()
    {
        $sql = parent::$connection->prepare("SELECT Count(id) FROM `products` Where 1");
        return parent::select_one($sql)['Count(id)'];
    }
    public function deleteCategoryProduct($idProduct)
    {
        $sql = parent::$connection->prepare("DELETE FROM `category_product` WHERE product_id = ?;");
        $sql->bind_param('i', $idProduct);
        return $sql->execute();
    }
    public function deleteProduct($idProduct)
    {
        $sql = parent::$connection->prepare("DELETE FROM `products` WHERE id =? LIMIT 1;");
        $sql->bind_param('i', $idProduct);
        return $sql->execute();
    }
}

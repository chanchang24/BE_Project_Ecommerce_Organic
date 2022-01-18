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
        $sql->bind_param('sddisssi', $product['product_name'],  $product['product_price'],  $product['product_promotional_price'],  $product['product_quantily'], $product['product_main_image'], $product['product_main_image'], $product['product_description'], $product['id']);
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
        $sql = parent::$connection->prepare("SELECT `id`, `product_name`, `product_price`, `product_promotional_price`, `product_quantily`, `product_main_image`, `product_create_at` FROM `products`LIMIT ? , ?;");
        $sql->bind_param("ii", $numberPage, $perPage);
        return parent::select($sql);
    }
    public function getNewProducts($numberPage, $perPage)
    {
        $numberPage = ($numberPage - 1) * $perPage;
        $sql = parent::$connection->prepare("SELECT `id`, `product_name`, `product_price`, `product_quantily`,product_promotional_price, `product_main_image`,  `product_create_at`  FROM `products` ORDER BY product_create_at DESC  LIMIT ? , ?;");
        $sql->bind_param("ii", $numberPage, $perPage);
        return parent::select($sql);
    }
    public function getProductsByKey($numberPage, $perPage, $key)
    {
        $numberPage = ($numberPage - 1) * $perPage;
        $key  = "%" . str_replace(" ", "%", $key) . "%";
        $sql = parent::$connection->prepare("SELECT * FROM `products` WHERE product_name LIKE ?  LIMIT ? , ?;");
        $sql->bind_param("sii", $key, $numberPage, $perPage);
        return parent::select($sql);
    }
    public function getProductsCountByKey($key)
    {
        $key  = "%" . str_replace(" ", "%", $key) . "%";
        $sql = parent::$connection->prepare("SELECT COUNT(id) FROM `products` WHERE product_name LIKE ?  ;");
        $sql->bind_param("s", $key);
        return parent::select_one($sql)['COUNT(id)'];
    }
    public function getProductsByIDCategory($numberPage, $perPage, $id)
    {
        $numberPage = ($numberPage - 1) * $perPage;
        $sql = parent::$connection->prepare("SELECT * FROM `products` INNER JOIN category_product ON id = category_product.product_id WHERE category_product.category_id = ? LIMIT ? , ?;");
        $sql->bind_param("iii", $id, $numberPage, $perPage);
        return parent::select($sql);
    }
    public function getProductsCountByIDCategory($id)
    {
        $sql = parent::$connection->prepare("SELECT COUNT(id) FROM `products` INNER JOIN category_product ON id = category_product.product_id WHERE category_product.category_id = ?  ;");
        $sql->bind_param("s", $id);
        return parent::select_one($sql)['COUNT(id)'];
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
    public function getProductByID($id)
    {
        $sql = parent::$connection->prepare("SELECT  `id`, `product_name`, `product_price`, `product_promotional_price`, `product_quantily`, `product_main_image`, `product_create_at` FROM `products` WHERE id = ?;");
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
    public function insertReview($username, $content, $ratingStar, $idProduct)
    {
        $sql = parent::$connection->prepare("INSERT INTO `product_review`(`product_id`, `product_review_content`, `product_review_rating`, `product_review_username`) VALUES (?,?,?,?);");
        $sql->bind_param('isis', $idProduct, $content, $ratingStar, $username);
        return $sql->execute();
    }
    public function updateQuantity($id, $qty)
    {
        $sql = parent::$connection->prepare("UPDATE `products` SET `product_quantily`= product_quantily - ?  WHERE id = ?;");
        $sql->bind_param('ii', $$qty, $id);
        return $sql->execute();
    }
    public function getFeaturedProducts()
    {
        $sql = parent::$connection->prepare('SELECT'
            . '       products.product_name as product_name,'
            . '       product_review.product_id as product_id,'
            . '       products.product_price as product_price,'
            . '       products.product_promotional_price as product_promotional_price ,'
            . '       products.product_main_image as product_main_image,'
            . '       products.product_quantily as product_quantily,'
            . '       products.product_create_at,'
            . '       COUNT(product_review.product_id) AS review_count,'
            . '       AVG(product_review.product_review_rating) AS rating_average,'
            . '       COUNT(product_review.id) * AVG(product_review.product_review_rating) AS total_score'
            . '   FROM'
            . '       product_review'
            . '   INNER JOIN products ON products.id = product_review.product_id'
            . '   GROUP BY'
            . '       product_review.product_id'
            . '   ORDER BY'
            . '       total_score'
            . '   DESC'
            . '   LIMIT 8');
        return parent::select($sql);
    }
    public function getReViews($id)
    {
        $sql = parent::$connection->prepare("SELECT `id`, `product_id`, `product_review_content`, `product_review_rating`, `product_review_create_at`, `product_review_username` FROM `product_review` WHERE product_id =?");
        $sql->bind_param("i", $id);
        return  parent::select($sql);
    }
    public function getRelatedProducts($id)
    {
        $sql = parent::$connection->prepare("SELECT `id`, `product_name`, `product_price`, `product_promotional_price`, `product_quantily`, `product_main_image`, `product_create_at` FROM `products` INNER JOIN category_product ON product_id = id WHERE id != ? AND category_id IN (SELECT category_id FROM category_product WHERE category_product.product_id = ?   ) limit 4;");
        $sql->bind_param("ii", $id, $id);
        return  parent::select($sql);
    }
    public function getSaleProduct()
    {
        $sql = parent::$connection->prepare("SELECT `id`, `product_name`, `product_price`, `product_promotional_price`, `product_quantily`, `product_main_image`, ROUND(100 - product_promotional_price/product_price*100)  AS sale FROM `products` WHERE 100 - product_promotional_price/product_price*100 > 0 ORDER by (sale) DESC LIMIT 8;");
        return  parent::select($sql);
    }
}

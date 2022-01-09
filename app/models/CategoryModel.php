<?php
class CategoryModel extends DB
{
    //lấy tất cả sản phẩm
    public function getCategories()
    {
        //2.Viết câu SQL
        $sql = parent::$connection->prepare("SELECT * FROM `categories` WHERE 1 ORDER BY category_name ");
        return parent::select($sql);
    }
    public function getCategoryByProduct($idProduct)
    {
        $sql = parent::$connection->prepare("SELECT `category_name` FROM `categories` INNER JOIN category_product ON categories.id = category_product.category_id WHERE category_product.product_id = ?;");
        $sql->bind_param("i", $idProduct);
        return array_column(parent::select($sql), 'category_name');
    }
    public function getCategory($id)
    {
        $sql = parent::$connection->prepare("SELECT * FROM `categories` WHERE id = ? LIMIT 1;");
        $sql->bind_param("i", $id);
        return parent::select_one($sql);
    }
    public function insert($category)
    {
        $sql = parent::$connection->prepare("INSERT INTO `categories`(`category_name`, `category_image`, `category_title`) VALUES (?,?,?);");
        $sql->bind_param("sss", $category['category_name'], $category['category_image'], $category['category_title']);
        return $sql->execute();
    }
    public function deleteRelationshipProduct($idCategory)
    {
        $sql = parent::$connection->prepare("DELETE FROM `category_product` WHERE category_id = ?;");
        $sql->bind_param('i', $idCategory);
        return $sql->execute();
    }
    public function deleteCategory($id)
    {
        $sql = parent::$connection->prepare("DELETE FROM `categories` WHERE id = ? LIMIT 1;");
        $sql->bind_param('i', $id);
        return $sql->execute();
    }
    public function updateCategory($category)
    {
        $sql = parent::$connection->prepare("UPDATE `categories` SET `category_name`=?,`category_image`=IF(?='', category_image,?),`category_title`= ? WHERE id =? LIMIT 1");
        $sql->bind_param('sssi', $category['category_name'], $category['category_image'],$category['category_title'],$category['id']);
        return $sql->execute();
    }
}

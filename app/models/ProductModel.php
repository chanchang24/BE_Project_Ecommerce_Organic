<?php
class ProductModel extends Db
{
    //lấy tất cả sản phẩm
    public function getProducts()
    {
        $sql = parent::$connection->prepare("SELECT * FROM products");
        return parent::select($sql);
    }
    public function getProductsById($id)
    {
        
        $sql = parent::$connection->prepare("SELECT * FROM products WHERE id=?");
        $sql->bind_param('i', $id); 
        return parent::select($sql);
    }
    public function getProductsByCategory($category_id)
    {      
        $sql = parent::$connection->prepare("SELECT * FROM products INNER JOIN category_product ON products.id=category_product.product_id WHERE category_id=?");
        $sql->bind_param('i', $category_id); 
        return parent::select($sql);
    }
    public function addProduct($productName, $productDescription, $productPrice, $productImage,$productDiscount,$productDate)
    {
        $sql = parent::$connection->prepare("INSERT INTO products( product_name,product_price,product_discount ,product_description, product_main_image, product_create_at) VALUES (?,?,?,?,?,?)");
        $sql->bind_param('sddsss', $productName,  $productPrice, $productDiscount,$productDescription,$productImage,$productDate);
        return $sql->execute();
    }
    public function removeProduct($id){
        $sql = parent::$connection->prepare("DELETE FROM `products` WHERE products.id = ?");
        $sql->bind_param('i', $id); 
        return $sql->execute();
    }
    public function updateProduct($id,$productName, $productDescription, $productPrice, $productImage){
        $sql = parent::$connection->prepare("UPDATE products SET product_name=?,product_price=?,product_description=?,product_image=? WHERE id=?");
        $sql->bind_param('sdssi', $productName,$productPrice, $productDescription,  $productImage,$id);
        return $sql->execute();
    }
    public function searchProduct($name)
    {     
        $sql = parent::$connection->prepare("SELECT * FROM `products` WHERE product_name LIKE ? ");
        $name =str_replace(' ','%',$name);
        $searchName = "%".$name."%";
        $sql->bind_param('s', $searchName); 
        return parent::select($sql);
    }

    //pagination
    public function getCount(){
        $sql = parent::$connection->prepare("SELECT COUNT(*) FROM `products` ");
        return parent::select($sql);
    }
    public static function createPageLinks($totalRow, $perPage, $currentPage) {
        $numberPage= ceil($totalRow/$perPage);
        
    }

    public function getPagination($offset,$limit){
        $sql = parent::$connection->prepare("SELECT * FROM `products` LIMIT ?,? ");
        $sql->bind_param('ss', $offset,$limit); 
        return parent::select($sql);
    }
    public function getPaginationBySearch($offset,$limit,$key){
        $sql = parent::$connection->prepare("SELECT * FROM `products`WHERE product_name LIKE ? LIMIT ?,?  ");
        $searchName = "%".$key."%";
        $sql->bind_param('sss',$searchName, $offset,$limit); 
        return parent::select($sql);
    }
    public function getCountBySearch($name){
        $sql = parent::$connection->prepare("SELECT COUNT(*) FROM `products` WHERE product_name LIKE ? ");
        $searchName = "%".$name."%";
        $sql->bind_param('s', $searchName);
        return parent::select($sql);
    }

}

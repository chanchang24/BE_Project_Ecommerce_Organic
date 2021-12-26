<?php
    class CategoryModel extends Db{
        //lấy tất cả sản phẩm
        public function getCategories(){
            //2.Viết câu SQL
            $sql= parent::$connection->prepare("SELECT * FROM categories");
            return parent::select($sql);
        }

    }

?>
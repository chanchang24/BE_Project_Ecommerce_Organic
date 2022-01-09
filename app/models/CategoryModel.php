<?php
    class CategoryModel extends DB{
        public function getCategories(){
            $sql= parent::$connection->prepare("SELECT * FROM categories");
            return parent::select($sql);
        }
    }
?>
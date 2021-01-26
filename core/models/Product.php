<?php
namespace Core\Models;

class Product extends Model{
    protected static function getTableName(){
        return 'products';
    }

    public static function getCategory(string $nameCateg)
    {
        return Category::getCategId($nameCateg);
    }
}
<?php

class DiscountCodesGroups extends DbObject
{
    protected static $dbTable = "discountCodesGroups";
    protected static $dbTableFields = ["name"];
    public $id;
    public $name;

//    public static function findByPricesId($id)
//    {
//        $params[':prices_id'] = $id;
//        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where prices_id = :prices_id", $params);
//        return $resultArray;
//    }
//    public static function findVolumeIdByPriceAndPriceId($prices_id, $price)
//    {
//        $params[':prices_id'] = $prices_id;
//        $params[':price'] = $price;
//        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where prices_id = :prices_id and price = :price", $params);
//        return array_shift($resultArray);
//    }
//    public static function findByVolumeAndPrices($volume_id, $prices_id)
//    {
//        $params[':prices_id'] = $prices_id;
//        $params[':volume_id'] = $volume_id;
//        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where prices_id = :prices_id and volume_id = :volume_id", $params);
//        return !empty($resultArray) ? array_shift($resultArray) : false;
//    }


}
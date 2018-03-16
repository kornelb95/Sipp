<?php

class DiscountCodes extends DbObject
{
    protected static $dbTable = "discountCodes";
    protected static $dbTableFields = ["code", "group_id", "discount","freedelivery","prices_id", "type","date","active"];
    public $id;
    public $code;
    public $group_id;
    public $discount = null;
    public $freedelivery = null;
    public $prices_id = null;
    public $type;
    public $date;
    public $active;

    public static function findByGroupId($id)
    {
        $params[':group_id'] = $id;
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where group_id = :group_id", $params);
        return $resultArray;
    }
    public static function findByPricesId($id)
    {
        $params[':prices_id'] = $id;
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where prices_id = :prices_id", $params);
        return $resultArray;
    }
    public static function findByCode($code)
    {
        $params[':code'] = $code;
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where code = :code", $params);
        return !empty($resultArray) ? $resultArray : null;
    }
    public static function findDiscounts()
    {
        $resultArray = static::findByQuery("select * from ". static::$dbTable . " WHERE NOT (discount <=> NULL)");

        return !empty($resultArray) ? $resultArray : null;
    }
    public static function findPrices()
    {
        $resultArray = static::findByQuery("select * from ". static::$dbTable . " WHERE NOT (prices_id <=> NULL)");

        return !empty($resultArray) ? $resultArray : null;
    }
    public static function findFreeDelivery()
    {
        $resultArray = static::findByQuery("select * from ". static::$dbTable . " WHERE NOT (freedelivery <=> NULL)");

        return !empty($resultArray) ? $resultArray : null;
    }
    public static function findActives()
    {
        $params[':active'] = 'TAK';
        $resultArray = static::findByQuery("select * from ". static::$dbTable . " WHERE active = :active", $params);

        return !empty($resultArray) ? $resultArray : null;
    }


}
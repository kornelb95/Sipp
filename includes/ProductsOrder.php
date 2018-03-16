<?php


class ProductsOrder extends DbObject
{
    protected static $dbTable = "ProductsOrder";
    protected static $dbTableFields = ["order_id", "product_id", "volume_id", "amount"];
    public $id;
    public $order_id;
    public $product_id;
    public $volume_id;
    public $amount;

    public static function findByOrderID($order_id)
    {
        $params[':order_id'] = $order_id;
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where order_id = :order_id", $params);
        return $resultArray;
    }
    public static function findByProductId($product_id)
    {
        $params[':product_id'] = $product_id;
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where product_id = :product_id", $params);
        return $resultArray;
    }
    public static function findOrderIdByProductAndVolume($product_id, $volume_id)
    {

//            print_r($volume_id);
//    print_r($product_id);
//    die;
        if($product_id != 'nooption' && $volume_id != 'nooption') {
            $params[':product_id'] = $product_id;
            $params[':volume_id'] = $volume_id;
            $resultArray = static::findByQuery("select * from ". static::$dbTable ." where product_id = :product_id and volume_id = :volume_id", $params);
            return $resultArray;
        } elseif ($volume_id == 'nooption') {
            $params[':product_id'] = $product_id;
            $resultArray = static::findByQuery("select * from ". static::$dbTable ." where product_id = :product_id", $params);
            return $resultArray;
        } elseif($product_id == 'nooption') {
            $params[':volume_id'] = $volume_id;
            $resultArray = static::findByQuery("select * from ". static::$dbTable ." where volume_id = :volume_id", $params);
            return $resultArray;
        }

    }

}
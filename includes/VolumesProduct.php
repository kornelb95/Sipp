<?php

class VolumesProduct extends DbObject
{
    protected static $dbTable = "productsVolumes";
    protected static $dbTableFields = ["product_id", "volume_id"];
    public $id;
    public $product_id;
    public $volume_id;

    public static function findByProductId($id)
    {
        $params[':product_id'] = $id;
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where product_id = :product_id", $params);
        return $resultArray;
    }


}
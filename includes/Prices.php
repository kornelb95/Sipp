<?php

class Prices extends DbObject
{
    protected static $dbTable = "prices";
    protected static $dbTableFields = ["name"];
    public $id;
    public $name;

    public static function pricesExists($name)
    {
        global $database;
        $sql = "select * from " . self::$dbTable . " where name = :name";
        $params[':name'] = $name;
        $result = self::findByQuery($sql, $params);
        return (!empty($result) ? true : false);
    }


}
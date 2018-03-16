<?php

class Category extends DbObject
{
    protected static $dbTable = "productsCategory";
    protected static $dbTableFields = ["category"];
    public $id;
    public $category;

    public static function categoryExists($category)
    {
        global $database;
        $sql = "select * from " . self::$dbTable . " where category = :category";
        $params[':category'] = $category;
        $result = self::findByQuery($sql, $params);
        return (!empty($result) ? true : false);
    }


}
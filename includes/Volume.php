<?php

class Volume extends DbObject
{
    protected static $dbTable = "volume";
    protected static $dbTableFields = ["volume"];
    public $id;
    public $volume;

    public static function volumeExists($volume)
    {
        global $database;
        $sql = "select * from " . self::$dbTable . " where volume = :volume";
        $params[':volume'] = $volume;
        $result = self::findByQuery($sql, $params);
        return (!empty($result) ? true : false);
    }
    public static function findIdByVolume($volume)
    {
        $params[':volume'] = $volume;
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where volume = :volume", $params);
        return array_shift($resultArray);
    }

}
<?php

class Orders extends DbObject
{
    protected static $dbTable = "orders";
    protected static $dbTableFields = ["user_id", "email", "status", "totalcost", "date", "first_name", "last_name", "street", "house_number", "post_code","town", "province", "send_method", "pay_method"];
    public $id;
    public $user_id;
    public $email;
    public $status;
    public $totalcost;
    public $date;
    public $first_name;
    public $last_name;
    public $street;
    public $house_number;
    public $post_code;
    public $town;
    public $province;
    public $send_method;
    public $pay_method;

    public static function lastOrder($user_id)
    {
        global $database;
        $sql = "select * from " . self::$dbTable . " where user_id = :user_id order by 'date' desc limit 1";
        $params[':user_id'] = $user_id;
        $result = self::findByQuery($sql, $params);
        return (!empty($result) ?  array_shift($result) : null);
    }

    public static function findBetweenDate($from, $to)
    {
        global $database;
        $sql = "select * from " . self::$dbTable . " where date >= :from AND date < :to";
        $params[':from'] = $from;
        $params[':to'] = $to;
        $result = self::findByQuery($sql, $params);
        return (!empty($result) ? $result : null);
    }

}
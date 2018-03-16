<?php

class Admin extends DbObject
{
    protected static $dbTable = "admins";
    protected static $dbTableFields = ["login", "password"];
    public $id;
    public $login;
    public $password;

    public static function verifyAdmin($login, $password)
    {
        global $database;
        $sql = "select * from " . self::$dbTable . " where login = :login and password = :password limit 1";

        $params = [
            ':login' => $login,
            ':password' => $password
        ];

        $resultArray = self::findByQuery($sql, $params);

        return !empty($resultArray) ? array_shift($resultArray) : false;
    }

    public static function adminExists($username)
    {
        global $database;
        $sql = "select * from " . self::$dbTable . " where username = :username";
        $params[':username'] = $database->escapeString($username);
        $result = self::findByQuery($sql, $params);
        return (!empty($result) ? true : false);
    }

}
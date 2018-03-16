<?php


class Database {
    public $pdo;
    public $db;
    public $stmt;
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
        $this->db = $this->openConnection();
    }

    private function loadConfig()
    {
        $this->config = require_once 'config.php';
    }

    private function openConnection()
    {
        try {
            $this->pdo = new PDO("mysql:host={$this->config['db']['host']};dbname={$this->config['db']['dbname']};charset=utf8", $this->config['db']['user'], $this->config['db']['pass'], [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            return $this->pdo;

        } catch (PDOException $e) {

            echo $e->getMessage();
            exit('Query error');
        }
    }

    public function query(string $sql, array $params = null)
    {
        try {
            $this->stmt = $this->db->prepare($sql);
            ($params == null ? null:$this->bind($params));
            $this->stmt->execute();
            return $this->stmt;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit('Database error');
        }

    }
    public function bind($params)
    {

        foreach ($params as $key => $val) {
//            if (is_null($type)) {
//                switch (true) {
//                    case is_int($val):
//                        $type = PDO::PARAM_INT;
//                        break;
//                    case is_bool($val):
//                        $type = PDO::PARAM_BOOL;
//                        break;
//                    case is_null($val):
//                        $type = PDO::PARAM_NULL;
//                        break;
//                    default:
//                        $type = PDO::PARAM_STR;
//                }
//            }
            $this->stmt->bindValue($key, $val);
        }
    }
    public function escapeString($str)
    {
        $str = preg_replace('/\s+/', '', $str);
        $str = trim($str);
        return $str;
    }
    public function insertId()
    {
        return $this->db->lastInsertId();
    }
}

$database = new Database();


<?php

class Product extends DbObject
{
    protected static $dbTable = "products";
    protected static $dbTableFields = ["name", "category_id", "price_id", "filename", "type", "description", "status", "end_date"];
    public $id;
    public $name;
    public $category_id;
    public $price_id;
    public $filename;
    public $type;
    public $description;
    public $status;
    public $end_date;
    public $tmp_path;
    public $upload_directory = "images";


    public static function HowManyLimitted()
    {
        global $database;
        $params[':type'] = 'limitted';
        $params[':status'] = 'widoczny';
        $stmt = $database->query("select * from ". static::$dbTable ." where type = :type and status = :status", $params);
        return $stmt->rowCount();
    }
    public static function findLimitted()
    {
        $params[':type'] = 'limitted';
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where type = :type", $params);
        return $resultArray;
    }
    public static function findShop()
    {
        $params[':type'] = 'shop';
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where type = :type", $params);
        return $resultArray;
    }

    public function picture_path(){
        return $this->upload_directory . DS . $this->filename;
    }

    public function upload_photo(){

        if(!empty($this->errors)){
            return false;
        }
        if(empty($this->filename) || empty($this->tmp_path)){
            $this->errors[] = "the file was not available";
            return false;
        }
        $target_path = __DIR__ . DS . '..' . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

        if(file_exists($target_path)) {
            $this->errors[] = "The file {$this->filename} already exists";
            return false;
        }
        if(move_uploaded_file($this->tmp_path, $target_path)){

            unset($this->tmp_path);
            return true;

        } else{
            $this->errors[] = "the folder probably doesnt have permission";
            return false;
        }
    }

    public function delete_photo(){
        if($this->delete()){
            $target_path = SITE_ROOT.DS.'admin'.DS.$this->picture_path();

            return unlink($target_path) ? true : false;
        } else{
            return false;
        }
    }

//    public static function verifyProduct($username, $password)
//    {
//        global $database;
//        $sql = "select * from " . self::$dbTable . " where username = :username and password = :password and activation = :activation limit 1";
//
//        $params = [
//            ':username' => $username,
//            ':password' => $password,
//            ':activation' => 'activated'
//        ];
//
//        $resultArray = self::findByQuery($sql, $params);
//
//        return !empty($resultArray) ? array_shift($resultArray) : false;
//    }

}
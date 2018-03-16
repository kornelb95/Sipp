<?php
/**
 * Created by PhpStorm.
 * User: Kornel Błażek
 * Date: 12.02.2018
 * Time: 15:21
 */

class DbObject
{
    protected static $dbTable = "users";
    public $errors = [];
    public $upload_errors_array = [
        UPLOAD_ERR_OK => "There is no error",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the max_file_size",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
        UPLOAD_ERR_NO_FILE => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload"
    ];

    public function setFile($file){
        if(empty($file) || !$file || !is_array($file)){
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif($file['error'] != 0){
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else{
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
        }
    }
    public static function findAll()
    {
        $sql = 'SELECT * FROM ' . static::$dbTable;
        return static::findByQuery($sql);
    }

    public static function findById($id)
    {
        $params[':id'] = $id;
        $resultArray = static::findByQuery("select * from ". static::$dbTable ." where id = :id", $params);
        return !empty($resultArray) ? array_shift($resultArray) : false;
    }

    public static function findByQuery(string $sql, array $params = null)
    {
        global $database;
        $result = $database->query($sql, $params);
        $objectArray = [];
        while ($row = $result->fetch()) {
            $objectArray[] = static::instantation($row);
        }
        return $objectArray;
    }

    public static function instantation($record)
    {
        //zwraca nazwę klasy an rzecz ktorej wywolano metodę
        $callingClass = get_called_class();

        //tworzymy obiekt danej klasy
        $theObject = new $callingClass;

        //pobrany wiersz z tabeli jako tablica - indeksy to nazwy kolumn
        foreach ($record as $attribute => $value) {
            //sprawdza czy w klasie istnieje dany atrybut, jezeli tak to ustawia wartosc dla atrybutu

            if ($theObject->hasAttribute($attribute)) {
                $theObject->$attribute = $value;
            }
        }
        //zwraca obiekt
        return $theObject;
    }

    protected function hasAttribute($attr)
    {
        $object_properties = get_object_vars($this);
        return array_key_exists($attr,$object_properties);
    }

    protected function properties()
    {
        global $database;
        $properties = [];
        foreach (static::$dbTableFields as $dbField) {
            if (property_exists($this, $dbField)) {
               $properties[$dbField] = $this->$dbField;
            }
        }
        return $properties;
    }
    protected function cleanProperties()
    {
        global $database;

        $cleanProperties = [];

        foreach ($this->properties() as $key => $value){
            $cleanProperties[$key] = $database->escapeString($value);
        }
        return $cleanProperties;
    }

    public function save()
    {
        return (isset($this->id) ? $this->update() : $this->create());
    }

    public function create()
    {
        global $database;

        $properties = $this->properties();
        $sql = "insert into ". static::$dbTable . "(" . implode(",", array_keys($properties)) . ")";
        $sql .= " values(:". implode(", :", array_keys($properties)) . ")";
        $params = [];
        foreach ($properties as $key => $val)
        {
            $params[':'.$key] = $val;
        }

        if ($database->query($sql, $params)) {
            $this->id = $database->insertId();
            return true;
        } else {
            return false;
        }
    }


    public function update()
    {
        global $database;

        $properties = $this->properties();

        $propertiesPairs = [];

        foreach ($properties as $key => $val) {
            $propertiesPairs[] = "{$key} = :{$key}";
        }

        $sql = "update " .static::$dbTable ." set ";
        $sql .= implode(", ", $propertiesPairs);
        $sql .= " where id = :idd";

        $params[':idd'] = $this->id;

        foreach ($properties as $key => $val)
        {
            $params[':'.$key] = $val;
        }

        $result = $database->query($sql, $params);

        return ($result->rowCount() == 1 ? true : false);
    }

    public function delete()
    {
        global $database;

        $sql = "delete from " . static::$dbTable . " where id = :id limit 1";
        $params = [];
        $params[':id'] = $this->id;
        $result = $database->query($sql, $params);
        return ($result->affected_rows == 1 ? true : false);
    }
}
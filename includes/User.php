<?php

class User extends DbObject
{
    protected static $dbTable = "users";
    protected static $dbTableFields = ["username", "password", "email", "activation", "first_name"];
    public $id;
    public $username;
    public $password;
    public $email;
    public $activation;
    public $first_name;
    public $password2;



    public static function verifyUser($username, $password)
    {
        global $database;
        $sql = "select * from " . self::$dbTable . " where username = :username and password = :password and activation = :activation limit 1";

        $params = [
            ':username' => $username,
            ':password' => $password,
            ':activation' => 'activated'
        ];

        $resultArray = self::findByQuery($sql, $params);

        return !empty($resultArray) ? array_shift($resultArray) : false;
    }

    public static function countOrders($user_id)
    {
        global $database;
        $sql = "select * from orders where user_id = :user_id";

        $params = [
            ':user_id' => $user_id,
        ];

        $resultArray = self::findByQuery($sql, $params);

        return count($resultArray);
    }

    public function register()
    {
        global $database;

        if(empty($this->username)) {
            $errors = "Proszę wprowadzić nazwę użytkownika<br>";
        } elseif (!ctype_alnum($this->username)) {
            $errors .= "Nazwa użytkownika składać może się tylko z liter oraz cyfr<br>";
        }

        if (empty($this->email)) {
            $errors .= "Proszę wprowadzić adres email<br>";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors .= "Adres Email ma zły format<br>";
        }

        if(empty($this->password)) {
            $errors .= "Proszę wprowadzić hasło<br>";
        } elseif (!(strlen($this->password) > 6 && preg_match('/[A-Z]/',$this->password) && preg_match('/[0-9]/',$this->password))) {
            $errors .= "Hasło powinno mieć conajmniej 6 liter, jedną duża literę oraz przynajmniej jedną cyfrę<br>";
        }

        if($this->diffrentPasswords()) {
            $errors .= "Różne hasła<br>";
        }
        if (self::userExists($this->username)) {
            $errors .= "Taki użytkownik już istnieje<br>";
        }
        if (self::emailExists($this->email)) {
            $errors .= "Taki email już istnieje<br>";
        }

        if ($errors) {
            global $session;
            $session->message($errors);
            return false;
        }

        //tutaj koneic debugowania
        $properties = $this->properties();


        $sql = "insert into ". static::$dbTable . "(" . implode(",", array_keys($properties)) . ")";
        $sql .= " values(:". implode(", :", array_keys($properties)) . ")";
        $params = [];
        $this->activation = bin2hex(openssl_random_pseudo_bytes(16));


        foreach ($properties as $key => $val)
        {
            $params[':'.$key] = $val;
        }
        $params[':password'] = $this->hash($this->password);
        $params[':activation'] = $this->activation;

        if ($database->query($sql, $params)) {
            $this->id = $database->insertId();
            $this->mail();
            return true;
        } else {
            return false;
        }


    }

    public function hash($password)
    {
        $password = hash('sha256', $password);
        return $password;
    }

    public static function userExists($username)
    {
        global $database;
        $sql = "select * from " . self::$dbTable . " where username = :username";
        $params[':username'] = $database->escapeString($username);
        $result = self::findByQuery($sql, $params);
        return (!empty($result) ? true : false);
    }

    public static function emailExists($email)
    {
        $sql = "select * from " . self::$dbTable . " where email = :email";
        $params[':email'] = $email;
        $result = self::findByQuery($sql, $params);
        return (!empty($result) ? true : false);
    }

    private function mail()
    {
        $message = "Proszę wejść w link, aby aktywować konto:\n\n";
        $message .="http://kornelb.com.pl/SIPP/activate.php?email=" . urlencode($this->email) . "&key=$this->activation";
        if(mail($this->email, 'Potwierdzenie rejestracji', $message, 'From:'.'kornelb@korni007.webd.pl')){
            echo "<div class='alert alert-success'>Rejestracja pomyślna! Wiadomość z linkiem aktywacyjnym została wysłana na {$this->email}. </div>";
        }
    }

    public function activate($email, $key)
    {
        global $database;
        //zapytanie ustawia flagę aktywacji dla danego maila i klucza aktywacyjnego
        $sql = "UPDATE users SET activation = :activated WHERE (email = :email AND activation = :activation) LIMIT 1";
        $params = [
            ':email' => $database->escapeString($email),
            ':activated' => 'activated',
            ':activation' => $database->escapeString($key)
        ];
        $result = $database->query($sql, $params);
        //zwraca ilość poprawnie wyszukanych wierszy w ostatnim zapytaniu
        //zapytanie wykonane poprawnie - wyśiwetlenie info oraz button Zaloguj
        if($result->rowCount() == 1){
            echo '<div class="alert alert-success">Konto zostało pomyślnie utworzone.</div>';
            echo '<a href="logowanie.php" type="button" class="btn-lg btn-success">Zaloguj się<a/>';

        }else{ //niepowodzenie zapytania
            //info o niepowodzeniu aktywacji konta
            echo '<div class="alert alert-danger">Konto nie zostało aktywowane...</div>';
            echo '<div class="alert alert-danger">' . $result->errorInfo() . '</div>';

        }
    }

    public function diffrentPasswords()
    {
        return ($this->hash($this->password) != $this->hash($this->password2)) ? true : false;
    }

}
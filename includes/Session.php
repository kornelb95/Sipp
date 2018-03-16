<?php
class Session{

    private $signed_in = false;
    private $signed_in_admin = false;
    public $user_id;
    public $admin_id;
    public $message;
    public $errorMessage;

    function __construct()
    {
        session_start();
        $this->checkAdmin();
        $this->check_the_login();
        $this->check_message();
        $this->check_errorMessage();
    }


    public function message($msg = ""){
        if(!empty($msg)){
            $_SESSION['message'] = $msg;
        } else{
            return $this->message;
        }
    }

    private function check_message(){
        if(isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else{
            $this->message = "";
        }
    }
    public function errorMessage($msg = ""){
        if(!empty($msg)){
            $_SESSION['errorMessage'] = $msg;
        } else{
            return $this->errorMessage;
        }
    }

    private function check_errorMessage(){
        if(isset($_SESSION['errorMessage'])){
            $this->errorMessage = $_SESSION['errorMessage'];
            unset($_SESSION['errorMessage']);
        } else{
            $this->errorMessage = "";
        }
    }

    private function check_the_login(){
        if(isset($_SESSION['user_id'])){
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;
        } else{
            unset($this->user_id);
            $this->signed_in = false;
        }
    }

    private function checkAdmin(){
        if(isset($_SESSION['admin_id'])){
            $this->admin_id = $_SESSION['admin_id'];
            $this->signed_in_admin = true;
        } else{
            unset($this->admin_id);
            $this->signed_in_admin = false;
        }
    }

    public function isSignedIn(){
        return $this->signed_in;
    }

    public function isSignedInAdmin(){
        return $this->signed_in_admin;
    }

    public function login($user){
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }

    public function loginAdmin($admin){
        if($admin){
            $this->admin_id = $_SESSION['admin_id'] = $admin->id;
            $this->signed_in_admin = true;
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    public function logoutAdmin(){
        unset($_SESSION['admin_id']);
        unset($this->admin_id);
        $this->signed_in_admin = false;
    }
}

$session = new Session();
$message = $session->message;
$errorMessage = $session->errorMessage;
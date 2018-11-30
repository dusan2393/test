<?php

class Session {
    
    private $logged_in;
    private $user_id;
    public $message;

    function __construct(){
        session_start();
        $this->check_login();
        $this->check_message();
    }
    
    public function login($found_user){
        if ($found_user){
            $this->logged_in = true;
            $this->user_id = $_SESSION['user_id'] = $found_user->id;
        }
    }

    public function user_id(){
        return $this->user_id;
    }
    
    public function is_logged_in(){
        return $this->logged_in;
    }
    
    private function check_login(){
        if (isset($_SESSION['user_id'])){
            $this->logged_in = true;
            $this->user_id = $_SESSION['user_id'];
        } else {
            unset($_SESSION['user_id']);
            $this->logged_in = false;
        }
    }
    

    
    
    // -------------- messages ------------------- \\
    public function message($msg=""){
        $_SESSION['message'] = $msg;
        $this->message = $_SESSION['message'];
        return $this->message;
        
    }

    private function check_message(){
        if (isset($_SESSION['message'])){
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }
    
    
}


$session = new Session;





?>
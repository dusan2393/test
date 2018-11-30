<?php 
require_once('config.php');	


class MysqliConnect {
    
    private $connect;
    private $last_query;
    
    function __construct(){
        $this->open_connection();
    }
    
    private function open_connection(){
        $this->connect = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if(!$this->connect){
            die("Database connection failed: " . mysqli_error());
        }
    }
    
    public function close_connection(){
        if($this->connect){
            mysqli_close($this->connect);
            unset($this->connect);
        }
    }
    
    public function query($q){
        $this->last_query = $q;
        $result = mysqli_query($this->connect, $q);
        $this->confirm_query($result);
        return $result;
    }
    
    private function confirm_query($result){
        if(!$result){
            die("Query failed, last query: <br>" . $this->last_query);
        }
    }
    
    public function safe_string($string){
        $string = stripslashes($string);
        return mysqli_real_escape_string($this->connect, trim($string));
    }
    
    public function fetch_array($result_set){
        return mysqli_fetch_array($result_set);
    }
    
    public function fetch_assoc($result_set){
        return mysqli_fetch_assoc($result_set);
    }
    
    public function num_rows($result_set){
        return mysqli_num_rows($result_set);
    }
    
    public function affected_rows(){
        return mysqli_affected_rows($this->connect);
    }
    
    public function insert_id(){
        return mysqli_insert_id($this->connect);
    }
    
}

$c = new MysqliConnect();






?>
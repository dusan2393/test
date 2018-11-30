<?php
require_once('dbconnection.php');	


class User extends DatabaseObject {
    
    protected static $table_name = "user";
    protected static $db_fields = array("id", "username", "password", "email");
    public $id;
    public $username;
    public $password;
    public $email;
    public $errors = array();
    
    // attach user and validate inputs
    public function attach_user($username, $password, $passwordConfirm, $email){

        if (isset($password) && !empty($password) && isset($passwordConfirm) && !empty($passwordConfirm) && isset($username) && !empty($username)){ 

            if ($_POST['password'] === $_POST['passwordConfirm']){

                if (!self::user_exist($_POST['username'], $_POST['email'])){

                    $this->username = $username;

                    if (strlen($password) > 4){
                        $this->password = $this->password_encrypt($password);
                    } else {
                        $this->errors[] = "Password should be at least 4 characters";
                        return false;
                    }

                    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                        $this->email = $email;
                        return true;
                    } else {
                        $this->errors[] = "Please provide your valid E-mail";
                        return false;
                    }


                } else {
                    $this->errors[] = "Mail or username already exist!";
                    return false;
                }

            } else {
                $this->errors[] = "Passwords does not mach!";
                return false;
            }
        
        } else {
            $this->errors[] = "Fill all fields!";
            return false;
        }

    }
    
    public static function user_exist($username, $email){
        $safe_user = $username;
        $safe_email = $email;
        $q  = "SELECT * FROM user ";
        $q .= "WHERE username = '$safe_user' ";
        $q .= "AND email = '$safe_email' ";
        $q .= "LIMIT 1";
        
        $result_set = self::find_by_query($q);
        return !empty($result_set) ? true : false; 
    }
    
    // used for login
    public function authenticate($username, $password){
        global $c;
        
        if (isset($username) && !empty($username) && isset($password) && !empty($password)){
            
            $safe_user = $c->safe_string($username);
            $safe_pass = $c->safe_string($password);

            $q  = "SELECT * FROM user ";
            $q .= "WHERE username = '$safe_user' ";
            $q .= "LIMIT 1";
            
            $result_set = self::find_by_query($q);

            $user = !empty($result_set) ? array_shift($result_set) : false;
            
            // if found user check if hashed password mach if yes then return user
            if ($user){
                
                if (self::password_check($password, $user->password)){
                    
                    return $user;
                    
                } else {
                    
                    $this->errors[] = "Wrong username or password!!";
                    return false;
                }
                
            } else {
                $this->errors[] = "Wrong username or password!";
                return false;
            }
            
        } else {
            $this->errors[] = "Fill all fields";
            return false;
        }
        
    }

    public static function search_users($search_text){
        global $c;
        $q  = "SELECT * FROM user WHERE ";  
        $q .= "username LIKE '%" . $c->safe_string($search_text) . "%' ";
        $q .= "OR email LIKE '%" . $c->safe_string($search_text) . "%'"; 
        $result_set = self::find_by_query($q);
        //var_dump($result_set);
        return !empty($result_set) ? $result_set : false;
    }
    
        // *-*-*-*-*-*-*-*-*-*-*-*-*-* PASSWORDS *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*///     
    private function password_encrypt($password) {
        $hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
        $salt_length = 22; 					// Blowfish salts should be 22-characters or more
        $salt = $this->generate_salt($salt_length);
        $format_and_salt = $hash_format . $salt;
        $hash = crypt($password, $format_and_salt);
        return $hash;
    }

    private function generate_salt($length) {
        // Not 100% unique, not 100% random, but good enough for a salt
        // MD5 returns 32 characters
        $unique_random_string = md5(uniqid(mt_rand(), true));

        // Valid characters for a salt are [a-zA-Z0-9./]
        $base64_string = base64_encode($unique_random_string);

        // But not '+' which is valid in base64 encoding
        $modified_base64_string = str_replace('+', '.', $base64_string);

        // Truncate string to the correct length
        $salt = substr($modified_base64_string, 0, $length);

        return $salt;
    }

    private static function password_check($password, $existing_hash) {
        
    // existing hash contains format and salt at start
        $hash = crypt($password, $existing_hash);
		echo $hash;
        
        if ($hash === $existing_hash) {
            return true;
        } else {
            return false;
        }
    }
    // ------------------ END pass END------------------//
    
}





?>
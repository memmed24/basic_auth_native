<?php
class Auth{
    public static $db;
    private $host = "mysql:host=localhost;dbname=login";
    private $user = "root";
    private $pass = "";
    private static $query;
    private static $statement;
    private static $user_data;

    function __construct(){
        session_start();
        try{
            self::$db = new PDO($this->host, $this->user, $this->pass);
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    public static function Login($array){
        self::$query = "SELECT * FROM users WHERE email = '".$array['email']."' LIMIT 1";
        self::$statement = self::$db->prepare(self::$query);
        self::$statement->execute();
        self::$user_data = self::$statement->fetch(PDO::FETCH_OBJ);

        if(self::$user_data != null){
            if(self::$user_data->password == self::Hashing($array['pass'])){
                $_SESSION["Logged"] = true;
                $_SESSION['type'] = "success";
            }else{
                $_SESSION["Wrong_password"] = true;
                $_SESSION['type'] = "fail";
            }
        }else{
            $_SESSION["User_exist_false"] = true;
            $_SESSION['type'] = "fail";
        }
        return header('Location: http://localhost/login');
    }
    public static function Register($array){
        self::$query = "SELECT * FROM users WHERE email = '".$array['email']."' LIMIT 1";
        self::$statement = self::$db->prepare(self::$query);
        self::$statement->execute();
        self::$user_data = self::$statement->fetch(PDO::FETCH_OBJ);

        if(self::$user_data == null){
            $array['pass'] = self::Hashing($array['pass']);

            self::$query = "INSERT 
                INTO users (name, email, password) 
                VALUES ('".$array['name']."', '".$array['email']."', '".$array['pass']."')";
            self::$statement = self::$db->prepare(self::$query);
            self::$statement->execute();

            $_SESSION["Register"] = true;
            $_SESSION['type'] = "success";
        }else{
            $_SESSION["User_exist"] = true;
            $_SESSION['type'] = "fail";
        }
        return header('Location: http://localhost/login');
    }
    private static function Hashing($pass): string{
        $hash = md5($pass);
        return $hash;
    }
}

$login = new Auth();
$type = $_GET['type'];
if($type == 'login'){
   Auth::Login($_POST);
}else if($type='register'){
   Auth::Register($_POST);
}
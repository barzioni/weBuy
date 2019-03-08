<?php
class Database{

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "webuy_db";
    private $username = "webuy_admin";
    private $password = "Twd55!!da4452???o3";
    public $conn;


    public function __construct()
    {
        //allowed IPs
//        $allow = array("77.127.92.142", "80.246.137.237", '185.32.177.90');
//
//        if(!in_array($_SERVER['REMOTE_ADDR'], $allow) && !in_array($_SERVER["HTTP_X_FORWARDED_FOR"], $allow)) {
//
//            echo 'You are not allowed to access this server!';
//
//            die();
//        }
    }


// get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

<?php
namespace coding\app\system;



class Database{
    public $pdo;
    function __construct($dbConfig)
    {
        $dsn="mysql:host=".$dbConfig['servername'].";dbname=".$dbConfig['dbname']."";
        $username=$dbConfig["username"];
        $pass=$dbConfig["dbpass"];
        $this->pdo=new \PDO($dsn,$username,$pass);
        //echo ("Connected") ;
    }

    public function insert(){

    }
    public function udpate(){

    }
    public function delete(){
        
    }

}
?>
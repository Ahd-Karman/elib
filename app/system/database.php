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
        echo ("Connected") ;
    }

    public function insert(){
        $columns = '';
        $values = '';

        foreach ($table_data as $key => $value) {
        $columns .= "`$key` ,";
        $values .= "'$value' ,";
        }

        $columns = substr($columns, 0, -1);
        $values = substr($values, 0, -1);

        $this->db_query = "INSERT INTO `{$this->table_name}` ($columns) VALUES ({$values})";

        return $this;
    }
    public function udpate(){

    }
    public function delete(){
        
    }

}
?>
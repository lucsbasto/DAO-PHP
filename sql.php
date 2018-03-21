<?php

class Sql extends PDO{
    private $conn;
    public  function __construct($dsn, $username, $passwd, $options){
        $this->conn = new PDO("mysql:host=localhost;dbname=db_php7","root","");
    }

}

?>
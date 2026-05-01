<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $passwords = ["", "Ja252267@&", "lomysql*123"]; 
    private $dbname = "focus_pocus_db";
    public $conn;

    public function connect() {
        $connected = false;
        foreach ($this->passwords as $pass) {
            try {
                $this->conn = new mysqli(
                    $this->host,
                    $this->username,
                    $pass,
                    $this->dbname
                );
                
                $connected = true;
                break;
                
            } catch (mysqli_sql_exception $e) {
            }
        }
        if (!$connected || $this->conn->connect_error) {
            die("Connection Failed: Please check your database settings.");
        }
       
        return $this->conn;
    }
}
?>
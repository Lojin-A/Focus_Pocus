<?php

class Database {
    private $host = "localhost";
    private $username = "root";
    private $passwords = ["", "Ja252267@&", "lomysql*123"]; 
    private $db_name="focus_pocus_db";
    public $conn;

   public function connect() {
        $this->conn = null;
        $connected = false;

        // Loop through each password in the array until one works
        foreach ($this->passwords as $pass) {
            try {
                // We use $pass (the current item in the loop) instead of $this->password
                $this->conn = new mysqli($this->host, $this->username, $pass, $this->db_name);
                
                // If there is no connection error, we found the right password!
                if (!$this->conn->connect_error) {
                    $connected = true;
                    break; 
                }
            } catch (mysqli_sql_exception $e) {
                // If this password fails, the loop just moves to the next one
                continue;
            }
        }

        if (!$connected) {
            die("Connection Failed: Could not connect with any provided passwords. Check Laragon/MySQL status.");
        }

        return $this->conn;
    }
}
?>


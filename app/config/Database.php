<?php

namespace Config;
use PDO;
use PDOException;

class Database {
    private $host = "localhost";       
    private $db_name = "youdemy"; 
    private $username = "postgres"; 
    private $password = "0000";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "pgsql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "connected successfuly";
        } catch(PDOException $e) {
            echo "EROUR: " . $e->getMessage();
        }

        return $this->conn;
    }
}

?>

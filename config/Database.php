<?php 
    class Database {
        private $namedatabase = "mesadeayuda";
        private $host = "localhost";
        private $name ="root";
        private $password = "";
        private $conn;

        public function getConnection(){
            $this->conn =null;

            try {
                $this->conn = new PDO("mysql:host" . $this->host . ";dbname=" .$this->namedatabase, $this->name, $this->password);
                $this->conn->exec("set names utf8");
            } catch (Exception $e) {
                echo "Connection error: " . $e->getMessage();
            } 
        }
    }
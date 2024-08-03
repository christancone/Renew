<?php
// DbConnector.php

class DbConnector {
    private $host = 'localhost';
    private $user = 'testuser';
    private $pass = '';
    private $dbname = 'renew';
    private $con;

    public function __construct() {
        try {
            $this->con = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit('Failed to connect to MySQL: ' . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->con;
    }
}
?>

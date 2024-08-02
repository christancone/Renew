<?php
class DBConnector {
private $host = 'localhost';
private $db = 'renew';
private $user = 'testuser';
private $pass = '';
private $charset = 'utf8mb4';
private $pdo;

public function connect() {
$dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
try {
$this->pdo = new PDO($dsn, $this->user, $this->pass);
$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
throw new PDOException($e->getMessage());
}

return $this->pdo;
}

public function disconnect() {
$this->pdo = null;
}
}

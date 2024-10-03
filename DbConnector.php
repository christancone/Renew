<?php
class DbConnector{
    private $hostName = "localhost";
    private $dbName = "renew";
    private $dbUser = "root";
    private $dbPassword = "";
    
    public function getConnection(){
        $dsn = "mysql:host=".$this->hostName.";dbname=".$this->dbName;
        
        try {
            $con = new PDO($dsn,$this->dbUser,$this->dbPassword);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $con;
        } catch (PDOException $ex) {
            die("Connection failed!".$ex->getMessage());
        }
    }
    
}
?>

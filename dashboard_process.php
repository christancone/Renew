<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once 'DBConnector.php';

class Dashboard {

    public function getAvailableItemsCount() {
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "SELECT COUNT(*) as count FROM stock";

        try {
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'];
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getOutOfStockCount() {
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "SELECT COUNT(*) as count FROM stock WHERE quantity = 0";

        try {
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'];
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getLowStockCount() {
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "SELECT COUNT(*) as count FROM stock WHERE quantity > 0 AND quantity < 10";

        try {
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'];
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getExpiredProductsCount() {
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "SELECT COUNT(*) as count FROM stock WHERE expiry_date < CURDATE()";

        try {
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'];
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getNumberOfEmployeesCount() {
        $dbcon = new dbConnector();
        $con = $dbcon->getConnection();
        $query = "SELECT COUNT(*) as count FROM users";

        try {
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $row = $pstmt->fetch(PDO::FETCH_ASSOC);
            return $row['count'];
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getDashboardData() {
        return [
            'availableItems' => $this->getAvailableItemsCount(),
            'outOfStock' => $this->getOutOfStockCount(),
            'lowStock' => $this->getLowStockCount(),
            'expiredProducts' => $this->getExpiredProductsCount(),
            'numberOfEmployees' => $this->getNumberOfEmployeesCount()
        ];
    }
}

?>

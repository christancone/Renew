<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Your existing PHP code
// e.g., fetching data and echoing JSON response


require_once 'DBConnector.php';

class Dashboard {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getOutOfStockCount() {
        try {
            $sql = "SELECT COUNT(*) as count FROM stock WHERE quantity = 0";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

    public function getLowStockCount() {
        try {
            $sql = "SELECT COUNT(*) as count FROM stock WHERE quantity > 0 AND quantity < 10";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

    public function getExpiredProductsCount() {
        try {
            $sql = "SELECT COUNT(*) as count FROM stock WHERE expiry_date < CURDATE()";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

    public function getDashboardData() {
        return [
            'outOfStock' => $this->getOutOfStockCount(),
            'lowStock' => $this->getLowStockCount(),
            'expiredProducts' => $this->getExpiredProductsCount()
        ];
    }
}

// Initialize database connection
$db = new DBConnector();
$pdo = $db->connect();

// Create an instance of the Dashboard class
$dashboard = new Dashboard($pdo);

// Get dashboard data
$data = $dashboard->getDashboardData();



// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);

// Disconnect from the database
$db->disconnect();
?>

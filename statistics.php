<?php
session_start();
include 'DbConnector.php';
if (isset($_COOKIE['user_id']) && isset($_COOKIE['role'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['role'] = $_COOKIE['role'];
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
try {
    $dbcon = new DbConnector();
    $conn = $dbcon->getConnection();

    $stmt = $conn->query("SELECT COUNT(*) as total_products FROM stock");
    $total_products = $stmt->fetchColumn();

    $stmt = $conn->query("SELECT SUM(quantity) as total_quantity FROM stock");
    $total_quantity = $stmt->fetchColumn();


    $stmt = $conn->query("SELECT prd_type, COUNT(*) as count FROM stock GROUP BY prd_type");
    $category_distribution = $stmt->fetchAll();

    $stmt = $conn->query("SELECT getmethod, COUNT(*) as count FROM stock GROUP BY getmethod");
    $method_distribution = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inventory Statistics</title>
    <style>
        
        .container {
            width: 90%;
            margin: auto;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            margin-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .table th {
            background-color: #3d5af1;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color:white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inventory Statistics</h1>
        
        <div class="card">
            <h2>Total Products</h2>
            <p><?= htmlspecialchars($total_products) ?></p>
        </div>
        
        <div class="card">
            <h2>Total Quantity of Products</h2>
            <p><?= htmlspecialchars($total_quantity) ?></p>
        </div>

        <div class="card">
            <h2>Category Distribution</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($category_distribution as $category): ?>
                        <tr>
                            <td><?= htmlspecialchars($category['prd_type']) ?></td>
                            <td><?= htmlspecialchars($category['count']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>Get Method Distribution</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Get Method</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($method_distribution as $method): ?>
                        <tr>
                            <td><?= htmlspecialchars($method['getmethod']) ?></td>
                            <td><?= htmlspecialchars($method['count']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

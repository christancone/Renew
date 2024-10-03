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

    $stmt = $conn->query("SELECT * FROM stock");
    $stocks = $stmt->fetchAll();
    $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Management System</title>
    <style>
        .container {
            width: 100%;
            margin: 0px;
            font-size: 13px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-wrapper {
            overflow-x: auto; 
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            min-width: 700px;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #3d5af1;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .edit-btn, .add-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
        }

        .edit-btn:hover, .add-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Stock</h1>
       
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Product Type</th>
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Chemical Name</th>
                        <th>Brand Name</th>
                        <th>Description</th>
                        <th>Expiry Date</th>
                        <th>Get Method</th>
                        <?php if ($isAdmin): ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stocks as $stock): ?>
                        <tr>
                            <td><?= htmlspecialchars($stock['id']) ?></td>
                            <td><?= htmlspecialchars($stock['prd_name']) ?></td>
                            <td><?= htmlspecialchars($stock['prd_type']) ?></td>
                            <td><?= htmlspecialchars($stock['quantity']) ?></td>
                            <td><img src="img/<?= htmlspecialchars($stock['image']) ?>" alt="Product Image"></td>
                            <td><?= htmlspecialchars($stock['chemical_name']) ?></td>
                            <td><?= htmlspecialchars($stock['brand_name']) ?></td>
                            <td><?= htmlspecialchars($stock['description']) ?></td>
                            <td><?= htmlspecialchars($stock['expiry_date']) ?></td>
                            <td><?= htmlspecialchars($stock['getmethod']) ?></td>
                            <?php if ($isAdmin): ?>
                               <td>
                                    <a href="edit_stock.php?id=<?= htmlspecialchars($stock['id']) ?>" class="edit-btn">Edit</a>
                                </td>


                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

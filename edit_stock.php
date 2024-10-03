<?php
session_start(); 
if (isset($_COOKIE['user_id']) && isset($_COOKIE['role'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['role'] = $_COOKIE['role'];
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'DbConnector.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    die("Access denied.");
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);

try {
    $dbcon = new DbConnector();
    $conn = $dbcon->getConnection();

    $query = "SELECT * FROM stock WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    if ($stmt->rowCount() == 0) {
        die("Stock record not found.");
    }
    
    $stock = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['update'])) {
            $prd_name = $_POST['prd_name'];
            $prd_type = $_POST['prd_type'];
            $quantity = $_POST['quantity'];
            $image = $_POST['image'];
            $chemical_name = $_POST['chemical_name'];
            $brand_name = $_POST['brand_name'];
            $description = $_POST['description'];
            $expiry_date = $_POST['expiry_date'];
            $getmethod = $_POST['getmethod'];

            if (empty($prd_name) || empty($getmethod)) {
                die("Please fill in all required fields.");
            }

            $updateQuery = "UPDATE stock SET prd_name = :prd_name, prd_type = :prd_type, quantity = :quantity, image = :image, chemical_name = :chemical_name, brand_name = :brand_name, description = :description, expiry_date = :expiry_date, getmethod = :getmethod WHERE id = :id";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindParam(':prd_name', $prd_name);
            $updateStmt->bindParam(':prd_type', $prd_type);
            $updateStmt->bindParam(':quantity', $quantity);
            $updateStmt->bindParam(':image', $image);
            $updateStmt->bindParam(':chemical_name', $chemical_name);
            $updateStmt->bindParam(':brand_name', $brand_name);
            $updateStmt->bindParam(':description', $description);
            $updateStmt->bindParam(':expiry_date', $expiry_date);
            $updateStmt->bindParam(':getmethod', $getmethod);
            $updateStmt->bindParam(':id', $id);

            if ($updateStmt->execute()) {
                header("Location: index.php"); 
                exit();
            } else {
                die("Error updating stock record.");
            }
        } elseif (isset($_POST['delete'])) {
            $deleteQuery = "DELETE FROM stock WHERE id = :id";
            $deleteStmt = $conn->prepare($deleteQuery);
            $deleteStmt->bindParam(':id', $id);

            if ($deleteStmt->execute()) {
                header("Location: index.php"); 
                exit();
            } else {
                die("Error deleting stock record.");
            }
        }
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Stock</title>
    <style>
        .container {
            width: 100%;
            margin: auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-label {
            display: block;
            margin-bottom: 5px;
        }
        .form-control {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Stock</h1>
        <form method="post">
            <div class="form-group">
                <label for="prd_name" class="form-label">Product Name</label>
                <input type="text" id="prd_name" name="prd_name" class="form-control" value="<?= htmlspecialchars($stock['prd_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="prd_type" class="form-label">Product Type</label>
                <input type="text" id="prd_type" name="prd_type" class="form-control" value="<?= htmlspecialchars($stock['prd_type']) ?>">
            </div>
            <div class="form-group">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" id="quantity" name="quantity" class="form-control" value="<?= htmlspecialchars($stock['quantity']) ?>" required>
            </div>
            <div class="form-group">
                <label for="image" class="form-label">Image URL</label>
                <input type="text" id="image" name="image" class="form-control" value="<?= htmlspecialchars($stock['image']) ?>">
            </div>
            <div class="form-group">
                <label for="chemical_name" class="form-label">Chemical Name</label>
                <input type="text" id="chemical_name" name="chemical_name" class="form-control" value="<?= htmlspecialchars($stock['chemical_name']) ?>">
            </div>
            <div class="form-group">
                <label for="brand_name" class="form-label">Brand Name</label>
                <input type="text" id="brand_name" name="brand_name" class="form-control" value="<?= htmlspecialchars($stock['brand_name']) ?>">
            </div>
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control"><?= htmlspecialchars($stock['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="expiry_date" class="form-label">Expiry Date</label>
                <input type="date" id="expiry_date" name="expiry_date" class="form-control" value="<?= htmlspecialchars($stock['expiry_date']) ?>">
            </div>
            <div class="form-group">
                <label for="getmethod" class="form-label">Get Method</label>
                <select id="getmethod" name="getmethod" class="form-control" required>
                    <option value="OTC" <?= $stock['getmethod'] === 'OTC' ? 'selected' : '' ?>>OTC</option>
                    <option value="Prescription Required" <?= $stock['getmethod'] === 'Prescription Required' ? 'selected' : '' ?>>Prescription Required</option>
                </select>
            </div>
            <div class="form-group btn-group">
                <button type="submit" name="update" class="btn-primary">Update</button>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($stock['id']) ?>">
                    <button type="submit" name="delete" class="btn-danger">Delete</button>
                </form>
            </div>
        </form>
    </div>
</body>
</html>

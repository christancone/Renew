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
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';

if (!$isAdmin) {
    die("Access denied");
}

try {
    $dbcon = new DbConnector();
    $conn = $dbcon->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin) {
        $prd_name = filter_input(INPUT_POST, 'prd_name', FILTER_SANITIZE_STRING);
        $prd_type = filter_input(INPUT_POST, 'prd_type', FILTER_SANITIZE_STRING);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
        $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
        $chemical_name = filter_input(INPUT_POST, 'chemical_name', FILTER_SANITIZE_STRING);
        $brand_name = filter_input(INPUT_POST, 'brand_name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $expiry_date = filter_input(INPUT_POST, 'expiry_date', FILTER_SANITIZE_STRING);
        $getmethod = filter_input(INPUT_POST, 'getmethod', FILTER_SANITIZE_STRING);

        if (empty($prd_name) || empty($quantity) || empty($getmethod)) {
            die("Please fill in all required fields.");
        }

        $insertQuery = "INSERT INTO stock (prd_name, prd_type, quantity, image, chemical_name, brand_name, description, expiry_date, getmethod) VALUES (:prd_name, :prd_type, :quantity, :image, :chemical_name, :brand_name, :description, :expiry_date, :getmethod)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':prd_name', $prd_name);
        $insertStmt->bindParam(':prd_type', $prd_type);
        $insertStmt->bindParam(':quantity', $quantity);
        $insertStmt->bindParam(':image', $image);
        $insertStmt->bindParam(':chemical_name', $chemical_name);
        $insertStmt->bindParam(':brand_name', $brand_name);
        $insertStmt->bindParam(':description', $description);
        $insertStmt->bindParam(':expiry_date', $expiry_date);
        $insertStmt->bindParam(':getmethod', $getmethod);

        if ($insertStmt->execute()) {
             echo "<script>
                    alert('Stock Added!');
                    window.location.href = 'index.php';
                  </script>";
            exit();

        } else {
            echo "<script>alert('An error occurred while adding the stock.');</script>";
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
    <title>Add New Stock</title>
    <style>
        .container1 {
            width: 100%;
            margin: 0 auto;
            font-size: 13px;
            max-width: 800px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .add-form {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
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
    </style>
</head>
<body>
    <div class="container1">
        <h1>Add New Stock</h1>
        <div class="add-form">
            <h2>Stock Details</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="prd_name" class="form-label">Product Name</label>
                    <input type="text" id="prd_name" name="prd_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="prd_type" class="form-label">Product Type</label>
                    <input type="text" id="prd_type" name="prd_type" class="form-control">
                </div>
                <div class="form-group">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="image" class="form-label">Image URL</label>
                    <input type="text" id="image" name="image" class="form-control" placeholder="Just type the image name.jpg">
                </div>
                <div class="form-group">
                    <label for="chemical_name" class="form-label">Chemical Name</label>
                    <input type="text" id="chemical_name" name="chemical_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="brand_name" class="form-label">Brand Name</label>
                    <input type="text" id="brand_name" name="brand_name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="expiry_date" class="form-label">Expiry Date</label>
                    <input type="date" id="expiry_date" name="expiry_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="getmethod" class="form-label">Get Method</label>
                    <select id="getmethod" name="getmethod" class="form-control" required>
                        <option value="OTC">OTC</option>
                        <option value="Prescription Required">Prescription Required</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-primary">Add Stock</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

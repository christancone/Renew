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

$isPharmacist = isset($_SESSION['role']) && $_SESSION['role'] === 'Pharmacist';

if (!$isPharmacist) {
    die("Access denied");
}


try {
    $dbcon = new DbConnector();
    $conn = $dbcon->getConnection();
    
    $userId = $_SESSION['user_id'];
    $query = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $query->execute(['id' => $userId]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    $stmt = $conn->query("SELECT id, prd_name, quantity FROM stock WHERE quantity"); 
    $lowStockItems = $stmt->fetchAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $item_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
        $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

        if (empty($item_id) || empty($message)) {
            echo "<script>alert('Please select a product and provide a message.');</script>";
        } else {
            $itemStmt = $conn->prepare("SELECT prd_name, quantity FROM stock WHERE id = :item_id");
            $itemStmt->bindParam(':item_id', $item_id);
            $itemStmt->execute();
            $item = $itemStmt->fetch();

            if ($item) {
                $fullMessage = "Reported by: " . htmlspecialchars($user['username']) . "\n | Medicine: " . htmlspecialchars($item['prd_name']) . "\n | Current Stock: " . htmlspecialchars($item['quantity']) .   "\n | Message: " . $message;

                $insertQuery = "INSERT INTO notifications (message) VALUES (:message)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bindParam(':message', $fullMessage);

                if ($insertStmt->execute()) {
                    echo "<script>alert('Notification sent successfully.');window.location.href = 'index.php';</script>";
                } else {
                    echo "<script>alert('An error occurred while sending the notification.');</script>";
                }
            } else {
                echo "<script>alert('Selected item not found.');</script>";
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
    <title>Inventory Count</title>
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
    <div class="container">
        <h1>Report Low Stock</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="item_id" class="form-label">Select Medicine</label>
                <select id="item_id" name="item_id" class="form-control" required>
                    <option value="">Select a medicine</option>
                    <?php foreach ($lowStockItems as $item): ?>
                        <option value="<?= htmlspecialchars($item['id']) ?>">
                            <?= htmlspecialchars($item['prd_name']) ?> (Current Stock: <?= htmlspecialchars($item['quantity']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-primary">Send Notification</button>
            </div>
        </form>
    </div>
</body>
</html>

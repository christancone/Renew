<?php
session_start(); // Start a new session or resume the existing session
include('DBConnector.php'); // Include your database connection class

// Get POST data from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Validate input (basic validation, should be improved for production)
if (empty($username) || empty($password)) {
    echo "Username and Password are required.";
    exit();
}

// Create a new instance of the DBConnector class
$dbConnector = new DBConnector();
$connection = $dbConnector->getConnection(); // Call the non-static method

try {
    // Prepare and execute a query to check credentials
    $query = "SELECT id, username, password, role FROM Users WHERE username = :username";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store user ID and role in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on role
            if ($user['role'] === 'Pharmacist') {
                header("Location: ../Christan/backend/redirect_pharma.php");
            } else {
                header("Location: dashboard.php"); // Adjust according to your setup
            }
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this username.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection = null; // Close the connection
?>

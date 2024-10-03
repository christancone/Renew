<?php
session_start();
include('DbConnector.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember_me']);

    if (empty($email) || empty($password)) {
        echo "Email and Password are required.";
        exit();
    }

    $dbConnector = new DbConnector();
    $connection = $dbConnector->getConnection(); 

    try {
        $query = "SELECT id, username, password, role FROM users WHERE email = :email";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);


            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                if ($rememberMe) {
                    setcookie('user_id', $user['id'], time() + (86400 * 30), "/");
                    setcookie('role', $user['role'], time() + (86400 * 30), "/");
                }

                if ($user['role'] === 'Pharmacist') {
                    header("Location: index.php");
                } else {
                    header("Location: index.php"); 
                }
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with this email.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $connection = null; 
}
?>


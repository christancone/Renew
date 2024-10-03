<?php
session_start();
require_once 'DbConnector.php';
if (isset($_COOKIE['user_id']) && isset($_COOKIE['role'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['role'] = $_COOKIE['role'];
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = trim($_POST['id']);
    $username = trim($_POST['username']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phonenumber = trim($_POST['phonenumber']);


    $errors = [];

    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username is required and should be at least 3 characters.";
    }
    if (empty($firstname) || strlen($firstname) < 1) {
        $errors[] = "First name is required.";
    }
    if (empty($lastname) || strlen($lastname) < 1) {
        $errors[] = "Last name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if (!empty($phonenumber) && !preg_match("/^[0-9]{10,15}$/", $phonenumber)) {
        $errors[] = "Phone number should be 10 to 15 digits.";
    }

    if (!empty($errors)) {
        echo "<script>
                    alert('" . implode("\\n", $errors) . "');
                    window.location.href = 'index.php';
                </script>";
        exit();
    }

    try {
        $db = new DbConnector();
        $conn = $db->getConnection();

        $query = $conn->prepare("UPDATE users SET username = :username, firstname = :firstname, lastname = :lastname, email = :email, phonenumber = :phonenumber WHERE id = :id");
        $query->execute([
            'username' => $username,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phonenumber' => $phonenumber,
            'id' => $userId
        ]);

        echo "<script>
                    alert('User Updated!');
                    window.location.href = 'index.php';
                </script>";
        
    } catch (PDOException $e) {
        echo "<script>
                    alert('Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "');
                    window.location.href = 'index.php';
                </script>";
    }
}
?>

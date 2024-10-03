<?php
include 'DbConnector.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = trim($_POST['role']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phonenumber = trim($_POST['phonenumber']);

    $errors = [];

    if (empty($role)) {
        $errors[] = "Role is required.";
    }
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username is required and should be at least 3 characters.";
    }
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password is required and should be at least 6 characters.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if (!empty($phonenumber) && !preg_match("/^[0-9]{10,15}$/", $phonenumber)) {
        $errors[] = "Phone number should be 10 to 15 digits.";
    }

    if (empty($errors)) {
        try {
            $db = new DbConnector();
            $conn = $db->getConnection();

            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->rowCount() > 0) {
                $errors[] = "Username already taken.";
            }

            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $errors[] = "Email already registered.";
            }

            if (empty($errors)) {
                $stmt = $conn->prepare("INSERT INTO users (role, username, password, firstname, lastname, email, phonenumber) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$role, $username, password_hash($password, PASSWORD_BCRYPT), $firstname, $lastname, $email, $phonenumber]);

                echo "<script>alert('Registration Successful!');window.location.href = 'login.php';</script>";
            } else {
                echo "<script>alert('".implode("\\n", $errors)."');window.location.href = 'signup.php';</script>";
            }

        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('".implode("\\n", $errors)."');window.location.href = 'signup.php';</script>";
    }
}
?>

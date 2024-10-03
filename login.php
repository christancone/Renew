<?php
session_start();
if (isset($_COOKIE['user_id']) && isset($_COOKIE['role'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['role'] = $_COOKIE['role'];
}

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Bootstrap</title>
    <link rel="stylesheet" href="login_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row border w-100 shadow rounded">
        <div class="col-md-5 bg-primary d-flex justify-content-center align-items-center mydiv shadow rounded">
            <h1 class="text-center text-white text-effect">Pharmacy</h1>
        </div>
        <div class="col-md-7">
            <form class="row justify-content-center mt-5" method="POST" action="authenticate.php">
                <div class="col-10 col-md-8">
                    <h1 class="text-center mb-4 text-effect">Login</h1>
                    <p class="text-center mb-5">Access to our dashboard</p>
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <input type="checkbox" id="remember_me" name="remember_me">
                        <label for="remember_me" class="form-label">Remember Me</label>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                    <div class="text-center mt-3">
                        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

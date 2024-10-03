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
    <title>Sign Up with Bootstrap</title>
    <link rel="stylesheet" href="login_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center signup ">
    <div class="row border w-100 shadow rounded">
        <div class="col-md-5 bg-primary d-flex justify-content-center align-items-center mydiv shadow rounded">
            <h1 class="text-center text-white text-effect">Pharmacy</h1>
        </div>
        <div class="col-md-7">
            <form class="row justify-content-center mt-5" method="POST" action="register.php">
                <div class="col-10 col-md-8">
                    <h1 class="text-center mb-4 text-effect">Sign Up</h1>
                    <p class="text-center mb-5">Create a new account</p>

                    <div class="form-group mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="" disabled selected>Select your role</option>
                            <option value="Admin">Admin</option>
                            <option value="Pharmacist">Pharmacist</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" class="form-control" required minlength="3">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required minlength="6">
                    </div>

                    <div class="form-group mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" id="firstname" name="firstname" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" id="lastname" name="lastname" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="phonenumber" class="form-label">Phone Number</label>
                        <input type="text" id="phonenumber" name="phonenumber" class="form-control" pattern="[0-9]{10,15}">
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>

                    <div class="text-center mt-3">
                        <p>Already have an account? <a href="login.php">Login here</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

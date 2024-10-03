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
$userId = $_SESSION['user_id'];
$db = new DbConnector();
$conn = $db->getConnection();

$query = $conn->prepare("SELECT * FROM users WHERE id = :id");
$query->execute(['id' => $userId]);
$user = $query->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>

        .profile-container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: auto;
        }
        .profile-card-header {
            background-color: #3d5af1;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .profile-form-group {
            margin-bottom: 20px;
        }
        .profile-label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
            color: #333;
        }
        .profile-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        .profile-input:focus {
            border-color: #007bff;
            outline: none;
        }
        .profile-form-row {
            display: flex;
            gap: 20px;
        }
        .profile-form-group-inline {
            flex: 1;
        }
        .profile-btn-primary {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #3d5af1;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .profile-btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-card-header">
            User Profile
        </div>
        <div class="profile-card-body">
            <form id="profileForm" method="POST" action="updateProfile.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                <div class="profile-form-group">
                    <label for="username" class="profile-label">Username:</label>
                    <input type="text" id="username" name="username" class="profile-input" value="<?php echo htmlspecialchars($user['username']); ?>">
                </div>
                <div class="profile-form-row">
                    <div class="profile-form-group profile-form-group-inline">
                        <label for="firstname" class="profile-label">First Name:</label>
                        <input type="text" id="firstname" name="firstname" class="profile-input" value="<?php echo htmlspecialchars($user['firstname']); ?>">
                    </div>
                    <div class="profile-form-group profile-form-group-inline">
                        <label for="lastname" class="profile-label">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" class="profile-input" value="<?php echo htmlspecialchars($user['lastname']); ?>">
                    </div>
                </div>
                <div class="profile-form-group">
                    <label for="email" class="profile-label">Email:</label>
                    <input type="email" id="email" name="email" class="profile-input" value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>
                <div class="profile-form-group">
                    <label for="phonenumber" class="profile-label">Phone Number:</label>
                    <input type="text" id="phonenumber" name="phonenumber" class="profile-input" value="<?php echo htmlspecialchars($user['phonenumber']); ?>">
                </div>
                <div class="profile-form-group">
                    <button type="submit" class="profile-btn-primary" >Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>

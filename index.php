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

$isAdmin = ($user['role'] === 'Admin');
$isPharmacist = ($user['role'] === 'Pharmacist');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/x-icon" href="./img/favicon.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="sidebar-top" style="margin-bottom:40px;">
            <span class="shrink-btn">
                <i class='bx bx-chevron-left'></i>
            </span>
            <img src="./img/logo.png" class="logo" alt="Logo">
            <h3 class="hide">Renews</h3>
        </div>

        <div class="search" style="display: none;">
            <i class='bx bx-search'></i>
            <input type="text" class="hide" placeholder="Quick Search ...">
        </div>

        <div class="sidebar-links">
            <ul>
                <div class="active-tab"></div>
                <li class="tooltip-element" data-tooltip="0">
                    <a href="#" class="active" data-active="0" data-content="dashboard">
                        <div class="icon">
                            <i class='bx bx-tachometer'></i>
                            <i class='bx bxs-tachometer'></i>
                        </div>
                        <span class="link hide">Dashboard</span>
                    </a>
                </li>
                <?php if ($isAdmin): ?>
                <li class="tooltip-element" data-tooltip="1">
                    <a href="#" data-active="1" data-content="add_inventory">
                        <div class="icon">
                            <i class='bx bx-store'></i>
                            <i class='bx bx-store'></i>
                        </div>
                        <span class="link hide">Add Inventory</span>
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($isPharmacist): ?>
                <li class="tooltip-element" data-tooltip="1">
                    <a href="#" data-active="1" data-content="InventoryCount">
                        <div class="icon">
                            <i class='bx bx-store'></i>
                            <i class='bx bx-store'></i>
                        </div>
                        <span class="link hide">Inventory Count Update</span>
                    </a>
                </li>
                <?php endif; ?>
                <li class="tooltip-element" data-tooltip="2">
                    <a href="#" data-active="2" data-content="inventory">
                        <div class="icon">
                            <i class='bx bx-store'></i>
                            <i class='bx bx-store'></i>
                        </div>
                        <span class="link hide">Inventory</span>
                    </a>
                </li>
                <li class="tooltip-element" data-tooltip="3">
                    <a href="#" data-active="3" data-content="statistics">
                        <div class="icon">
                            <i class='bx bx-bar-chart-square'></i>
                            <i class='bx bxs-bar-chart-square'></i>
                        </div>
                        <span class="link hide">Statistics</span>
                    </a>
                </li>
                <li class="tooltip-element" data-tooltip="4">
                    <a href="#" data-active="4" data-content="profile">
                        <div class="icon">
                            <i class='bx bx-user'></i>
                            <i class='bx bx-user'></i>
                        </div>
                        <span class="link hide">Profile</span>
                    </a>
                </li>
                <div class='tooltip'>
                    <span class="show">Dashboard</span>
                    <?php if ($isAdmin): ?>
                    <span>Add Inventory</span>
                    <?php endif; ?>
                    <?php if ($isPharmacist): ?>
                    <span>Inventory Count Update</span>
                    <?php endif; ?>
                    <span>Inventory</span>
                    <span>Statistics</span>
                    <span>Profile</span>
                </div>
            </ul>
        </div>

        <div class="sidebar-footer">
            <a href="#" class="account tooltip-element" data-tooltip="0">
                <i class='bx bx-user'></i>
            </a>
            <div class="admin-user tooltip-element" data-tooltip="1">
                <div class="admin-profile hide">
                    <img src="./img/manger.jpg" alt="Manager">
                    <div class="admin-info">
                        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                        <h5><?php echo htmlspecialchars($user['role']); ?></h5>
                    </div>
                </div>
                <a href="logout.php" class="log-out">
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
            <div class='tooltip'>
                <span class="show"><?php echo htmlspecialchars($user['username']); ?></span>
                <span>Logout</span>
            </div>
        </div>
    </nav>

    <main id="main-content">
    </main>

    <script src="app.js"></script>
</body>
</html>


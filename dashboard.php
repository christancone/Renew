<?php
session_start();
include 'dashboard_process.php';

if (isset($_COOKIE['user_id']) && isset($_COOKIE['role'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['role'] = $_COOKIE['role'];
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$d = new Dashboard();
$data = $d->getDashboardData();

require_once 'DbConnector.php';

$userId = $_SESSION['user_id'];
$db = new DbConnector();
$conn = $db->getConnection();

$query = $conn->prepare("SELECT * FROM users WHERE id = :id");
$query->execute(['id' => $userId]);
$user = $query->fetch(PDO::FETCH_ASSOC);

$isAdmin = ($user['role'] === 'Admin');
$isPharmacist = ($user['role'] === 'Pharmacist');

if ($isAdmin) {
    try {
        $dbcon = new DbConnector();
        $conn = $dbcon->getConnection();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_completed'])) {
            $notificationId = $_POST['notification_id'];
            $stmt = $conn->prepare("DELETE FROM notifications WHERE id = :id");
            $stmt->execute(['id' => $notificationId]);
             echo "<script>alert('Notification Marked as Completed.');window.location.href = 'index.php';</script>";
        }

        $stmt = $conn->query("SELECT * FROM notifications ORDER BY created_at DESC");
        $notifications = $stmt->fetchAll();

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>My Dashboard</h1>

    <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: flex-start; margin: 0; padding: 0;">

        <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; flex: 1 1 calc(33.333% - 20px); box-sizing: border-box; min-width: 200px;">
            <h2 style="margin-top: 0; color: #333; font-size: 18px;">Available Items</h2>
            <div style="display: flex; align-items: center; margin-top: 20px;">
                <div style="margin-right: 20px;">
                    <div style="width: 40px; height: 40px; background-color: green; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                        <i class='bx bx-check right-mark' style="color: white; font-size: 24px;"></i>
                    </div>
                </div>
                <div style="font-size: 36px; font-weight: bold; color: #333;"><?php echo $data['availableItems']; ?></div>
            </div>
        </div>

        <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; flex: 1 1 calc(33.333% - 20px); box-sizing: border-box; min-width: 200px;">
            <h2 style="margin-top: 0; color: #333; font-size: 18px;">Products Out of Stock</h2>
            <div style="display: flex; align-items: center; margin-top: 20px;">
                <div style="margin-right: 20px;">
                    <div style="width: 40px; height: 40px; background-color: #ff4d4d; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                        <i class='bx bx-block' style="color: white; font-size: 24px;"></i>
                    </div>
                </div>
                <div style="font-size: 36px; font-weight: bold; color: #333;"><?php echo $data['outOfStock']; ?></div>
            </div>
        </div>

        <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; flex: 1 1 calc(33.333% - 20px); box-sizing: border-box; min-width: 200px;">
            <h2 style="margin-top: 0; color: #333; font-size: 18px;">Low on Stock</h2>
            <div style="display: flex; align-items: center; margin-top: 20px;">
                <div style="margin-right: 20px;">
                    <div style="width: 40px; height: 40px; background-color: #ffcc00; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                        <i class='bx bx-low-vision' style="color: white; font-size: 24px;"></i>
                    </div>
                </div>
                <div style="font-size: 36px; font-weight: bold; color: #333;"><?php echo $data['lowStock']; ?></div>
            </div>
        </div>

        <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; flex: 1 1 calc(33.333% - 20px); box-sizing: border-box; min-width: 200px;">
            <h2 style="margin-top: 0; color: #333; font-size: 18px;">Expired Products</h2>
            <div style="display: flex; align-items: center; margin-top: 20px;">
                <div style="margin-right: 20px;">
                    <div style="width: 40px; height: 40px; background-color: #ff4d4d; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                        <i class='bx bx-error' style="color: white; font-size: 24px;"></i>
                    </div>
                </div>
                <div style="font-size: 36px; font-weight: bold; color: #333;"><?php echo $data['expiredProducts']; ?></div>
            </div>
        </div>

        <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 20px; flex: 1 1 calc(33.333% - 20px); box-sizing: border-box; min-width: 200px;">
            <h2 style="margin-top: 0; color: #333; font-size: 18px;">Number of Employees</h2>
            <div style="display: flex; align-items: center; margin-top: 20px;">
                <div style="margin-right: 20px;">
                    <div style="width: 40px; height: 40px; background-color: blue; border-radius: 50%; display: flex; justify-content: center; align-items: center;">
                        <i class='bx bx-user employer-mark' style="color: white; font-size: 24px;"></i>
                    </div>
                </div>
                <div style="font-size: 36px; font-weight: bold; color: #333;"><?php echo $data['numberOfEmployees']; ?></div>
            </div>
        </div>
    </div>
    </br></br>

    <?php if ($isAdmin): ?>
    <h2>Notifications</h2>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="padding: 10px; border: 1px solid #ddd; background-color: #007bff; color: white;">ID</th>
                    <th style="padding: 10px; border: 1px solid #ddd; background-color: #007bff; color: white;">Message</th>
                    <th style="padding: 10px; border: 1px solid #ddd; background-color: #007bff; color: white;">Created At</th>
                    <th style="padding: 10px; border: 1px solid #ddd; background-color: #007bff; color: white;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($notifications)): ?>
                    <?php foreach ($notifications as $notification): ?>
                        <tr>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($notification['id']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($notification['message']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;"><?= htmlspecialchars($notification['created_at']) ?></td>
                            <td style="padding: 10px; border: 1px solid #ddd;">
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <input type="hidden" name="notification_id" value="<?= htmlspecialchars($notification['id']) ?>">
                                    <button type="submit" name="mark_completed" style="background-color: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer;">Mark as Completed</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="padding: 10px; border: 1px solid #ddd; text-align: center;">No notifications available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</body>
</html>

<?php
include "../Model/db.php";
session_start();

$database = new db();
$connection = $database->connection();

$message = "";

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $delete_id = intval($_GET['id']);
    
    $target_user = $database->getUserById($connection, "users", $delete_id);
    $target_data = $target_user ? $target_user->fetch_assoc() : null;

    if ($target_data && strtolower($target_data['role']) === 'admin') {
        $_SESSION['error_message'] = "Main Admin accounts cannot be deleted!";
    } else {
        $database->deleteUser($connection, "users", $delete_id);
    }
    
    header("Location: manage_users.php");
    exit();
}

if (isset($_SESSION['error_message'])) {
    $message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

$all_users = $database->getAllUsers($connection, "users");

// Fetch Main Admin Profile
$logged_in_username = $_SESSION['username'] ?? '';
$admin_check = $database->CheckUser($connection, "users", $logged_in_username);
$main_admin = null;

if ($admin_check && $row = $admin_check->fetch_assoc()) {
    if (strtolower($row['role']) === 'admin') {
        $main_admin = $row;
    }
}

if (!$main_admin) {
    $admin_query = mysqli_query($connection, "SELECT * FROM users WHERE LOWER(role) = 'admin' LIMIT 1");
    if ($admin_query && $admin_row = mysqli_fetch_assoc($admin_query)) {
        $main_admin = $admin_row;
    }
}

$main_admin_id = $main_admin ? intval($main_admin['id']) : 0;
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Users - Main Admin</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
body { background: #f7f0df; color: #000000; display: flex; flex-direction: column; min-height: 100vh; }
.header { background: #741f2b; color: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
.header h1 { font-size: 24px; }
.back { background: #fffdf7; color: #741f2b; height: 37px; padding: 0 15px; border-radius: 5px; text-decoration: none; font-weight: 500; display: flex; align-items: center; justify-content: center; }
.back:hover { background: #f3e8d2; }

.container { flex: 1; display: flex; flex-direction: column; align-items: center; padding: 40px 20px; }
.welcome { text-align: center; margin-bottom: 25px; }
.welcome h2 { margin-bottom: 8px; color: #741f2b; }
.welcome p { color: #333333; }

/* Main Container Box */
.box { width: 100%; max-width: 800px; background: #fffdf7; padding: 30px 40px; border-radius: 10px; border: 1px solid #eadfc9; box-shadow: 0 5px 20px rgba(75, 20, 20, 0.12); }
.box h3 { color: #741f2b; margin-bottom: 12px; font-size: 20px; }

/* User List Elements (No cards, no tables) */
.user-entry { margin-bottom: 18px; line-height: 1.6; }
.user-entry p { font-size: 15px; color: #333333; }
.user-entry strong { color: #741f2b; }

.delete-btn { background: #741f2b; color: white; border: none; padding: 5px 12px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold; display: inline-block; margin-top: 6px; }
.delete-btn:hover { background: #5c1721; }

.error-msg { color: #a00000; background: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 14px; text-align: center; width: 100%; max-width: 800px; }
.no-users { color: #666; font-style: italic; margin-bottom: 15px; }

.footer { background: #741f2b; color: #fffdf7; text-align: center; padding: 15px 20px; font-size: 14px; margin-top: auto; }
</style>
</head>
<body>

<div class="header">
    <h1>Manage Users</h1>
    <a href="admin.php" class="back">Back to Dashboard</a>
</div>

<div class="container">
    <div class="welcome">
        <h2>System Users</h2>
        <p>View and manage existing system accounts.</p>
    </div>

    <?php if (!empty($message)): ?>
        <div class="error-msg"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <div class="box">
        <h3>Main Admin Profile</h3>
        <?php if ($main_admin): ?>
            <div class="user-entry">
                <p><strong>ID:</strong> <?php echo $main_admin['id']; ?> | <strong>Name:</strong> <?php echo htmlspecialchars($main_admin['name']); ?> (Main Admin)</p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($main_admin['username']); ?> | <strong>Password:</strong> <?php echo htmlspecialchars($main_admin['password']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($main_admin['email']); ?> | <strong>Role:</strong> <?php echo htmlspecialchars(ucfirst($main_admin['role'])); ?></p>
            </div>
        <?php else: ?>
            <p class="no-users">Main Admin profile not found.</p>
        <?php endif; ?>

        <hr style="border: 0; border-top: 1px solid #eadfc9; margin: 20px 0;">

        <h3>Other Users</h3>
        <?php 
        $has_other_users = false;
        if ($all_users && $all_users->num_rows > 0): 
            while ($row = $all_users->fetch_assoc()): 
                if (intval($row['id']) === $main_admin_id || strtolower($row['role']) === 'admin') continue;
                $has_other_users = true;
        ?>
            <div class="user-entry">
                <p><strong>ID:</strong> <?php echo $row['id']; ?> | <strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($row['username']); ?> | <strong>Password:</strong> <?php echo htmlspecialchars($row['password']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?> | <strong>Role:</strong> <?php echo htmlspecialchars(ucfirst($row['role'])); ?></p>
                <a href="manage_users.php?action=delete&id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
            </div>
        <?php 
            endwhile; 
        endif; 
        if (!$has_other_users):
        ?>
            <p class="no-users">No other users registered in the system.</p>
        <?php endif; ?>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

</body>
</html>
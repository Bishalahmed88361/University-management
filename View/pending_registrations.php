<?php
include "../Model/db.php";
session_start();

$database = new db();
$connection = $database->connection();

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'approve') {
        $database->approveUser($connection, "users", $id);
    } else if ($_GET['action'] === 'reject') {
        $database->deleteUser($connection, "users", $id);
    }
    header("Location: pending_registrations.php");
    exit();
}

$pending_users = $database->getPendingUsers($connection, "users");
?>
<!DOCTYPE html>
<html>
<head>
<title>Pending Registrations</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
body { background: #f7f0df; color: #000000; display: flex; flex-direction: column; min-height: 100vh; }
.header { background: #741f2b; color: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
.header h1 { font-size: 24px; }
.back { background: #fffdf7; color: #741f2b; height: 37px; padding: 0 15px; border-radius: 5px; text-decoration: none; font-weight: 500; display: flex; align-items: center; justify-content: center; }
.back:hover { background: #f3e8d2; }
.container { flex: 1; padding: 40px; }
.welcome { margin-bottom: 25px; }
.welcome h2 { margin-bottom: 8px; }
.welcome p { color: #333333; }
.user-item { margin-bottom: 15px; font-size: 15px; }
.btn-link { background: #741f2b; color: white; border: none; padding: 4px 10px; border-radius: 4px; text-decoration: none; font-size: 13px; margin-left: 5px; }
.btn-link:hover { background: #5c1721; }
.footer { background: #741f2b; color: #fffdf7; text-align: center; padding: 15px 20px; font-size: 14px; margin-top: auto; }
</style>
</head>
<body>

<div class="header">
    <h1>Pending Registrations</h1>
    <a href="admin.php" class="back">Back to Dashboard</a>
</div>

<div class="container">
    <div class="welcome">
        <h2>Registration Requests</h2>
        <p>Review and manage pending user registration requests.</p>
    </div>

    <div class="user-list">
        <?php if ($pending_users && $pending_users->num_rows > 0): ?>
            <?php while ($row = $pending_users->fetch_assoc()): ?>
                <div class="user-item">
                    ID: <?php echo $row['id']; ?> | 
                    Name: <?php echo htmlspecialchars($row['name']); ?> | 
                    Username: <?php echo htmlspecialchars($row['username']); ?> | 
                    Email: <?php echo htmlspecialchars($row['email']); ?> | 
                    Role: <?php echo htmlspecialchars($row['role']); ?>
                    <a href="pending_registrations.php?action=approve&id=<?php echo $row['id']; ?>" class="btn-link">Approve</a>
                    <a href="pending_registrations.php?action=reject&id=<?php echo $row['id']; ?>" class="btn-link" onclick="return confirm('Reject this request?')">Reject</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No pending registrations available.</p>
        <?php endif; ?>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

</body>
</html>
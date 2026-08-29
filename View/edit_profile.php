<?php
include "../Model/db.php";
session_start();

$database = new db();
$connection = $database->connection();

// Determine navigation back link
if (isset($_GET["from"])) {
    if ($_GET["from"] == "course_admin.php") {
        $backPage = "course_admin.php";
    } else if ($_GET["from"] == "teacher.php") {
        $backPage = "teacher.php";
    } else if ($_GET["from"] == "student.php") {
        $backPage = "student.php";
    } else {
        $backPage = "admin.php";
    }
} else {
    $backPage = "admin.php";
}

// Fetch currently logged-in user
$logged_in_username = $_SESSION['username'] ?? '';
$user_res = $database->CheckUser($connection, "users", $logged_in_username);
$current_user = ($user_res && $user_res->num_rows > 0) ? $user_res->fetch_assoc() : null;

$message = "";
$message_type = "";

// Handle Delete Account (Blocked for admin role)
if (isset($_POST['action']) && $_POST['action'] === 'delete_account' && $current_user) {
    if ($current_user['role'] === 'admin') {
        $message = "Main Admin cannot delete their own account.";
        $message_type = "error";
    } else {
        $database->deleteUser($connection, "users", $current_user['id']);
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

// Handle Form Submission (Save Changes)
if ($_SERVER["REQUEST_METHOD"] === "POST" && (!isset($_POST['action']) || $_POST['action'] !== 'delete_account')) {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirm_password = trim($_POST["confirm_password"] ?? "");

    if (empty($name) || empty($email) || empty($username)) {
        $message = "Please fill all required fields.";
        $message_type = "error";
    } else if (!empty($password) && $password !== $confirm_password) {
        $message = "Passwords do not match.";
        $message_type = "error";
    } else if ($current_user) {
        // Check if username is taken by another user
        if ($username !== $current_user['username']) {
            $check_user = $database->CheckUser($connection, "users", $username);
            if ($check_user && $check_user->num_rows > 0) {
                $message = "Username is already taken by another account.";
                $message_type = "error";
            }
        }

        if (empty($message)) {
            $update_res = $database->updateProfile($connection, "users", $current_user['id'], $name, $email, $username, $password);
            if ($update_res) {
                $_SESSION['username'] = $username; // Update session if username changed
                $message = "Profile updated successfully.";
                $message_type = "success";
                
                // Refresh local user data
                $user_res = $database->CheckUser($connection, "users", $username);
                $current_user = $user_res->fetch_assoc();
            } else {
                $message = "Failed to update profile. Please try again.";
                $message_type = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Profile</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
body { background: #f7f0df; color: #000000; display: flex; flex-direction: column; min-height: 100vh; }
.header { background: #741f2b; color: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
.header h1 { font-size: 24px; }
.back { background: #fffdf7; color: #741f2b; height: 37px; padding: 0 15px; border-radius: 5px; text-decoration: none; font-weight: 500; display: flex; align-items: center; justify-content: center; }
.back:hover { background: #f3e8d2; }
.container { flex: 1; display: flex; justify-content: center; align-items: center; padding: 40px; }
.box { width: 400px; background: #fffdf7; padding: 40px; border-radius: 10px; border: 1px solid #eadfc9; box-shadow: 0 5px 20px rgba(75, 20, 20, 0.12); }
.box h2 { color: #741f2b; text-align: center; font-size: 24px; margin-bottom: 8px; }
.subtitle { text-align: center; color: #333333; margin-bottom: 20px; font-size: 14px; }
.form-group { margin-bottom: 18px; }
label { display: block; margin-bottom: 6px; font-weight: bold; font-size: 14px; }
input { width: 100%; padding: 11px; border: 1px solid #aaa; border-radius: 5px; font-size: 14px; background: white; color: #000000; }
input:focus { outline: none; border-color: #741f2b; }
.buttons { display: flex; gap: 10px; margin-top: 5px; }
button { width: 100%; padding: 12px; background: #741f2b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; }
button:hover { background: #5c1721; }
.cancel-btn { margin-top: 15px; }
.error-msg { color: #a00000; background: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: center; }
.success-msg { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: center; }
.footer { background: #741f2b; color: #fffdf7; text-align: center; padding: 15px 20px; font-size: 14px; margin-top: auto; }

@media (max-width: 600px) {
    .header { padding: 20px; }
    .container { padding: 25px; }
    .box { width: 100%; max-width: 400px; }
}
</style>
</head>
<body>

<div class="header">
    <h1>Edit Profile</h1>
    <a href="<?php echo htmlspecialchars($backPage); ?>" class="back">Back to Dashboard</a>
</div>

<div class="container">
    <div class="box">
        <h2>Manage Profile Information</h2>
        <p class="subtitle">Update your personal account information.</p>

        <?php if (!empty($message)): ?>
            <div class="<?php echo ($message_type === 'success') ? 'success-msg' : 'error-msg'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="post" id="profileForm" action="edit_profile.php?from=<?php echo urlencode($backPage); ?>" onsubmit="return validateForm()">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($current_user['name'] ?? ''); ?>" placeholder="Enter name">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($current_user['email'] ?? ''); ?>" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($current_user['username'] ?? ''); ?>" placeholder="Enter username">
            </div>

            <div class="form-group">
                <label>New Password (leave blank to keep current)</label>
                <input type="password" name="password" placeholder="Enter new password">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm password">
            </div>

            <div class="buttons">
                <button type="submit">Save Changes</button>
                <?php if ($current_user && $current_user['role'] !== 'admin'): ?>
                    <button type="submit" name="action" value="delete_account" onclick="return confirm('Are you sure you want to delete your profile? This cannot be undone.');">Delete Account</button>
                <?php endif; ?>
            </div>

            <button type="button" class="cancel-btn" onclick="window.location.href='<?php echo htmlspecialchars($backPage); ?>'">Cancel</button>
        </form>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

<script>
function validateForm() {
    let activeElement = document.activeElement;
    if (activeElement && activeElement.value === "delete_account") {
        return true;
    }

    let name = document.querySelector("[name='name']").value.trim();
    let email = document.querySelector("[name='email']").value.trim();
    let username = document.querySelector("[name='username']").value.trim();
    let password = document.querySelector("[name='password']").value.trim();
    let confirmPassword = document.querySelector("[name='confirm_password']").value.trim();

    if (name === "" || email === "" || username === "") {
        alert("Please fill all required fields.");
        return false;
    }

    if (password !== "" && password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    return true;
}
</script>

</body>
</html>
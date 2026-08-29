<?php
include "../Model/db.php";
session_start();

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirm_password = trim($_POST["confirm_password"] ?? "");
    $role = $_POST["role"] ?? "";

    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($role)) {
        $message = "Please fill all fields.";
        $message_type = "error";
    } else if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $message_type = "error";
    } else {
        $database = new db();
        $connection = $database->connection();
        $result = $database->createUserDirect($connection, "users", $name, $email, $username, $password, $role);

        if ($result) {
            $message = "User created successfully!";
            $message_type = "success";
        } else {
            $message = "Creation failed. Try again.";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Create User</title>
<script src="../JS/CheckUser.js"></script>
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
.subtitle { text-align: center; color: #333333; margin-bottom: 30px; font-size: 14px; }
.form-group { margin-bottom: 18px; }
label { display: block; margin-bottom: 6px; font-weight: bold; font-size: 14px; }
input, select { width: 100%; padding: 11px; border: 1px solid #aaa; border-radius: 5px; font-size: 14px; background: white; color: #000000; }
input:focus, select:focus { outline: none; border-color: #741f2b; }
.buttons { display: flex; gap: 10px; margin-top: 5px; }
button { width: 100%; padding: 12px; background: #741f2b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; }
button:hover { background: #5c1721; }
.error { color: #a00000; background: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: center; }
.success { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: center; }
.footer { background: #741f2b; color: #fffdf7; text-align: center; padding: 15px 20px; font-size: 14px; margin-top: auto; }
@media (max-width: 600px) { .header { padding: 20px; } .container { padding: 25px; } .box { width: 100%; max-width: 400px; } }
</style>
<script>
    function collect_data() {
        let name = document.querySelector("[name='name']").value.trim();
        let email = document.querySelector("[name='email']").value.trim();
        let username = document.getElementById("username").value.trim();
        let password = document.querySelector("[name='password']").value.trim();
        let confirmPassword = document.querySelector("[name='confirm_password']").value.trim();
        let role = document.querySelector("[name='role']").value;

        if (name === "" || email === "" || username === "" || password === "" || confirmPassword === "" || role === "") {
            alert("Please fill all fields.");
            return false;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        return true;
    }
</script>
</head>
<body>

<div class="header">
    <h1>Create User</h1>
    <a href="admin.php" class="back">Back to Dashboard</a>
</div>

<div class="container">
    <div class="box">
        <h2>Create New User</h2>
        <p class="subtitle">Create an account directly for a university user.</p>

        <?php if (!empty($message)): ?>
            <div class="<?php echo ($message_type === 'success') ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="" onsubmit="return collect_data()">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" placeholder="Enter name">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" onkeyup="CheckUser()">
                <span id="userresponse" style="font-size: 12px; margin-top: 4px; display: block;"></span>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password">
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Confirm password">
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role">
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="course_admin">Course Administrator</option>
                </select>
            </div>

            <div class="buttons">
                <button type="submit">Create User</button>
                <button type="button" onclick="window.location.href='admin.php'">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

</body>
</html>
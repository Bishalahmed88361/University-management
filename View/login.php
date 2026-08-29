<?php
include "../Controller/Loginvalidation.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background: #f7f0df; color: #000000; }
        .container { min-height: 100vh; display: flex; justify-content: center; align-items: center; }
        .box { width: 400px; background: #fffdf7; padding: 40px; border-radius: 10px; border: 1px solid #eadfc9; box-shadow: 0 5px 20px rgba(75, 20, 20, 0.12); }
        .box h1 { color: #741f2b; text-align: center; font-size: 27px; margin-bottom: 8px; }
        .subtitle { text-align: center; color: #333333; margin-bottom: 30px; font-size: 14px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-weight: bold; font-size: 14px; }
        input, select { width: 100%; padding: 11px; border: 1px solid #aaa; border-radius: 5px; font-size: 14px; background: white; }
        input:focus, select:focus { outline: none; border-color: #741f2b; }
        button { width: 100%; padding: 12px; background: #741f2b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; }
        button:hover { background: #5c1721; }
        .link { text-align: center; margin-top: 15px; font-size: 14px; }
        .link a { color: #741f2b; text-decoration: none; font-weight: bold; }
        .link a:hover { text-decoration: underline; }
        .error { color: #a00000; font-size: 13px; margin-bottom: 15px; text-align: center; }
    </style>
    <script>
        function collect_data() {
            let username = document.getElementById("username").value.trim();
            let password = document.getElementById("password").value.trim();
            let role = document.getElementById("role").value;

            if (username === "" || password === "" || role === "") {
                document.getElementById("error").style.display = "block";
                return false;
            }
            return true;
        }
    </script>
</head>
<body>

<div class="container">
    <div class="box">
        <h1>University Management System</h1>
        <p class="subtitle">Please login to continue.</p>

        <p class="error" id="error" style="<?php echo !empty($message) ? 'display:block;' : 'display:none;'; ?>">
            <?php echo !empty($message) ? $message : 'Please fill all fields.'; ?>
        </p>

        <form method="post" action="" onsubmit="return collect_data()">
            <div class="form-group">
                <label>Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($username); ?>">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password">
            </div>

            <div class="form-group">
                <label>Login As</label>
                <select id="role" name="role">
                    <option value="">Select Role</option>
                    <option value="admin">Main Admin</option>
                    <option value="course_admin">Course Administrator</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="link">
            <a href="home.php">Back to Home</a>
        </div>
    </div>
</div>

</body>
</html>
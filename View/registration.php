<?php
include "../Controller/RegistrationValidation.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <script src="../JS/CheckUser.js"></script>
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
        .buttons { display: flex; gap: 10px; margin-top: 5px; }
        button { width: 100%; padding: 12px; background: #741f2b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; }
        button:hover { background: #5c1721; }
        .link { text-align: center; margin-top: 15px; font-size: 14px; }
        .link a { color: #741f2b; text-decoration: none; font-weight: bold; }
        .link a:hover { text-decoration: underline; }
        .error { color: #a00000; font-size: 13px; margin-bottom: 15px; text-align: center; }
        .success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: center;
        }
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

<div class="container">
    <div class="box">
        <h1>Registration</h1>
        <p class="subtitle">Create an account request.</p>

        <?php if (!empty($message)): ?>
            <p class="<?php echo (strpos($message, 'submitted') !== false) ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
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
                <label>Register As</label>
                <select name="role">
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="course_admin">Course Administrator</option>
                </select>
            </div>

            <div class="buttons">
                <button type="submit">Register</button>
                <button type="button" onclick="window.location.href='home.php'">Cancel</button>
            </div>
        </form>

        <div class="link">
            <a href="login.php">Already have an account? Login</a>
        </div>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html>
<head>
<title>Main Admin Dashboard</title>
<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

html, body {
    height: 100%;
}

body {
    background: #f7f0df;
    color: #000000;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.header {
    background: #741f2b;
    color: white;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h1 {
    font-size: 24px;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.notification, .logout {
    width: 110px;
    height: 37px;
    background: #fffdf7;
    color: #741f2b;
    padding: 0 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification:hover, .logout:hover {
    background: #f3e8d2;
}

.container {
    width: 650px;
    height: 480px;
    margin: 40px auto;
    background: #fffdf7;
    border: 1px solid #eadfc9;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(75, 20, 20, 0.12);
    padding: 30px 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    box-sizing: border-box;
}

.welcome {
    margin-bottom: 20px;
    height: 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.welcome h2 {
    margin-bottom: 6px;
    font-size: 22px;
    color: #741f2b;
    line-height: 1.2;
}

.welcome p {
    color: #333333;
    font-size: 14px;
    line-height: 1.2;
}

.menu {
    display: flex;
    flex-direction: column;
    gap: 14px;
    width: 380px;
}

.menu button {
    width: 100%;
    height: 48px;
    background: #741f2b;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 500;
}

.menu button:hover {
    background: #5c1721;
}

.footer {
    background: #741f2b;
    color: #fffdf7;
    text-align: center;
    padding: 15px 20px;
    font-size: 14px;
    margin-top: auto;
    width: 100%;
}
</style>
</head>
<body>

<div class="header">
    <h1>Main Admin Dashboard</h1>
    <div class="header-right">
        <div class="notification" onclick="notifications()">
            Notifications
        </div>
        <a href="login.php" class="logout">
            Logout
        </a>
    </div>
</div>

<div class="container">
    <div class="welcome">
        <h2>Welcome, Main Admin</h2>
        <p>Manage users and registration.</p>
    </div>

    <div class="menu">
        <button onclick="window.location.href='create_user.php'">
            Create Users
        </button>
        <button onclick="window.location.href='pending_registrations.php'">
            Pending Registrations
        </button>
        <button onclick="window.location.href='manage_users.php'">
            Manage Users
        </button>
        <button onclick="window.location.href='edit_profile.php?from=admin.php'">
            Edit Profile
        </button>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

<script>
function notifications() {

}
</script>

</body>
</html>
<?php
include "../Model/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirm_password = trim($_POST["confirm_password"] ?? "");
    $role = $_POST["role"] ?? "";

    if (empty($name) || empty($email) || empty($username) || empty($password) || empty($confirm_password) || empty($role)) {
        $message = "Please fill all fields.";
    } else if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $database = new db();
        $connection = $database->connection();

        // Check if username already exists
        $check_user = $database->CheckUser($connection, "users", $username);
        if ($check_user && mysqli_num_rows($check_user) > 0) {
            $message = "Username is already taken.";
        } else {
            $result = $database->signup($connection, "users", $name, $email, $username, $password, $role);
            if ($result) {
                $message = "Your registration request is submitted. Please wait for the admin to approve your account.";
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<?php
include "../Model/db.php";
session_start();

$username = "";
$password = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $role = $_POST["role"] ?? "";

    $valid = true;
    if (empty($username) || empty($password) || empty($role)) {
        $message = "Please fill all fields.";
        $valid = false;
    }

    if ($valid) {
        $database = new db();
        $connection = $database->connection();
        $result = $database->signin($connection, "users", $username, $password);

        if ($result !== false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if ($row['role'] === $role) {
                $_SESSION["logged_in"] = true;
                $_SESSION["username"] = $row['username'];
                $_SESSION["role"] = $row['role'];

                $jsonfile = "../Model/user.json";
                $users = [];
                if (file_exists($jsonfile)) {
                    $jsonData = file_get_contents($jsonfile);
                    $users = json_decode($jsonData, true) ?? [];
                }
                $users[] = [
                    'username' => $username,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'timestamp' => time()
                ];
                file_put_contents($jsonfile, json_encode($users, JSON_PRETTY_PRINT));

                if ($role === "admin") {
                    Header("Location:../View/admin.php");
                } else if ($role === "course_admin") {
                    Header("Location:../View/course_admin.php");
                } else if ($role === "teacher") {
                    Header("Location:../View/teacher.php");
                } else if ($role === "student") {
                    Header("Location:../View/student.php");
                }
            } else {
                $message = "Role mismatch for this user.";
            }
        } else {
            $message = "Invalid Credentials or Account Not Approved.";
        }
    }
}
?>

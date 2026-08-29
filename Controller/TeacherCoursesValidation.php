<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "../Model/db.php";

if (
    !isset($_SESSION["logged_in"]) ||
    $_SESSION["logged_in"] !== true ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "teacher"
) {
    header("Location: login.php");
    exit;
}

$teacher_username = $_SESSION["username"];

$db = new db();
$connection = $db->connection();
$teacher_courses = $db->getTeacherCourses($connection, $teacher_username);
?>

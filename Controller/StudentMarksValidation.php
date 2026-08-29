<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "../Model/db.php";

if (
    !isset($_SESSION["logged_in"]) ||
    $_SESSION["logged_in"] !== true ||
    !isset($_SESSION["role"]) ||
    $_SESSION["role"] !== "student" ||
    !isset($_SESSION["username"])
) {
    header("Location: login.php");
    exit;
}

$student_username = $_SESSION["username"];

$db = new db();
$connection = $db->connection();
$student_marks = $db->getStudentMarks($connection, $student_username);
?>

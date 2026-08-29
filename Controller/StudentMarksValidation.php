<?php
session_start();
include "../Model/db.php";

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] != true || !isset($_SESSION["role"]) || $_SESSION["role"] != "student" || !isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$student_username = $_SESSION["username"];

$db = new db();
$connection = $db->connection();
$marks_records = $db->getStudentMarks($connection, $student_username);
?>

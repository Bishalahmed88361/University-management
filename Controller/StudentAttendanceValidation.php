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
$enrolled_courses = $db->getStudentCourses($connection, $student_username);

$selected_course = trim($_GET["course_id"] ?? "");
$attendance_records = [];

if ($selected_course != "") {
    $course_details = $db->getStudentCourseDetails($connection, $student_username, $selected_course);

    if ($course_details) {
        $attendance_records = $db->getStudentAttendanceRecords($connection, $student_username, $selected_course);
    } else {
        $selected_course = "";
    }
}
?>

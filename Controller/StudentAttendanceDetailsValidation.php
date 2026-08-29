<?php
session_start();
include "../Model/db.php";

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] != true || !isset($_SESSION["role"]) || $_SESSION["role"] != "student" || !isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$student_username = $_SESSION["username"];
$selected_course = trim($_GET["course_id"] ?? "");

$course = null;
$attendance_records = [];
$total_classes = 0;
$classes_present = 0;
$attendance_percentage = 0;
$error = "";

$db = new db();
$connection = $db->connection();

if ($selected_course == "") {
    $error = "Please select a course.";
} else {
    $course = $db->getStudentCourseDetails($connection, $student_username, $selected_course);

    if ($course == null) {
        $error = "This course is not included in your enrollment.";
    } else {
        $attendance_records = $db->getStudentAttendanceRecords($connection, $student_username, $selected_course);
        $total_classes = count($attendance_records);

        foreach ($attendance_records as $record) {
            if ($record["status"] == "present") {
                $classes_present++;
            }
        }

        if ($total_classes > 0) {
            $attendance_percentage = round(($classes_present / $total_classes) * 100, 2);
        }
    }
}
?>

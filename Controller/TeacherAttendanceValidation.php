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

$selected_course = "";
$selected_date = date("Y-m-d");
$students = [];
$attendance = [];
$message = "";
$error = "";

if (isset($_GET["course_id"])) {
    $selected_course = trim($_GET["course_id"]);

    if ($selected_course !== "") {
        if ($db->isTeacherAssignedToCourse($connection, $teacher_username, $selected_course)) {
            if (isset($_GET["date"]) && $_GET["date"] !== "") {
                $selected_date = $_GET["date"];
            }

            $students = $db->getCourseStudents($connection, $selected_course);
            $attendance = $db->getAttendance($connection, $selected_course, $selected_date);
        } else {
            $error = "You are not assigned to this course.";
            $selected_course = "";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selected_course = isset($_POST["course_id"]) ? trim($_POST["course_id"]) : "";
    $selected_date = isset($_POST["date"]) ? trim($_POST["date"]) : "";

    if ($selected_course === "") {
        $error = "Please select a course.";
    } elseif ($selected_date === "") {
        $error = "Please select a date.";
    } elseif (!$db->isTeacherAssignedToCourse($connection, $teacher_username, $selected_course)) {
        $error = "You are not assigned to this course.";
    } elseif (isset($_POST["attendance"]) && is_array($_POST["attendance"])) {
        foreach ($_POST["attendance"] as $student_username => $status) {
            if ($status !== "present" && $status !== "absent") {
                $error = "Invalid attendance status.";
                break;
            }

            $db->saveAttendance(
                $connection,
                $selected_course,
                $student_username,
                $selected_date,
                $status
            );
        }

        if ($error === "") {
            $message = "Attendance saved successfully.";
        }
    }

    if ($error === "") {
        $students = $db->getCourseStudents($connection, $selected_course);
        $attendance = $db->getAttendance($connection, $selected_course, $selected_date);
    }
}
?>

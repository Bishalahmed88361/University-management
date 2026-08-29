<?php
session_start();
include "../Model/db.php";

if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] != true || !isset($_SESSION["role"]) || $_SESSION["role"] != "teacher" || !isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$teacher_username = $_SESSION["username"];

$db = new db();
$connection = $db->connection();
$teacher_courses = $db->getTeacherCourses($connection, $teacher_username);

$selected_course = "";
$students = [];
$marks = [];
$message = "";
$error = "";

if (isset($_GET["course_id"])) {
    $selected_course = trim($_GET["course_id"]);

    if ($selected_course != "") {
        if ($db->isTeacherAssignedToCourse($connection, $teacher_username, $selected_course)) {
            $students = $db->getCourseStudents($connection, $selected_course);
            $marks = $db->getMarks($connection, $selected_course);
        } else {
            $error = "You are not assigned to this course.";
            $selected_course = "";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selected_course = trim($_POST["course_id"] ?? "");

    if ($selected_course == "") {
        $error = "Please select a course.";
    } elseif (!$db->isTeacherAssignedToCourse($connection, $teacher_username, $selected_course)) {
        $error = "You are not assigned to this course.";
    } elseif (isset($_POST["marks"]) && is_array($_POST["marks"])) {
        $students = $db->getCourseStudents($connection, $selected_course);

        foreach ($_POST["marks"] as $student_username => $mark) {
            $mark = trim($mark);

            if ($mark == "") {
                continue;
            }

            $student_allowed = false;

            foreach ($students as $student) {
                if ($student["username"] == $student_username) {
                    $student_allowed = true;
                    break;
                }
            }

            if (!$student_allowed) {
                $error = "Invalid student for this course.";
                break;
            } elseif (!is_numeric($mark)) {
                $error = "Marks must be numeric.";
                break;
            }

            $mark = (float) $mark;

            if ($mark < 0 || $mark > 100) {
                $error = "Marks must be between 0 and 100.";
                break;
            }

            if ($mark >= 80) {
                $grade = "A+";
            } elseif ($mark >= 75) {
                $grade = "A";
            } elseif ($mark >= 70) {
                $grade = "A-";
            } elseif ($mark >= 65) {
                $grade = "B+";
            } elseif ($mark >= 60) {
                $grade = "B";
            } elseif ($mark >= 55) {
                $grade = "B-";
            } elseif ($mark >= 50) {
                $grade = "C+";
            } elseif ($mark >= 45) {
                $grade = "C";
            } elseif ($mark >= 40) {
                $grade = "D";
            } else {
                $grade = "F";
            }

            $saved = $db->saveMark($connection, $selected_course, $student_username, $mark, $grade);

            if (!$saved) {
                $error = "Unable to save marks.";
                break;
            }
        }

        if ($error == "") {
            $message = "Marks saved successfully.";
        }

        $students = $db->getCourseStudents($connection, $selected_course);
        $marks = $db->getMarks($connection, $selected_course);
    } else {
        $error = "Marks data is missing.";
    }
}
?>

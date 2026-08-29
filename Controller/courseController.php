<?php
session_start();
include "../Model/db.php";

if (isset($_GET["action"]) && $_GET["action"] == "check_unique") {
    header("Content-Type: application/json");

    $database = new db();
    $connection = $database->connection();

    $field = $_GET["field"] ?? "";
    $value = trim($_GET["value"] ?? "");
    $response = ["isUnique" => true];

    if ($field == "course_id" && !empty($value)) {
        $courses = $database->getCourses($connection);

        if ($courses) {
            while ($course = mysqli_fetch_assoc($courses)) {
                if ($course["course_id"] == $value) {
                    $response["isUnique"] = false;
                    break;
                }
            }
        }
    }

    echo json_encode($response);
    exit();
}

class CourseController
{
    function handleCourseCreation()
    {
        $message = "";
        $message_type = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $course_id = trim($_POST["course_id"] ?? "");
            $course_name = trim($_POST["course_name"] ?? "");
            $course_code = trim($_POST["course_code"] ?? "");
            $credit = trim($_POST["credit"] ?? "3");
            $day = trim($_POST["day"] ?? "");
            $start_time = trim($_POST["start_time"] ?? "");
            $end_time = trim($_POST["end_time"] ?? "");

            if (empty($course_id) || empty($course_name) || empty($course_code) || empty($credit) || empty($day) || empty($start_time) || empty($end_time)) {
                $message = "Please fill all fields.";
                $message_type = "error";
            } elseif (!is_numeric($credit) || $credit < 1 || $credit > 6) {
                $message = "Course credit must be between 1 and 6.";
                $message_type = "error";
            } else {
                $database = new db();
                $connection = $database->connection();

                $created = $database->createCourse(
                    $connection,
                    $course_id,
                    $course_name,
                    $course_code,
                    $credit,
                    $day,
                    $start_time,
                    $end_time
                );

                if ($created) {
                    $message = "Course created successfully!";
                    $message_type = "success";
                } else {
                    $message = "Failed to create course. Course ID may already exist.";
                    $message_type = "error";
                }
            }
        }

        return [
            "message" => $message,
            "message_type" => $message_type
        ];
    }

    function fetchAllCoursesWithDetails()
    {
        $database = new db();
        $connection = $database->connection();

        $sql = "SELECT courses.*,
                       users.name AS teacher_name,
                       COUNT(student_enrollments.student_username) AS enrolled_students
                FROM courses
                LEFT JOIN faculty_assignments
                ON courses.course_id = faculty_assignments.course_id
                LEFT JOIN users
                ON faculty_assignments.faculty_username = users.username
                LEFT JOIN student_enrollments
                ON courses.course_id = student_enrollments.course_id
                GROUP BY courses.course_id";

        $result = mysqli_query($connection, $sql);

        if ($result == false) {
            return $database->getCourses($connection);
        }

        return $result;
    }
}
?>

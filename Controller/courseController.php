<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "../Model/db.php";

if (isset($_GET['action']) && $_GET['action'] === 'check_unique') {
    ob_clean();
    header('Content-Type: application/json');

    $db = new db();
    $conn = $db->connection();

    $field = $_GET['field'] ?? '';
    $value = trim($_GET['value'] ?? '');

    $response = ['isUnique' => true];

    if ($field === 'course_id' && !empty($value)) {
        $stmt = $conn->prepare("SELECT course_id FROM courses WHERE course_id = ?");
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $response['isUnique'] = false;
        }
        $stmt->close();
    } elseif ($field === 'course_code' && !empty($value)) {
        $stmt = $conn->prepare("SELECT course_code FROM courses WHERE course_code = ?");
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $response['isUnique'] = false;
        }
        $stmt->close();
    }

    echo json_encode($response);
    exit;
}

class CourseController {
    private $db;
    private $connection;

    public function __construct() {
        $this->db = new db();
        $this->connection = $this->db->connection();
    }

    public function handleCourseCreation() {
        $message = "";
        $message_type = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
            } elseif (!is_numeric($credit) || (int)$credit < 1 || (int)$credit > 6) {
                $message = "Course credit must be between 1 and 6.";
                $message_type = "error";
            } else {
                $created = $this->db->createCourse($this->connection, $course_id, $course_name, $course_code, (int)$credit, $day, $start_time, $end_time);
                if ($created) {
                    $message = "Course created successfully!";
                    $message_type = "success";
                } else {
                    $message = "Failed to create course. Course ID or Code may already exist.";
                    $message_type = "error";
                }
            }
        }

        return [
            'message' => $message,
            'message_type' => $message_type
        ];
    }

    // Displays unique enrolled student counts and valid active faculty
    public function fetchAllCoursesWithDetails() {
        $query = "SELECT c.*, 
                         COALESCE(u_fac.name, fa.faculty_username, 'Not Assigned') AS teacher_name, 
                         COUNT(DISTINCT se.student_username) AS enrolled_students
                  FROM courses c
                  LEFT JOIN faculty_assignments fa ON c.course_id = fa.course_id
                  LEFT JOIN users u_fac ON fa.faculty_username = u_fac.username AND u_fac.status = 'approved'
                  LEFT JOIN student_enrollments se ON c.course_id = se.course_id
                  LEFT JOIN users u_stu ON se.student_username = u_stu.username AND u_stu.status = 'approved'
                  GROUP BY c.course_id";

        $res = mysqli_query($this->connection, $query);

        if (!$res) {
            return $this->db->getCourses($this->connection);
        }

        return $res;
    }
}
?>
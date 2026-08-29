<?php
session_start();
include "../Model/db.php";

$database = new db();
$connection = $database->connection();

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = trim($_POST["course_id"] ?? "");
    $student_username = trim($_POST["student_username"] ?? "");

    if (empty($course_id) || empty($student_username)) {
        $message = "Please select both a course and a student.";
        $message_type = "error";
    } else {
        $enrolled = $database->enrollStudent($connection, $course_id, $student_username);
        if ($enrolled) {
            $message = "Student successfully enrolled in course!";
            $message_type = "success";
        } else {
            $message = "Failed to enroll student.";
            $message_type = "error";
        }
    }
}

$courses = $database->getCourses($connection);
$students = $database->getUsersByRole($connection, "student");
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Enrollment</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
body { background: #f7f0df; color: #000000; display: flex; flex-direction: column; min-height: 100vh; }
.header { background: #741f2b; color: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
.header h1 { font-size: 24px; }
.back { background: #fffdf7; color: #741f2b; height: 37px; padding: 0 15px; border-radius: 5px; text-decoration: none; font-weight: 500; display: flex; align-items: center; justify-content: center; }
.back:hover { background: #f3e8d2; }
.container { flex: 1; padding: 40px; display: flex; flex-direction: column; align-items: center; }
.box { width: 100%; max-width: 600px; background: #fffdf7; padding: 40px; border-radius: 10px; border: 1px solid #eadfc9; box-shadow: 0 5px 20px rgba(75, 20, 20, 0.12); }
.box h2 { color: #741f2b; text-align: center; font-size: 24px; margin-bottom: 8px; }
.subtitle { text-align: center; color: #333333; margin-bottom: 25px; font-size: 14px; }
.form-group { margin-bottom: 18px; }
label { display: block; margin-bottom: 6px; font-weight: bold; font-size: 14px; }
select { width: 100%; padding: 11px; border: 1px solid #aaa; border-radius: 5px; font-size: 14px; background: white; color: #000000; }
select:focus { outline: none; border-color: #741f2b; }
button { width: 100%; padding: 12px; background: #741f2b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; }
button:hover { background: #5c1721; }
.error-msg { color: #a00000; background: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: center; }
.success-msg { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: center; }
.footer { background: #741f2b; color: #fffdf7; text-align: center; padding: 15px 20px; font-size: 14px; margin-top: auto; }
</style>
</head>
<body>

<div class="header">
    <h1>Student Enrollment</h1>
    <a href="course_admin.php" class="back">Back to Dashboard</a>
</div>

<div class="container">
    <div class="box">
        <h2>Manage Student Enrollment</h2>
        <p class="subtitle">Enroll students into university courses.</p>

        <?php if (!empty($message)): ?>
            <div class="<?php echo ($message_type === 'success') ? 'success-msg' : 'error-msg'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="course_student.php" onsubmit="return validateForm()">
            <div class="form-group">
                <label>Select Course</label>
                <select name="course_id" id="course_id">
                    <option value="">Select a Course</option>
                    <?php while ($course = mysqli_fetch_assoc($courses)): ?>
                        <option value="<?php echo htmlspecialchars($course['course_id']); ?>">
                            <?php echo htmlspecialchars($course['course_code'] . " - " . $course['course_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Select Student</label>
                <select name="student_username" id="student_username">
                    <option value="">Select a Student</option>
                    <?php while ($student = mysqli_fetch_assoc($students)): ?>
                        <option value="<?php echo htmlspecialchars($student['username']); ?>">
                            <?php echo htmlspecialchars($student['name'] . " (" . $student['username'] . ")"); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit">Enroll Student</button>
        </form>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

<script>
function validateForm() {
    let course = document.getElementById("course_id").value;
    let student = document.getElementById("student_username").value;
    if (course === "" || student === "") {
        alert("Please select both course and student.");
        return false;
    }
    return true;
}
</script>

</body>
</html>
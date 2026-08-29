<?php
session_start();
include "../Model/db.php";

$database = new db();
$connection = $database->connection();

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = trim($_POST["course_id"] ?? "");
    $faculty_username = trim($_POST["faculty_username"] ?? "");

    if (empty($course_id) || empty($faculty_username)) {
        $message = "Please select both a course and a teacher.";
        $message_type = "error";
    } else {
        $assigned = $database->assignFaculty($connection, $course_id, $faculty_username);
        if ($assigned) {
            $message = "Faculty successfully assigned to course!";
            $message_type = "success";
        } else {
            $message = "Failed to assign faculty.";
            $message_type = "error";
        }
    }
}

$courses = $database->getCourses($connection);
$teachers = $database->getUsersByRole($connection, "teacher");
?>

<!DOCTYPE html>
<html>
<head>
<title>Faculty Assignment</title>
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
    <h1>Faculty Assignment</h1>
    <a href="course_admin.php" class="back">Back to Dashboard</a>
</div>

<div class="container">
    <div class="box">
        <h2>Assign Faculty</h2>
        <p class="subtitle">Assign teachers to university courses.</p>

        <?php if (!empty($message)): ?>
            <div class="<?php echo ($message_type === 'success') ? 'success-msg' : 'error-msg'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="course_faculty.php" onsubmit="return validateForm()">
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
                <label>Select Teacher</label>
                <select name="faculty_username" id="faculty_username">
                    <option value="">Select a Teacher</option>
                    <?php while ($teacher = mysqli_fetch_assoc($teachers)): ?>
                        <option value="<?php echo htmlspecialchars($teacher['username']); ?>">
                            <?php echo htmlspecialchars($teacher['name'] . " (" . $teacher['username'] . ")"); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit">Assign Faculty</button>
        </form>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

<script>
function validateForm() {
    let course = document.getElementById("course_id").value;
    let faculty = document.getElementById("faculty_username").value;
    if (course === "" || faculty === "") {
        alert("Please select both course and faculty.");
        return false;
    }
    return true;
}
</script>

</body>
</html>
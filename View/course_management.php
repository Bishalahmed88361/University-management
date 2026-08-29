<?php
include "../Controller/courseController.php";

$controller = new CourseController();
$result = $controller->handleCourseCreation();

$message = $result['message'];
$message_type = $result['message_type'];

$courses_res = $controller->fetchAllCoursesWithDetails();
?>

<!DOCTYPE html>
<html>
<head>
<title>Course Management</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
body { background: #f7f0df; color: #000000; display: flex; flex-direction: column; min-height: 100vh; }
.header { background: #741f2b; color: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
.header h1 { font-size: 24px; }
.back { background: #fffdf7; color: #741f2b; height: 37px; padding: 0 15px; border-radius: 5px; text-decoration: none; font-weight: 500; display: flex; align-items: center; justify-content: center; }
.back:hover { background: #f3e8d2; }
.header-actions { display: flex; gap: 10px; }
.container { flex: 1; display: flex; flex-direction: column; align-items: center; padding: 40px 20px; gap: 30px; }
.box { width: 100%; max-width: 600px; background: #fffdf7; padding: 30px 40px; border-radius: 10px; border: 1px solid #eadfc9; box-shadow: 0 5px 20px rgba(75, 20, 20, 0.12); }
.box h2 { color: #741f2b; text-align: center; font-size: 24px; margin-bottom: 8px; }
.subtitle { text-align: center; color: #333333; margin-bottom: 20px; font-size: 14px; }
.form-group { margin-bottom: 18px; }
label { display: block; margin-bottom: 6px; font-weight: bold; font-size: 14px; }
input[type="text"], select { width: 100%; padding: 11px; border: 1px solid #aaa; border-radius: 5px; font-size: 14px; background: white; color: #000000; }
input:focus, select:focus { outline: none; border-color: #741f2b; }

.validation-msg { font-size: 12px; font-weight: bold; margin-left: 8px; }

.time-inputs { display: flex; gap: 10px; }
.time-inputs input { flex: 1; }

.buttons { display: flex; gap: 10px; margin-top: 5px; }
button { width: 100%; padding: 12px; background: #741f2b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; }
button:hover { background: #5c1721; }
.error-msg { color: #a00000; background: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: center; }
.success-msg { color: #155724; background: #d4edda; border: 1px solid #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; text-align: center; }

.list-box { width: 100%; max-width: 600px; background: #fffdf7; padding: 30px; border-radius: 10px; border: 1px solid #eadfc9; box-shadow: 0 5px 20px rgba(75, 20, 20, 0.12); }
.list-box h3 { color: #741f2b; margin-bottom: 15px; font-size: 20px; text-align: center; }
.course-card { background: #ffffff; border: 1px solid #eadfc9; border-radius: 6px; padding: 15px; margin-bottom: 12px; }
.course-card p { font-size: 14px; color: #333333; line-height: 1.6; }
.course-card strong { color: #741f2b; }
.no-courses { text-align: center; color: #666; font-style: italic; }

.footer { background: #741f2b; color: #fffdf7; text-align: center; padding: 15px 20px; font-size: 14px; margin-top: auto; }
</style>

<script src="../JS/courseValidation.js"></script>
</head>
<body>

<div class="header">
    <h1>Course Management</h1>
    <div class="header-actions">
        <a href="course_upload.php" class="back">Upload Courses</a>
        <a href="course_admin.php" class="back">Back to Dashboard</a>
    </div>
</div>

<div class="container">
    <div class="box">
        <h2>Create New Course</h2>
        <p class="subtitle">Enter course information to add a new course.</p>

        <?php if (!empty($message)): ?>
            <div class="<?php echo ($message_type === 'success') ? 'success-msg' : 'error-msg'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form id="courseForm" method="POST" action="course_management.php" onsubmit="return validateCourseForm()">
            <div class="form-group">
                <label>Course ID <span id="idError" class="validation-msg"></span></label>
                <input type="text" name="course_id" placeholder="Enter course ID" onkeyup="checkUniqueness('course_id', this.value, 'idError')">
            </div>

            <div class="form-group">
                <label>Course Name</label>
                <input type="text" name="course_name" placeholder="Enter course name">
            </div>

            <div class="form-group">
                <label>Course Code <span id="codeError" class="validation-msg"></span></label>
                <input type="text" name="course_code" placeholder="Enter course code" onkeyup="checkUniqueness('course_code', this.value, 'codeError')">
            </div>

            <div class="form-group">
                <label>Course Credit</label>
                <select name="credit">
                    <option value="">Select Credit</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3" selected>3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>

            <div class="form-group">
                <label>Class Day</label>
                <select name="day">
                    <option value="">Select Day</option>
                    <option value="Sunday">Sunday</option>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Saturday">Saturday</option>
                </select>
            </div>

            <div class="form-group">
                <label>Class Schedule</label>
                <div class="time-inputs">
                    <input type="text" name="start_time" placeholder="Start (e.g. 8:00 AM)">
                    <input type="text" name="end_time" placeholder="End (e.g. 10:00 AM)">
                </div>
            </div>

            <div class="buttons">
                <button type="submit">Create Course</button>
                <button type="button" onclick="window.location.href='course_admin.php'">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Live Course List Display -->
    <div class="list-box">
        <h3>Existing Courses</h3>
        <?php if ($courses_res && mysqli_num_rows($courses_res) > 0): ?>
            <?php while ($course = mysqli_fetch_assoc($courses_res)): ?>
                <div class="course-card">
                    <p><strong>Course:</strong> <?php echo htmlspecialchars($course['course_code'] . " - " . $course['course_name']); ?></p>
                    <p><strong>ID:</strong> <?php echo htmlspecialchars($course['course_id']); ?> | <strong>Credit:</strong> <?php echo htmlspecialchars($course['credit']); ?></p>
                    <p><strong>Assigned Teacher:</strong> <?php echo htmlspecialchars($course['teacher_name'] ?? 'Not Assigned'); ?></p>
                    <p><strong>Enrolled Students:</strong> <?php echo htmlspecialchars($course['enrolled_students'] ?? 0); ?></p>
                    <p><strong>Schedule:</strong> <?php echo htmlspecialchars($course['day'] . " (" . $course['start_time'] . " - " . $course['end_time'] . ")"); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-courses">No existing courses found in the database.</p>
        <?php endif; ?>
    </div>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

</body>
</html>

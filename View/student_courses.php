<?php
include "../Controller/StudentCoursesValidation.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Courses - Student</title>
<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: #f7f0df;
    color: #000000;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.header {
    background: #741f2b;
    color: white;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header h1 { font-size: 24px; }

.back {
    background: #fffdf7;
    color: #741f2b;
    height: 37px;
    padding: 0 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
}

.back:hover { background: #f3e8d2; }

.container {
    flex: 1;
    padding: 40px;
}

.page-title { margin-bottom: 25px; }
.page-title h2 { margin-bottom: 8px; }
.page-title p { color: #333333; }

.course-line {
    padding: 18px 0;
    border-top: 1px solid #d8cdb8;
}

.course-line:last-of-type { border-bottom: 1px solid #d8cdb8; }
.course-line h3 { color: #741f2b; margin-bottom: 12px; }
.course-info { margin-bottom: 7px; font-size: 14px; }
.course-info:last-child { margin-bottom: 0; }
.label { font-weight: bold; }

.empty {
    background: #fffdf7;
    padding: 30px;
    border-radius: 10px;
    border: 1px solid #eadfc9;
    color: #555555;
}

.footer {
    background: #741f2b;
    color: #fffdf7;
    text-align: center;
    padding: 15px 20px;
    font-size: 14px;
    margin-top: auto;
}

@media (max-width: 700px) {
    .header { padding: 20px; }
    .container { padding: 25px; }
}
</style>
</head>
<body>

<div class="header">
    <h1>My Courses</h1>
    <a href="student.php" class="back">Back to Dashboard</a>
</div>

<div class="container">
    <div class="page-title">
        <h2>My Enrolled Courses</h2>
        <p>These are the courses currently included in your enrollment.</p>
    </div>

    <?php if (!empty($student_courses)): ?>
        <?php foreach ($student_courses as $course): ?>
            <div class="course-line">
                <h3>
                    <?php echo htmlspecialchars($course["course_code"] . " - " . $course["course_name"]); ?>
                </h3>

                <div class="course-info">
                    <span class="label">Course ID:</span>
                    <?php echo htmlspecialchars($course["course_id"]); ?>
                </div>

                <div class="course-info">
                    <span class="label">Course Name:</span>
                    <?php echo htmlspecialchars($course["course_name"]); ?>
                </div>

                <div class="course-info">
                    <span class="label">Course Code:</span>
                    <?php echo htmlspecialchars($course["course_code"]); ?>
                </div>

                <div class="course-info">
                    <span class="label">Credit:</span>
                    <?php echo htmlspecialchars($course["credit"]); ?>
                </div>

                <div class="course-info">
                    <span class="label">Class Day:</span>
                    <?php echo htmlspecialchars($course["day"]); ?>
                </div>

                <div class="course-info">
                    <span class="label">Class Time:</span>
                    <?php echo htmlspecialchars($course["start_time"] . " - " . $course["end_time"]); ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty">No courses are currently included in your enrollment.</div>
    <?php endif; ?>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

</body>
</html>

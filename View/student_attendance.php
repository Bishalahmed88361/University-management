<?php
include "../Controller/StudentAttendanceValidation.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Attendance</title>
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

.page-title { margin-bottom: 30px; }
.page-title h2 { margin-bottom: 8px; }
.page-title p { color: #333333; }

.selection-card {
    width: 600px;
    background: #fffdf7;
    padding: 30px;
    border-radius: 10px;
    border: 1px solid #eadfc9;
    box-shadow: 0 3px 10px rgba(75, 20, 20, 0.12);
}

.selection-card label {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    font-weight: 500;
}

.selection-card select {
    width: 100%;
    padding: 12px;
    border: 1px solid #d8cdb8;
    border-radius: 6px;
    background: white;
    color: #000000;
    font-size: 14px;
    margin-bottom: 20px;
}

.selection-card select:focus {
    outline: none;
    border-color: #741f2b;
}

.view-btn {
    background: #741f2b;
    color: white;
    border: none;
    padding: 11px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

.view-btn:hover { background: #5c1721; }

.empty {
    width: 600px;
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
    .selection-card, .empty { width: 100%; }
}
</style>
</head>
<body>

<div class="header">
    <h1>Attendance</h1>
    <a href="student.php" class="back">Back to Dashboard</a>
</div>

<div class="container">
    <div class="page-title">
        <h2>View Attendance</h2>
        <p>Select one of your enrolled courses to view its attendance records.</p>
    </div>

    <?php if (!empty($student_courses)): ?>
        <div class="selection-card">
            <form action="student_attendance_details.php" method="GET">
                <label>Select Course</label>

                <select name="course_id" required>
                    <option value="">Select Course</option>

                    <?php foreach ($student_courses as $course): ?>
                        <option value="<?php echo htmlspecialchars($course["course_id"]); ?>">
                            <?php echo htmlspecialchars($course["course_code"] . " - " . $course["course_name"]); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="view-btn">View Attendance</button>
            </form>
        </div>
    <?php else: ?>
        <div class="empty">No courses are currently included in your enrollment.</div>
    <?php endif; ?>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

</body>
</html>

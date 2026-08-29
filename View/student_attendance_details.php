<?php
include "../Controller/StudentAttendanceDetailsValidation.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Attendance Details</title>
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

.error-message {
    color: #a00000;
    background: #f8d7da;
    border: 1px solid #f5c6cb;
    padding: 12px;
    border-radius: 6px;
}

.course-info {
    background: #fffdf7;
    padding: 25px;
    border-radius: 10px;
    border: 1px solid #eadfc9;
    box-shadow: 0 3px 10px rgba(75, 20, 20, 0.12);
    margin-bottom: 25px;
}

.course-info h3 { color: #741f2b; margin-bottom: 20px; }

.course-details {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.detail p:first-child {
    color: #666666;
    font-size: 13px;
    margin-bottom: 6px;
}

.detail p:last-child { font-weight: 500; }

.summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.summary-card {
    background: #fffdf7;
    padding: 22px;
    border-radius: 10px;
    border: 1px solid #eadfc9;
    box-shadow: 0 3px 10px rgba(75, 20, 20, 0.12);
}

.summary-card h3 {
    color: #741f2b;
    margin-bottom: 10px;
    font-size: 15px;
}

.value { font-size: 27px; font-weight: bold; }

.records-title {
    color: #741f2b;
    margin-bottom: 12px;
}

.attendance-line {
    padding: 15px;
    border-top: 1px solid #d8cdb8;
    font-size: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.attendance-line:last-of-type { border-bottom: 1px solid #d8cdb8; }
.record-date { font-weight: 500; }
.status { font-weight: bold; text-transform: capitalize; }
.present { color: #155724; }
.absent { color: #a00000; }

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

@media (max-width: 800px) {
    .header { padding: 20px; }
    .container { padding: 25px; }
    .course-details, .summary { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<div class="header">
    <h1>Attendance Details</h1>
    <a href="student_attendance.php" class="back">Change Course</a>
</div>

<div class="container">
    <div class="page-title">
        <h2>Course Attendance</h2>
        <p>View your attendance records for the selected course.</p>
    </div>

    <?php if (!empty($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php else: ?>
        <div class="course-info">
            <h3>Course Information</h3>

            <div class="course-details">
                <div class="detail">
                    <p>Course ID</p>
                    <p><?php echo htmlspecialchars($course["course_id"]); ?></p>
                </div>

                <div class="detail">
                    <p>Course Name</p>
                    <p><?php echo htmlspecialchars($course["course_code"] . " - " . $course["course_name"]); ?></p>
                </div>

                <div class="detail">
                    <p>Teacher</p>
                    <p><?php echo htmlspecialchars($course["teacher_name"]); ?></p>
                </div>
            </div>
        </div>

        <div class="summary">
            <div class="summary-card">
                <h3>Total Classes</h3>
                <div class="value"><?php echo $total_classes; ?></div>
            </div>

            <div class="summary-card">
                <h3>Classes Present</h3>
                <div class="value"><?php echo $classes_present; ?></div>
            </div>

            <div class="summary-card">
                <h3>Attendance Percentage</h3>
                <div class="value"><?php echo number_format($attendance_percentage, 2); ?>%</div>
            </div>
        </div>

        <h3 class="records-title">Attendance Records</h3>

        <?php if (!empty($attendance_records)): ?>
            <?php foreach ($attendance_records as $record): ?>
                <div class="attendance-line">
                    <span class="record-date">
                        <?php echo htmlspecialchars(date("d M Y", strtotime($record["date"]))); ?>
                    </span>

                    <span class="status <?php echo htmlspecialchars($record["status"]); ?>">
                        <?php echo htmlspecialchars($record["status"]); ?>
                    </span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty">No attendance records are available for this course.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

</body>
</html>

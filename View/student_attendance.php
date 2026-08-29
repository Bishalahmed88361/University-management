<?php
include "../Controller/StudentAttendanceValidation.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student Attendance</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        html, body {
            height: 100%;
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

        .header h1 {
            font-size: 24px;
        }

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

        .back:hover {
            background: #f3e8d2;
        }

        .container {
            width: 750px;
            margin: 40px auto;
            background: #fffdf7;
            border: 1px solid #eadfc9;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(75, 20, 20, 0.12);
            padding: 40px;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h2 {
            margin-bottom: 8px;
            color: #741f2b;
            font-size: 22px;
        }

        .page-title p {
            color: #333333;
            font-size: 14px;
        }

        .select-group {
            margin-bottom: 25px;
        }

        .select-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #741f2b;
        }

        .select-group select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d8cdb8;
            border-radius: 6px;
            background: white;
            color: #000000;
            font-size: 14px;
            outline: none;
        }

        .select-group select:focus {
            border-color: #741f2b;
        }

        .text-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .text-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eadfc9;
            font-size: 14px;
        }

        .text-row:last-child {
            border-bottom: none;
        }

        .status-present {
            color: #155724;
            font-weight: bold;
        }

        .status-absent {
            color: #721c24;
            font-weight: bold;
        }

        .empty-msg {
            color: #555555;
            padding: 10px 0;
            font-size: 14px;
        }

        .footer {
            background: #741f2b;
            color: #fffdf7;
            text-align: center;
            padding: 15px 20px;
            font-size: 14px;
            margin-top: auto;
            width: 100%;
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
            <p>Select a course to instantly check your attendance status.</p>
        </div>

        <div class="select-group">

            <form method="GET" id="attendanceForm">

                <label>Select Course</label>

                <select name="course_id" onchange="document.getElementById('attendanceForm').submit()">

                    <option value="">-- Choose a Course --</option>

                    <?php

                    if (!empty($enrolled_courses)) {

                        foreach ($enrolled_courses as $course) {

                            $selected = "";

                            if ($selected_course == $course['course_id']) {
                                $selected = "selected";
                            }

                            echo "<option value='" . htmlspecialchars($course['course_id']) . "' $selected>";
                            echo htmlspecialchars($course['course_code'] . " - " . $course['course_name']);
                            echo "</option>";
                        }
                    }

                    ?>

                </select>

            </form>

        </div>

        <div class="text-list">

            <?php

            if ($selected_course != "") {

                if (!empty($attendance_records)) {

                    foreach ($attendance_records as $row)
                    {
                        echo "<div class='text-row'>";

                        echo "<span>";
                        echo "<strong>Date:</strong> ";
                        echo htmlspecialchars($row['date']);
                        echo "</span>";

                        echo "<span class='status-" . htmlspecialchars($row['status']) . "'>";
                        echo "<strong>Status:</strong> ";
                        echo htmlspecialchars(ucfirst($row['status']));
                        echo "</span>";

                        echo "</div>";
                    }

                } else
                {
                    echo "<p class='empty-msg'>";
                    echo "No attendance records found for this course.";
                    echo "</p>";
                }

            } else
            {
                echo "<p class='empty-msg'>";
                echo "Please select a course above to view your attendance.";
                echo "</p>";
            }

            ?>

        </div>

    </div>

    <div class="footer">
        <p>
            &copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.
        </p>
    </div>

</body>

</html>

<?php

include "../Controller/TeacherAttendanceValidation.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Attendance - Teacher</title>

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
            padding: 40px;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h2 {
            margin-bottom: 8px;
        }

        .page-title p {
            color: #333333;
        }

        .controls {
            background: #fffdf7;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #eadfc9;
            box-shadow: 0 3px 10px rgba(75, 20, 20, 0.12);
            margin-bottom: 25px;
        }

        .control-group {
            margin-bottom: 15px;
        }

        .control-group:last-child {
            margin-bottom: 0;
        }

        .control-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
        }

        .control-group select,
        .control-group input {
            width: 300px;
            padding: 11px;
            border: 1px solid #d8cdb8;
            border-radius: 6px;
            background: white;
        }

        .message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .student-line {
            padding: 15px 0;
            border-bottom: 1px solid #d8cdb8;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .student-line:first-child {
            border-top: 1px solid #d8cdb8;
        }

        .student-info h3 {
            color: #741f2b;
            margin-bottom: 6px;
        }

        .student-info p {
            font-size: 14px;
        }

        .attendance-options {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .attendance-options label {
            font-size: 14px;
            cursor: pointer;
        }

        .save-btn {
            margin-top: 20px;
            background: #741f2b;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .save-btn:hover {
            background: #5c1721;
        }

        .empty {
            background: #fffdf7;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #eadfc9;
            color: #555555;
        }

        @media (max-width: 700px) {

            .container {
                padding: 25px;
            }

            .control-group select,
            .control-group input {
                width: 100%;
            }

            .student-line {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

        }
    </style>

</head>

<body>

    <div class="header">

        <h1>
            Attendance
        </h1>

        <a href="teacher.php" class="back">
            Back to Dashboard
        </a>

    </div>


    <div class="container">

        <div class="page-title">

            <h2>
                Student Attendance
            </h2>

            <p>
                Record attendance for students enrolled in your courses.
            </p>

        </div>


        <?php if (!empty($message)): ?>

            <div class="message">

                <?php
                echo htmlspecialchars($message);
                ?>

            </div>

        <?php endif; ?>


        <?php if (!empty($error)): ?>

            <div class="message">

                <?php
                echo htmlspecialchars($error);
                ?>

            </div>

        <?php endif; ?>


        <div class="controls">

            <form method="GET">

                <div class="control-group">

                    <label>
                        Select Course
                    </label>

                    <select name="course_id" onchange="this.form.submit()" required>

                        <option value="">
                            Select Course
                        </option>

                        <?php foreach ($teacher_courses as $course): ?>

                            <option value="<?php
                            echo htmlspecialchars(
                                $course["course_id"]
                            );
                            ?>" <?php
                            if (
                                $selected_course ===
                                $course["course_id"]
                            ) {
                                echo "selected";
                            }
                            ?>>

                                <?php
                                echo htmlspecialchars(
                                    $course["course_code"]
                                    . " - "
                                    . $course["course_name"]
                                );
                                ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </form>


            <?php if (!empty($selected_course)): ?>

                <form method="GET">

                    <input type="hidden" name="course_id" value="<?php
                    echo htmlspecialchars(
                        $selected_course
                    );
                    ?>">

                    <div class="control-group">

                        <label>
                            Select Date
                        </label>

                        <input type="date" name="date" value="<?php
                        echo htmlspecialchars(
                            $selected_date
                        );
                        ?>" onchange="this.form.submit()" required>

                    </div>

                </form>

            <?php endif; ?>

        </div>


        <?php if (
            $selected_course !== "" &&
            !empty($students)
        ): ?>

            <form method="POST">

                <input type="hidden" name="course_id" value="<?php
                echo htmlspecialchars(
                    $selected_course
                );
                ?>">

                <input type="hidden" name="date" value="<?php
                echo htmlspecialchars(
                    $selected_date
                );
                ?>">


                <?php foreach ($students as $student): ?>

                    <?php

                    $student_username =
                        $student["username"];

                    $current_status = "absent";

                    if (
                        isset(
                        $attendance[
                            $student_username
                        ]
                    )
                    ) {
                        $current_status =
                            $attendance[
                                $student_username
                            ]["status"];
                    }

                    ?>


                    <div class="student-line">

                        <div class="student-info">

                            <h3>

                                <?php
                                echo htmlspecialchars(
                                    $student["name"]
                                );
                                ?>

                            </h3>

                            <p>

                                Student ID:

                                <?php
                                echo htmlspecialchars(
                                    $student_username
                                );
                                ?>

                            </p>

                        </div>


                        <div class="attendance-options">

                            <label>

                                <input type="radio" name="attendance[<?php
                                echo htmlspecialchars(
                                    $student_username
                                );
                                ?>]" value="present" <?php
                                if (
                                    $current_status ===
                                    "present"
                                ) {
                                    echo "checked";
                                }
                                ?>
                                    required>

                                Present

                            </label>


                            <label>

                                <input type="radio" name="attendance[<?php
                                echo htmlspecialchars(
                                    $student_username
                                );
                                ?>]" value="absent" <?php
                                if (
                                    $current_status ===
                                    "absent"
                                ) {
                                    echo "checked";
                                }
                                ?>>

                                Absent

                            </label>

                        </div>

                    </div>

                <?php endforeach; ?>


                <button type="submit" class="save-btn">
                    Save Attendance
                </button>

            </form>


        <?php elseif ($selected_course !== ""): ?>

            <div class="empty">
                No students are enrolled in this course.
            </div>

        <?php endif; ?>


    </div>

</body>

</html>
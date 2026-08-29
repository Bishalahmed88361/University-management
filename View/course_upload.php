<?php
include "../Controller/course_management_validation.php";
?>

<!DOCTYPE html>
<html>
<head>

<title>Upload Courses</title>

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
    display: flex;
    align-items: center;
}

.container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}

.box {
    width: 560px;
    background: #fffdf7;
    padding: 40px;
    border-radius: 10px;
    border: 1px solid #eadfc9;
    box-shadow: 0 5px 20px rgba(75, 20, 20, 0.12);
}

.box h2 {
    color: #741f2b;
    text-align: center;
    margin-bottom: 10px;
}

.subtitle,
.format {
    color: #333333;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 22px;
}

label {
    display: block;
    margin-bottom: 7px;
    font-weight: bold;
}

input[type="file"] {
    width: 100%;
    padding: 11px;
    border: 1px solid #aaa;
    border-radius: 5px;
    background: white;
    margin-bottom: 18px;
}

button {
    width: 100%;
    padding: 12px;
    background: #741f2b;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
}

button:hover {
    background: #5c1721;
}

.success {
    color: green;
    font-size: 13px;
    margin-bottom: 10px;
}

.error {
    color: red;
    font-size: 12px;
    margin-bottom: 10px;
}

.footer {
    background: #741f2b;
    color: #fffdf7;
    text-align: center;
    padding: 15px 20px;
    font-size: 14px;
    margin-top: auto;
}

</style>

</head>

<body>

<div class="header">

    <h1>Upload Courses</h1>

    <a href="course_management.php" class="back">
        Back to Course Management
    </a>

</div>

<div class="container">

    <div class="box">

        <h2>Upload Course</h2>

        <p class="subtitle">
            Supported file formats: .txt, .csv.
        </p>

        <p class="format">
            Text Format:<br>
            course_id, course_name, course_code, credit, day, start_time, end_time
        </p>

        <p class="success"><?php echo htmlspecialchars($upload_message); ?></p>
        <p class="error"><?php echo htmlspecialchars($upload_error); ?></p>

        <form method="post" action="" enctype="multipart/form-data">

            <label>Select File</label>

            <input
                type="file"
                name="course_file"
                accept=".txt,.csv"
                required
            >

            <button type="submit">
                Upload Courses
            </button>

        </form>

    </div>

</div>

<div class="footer">
    <p>&copy; <?php echo date("Y"); ?> University Portal. All Rights Reserved.</p>
</div>

</body>
</html>

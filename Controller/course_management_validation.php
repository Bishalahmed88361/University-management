<?php
include "../Model/db.php";

$upload_message = "";
$upload_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["course_file"]))
{
    $path = "../Uploads/courses_" . date("Y-m-d_H-i-s") . ".txt";

    if (move_uploaded_file($_FILES["course_file"]["tmp_name"], $path))
    {
        $lines = file($path);
        $database = new db();
        $connection = $database->connection();
        $added = 0;

        for ($i = 0; $i < count($lines); $i++)
        {
            $line = trim($lines[$i]);

            if ($line != "" && $line[0] != "#")
            {
                $data = array_map("trim", explode(",", $line));

                if (count($data) == 7 && strtolower($data[0]) != "course_id")
                {
                    try
                    {
                        $result = $database->createCourse(
                            $connection,
                            $data[0],
                            $data[1],
                            $data[2],
                            $data[3],
                            $data[4],
                            date("H:i:s", strtotime($data[5])),
                            date("H:i:s", strtotime($data[6]))
                        );
                    }
                    catch (mysqli_sql_exception $exception)
                    {
                        $result = false;
                    }

                    if ($result)
                    {
                        $added++;
                    }
                }
                else
                {
                    $upload_error = "Some lines did not contain 7 values";
                }
            }
        }

        $upload_message = $added . " courses uploaded successfully";
    }
    else
    {
        $upload_error = "File upload failed";
    }
}
?>

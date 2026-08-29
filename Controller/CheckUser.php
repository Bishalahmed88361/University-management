<?php
include "../Model/db.php";

$username = $_POST["username"] ?? "";

if (!$username) {
    echo "Username Required";
} else { 
    $database = new db();
    $connection = $database->connection();
    $result = $database->CheckUser($connection, "users", $username);

    if ($result !== false && $result->num_rows > 0) {
        echo "<span style='color:red;'>UserName Already Taken</span>";
    } else {
        echo "<span style='color:green;'>User Name Available</span>";
    }
}
?>
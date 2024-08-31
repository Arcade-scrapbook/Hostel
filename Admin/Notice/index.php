<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "admin") {
        http_response_code(403);
        exit();
    }
} else {
    http_response_code(403);
    header('Location: https://gpphostels.rf.gd');
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['search_criteria'])) {
    // Database connection details
  $servername = "sql302.infinityfree.com";
  $username = "if0_36375033";
  $password = "TC6VYgEIdbFI95H";
  $dbname = "if0_36375033_hostel";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $date = $_POST['date'];
    $type = $_POST['search_criteria'];
    $wing = $_POST['wing'];
    $notice = $_POST['notice'];
    $name = $_SESSION['fname'] . ' ' . $_SESSION['lname'];
    $c_date = date("Y-m-d");

    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO Notice (date, type, name, note,  wing) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param("ssss", $c_date, $type, $name, $note, $wing);

    // Set parameters and execute
    if ($type === 'Important Meeting' || $type === 'General Meeting') {
        $time = $_POST['time'];
        $topic = $_POST['topic'];
        $note = "$type on <span class='time'>$date</span> at $time for $wing on topic $topic: $notice";
    } else {
        $note = "$type notice: $notice";
    }

    // Outputting to console
    echo '<script>console.log("' . addslashes($note) . '");</script>';

    // Execute the statement
    if (!$stmt->execute()) {
        echo '<script>console.error("Error executing query: ' . addslashes($stmt->error) . '");</script>';
    } else {
        echo '<script>alert("Notice recorded successfully as: ' . addslashes($note) . '");</script>';
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<link rel="stylesheet" href="style.css">
<script>
function showDateTimeFields() {
    var selectBox = document.getElementById("search_criteria");
    var selectedValue = selectBox.value;
    var dateField = document.getElementById("date_field");
    var timeField = document.getElementById("time_field");
    var topicField = document.getElementById("topic_field");

    if (selectedValue === "Important Meeting" || selectedValue === "General Meeting") {
        dateField.style.display = "flex";
        timeField.style.display = "flex";
        topicField.style.display = "flex";
    } else {
        dateField.style.display = "none";
        timeField.style.display = "none";
        topicField.style.display = "none";
    }
}
</script>
<style>
        #nav-icon1,
        #nav-icon2,
        #nav-icon3,
        #nav-icon4 {
            width: 60px;
            height: 45px;
            position: relative;
            margin: 50px auto;
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            -webkit-transition: .5s ease-in-out;
            -moz-transition: .5s ease-in-out;
            -o-transition: .5s ease-in-out;
            transition: .5s ease-in-out;
            cursor: pointer;
        }

        #nav-icon1 span,
        #nav-icon3 span,
        #nav-icon4 span {
            display: block;
            position: absolute;
            height: 9px;
            width: 100%;
            background: #d3531a;
            border-radius: 9px;
            opacity: 1;
            left: 0;
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            -webkit-transition: .25s ease-in-out;
            -moz-transition: .25s ease-in-out;
            -o-transition: .25s ease-in-out;
            transition: .25s ease-in-out;
        }


        /* Icon 2 */

        #nav-icon2 {
            position: fixed;
            left: 10px;
        }

        #nav-icon2 span {
            display: block;
            position: absolute;
            height: 7px;
            width: 50%;
            background: #c7c7c7;
            opacity: 1;
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
            -webkit-transition: .25s ease-in-out;
            -moz-transition: .25s ease-in-out;
            -o-transition: .25s ease-in-out;
            transition: .25s ease-in-out;

        }
</style>
</head>
</html>

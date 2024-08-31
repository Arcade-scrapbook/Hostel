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

//$name = $_SESSION['name'];
$name="Computer";
$message = '';
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectOption = $_POST['select-option'];
    $fineAmount = $_POST['fine-amount'];
    $reason = $_POST['reason'];

    // Database credentials
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

    if ($selectOption == "enrollment") {
        $enrollmentNumbers = explode(",", $_POST['enrollment']);
        $enrollmentList = [];
        foreach ($enrollmentNumbers as $enrollment) {
            $enrollment = trim($enrollment);

            // Verify if the enrollment number exists
            $sql = "SELECT COUNT(*) as count FROM user WHERE user_id = '$enrollment'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();

            if ($row['count'] > 0) {
                $sql = "INSERT INTO transaction (enrollment_number, amount, reason, imposed_by, type) 
                        VALUES ('$enrollment', '$fineAmount', '$reason', '$name', 'Fine')";
                if ($conn->query($sql) === TRUE) {
                    $enrollmentList[] = $enrollment;
                }
            } else {
                $errorMessages[] = "Enrollment number $enrollment does not exist in the database.";
            }
        }
        $message = 'Fines imposed on enrollment numbers: ' . implode(", ", $enrollmentList) . '.';
    } elseif ($selectOption == "wing") {
        $wing = $_POST['wing'];
        $wingCondition = $wing == "all" ? "" : "WHERE wing = '$wing'";
        $sql = "SELECT user_id FROM user $wingCondition";
        $result = $conn->query($sql);
        $userList = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $enrollment = $row['user_id'];
                $sql = "INSERT INTO transaction (enrollment_number, amount, reason, imposed_by, type) 
                        VALUES ('$enrollment', '$fineAmount', '$reason', '$name', 'debit')";
                if ($conn->query($sql) === TRUE) {
                    $userList[] = $enrollment;
                }
            }
        }
        $message = $wing == "all" ? 'Fines imposed on all users.' : 'Fines imposed on users in ' . $wing . ' wing: ' . implode(", ", $userList) . '.';
    } elseif ($selectOption == "year") {
        $wing = $_POST['wing'];
        $year = $_POST['year'];
        $yearCondition = "";

        if ($year == "first") {
            $yearCondition = "AND divi LIKE '%1'";
        } elseif ($year == "second") {
            $yearCondition = "AND divi LIKE '%2'";
        } elseif ($year == "third") {
            $yearCondition = "AND divi LIKE '%3'";
        }

        $wingCondition = $wing == "all" ? "" : "AND wing = '$wing'";
        $sql = "SELECT user_id FROM user WHERE 1=1 $yearCondition $wingCondition";
        $result = $conn->query($sql);
        $userList = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $enrollment = $row['user_id'];
                $sql = "INSERT INTO transaction (enrollment_number, amount, reason, imposed_by, type) 
                        VALUES ('$enrollment', '$fineAmount', '$reason', '$name', 'debit')";
                if ($conn->query($sql) === TRUE) {
                    $userList[] = $enrollment;
                }
            }
        }
        $message = $wing == "all" ? 'Fines imposed on ' . $year . ' year students.' : 'Fines imposed on ' . $year . ' year students in ' . $wing . ' wing: ' . implode(", ", $userList) . '.';
    }

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
    <style>
        #year-section .field {
            flex-direction: column;
        }
    </style>
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
</style>
</head>
</html>

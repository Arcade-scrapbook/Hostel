<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "security_head") {
        http_response_code(403);
        exit();
    }
} else {
    http_response_code(403);
    header('Location: https://gpphostels.rf.gd');
    exit();
}

$servername = "sql302.infinityfree.com";
$username = "if0_36375033";
$password = "TC6VYgEIdbFI95H";
$dbname = "if0_36375033_hostel";


$string = "";
$role = "security";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $first = $_POST["first"];
    $last = $_POST["last"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    $first = filter_var($first, FILTER_SANITIZE_STRING);
    $last = filter_var($last, FILTER_SANITIZE_STRING);
    $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    $conn->begin_transaction();

    try {
        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
            $fileType = $_FILES["photo"]["type"];
            $fileContent = file_get_contents($_FILES["photo"]["tmp_name"]);
            $encodedContent = "data:" . $fileType . ";base64," . base64_encode($fileContent);

            $stmt = $conn->prepare("INSERT INTO user (first, last, phone_no, password, role, user_id, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssissss", $first, $last, $phone, $password, $role, $phone, $encodedContent);

            if (!$stmt->execute()) {
                throw new Exception("Error: " . $stmt->error);
            }

            $conn->commit();
            $string = "<p style='color: green;'>Record and image added successfully!</p>";
        } else {
            throw new Exception("Error uploading file.");
        }
    } catch (Exception $e) {

        $conn->rollback();
        $string = "<p style='color: red;'>" . $e->getMessage() . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Security Data</title>
    <link rel="stylesheet" href="style.css">
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

        #nav-icon2 span:nth-child(even) {
            left: 50%;
            border-radius: 0 9px 9px 0;
        }

        #nav-icon2 span:nth-child(odd) {
            left: 0px;
            border-radius: 9px 0 0 9px;
        }
</style>
</head>
</html>

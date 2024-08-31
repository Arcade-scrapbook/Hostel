<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "office") {
        http_response_code(403);
        exit();
    }
} else {
    http_response_code(403);
    header('Location: https://gpphostels.rf.gd');
    exit();
}

// Database connection settings (add your actual credentials)
$servername = "sql302.infinityfree.com";
$username = "if0_36375033";
$password = "TC6VYgEIdbFI95H";
$dbname = "if0_36375033_hostel";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize inputs
    $first = $conn->real_escape_string($_POST["first"]);
    $middle = $conn->real_escape_string($_POST["middle"]);
    $last = $conn->real_escape_string($_POST["last"]);
    $birthdate = $conn->real_escape_string($_POST["birthdate"]);
    $parents_phone = filter_var($_POST["parents_phone"], FILTER_SANITIZE_NUMBER_INT);
    $phone_no = filter_var($_POST["phone_no"], FILTER_SANITIZE_NUMBER_INT);
    $address = $conn->real_escape_string($_POST["address"]);
    $blood = $conn->real_escape_string($_POST["blood"]);
    $percentage = $conn->real_escape_string($_POST["percentage"]);
    $dept = $conn->real_escape_string($_POST["dept"]);
    $divi = $conn->real_escape_string($_POST["divi"]);
    $wing = $conn->real_escape_string($_POST["wing"]);
    $room = $conn->real_escape_string($_POST["room"]);
    $application_id = $conn->real_escape_string($_POST["application_id"]);
    $caste = $conn->real_escape_string($_POST["caste"]);
    $password_value = $conn->real_escape_string($_POST["password"]);
    $enrol = $conn->real_escape_string($_POST["enrolment"]);
    $role = "student";

    // Begin transaction
    $conn->begin_transaction();

    try {
        if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
            $fileType = $_FILES["photo"]["type"];
            $fileContent = file_get_contents($_FILES["photo"]["tmp_name"]);
            $encodedContent = "data:" . $fileType . ";base64," . base64_encode($fileContent);

            // Prepare and execute the SQL statement for the user
            $stmt = $conn->prepare("INSERT INTO user (user_id, first, middle, last, birthdate, phone_no, parents_phone, address, blood, percentage, dept, divi, wing, room, application_id, role, caste, password, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssssssssssssss", $enrol, $first, $middle, $last, $birthdate, $phone_no, $parents_phone, $address, $blood, $percentage, $dept, $divi, $wing, $room, $application_id, $role, $caste, $password_value, $encodedContent);

            if (!$stmt->execute()) {
                throw new Exception("Error: " . $stmt->error);
            }

            // Determine the amount based on caste
            $caste_lower = strtolower($caste);
            $amount = ($caste_lower == 'open') ? '1100.00' : '550.00';

            // Prepare and execute the SQL statement for the transaction
            $reason = 'Hostel Fees';
            $imposed_by = 'Admin';
            $type = 'Imposed';
            $status = 'unpaid';
            $imposed_date = date('Y-m-d H:i:s');

            $stmt2 = $conn->prepare("INSERT INTO transaction (enrollment_number, amount, reason, imposed_by, type, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt2->bind_param("ssssss", $enrol, $amount, $reason, $imposed_by, $type, $status);

            if (!$stmt2->execute()) {
                throw new Exception("Error: " . $stmt2->error);
            }

            // Commit the transaction
            $conn->commit();
            $message = "<p style='color: green;'>Record and image added successfully!</p>";
        } else {
            throw new Exception("Error uploading file.");
        }
    } catch (Exception $e) {
        // Rollback the transaction
        $conn->rollback();
        $message = "<p style='color: red;'>" . $e->getMessage() . "</p>";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Data</title>
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

</style>
</head>
</html>

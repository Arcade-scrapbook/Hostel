<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$host = "sql302.infinityfree.com";
$username = "if0_36375033";
$password = "TC6VYgEIdbFI95H";
$database = "if0_36375033_hostel";

$connection = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to get the user's IP address
function getIpAddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Get the IP address
$ip_address = getIpAddress();
$date_today = date("Y-m-d");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['userid'];
    $password = $_POST['password'];

    // Check if the IP address is blocked
    $check_attempts_query = "SELECT attempt_count, last_attempt_date, blocked FROM login_attempts WHERE ip_address = ?";
    $check_stmt = mysqli_prepare($connection, $check_attempts_query);
    mysqli_stmt_bind_param($check_stmt, "s", $ip_address);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $attempt_data = mysqli_fetch_assoc($check_result);
        if ($attempt_data['blocked']) {
            die("IP address <strong>$ip_address</strong> is blocked. Please contact admin to unblock.");
        }
        
        if ($attempt_data['last_attempt_date'] == $date_today && $attempt_data['attempt_count'] >= 5) {
            // Block the IP address
            $block_query = "UPDATE login_attempts SET blocked = TRUE WHERE ip_address = ?";
            $block_stmt = mysqli_prepare($connection, $block_query);
            mysqli_stmt_bind_param($block_stmt, "s", $ip_address);
            mysqli_stmt_execute($block_stmt);

            die("IP address <strong>$ip_address</strong> is blocked. Please contact admin to unblock.");
        }
    }

    // Prepare the query to prevent SQL injection
    $query = "SELECT * FROM user WHERE user_id=? AND password=?";
    $stmt = mysqli_prepare($connection, $query);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, "is", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $usern = $user['user_id'];
        $role = $user['role'];
        $fname = $user['first'];
        $mname = $user['middle'];
        $lname = $user['last'];
        $phone = $user['phone_no'];
        $phone_p = $user['parents_phone'];
        $add = $user['address'];
        $blood = $user['blood'];
        $dept = $user['dept'];
        $div = $user['divi'];
        $wing = $user['wing'];
        $room = $user['room'];
        $birthdate = $user['birthdate'];

        $_SESSION['username'] = $usern;
        $_SESSION['role'] = $role;
        $_SESSION['fname'] = $fname;
        $_SESSION['mname'] = $mname;
        $_SESSION['lname'] = $lname;
        $_SESSION['phone'] = $phone;
        $_SESSION['phone_p'] = $phone_p;
        $_SESSION['address'] = $add;
        $_SESSION['blood'] = $blood;
        $_SESSION['dept'] = $dept;
        $_SESSION['div'] = $div;
        $_SESSION['wing'] = $wing;
        $_SESSION['room'] = $room;
        $_SESSION['birthdate'] = $birthdate;
?>

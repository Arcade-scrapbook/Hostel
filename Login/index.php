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

        // Reset login attempts on successful login
        $reset_attempts_query = "DELETE FROM login_attempts WHERE ip_address = ?";
        $reset_stmt = mysqli_prepare($connection, $reset_attempts_query);
        mysqli_stmt_bind_param($reset_stmt, "s", $ip_address);
        mysqli_stmt_execute($reset_stmt);

        switch ($role) {
            case 'admin':
                header("Location: ../Admin");
                exit;
            case 'student':
                header("Location: ../Student");
                exit;
            case 'office':
                header("Location: ../Office");
                exit;
            case 'security_head':
                header("Location: ../Security/Head");
                exit;
            case 'security':
                header("Location: ../Security");
                exit;
            case 'unblock':
                header("Location: ../Unblock");
                exit;
            default:
                echo "unknown role"; // Redirect to login page if role is unknown
                exit;
        }
    } else {
        echo "Invalid username or password";

        // Update login attempts on failed login
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            if ($attempt_data['last_attempt_date'] == $date_today) {
                $remaining_attempts = 4 - $attempt_data['attempt_count'];
                $update_attempts_query = "UPDATE login_attempts SET attempt_count = attempt_count + 1 WHERE ip_address = ?";
                $update_stmt = mysqli_prepare($connection, $update_attempts_query);
                mysqli_stmt_bind_param($update_stmt, "s", $ip_address);
                mysqli_stmt_execute($update_stmt);
                echo "<br>Remaining attempts: $remaining_attempts";
            } else {
                $reset_attempts_query = "UPDATE login_attempts SET attempt_count = 1, last_attempt_date = ? WHERE ip_address = ?";
                $reset_stmt = mysqli_prepare($connection, $reset_attempts_query);
                mysqli_stmt_bind_param($reset_stmt, "ss", $date_today, $ip_address);
                mysqli_stmt_execute($reset_stmt);
                echo "<br>Remaining attempts: 4";
            }
        } else {
            $insert_attempts_query = "INSERT INTO login_attempts (ip_address, attempt_count, last_attempt_date) VALUES (?, 1, ?)";
            $insert_stmt = mysqli_prepare($connection, $insert_attempts_query);
            mysqli_stmt_bind_param($insert_stmt, "ss", $ip_address, $date_today);
            mysqli_stmt_execute($insert_stmt);
            echo "<br>Remaining attempts: 4";
        }
    }
}
?>

<!doctype html public "-//w3c//dtd html 3.2//en">
<html>

<head>
    <link rel="icon" type="image/png" href="/favicon.png" />
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <script src='https://kit.fontawesome.com/a16a49be46.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form class='form rotate' action='' method=post>
        <!-- Added 'rotate' class here -->
        <h1>Welcome Back</h1>
        <p>Enter your credentials to continue.</p>

        <div class='input-wrapper'>
            <input type='text' name='userid' placeholder='Enter your username' />
            <i class='fa-solid fa-user'></i>
        </div>

        <div class='input-wrapper'>
            <input type='password' placeholder='Enter your password' id='pass' name='password' />
            <i class='fa-solid fa-lock' onclick='hide()' id='lock'></i>
        </div>

        <div class='button-wrapper'>
            <button type='submit'>
                Sign In&nbsp;
                <i class='fa-solid fa-arrow-right-to-bracket'></i>
            </button>
        </div>
    </form>
    <br>
    <br>
    <footer>
        <div>
            <span>Created By <a id='c' href=''>Tejas Patil</a> | <span class='far fa-copyright' aria-hidden='true'></span> 2024 All rights
                reserved.</span>
        </div>
    </footer>

    <script>
        function hide() {
            var x = document.getElementById('pass');
            var y = document.getElementById('lock');
            if (x.type === 'password') {
                x.type = 'text';
                y.className = 'fa-solid fa-unlock-keyhole';
            } else {
                x.type = 'password';
                y.className = 'fa-solid fa-lock';
            }
        }
    </script>
</body>

</html>

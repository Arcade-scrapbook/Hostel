<?php
session_start();

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

$host = "sql302.infinityfree.com";
$username = "if0_36375033";
$password = "TC6VYgEIdbFI95H";
$database = "if0_36375033_hostel";
$conn = new mysqli($host, $username, $password, $database);

$string = "";
$c = 1;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$wing = [
    "A", "A", "A", "B", "B", "B",
    "A", "A", "A", "B", "B", "B",
    "A", "A", "A", "B", "B", "B",
    "A", "A", "A", "B", "B", "B",
    "A", "A", "A", "B", "B", "B",
    "A", "A", "A", "B", "B", "B",
    "A", "A", "A", "B", "B", "B"
];

$day = [
    "Monday", "Monday", "Monday", "Monday", "Monday", "Monday",
    "Tuesday", "Tuesday", "Tuesday", "Tuesday", "Tuesday", "Tuesday",
    "Wednesday", "Wednesday", "Wednesday", "Wednesday", "Wednesday", "Wednesday",
    "Thursday", "Thursday", "Thursday", "Thursday", "Thursday", "Thursday",
    "Friday", "Friday", "Friday", "Friday", "Friday", "Friday",
    "Saturday", "Saturday", "Saturday", "Saturday", "Saturday", "Saturday",
    "Sunday", "Sunday", "Sunday", "Sunday", "Sunday", "Sunday"
];

$start_time = [
    "07:00", "14:00", "22:00", "07:00", "14:00", "22:00",
    "07:00", "14:00", "22:00", "07:00", "14:00", "22:00",
    "07:00", "14:00", "22:00", "07:00", "14:00", "22:00",
    "07:00", "14:00", "22:00", "07:00", "14:00", "22:00",
    "07:00", "14:00", "22:00", "07:00", "14:00", "22:00",
    "07:00", "14:00", "22:00", "07:00", "14:00", "22:00",
    "07:00", "14:00", "22:00", "07:00", "14:00", "22:00"
];

$end_time = [
    "14:00", "22:00", "07:00", "14:00", "22:00", "07:00",
    "14:00", "22:00", "07:00", "14:00", "22:00", "07:00",
    "14:00", "22:00", "07:00", "14:00", "22:00", "07:00",
    "14:00", "22:00", "07:00", "14:00", "22:00", "07:00",
    "14:00", "22:00", "07:00", "14:00", "22:00", "07:00",
    "14:00", "22:00", "07:00", "14:00", "22:00", "07:00",
    "14:00", "22:00", "07:00", "14:00", "22:00", "07:00"
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $c = 1;

    $string = "";

    for ($i = 0; $i < 100; $i++) {
        if (isset($_POST["selection" . $i])) {
            $selection = $_POST["selection" . $i];
            if (strpos($selection, "Null") === false) {

                $current_wing = $wing[$i % count($wing)];
                $current_day = $day[$i % count($day)];
                $current_start_time = $start_time[$i % count($start_time)];
                $current_end_time = $end_time[$i % count($end_time)];

                $stmt = $conn->prepare("SELECT CONCAT(first, ' ', last) AS name, first, last, phone_no, role, image FROM user WHERE TRIM(CONCAT(first, ' ', last)) = ? AND role = 'security'");
                $stmt->bind_param("s", $selection);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $name = htmlspecialchars($row["name"]);
                            $phone = $row["phone_no"];

                            $currentDate = new DateTime();
                            $next = $currentDate->modify(
                                "next " . $current_day
                            );
                            $nextDateString = $next->format("Y-m-d");

                            $check_stmt = $conn->prepare(
                                "SELECT COUNT(*) FROM schedule WHERE date = ? AND wing = ? AND day = ? AND start_time = ? AND end_time = ?"
                            );
                            $check_stmt->bind_param(
                                "sssss",
                                $nextDateString,
                                $current_wing,
                                $current_day,
                                $current_start_time,
                                $current_end_time
                            );
                            $check_stmt->execute();
                            $check_stmt->bind_result($count);
                            $check_stmt->fetch();
                            $check_stmt->close();

                            if ($count > 0) {

                                $update_stmt = $conn->prepare(
                                    "UPDATE schedule SET name = ?, phone = ? WHERE date = ? AND wing = ? AND day = ? AND start_time = ? AND end_time = ?"
                                );
                                $update_stmt->bind_param(
                                    "sssssss",
                                    $name,
                                    $phone,
                                    $nextDateString,
                                    $current_wing,
                                    $current_day,
                                    $current_start_time,
                                    $current_end_time
                                );

                                if ($update_stmt->execute()) {
                                    $string .= "$c] Data updated successfully for $selection for shift on $current_day from $current_start_time till $current_end_time at $current_wing Wing dated on $nextDateString.<br><br>";
                                } else {
                                    $string .=
                                        "$c] Error updating data for $selection for shift on $current_day from $current_start_time till $current_end_time at $current_wing Wing dated on $nextDateString: " .
                                        htmlspecialchars($update_stmt->error) .
                                        "<br><br>";
                                }
                                $update_stmt->close();
                            } else {

                                $insert_stmt = $conn->prepare(
                                    "INSERT INTO schedule (wing, day, start_time, end_time, name, phone, date) VALUES (?, ?, ?, ?, ?, ?, ?)"
                                );
                                $insert_stmt->bind_param(
                                    "sssssss",
                                    $current_wing,
                                    $current_day,
                                    $current_start_time,
                                    $current_end_time,
                                    $name,
                                    $phone,
                                    $nextDateString
                                );

                                if ($insert_stmt->execute()) {
                                    $string .= "$c] Data inserted successfully for $selection for shift on $current_day from $current_start_time till $current_end_time at $current_wing Wing dated on $nextDateString.<br><br>";
                                } else {
                                    $string .=
                                        "$c] Error inserting data for $selection for shift on $current_day from $current_start_time till $current_end_time at $current_wing Wing dated on $nextDateString: " .
                                        htmlspecialchars($insert_stmt->error) .
                                        "<br><br>";
                                }
                                $insert_stmt->close();
                            }
                            $c++;
                        }
                    } else {
                        $string .=
                            "$c] No matching records found for selection " .
                            htmlspecialchars($selection) .
                            ".<br><br>";
                        $c++;
                    }
                    $stmt->close();
                } else {
                    $string .=
                        "$c] Error executing query for selection " .
                        htmlspecialchars($selection) .
                        ": " .
                        htmlspecialchars($stmt->error) .
                        "<br><br>";
                    $c++;
                }
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        #nav-icon2 span:nth-child(even) {
            left: 50%;
            border-radius: 0 9px 9px 0;
        }

        #nav-icon2 span:nth-child(odd) {
            left: 0px;
            border-radius: 9px 0 0 9px;
        }

        #nav-icon2 span:nth-child(1),
        #nav-icon2 span:nth-child(2) {
            top: 0px;
        }

        #nav-icon2 span:nth-child(3),
        #nav-icon2 span:nth-child(4) {
            top: 18px;
        }

        #nav-icon2 span:nth-child(5),
        #nav-icon2 span:nth-child(6) {
            top: 36px;
        }

        #nav-icon2.open span:nth-child(1),
        #nav-icon2.open span:nth-child(6) {
            -webkit-transform: rotate(45deg);
            -moz-transform: rotate(45deg);
            -o-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        #nav-icon2.open span:nth-child(2),
        #nav-icon2.open span:nth-child(5) {
            -webkit-transform: rotate(-45deg);
            -moz-transform: rotate(-45deg);
            -o-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }

        #nav-icon2.open span:nth-child(1) {
            left: 5px;
            top: 7px;
        }

        #nav-icon2.open span:nth-child(2) {
            left: calc(50% - 5px);
            top: 7px;
        }

        #nav-icon2.open span:nth-child(3) {
            left: -50%;
            opacity: 0;
        }

        #nav-icon2.open span:nth-child(4) {
            left: 100%;
            opacity: 0;
        }

        #nav-icon2.open span:nth-child(5) {
            left: 5px;
            top: 29px;
        }

        #nav-icon2.open span:nth-child(6) {
            left: calc(50% - 5px);
            top: 29px;
        }

        .top {

            display: flex;
            flex-direction: row;
            /* Added this line to correct the syntax */
        }

        /* Initial state: hidden */
        .hidden {
            opacity: 0;
            transition: opacity 2s ease-out;
        }

        /* Visible state: shown */
        .visible {
            opacity: 1;
            transition: opacity 2s ease-in;

        }
    </style>
</head>

<body class="wrapper">
    <div class="main-container">
        <div class="header">
            <div class="top">
                <div id="nav-icon2">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="logo">Gpp Hostel
                    <span class=logo-det># Boys</span>
                </div>

            </div>
            <a class="header-link active" href="/Security/Head">
                Dashboard
            </a>
            <a class="header-link" href="/">
                Home
            </a>
            <a class="header-link" href="/About">
                About us
            </a>
            <a class="header-link" href="#">
                Committee
            </a>
            <a class="header-link" href="/Security/Head/Add">
                Add
            </a>
            <div class="user-info">
                <div class="a">
                    <div class="b">
                        <div class="user-name"><?php echo $_SESSION["fname"] .
                                                    " " .
                                                    substr($_SESSION["lname"], 0, 1); ?></div>
                        <svg class="profile" viewBox="-42 0 512 512" fill="currentColor">
                            <path d="M210.4 246.6c33.8 0 63.2-12.1 87.1-36.1 24-24 36.2-53.3 36.2-87.2 0-33.9-12.2-63.2-36.2-87.2-24-24-53.3-36.1-87.1-36.1-34 0-63.3 12.2-87.2 36.1S87 89.4 87 123.3c0 33.9 12.2 63.2 36.2 87.2 24 24 53.3 36.1 87.2 36.1zm-66-189.3a89.1 89.1 0 0166-27.3c26 0 47.5 9 66 27.3a89.2 89.2 0 0127.3 66c0 26-9 47.6-27.4 66a89.1 89.1 0 01-66 27.3c-26 0-47.5-9-66-27.3a89.1 89.1 0 01-27.3-66c0-26 9-47.6 27.4-66zm0 0M426.1 393.7a304.6 304.6 0 00-12-64.9 160.7 160.7 0 00-13.5-30.3c-5.7-10.2-12.5-19-20.1-26.3a88.9 88.9 0 00-29-18.2 100.1 100.1 0 00-37-6.7c-5.2 0-10.2 2.2-20 8.5-6 4-13 8.5-20.9 13.5-6.7 4.3-15.8 8.3-27 11.9a107.3 107.3 0 01-66 0 119.3 119.3 0 01-27-12l-21-13.4c-9.7-6.3-14.8-8.5-20-8.5a100 100 0 00-37 6.7 88.8 88.8 0 00-29 18.2 114.4 114.4 0 00-20.1 26.3 161 161 0 00-13.4 30.3A302.5 302.5 0 001 393.7c-.7 9.8-1 20-1 30.2 0 26.8 8.5 48.4 25.3 64.4C41.8 504 63.6 512 90.3 512h246.5c26.7 0 48.6-8 65.1-23.7 16.8-16 25.3-37.6 25.3-64.4a437 437 0 00-1-30.2zm-44.9 72.8c-11 10.4-25.4 15.5-44.4 15.5H90.3c-19 0-33.4-5-44.4-15.5C35.2 456.3 30 442.4 30 424c0-9.5.3-19 1-28.1A272.9 272.9 0 0141.7 338a131 131 0 0110.9-24.7A84.8 84.8 0 0167.4 294a59 59 0 0119.3-12 69 69 0 0123.6-4.5c1 .5 3 1.6 6 3.6l21 13.6c9 5.6 20.4 10.7 34 15.1a137.3 137.3 0 0084.5 0c13.7-4.4 25.1-9.5 34-15.1a2721 2721 0 0027-17.2 69 69 0 0123.7 4.5 59 59 0 0119.2 12 84.5 84.5 0 0114.9 19.4c4.5 8 8.2 16.3 10.8 24.7a275.2 275.2 0 0110.8 57.8c.6 9 1 18.5 1 28.1 0 18.5-5.3 32.4-16 42.6zm0 0" />
                        </svg>
                    </div>
                                        <div class="log_out" onclick="logout()">
                        Log Out
                    </div>
                </div>

                <div class="hour" id="current-time">08.20 pm</div>
            </div>
        </div>
                <script>
            function logout() {
                localStorage.clear();
                sessionStorage.clear();

                document.cookie.split(';').forEach(function(cookie) {
                    var cookieName = cookie.split('=')[0].trim();
                    document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
                });

                window.location.href = '/Login';
            }
            document.addEventListener('DOMContentLoaded', function() {


                var navIcon2 = document.getElementById('nav-icon2');

                navIcon2.addEventListener('click', function() {

                    this.classList.toggle('open');

                    var elements = document.querySelectorAll('.header-link, .user-info');

                    elements.forEach(function(element) {

                        if (element.classList.contains('hidden')) {
                            element.classList.remove('hidden');
                            element.classList.add('visible');
                        } else if (element.classList.contains('visible')) {
                            element.classList.remove('visible');
                            element.classList.add('hidden');
                        } else {

                            element.classList.add('hidden');
                        }
                    });
                });
            });
</script>
    </div>
</body>
</html>

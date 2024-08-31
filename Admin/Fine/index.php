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
            <a class="header-link" href="/Admin">
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
            <a class="header-link" href="/Admin/Room">
                Room
            </a>
            <a class="header-link" href="/Admin/Notice">
                Notice
            </a>
            <a class="header-link active" href="/Admin/Fine">
                Fine
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

            function addHiddenClass() {
                const navIcon = document.getElementById('nav-icon2');
                console.log(window.innerWidth);
                if (window.innerWidth < 851) {
                    const elements = document.querySelectorAll('.header-link, .user-info');
                    elements.forEach(element => {
                        element.classList.add('hidden');
                    });
                    if (navIcon) {
                        navIcon.style.display = 'block';
                    }
                } else {
                    const elements = document.querySelectorAll('.header-link.hidden, .user-info.hidden');
                    elements.forEach(element => {
                        element.classList.remove('hidden');
                    });
                    if (navIcon) {
                        navIcon.style.display = 'none';
                    }
                }
            }

            window.onload = addHiddenClass;

            window.onresize = addHiddenClass;

            function updateTime() {
                var now = new Date();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                var currentTime = hours + ':' + minutes + ' ' + ampm;
                document.getElementById('current-time').textContent = currentTime;
            }

            setInterval(updateTime, 1000);

            window.onload = updateTime;


            document.addEventListener("DOMContentLoaded", addHiddenClass);
        </script>
        <div class="user-box first-box activity card">
            <h1>Fine</h1>
            <form method="post" action="">
                <div class="field">
                    <label for="select-option">Impose fine based on:</label>
                    <select name="select-option" id="select-option" class="select" onchange="updateForm()">
                        <option value="enrollment">Enrollment Number</option>
                        <option value="wing">Wing</option>
                        <option value="year">Year</option>
                    </select>
                </div>

                <div id="enrollment-section" class="field" style="display:none;">
                    <label for="enrollment">Enrollment Numbers (comma separated):</label>
                    <input type="text" name="enrollment" id="enrollment" class="search" placeholder="Enter enrollment numbers">
                </div>

                <div id="wing-section" class="field" style="display:none;">
                    <label for="wing">Select Wing:</label>
                    <select name="wing" id="wing" class="select">
                        <option value="all">All Wings</option>
                        <option value="A">A Wing</option>
                        <option value="B">B Wing</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

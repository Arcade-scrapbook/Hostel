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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <a class="header-link active" href="/Admin">
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
            <a class="header-link" href="/Admin/Fine">
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
        <div class="user-box first-box">
            <div class="activity card user-box" style="--delay: .2s">
				<div class="title">Boys Hostel</div>
				<div class="activity-links">
					<div class="activity-link active">A Wing</div>
				</div>
				
                <div class="destination">
    <?php
    $token = "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";

            $repoOwner = "Tejas2305";
            $repoName = "Hostel-Webiste";
// PHP code from above
$servername = "sql302.infinityfree.com";
$username = "if0_36375033";
$password = "TC6VYgEIdbFI95H";
$dbname = "if0_36375033_hostel";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $today = date("Y-m-d");
    $first_day_of_week = date("Y-m-d", strtotime("monday this week", strtotime($today)));
    $last_day_of_week = date("Y-m-d", strtotime("sunday this week", strtotime($today)));
    $wing = "A";
    $sql = "SELECT schedule.*, user.image FROM schedule JOIN user ON CONCAT(user.first, ' ', user.last) = schedule.name WHERE schedule.wing = '$wing' AND schedule.date BETWEEN '$first_day_of_week' AND '$last_day_of_week' ORDER BY schedule.date, schedule.start_time;";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $current_date = null;
        $card_count = 0; // Initialize card counter
        // Output data for each schedule entry
        while ($row = $result->fetch_assoc()) {
            // Output date and day only once if it's a new date
            if ($row["date"] !== $current_date) {
                // Check if the previous day's card count was odd
                if ($card_count % 2 != 0) {
                    echo '<div class="destination-card black-card"></div>';
                }
                $card_count = 0; // Reset card counter for new date
                echo '<h3  style="display:inline-block;">' . $row["day"] . '<h5 style="display:inline-block; margin-left:10px;">[' . $row["date"] . ']</h5></h3>';
                $current_date = $row["date"];
            }
            
            
           

            echo '<div class="destination-card"><div class="destination-profile">';
            echo '<img class="profile-img" src="' . $row["image"] . '" alt="Image"/>';
            echo '<div class="destination-length">';
            echo '<div class="name">' . $row["name"] . '</div>';
            echo '<div>From ' . $row["start_time"] . ' Till ' . $row["end_time"] . '</div>';
            echo '</div></div><div class="destination-points">';
            echo '<div class="point">' . $row["phone"] . '</div>';
            echo '</div></div>';

            $card_count++; // Increment card counter
        }
        // Check if the last day's card count was odd
        if ($card_count % 2 != 0) {
            echo '<div class="destination-card black-card"></div>';
        }
    } else {
        echo "No schedule found for wing " . $wing . " for the current week";
    }
    ?>
</div>
						
								
								
                <br>
                <br>

				<div class="activity-links">
					<div class="activity-link active">B Wing</div>
				</div>
                <br>
				                <div class="destination">
    <?php
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $today = date("Y-m-d");
    $first_day_of_week = date("Y-m-d", strtotime("monday this week", strtotime($today)));
    $last_day_of_week = date("Y-m-d", strtotime("sunday this week", strtotime($today)));
    $wing = "B";
    $sql = "SELECT schedule.*, user.image FROM schedule JOIN user ON CONCAT(user.first, ' ', user.last) = schedule.name WHERE schedule.wing = '$wing' AND schedule.date BETWEEN '$first_day_of_week' AND '$last_day_of_week' ORDER BY schedule.date, schedule.start_time;";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $current_date = null;
        $card_count = 0; // Initialize card counter
        // Output data for each schedule entry
        while ($row = $result->fetch_assoc()) {
            // Output date and day only once if it's a new date
            if ($row["date"] !== $current_date) {
                // Check if the previous day's card count was odd
                if ($card_count % 2 != 0) {
                    echo '<div class="destination-card black-card"></div>';
                }
                $card_count = 0; // Reset card counter for new date
                echo '<h3 style="display:inline-block;">' . $row["day"] . '<h5 style="display:inline-block; margin-left:10px;">[' . $row["date"] . ']</h5></h3>';
                $current_date = $row["date"];
            }

           

            echo '<div class="destination-card"><div class="destination-profile">';
            echo '<img class="profile-img" src="' . $row["image"] . '" alt="Image"/>';
            echo '<div class="destination-length">';
            echo '<div class="name">' . $row["name"] . '</div>';
            echo '<div>From ' . $row["start_time"] . ' Till ' . $row["end_time"] . '</div>';
            echo '</div></div><div class="destination-points">';
            echo '<div class="point">' . $row["phone"] . '</div>';
            echo '</div></div>';

            $card_count++; // Increment card counter
        }
        // Check if the last day's card count was odd
        if ($card_count % 2 != 0) {
            echo '<div class="destination-card black-card"></div>';
        }
    } else {
        echo "No schedule found for wing " . $wing . " for the current week";
    }
    ?>
</div>
			</div>
        </div>
    </div>
</body>
</html>

<?php
session_start();

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "student") {
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

        }

        .hidden {
            opacity: 0;
            transition: opacity 2s ease-out;
        }

        .visible {
            opacity: 1;
            transition: opacity 2s ease-in;

        }
        .logo{
            padding:20px 50px 20px 50px;
        }
    </style>

</head>

<body class="wrapper">
    <?php
    date_default_timezone_set("Asia/Kolkata");

    $host = "sql302.infinityfree.com";
    $username = "if0_36375033";
    $password = "TC6VYgEIdbFI95H";
    $database = "if0_36375033_hostel";

    $connection = mysqli_connect($host, $username, $password, $database);

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    ?>
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
            <a class="header-link active" href="/Student">
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

            function setMarginLeftToZero() {
                if (window.innerWidth < 850) {

                    const cardElements = document.querySelectorAll('.card');

                    const userBoxElements = document.querySelectorAll('.user-box');

                    const wrapperElements = document.querySelectorAll('[class*="-wrapper"]');

                    const allSelectedElements = [...cardElements, ...userBoxElements, ...wrapperElements];

                    allSelectedElements.forEach(element => {
                        element.style.marginLeft = '0';
                    });
                } else {

                    const resetElements = document.querySelectorAll('.card, .user-box, [class*="-wrapper"]');
                    resetElements.forEach(element => {
                        element.style.marginLeft = '';
                    });
                }
            }
            setMarginLeftToZero();
            document.addEventListener("DOMContentLoaded", setMarginLeftToZero);
            window.addEventListener("resize", setMarginLeftToZero);
        </script>
        <div class="user-box first-box">
            <div class="activity card" style="--delay: .2s">
                <div class="title"><?php echo $_SESSION["wing"]; ?> Wing</div>
                <div class="title">Room Number: <?php echo $_SESSION["room"]; ?></div>
                <div class="activity-links">
                    <div class="activity-link active">Room Mates</div>
                </div>
                <div class="destination">
                    <?php
                    $sql =
                        "SELECT * FROM user WHERE room = '" .
                        $_SESSION["room"] .
                        "' AND user_id <> '" .
                        $_SESSION["username"] .
                        "'";
                    $result = mysqli_query($connection, $sql);

                    if (mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                            echo '<div class="destination-card">';
                            echo '<div class="destination-profile">';
                            echo '<img class="profile-img" src="' .
                                $row["image"] .
                                '" alt="" />';
                            echo '<div class="destination-length">';
                            echo '<div class="name">' .
                                $row["first"] .
                                " " .
                                $row["middle"] .
                                " " .
                                $row["last"] .
                                "</div>";
                            echo "<div>(" . $row["dept"] . ")</div>";
                            echo "</div>";
                            echo "</div>";
                            echo '<div class="destination-points">';
                            echo '<div class="point">' . $row["phone_no"] . "</div>";
                            echo '<div class="sub-point">' . $row["address"] . "</div>";
                            echo '<div class="sub-point">' .
                                date("d/m/Y", strtotime($row["birthdate"])) .
                                "</div>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "No users found in room";
                    }
                    ?>
                </div>
            </div>
            <div class="discount card" style="--delay: .4s">
                <?php

                $stmt = $connection->prepare("SELECT image FROM user WHERE user_id = ?");
                $stmt->bind_param("s", $_SESSION["username"]);
                $stmt->execute();
                $result = $stmt->get_result();

                $image = $result->fetch_assoc()["image"] ?? null;

                $stmt->close();

                $connection->close();
                ?>

                <div class="title">Your Profile</div>
                <div class="account-profile">
                    <img src="<?php echo $image; ?>" alt="">
                    <div class="blob-wrap">
                        <div class="blob"></div>
                        <div class="blob"></div>
                        <div class="blob"></div>
                    </div>
                    <div class="account-text">
                        <div class="account-name"><?php echo $_SESSION["fname"] .
                                                        " " .
                                                        $_SESSION["mname"] .
                                                        " " .
                                                        $_SESSION["lname"]; ?></div>

                        <table class="account-table">
                            <tr>
                                <td class="account-title"><span class="lable">Enrollment No: </span></td>
                                <td><?php echo $_SESSION["username"]; ?></td>
                            </tr>
                            <tr>
                                <td class="account-title"><span class="lable">Phone number: </span></td>
                                <td><?php echo $_SESSION["phone"]; ?></td>
                            </tr>
                            <tr>
                                <td class="account-title"><span class="lable">City: </span></td>
                                <td><?php echo $_SESSION["address"]; ?></td>
                            </tr>
                            <tr>
                                <td class="account-title"><span class="lable">Parents phone no.: </span></td>
                                <td><?php echo $_SESSION["phone_p"]; ?></td>
                            </tr>
                            <tr>
                                <td class="account-title"><span class="lable">Birth Date: </span></td>
                                <td><?php echo date(
                                        "d/m/Y",
                                        strtotime($_SESSION["birthdate"])
                                    ); ?></td>
                            </tr>
                            <tr>
                                <td class="account-title"><span class="lable">Blood Group: </span></td>
                                <td><?php echo $_SESSION["blood"]; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="discount-wrapper">
                    <div class="discount-info">
                        <div class="subtitle">Pending Payment:</div>
                        <div class="subtitle-count" id="pending_payment">₹0</div>
                    </div>
                </div>
            </div>
            <?php

            function fetchAttendanceData($user_id, $month, $year)
            {
                global $host, $username, $password, $database;

                $conn = new mysqli($host, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT date, status, time FROM attendance WHERE user_id = $user_id AND MONTH(date) = $month AND YEAR(date) = $year";
                $result = $conn->query($sql);

                $attendance_data = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $attendance_data[$row["date"]] = [
                            "status" => $row["status"],
                            "time" => $row["time"],
                        ];
                    }
                }

                $conn->close();
                return $attendance_data;
            }

            $user_id = isset($_SESSION["username"]) ? $_SESSION["username"] : "0";
            $month = isset($_GET["month"]) ? (int) $_GET["month"] : date("n");
            $year = isset($_GET["year"]) ? (int) $_GET["year"] : date("Y");
            $attendance_data = fetchAttendanceData($user_id, $month, $year);
            ?>
            <div class="cards-wrapper" id="cal" style="--delay: .6s">
                <div class="cards-header">
                    <div class="cards-header-date">
                        <svg id="prevMonth" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left" style="cursor: pointer;">
                            <path d="M15 18l-6-6 6-6"></path>
                        </svg>
                        <div class="title"><?php echo date(
                                                "F Y",
                                                strtotime("$year-$month-01")
                                            ); ?></div>
                        <svg id="nextMonth" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right" style="cursor: pointer;">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </div>
                </div>

                <div class="cards card">
                    <div class="cards-head">
                        <div class="cards-info">
                            <div class="degree">
                                <span id="absentInMonth">Absent in this Month: 0</span>
                                <span id="lateInMonth">Late in this Month: 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="items days">
                        <div class="item">Mon</div>
                        <div class="item">Tue</div>
                        <div class="item">Wed</div>
                        <div class="item">Thu</div>
                        <div class="item">Fri</div>
                        <div class="item">Sat</div>
                        <div class="item">Sun</div>
                    </div>

                    <div class="items numbers" id="calendarDays">
                        <?php
                        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                        $firstDayOfMonth = date("N", strtotime("$year-$month-01"));
                        $lastDayOfMonth = date("N", strtotime("$year-$month-$daysInMonth"));
                        $absentInMonth = 0;
                        $lateInMonth = 0;

                        $prevMonth = $month - 1;
                        $prevYear = $year;
                        if ($prevMonth == 0) {
                            $prevMonth = 12;
                            $prevYear--;
                        }
                        $daysInPrevMonth = cal_days_in_month(
                            CAL_GREGORIAN,
                            $prevMonth,
                            $prevYear
                        );
                        for ($i = $firstDayOfMonth - 1; $i > 0; $i--) {
                            $prevDate = $daysInPrevMonth - $i + 1;
                            echo "<div class='item disabled'>$prevDate</div>";
                        }

                        for ($i = 1; $i <= $daysInMonth; $i++) {
                            $date = sprintf("%d-%02d-%02d", $year, $month, $i);
                            $class = "";
                            $time = "";

                            if (isset($attendance_data[$date])) {
                                $status = $attendance_data[$date]["status"];
                                $time = $attendance_data[$date]["time"];
                                $class = $status;
                                if ($status == "absent") {
                                    $absentInMonth++;
                                } elseif ($status == "late") {
                                    $lateInMonth++;
                                }
                            } elseif (strtotime($date) < strtotime("today")) {
                                $class = "absent";
                                $absentInMonth++;
                            }

                            echo "<div class='item $class' data-date='$date' data-time='$time'>$i</div>";
                        }

                        $nextMonth = $month + 1;
                        $nextYear = $year;
                        if ($nextMonth == 13) {
                            $nextMonth = 1;
                            $nextYear++;
                        }
                        for ($i = 1; $i <= 7 - $lastDayOfMonth; $i++) {
                            echo "<div class='item disabled'>$i</div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div id="popup">
                <div class="popup-close" id="popup-close">&times;</div>
                <div id="popup-date" class="popup-date"></div>
                <div id="popup-time" class="popup-time"></div>
            </div>

            <script>
                document.getElementById('absentInMonth').innerText = "Absent in this Month: <?php echo $absentInMonth; ?>";
                document.getElementById('lateInMonth').innerText = "Late in this Month: <?php echo $lateInMonth; ?>";

                document.querySelectorAll('.item').forEach(function(item) {
                    item.addEventListener('click', function(event) {
                        var date = this.getAttribute('data-date');
                        var time = this.getAttribute('data-time');
                        var status = this.classList.contains('present') ? 'present' : this.classList.contains('late') ? 'late' : '';

                        if (date && time) {
                            var popup = document.getElementById('popup');
                            document.getElementById('popup-date').innerText = date;
                            document.getElementById('popup-time').innerText = `Marked ${status} at ${time}`;
                            popup.style.display = 'block';
                            popup.style.left = event.pageX + 'px';
                            popup.style.top = event.pageY + 'px';
                        }
                    });
                });

                document.addEventListener('click', function(event) {
                    var popup = document.getElementById('popup');
                    var popupClose = document.getElementById('popup-close');
                    if (!event.target.classList.contains('item') && event.target != popupClose) {
                        popup.style.display = 'none';
                    }
                });

                document.getElementById('popup-close').addEventListener('click', function() {
                    document.getElementById('popup').style.display = 'none';
                });
            </script>

            <div class="account-wrapper" style="--delay: .8s">
                <div class="in-header">
                    <div class="title">In and Out</div>
                    <div class="v">View All</div>
                </div>
                <div class="account card" id="ac">
                    <div class="data">
                        <div class="set">
                            <span class="date">23 oct 2023</span>
                            <div class="in_out">
                                <div class="out">
                                    Out: 9:00 Am
                                </div>
                                <div class="in">
                                    In: 11:00 Am
                                </div>
                            </div>
                            <div class="in_out">
                                <div class="out">
                                    Out: 1:00 pm
                                </div>
                                <div class="in">
                                    In: 5:00 Am
                                </div>
                            </div>
                        </div>
                        <div class="set">
                            <span class="date">25 oct 2023</span>
                            <div class="in_out">
                                <div class="out">
                                    Out: 8:00 Am
                                </div>
                                <div class="in">
                                    In: 11:00 Am
                                </div>
                            </div>
                            <div class="in_out">
                                <div class="out">
                                    Out: 4:00 pm
                                </div>
                                <div class="in">
                                    In: 5:00 Am
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="user-box second-box">
            <div class="cards-wrapper" style="--delay: 1s">
                <div class="cards-header">
                    <div class="cards-header-date">
                        <div class="title">Notice</div>
                    </div>
                </div>
                <?php
                $wing = $_SESSION["wing"];

                $conn = new mysqli($host, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT date, type, name, note, wing FROM Notice";
                $result = $conn->query($sql);
                ?>

                <div class="cards card">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>From</th>
                                <th>Note</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    if ($row["wing"] == "All" || $row["wing"] == $wing) {
                                        echo "<tr>";
                                        echo "<td><span class='time'>" .
                                            $row["date"] .
                                            "</span></td>";
                                        echo "<td>" . $row["type"] . "</td>";
                                        echo "<td>" . $row["name"] . "</td>";
                                        echo "<td>" . $row["note"] . "</td>";
                                        echo "</tr>";
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='4'>No notices found</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class=" transection" style="--delay: 1.2s">
                <div class="transection-header cards-header">
                    <div class="head">Transactions</div>
                </div>
                <div class="card" id="tran">
                    <?php

                    $conn = new mysqli($host, $username, $password, $database);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $user_enrollment_number = $_SESSION["username"];

                    $sql =
                        "SELECT type, reason, amount, status,method FROM transaction WHERE enrollment_number = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $user_enrollment_number);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    $totalAmount = 0;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $type = $row["type"];
                            $reason = $row["reason"];
                            $amount = $row["amount"];
                            $status = $row["status"];
                            $method = $row["method"];

                            if (strcasecmp($status, "unpaid") == 0) {
                                $totalAmount -= $amount;
                            }

                            $moneyClass =
                                strcasecmp($status, "paid") == 0
                                ? "is-active"
                                : "is-cancel";
                            $moneySign =
                                strcasecmp($status, "paid") == 0
                                ? "(paid)" . $method . "<br>"
                                : "(imposed)<br>";
                    ?>

                            <div class="credit-wrapper">
                                <div class="credit-name">
                                    <div class="credit-type"><?php echo htmlspecialchars(
                                                                    $type
                                                                ); ?></div>
                                    <div class="credit-status"><?php echo htmlspecialchars(
                                                                    $reason
                                                                ); ?></div>
                                </div>
                                <div class="credit-money <?php echo $moneyClass; ?>"><?php echo $moneySign; ?> ₹<?php echo number_format(
                                                                                                                    $amount,
                                                                                                                    2
                                                                                                                ); ?></div>
                            </div>

                    <?php
                        }
                    } else {
                        echo "No transactions found.";
                    }

                    $stmt->close();
                    $conn->close();
                    ?>

                </div>

            </div>
        </div>
    </div>
    <script>
        function updateCalendar(month, year) {
            window.location.href = `?month=${month}&year=${year}#cal`;
        }

        document.getElementById('prevMonth').addEventListener('click', function() {
            let month = <?php echo $month; ?>;
            let year = <?php echo $year; ?>;
            month--;
            if (month < 1) {
                month = 12;
                year--;
            }
            updateCalendar(month, year);
        });

        document.getElementById('nextMonth').addEventListener('click', function() {
            let month = <?php echo $month; ?>;
            let year = <?php echo $year; ?>;
            month++;
            if (month > 12) {
                month = 1;
                year++;
            }
            updateCalendar(month, year);
        });

        var totalAmount = "<?php echo $totalAmount; ?>";
        var formattedAmount = "₹" + parseFloat(totalAmount).toFixed(2);

        var pendingPaymentElement = document.getElementById("pending_payment");
        pendingPaymentElement.innerText = formattedAmount;

        if (totalAmount < 0) {
            pendingPaymentElement.style.color = "#d14b69";
        } else if (totalAmount > 0) {
            pendingPaymentElement.style.color = "#17a98a";
        }
    </script>
</body>

</html>

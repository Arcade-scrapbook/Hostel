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




<div class=" card" style="--delay: .4s; width:10px;">
<div class="transection-header cards-header">
    <div class="head">Transactions</div>
</div>
<div class="card" id="tran">
<?php
 $host = "sql302.infinityfree.com";
    $username = "if0_36375033";
    $password = "TC6VYgEIdbFI95H";
    $dbname = "if0_36375033_hostel";
?>
    <?php
// Start session
session_start();

// Database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the last 5 non-debit transactions based on imposed_date
$sql = "SELECT enrollment_number, type, reason, amount FROM transaction WHERE type <> 'debit' ORDER BY imposed_date DESC LIMIT 5";
$result = $conn->query($sql);

$totalAmount = 0; // Initialize total amount
$transactionsDisplayed = false; // Flag to check if any transactions are displayed

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $enrollment_number = $row['enrollment_number'];
        $type = $row['type'];
        $reason = $row['reason'];
        $amount = $row['amount'];

        // Calculate total amount
        if ($type == 'credit') {
            $totalAmount += $amount;
        } else {
            $totalAmount -= $amount;
        }

        $moneyClass = ($type == 'credit') ? 'is-active' : 'is-cancel';
        $moneySign = ($type == 'credit') ? '+' : '(Imposed)<br>';
        ?>

        <div class="credit-wrapper">
            <div class="credit-name">
                <div class="credit-type"><?php echo htmlspecialchars($type); ?></div>
                <div class="credit-status"><?php echo htmlspecialchars($reason); ?></div>
                <div class="credit-enrollment">Enrollment: <?php echo htmlspecialchars($enrollment_number); ?></div>
            </div>
            <div class="credit-money <?php echo $moneyClass; ?>"><?php echo $moneySign; ?> ₹<?php echo number_format($amount, 2); ?></div>
        </div>

        <?php
        $transactionsDisplayed = true;
    }
}

// If no non-debit transactions are found, fetch the last 5 debit transactions
if (!$transactionsDisplayed) {
    $sql = "SELECT enrollment_number, type, reason, amount FROM transaction WHERE type = 'debit' ORDER BY imposed_date DESC LIMIT 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $enrollment_number = $row['enrollment_number'];
            $type = $row['type'];
            $reason = $row['reason'];
            $amount = $row['amount'];

            // Calculate total amount
            $totalAmount -= $amount;

            $moneyClass = 'is-cancel';
            $moneySign = '-';
            ?>

            <div class="credit-wrapper">
                <div class="credit-name">
                    <div class="credit-type"><?php echo htmlspecialchars($type); ?></div>
                    <div class="credit-status"><?php echo htmlspecialchars($reason); ?></div>
                    <div class="credit-enrollment">Enrollment: <?php echo htmlspecialchars($enrollment_number); ?></div>
                </div>
                <div class="credit-money <?php echo $moneyClass; ?>"><?php echo $moneySign; ?> ₹<?php echo number_format($amount, 2); ?></div>
            </div>

            <?php
        }
    } else {
        echo "No transactions found.";
    }
}


$conn->close();
?>

</div>
</div>
<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = "sql302.infinityfree.com";
$username = "if0_36375033";
$password = "TC6VYgEIdbFI95H";
$database = "if0_36375033_hostel";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the transaction and user tables
$sql = "SELECT u.wing, t.type, t.reason, t.amount, t.status 
        FROM transaction t 
        JOIN user u ON t.enrollment_number = u.user_id 
        WHERE u.role = 'student'";

$result = $conn->query($sql);

// Initialize arrays to hold data
$wingData = [];
$totalPaid = 0;
$totalUnpaid = 0;

// Process fetched data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $wing = $row['wing'];
        $type = $row['type'];
        $reason = $row['reason'];
        $amount = $row['amount'];
        $status = $row['status'];

        // Initialize wing data if not already done
        if (!isset($wingData[$wing])) {
            $wingData[$wing] = [
                'imposed' => [
                    'hostel_fees' => 0,
                    'reserved_fees' => 0,
                    'other_fines' => 0,
                    'count' => 0
                ],
                'paid' => [
                    'hostel_fees' => 0,
                    'reserved_fees' => 0,
                    'other_fines' => 0,
                    'count' => 0
                ],
                'unpaid' => [
                    'hostel_fees' => 0,
                    'reserved_fees' => 0,
                    'other_fines' => 0,
                    'count' => 0
                ]
            ];
        }

        // Convert $reason and $status to lowercase for case-insensitive comparison
        $reasonLower = strtolower($reason);
        $statusLower = strtolower($status);

        // Determine fee type and update wing data accordingly
        if ($reasonLower === 'hostel fees') {
            if ($statusLower === 'paid') {
                $wingData[$wing]['paid']['hostel_fees'] += $amount;
                $wingData[$wing]['paid']['count']++;
            } else {
                $wingData[$wing]['unpaid']['hostel_fees'] += $amount;
                $wingData[$wing]['unpaid']['count']++;
            }
            $wingData[$wing]['imposed']['hostel_fees'] += $amount;
            $wingData[$wing]['imposed']['count']++;
        } elseif ($reasonLower === 'hostel fees (reserved caste)') {
            if ($statusLower === 'paid') {
                $wingData[$wing]['paid']['reserved_fees'] += $amount;
                $wingData[$wing]['paid']['count']++;
            } else {
                $wingData[$wing]['unpaid']['reserved_fees'] += $amount;
                $wingData[$wing]['unpaid']['count']++;
            }
            $wingData[$wing]['imposed']['reserved_fees'] += $amount;
            $wingData[$wing]['imposed']['count']++;
        } else {
            if ($statusLower === 'paid') {
                $wingData[$wing]['paid']['other_fines'] += $amount;
                $wingData[$wing]['paid']['count']++;
            } else {
                $wingData[$wing]['unpaid']['other_fines'] += $amount;
                $wingData[$wing]['unpaid']['count']++;
            }
            $wingData[$wing]['imposed']['other_fines'] += $amount;
            $wingData[$wing]['imposed']['count']++;
        }

        // Update total amounts
        if ($statusLower === 'paid') {
            $totalPaid += $amount;
        } else {
            $totalUnpaid += $amount;
        }
    }
} else {
    echo "No transactions found.";
}

$conn->close();
?>
<div class="discount card" style="--delay: .4s">
    <div class="title">Transaction</div>
    <div class="transaction-wrapper">
        <?php foreach ($wingData as $wing => $data) { ?>
        <div class="transaction">
            <div class="transaction-info">
                <div class="transaction-type"><?php echo htmlspecialchars($wing); ?> Wing</div>
                <h4>Imposed</h4>
                <br>
                <table class="transaction-table">
                    <tr>
                        <td>Hostel Fees</td>
                        <td>:1100 x <span class="number"><?php echo $data['imposed']['count']; ?></span></td>
                        <td>= <?php echo number_format($data['imposed']['hostel_fees'], 2); ?></td>
                    </tr>
                    <tr>
                        <td>Hostel Fees (reserved Caste)</td>
                        <td>:550 x <span class="number"><?php echo $data['imposed']['count']; ?></span></td>
                        <td>= <?php echo number_format($data['imposed']['reserved_fees'], 2); ?></td>
                    </tr>
                    <tr>
                        <td>Other Fines</td>
                        <td colspan="2"><?php echo number_format($data['imposed']['other_fines'], 2); ?></td>
                    </tr>
                </table>
                <br>
                <h4>Paid</h4>
                <br>
                <table class="transaction-table">
                    <tr>
                        <td>Hostel Fees</td>
                        <td>:1100 x <span class="number"><?php echo $data['paid']['count']; ?></span></td>
                        <td>= <?php echo number_format($data['paid']['hostel_fees'], 2); ?></td>
                    </tr>
                    <tr>
                        <td>Hostel Fees (reserved Caste)</td>
                        <td>:550 x <span class="number"><?php echo $data['paid']['count']; ?></span></td>
                        <td>= <?php echo number_format($data['paid']['reserved_fees'], 2); ?></td>
                    </tr>
                    <tr>
                        <td>Other Fines</td>
                        <td colspan="2"><?php echo number_format($data['paid']['other_fines'], 2); ?></td>
                    </tr>
                </table>
                <br>
                <h4>UnPaid</h4>
                <br>
                <table class="transaction-table">
                    <tr>
                        <td>Hostel Fees</td>
                        <td>:1100 x <span class="number"><?php echo $data['unpaid']['count']; ?></span></td>
                        <td>= <?php echo number_format($data['unpaid']['hostel_fees'], 2); ?></td>
                    </tr>
                    <tr>
                        <td>Hostel Fees (reserved Caste)</td>
                        <td>:550 x <span class="number"><?php echo $data['unpaid']['count']; ?></span></td>
                        <td>= <?php echo number_format($data['unpaid']['reserved_fees'], 2); ?></td>
                    </tr>
                    <tr>
                        <td>Other Fines</td>
                        <td colspan="2"><?php echo number_format($data['unpaid']['other_fines'], 2); ?></td>
                    </tr>
                </table>
                <br>
            </div>

        <div class="wing-summary">
            <div class="transaction-amount is-active">Paid: <?= number_format($data['paid']['hostel_fees'] + $data['paid']['reserved_fees'] + $data['paid']['other_fines'], 2) ?></div>
            <div class="transaction-amount is-cancel">UnPaid: <?= number_format($data['unpaid']['hostel_fees'] + $data['unpaid']['reserved_fees'] + $data['unpaid']['other_fines'], 2) ?></div>
        </div>


        </div>
        <?php } ?>
    </div>
    <div class="discount-wrapper">
        <div class="discount-info">
            <div class="subtitle">Paid Payment:</div>
            <div class="subtitle-count">₹<?= number_format($totalPaid, 2) ?></div>
            <div class="subtitle">Pending Payment:</div>
            <div class="subtitle-count">₹<?= number_format($totalUnpaid, 2) ?></div>
        </div>
    </div>
</div>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "sql302.infinityfree.com";
$username = "if0_36375033";
$password = "TC6VYgEIdbFI95H";
$dbname = "if0_36375033_hostel";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to get attendance data
function getAttendanceData($date) {
    global $conn;
    $data = [
        'lateAWing' => [],
        'lateBWing' => [],
        'absentAWing' => [],
        'absentBWing' => []
    ];

    // Get users' data
    $usersQuery = "SELECT * FROM user";
    $usersResult = $conn->query($usersQuery);

    if ($usersResult->num_rows > 0) {
        while ($user = $usersResult->fetch_assoc()) {
            $userId = $user['user_id'];
            $attendanceQuery = "SELECT * FROM attendance WHERE user_id='$userId' AND date='$date'";
            $attendanceResult = $conn->query($attendanceQuery);

            if ($attendanceResult->num_rows > 0) {
                $attendance = $attendanceResult->fetch_assoc();
                $status = $attendance['status'];
                $time = $attendance['time'];

                if ($status == 'late') {
                    $user['status'] = 'late';
                    $user['time'] = $time;
                    if ($user['wing'] == 'A') {
                        $data['lateAWing'][] = $user;
                    } else {
                        $data['lateBWing'][] = $user;
                    }
                } else {
                    // Do not display present users
                    continue;
                }
            } else {
                $currentTime = date('H:i:s');
                
                    $user['status'] = 'absent';
                    if ($user['wing'] == 'A') {
                        $data['absentAWing'][] = $user;
                    } else {
                        $data['absentBWing'][] = $user;
                    }
                
            }
        }
    }

    return $data;
}

// Get date from form or use today's date for initial load
$date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
$attendanceData = getAttendanceData($date);

// Update the date based on form input for next/previous day
if (isset($_POST['change_date'])) {
    $change_date = intval($_POST['change_date']);
    $date = date('Y-m-d', strtotime("$date $change_date day"));
    $attendanceData = getAttendanceData($date);
}
?>
<div class="cards-wrapper" style="--delay: .6s">
                <form class="cards-header" method="POST">
                    <div class="cards-header-date">
                    <button type="submit" name="change_date" value="-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-left" type="submit" name="change_date" value="-1">
                            <path d="M15 18l-6-6 6-6" />
                        </svg>
                        </button>
                        <div class="title" id="dateTitle"><?php echo date('F j, Y', strtotime($date)); ?></div>
                        <button type="submit" name="change_date" value="1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-chevron-right">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                        </button>
                    </div>
                     <input type="hidden" name="date" value="<?php echo $date; ?>">
                </form>
                
                <div class="cards card">
                
            <div class="custom-heading">late Arrived Students</div>
            <h3 class="center">A Wing</h3>
            <div id="lateAWing" class="custom-card-info">
                <?php foreach ($attendanceData['lateAWing'] as $user): ?>
                    <div class="custom-destination-card late">
                        <div class="custom-destination-profile">
                            <img class="custom-profile-img" src="<?php echo $user['image']; ?>" alt="">
                            <div class="custom-destination-length">
                                <div class="custom-name"><?php echo $user['first'] . ' ' . $user['middle'] . ' ' . $user['last']; ?></div>
                                <div>ID: <?php echo $user['user_id']; ?></div>
                            </div>
                        </div>
                        <div class="custom-destination-points">
                            <div class="custom-sub-point">Room No: <?php echo $user['room']; ?></div>
                            <div class="custom-sub-point">Phone No: <?php echo $user['phone_no']; ?></div>
                            <div class="custom-sub-point">Arrived at: <?php echo $user['time']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <h3 class="center">B Wing</h3>
            <div id="lateBWing" class="custom-card-info">
                <?php foreach ($attendanceData['lateBWing'] as $user): ?>
                    <div class="custom-destination-card late">
                        <div class="custom-destination-profile">
                            <img class="custom-profile-img" src="<?php echo $user['image']; ?>" alt="">
                            <div class="custom-destination-length">
                                <div class="custom-name"><?php echo $user['first'] . ' ' . $user['middle'] . ' ' . $user['last']; ?></div>
                                <div>ID: <?php echo $user['user_id']; ?></div>
                            </div>
                        </div>
                        <div class="custom-destination-points">
                            <div class="custom-sub-point">Room No: <?php echo $user['room']; ?></div>
                            <div class="custom-sub-point">Phone No: <?php echo $user['phone_no']; ?></div>
                            <div class="custom-sub-point">Arrived at: <?php echo $user['time']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="custom-heading">absent Students</div>
            <h3 class="center">A Wing</h3>
            <div id="absentAWing" class="custom-card-info">
                <?php foreach ($attendanceData['absentAWing'] as $user): ?>
                    <div class="custom-destination-card ab">
                        <div class="custom-destination-profile">
                            <img class="custom-profile-img" src="<?php echo $user['image']; ?>" alt="">
                            <div class="custom-destination-length">
                                <div class="custom-name"><?php echo $user['first'] . ' ' . $user['middle'] . ' ' . $user['last']; ?></div>
                                <div>ID: <?php echo $user['user_id']; ?></div>
                            </div>
                        </div>
                        <div class="custom-destination-points">
                            <div class="custom-sub-point">Room No: <?php echo $user['room']; ?></div>
                            <div class="custom-sub-point">Phone No: <?php echo $user['phone_no']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <h3 class="center">B Wing</h3>
            <div id="absentBWing" class="custom-card-info">
                <?php foreach ($attendanceData['absentBWing'] as $user): ?>
                    <div class="custom-destination-card ab">
                        <div class="custom-destination-profile">
                            <img class="custom-profile-img" src="<?php echo $user['image']; ?>" alt="">
                            <div class="custom-destination-length">
                                <div class="custom-name"><?php echo $user['first'] . ' ' . $user['middle'] . ' ' . $user['last']; ?></div>
                                <div>ID: <?php echo $user['user_id']; ?></div>
                            </div>
                        </div>
                        <div class="custom-destination-points">
                            <div class="custom-sub-point">Room No: <?php echo $user['room']; ?></div>
                            <div class="custom-sub-point">Phone No: <?php echo $user['phone_no']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        </div>
        <div class="user-box second-box">
            <div class="cards-wrapper" style="--delay: 1s">
                <div class="cards-header">
                    <div class="cards-header-date">
                        <div class="title">Notice</div>
                    </div>
                    <a href="https://gpphostels.rf.gd/Admin/Fine">
                    <div class="new">
                        New +
                    </div>
                    </a>
                </div>
                <?php
                $conn = new mysqli($servername, $username, $password, $dbname);

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
                while($row = $result->fetch_assoc()) {
                    if ($row['wing'] == 'All' || $row['wing'] == $wing) {
                        echo "<tr>";
                        echo "<td><span class='time'>" . $row['date'] . "</span></td>";
                        echo "<td>" . $row['type'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['note'] . "</td>";
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

        </div>
    </div>
</body>


</html>

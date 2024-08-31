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
</style>
</head>
</html>

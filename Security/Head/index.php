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
                            }
                        }
                    }
                }
            }
        }
              ?>

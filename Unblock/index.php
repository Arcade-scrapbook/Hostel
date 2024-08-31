<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "unblock") {
        http_response_code(403);
        exit();
    }
} else {
    http_response_code(403);
    header('Location: https://gpphostels.rf.gd');
    exit();
}


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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ip_address = $_POST['ip_address'];

    // Unblock the IP address
    $unblock_query = "UPDATE login_attempts SET blocked = FALSE, attempt_count = 0 WHERE ip_address = ?";
    $stmt = mysqli_prepare($connection, $unblock_query);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($connection));
    }

    mysqli_stmt_bind_param($stmt, "s", $ip_address);
    if (mysqli_stmt_execute($stmt)) {
        echo "IP address <strong>$ip_address</strong> has been unblocked.";
    } else {
        echo "Failed to unblock IP address <strong>$ip_address</strong>.";
    }
}

// Fetch all blocked IP addresses
$fetch_blocked_query = "SELECT ip_address FROM login_attempts WHERE blocked = TRUE";
$blocked_result = mysqli_query($connection, $fetch_blocked_query);

?>

<!doctype html>
<html>

<head>
    <link rel="icon" type="image/png" href="/favicon.png" />
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <script src='https://kit.fontawesome.com/a16a49be46.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Unblock IP Address</h1>
    
    <?php if (mysqli_num_rows($blocked_result) > 0): ?>
        <form action="" method="post">
            <div class='input-wrapper'>
                <label for="search_ip">Search IP Address:</label>
                <input type="text" id="search_ip" placeholder="Type to search..." onkeyup="filterIPs()">
                <label for="ip_address">Select IP Address to Unblock:</label>
                <select name="ip_address" id="ip_select" required>
                <option value="" disabled selected>Select</option>

                    <?php while ($row = mysqli_fetch_assoc($blocked_result)): ?>
                        <option value="<?php echo $row['ip_address']; ?>"><?php echo $row['ip_address']; ?></option>
                    <?php endwhile; ?>
                </select>
                <i class='fa-solid fa-network-wired'></i>
            </div>
            <div class='button-wrapper'>
                <button type="submit">Unblock</button>
            </div>
        </form>
    <?php else: ?>
        <p>No blocked IP addresses found.</p>
    <?php endif; ?>
</body>

<script>
    function filterIPs() {
        const searchInput = document.getElementById('search_ip').value.toLowerCase();
        const ipSelect = document.getElementById('ip_select');
        const options = ipSelect.options;

        for (let i = 0; i < options.length; i++) {
            const optionText = options[i].text.toLowerCase();
            if (optionText.includes(searchInput)) {
                options[i].style.display = '';
            } else {
                options[i].style.display = 'none';
            }
        }
    }
</script>

</html>

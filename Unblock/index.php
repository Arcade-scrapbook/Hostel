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
    <style>
    
.btn-3 {
    width: 130px;
  height: 40px;
  color: #fff;
  border-radius: 5px;
  padding: 10px 25px;
  font-family: 'Lato', sans-serif;
  font-weight: 500;
  background: transparent;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
  display: inline-block;
   box-shadow:inset 2px 2px 2px 0px rgba(255,255,255,.5),
   7px 7px 20px 0px rgba(0,0,0,.1),
   4px 4px 5px 0px rgba(0,0,0,.1);
  outline: none;
  background: rgb(0,172,238);
background: linear-gradient(0deg, rgba(0,172,238,1) 0%, rgba(2,126,251,1) 100%);
  width: 130px;
  height: 40px;
  line-height: 42px;
  padding: 0;
  border: none;
  
}
.btn-3 span {
  position: relative;
  display: block;
  width: 100%;
  height: 100%;
}
.btn-3:before,
.btn-3:after {
  position: absolute;
  content: "";
  right: 0;
  top: 0;
   background: rgba(2,126,251,1);
  transition: all 0.3s ease;
}
.btn-3:before {
  height: 0%;
  width: 2px;
}
.btn-3:after {
  width: 0%;
  height: 2px;
}
.btn-3:hover{
   background: transparent;
  box-shadow: none;
}
.btn-3:hover:before {
  height: 100%;
}
.btn-3:hover:after {
  width: 100%;
}
.btn-3 span:hover{
   color: rgba(2,126,251,1);
}
.btn-3 span:before,
.btn-3 span:after {
  position: absolute;
  content: "";
  left: 0;
  bottom: 0;
   background: rgba(2,126,251,1);
  transition: all 0.3s ease;
}
.btn-3 span:before {
  width: 2px;
  height: 0%;
}
.btn-3 span:after {
  width: 0%;
  height: 2px;
}
.btn-3 span:hover:before {
  height: 100%;
}
.btn-3 span:hover:after {
  width: 100%;
}

    </style>
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
    </script>
</head>

<body>

                <button class="btn-3" onclick="logout()"><span>Logout</span></button>

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

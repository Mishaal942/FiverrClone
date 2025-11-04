<?php
// ✅ Database Connection Settings
$host = "localhost";        // Change only if hosting gives another host
$user = "unzfutgwrtkyb";             // Your DB username
$pass = "zxqqgfz2ugxg";                 // Your DB password
$dbname = "dbkcwlikd3vjge";  // Your Database name

// ✅ Create Connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// ✅ Show Error if Connection Fails
if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>

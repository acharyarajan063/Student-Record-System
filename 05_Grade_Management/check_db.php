<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "student_record_system";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("<span style='color:red'>❌ Connection FAILED: " . $conn->connect_error . "</span>");
} else {
    echo "<span style='color:green'>✅ Connection SUCCESS! Database '$db' is connected.</span>";
    
    // Show database info
    echo "<br>Server info: " . $conn->server_info;
    echo "<br>Host info: " . $conn->host_info;
    
    $conn->close();
}
?>
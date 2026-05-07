<?php
// delete.php - removes a course record by id and redirects back to the course list

// Use XAMPP default credentials; adjust database settings as needed.
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'student_record_system';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit;
}

$stmt = $mysqli->prepare('DELETE FROM course WHERE CourseID = ?');
if (!$stmt) {
    echo 'Prepare failed: ' . $mysqli->error;
    $mysqli->close();
    exit;
}

$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();
$mysqli->close();

header('Location: index.php');
exit;
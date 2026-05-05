<?php
// Enable error reporting (development only)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once "database/db.php";

// Start session
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get input values
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate inputs
   if (empty($email) || empty($password)) {
    header("Location: index.php?error=empty");
    exit();
}

    // Connect to database
    $db = new Database();
    $conn = $db->connect();

    // Fetch student by email
    $stmt = $conn->prepare("SELECT * FROM student WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check login
    if ($user = $result->fetch_assoc()) {

        // Temporary password check
        if ($password === "1234") {

            // Store session data
            $_SESSION['student_id'] = $user['StudentID'];
            $_SESSION['student_name'] = $user['StudentName'];
            $_SESSION['role'] = 'student';

            // Redirect to dashboard
            header("Location: student_management/index.php");
            exit();
        }
    }

    // Login failed
    header("Location: index.php?error=invalid");
    exit();
}
?>
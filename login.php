<?php

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database
require_once "database/db.php";

// Start session
session_start();

// Check form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form values
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validate empty fields
    if (empty($email) || empty($password)) {

        header("Location: index.php?error=empty");
        exit();
    }

    // Database connection
    $db = new Database();
    $conn = $db->connect();

    /*
    |--------------------------------------------------------------------------
    | Check Admin Login
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare(
        "SELECT * FROM admin WHERE Email = ?"
    );

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    // Admin found
    if ($admin = $result->fetch_assoc()) {

        // Check password
        if ($password === $admin['Password']) {

            // Store session
            $_SESSION['admin_id'] = $admin['AdminID'];
            $_SESSION['admin_name'] = $admin['Name'];
            $_SESSION['role'] = 'admin';

            // Redirect admin
            header("Location: student_management/admin.php");
            exit();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Check Student Login
    |--------------------------------------------------------------------------
    */

    $stmt = $conn->prepare(
        "SELECT * FROM student WHERE Email = ?"
    );

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    // Student found
    if ($student = $result->fetch_assoc()) {

        // Check password
        if ($password === $student['Password']) {

            // Store session
            $_SESSION['student_id'] = $student['StudentID'];
            $_SESSION['student_name'] = $student['StudentName'];
            $_SESSION['role'] = 'student';

            // Redirect student
           header("Location: student_management/student_dashboard.php");
            exit();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Login Failed
    |--------------------------------------------------------------------------
    */

    header("Location: index.php?error=invalid");
    exit();
}
?>
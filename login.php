<?php

// Enable errors (development only)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database
require_once "database/db.php";

// Start session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    // Capture the role from the hidden input, default to 'student' just in case
    $role = trim($_POST['role'] ?? 'student');

    // Validation
    if (empty($email) || empty($password)) {
        header("Location: index.php?error=empty");
        exit();
    }

    // Whitelist roles to prevent malicious manipulation
    $allowed_roles = ['student', 'teacher', 'admin'];
    if (!in_array($role, $allowed_roles)) {
        header("Location: index.php?error=invalid");
        exit();
    }

    // Determine Table and Columns based on the Role
    $tableName = '';
    $idColumn = '';
    $nameColumn = '';
    $dashboardPath = '';

    if ($role === 'student') {
        $tableName = 'student';
        $idColumn = 'StudentID';
        $nameColumn = 'StudentName';
        $dashboardPath = '01_student_management/student_dashboard.php';
    } elseif ($role === 'teacher') {
        $tableName = 'teacher';
        $idColumn = 'TeacherID';
        $nameColumn = 'TeacherName';
        $dashboardPath = '02_teacher_management/teacher_dashboard.php';
    } elseif ($role === 'admin') {
        $tableName = 'admin';
        $idColumn = 'AdminID';
        $nameColumn = 'Name';
        // ✨ NEW PATH: Point it to the dashboard!
        $dashboardPath = 'admin_dashboard.php';
    }

    // Database connection
    $db = new Database();
    $conn = $db->connect();

    // Query the dynamically selected table
    $sql = "SELECT * FROM `$tableName` WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check User
    if ($user = $result->fetch_assoc()) {

        // Verify Password
        if (password_verify($password, $user['Password'])) {

            // Store Session Data dynamically
            $_SESSION['user_id'] = $user[$idColumn];
            $_SESSION['user_name'] = $user[$nameColumn];
            $_SESSION['role'] = $role;
            if ($role === 'student') {

                $_SESSION['student_id'] = $user['StudentID'];

            } elseif ($role === 'teacher') {

                $_SESSION['teacher_id'] = $user['TeacherID'];

            } elseif ($role === 'admin') {

                $_SESSION['admin_id'] = $user['AdminID'];
            }

            // Redirect to the correct Dashboard
            header("Location: " . $dashboardPath);
            exit();
        }
    }

    // Invalid Login
    header("Location: index.php?error=invalid");
    exit();
}
?>
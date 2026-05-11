<?php

// Enable errors (development only)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database
require_once "database/db.php";

// Start session
session_start();

/*
|--------------------------------------------------------------------------
| Login Form Submit
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if (empty($email) || empty($password)) {

        header("Location: index.php?error=empty");
        exit();
    }

    // Database connection
    $db = new Database();
    $conn = $db->connect();

    /*
    |--------------------------------------------------------------------------
    | Find Student By Email
    |--------------------------------------------------------------------------
    */

    $sql = "SELECT * FROM student WHERE Email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    /*
    |--------------------------------------------------------------------------
    | Check User
    |--------------------------------------------------------------------------
    */

    if ($user = $result->fetch_assoc()) {

        /*
        |--------------------------------------------------------------------------
        | Verify Password
        |--------------------------------------------------------------------------
        */

        if (password_verify($password, $user['Password'])) {

            /*
            |--------------------------------------------------------------------------
            | Store Session
            |--------------------------------------------------------------------------
            */

            $_SESSION['student_id'] = $user['StudentID'];

            $_SESSION['student_name'] = $user['StudentName'];

            $_SESSION['role'] = 'student';

            /*
            |--------------------------------------------------------------------------
            | Redirect Dashboard
            |--------------------------------------------------------------------------
            */

            header(
                "Location: student_management/student_dashboard.php"
            );

            exit();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Invalid Login
    |--------------------------------------------------------------------------
    */

    header("Location: index.php?error=invalid");

    exit();
}
?>
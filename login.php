<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "database/db.php";

session_start();

/*
|--------------------------------------------------------------------------
| CHECK IF FORM IS SUBMITTED
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form data safely
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($username) || empty($password)) {
        echo "Please fill all fields";
        exit();
    }

    /*
    |--------------------------------------------------------------------------
    | DATABASE CONNECTION
    |--------------------------------------------------------------------------
    */
    $db = new Database();
    $conn = $db->connect();

    /*
    |--------------------------------------------------------------------------
    | CHECK USER IN DATABASE
    |--------------------------------------------------------------------------
    */
    $stmt = $conn->prepare("SELECT * FROM student WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    /*
    |--------------------------------------------------------------------------
    | LOGIN VALIDATION
    |--------------------------------------------------------------------------
    */
    if ($user = $result->fetch_assoc()) {

        // TEMP password check (for now)
        // later you will use password_hash()
        if ($password === "1234") {

            // Create session
            $_SESSION['student_id'] = $user['StudentID'];
            $_SESSION['student_name'] = $user['StudentName'];

            // Redirect to dashboard
            header("Location: student_management/index.php");
            exit();
        }
    }

    // If login fails
    echo "Invalid username or password";
}
?>
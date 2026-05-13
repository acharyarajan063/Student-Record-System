<?php
session_start();

require_once '../controllers/StudentController.php';

$controller = new StudentController();

// Temporary student ID
// Later replace with real session login ID
$studentId = $_SESSION['student_id'] ?? 1;

// Get student data
$student = $controller->getStudentById($studentId);

// Check if student exists
if (!$student) {
    die("Student data not found.");
}

$message = "";

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    // Validation
    if (empty($name) || empty($email)) {

        $message = "Name and Email are required.";

    } else {

        $controller->updateProfile(
            $studentId,
            $name,
            $email,
            $phone,
            $password
        );

        $message = "Profile updated successfully.";

        // Refresh updated data
        $student = $controller->getStudentById($studentId);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Update Profile</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family: 'Poppins', sans-serif;
    background: #f1f5f9;
    margin: 0;
    padding: 40px;
}

.container{
    max-width: 700px;
    margin: auto;
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
}

h2{
    margin-bottom: 25px;
    color: #1e293b;
}

.form-group{
    margin-bottom: 20px;
}

label{
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
}

input{
    width: 100%;
    padding: 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 14px;
    box-sizing: border-box;
}

button{
    background: #3b82f6;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 15px;
    font-weight: 500;
}

button:hover{
    background: #2563eb;
}

.message{
    margin-bottom: 20px;
    padding: 12px;
    border-radius: 8px;
    background: #dcfce7;
    color: #166534;
}

</style>
</head>

<body>

<div class="container">

    <h2>Update Profile</h2>

    <?php if(!empty($message)): ?>
        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="form-group">
            <label>Full Name</label>

            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($student['StudentName']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Email</label>

            <input
                type="email"
                name="email"
                value="<?= htmlspecialchars($student['Email']) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label>Phone Number</label>

            <input
                type="text"
                name="phone"
                value="<?= htmlspecialchars($student['Phone'] ?? '') ?>"
            >
        </div>

        <div class="form-group">
            <label>New Password</label>

            <input
                type="password"
                name="password"
                placeholder="Enter new password"
            >
        </div>

        <button type="submit">
            Update Profile
        </button>

    </form>

</div>

</body>
</html>
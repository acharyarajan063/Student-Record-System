<?php
require_once "database/db.php";

$db = new Database();
$conn = $db->connect();

/*
|------------------------------------------------------------
| GET TOTAL COUNTS
|------------------------------------------------------------
*/

$studentCount = 0;
$teacherCount = 0;
$courseCount = 0;

/* Students */

$studentQuery = "SELECT COUNT(*) AS total FROM student";
$studentResult = $conn->query($studentQuery);

if($studentResult && $studentResult->num_rows > 0){

    $studentData = $studentResult->fetch_assoc();
    $studentCount = $studentData['total'];

}

/* Teachers */

$teacherQuery = "SELECT COUNT(*) AS total FROM teacher";
$teacherResult = $conn->query($teacherQuery);

if($teacherResult && $teacherResult->num_rows > 0){

    $teacherData = $teacherResult->fetch_assoc();
    $teacherCount = $teacherData['total'];

}

/* Courses */

$courseQuery = "SELECT COUNT(*) AS total FROM course";
$courseResult = $conn->query($courseQuery);

if($courseResult && $courseResult->num_rows > 0){

    $courseData = $courseResult->fetch_assoc();
    $courseCount = $courseData['total'];

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educare Institute of Technology</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="left">
            <div class="circle top-circle"></div>
            <div class="circle bottom-circle"></div>
            <div class="left-content">
                
                <h1>Welcome<br>Back</h1>
                <p>Sign in to your portal to manage classes, students, attendance, and resources.</p>
                
                <div class="stats">
                    <div class="stat-card">
                        <h2><?= $studentCount ?></h2>
                        <span>Students</span>
                    </div>
                    <div class="stat-card">
                        <h2><?= $teacherCount ?></h2>
                        <span>Teachers</span>
                    </div>
                    <div class="stat-card">
                        <h2><?= $courseCount ?></h2>
                        <span>Courses</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="form-box">
                <h2>Sign In</h2>
                <p class="subtitle">Sign in to manage your classes</p>

                <div class="role-tabs" id="roleTabs">
                    <button type="button" class="tab active" data-role="teacher">Teacher</button>
                    <button type="button" class="tab" data-role="admin">Admin</button>
                    <button type="button" class="tab" data-role="student">Student</button>
                </div>

                <form method="POST" action="login.php">
                    <input type="hidden" name="role" id="selectedRole" value="teacher">

                    <div class="input-group">
                        <label>E-MAIL</label>
                        <input type="email" id="emailInput" name="email" placeholder="teacher@school.com" required>
                    </div>

                    <div class="input-group">
                        <label>PASSWORD</label>
                        <div class="password-box">
                            <input type="password" name="password" id="password" placeholder="Enter your password" required>
                            <span onclick="togglePassword()">👁</span>
                        </div>
                    </div>

                    <div class="forgot-password">
                        <a href="#">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-btn">Sign In</button>
                </form>

                <div class="bottom-text">
                    Need access? <a href="01_student_management/register.php">Register as Student</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- Interactivity for Role Tabs ---
        const tabs = document.querySelectorAll('.tab');
        const emailInput = document.getElementById('emailInput');
        const roleInput = document.getElementById('selectedRole');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');

                // Get the role data attribute
                const role = tab.getAttribute('data-role');
                
                // Update the hidden input for backend submission
                roleInput.value = role;

                // Update the email placeholder to match the role dynamically
                if (role === 'teacher') {
                    emailInput.placeholder = 'teacher@school.com';
                } else if (role === 'admin') {
                    emailInput.placeholder = 'admin@school.com';
                } else {
                    emailInput.placeholder = 'student@school.com';
                }
            });
        });

        // --- Password Visibility Toggle ---
        function togglePassword() {
            const pass = document.getElementById("password");
            if (pass.type === "password") {
                pass.type = "text";
            } else {
                pass.type = "password";
            }
        }
    </script>
</body>
</html>
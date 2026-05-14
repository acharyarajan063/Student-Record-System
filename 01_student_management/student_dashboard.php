<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    header("Location: ../index.php");
    exit();
}

include("../navbar.php");

require_once '../database/db.php';

$db = new Database();

$conn = $db->connect();

/*
|--------------------------------------------------------------------------
| Student Session
|--------------------------------------------------------------------------
*/

$studentID = $_SESSION['user_id'] ?? 0;

/*
|--------------------------------------------------------------------------
| Student Information
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM student
    WHERE StudentID = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $studentID);

$stmt->execute();

$student = $stmt->get_result()->fetch_assoc();

/*
|--------------------------------------------------------------------------
| Total Courses
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT COUNT(*) AS totalCourses
    FROM enrollment
    WHERE StudentID = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $studentID);

$stmt->execute();

$totalCourses =
$stmt->get_result()->fetch_assoc()['totalCourses'];

/*
|--------------------------------------------------------------------------
| Total Attendance
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT COUNT(*) AS totalAttendance
    FROM attendance
    WHERE StudentID = ?
    AND Status = 'Present'
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $studentID);

$stmt->execute();

$totalAttendance =
$stmt->get_result()->fetch_assoc()['totalAttendance'];

/*
|--------------------------------------------------------------------------
| Total Passed Subjects
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT COUNT(*) AS totalPassed
    FROM grade
    WHERE StudentID = ?
    AND isPassed = 1
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $studentID);

$stmt->execute();

$totalPassed =
$stmt->get_result()->fetch_assoc()['totalPassed'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>Student Dashboard</title>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet"
>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:#f1f5f9;
}

.dashboard{

    margin-left:250px;

    padding:40px;

    min-height:100vh;
}

.welcome-card{

    background:
    linear-gradient(135deg,#2563eb,#1d4ed8);

    color:white;

    padding:35px;

    border-radius:24px;

    margin-bottom:35px;

    box-shadow:
    0 10px 25px rgba(37,99,235,0.25);
}

.welcome-card h1{

    font-size:36px;

    margin-bottom:10px;
}

.welcome-card p{

    opacity:0.9;

    font-size:16px;
}

.card-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(240px,1fr));

    gap:25px;

    margin-bottom:40px;
}

.card{

    background:white;

    padding:28px;

    border-radius:22px;

    box-shadow:
    0 6px 20px rgba(0,0,0,0.05);

    transition:0.3s;
}

.card:hover{

    transform:translateY(-5px);
}

.card h3{

    color:#64748b;

    font-size:16px;

    margin-bottom:12px;
}

.card h1{

    color:#1e293b;

    font-size:38px;
}

.quick-links{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(250px,1fr));

    gap:25px;
}

.link-card{

    background:white;

    padding:25px;

    border-radius:20px;

    text-decoration:none;

    color:#1e293b;

    box-shadow:
    0 6px 20px rgba(0,0,0,0.05);

    transition:0.3s;
}

.link-card:hover{

    transform:translateY(-5px);

    background:#eff6ff;
}

.link-card h2{

    margin-bottom:10px;

    font-size:22px;
}

.link-card p{

    color:#64748b;

    font-size:14px;

    line-height:1.6;
}



  @media(max-width:768px){

    .dashboard{

        margin-left:0;

        padding:20px;
    }


    .welcome-card h1{
        font-size:28px;
    }
}

</style>

</head>

<body>
    <?php include '../navbar.php'; ?>

<div class="dashboard">

<!-- Welcome -->

<div class="welcome-card">

<h1>

Welcome,
<?= htmlspecialchars($student['StudentName']) ?>

👋

</h1>

<p>

Manage your academic activities and track your progress.

</p>

</div>

<!-- Statistics -->

<div class="card-grid">

<div class="card">

<h3>Total Courses</h3>

<h1>

<?= $totalCourses ?>

</h1>

</div>

<div class="card">

<h3>Attendance Records</h3>

<h1>

<?= $totalAttendance ?>

</h1>

</div>

<div class="card">

<h3>Passed Subjects</h3>

<h1>

<?= $totalPassed ?>

</h1>

</div>

</div>

<!-- Quick Links -->

<div class="quick-links">

<a
href="../04_Course_management/course_dashboard.php"
class="link-card"
>

<h2>

📚 My Courses

</h2>

<p>

View all enrolled courses and course details.

</p>

</a>

<a
href="../03_Attendance_management/attendance_dashboard.php"
class="link-card"
>

<h2>

🗓 Attendance

</h2>

<p>

Track your attendance records and performance.

</p>

</a>

<a
href="../05_Grade_management/grade_dashboard.php"
class="link-card"
>

<h2>

📊 Grades

</h2>

<p>

View your marks, grades, and academic results.

</p>

</a>

<a
href="student_profile.php"
class="link-card"
>

<h2>

👤 My Profile

</h2>

<p>

Manage your account and personal information.

</p>

</a>

</div>

</div>

</body>

</html>
<?php
session_start();

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'teacher'
) {
    header("Location: ../index.php");
    exit();
}

include("../navbar.php");

require_once '../database/db.php';

$conn = (new Database())->connect();

/*
|--------------------------------------------------------------------------
| Teacher Session
|--------------------------------------------------------------------------
*/

$teacherId = $_SESSION['user_id'] ?? 0;

/*
|--------------------------------------------------------------------------
| Get Teacher Information
|--------------------------------------------------------------------------
*/

$sql = "
SELECT *
FROM teacher
WHERE TeacherID = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $teacherId);

$stmt->execute();

$teacher = $stmt->get_result()->fetch_assoc();

/*
|--------------------------------------------------------------------------
| Get Assigned Courses
|--------------------------------------------------------------------------
*/

$sql = "
SELECT *
FROM course
WHERE TeacherID = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $teacherId);

$stmt->execute();

$courses = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>Teacher Dashboard</title>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet"
>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#f8fafc;
}

.main-content{
    padding:40px;
}

.welcome-card{

    background:
    linear-gradient(135deg,#3b82f6,#1d4ed8);

    color:white;

    padding:35px;

    border-radius:20px;

    margin-bottom:30px;

    box-shadow:
    0 10px 25px rgba(59,130,246,0.25);
}

.welcome-card h1{

    font-size:34px;

    margin-bottom:10px;
}

.welcome-card p{

    opacity:0.9;

    font-size:16px;
}

.section-title{

    margin-bottom:20px;

    color:#1e293b;

    font-size:28px;

    font-weight:700;
}

.course-grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(300px,1fr));

    gap:25px;
}

.course-card{

    background:white;

    padding:25px;

    border-radius:18px;

    box-shadow:
    0 5px 20px rgba(0,0,0,0.06);

    transition:0.3s;
}

.course-card:hover{

    transform:translateY(-5px);
}

.course-code{

    display:inline-block;

    background:#dbeafe;

    color:#1d4ed8;

    padding:6px 12px;

    border-radius:20px;

    font-size:13px;

    font-weight:600;

    margin-bottom:15px;
}

.course-name{

    font-size:24px;

    font-weight:700;

    color:#1e293b;

    margin-bottom:15px;
}

.course-info{

    margin-bottom:10px;

    color:#475569;
}

.badge{

    display:inline-block;

    margin-top:10px;

    padding:6px 12px;

    border-radius:20px;

    font-size:12px;

    font-weight:600;
}

.active{

    background:#dcfce7;

    color:#166534;
}

.inactive{

    background:#fee2e2;

    color:#991b1b;
}

.empty-box{

    background:white;

    padding:40px;

    border-radius:18px;

    text-align:center;

    color:#64748b;

    box-shadow:
    0 5px 20px rgba(0,0,0,0.05);
}

@media(max-width:768px){

    .main-content{
        padding:20px;
    }

    .welcome-card h1{
        font-size:28px;
    }

    .section-title{
        font-size:24px;
    }
}

</style>

</head>

<body>

<?php include '../navbar.php'; ?>

<div class="main-content">

<!-- Welcome -->
<div class="welcome-card">

<h1>

Welcome,
<?= htmlspecialchars($teacher['TeacherName']) ?>

👋

</h1>

<p>

Manage your assigned courses, attendance, and grades.

</p>

</div>

<!-- Courses -->
<h2 class="section-title">

Assigned Courses

</h2>

<?php if($courses->num_rows > 0): ?>

<div class="course-grid">

<?php while($row = $courses->fetch_assoc()): ?>

<div class="course-card">

<div class="course-code">

<?= htmlspecialchars($row['CourseCode']) ?>

</div>

<div class="course-name">

<?= htmlspecialchars($row['CourseName']) ?>

</div>

<div class="course-info">

<strong>Credit Points:</strong>

<?= htmlspecialchars($row['CreditPoints']) ?>

</div>

<div class="course-info">

<strong>Start Date:</strong>

<?= htmlspecialchars($row['StartDate']) ?>

</div>

<span class="badge <?= $row['IsActive'] ? 'active' : 'inactive' ?>">

<?= $row['IsActive'] ? 'Active' : 'Inactive' ?>

</span>

</div>

<?php endwhile; ?>

</div>

<?php else: ?>

<div class="empty-box">

No assigned courses found.

</div>

<?php endif; ?>

</div>

</body>

</html>
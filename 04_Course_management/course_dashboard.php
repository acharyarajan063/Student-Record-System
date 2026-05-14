<?php

session_start();

require_once '../database/db.php';

$conn = (new Database())->connect();

/*
|--------------------------------------------------------------------------
| Get Student ID
|--------------------------------------------------------------------------
*/

$studentId = $_SESSION['student_id'] ?? 0;

/*
|--------------------------------------------------------------------------
| Get Student Courses
|--------------------------------------------------------------------------
|
| This assumes:
| enrollment table exists
| student enrolled in courses
|
*/

$sql = "
SELECT
    course.CourseName,
    course.CourseCode,
    course.CreditPoints,
    course.StartDate,
    teacher.TeacherName
FROM enrollment
INNER JOIN course
    ON enrollment.CourseID = course.CourseID
LEFT JOIN teacher
    ON course.TeacherID = teacher.TeacherID
WHERE enrollment.StudentID = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $studentId);

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

<title>My Courses</title>

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

.page-title{

    margin-bottom:30px;
}

.page-title h2{

    font-size:32px;

    color:#1e293b;

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

    border-radius:18px;

    padding:25px;

    box-shadow:
    0 5px 20px rgba(0,0,0,0.06);

    transition:0.3s;
}

.course-card:hover{

    transform:translateY(-5px);
}

.course-code{

    display:inline-block;

    background:#eef2ff;

    color:#4338ca;

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

    margin-bottom:18px;
}

.course-info{

    margin-bottom:12px;

    color:#475569;

    font-size:15px;
}

.course-info strong{

    color:#0f172a;
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

    .page-title h2{
        font-size:26px;
    }
}

</style>

</head>

<body>

<?php include '../student_navbar.php'; ?>

<div class="main-content">

<div class="page-title">

<h2>My Courses</h2>

</div>

<?php if ($courses->num_rows > 0): ?>

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

<strong>Teacher:</strong>

<?= htmlspecialchars($row['TeacherName']) ?>

</div>

<div class="course-info">

<strong>Start Date:</strong>

<?= htmlspecialchars($row['StartDate']) ?>

</div>

</div>

<?php endwhile; ?>

</div>

<?php else: ?>

<div class="empty-box">

No enrolled courses found.

</div>

<?php endif; ?>

</div>

</body>

</html>
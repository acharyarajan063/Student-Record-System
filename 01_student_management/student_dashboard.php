<?php
session_start();

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'student'
) {
    header("Location: ../index.php");
    exit();
}

include("../navbar.php");
require_once("../database/db.php");

$db = new Database();
$conn = $db->connect();

$student_id = $_SESSION['student_id'];

/*
|------------------------------------------------------------------
| GET STUDENT DETAILS
|------------------------------------------------------------------
*/

$sql = "SELECT * FROM student WHERE StudentID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();

$result = $stmt->get_result();
$student = $result->fetch_assoc();

/*
|------------------------------------------------------------------
| DUMMY DATA
|------------------------------------------------------------------
*/

$totalCourses = 5;
$attendance = "92%";
$currentGrade = "A";
$pendingAssignments = 3;

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

        .main-content{
            padding:40px;
        }

        /* ================================================== */
        /* HERO */
        /* ================================================== */

        .hero{
            background:linear-gradient(135deg,#2563eb,#1d4ed8);
            color:white;
            padding:40px;
            border-radius:25px;
            margin-bottom:30px;
            box-shadow:0 10px 25px rgba(37,99,235,0.2);
        }

        .hero h1{
            font-size:42px;
            margin-bottom:10px;
        }

        .hero p{
            font-size:17px;
            opacity:0.95;
        }

        /* ================================================== */
        /* STATS */
        /* ================================================== */

        .stats-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            margin-bottom:30px;
        }

        .stat-card{
            background:white;
            padding:30px;
            border-radius:20px;
            box-shadow:0 4px 12px rgba(0,0,0,0.05);
            transition:0.3s;
        }

        .stat-card:hover{
            transform:translateY(-5px);
        }

        .stat-card h3{
            font-size:15px;
            color:#64748b;
            margin-bottom:15px;
        }

        .stat-card h1{
            font-size:40px;
            color:#1e293b;
        }

        /* ================================================== */
        /* GRID */
        /* ================================================== */

        .dashboard-grid{
            display:grid;
            grid-template-columns:2fr 1fr;
            gap:25px;
        }

        .card{
            background:white;
            padding:30px;
            border-radius:20px;
            box-shadow:0 4px 12px rgba(0,0,0,0.05);
        }

        .card h2{
            margin-bottom:20px;
            color:#1e293b;
        }

        /* ================================================== */
        /* TABLE */
        /* ================================================== */

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#1e293b;
            color:white;
            padding:15px;
            text-align:left;
        }

        td{
            padding:15px;
            border-bottom:1px solid #e2e8f0;
            color:#475569;
        }

        /* ================================================== */
        /* COURSE CARD */
        /* ================================================== */

        .course-card{
            border:1px solid #e2e8f0;
            border-radius:15px;
            padding:20px;
            margin-bottom:15px;
        }

        .course-code{
            display:inline-block;
            background:#dbeafe;
            color:#2563eb;
            padding:6px 14px;
            border-radius:30px;
            font-size:13px;
            font-weight:600;
            margin-bottom:12px;
        }

        .course-card h3{
            color:#1e293b;
            margin-bottom:10px;
        }

        .course-card p{
            color:#64748b;
            margin-bottom:6px;
        }

        /* ================================================== */
        /* PROFILE */
        /* ================================================== */

        .profile-info p{
            margin-bottom:12px;
            color:#475569;
        }

        .profile-info strong{
            color:#1e293b;
        }

        /* ================================================== */
        /* QUICK BUTTONS */
        /* ================================================== */

        .quick-actions{
            display:flex;
            flex-direction:column;
            gap:15px;
        }

        .quick-btn{
            display:block;
            text-align:center;
            background:#2563eb;
            color:white;
            padding:14px;
            border-radius:12px;
            text-decoration:none;
            font-weight:600;
            transition:0.3s;
        }

        .quick-btn:hover{
            background:#1d4ed8;
        }

        /* ================================================== */
        /* NOTIFICATIONS */
        /* ================================================== */

        .notification{
            background:#f8fafc;
            padding:15px;
            border-radius:12px;
            margin-bottom:12px;
            border-left:5px solid #2563eb;
        }

        .notification p{
            color:#334155;
            font-size:14px;
        }

        @media(max-width:900px){

            .dashboard-grid{
                grid-template-columns:1fr;
            }

            .hero h1{
                font-size:30px;
            }

        }

    </style>

</head>

<body>

<div class="main-content">

    <!-- HERO -->

    <div class="hero">

        <h1>

            Welcome,
            <?= htmlspecialchars($student['StudentName']) ?> 👋

        </h1>

        <p>

            Track your courses, attendance, grades, and academic progress.

        </p>

    </div>

    <!-- STATS -->

    <div class="stats-grid">

        <div class="stat-card">

            <h3>Total Courses</h3>

            <h1><?= $totalCourses ?></h1>

        </div>

        <div class="stat-card">

            <h3>Attendance</h3>

            <h1><?= $attendance ?></h1>

        </div>

        <div class="stat-card">

            <h3>Current Grade</h3>

            <h1><?= $currentGrade ?></h1>

        </div>

        <div class="stat-card">

            <h3>Assignments</h3>

            <h1><?= $pendingAssignments ?></h1>

        </div>

    </div>

    <!-- GRID -->

    <div class="dashboard-grid">

        <!-- LEFT -->

        <div>

            <!-- CLASS SCHEDULE -->

            <div class="card" style="margin-bottom:25px;">

                <h2>Today's Schedule</h2>

                <table>

                    <tr>

                        <th>Time</th>
                        <th>Course</th>
                        <th>Room</th>

                    </tr>

                    <tr>

                        <td>09:00 AM</td>
                        <td>Programming</td>
                        <td>A-201</td>

                    </tr>

                    <tr>

                        <td>12:00 PM</td>
                        <td>Database Systems</td>
                        <td>B-105</td>

                    </tr>

                    <tr>

                        <td>03:00 PM</td>
                        <td>Networking</td>
                        <td>C-302</td>

                    </tr>

                </table>

            </div>

            <!-- ENROLLED COURSES -->

            <div class="card">

                <h2>Enrolled Courses</h2>

                <div class="course-card">

                    <span class="course-code">

                        CS101

                    </span>

                    <h3>

                        Introduction to Programming

                    </h3>

                    <p>

                        <strong>Credits:</strong> 10

                    </p>

                    <p>

                        <strong>Semester:</strong> Fall 2026

                    </p>

                </div>

                <div class="course-card">

                    <span class="course-code">

                        DB202

                    </span>

                    <h3>

                        Database Systems

                    </h3>

                    <p>

                        <strong>Credits:</strong> 5

                    </p>

                    <p>

                        <strong>Semester:</strong> Fall 2026

                    </p>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div>

            <!-- PROFILE -->

            <div class="card" style="margin-bottom:25px;">

                <h2>Student Profile</h2>

                <div class="profile-info">

                    <p>

                        <strong>ID:</strong>

                        <?= $student['StudentID'] ?>

                    </p>

                    <p>

                        <strong>Name:</strong>

                        <?= htmlspecialchars($student['StudentName']) ?>

                    </p>

                    <p>

                        <strong>Email:</strong>

                        <?= htmlspecialchars($student['Email']) ?>

                    </p>

                    <p>

                        <strong>Level:</strong>

                        <?= htmlspecialchars($student['Level']) ?>

                    </p>

                    <p>

                        <strong>Status:</strong>

                        <?= $student['IsActive'] ? 'Active' : 'Inactive' ?>

                    </p>

                </div>

            </div>

            <!-- QUICK ACTIONS -->

            <div class="card" style="margin-bottom:25px;">

                <h2>Quick Actions</h2>

                <div class="quick-actions">

                    <a href="../04_course_management/course_dashboard.php" class="quick-btn">

                        View Courses

                    </a>

                    <a href="../03_Attendance_management/attendance_dashboard.php" class="quick-btn">

                        Check Attendance

                    </a>

                    <a href="../05_Grade_management/grade_dashboard.php" class="quick-btn">

                        View Grades

                    </a>

                </div>

            </div>

            <!-- NOTIFICATIONS -->

            <div class="card">

                <h2>Notifications</h2>

                <div class="notification">

                    <p>

                        Assignment submission closes tomorrow.

                    </p>

                </div>

                <div class="notification">

                    <p>

                        Your attendance is above 90%.

                    </p>

                </div>

                <div class="notification">

                    <p>

                        Midterm exams start next week.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
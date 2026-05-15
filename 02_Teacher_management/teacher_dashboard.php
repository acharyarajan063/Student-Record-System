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
require_once("../database/db.php");

$db = new Database();
$conn = $db->connect();

$teacher_id = $_SESSION['teacher_id'];

/*
|--------------------------------------------------------------------------
| GET TEACHER DETAILS
|--------------------------------------------------------------------------
*/

$sql = "SELECT * FROM teacher WHERE TeacherID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();

$result = $stmt->get_result();
$teacher = $result->fetch_assoc();

/*
|--------------------------------------------------------------------------
| DUMMY DATA
|--------------------------------------------------------------------------
*/

$totalCourses = 4;
$totalStudents = 120;
$pendingGrades = 18;
$todayClasses = 3;
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
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

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
            margin-bottom:30px;
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
        /* COURSES */
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
        /* QUICK ACTIONS */
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
            <?= htmlspecialchars($teacher['TeacherName']) ?> 👋

        </h1>

        <p>

            Manage your courses, attendance, schedules, and grades professionally.

        </p>

    </div>

    <!-- STATS -->

    <div class="stats-grid">

        <div class="stat-card">

            <h3>Total Courses</h3>

            <h1><?= $totalCourses ?></h1>

        </div>

        <div class="stat-card">

            <h3>Total Students</h3>

            <h1><?= $totalStudents ?></h1>

        </div>

        <div class="stat-card">

            <h3>Pending Grades</h3>

            <h1><?= $pendingGrades ?></h1>

        </div>

        <div class="stat-card">

            <h3>Today's Classes</h3>

            <h1><?= $todayClasses ?></h1>

        </div>

    </div>

    <!-- GRID -->

    <div class="dashboard-grid">

        <!-- LEFT -->

        <div>

            <!-- SCHEDULE -->

            <div class="card" style="margin-bottom:25px;">

                <h2>Weekly Teaching Schedule</h2>

                <table>

                    <tr>

                        <th>Day</th>
                        <th>Time</th>
                        <th>Course</th>
                        <th>Room</th>

                    </tr>

                    <tr>

                        <td>Monday</td>
                        <td>09:00 - 11:00</td>
                        <td>Programming</td>
                        <td>A-201</td>

                    </tr>

                    <tr>

                        <td>Tuesday</td>
                        <td>13:00 - 15:00</td>
                        <td>Database Systems</td>
                        <td>B-105</td>

                    </tr>

                    <tr>

                        <td>Thursday</td>
                        <td>10:00 - 12:00</td>
                        <td>Networking</td>
                        <td>C-302</td>

                    </tr>

                </table>

            </div>

            <!-- COURSES -->

            <div class="card">

                <h2>Assigned Courses</h2>

                <div class="course-card">

                    <span class="course-code">

                        CS101

                    </span>

                    <h3>

                        Introduction to Programming

                    </h3>

                    <p>

                        <strong>Students:</strong> 45

                    </p>

                    <p>

                        <strong>Semester:</strong> Fall 2026

                    </p>

                    <p>

                        <strong>Credits:</strong> 10

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

                        <strong>Students:</strong> 38

                    </p>

                    <p>

                        <strong>Semester:</strong> Fall 2026

                    </p>

                    <p>

                        <strong>Credits:</strong> 5

                    </p>

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div>

            <!-- PROFILE -->

            <div class="card" style="margin-bottom:25px;">

                <h2>Teacher Profile</h2>

                <div class="profile-info">

                    <p>

                        <strong>ID:</strong>

                        <?= $teacher['TeacherID'] ?>

                    </p>

                    <p>

                        <strong>Name:</strong>

                        <?= htmlspecialchars($teacher['TeacherName']) ?>

                    </p>

                    <p>

                        <strong>Email:</strong>

                        <?= htmlspecialchars($teacher['Email']) ?>

                    </p>

                    <p>

                        <strong>Department:</strong>

                        <?php

                            $department = $teacher['Department'];

                            if($department == 'IT'){
                                echo 'Information Technology';
                            }
                            elseif($department == 'Business'){
                                echo 'Business Management';
                            }
                            elseif($department == 'Networking'){
                                echo 'Computer Networking';
                            }
                            elseif($department == 'Data Science'){
                                echo 'Data Science & Analytics';
                            }
                            elseif($department == 'Software Eng'){
                                echo 'Software Engineering';
                            }
                            else{
                                echo htmlspecialchars($department);
                            }

                        ?>

                    </p>

                    <p>

                        <strong>Date Joined:</strong>

                        <?= htmlspecialchars($teacher['DateJoined']) ?>

                    </p>

                    <p>

                        <strong>Status:</strong>

                        <?= $teacher['IsActive'] ? 'Active' : 'Inactive' ?>

                    </p>

                </div>

            </div>

            <!-- QUICK ACTIONS -->

            <div class="card" style="margin-bottom:25px;">

                <h2>Quick Actions</h2>

                <div class="quick-actions">

                    <a href="#" class="quick-btn">

                        Mark Attendance

                    </a>

                    <a href="#" class="quick-btn">

                        Upload Grades

                    </a>

                    <a href="#" class="quick-btn">

                        View Students

                    </a>

                    <a href="#" class="quick-btn">

                        Course Materials

                    </a>

                </div>

            </div>

            <!-- NOTIFICATIONS -->

            <div class="card">

                <h2>Notifications</h2>

                <div class="notification">

                    <p>

                        Midterm grade submission deadline is Friday.

                    </p>

                </div>

                <div class="notification">

                    <p>

                        3 students were absent consecutively in CS101.

                    </p>

                </div>

                <div class="notification">

                    <p>

                        New teaching material uploaded for Database Systems.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
<?php

session_start();

require_once '../database/db.php';

// Get logged in student ID
$studentId = $_SESSION['student_id'] ?? 1;

// Database connection
$conn = (new Database())->connect();

/*
|--------------------------------------------------------------------------
| Get Student Information
|--------------------------------------------------------------------------
*/

$sql = "SELECT * FROM student WHERE StudentID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentId);
$stmt->execute();

$student = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            background:#f4f7fb;
            display:flex;
            min-height:100vh;
        }

        /*
        |--------------------------------------------------------------------------
        | Sidebar
        |--------------------------------------------------------------------------
        */

        .sidebar{
            width:260px;
            background:linear-gradient(180deg,#4f46e5,#ff00cc);
            color:white;
            padding:30px 20px;
            position:fixed;
            top:0;
            left:0;
            bottom:0;
            box-shadow:0 0 20px rgba(0,0,0,0.15);
        }

        .sidebar h2{
            font-size:28px;
            margin-bottom:40px;
            font-weight:700;
        }

        .menu{
            display:flex;
            flex-direction:column;
            gap:18px;
        }

        .menu a{
            text-decoration:none;
            color:white;
            padding:14px 18px;
            border-radius:12px;
            transition:0.3s;
            font-weight:500;
        }

        .menu a:hover{
            background:rgba(255,255,255,0.15);
        }

        .logout{
            margin-top:40px;
            background:#ffffff;
            color:#4f46e5 !important;
            text-align:center;
            font-weight:600;
        }

        .logout:hover{
            background:#f3f3f3 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | Main Content
        |--------------------------------------------------------------------------
        */

        .main{
            margin-left:260px;
            width:100%;
            padding:40px;
        }

        /*
        |--------------------------------------------------------------------------
        | Top Bar
        |--------------------------------------------------------------------------
        */

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:35px;
        }

        .topbar h1{
            font-size:40px;
            color:#1e293b;
        }

        .topbar span{
            color:#4f46e5;
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Cards
        |--------------------------------------------------------------------------
        */

        .dashboard-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
            gap:25px;
        }

        .card{
            background:white;
            border-radius:20px;
            padding:28px;
            box-shadow:0 4px 15px rgba(0,0,0,0.08);
            transition:0.3s;
        }

        .card:hover{
            transform:translateY(-4px);
        }

        .card h2{
            margin-bottom:20px;
            color:#1e293b;
            font-size:24px;
        }

        .info p{
            margin-bottom:14px;
            color:#475569;
            font-size:15px;
        }

        .info strong{
            color:#0f172a;
        }

        /*
        |--------------------------------------------------------------------------
        | Status Badge
        |--------------------------------------------------------------------------
        */

        .badge{
            display:inline-block;
            padding:6px 14px;
            border-radius:20px;
            font-size:13px;
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

        /*
        |--------------------------------------------------------------------------
        | Course Cards
        |--------------------------------------------------------------------------
        */

        .course-box{
            background:#f8fafc;
            border-left:5px solid #4f46e5;
            padding:15px;
            border-radius:12px;
            margin-bottom:15px;
        }

        .course-box h3{
            color:#1e293b;
            margin-bottom:6px;
        }

        .course-box p{
            color:#64748b;
            font-size:14px;
        }

        /*
        |--------------------------------------------------------------------------
        | Grade Cards
        |--------------------------------------------------------------------------
        */

        .grade-item{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:14px 0;
            border-bottom:1px solid #e2e8f0;
        }

        .grade{
            background:#4f46e5;
            color:white;
            padding:6px 12px;
            border-radius:10px;
            font-size:14px;
            font-weight:600;
        }

        /*
        |--------------------------------------------------------------------------
        | Attendance Bar
        |--------------------------------------------------------------------------
        */

        .progress{
            background:#e2e8f0;
            border-radius:20px;
            overflow:hidden;
            height:22px;
            margin-top:18px;
        }

        .progress-bar{
            height:100%;
            width:85%;
            background:linear-gradient(90deg,#4f46e5,#ff00cc);
            text-align:center;
            color:white;
            font-size:13px;
            line-height:22px;
            font-weight:600;
        }

    </style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>🎓 Student</h2>

    <div class="menu">

        <a href="#">🏠 Dashboard</a>

        <a href="#">📚 My Courses</a>

        <a href="#">📊 Grades</a>

        <a href="#">📅 Attendance</a>

        <a href="../logout.php" class="logout">Logout</a>

    </div>

</div>

<!-- MAIN CONTENT -->
<div class="main">

    <!-- Top Bar -->
    <div class="topbar">

        <h1>
            Welcome,
            <span>
                <?= htmlspecialchars($student['StudentName']) ?>
            </span>
            👋
        </h1>

    </div>

    <!-- Dashboard Grid -->
    <div class="dashboard-grid">

        <!-- Student Info -->
        <div class="card">

            <h2>Student Information</h2>

            <div class="info">

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

                    <span class="badge <?= $student['IsActive'] ? 'active' : 'inactive' ?>">

                        <?= $student['IsActive'] ? 'Active' : 'Inactive' ?>

                    </span>

                </p>

            </div>

        </div>

        <!-- Courses -->
        <div class="card">

            <h2>My Courses</h2>

            <div class="course-box">
                <h3>Web Development</h3>
                <p>CTEC 2201</p>
            </div>

            <div class="course-box">
                <h3>Database Systems</h3>
                <p>CTEC 2202</p>
            </div>

            <div class="course-box">
                <h3>Software Engineering</h3>
                <p>CTEC 2203</p>
            </div>

        </div>

        <!-- Grades -->
        <div class="card">

            <h2>My Grades</h2>

            <div class="grade-item">
                <span>Web Development</span>
                <span class="grade">A</span>
            </div>

            <div class="grade-item">
                <span>Database Systems</span>
                <span class="grade">B+</span>
            </div>

            <div class="grade-item">
                <span>Software Engineering</span>
                <span class="grade">A-</span>
            </div>

        </div>

        <!-- Attendance -->
        <div class="card">

            <h2>Attendance</h2>

            <p>
                Your current attendance is excellent.
            </p>

            <div class="progress">

                <div class="progress-bar">
                    85%
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
<?php
session_start();

// Redirect if not logged in as a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../index.php");
    exit();
}

require_once '../database/db.php';

// Get logged in student ID using the updated session variable
$studentId = $_SESSION['user_id'];

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

// Extra safety check in case the database record was deleted
if (!$student) {
    die("Error: Student profile not found in database.");
}

/*
|--------------------------------------------------------------------------
| Get Student Courses
|--------------------------------------------------------------------------
*/
$sqlCourses = "
    SELECT c.CourseName, c.CourseCode
    FROM enrollment e
    JOIN course c ON e.CourseID = c.CourseID
    WHERE e.StudentID = ?
";
$stmtCourses = $conn->prepare($sqlCourses);
$stmtCourses->bind_param("i", $studentId);
$stmtCourses->execute();
$courses = $stmtCourses->get_result();

/*
|--------------------------------------------------------------------------
| Get Student Grades
|--------------------------------------------------------------------------
*/
$sqlGrades = "
    SELECT c.CourseName, g.Marks, g.GradeLetter
    FROM grade g
    JOIN course c ON g.CourseID = c.CourseID
    WHERE g.StudentID = ?
";
$stmtGrades = $conn->prepare($sqlGrades);
$stmtGrades->bind_param("i", $studentId);
$stmtGrades->execute();
$grades = $stmtGrades->get_result();

/*
|--------------------------------------------------------------------------
| Get Attendance Statistics
|--------------------------------------------------------------------------
*/
$sqlAttendance = "
    SELECT
        COUNT(*) AS totalClasses,
        SUM(CASE WHEN Status = 'Present' THEN 1 ELSE 0 END) AS presentClasses
    FROM attendance
    WHERE StudentID = ?
";
$stmtAttendance = $conn->prepare($sqlAttendance);
$stmtAttendance->bind_param("i", $studentId);
$stmtAttendance->execute();
$attendance = $stmtAttendance->get_result()->fetch_assoc();

$totalClasses = $attendance['totalClasses'] ?? 0;
$presentClasses = $attendance['presentClasses'] ?? 0;
$attendancePercent = 0;

if ($totalClasses > 0) {
    $attendancePercent = round(($presentClasses / $totalClasses) * 100);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - EduCare</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8fafc; /* Matches admin background */
            color: #334155;
            padding-left: 250px; /* Makes room for the sidebar */
            min-height: 100vh;
        }

        /*
        |--------------------------------------------------------------------------
        | Sidebar (Matching Admin Style)
        |--------------------------------------------------------------------------
        */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #2c3e50; /* Admin dark blue */
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
            color: white;
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }

        .sidebar .nav-brand {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 50px;
            text-align: center;
        }

        .sidebar .nav-links {
            display: flex;
            flex-direction: column;
            list-style: none;
            gap: 15px;
        }

        .sidebar .nav-links a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar .nav-links a:hover,
        .sidebar .nav-links a.active {
            background-color: #3b82f6; /* Blue highlight */
            color: white;
        }

        .sidebar .nav-profile {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            border-top: 1px solid #3f546a;
            padding-top: 25px;
        }

        .sidebar .logout-btn {
            background-color: #ef4444;
            color: white;
            text-decoration: none;
            padding: 10px 0;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            width: 100%;
            transition: 0.3s;
        }

        .sidebar .logout-btn:hover {
            background-color: #dc2626;
        }

        /*
        |--------------------------------------------------------------------------
        | Main Content
        |--------------------------------------------------------------------------
        */
        .main-content {
            padding: 40px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
        }

        .page-header p {
            color: #64748b;
            font-size: 15px;
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Cards Grid
        |--------------------------------------------------------------------------
        */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-top: 4px solid #3b82f6;
        }

        /* Give specific cards different border colors */
        .card.courses-card { border-top-color: #10b981; }
        .card.grades-card { border-top-color: #f59e0b; }
        .card.attendance-card { border-top-color: #8b5cf6; }

        .card h2 {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Card Content Styling */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child { border-bottom: none; }
        
        .info-label { color: #64748b; font-weight: 500; font-size: 14px; }
        .info-value { color: #0f172a; font-weight: 600; font-size: 14px; }

        /* Badge */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .active { background: #d1fae5; color: #065f46; }
        .inactive { background: #fee2e2; color: #991b1b; }

        /* Lists */
        .course-item, .grade-item {
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .course-item:last-child, .grade-item:last-child { border-bottom: none; }
        
        .course-title { font-weight: 600; color: #1e293b; font-size: 15px; }
        .course-code { font-size: 13px; color: #64748b; }

        .grade-pill {
            background: #3b82f6;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            float: right;
        }

        /* Progress Bar */
        .progress-wrapper {
            background: #e2e8f0;
            border-radius: 20px;
            height: 12px;
            overflow: hidden;
            margin-top: 15px;
        }
        .progress-fill {
            height: 100%;
            background: #8b5cf6;
            border-radius: 20px;
        }
        .attendance-text {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #475569;
            margin-top: 10px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <div class="nav-brand">🎓 Student</div>
        <ul class="nav-links">
            <li><a href="#" class="active">Dashboard</a></li>
            <li><a href="#">My Courses</a></li>
            <li><a href="#">Grades</a></li>
            <li><a href="#">Attendance</a></li>
            <li><a href="edit_profile.php">Update Profile</a></li>
        </ul>
        <div class="nav-profile">
            <a href="../logout.php" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="main-content">

        <div class="page-header">
            <h1>Welcome, <?= htmlspecialchars($student['StudentName']) ?> 👋</h1>
            <p>Here is an overview of your academic progress.</p>
        </div>

        <div class="dashboard-grid">

            <div class="card">
                <h2>Student Information</h2>
                <div class="info-row">
                    <span class="info-label">Name</span>
                    <span class="info-value"><?= htmlspecialchars($student['StudentName']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value"><?= htmlspecialchars($student['Email']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Level</span>
                    <span class="info-value"><?= htmlspecialchars($student['Level']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="badge <?= $student['IsActive'] ? 'active' : 'inactive' ?>">
                        <?= $student['IsActive'] ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
            </div>

            <div class="card courses-card">
                <h2>My Courses</h2>
                <?php if ($courses->num_rows > 0): ?>
                    <?php while ($course = $courses->fetch_assoc()): ?>
                        <div class="course-item">
                            <div class="course-title"><?= htmlspecialchars($course['CourseName']) ?></div>
                            <div class="course-code"><?= htmlspecialchars($course['CourseCode']) ?></div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="color: #64748b; font-size: 14px;">You are not enrolled in any courses.</p>
                <?php endif; ?>
            </div>

            <div class="card grades-card">
                <h2>Recent Grades</h2>
                <?php if ($grades->num_rows > 0): ?>
                    <?php while ($grade = $grades->fetch_assoc()): ?>
                        <div class="grade-item">
                            <span class="grade-pill"><?= htmlspecialchars($grade['GradeLetter']) ?></span>
                            <div class="course-title"><?= htmlspecialchars($grade['CourseName']) ?></div>
                            <div class="course-code">Marks: <?= htmlspecialchars($grade['Marks']) ?></div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p style="color: #64748b; font-size: 14px;">No grades posted yet.</p>
                <?php endif; ?>
            </div>

            <div class="card attendance-card">
                <h2>Attendance Overview</h2>
                <div class="progress-wrapper">
                    <div class="progress-fill" style="width: <?= $attendancePercent ?>%;"></div>
                </div>
                <div class="attendance-text">
                    <span>Present: <?= $presentClasses ?> / <?= $totalClasses ?></span>
                    <span style="color: #0f172a; font-weight: 700;"><?= $attendancePercent ?>%</span>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
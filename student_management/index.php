<?php
session_start();

if (!isset($_SESSION['student_id'])) {
   header("Location: /Student-Record-System/login.php");
    exit();
}

require_once "../controllers/StudentController.php";

$controller = new StudentController();

$studentId = $_SESSION['student_id'];
$StudentName = $_SESSION['student_name'];

$student = $controller->edit($studentId);
$courses = $controller->getCourses($studentId);
$grades = $controller->getGrades($studentId);
$attendance = $controller->getAttendanceStats($studentId);

$total = $attendance['total'] ?? 0;
$present = $attendance['present'] ?? 0;

$attendancePercent = $total > 0 
    ? round(($present / $total) * 100) 
    : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>

    <div class="dashboard">

        <!-- SIDEBAR -->
        <div class="sidebar">
            <div class="logo">🎓 Student</div>
            <ul>
                <li class="active">🏠 Dashboard</li>
            </ul>
        </div>

        <!-- MAIN -->
        <div class="main">

            <!-- TOP -->
            <div class="top-bar">
                <h1>
                    Welcome back,
                    <span style="color:#6366f1;">
                        <?= htmlspecialchars($StudentName) ?>
                    </span> 👋
                </h1>
            </div>

            <h3>📚 My Courses</h3>

            <?php while ($row = $courses->fetch_assoc()): ?>
                <div>
                    <div class="card-container">
                        <?php while ($row = $courses->fetch_assoc()): ?>
                            <div class="card">
                                <h3><?= $row['CourseName'] ?></h3>
                                <p><?= $row['CourseCode'] ?></p>

                                <div class="actions">
                                    <a href="#">View</a>
                                    <a href="#">Drop</a>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    </div>

                <?php endwhile; ?>
                <h3>📊 My Grades</h3>

                <div class="card-container">
                    <?php while ($g = $grades->fetch_assoc()): ?>
                        <div class="card">
                            <h3>
                                <?= htmlspecialchars($g['CourseName']) ?>
                            </h3>
                            <p>Marks:
                                <?= htmlspecialchars($g['Marks']) ?>
                            </p>

                            <!-- Badge uses CSS classes: .badge.A / .badge.B / .badge.C -->
                            <span class="badge <?= htmlspecialchars($g['GradeLetter']) ?>">
                                <?= htmlspecialchars($g['GradeLetter']) ?>
                            </span>
                        </div>


                    <?php endwhile; ?>
                </div>
                <h3>📅 My Attendance</h3>

                <div class="card-container">
                    <div class="card">
                        <h3>Attendance</h3>
                        <p>Total Classes: <?= $total ?></p>
                        <p>Present: <?= $present ?></p>

                        <span class="badge">
                            <?= $attendancePercent ?>%
                        </span>
                    </div>
                </div>


            </div>


        </div>

    </div>

</body>

</html>
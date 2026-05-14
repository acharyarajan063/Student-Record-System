<?php
session_start();

if (
    !isset($_SESSION['role']) ||
    $_SESSION['role'] != 'admin'
) {
    header("Location: ../index.php");
    exit();
}

include("../navbar.php");


require_once '../controllers/EnrollmentController.php';
require_once '../database/db.php';

$controller = new EnrollmentController();

$enrollments = $controller->index();

$db = new Database();
$conn = $db->connect();

// Students
$students = $conn->query(
    "SELECT * FROM student"
);

// Courses
$courses = $conn->query(
    "SELECT * FROM course"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Enrollment Management</title>

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

        h2{
            margin-bottom:30px;
            color:#1e293b;
        }

        .card{
            background:white;
            padding:30px;
            border-radius:15px;
            margin-bottom:30px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        form{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
        }

        select,
        input{
            padding:12px;
            border:1px solid #cbd5e1;
            border-radius:10px;
            min-width:220px;
        }

        button{
            background:#3b82f6;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:10px;
            cursor:pointer;
        }

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
        }

        .delete-btn{
            background:#ef4444;
            color:white;
            padding:8px 12px;
            text-decoration:none;
            border-radius:8px;
        }

    </style>

</head>

<body>

<?php include '../navbar.php'; ?>

<div class="main-content">

    <h2>Enrollment Management</h2>

    <div class="card">

        <form
            action="store.php"
            method="POST"
        >

            <select name="student_id" required>

                <option value="">
                    Select Student
                </option>

                <?php while($student = $students->fetch_assoc()): ?>

                    <option value="<?= $student['StudentID'] ?>">

                        <?= $student['StudentName'] ?>

                    </option>

                <?php endwhile; ?>

            </select>

            <select name="course_id" required>

                <option value="">
                    Select Course
                </option>

                <?php while($course = $courses->fetch_assoc()): ?>

                    <option value="<?= $course['CourseID'] ?>">

                        <?= $course['CourseName'] ?>

                    </option>

                <?php endwhile; ?>

            </select>

            <input
                type="date"
                name="date"
                required
            >

            <button type="submit">

                Enroll Student

            </button>

        </form>

    </div>

    <div class="card">

        <table>

            <tr>

                <th>ID</th>
                <th>Student</th>
                <th>Course</th>
                <th>Date</th>
                <th>Action</th>

            </tr>

            <?php while($row = $enrollments->fetch_assoc()): ?>

            <tr>

                <td><?= $row['EnrollmentID'] ?></td>

                <td><?= $row['StudentName'] ?></td>

                <td><?= $row['CourseName'] ?></td>

                <td><?= $row['EnrollmentDate'] ?></td>

                <td>

                    <a
                        class="delete-btn"
                        href="delete.php?id=<?= $row['EnrollmentID'] ?>"
                    >
                        Delete
                    </a>

                </td>

            </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>
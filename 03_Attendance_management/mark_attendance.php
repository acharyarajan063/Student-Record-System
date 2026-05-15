
<?php
session_start();

if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] != 'teacher' && $_SESSION['role'] != 'admin')
) {
    header("Location: ../index.php");
    exit();
}

require_once '../database/db.php';
include('../navbar.php');

$db = new Database();
$conn = $db->connect();

/*
|--------------------------------------------------------------------------
| GET STUDENTS
|--------------------------------------------------------------------------
*/

$sql = "SELECT * FROM student WHERE IsActive = 1";
$result = $conn->query($sql);

/*
|--------------------------------------------------------------------------
| SAVE ATTENDANCE
|--------------------------------------------------------------------------
*/

if(isset($_POST['save_attendance'])){

    $date = date('Y-m-d');
    $recordedBy = $_SESSION['user_name'];

    foreach($_POST['attendance'] as $studentId => $status){

        $course = $_POST['course'][$studentId];
        $excused = 0;

        $insert = "INSERT INTO attendance
        (StudentID, CourseName, AttendanceDate, Status, RecordedBy, IsExcused)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insert);

        $stmt->bind_param(
            "issssi",
            $studentId,
            $course,
            $date,
            $status,
            $recordedBy,
            $excused
        );

        $stmt->execute();
    }

    header("Location: attendance_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Mark Attendance</title>

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
            background:#f8fafc;
        }

        .main-content{
            padding:40px;
        }

        .page-title{
            font-size:40px;
            color:#1e293b;
            margin-bottom:30px;
            font-weight:700;
        }

        .card{
            background:white;
            border-radius:20px;
            padding:30px;
            box-shadow:0 8px 20px rgba(0,0,0,0.06);
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#1e293b;
            color:white;
            padding:16px;
            text-align:left;
        }

        td{
            padding:16px;
            border-bottom:1px solid #e2e8f0;
        }

        select{
            width:100%;
            padding:10px;
            border:1px solid #cbd5e1;
            border-radius:10px;
        }

        .submit-btn{
            margin-top:25px;
            background:#2563eb;
            color:white;
            border:none;
            padding:14px 24px;
            border-radius:12px;
            font-size:15px;
            font-weight:600;
            cursor:pointer;
            transition:0.3s;
        }

        .submit-btn:hover{
            background:#1d4ed8;
        }

        @media(max-width:768px){

            .card{
                overflow-x:auto;
            }

            table{
                min-width:900px;
            }
        }

    </style>

</head>

<body>

<div class="main-content">

    <h1 class="page-title">
        Mark Attendance
    </h1>

    <div class="card">

        <form method="POST">

            <table>

                <tr>

                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Status</th>

                </tr>

                <?php while($row = $result->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= $row['StudentID'] ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['StudentName']) ?>
                        </td>

                        <td>

                            <select
                                name="course[<?= $row['StudentID'] ?>]"
                                required
                            >

                                <option value="Introduction to Programming">
                                    Introduction to Programming
                                </option>

                                <option value="Database Systems">
                                    Database Systems
                                </option>

                                <option value="Computer Networks">
                                    Computer Networks
                                </option>

                            </select>

                        </td>

                        <td>

                            <select
                                name="attendance[<?= $row['StudentID'] ?>]"
                                required
                            >

                                <option value="Present">
                                    Present
                                </option>

                                <option value="Absent">
                                    Absent
                                </option>

                                <option value="Late">
                                    Late
                                </option>

                            </select>

                        </td>

                    </tr>

                <?php endwhile; ?>

            </table>

            <button
                type="submit"
                name="save_attendance"
                class="submit-btn"
            >

                Save Attendance

            </button>

        </form>

    </div>

</div>

</body>
</html>

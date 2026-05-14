<?php

require_once '../controllers/AttendanceController.php';
require_once '../database/db.php';

$controller = new AttendanceController();

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

$attendance = $controller->edit($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = [

        'attendanceID' => $id,
        'studentID' => $_POST['studentID'],
        'courseID' => $_POST['courseID'],
        'attendanceDate' => $_POST['attendanceDate'],
        'status' => $_POST['status'],
        'recordedBy' => $_POST['recordedBy'],
        'isExcused' => $_POST['isExcused']

    ];

    $controller->update($data);

    header("Location: attendance_admin.php");

    exit();
}

$students = $conn->query("SELECT * FROM student");

$courses = $conn->query("SELECT * FROM course");

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Attendance</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

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
            margin-left:250px;
            padding:40px;
        }

        .form-container{
            max-width:700px;
            background:white;
            padding:35px;
            border-radius:20px;
            box-shadow:0 8px 20px rgba(0,0,0,0.08);
        }

        h1{
            margin-bottom:30px;
            color:#1e293b;
        }

        .form-group{
            margin-bottom:20px;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-weight:600;
            color:#334155;
        }

        input,
        select{
            width:100%;
            padding:14px;
            border:1px solid #cbd5e1;
            border-radius:10px;
            outline:none;
            font-size:15px;
        }

        input:focus,
        select:focus{
            border-color:#2563eb;
        }

        button{
            background:#2563eb;
            color:white;
            border:none;
            padding:14px 22px;
            border-radius:10px;
            font-size:15px;
            font-weight:600;
            cursor:pointer;
        }

        button:hover{
            background:#1d4ed8;
        }

    </style>

</head>

<body>

<?php include '../navbar.php'; ?>

<div class="main-content">

    <div class="form-container">

        <h1>Edit Attendance</h1>

        <form method="POST">

            <div class="form-group">

                <label>Student</label>

                <select name="studentID" required>

                    <?php while($student = $students->fetch_assoc()): ?>

                        <option value="<?= $student['StudentID'] ?>"
                        
                        <?= ($student['StudentID'] == $attendance['StudentID']) ? 'selected' : '' ?>>

                            <?= $student['StudentName'] ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="form-group">

                <label>Course</label>

                <select name="courseID" required>

                    <?php while($course = $courses->fetch_assoc()): ?>

                        <option value="<?= $course['CourseID'] ?>"
                        
                        <?= ($course['CourseID'] == $attendance['CourseID']) ? 'selected' : '' ?>>

                            <?= $course['CourseName'] ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="form-group">

                <label>Date</label>

                <input type="date"
                       name="attendanceDate"
                       value="<?= $attendance['AttendanceDate'] ?>"
                       required>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select name="status">

                    <option value="Present"
                    
                    <?= ($attendance['Status'] == 'Present') ? 'selected' : '' ?>>

                        Present

                    </option>

                    <option value="Absent"
                    
                    <?= ($attendance['Status'] == 'Absent') ? 'selected' : '' ?>>

                        Absent

                    </option>

                    <option value="Late"
                    
                    <?= ($attendance['Status'] == 'Late') ? 'selected' : '' ?>>

                        Late

                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Recorded By</label>

                <input type="text"
                       name="recordedBy"
                       value="<?= $attendance['RecordedBy'] ?>"
                       required>

            </div>

            <div class="form-group">

                <label>Excused</label>

                <select name="isExcused">

                    <option value="0"
                    
                    <?= ($attendance['IsExcused'] == 0) ? 'selected' : '' ?>>

                        No

                    </option>

                    <option value="1"
                    
                    <?= ($attendance['IsExcused'] == 1) ? 'selected' : '' ?>>

                        Yes

                    </option>

                </select>

            </div>

            <button type="submit">

                Update Attendance

            </button>

        </form>

    </div>

</div>

</body>
</html>
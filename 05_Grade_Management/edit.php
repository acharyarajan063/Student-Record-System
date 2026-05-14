<?php

require_once '../controllers/Grade_Controller.php';
require_once '../database/db.php';

$controller = new GradeController();

$db = new Database();
$conn = $db->connect();

$id = $_GET['id'];

$grade = $controller->edit($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = [

        'gradeID' => $id,
        'studentID' => $_POST['studentID'],
        'courseID' => $_POST['courseID'],
        'marks' => $_POST['marks'],
        'gradeLetter' => $_POST['gradeLetter'],
        'isPassed' => $_POST['isPassed']

    ];

    $controller->update($data);

    header("Location: grade_admin.php");

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

    <title>Edit Grade</title>

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

    </style>

</head>

<body>

<?php include '../navbar.php'; ?>

<div class="main-content">

    <div class="form-container">

        <h1>Edit Grade</h1>

        <form method="POST">

            <div class="form-group">

                <label>Student</label>

                <select name="studentID">

                    <?php while($student = $students->fetch_assoc()): ?>

                        <option value="<?= $student['StudentID'] ?>"
                        
                        <?= ($student['StudentID'] == $grade['StudentID']) ? 'selected' : '' ?>>

                            <?= $student['StudentName'] ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="form-group">

                <label>Course</label>

                <select name="courseID">

                    <?php while($course = $courses->fetch_assoc()): ?>

                        <option value="<?= $course['CourseID'] ?>"
                        
                        <?= ($course['CourseID'] == $grade['CourseID']) ? 'selected' : '' ?>>

                            <?= $course['CourseName'] ?>

                        </option>

                    <?php endwhile; ?>

                </select>

            </div>

            <div class="form-group">

                <label>Marks</label>

                <input type="number"
                       step="0.01"
                       name="marks"
                       value="<?= $grade['Marks'] ?>">

            </div>

            <div class="form-group">

                <label>Grade Letter</label>

                <input type="text"
                       name="gradeLetter"
                       value="<?= $grade['GradeLetter'] ?>">

            </div>

            <div class="form-group">

                <label>Pass Status</label>

                <select name="isPassed">

                    <option value="1"
                    
                    <?= ($grade['isPassed'] == 1) ? 'selected' : '' ?>>

                        Passed

                    </option>

                    <option value="0"
                    
                    <?= ($grade['isPassed'] == 0) ? 'selected' : '' ?>>

                        Failed

                    </option>

                </select>

            </div>

            <button type="submit">

                Update Grade

            </button>

        </form>

    </div>

</div>

</body>
</html>
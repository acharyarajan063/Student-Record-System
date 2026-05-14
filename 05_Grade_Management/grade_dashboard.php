<?php

session_start();

require_once '../database/db.php';

$db = new Database();

$conn = $db->connect();

/*
|--------------------------------------------------------------------------
| Get Logged In Student
|--------------------------------------------------------------------------
*/

$studentID = $_SESSION['user_id'] ?? 0;

/*
|--------------------------------------------------------------------------
| Fetch Grades
|--------------------------------------------------------------------------
*/

$sql = "

    SELECT

        grade.*,
        course.CourseName

    FROM grade

    INNER JOIN course
    ON grade.CourseID = course.CourseID

    WHERE grade.StudentID = ?

    ORDER BY grade.DateRecorded DESC

";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $studentID);

$stmt->execute();

$grades = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Grades</title>

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
            background:#f1f5f9;
        }

        .dashboard{
            max-width:1200px;
            margin:auto;
            padding:40px 20px;
        }

        .top-section{
            margin-bottom:30px;
        }

        .top-section h1{
            font-size:34px;
            color:#1e293b;
            margin-bottom:10px;
        }

        .top-section p{
            color:#64748b;
            font-size:15px;
        }

        .card-container{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            margin-bottom:30px;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:20px;
            box-shadow:0 6px 20px rgba(0,0,0,0.05);
        }

        .card h2{
            font-size:16px;
            color:#64748b;
            margin-bottom:10px;
        }

        .card h1{
            font-size:34px;
            color:#2563eb;
        }

        .table-container{
            background:white;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 6px 20px rgba(0,0,0,0.05);
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#2563eb;
            color:white;
            padding:16px;
            text-align:left;
            font-size:14px;
        }

        td{
            padding:16px;
            border-bottom:1px solid #e2e8f0;
            font-size:14px;
            color:#334155;
        }

        tr:hover{
            background:#f8fafc;
        }

        .pass{
            color:#16a34a;
            font-weight:600;
        }

        .fail{
            color:#dc2626;
            font-weight:600;
        }

        @media(max-width:768px){

            .dashboard{
                padding:20px;
            }

            table{
                min-width:700px;
            }

            .table-container{
                overflow-x:auto;
            }
        }

    </style>

</head>

<body>
    <?php include '../navbar.php'; ?>

<div class="dashboard">

    <div class="top-section">

        <h1>

            My Grades

        </h1>

        <p>

            View all your course grades and academic performance.

        </p>

    </div>

    <div class="card-container">

        <div class="card">

            <h2>Total Subjects</h2>

            <h1>

                <?= $grades->num_rows ?>

            </h1>

        </div>

    </div>

    <div class="table-container">

        <table>

            <tr>

                <th>Course</th>
                <th>Marks</th>
                <th>Grade</th>
                <th>Status</th>
                <th>Date</th>

            </tr>

            <?php while($row = $grades->fetch_assoc()): ?>

                <tr>

                    <td>

                        <?= htmlspecialchars($row['CourseName']) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($row['Marks']) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($row['GradeLetter']) ?>

                    </td>

                    <td>

                        <span class="<?= $row['isPassed'] ? 'pass' : 'fail' ?>">

                            <?= $row['isPassed'] ? 'Passed' : 'Failed' ?>

                        </span>

                    </td>

                    <td>

                        <?= htmlspecialchars($row['DateRecorded']) ?>

                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

    </div>

</div>

</body>
</html>
<?php

require_once '../controllers/AttendanceController.php';

$controller = new AttendanceController();

$attendance = $controller->index();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Attendance Management</title>

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
            padding:40px;
            margin-left:250px;
        }

        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .top-bar h1{
            font-size:32px;
            color:#1e293b;
        }

        .add-btn{
            background:#2563eb;
            color:white;
            text-decoration:none;
            padding:12px 20px;
            border-radius:10px;
            font-weight:600;
            transition:0.3s;
        }

        .add-btn:hover{
            background:#1d4ed8;
        }

        .table-container{
            background:white;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 8px 20px rgba(0,0,0,0.08);
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

        .status{
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:600;
        }

        .present{
            background:#dcfce7;
            color:#166534;
        }

        .absent{
            background:#fee2e2;
            color:#991b1b;
        }

        .late{
            background:#fef3c7;
            color:#92400e;
        }

        .action-btn{
            padding:7px 12px;
            border-radius:8px;
            text-decoration:none;
            color:white;
            font-size:13px;
            font-weight:500;
            margin-right:5px;
        }

        .edit-btn{
            background:#0ea5e9;
        }

        .delete-btn{
            background:#ef4444;
        }

        .edit-btn:hover{
            background:#0284c7;
        }

        .delete-btn:hover{
            background:#dc2626;
        }

    </style>

</head>

<body>

<?php include '../navbar.php'; ?>

<div class="main-content">

    <div class="top-bar">

        <h1>Attendance Management</h1>

        <a href="add.php" class="add-btn">

            + Add Attendance

        </a>

    </div>

    <div class="table-container">

        <table>

            <tr>

                <th>ID</th>
                <th>Student</th>
                <th>Course</th>
                <th>Date</th>
                <th>Status</th>
                <th>Recorded By</th>
                <th>Excused</th>
                <th>Actions</th>

            </tr>

            <?php while($row = $attendance->fetch_assoc()): ?>

                <tr>

                    <td>

                        <?= $row['AttendanceID'] ?>

                    </td>

                    <td>

                        <?= $row['StudentName'] ?>

                    </td>

                    <td>

                        <?= $row['CourseName'] ?>

                    </td>

                    <td>

                        <?= $row['AttendanceDate'] ?>

                    </td>

                    <td>

                        <span class="status <?= strtolower($row['Status']) ?>">

                            <?= $row['Status'] ?>

                        </span>

                    </td>

                    <td>

                        <?= $row['RecordedBy'] ?>

                    </td>

                    <td>

                        <?= $row['IsExcused'] ? 'Yes' : 'No' ?>

                    </td>

                    <td>

                        <a href="edit.php?id=<?= $row['AttendanceID'] ?>"
                           class="action-btn edit-btn">

                            Edit

                        </a>

                        <a href="delete.php?id=<?= $row['AttendanceID'] ?>"
                           class="action-btn delete-btn"
                           onclick="return confirm('Delete this attendance?')">

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
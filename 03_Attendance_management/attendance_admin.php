
<?php
require_once '../controllers/AttendanceController.php';

$controller = new AttendanceController();

// Get attendance records
$attendance = $controller->index();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management - EduCare</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        .main-content {
            padding: 40px;
            background-color: #f8fafc;
            min-height: 100vh;
            color: #334155;
            box-sizing: border-box;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .mark-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #10b981;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);
        }

        .mark-btn:hover {
            background: #059669;
        }

        .filter-form {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            align-items: center;
        }

        .filter-form input,
        .filter-form select {
            padding: 10px 15px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            outline: none;
            min-width: 200px;
        }

        .filter-form input:focus,
        .filter-form select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-form button {
            background: #2c3e50;
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: 0.3s;
            font-family: inherit;
        }

        .filter-form button:hover {
            background: #1e293b;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #2c3e50;
            color: white;
            padding: 16px;
            text-align: left;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #e2e8f0;
            color: #475569;
            font-size: 14px;
        }

        tr:hover {
            background: #f8fafc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .present {
            background: #d1fae5;
            color: #065f46;
        }

        .absent {
            background: #fee2e2;
            color: #991b1b;
        }

        .late {
            background: #fef3c7;
            color: #92400e;
        }

    </style>
</head>

<body>

<?php include '../navbar.php'; ?>

<div class="main-content">

    <div class="page-header">
        <h2>Attendance Management</h2>

        <a href="mark_attendance.php" class="mark-btn">
            ➕ Mark Attendance
        </a>
    </div>

    <form method="GET" class="filter-form">

        <input
            type="text"
            name="search"
            placeholder="Search student..."
        >

        <input
            type="date"
            name="date"
        >

        <select name="status">
            <option value="">All Status</option>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
            <option value="Late">Late</option>
        </select>

        <button type="submit">
            Apply Filter
        </button>

    </form>

    <div class="table-container">

        <table>

            <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Date</th>
                <th>Status</th>
            </tr>

            <?php if ($attendance && $attendance->num_rows > 0): ?>

                <?php while ($row = $attendance->fetch_assoc()): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($row['AttendanceID']) ?>
                        </td>

                        <td>
                            <strong>
                                <?= htmlspecialchars($row['StudentName']) ?>
                            </strong>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['AttendanceDate']) ?>
                        </td>

                        <td>

                            <span class="badge 
                                <?= strtolower($row['Status']) ?>">

                                <?= htmlspecialchars($row['Status']) ?>

                            </span>

                        </td>

                    </tr>

                <?php endwhile; ?>

            <?php else: ?>

                <tr>
                    <td colspan="4" style="text-align:center; padding:40px; color:#64748b;">
                        No attendance records found.
                    </td>
                </tr>

            <?php endif; ?>

        </table>

    </div>

</div>

</body>
</html>



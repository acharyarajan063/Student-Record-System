<?php

session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit();
}

include("../navbar.php");

// Include Student Controller
require_once '../controllers/StudentController.php';

// Create controller object
$controller = new StudentController();

// Get search value from URL
$search = $_GET['search'] ?? '';

// Get level filter value from URL
$level = $_GET['level'] ?? '';

/*
|--------------------------------------------------------------------------
| Search + Filter Logic
|--------------------------------------------------------------------------
*/
if (!empty($search) && !empty($level)) {
    $student = $controller->searchAndFilter($search, $level);
} elseif (!empty($search)) {
    $student = $controller->search($search);
} elseif (!empty($level)) {
    $student = $controller->filterByLevel($level);
} else {
    $student = $controller->index();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management - EduCare</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Main Content Container */
        .main-content {
            padding: 40px;
            background-color: #f8fafc; /* Matches dashboard background */
            min-height: 100vh;
            color: #334155;
            box-sizing: border-box;
        }

        /* Header Layout */
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

        /* Buttons */
        .add-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #10b981; /* Green button */
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);
        }

        .add-btn:hover { background: #059669; }

        /* Search Form */
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

        .filter-form button:hover { background: #1e293b; }

        /* Table Card Container */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* Table Design */
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

        tr:hover { background: #f8fafc; }
        tr:last-child td { border-bottom: none; }

        /* Action Buttons inside Table */
        .edit-btn, .delete-btn {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            margin-right: 8px;
            display: inline-block;
            transition: 0.2s;
        }

        .edit-btn { background: #3b82f6; color: white; }
        .edit-btn:hover { background: #2563eb; }

        .delete-btn { background: #ef4444; color: white; }
        .delete-btn:hover { background: #dc2626; }

        /* Status Badge */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .active { background: #d1fae5; color: #065f46; }
        .inactive { background: #fee2e2; color: #991b1b; }
    </style>
</head>

<body>

    <?php include '../navbar.php'; ?>

    <div class="main-content">
        
        <div class="page-header">
            <h2>Student Management</h2>
            <a href="add.php" class="add-btn">➕ Add New Student</a>
        </div>

        <form method="GET" class="filter-form">
            <input type="text" name="search" placeholder="Search student..." value="<?= htmlspecialchars($search) ?>">
            
            <select name="level">
                <option value="">All Levels</option>
                <option value="Year 1" <?= ($level == 'Year 1') ? 'selected' : '' ?>>Year 1</option>
                <option value="Year 2" <?= ($level == 'Year 2') ? 'selected' : '' ?>>Year 2</option>
                <option value="Year 3" <?= ($level == 'Year 3') ? 'selected' : '' ?>>Year 3</option>
            </select>
            
            <button type="submit">Apply Filter</button>
        </form>

        <div class="table-container">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Student Name</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>

                <?php if ($student->num_rows > 0): ?>
                    <?php while ($row = $student->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['StudentID']) ?></td>
                            <td><strong><?= htmlspecialchars($row['StudentName']) ?></strong></td>
                            <td><?= htmlspecialchars($row['Email']) ?></td>
                            <td><?= htmlspecialchars($row['Level']) ?></td>
                            <td>
                                <span class="badge <?= $row['IsActive'] ? 'active' : 'inactive' ?>">
                                    <?= $row['IsActive'] ? 'Active' : 'Inactive' ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $row['StudentID'] ?>" class="edit-btn">Edit</a>
                                <a href="delete.php?id=<?= $row['StudentID'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center; padding: 40px; color: #64748b;">
                            No students found matching your criteria.
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

    </div>

</body>
</html>
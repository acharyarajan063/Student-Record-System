<?php
// Include Course Controller
require_once '../controllers/CourseController.php';

// Create controller object
$controller = new CourseController();

// Get search value from URL
$search = $_GET['search'] ?? '';

// Get filter value from URL
$isActive = $_GET['isActive'] ?? '';

if (!empty($search) && $isActive !== '') {
    $courses = $controller->searchAndFilter($search, $isActive);
} elseif (!empty($search)) {
    $courses = $controller->search($search);
} elseif ($isActive !== '') {
    $courses = $controller->filterByStatus($isActive);
} else {
    $courses = $controller->index();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
            background: #f4f4f4;
        }
        h2 { color: #2c3e50; }
        .add-btn {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 0.6rem 1.2rem;
            background: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        form { margin-bottom: 1rem; }
        input, select, button { padding: 0.5rem; margin-right: 0.5rem; }
        button {
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th {
            background: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td { padding: 12px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f1f1f1; }
        .edit-btn {
            background: #3498db;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 6px;
        }
        .delete-btn {
            background: #e74c3c;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 13px; }
        .active { background: #d4edda; color: #155724; }
        .inactive { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

    <h2>Course Management</h2>

    <a href="add.php" class="add-btn">➕ Add New Course</a>

    <!-- Search + Filter Form -->
    <form method="GET">
        <input type="text" name="search" 
        placeholder="Search course..." 
        value="<?= htmlspecialchars($search) ?>">

        <select name="isActive">
            <option value="">All Status</option>
            <option value="1" <?= ($isActive == '1') ? 'selected' : '' ?>>Active</option>
            <option value="0" <?= ($isActive == '0') ? 'selected' : '' ?>>Inactive</option>
        </select>

        <button type="submit">Apply</button>
    </form>

    <!-- Course Table -->
    <table>
        <tr>
            <th>ID</th>
            <th>Course Name</th>
            <th>Course Code</th>
            <th>Credit Points</th>
            <th>Start Date</th>
            <th>Teacher ID</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php if ($courses->num_rows > 0): ?>
            <?php while ($row = $courses->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['CourseID']) ?></td>
                    <td><?= htmlspecialchars($row['CourseName']) ?></td>
                    <td><?= htmlspecialchars($row['CourseCode']) ?></td>
                    <td><?= htmlspecialchars($row['CreditPoints']) ?></td>
                    <td><?= htmlspecialchars($row['StartDate']) ?></td>
                    <td><?= htmlspecialchars($row['TeacherID']) ?></td>
                    <td>
                        <span class="badge <?= $row['IsActive'] ? 'active' : 'inactive' ?>">
                            <?= $row['IsActive'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $row['CourseID'] ?>" class="edit-btn">Edit</a>
                        <a href="delete.php?id=<?= $row['CourseID'] ?>" class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this course?')">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align:center;">No courses found.</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>
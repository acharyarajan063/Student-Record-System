<?php
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
| If both search and level exist:
| -> search + filter together
|
| If only search exists:
| -> search students
|
| If only level exists:
| -> filter students
|
| Else:
| -> show all students
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

    <title>Student Management</title>

    <!-- CSS Styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
            background: #f4f4f4;
        }

        h2 {
            color: #2c3e50;
        }

        /* Add Button */
        .add-btn {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 0.6rem 1.2rem;
            background: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Search Form */
        form {
            margin-bottom: 1rem;
        }

        input,
        select,
        button {
            padding: 0.5rem;
            margin-right: 0.5rem;
        }

        button {
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Table Design */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th {
            background: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f1f1f1;
        }

        /* Action Buttons */
        .edit-btn {
            background: #3498db;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Status Badge */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 13px;
        }

        .active {
            background: #d4edda;
            color: #155724;
        }

        .inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .edit-btn {
            background: #3498db;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 6px;
        }
    </style>

</head>

<body>

    <!-- Page Title -->
    <h2>Student Management</h2>

    <!-- Add Student Button -->
    <a href="add.php" class="add-btn">
        ➕ Add New Student
    </a>

    <!-- Search + Filter Form -->
    <form method="GET">

        <!-- Search Input -->
        <input type="text" name="search" placeholder="Search student..." value="<?= htmlspecialchars($search) ?>">

        <!-- Filter Dropdown -->
        <select name="level">

            <option value="">All Levels</option>

            <option value="Year 1" <?= ($level == 'Year 1') ? 'selected' : '' ?>>
                Year 1
            </option>

            <option value="Year 2" <?= ($level == 'Year 2') ? 'selected' : '' ?>>
                Year 2
            </option>

            <option value="Year 3" <?= ($level == 'Year 3') ? 'selected' : '' ?>>
                Year 3
            </option>

        </select>

        <!-- Submit Button -->
        <button type="submit">Apply</button>

    </form>

    <!-- Student Table -->
    <table>

        <!-- Table Header -->
        <tr>

            <th>ID</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Level</th>
            <th>Status</th>
            <th>Actions</th>

        </tr>

        <!-- Check if students exist -->
        <?php if ($student->num_rows > 0): ?>

            <!-- Loop Through Students -->
            <?php while ($row = $student->fetch_assoc()): ?>

                <tr>

                    <!-- Student ID -->
                    <td>
                        <?= htmlspecialchars($row['StudentID']) ?>
                    </td>

                    <!-- Student Name -->
                    <td>
                        <?= htmlspecialchars($row['StudentName']) ?>
                    </td>

                    <!-- Email -->
                    <td>
                        <?= htmlspecialchars($row['Email']) ?>
                    </td>

                    <!-- Level -->
                    <td>
                        <?= htmlspecialchars($row['Level']) ?>
                    </td>

                    <!-- Status -->
                    <td>

                        <span class="badge <?= $row['IsActive'] ? 'active' : 'inactive' ?>">

                            <?= $row['IsActive'] ? 'Active' : 'Inactive' ?>

                        </span>

                    </td>

                    <!-- Actions -->
                    <td>

                        <!-- Edit -->
                        <a href="edit.php?id=<?= $row['StudentID'] ?>" class="edit-btn">
                            Edit
                        </a>

                        <!-- Delete -->
                        <a href="delete.php?id=<?= $row['StudentID'] ?>" class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this student?')">
                            Delete
                        </a>

                    </td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <!-- No Students Found -->
            <tr>

                <td colspan="6" style="text-align:center;">

                    No students found.

                </td>

            </tr>

        <?php endif; ?>

    </table>

</body>

</html>
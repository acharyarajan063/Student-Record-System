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
<html>

<head>

    <title>Student Management</title>

    <!-- CSS File -->
    <link rel="stylesheet" href="student.css">

</head>

<body>

    <!-- Page Heading -->
    <h2>Student Management</h2>

    <!-- Add Student Button -->
    <a href="add.php" style="display:inline-block; margin-bottom:20px;">
        ➕ Add New Student
    </a>

    <!-- Search + Filter Form -->
    <form method="GET" style="margin-bottom:20px;">

        <!-- Search Input -->
        <input type="text"
               name="search"
               placeholder="Search student..."
               value="<?= htmlspecialchars($search) ?>">

        <!-- Level Filter -->
        <select name="level">

            <option value="">All Levels</option>

            <option value="Year 1"
                <?= ($level == 'Year 1') ? 'selected' : '' ?>>
                Year 1
            </option>

            <option value="Year 2"
                <?= ($level == 'Year 2') ? 'selected' : '' ?>>
                Year 2
            </option>

            <option value="Year 3"
                <?= ($level == 'Year 3') ? 'selected' : '' ?>>
                Year 3
            </option>

        </select>

        <!-- Submit Button -->
        <button type="submit">Apply</button>

    </form>

    <!-- Student Table -->
    <table border="1" cellpadding="10" cellspacing="0" width="100%">

        <!-- Table Header -->
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Level</th>
            <th>Actions</th>
        </tr>

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

                <!-- Student Email -->
                <td>
                    <?= htmlspecialchars($row['Email']) ?>
                </td>

                <!-- Student Level -->
                <td>
                    <?= htmlspecialchars($row['Level']) ?>
                </td>

                <!-- Action Buttons -->
                <td>

                    <!-- Edit Button -->
                    <a href="edit.php?id=<?= $row['StudentID'] ?>">
                        Edit
                    </a>

                    |

                    <!-- Delete Button -->
                    <a href="delete.php?id=<?= $row['StudentID'] ?>"
                       onclick="return confirm('Are you sure you want to delete this student?')">
                        Delete
                    </a>

                </td>

            </tr>

        <?php endwhile; ?>

    </table>

</body>

</html>
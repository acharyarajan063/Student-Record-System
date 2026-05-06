<?php
require_once '../controllers/StudentController.php';

$controller = new StudentController();
if (isset($_GET['search'])) {

    $student = $controller->search($_GET['search']);

} else {

    $students = $controller->index();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student List</title>
    <link rel="stylesheet" href="student.css">
</head>

<body>

    <h2>Student List</h2>
    <a href="add.php" style="display:inline-block; margin-bottom:20px;">
        ➕ Add New Student
    </a>
    <form method="GET">

        <input type="text" name="search" placeholder="Search student...">

        <button type="submit">Search</button>

    </form>
    <div class="card-container">

        <?php while ($row = $student->fetch_assoc()): ?>

            <div class="card">
                <h3><?= htmlspecialchars($row['StudentName']) ?></h3>
                <p>Email: <?= htmlspecialchars($row['Email']) ?></p>
                <p>Level: <?= htmlspecialchars($row['Level']) ?></p>

                <div class="actions">
                    <a href="edit.php?id=<?= $row['StudentID'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $row['StudentID'] ?>">Delete</a>
                </div>
            </div>

        <?php endwhile; ?>

    </div>
</body>

</html>
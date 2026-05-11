<?php
// index.php - display all courses

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'student_record_system';

$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

$result = $mysqli->query('SELECT * FROM course ORDER BY CourseID ASC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; background: #f4f4f4; }
        h2 { color: #2c3e50; }
        .card-container { display: flex; flex-wrap: wrap; gap: 1rem; margin-top: 1rem; }
        .card { background: white; border-radius: 8px; padding: 1.2rem; width: 280px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .card h3 { margin: 0 0 0.5rem; color: #2c3e50; }
        .card p { margin: 0.3rem 0; color: #555; font-size: 0.9rem; }
        .actions { margin-top: 1rem; display: flex; gap: 0.5rem; }
        .actions a { padding: 0.4rem 0.8rem; border-radius: 4px; text-decoration: none; font-size: 0.85rem; }
        .edit { background: #3498db; color: white; }
        .delete { background: #e74c3c; color: white; }
        .add-btn { display: inline-block; margin-bottom: 1rem; padding: 0.6rem 1.2rem; background: #27ae60; color: white; text-decoration: none; border-radius: 5px; }
        .badge { display: inline-block; padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem; }
        .active { background: #d4edda; color: #155724; }
        .inactive { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

    <h2>Course Management</h2>
    <a href="add.php" class="add-btn">➕ Add New Course</a>

    <div class="card-container">

        <?php while ($row = $result->fetch_assoc()): ?>

            <div class="card">
                <h3><?= htmlspecialchars($row['CourseName']) ?></h3>
                <p><strong>Code:</strong> <?= htmlspecialchars($row['CourseCode']) ?></p>
                <p><strong>Credits:</strong> <?= htmlspecialchars($row['CreditPoints']) ?></p>
                <p><strong>Start Date:</strong> <?= htmlspecialchars($row['StartDate']) ?></p>
                <p><strong>Teacher ID:</strong> <?= htmlspecialchars($row['TeacherID']) ?></p>
                <p><strong>Status:</strong> 
                    <span class="badge <?= $row['IsActive'] ? 'active' : 'inactive' ?>">
                        <?= $row['IsActive'] ? 'Active' : 'Inactive' ?>
                    </span>
                </p>
                <div class="actions">
                    <a href="edit.php?id=<?= $row['CourseID'] ?>" class="edit">Edit</a>
                    <a href="delete.php?id=<?= $row['CourseID'] ?>" class="delete">Delete</a>
                </div>
            </div>

        <?php endwhile; ?>

    </div>

</body>
</html>
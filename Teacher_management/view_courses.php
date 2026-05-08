<?php
require_once("../models/teacher.php");

$teacher = new Teacher();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id      = (int) $_GET['id'];
$row     = $teacher->getById($id);
$courses = $teacher->getAssignedCourses($id);

if (!$row) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigned Courses</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="teacher.css">
</head>

<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
        <div class="left-content">
            <h1><?php echo htmlspecialchars($row['TeacherName']); ?></h1>
            <p><?php echo htmlspecialchars($row['Department']); ?></p>
            <span><?php echo htmlspecialchars($row['Email']); ?></span>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <div class="form-box">

            <h2>Assigned Courses</h2>

            <?php if ($courses->num_rows === 0): ?>
                <p style="color:#94a3b8; text-align:center; margin-top: 20px;">
                    No courses assigned to this teacher yet.
                </p>
            <?php else: ?>
                <table>
                    <tr>
                        <th>Course Name</th>
                        <th>Code</th>
                        <th>Credits</th>
                        <th>Start Date</th>
                    </tr>
                    <?php while ($course = $courses->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['CourseName']); ?></td>
                        <td><?php echo htmlspecialchars($course['CourseCode']); ?></td>
                        <td><?php echo $course['CreditPoints']; ?></td>
                        <td><?php echo $course['StartDate']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            <?php endif; ?>

            <p style="margin-top: 20px; text-align: center;">
                <a href="index.php">← Back to Teacher List</a>
            </p>

        </div>
    </div>

</div>

</body>
</html>

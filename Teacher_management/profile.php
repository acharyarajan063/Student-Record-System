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
    <title>Teacher Profile</title>
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
            <span><?php echo $row['IsActive'] ? 'Active' : 'Inactive'; ?></span>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <div class="form-box">

            <h2>Personal Profile</h2>

            <table class="profile-table">
                <tr>
                    <th>Teacher ID</th>
                    <td><?php echo $row['TeacherID']; ?></td>
                </tr>
                <tr>
                    <th>Full Name</th>
                    <td><?php echo htmlspecialchars($row['TeacherName']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td><?php echo htmlspecialchars($row['Department']); ?></td>
                </tr>
                <tr>
                    <th>Date Joined</th>
                    <td><?php echo $row['DateJoined']; ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <?php if ($row['IsActive']): ?>
                            <span class="badge badge-active">Active</span>
                        <?php else: ?>
                            <span class="badge badge-inactive">Inactive</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>

            <hr>

            <h2>Assigned Courses</h2>

            <?php if ($courses->num_rows === 0): ?>
                <p style="color:#94a3b8; text-align:center; margin-top:15px;">
                    No courses assigned yet.
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

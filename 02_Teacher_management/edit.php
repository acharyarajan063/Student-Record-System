<?php
require_once("../models/teacher.php");

$teacher = new Teacher();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET['id'];
$row = $teacher->getById($id);

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
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="teacher.css">
</head>

<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
        <div class="left-content">
            <h1>Edit Teacher</h1>
            <p>Update teacher details</p>
            <span>Make changes and save</span>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <div class="form-box">

            <h2>Edit Teacher</h2>

            <?php if (isset($_GET['error'])): ?>
                <?php if ($_GET['error'] === 'duplicate_email'): ?>
                    <p class="msg msg-error">That email is already registered to another teacher.</p>
                <?php elseif ($_GET['error'] === 'future_date'): ?>
                    <p class="msg msg-error">Date Joined cannot be in the future.</p>
                <?php endif; ?>
            <?php endif; ?>

            <form method="POST" action="../controllers/teachercontroller.php">

                <input type="hidden" name="teacherID" value="<?php echo $row['TeacherID']; ?>">

                <label>Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($row['TeacherName']); ?>" required>

                <label>Email</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($row['Email']); ?>" required>

                <label>Department</label>
                <input type="text" name="department" value="<?php echo htmlspecialchars($row['Department']); ?>" required>

                <label>Date Joined</label>
                <input type="date" name="dateJoined" value="<?php echo $row['DateJoined']; ?>" max="<?php echo date('Y-m-d'); ?>" required>

                <button type="submit" name="updateTeacher">Save Changes</button>

            </form>

            <p style="margin-top: 15px; text-align: center;">
                <a href="index.php">← Back to Teacher List</a>
            </p>

        </div>
    </div>

</div>

</body>
</html>

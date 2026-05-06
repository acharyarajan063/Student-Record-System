<?php
require_once("../models/teacher.php");

$teacher = new Teacher();
$teachers = $teacher->getAllTeachers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>

    <!-- LINK CSS -->
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
        <div class="left-content">
            <h1>Teacher Management</h1>
            <p>Manage teachers easily</p>
            <span>Add, view, and deactivate teachers</span>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <div class="form-box">

            <h2>Add Teacher</h2>

            <form method="POST" action="../controllers/teachercontroller.php">

                <label>Name</label>
                <input type="text" name="name" placeholder="Enter name" required>

                <label>Email</label>
                <input type="email" name="email" placeholder="Enter email" required>

                <label>Department</label>
                <input type="text" name="department" placeholder="Enter department" required>

                <label>Date Joined</label>
                <input type="date" name="dateJoined" required>

                <button type="submit" name="addTeacher">Add Teacher</button>

            </form>

            <hr>

            <h2>Teacher List</h2>

            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php while($row = $teachers->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['TeacherID']; ?></td>
                    <td><?php echo $row['TeacherName']; ?></td>
                    <td><?php echo $row['Email']; ?></td>
                    <td><?php echo $row['Department']; ?></td>
                    <td><?php echo $row['DateJoined']; ?></td>
                    <td><?php echo $row['IsActive'] ? "Active" : "Inactive"; ?></td>
                    <td>
                        <a href="../controllers/teachercontroller.php?delete=<?php echo $row['TeacherID']; ?>">
                            Deactivate
                        </a>
                    </td>
                </tr>
                <?php } ?>

            </table>

        </div>
    </div>

</div>

</body>
</html>
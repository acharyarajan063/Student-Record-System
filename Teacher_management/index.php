<?php
require_once("../models/teacher.php");

$teacher = new Teacher();
$teachers = $teacher->getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Management</title>

    <!-- TEAM CSS -->
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="teacher.css">
</head>

<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
        <div class="left-content">
            <h1>Teacher Management</h1>
            <p>Manage teachers easily</p>
            <span>Add, edit, and deactivate teachers</span>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <div class="form-box">

            <h2>Add Teacher</h2>

            <?php if (isset($_GET['error'])): ?>
                <?php if ($_GET['error'] === 'duplicate_email'): ?>
                    <p class="msg msg-error">That email is already registered to another teacher.</p>
                <?php elseif ($_GET['error'] === 'future_date'): ?>
                    <p class="msg msg-error">Date Joined cannot be in the future.</p>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <?php if ($_GET['success'] === 'added'): ?>
                    <p class="msg msg-success">Teacher added successfully.</p>
                <?php elseif ($_GET['success'] === 'updated'): ?>
                    <p class="msg msg-success">Teacher updated successfully.</p>
                <?php endif; ?>
            <?php endif; ?>

            <form method="POST" action="../controllers/teachercontroller.php">

                <label>Name</label>
                <input type="text" name="name" placeholder="Enter name" required>

                <label>Email</label>
                <input type="email" name="email" placeholder="Enter email" required>

                <label>Department</label>
                <input type="text" name="department" placeholder="Enter department" required>

                <label>Date Joined</label>
                <input type="date" name="dateJoined" max="<?php echo date('Y-m-d'); ?>" required>

                <button type="submit" name="addTeacher">Add Teacher</button>

            </form>

            <hr>

            <h2>Teacher List</h2>
            <p style="margin-bottom: 10px;">
                <a href="assign_courses.php">Assign Courses to Teachers →</a>
            </p>

            <input type="text" id="teacherSearch" placeholder="Search by name, email or department..." onkeyup="searchTeachers()">

            <table id="teacherTable">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Courses</th>
                    <th>Action</th>
                </tr>

                <?php while($row = $teachers->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['TeacherID']; ?></td>
                    <td><?php echo htmlspecialchars($row['TeacherName']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                    <td><?php echo htmlspecialchars($row['Department']); ?></td>
                    <td><?php echo $row['DateJoined']; ?></td>
                    <td><?php echo $row['IsActive'] ? "Active" : "Inactive"; ?></td>
                    <td>
                        <a href="view_courses.php?id=<?php echo $row['TeacherID']; ?>">View</a>
                    </td>
                    <td>
                        <a href="profile.php?id=<?php echo $row['TeacherID']; ?>">Profile</a>
                        |
                        <a href="edit.php?id=<?php echo $row['TeacherID']; ?>">Edit</a>
                        |
                        <a href="../controllers/teachercontroller.php?delete=<?php echo $row['TeacherID']; ?>">Deactivate</a>
                    </td>
                </tr>
                <?php } ?>

            </table>

        </div>
    </div>

</div>

<script>
function searchTeachers() {
    var input = document.getElementById("teacherSearch").value.toLowerCase();
    var rows = document.querySelectorAll("#teacherTable tr:not(:first-child)");

    rows.forEach(function(row) {
        var name       = row.cells[1].textContent.toLowerCase();
        var email      = row.cells[2].textContent.toLowerCase();
        var department = row.cells[3].textContent.toLowerCase();

        if (name.includes(input) || email.includes(input) || department.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
</script>

</body>
</html>
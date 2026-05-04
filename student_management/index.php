<?php
require_once "../controllers/StudentController.php";

$controller = new StudentController();
$students = $controller->index();
?>

<h2>Student Dashboard</h2>
<a href="add.php">➕ Add Student</a>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Level</th>
    <th>Action</th>
</tr>

<?php while($row = $students->fetch_assoc()): ?>
<tr>
    <td><?= $row['StudentID'] ?></td>
    <td><?= $row['StudentName'] ?></td>
    <td><?= $row['Email'] ?></td>
    <td><?= $row['Level'] ?></td>
    <td>
        <a href="edit.php?id=<?= $row['StudentID'] ?>">Edit</a> |
        <a href="delete.php?id=<?= $row['StudentID'] ?>" 
   onclick="return confirm('Are you sure you want to delete this student?')">
   Delete
</a>
    </td>
</tr>
<?php endwhile; ?>
</table>
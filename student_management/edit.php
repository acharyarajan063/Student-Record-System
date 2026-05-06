<?php
require_once '../controllers/StudentController.php';

$controller = new StudentController();

$id = $_GET['id'];

$student = $controller->edit($id);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $controller->update($_POST);

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<h2>Edit Student</h2>

<form method="POST">

    <input type="hidden" name="id"
        value="<?= $student['StudentID'] ?>">

    <input type="text" name="name"
        value="<?= htmlspecialchars($student['StudentName']) ?>">

    <br><br>

    <input type="email" name="email"
        value="<?= htmlspecialchars($student['Email']) ?>">

    <br><br>

    <input type="text" name="level"
        value="<?= htmlspecialchars($student['Level']) ?>">

    <br><br>

    <input type="date" name="dob"
        value="<?= htmlspecialchars($student['DateOfBirth']) ?>">
    <br><br>

    

    <button type="submit">Update Student</button>

</form>

</body>
</html>
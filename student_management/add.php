<?php
require_once '../controllers/StudentController.php';

$controller = new StudentController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->store($_POST);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>

<h2>Add Student</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="level" placeholder="Level"><br><br>
    <input type="date" name="dob"><br><br>
    <input type="date" name="enrolled"><br><br>
    <input type="number" name="isActive" placeholder="1 or 0"><br><br>

    <button type="submit">Add Student</button>
</form>

</body>
</html>
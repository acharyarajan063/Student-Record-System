<?php
require_once '../controllers/StudentController.php';

$controller = new StudentController();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['name'])) {

        $error = "Name is required";

    } elseif (empty($_POST['email'])) {

        $error = "Email is required";

    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

        $error = "Invalid email format";

    } elseif (empty($_POST['dob'])) {

        $error = "Date of birth is required";

    } elseif (empty($_POST['enrolled'])) {

        $error = "Enrollment date is required";

    } elseif ($_POST['isActive'] != 0 && $_POST['isActive'] != 1) {

        $error = "IsActive must be 0 or 1";

    } else {

        $controller->store($_POST);

        header("Location: index.php");
        exit();
    }
}
?>
<?php if (!empty($error)): ?>
    <p style="color:red;">
        <?= $error ?>
    </p>
<?php endif; ?>

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
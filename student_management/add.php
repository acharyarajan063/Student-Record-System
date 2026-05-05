<?php
// add.php - add a new student record

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'student_management';

$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $course = trim($_POST['course'] ?? '');

    if ($name === '' || $email === '' || $phone === '' || $course === '') {
        $message = 'All fields are required.';
    } else {
        $stmt = $mysqli->prepare('INSERT INTO students (name, email, phone, course) VALUES (?, ?, ?, ?)');
        if ($stmt) {
            $stmt->bind_param('ssss', $name, $email, $phone, $course);
            if ($stmt->execute()) {
                $stmt->close();
                header('Location: index.php');
                exit;
            }
            $message = 'Insert failed: ' . $stmt->error;
            $stmt->close();
        } else {
            $message = 'Prepare failed: ' . $mysqli->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        form { max-width: 400px; }
        label { display: block; margin-bottom: 0.5rem; }
        input { width: 100%; padding: 0.5rem; margin-bottom: 1rem; }
        .message { color: red; margin-bottom: 1rem; }
        .button { padding: 0.6rem 1.2rem; }
    </style>
</head>
<body>
    <h1>Add Student</h1>
    <?php if ($message !== ''): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="post" action="add.php">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>

        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>" required>

        <label for="course">Course</label>
        <input type="text" id="course" name="course" value="<?php echo isset($course) ? htmlspecialchars($course) : ''; ?>" required>

        <button type="submit" class="button">Add Student</button>
    </form>
    <p><a href="index.php">Back to list</a></p>
</body>
</html>

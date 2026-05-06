<?php
// add.php - add a new course record

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'student_record_system';

$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_error) {
    die('Database connection failed: ' . $mysqli->connect_error);
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseName   = trim($_POST['CourseName'] ?? '');
    $courseCode   = trim($_POST['CourseCode'] ?? '');
    $creditPoints = trim($_POST['CreditPoints'] ?? '');
    $startDate    = trim($_POST['StartDate'] ?? '');
    $teacherID    = trim($_POST['TeacherID'] ?? '');
    $isActive     = isset($_POST['IsActive']) ? 1 : 0;

    if ($courseName === '' || $courseCode === '' || $creditPoints === '' || $startDate === '' || $teacherID === '') {
        $message = 'All fields are required.';
    } else {
        $stmt = $mysqli->prepare('INSERT INTO course (CourseName, CourseCode, CreditPoints, StartDate, TeacherID, IsActive) VALUES (?, ?, ?, ?, ?, ?)');
        if ($stmt) {
            $stmt->bind_param('ssissi', $courseName, $courseCode, $creditPoints, $startDate, $teacherID, $isActive);
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
    <title>Add Course</title>
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
    <h1>Add Course</h1>
    <?php if ($message !== ''): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="post" action="add.php">
        <label for="CourseName">Course Name</label>
        <input type="text" id="CourseName" name="CourseName" value="<?php echo isset($courseName) ? htmlspecialchars($courseName) : ''; ?>" required>

        <label for="CourseCode">Course Code</label>
        <input type="text" id="CourseCode" name="CourseCode" value="<?php echo isset($courseCode) ? htmlspecialchars($courseCode) : ''; ?>" required>

        <label for="CreditPoints">Credit Points</label>
        <input type="number" id="CreditPoints" name="CreditPoints" value="<?php echo isset($creditPoints) ? htmlspecialchars($creditPoints) : ''; ?>" required>

        <label for="StartDate">Start Date</label>
        <input type="date" id="StartDate" name="StartDate" value="<?php echo isset($startDate) ? htmlspecialchars($startDate) : ''; ?>" required>

        <label for="TeacherID">Teacher ID</label>
        <input type="number" id="TeacherID" name="TeacherID" value="<?php echo isset($teacherID) ? htmlspecialchars($teacherID) : ''; ?>" required>

        <label for="IsActive">Is Active</label>
        <input type="checkbox" id="IsActive" name="IsActive" value="1" checked>

        <br><br>
        <button type="submit" class="button">Add Course</button>
    </form>
    <p><a href="index.php">Back to list</a></p>
</body>
</html>
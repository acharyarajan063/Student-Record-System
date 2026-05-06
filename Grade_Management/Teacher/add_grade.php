<?php
session_start();
include('../db.php');

$_SESSION['role'] = 'teacher';
$_SESSION['user_id'] = 1;

// Check teacher access 
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    die("Access denied");
}

$student_id = '';
$course_id = '';
$marks = '';
$errors = [];
$success_message = '';

// Get data for dropdowns
$students_query = "SELECT StudentID, StudentName FROM student WHERE IsActive = 1 ORDER BY StudentName";
$students_result = mysqli_query($conn, $students_query);

$courses_query = "SELECT CourseID, CourseName, CourseCode FROM course WHERE IsActive = 1 ORDER BY CourseName";
$courses_result = mysqli_query($conn, $courses_query);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $marks = $_POST['marks'];
    
    // VALIDATION
    if (empty($student_id)) {
        $errors[] = "Please select a student.";
    }
    if (empty($course_id)) {
        $errors[] = "Please select a course.";
    }
    if (empty($marks) && $marks !== '0') {
        $errors[] = "Please enter marks.";
    }
    if (!empty($marks) && !validateMarks($marks)) {
        $errors[] = "Marks must be between 0 and 100.";
    }
    
    // Check if grade already exists
    if (empty($errors) && gradeExists($conn, $student_id, $course_id)) {
        $errors[] = "A grade already exists for this student in this course. Please edit instead.";
    }
    
    if (empty($errors)) {
        $grade_data = calculateGrade($marks);
        $grade_letter = $grade_data['grade'];
        $is_passed = $grade_data['passed'];
        
        $insert_query = "INSERT INTO grade (StudentID, CourseID, Marks, GradeLetter, IsPassed, DateRecorded) 
                         VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("iidsi", $student_id, $course_id, $marks, $grade_letter, $is_passed);
        
        if ($stmt->execute()) {
            $success_message = "✅ Grade added successfully!";
            $student_id = $course_id = $marks = '';
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher - Add Grade</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container">
        <div class="nav-menu">
            <a href="teacher_dashboard.php">Dashboard</a>
            <a href="list_grades.php">View Grades</a>
            <a href="add_grade.php" class="active">Add Grade</a>
        </div>
        
        <h2>➕ Add New Grade (Teacher)</h2>
        
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <strong>❌ Please fix:</strong>
                <ul><?php foreach($errors as $error) echo "<li>$error</li>"; ?></ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <label for="student_id">Select Student *</label>
            <select name="student_id" id="student_id" required>
                <option value="">-- Select Student --</option>
                <?php while($student = mysqli_fetch_assoc($students_result)): ?>
                    <option value="<?php echo $student['StudentID']; ?>"><?php echo htmlspecialchars($student['StudentName']); ?></option>
                <?php endwhile; ?>
            </select>
            
            <label for="course_id">Select Course *</label>
            <select name="course_id" id="course_id" required>
                <option value="">-- Select Course --</option>
                <?php while($course = mysqli_fetch_assoc($courses_result)): ?>
                    <option value="<?php echo $course['CourseID']; ?>"><?php echo htmlspecialchars($course['CourseName']); ?></option>
                <?php endwhile; ?>
            </select>
            
            <label for="marks">Enter Marks (0-100) *</label>
            <input type="number" step="0.01" name="marks" id="marks" placeholder="Enter marks" min="0" max="100" required>
            
            <button type="submit" name="save" class="btn-save">💾 Save Grade</button>
            <a href="list_grades.php" class="btn-view">Cancel</a>
        </form>
    </div>
</body>
</html>
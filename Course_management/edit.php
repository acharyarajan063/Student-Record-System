<?php
require_once '../controllers/CourseController.php';

// Create controller object
$controller = new CourseController();

// Get course ID from URL
$id = $_GET['id'];

// Get course data
$course = $controller->edit($id);

// Error variable
$error = "";

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['courseName'])) {
        $error = "Course Name is required";
    } elseif (empty($_POST['courseCode'])) {
        $error = "Course Code is required";
    } elseif (empty($_POST['creditPoints'])) {
        $error = "Credit Points is required";
    } elseif (empty($_POST['startDate'])) {
        $error = "Start Date is required";
    } elseif (empty($_POST['teacherID'])) {
        $error = "Teacher ID is required";
    } else {
        // Update course
        $controller->update($_POST);
        // Redirect back
        header("Location: admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 2rem;
        }
        .container {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 { color: #2c3e50; margin-bottom: 1.5rem; }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        label { font-weight: bold; color: #2c3e50; }
        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }
        button:hover { background: #2980b9; }
        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }
        .back-container { text-align: center; margin-top: 1.5rem; }
        .back-btn {
            display: inline-block;
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            transition: 0.3s;
        }
        .back-btn:hover { color: #21618c; }
    </style>
</head>
<body>

    <div class="container">

        <h2>Edit Course</h2>

        <!-- Error Message -->
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Edit Form -->
        <form method="POST">

            <!-- Hidden Course ID -->
            <input type="hidden" name="id" value="<?= $course['CourseID'] ?>">

            <!-- Course Name -->
            <label>Course Name</label>
            <input type="text" name="courseName" 
            value="<?= htmlspecialchars($course['CourseName']) ?>">

            <!-- Course Code -->
            <label>Course Code</label>
            <input type="text" name="courseCode" 
            value="<?= htmlspecialchars($course['CourseCode']) ?>">

            <!-- Credit Points -->
            <label>Credit Points</label>
            <input type="number" name="creditPoints" 
            value="<?= htmlspecialchars($course['CreditPoints']) ?>">

            <!-- Start Date -->
            <label>Start Date</label>
            <input type="date" name="startDate" 
            value="<?= htmlspecialchars($course['StartDate']) ?>">

            <!-- Teacher ID -->
            <label>Teacher ID</label>
            <input type="number" name="teacherID" 
            value="<?= htmlspecialchars($course['TeacherID']) ?>">

            <!-- Status -->
            <label>Status</label>
            <select name="isActive">
                <option value="1" <?= ($course['IsActive'] == 1) ? 'selected' : '' ?>>
                    Active
                </option>
                <option value="0" <?= ($course['IsActive'] == 0) ? 'selected' : '' ?>>
                    Inactive
                </option>
            </select>

            <!-- Update Button -->
            <div class="button-group">
                <button type="submit">✏️ Update Course</button>
            </div>

        </form>

        <!-- Back Link -->
        <div class="back-container">
            <a href="admin.php" class="back-btn">← Back to Course List</a>
        </div>

    </div>

</body>
</html>
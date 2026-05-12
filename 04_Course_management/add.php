<?php
require_once '../controllers/CourseController.php';

$controller = new CourseController();

$error = "";

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
        $controller->store($_POST);
        header("Location: admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Course</title>
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
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }
        button:hover { background: #219150; }
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
        }
        .back-btn:hover { color: #21618c; }
    </style>
</head>
<body>

    <div class="container">

        <h2>Add Course</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">

            <label>Course Name</label>
            <input type="text" name="courseName" 
            placeholder="Enter course name" required>

            <label>Course Code</label>
            <input type="text" name="courseCode" 
            placeholder="Enter course code e.g. CS101" required>

            <label>Credit Points</label>
            <input type="number" name="creditPoints" 
            placeholder="Enter credit points" min="1" required>

            <label>Start Date</label>
            <input type="date" name="startDate" required>

            <label>Teacher ID</label>
            <input type="number" name="teacherID" 
            placeholder="Enter Teacher ID" required>

            <label>Status</label>
            <select name="isActive">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>

            <div class="button-group">
                <button type="submit">➕ Add Course</button>
            </div>

        </form>

        <div class="back-container">
            <a href="admin.php" class="back-btn">← Back to Course List</a>
        </div>

    </div>

</body>
</html>
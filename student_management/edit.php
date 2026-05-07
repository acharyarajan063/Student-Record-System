<?php
require_once '../controllers/StudentController.php';

// Create controller object
$controller = new StudentController();

// Get student ID from URL
$id = $_GET['id'];

// Get student data
$student = $controller->edit($id);

// Error variable
$error = "";

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validation

    if (empty($_POST['name'])) {

        $error = "Name is required";

    } elseif (empty($_POST['email'])) {

        $error = "Email is required";

    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

        $error = "Invalid email format";

    } else {

        // Update student
        $controller->update($_POST);

        // Redirect back
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Edit Student</title>

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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
            color: #2c3e50;
        }

        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #2980b9;
        }

        /* Center Button */
        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        /* Back Link */
        .back-container {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-btn {
            display: inline-block;
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            transition: 0.3s;
        }

        .back-btn:hover {
            color: #21618c;
        }
    </style>

</head>

<body>

    <div class="container">

        <h2>Edit Student</h2>

        <!-- Error Message -->
        <?php if (!empty($error)): ?>

            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>

        <!-- Edit Form -->
        <form method="POST">

            <!-- Hidden ID -->
            <input type="hidden" name="id" value="<?= $student['StudentID'] ?>">

            <!-- Student Name -->
            <label>Student Name</label>

            <input type="text" name="name" value="<?= htmlspecialchars($student['StudentName']) ?>">

            <!-- Email -->
            <label>Email</label>

            <input type="email" name="email" value="<?= htmlspecialchars($student['Email']) ?>">

            <!-- Level -->
            <label>Level</label>

            <select name="level">

                <option value="Year 1" <?= ($student['Level'] == 'Year 1') ? 'selected' : '' ?>>
                    Year 1
                </option>

                <option value="Year 2" <?= ($student['Level'] == 'Year 2') ? 'selected' : '' ?>>
                    Year 2
                </option>

                <option value="Year 3" <?= ($student['Level'] == 'Year 3') ? 'selected' : '' ?>>
                    Year 3
                </option>

            </select>

            <!-- Date of Birth -->
            <label>Date of Birth</label>

            <input type="date" name="dob" value="<?= htmlspecialchars($student['DateOfBirth']) ?>">
            <!-- Status -->
            <label>Status</label>

            <select name="isActive">

                <option value="1" <?= ($student['IsActive'] == 1) ? 'selected' : '' ?>>
                    Active
                </option>

                <option value="0" <?= ($student['IsActive'] == 0) ? 'selected' : '' ?>>
                    Inactive
                </option>

            </select>

            <!-- Update Button -->
            <div class="button-group">

                <button type="submit">
                    ✏️ Update Student
                </button>

            </div>

        </form>

        <!-- Back Link -->
        <div class="back-container">

            <a href="index.php" class="back-btn">
                ← Back to Student List
            </a>

        </div>

    </div>

</body>

</html>
<?php
require_once '../controllers/StudentController.php';

$controller = new StudentController();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validation

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

        // Store student
        $controller->store($_POST);

        // Redirect back to index
        header("Location: admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Add Student</title>

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
            background: #27ae60;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            background: #219150;
        }

        .back-btn {
            display: inline-block;
            margin-top: 1rem;
            text-decoration: none;
            color: #3498db;
        }

        /* Center Button */
        .button-group {
            display: flex;
            justify-content: center;
            margin-top: 1.5rem;
        }

        /* Better Back Link */
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

        <h2>Add Student</h2>

        <!-- Error Message -->
        <?php if (!empty($error)): ?>

            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>

        <?php endif; ?>

        <!-- Add Student Form -->
        <form method="POST">

            <!-- Student Name -->
            <label>Student Name</label>
            <input type="text" name="name" placeholder="Enter student name" required>

            <!-- Email -->
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter email" required>

            <!-- Level -->
            <label>Level</label>

            <select name="level">

                <option value="Year 1">Year 1</option>
                <option value="Year 2">Year 2</option>
                <option value="Year 3">Year 3</option>

            </select>

            <!-- Date of Birth -->
            <label>Date of Birth</label>
            <input type="date" name="dob">

            <!-- Enrollment Date -->
            <label>Enrollment Date</label>
            <input type="date" name="enrolled">

            <!-- Status -->
            <label>Status</label>

            <select name="isActive">

                <option value="1">Active</option>
                <option value="0">Inactive</option>

            </select>

            <!-- Submit Button -->
            <div class="button-group">

                <button type="submit">
                    ➕ Add Student
                </button>

            </div>

        </form>

        <!-- Back Link -->
        <div class="back-container">

            <a href="admin.php" class="back-btn">
                ← Back to Student List
            </a>

        </div>

    </div>

</body>

</html>
<?php
require_once("../database/db.php");

$db = new Database();
$conn = $db->connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $level = trim($_POST['level']);
    $DateOfBirth = trim($_POST['dob']); 
    $DateEnrolled = date('Y-m-d');

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO student
    (StudentName, Email, Password, Level,DateOfBirth, DateEnrolled, IsActive)
    VALUES (?, ?, ?, ?, ?, NOW(), 1)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssss",
        $name,
        $email,
        $hashedPassword,
        $level,
        $DateOfBirth,
      
    );

    if ($stmt->execute()) {

        header("Location: ../index.php?registered=success");
        exit();

    } else {

        $error = "Registration Failed";

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .register-card {
            width: 450px;
            background: white;
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: #1e293b;
            margin-bottom: 10px;
            font-size: 36px;
        }

        p {
            color: #64748b;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #334155;
        }

        input,
        select {
            width: 100%;
            padding: 14px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 15px;
        }

        .btn {
            width: 100%;
            background: #2563eb;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
        }

        .login-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }
    </style>

</head>

<body>

    <div class="register-card">

        <h1>

            Student Register

        </h1>

        <p>

            Create your student account.

        </p>

        <?php if (isset($error)): ?>

            <div class="error">

                <?= $error ?>

            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="input-group">

                <label>

                    Full Name

                </label>

                <input type="text" name="name" required>

            </div>

            <div class="input-group">

                <label>

                    Email

                </label>

                <input type="email" name="email" required>

            </div>

            <div class="input-group">

                <label>

                    Password

                </label>

                <input type="password" name="password" required>

            </div>

            <div class="input-group">

                <label>

                    Level

                </label>

                <select name="level" required>

                    <option value="Year 1">
                        Year 1
                    </option>

                    <option value="Year 2">
                        Year 2
                    </option>

                    <option value="Year 3">
                        Year 3
                    </option>

                </select>

            </div>
            <div class="input-group">

                <label>Date of Birth</label>

                <input type="date" name="dob" required>

            </div>

            <button type="submit" class="btn">

                Register

            </button>

        </form>

        <div class="login-link">

            Already have account?

            <a href="../index.php">

                Login

            </a>

        </div>

    </div>

</body>

</html>
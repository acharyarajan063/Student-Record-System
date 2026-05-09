<?php

require_once '../database/db.php';

$conn = (new Database())->connect();

$error = "";
$success = "";

/*
|--------------------------------------------------------------------------
| Registration Form Submit
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get form values
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $level = trim($_POST['level']);
    $password = trim($_POST['password']);

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if (empty($name)) {

        $error = "Name is required";

    } elseif (empty($email)) {

        $error = "Email is required";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Invalid email format";

    } elseif (empty($level)) {

        $error = "Please select level";

    } elseif (empty($password)) {

        $error = "Password is required";

    } else {

        /*
        |--------------------------------------------------------------------------
        | Check Existing Email
        |--------------------------------------------------------------------------
        */

        $check = $conn->prepare(
            "SELECT * FROM student WHERE Email = ?"
        );

        $check->bind_param("s", $email);

        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $error = "Email already exists";

        } else {

            /*
            |--------------------------------------------------------------------------
            | Insert Student
            |--------------------------------------------------------------------------
            */

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $sql = "
                INSERT INTO student
                (
                    StudentName,
                    Email,
                    Level,
                    Password,
                    IsActive
                )
                VALUES
                (
                    ?, ?, ?, ?, 1
                )
            ";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "ssss",
                $name,
                $email,
                $level,
                $hashedPassword
            );

            if ($stmt->execute()) {

                $success = "Registration successful";

            } else {

                $error = "Something went wrong";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Student Registration</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins', sans-serif;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#4f46e5,#ff00cc);
            padding:20px;
        }

        .register-card{

            width:100%;
            max-width:500px;

            background:white;

            padding:40px;

            border-radius:25px;

            box-shadow:0 10px 30px rgba(0,0,0,0.15);
        }

        h2{
            text-align:center;
            margin-bottom:30px;
            color:#1e293b;
            font-size:34px;
            font-weight:700;
        }

        .input-group{
            margin-bottom:20px;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-weight:600;
            color:#334155;
        }

        input,
        select{

            width:100%;

            padding:14px 16px;

            border:1px solid #cbd5e1;

            border-radius:12px;

            font-size:15px;

            transition:0.3s;
        }

        input:focus,
        select:focus{

            outline:none;

            border-color:#7c3aed;

            box-shadow:0 0 0 4px rgba(124,58,237,0.15);
        }

        .btn{

            width:100%;

            border:none;

            padding:15px;

            border-radius:12px;

            background:linear-gradient(135deg,#4f46e5,#ff00cc);

            color:white;

            font-size:16px;

            font-weight:600;

            cursor:pointer;

            transition:0.3s;
        }

        .btn:hover{

            transform:translateY(-2px);

            box-shadow:0 8px 20px rgba(124,58,237,0.3);
        }

        .error{

            background:#fee2e2;

            color:#991b1b;

            padding:12px;

            border-radius:10px;

            margin-bottom:20px;
        }

        .success{

            background:#dcfce7;

            color:#166534;

            padding:12px;

            border-radius:10px;

            margin-bottom:20px;
        }

        .login-link{

            margin-top:20px;

            text-align:center;
        }

        .login-link a{

            color:#4f46e5;

            text-decoration:none;

            font-weight:600;
        }

    </style>

</head>

<body>

    <div class="register-card">

        <h2>Student Registration</h2>

        <!-- Error -->
        <?php if (!empty($error)): ?>

            <div class="error">

                <?= $error ?>

            </div>

        <?php endif; ?>

        <!-- Success -->
        <?php if (!empty($success)): ?>

            <div class="success">

                <?= $success ?>

            </div>

        <?php endif; ?>

        <!-- Registration Form -->
        <form method="POST">

            <div class="input-group">

                <label>Full Name</label>

                <input
                    type="text"
                    name="name"
                    placeholder="Enter full name"
                >

            </div>

            <div class="input-group">

                <label>Email Address</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter email address"
                >

            </div>

            <div class="input-group">

                <label>Academic Level</label>

                <select name="level">

                    <option value="">
                        Select Level
                    </option>

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

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Create password"
                >

            </div>

            <button type="submit" class="btn">

                Register Account

            </button>

        </form>

        <div class="login-link">

            Already have an account?

            <a href="../index.php">

                Login Here

            </a>

        </div>

    </div>

</body>

</html>
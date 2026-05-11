<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Educare Institute of Technology</title>

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- CSS -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <!-- LEFT SIDE -->
        <div class="left">

            <div class="left-content">

                <div class="logo-box">

                    🎓

                </div>

                <h1>

                    Student Record System

                </h1>

                <p>

                    Educare Institute of Technology

                </p>

                <span>

                    Manage students, attendance, grades, and courses easily through one secure platform.

                </span>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="right">

            <div class="form-box">

                <h2>

                    Login

                </h2>

                <!-- Error Messages -->
                <?php if (isset($_GET['error'])): ?>

                    <div class="error-box">

                        <?php

                            if ($_GET['error'] == 'empty') {

                                echo "Please fill all fields.";

                            } elseif ($_GET['error'] == 'invalid') {

                                echo "Invalid email or password.";

                            }

                        ?>

                    </div>

                <?php endif; ?>

                <!-- Login Form -->
                <form method="POST" action="login.php">

                    <!-- Email -->
                    <div class="input-group">

                        <label>Email Address</label>

                        <input
                            type="email"
                            name="email"
                            placeholder="Enter your email"
                            required
                        >

                    </div>

                    <!-- Password -->
                    <div class="input-group">

                        <label>Password</label>

                        <div class="password-box">

                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Enter your password"
                                required
                            >

                            <span onclick="togglePassword()">

                                👁

                            </span>

                        </div>

                    </div>

                    <!-- Options -->
                    <div class="options">

                        <label class="remember">

                            <input type="checkbox">

                            Remember me

                        </label>

                        <a href="#">

                            Forgot password?

                        </a>

                    </div>

                    <!-- Login Button -->
                    <button type="submit">

                        Login

                    </button>

                </form>

                <!-- Register -->
                <div class="register-link">

                    Don't have an account?

                    <a href="student_management/register.php">

                        Register as Student

                    </a>

                </div>

                <!-- Role Info -->
                <div class="role-info">

                    <div class="role-card">

                        👨‍💼 Admin

                    </div>

                    <div class="role-card">

                        👨‍🏫 Teacher

                    </div>

                    <div class="role-card">

                        👨‍🎓 Student

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Toggle Password -->
    <script>

        function togglePassword() {

            const pass = document.getElementById("password");

            if (pass.type === "password") {

                pass.type = "text";

            } else {

                pass.type = "password";

            }
        }

    </script>

</body>

</html>
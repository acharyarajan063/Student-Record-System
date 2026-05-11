<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educare Institute of Technology</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
        <div class="left">
            <div class="circle top-circle"></div>
            <div class="circle bottom-circle"></div>
            <div class="left-content">
                
                <h1>Welcome<br>Back</h1>
                <p>Sign in to your portal to manage classes, students, attendance, and resources.</p>
                
                <div class="stats">
                    <div class="stat-card">
                        <h2>1240</h2>
                        <span>Students</span>
                    </div>
                    <div class="stat-card">
                        <h2>86</h2>
                        <span>Teachers</span>
                    </div>
                    <div class="stat-card">
                        <h2>34</h2>
                        <span>Courses</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="form-box">
                <h2>Sign In</h2>
                <p class="subtitle">Sign in to manage your classes</p>

                <div class="role-tabs" id="roleTabs">
                    <button type="button" class="tab active" data-role="teacher">Teacher</button>
                    <button type="button" class="tab" data-role="admin">Admin</button>
                    <button type="button" class="tab" data-role="student">Student</button>
                </div>

                <form method="POST" action="login.php">
                    <input type="hidden" name="role" id="selectedRole" value="teacher">

                    <div class="input-group">
                        <label>E-MAIL</label>
                        <input type="email" id="emailInput" name="email" placeholder="teacher@school.com" required>
                    </div>

                    <div class="input-group">
                        <label>PASSWORD</label>
                        <div class="password-box">
                            <input type="password" name="password" id="password" placeholder="Enter your password" required>
                            <span onclick="togglePassword()">👁</span>
                        </div>
                    </div>

                    <div class="forgot-password">
                        <a href="#">Forgot password?</a>
                    </div>

                    <button type="submit" class="login-btn">Sign In</button>
                </form>

                <div class="bottom-text">
                    Need access? <a href="student_management/register.php">Register as Student</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- Interactivity for Role Tabs ---
        const tabs = document.querySelectorAll('.tab');
        const emailInput = document.getElementById('emailInput');
        const roleInput = document.getElementById('selectedRole');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');

                // Get the role data attribute
                const role = tab.getAttribute('data-role');
                
                // Update the hidden input for backend submission
                roleInput.value = role;

                // Update the email placeholder to match the role dynamically
                if (role === 'teacher') {
                    emailInput.placeholder = 'teacher@school.com';
                } else if (role === 'admin') {
                    emailInput.placeholder = 'admin@school.com';
                } else {
                    emailInput.placeholder = 'student@school.com';
                }
            });
        });

        // --- Password Visibility Toggle ---
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
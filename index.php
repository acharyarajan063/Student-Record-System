<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Educare Institute of Technology</title>

  <!-- FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
      <div class="left-content">

        <h1>Welcome To</h1>
        <p>Educare Institute of Technology</p>
        <span>Manage students, attendance, and courses easily.</span>
      </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">

      <!-- LOGO -->

      <div class="form-box">
        <h2>Login</h2>
        <<!-- Login Form -->
          <form method="POST" action="login.php">

            <!-- Email input (matches database) -->
            <label>Email</label>
            <input type="text" name="email" placeholder="Enter email" required>

            <!-- Password input -->
            <label>Password</label>
            <div class="password-box">
              <input type="password" name="password" id="password" placeholder="Enter password" required>
              <span onclick="togglePassword()">👁</span>
            </div>

            <!-- Options -->
            <div class="options">
              <label><input type="checkbox"> Remember me</label>
              <a href="#">Forgot password?</a>
            </div>

            <!-- Submit -->
            <button type="submit">Login</button>

          </form>
      </div>

    </div>

    <script>
      function togglePassword() {
        const pass = document.getElementById("password");
        pass.type = pass.type === "password" ? "text" : "password";
      }
    </script>

</body>

</html>
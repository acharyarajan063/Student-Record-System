<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login — Teacher & Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet"/>
 <link rel="stylesheet" href="style.css"/>
</head>
<body>

<div class="page-layout">

  <!-- Left decorative panel -->
  <div class="left-panel">
    <div class="brand">
      <div class="brand-logo">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round">
          <path d="M12 3L2 9l10 6 10-6-10-6z"/><path d="M2 17l10 6 10-6"/><path d="M2 13l10 6 10-6"/>
        </svg>
      </div>
      <h1>Welcome Back</h1>
      <p>Sign in to your portal to manage classes, students, and school resources.</p>
    </div>

    <div class="left-footer">
      <div class="stat-row">
        <div class="stat">
          <div class="stat-num">1,240</div>
          <div class="stat-label">Students</div>
        </div>
        <div class="stat">
          <div class="stat-num">86</div>
          <div class="stat-label">Teachers</div>
        </div>
        <div class="stat">
          <div class="stat-num">34</div>
          <div class="stat-label">Courses</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right form panel -->
  <div class="right-panel">
    <div class="form-header">
      <h2>Sign in</h2>
      <p id="formSubtitle">Access your dashboard below</p>
    </div>

    <!-- Role tabs (outside form so buttons don't trigger submit) -->
    <div class="role-tabs">
      <button type="button" class="role-tab active" onclick="setRole(this, 'teacher')">Teacher</button>
      <button type="button" class="role-tab" onclick="setRole(this, 'admin')">Admin</button>
      <button type="button" class="role-tab" onclick="setRole(this, 'student')">Student</button>
    </div>

    <!-- Error -->
    <div class="error-msg" id="errorMsg">Invalid email or password. Please try again.</div>

    <!-- Form -->
    <form id="loginForm" onsubmit="handleSubmit(event)">
      <input type="hidden" name="role" id="roleInput" value="teacher"/>

      <div class="field">
        <label for="email">E-mail</label>
        <div class="input-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="1.8">
            <rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/>
          </svg>
          <input type="email" id="email" name="email" placeholder="name@school.com" required autocomplete="email"/>
        </div>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="1.8">
            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
          </svg>
          <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password"/>
          <button type="button" class="eye-btn" onclick="togglePassword()" id="eyeBtn">
            <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="1.8">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
        <div class="field-footer">
          <a href="forgot-password.php" class="forgot">Forgot password?</a>
        </div>
      </div>

      <button type="submit" class="sign-in-btn" id="submitBtn">
        <div class="spinner" id="spinner"></div>
        <span id="btnText">Sign in</span>
      </button>
    </form>

    <div class="bottom-note">
      Need access? <a href="mailto:admin@school.com">Contact your administrator</a>
    </div>
  </div>

</div>

<script>
  let currentRole = 'teacher';
  let pwVisible = false;

  function setRole(el, role) {
    currentRole = role;
    document.getElementById('roleInput').value = role;
    document.querySelectorAll('.role-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('errorMsg').classList.remove('show');

    const placeholders = {
      teacher: 'teacher@school.com',
      admin: 'admin@school.com',
      student: 'student@school.com'
    };
    document.getElementById('email').placeholder = placeholders[role];

    const subtitles = {
      teacher: 'Sign in to manage your classes',
      admin: 'Sign in to the administration panel',
      student: 'Sign in to access your courses'
    };
    document.getElementById('formSubtitle').textContent = subtitles[role];
  }

  function togglePassword() {
    pwVisible = !pwVisible;
    const input = document.getElementById('password');
    input.type = pwVisible ? 'text' : 'password';
    const icon = document.getElementById('eyeIcon');
    icon.innerHTML = pwVisible
      ? '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>'
      : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }

  function handleSubmit(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    const spinner = document.getElementById('spinner');
    const btnText = document.getElementById('btnText');
    const errorMsg = document.getElementById('errorMsg');

    // Show loading
    spinner.style.display = 'block';
    btnText.textContent = 'Signing in…';
    btn.disabled = true;
    errorMsg.classList.remove('show');

    const formData = new FormData(e.target);

    // Replace with your actual PHP endpoint
    fetch('login.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        window.location.href = data.redirect || 'dashboard.php';
      } else {
        errorMsg.textContent = data.message || 'Invalid credentials. Please try again.';
        errorMsg.classList.add('show');
        spinner.style.display = 'none';
        btnText.textContent = 'Sign in';
        btn.disabled = false;
      }
    })
    .catch(() => {
      // Demo fallback — remove in production
      errorMsg.textContent = 'Could not connect to server. Please try again.';
      errorMsg.classList.add('show');
      spinner.style.display = 'none';
      btnText.textContent = 'Sign in';
      btn.disabled = false;
    });
  }
</script>

</body>
</html>
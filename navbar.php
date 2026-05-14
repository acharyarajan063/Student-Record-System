<?php
// Get the name of the current file (e.g., 'admin.php' or 'teachers.php')
$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
    /* Reset and Body adjustment so content doesn't hide behind the sidebar */
    body {
        margin: 0;
        padding-left: 250px; /* Pushes your table to the right of the sidebar */
        font-family: 'Poppins', sans-serif;
    }

    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100vh; /* Full viewport height */
        background-color: #2c3e50; /* Matches your table header */
        display: flex;
        flex-direction: column; /* Stacks elements top-to-bottom */
        padding: 30px 20px;
        color: white;
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1); /* Shadow moved to the right edge */
        box-sizing: border-box;
    }

    .admin-sidebar .nav-brand {
        font-size: 24px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 50px;
        text-align: center;
    }

    .admin-sidebar .nav-links {
        display: flex;
        flex-direction: column;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 15px; /* Spacing between links */
    }

    .admin-sidebar .nav-links li a {
        display: block; /* Makes the entire button width clickable */
        color: #cbd5e1;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        padding: 12px 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .admin-sidebar .nav-links li a:hover,
    .admin-sidebar .nav-links li a.active {
        background-color: #3b82f6; /* Blue highlight */
        color: white;
    }

    /* Pushes the profile/logout section to the very bottom */
    .admin-sidebar .nav-profile {
        margin-top: auto; 
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        border-top: 1px solid #3f546a; /* Subtle divider line */
        padding-top: 25px;
    }

    .admin-sidebar .nav-profile span {
        font-weight: 500;
        font-size: 15px;
        color: #cbd5e1;
    }

    .admin-sidebar .logout-btn {
        background-color: #ef4444; /* Red button */
        color: white;
        text-decoration: none;
        padding: 10px 0;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        text-align: center;
        width: 100%;
        transition: background-color 0.3s;
    }

    .admin-sidebar .logout-btn:hover {
        background-color: #dc2626;
    }
</style>

<nav class="admin-sidebar">
    <div class="nav-brand">
        🎓 EduCare
    </div>
    
   <ul class="nav-links">

    <li>
        <a href="/Student-Record-System/admin_dashboard.php"
        <?php echo ($current_page == 'admin_dashboard.php') ? 'class="active"' : ''; ?>>
            Dashboard
        </a>
    </li>

    <li>
        <a href="/Student-Record-System/01_student_management/student_admin.php"
        <?php echo ($current_page == 'student_admin.php') ? 'class="active"' : ''; ?>>
            Students
        </a>
    </li>

    <li>
        <a href="/Student-Record-System/02_teacher_management/teacher_admin.php"
        <?php echo ($current_page == 'teacher_admin.php') ? 'class="active"' : ''; ?>>
            Teachers
        </a>
    </li>

    <li>
        <a href="/Student-Record-System/04_course_management/course_admin.php"
        <?php echo ($current_page == 'course_admin.php') ? 'class="active"' : ''; ?>>
            Courses
        </a>
    </li>
    <li>
    <a href="/Student-Record-System/03_Attendance_management/attendance_admin.php"
    <?php echo ($current_page == 'attendance_admin.php') ? 'class="active"' : ''; ?>>
        Attendance
    </a>
</li>
<li>
    <a href="/Student-Record-System/06_Enrollment_management/enrollment_admin.php">
        Enrollment
    </a>
</li>

</ul>
    <div class="nav-profile">
        <span><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Admin User'); ?></span>
        <a href="../logout.php" class="logout-btn">Logout</a>
    </div>
</nav>
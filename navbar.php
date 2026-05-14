<?php
$current_page = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'] ?? '';
?>

<style>
    /* ===== BODY FIX ===== */

    body {
        margin: 0;

        font-family: 'Poppins', sans-serif;
        background: #f8fafc;
        box-sizing: border-box;
    }

    body:not(.login-page) {
        padding-left: 270px;
    }

    /* ===== SIDEBAR ===== */

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;

        width: 250px;
        height: 100vh;

        background: #1e293b;

        display: flex;
        flex-direction: column;

        padding: 30px 20px;

        color: white;

        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);

        overflow-y: auto;

        z-index: 1000;
    }

    /* ===== BRAND ===== */

    .nav-brand {
        font-size: 28px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 40px;
        color: white;
    }

    /* ===== NAVIGATION ===== */

    .nav-links {
        list-style: none;
        padding: 0;
        margin: 0;

        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .nav-links li {
        width: 100%;
    }

    .nav-links li a {
        display: block;

        padding: 13px 16px;

        border-radius: 10px;

        text-decoration: none;

        color: #cbd5e1;

        font-size: 15px;
        font-weight: 500;

        transition: 0.3s ease;
    }

    .nav-links li a:hover,
    .nav-links li a.active {
        background: #2563eb;
        color: white;
    }

    /* ===== FOOTER PROFILE ===== */

    .nav-profile {
        margin-top: auto;

        border-top: 1px solid #334155;

        padding-top: 20px;

        display: flex;
        flex-direction: column;

        align-items: center;

        gap: 15px;
    }

    .nav-profile span {
        color: #cbd5e1;
        font-size: 14px;
        font-weight: 500;
    }

    /* ===== LOGOUT BUTTON ===== */

    .logout-btn {
        width: 100%;

        text-align: center;

        background: #ef4444;

        color: white;

        text-decoration: none;

        padding: 12px;

        border-radius: 10px;

        font-size: 14px;
        font-weight: 600;

        transition: 0.3s ease;
    }

    .logout-btn:hover {
        background: #dc2626;
    }

    /* ===== RESPONSIVE ===== */

    @media(max-width:768px) {

        body {
            padding-left: 0;
        }

        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }
    }
</style>

<nav class="sidebar">

    <!-- BRAND -->

    <div class="nav-brand">
        🎓 EduCare
    </div>

    <!-- NAVIGATION -->

    <ul class="nav-links">

        <!-- ================= ADMIN ================= -->

        <?php if ($role == 'admin'): ?>

            <li>
                <a href="/Student-Record-System/admin_dashboard.php" <?= ($current_page == 'admin_dashboard.php') ? 'class="active"' : '' ?>>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/01_student_management/student_admin.php"
                    <?= ($current_page == 'student_admin.php') ? 'class="active"' : '' ?>>
                    Students
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/02_teacher_management/teacher_admin.php"
                    <?= ($current_page == 'teacher_admin.php') ? 'class="active"' : '' ?>>
                    Teachers
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/04_course_management/course_admin.php"
                    <?= ($current_page == 'course_admin.php') ? 'class="active"' : '' ?>>
                    Courses
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/06_Enrollment_management/enrollment_admin.php"
                    <?= ($current_page == 'enrollment_admin.php') ? 'class="active"' : '' ?>>
                    Enrollment
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/03_Attendance_management/attendance_admin.php"
                    <?= ($current_page == 'attendance_admin.php') ? 'class="active"' : '' ?>>
                    Attendance
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/05_Grade_management/grade_admin.php" <?= ($current_page == 'grade_admin.php') ? 'class="active"' : '' ?>>
                    Grades
                </a>
            </li>

        <?php endif; ?>

        <!-- ================= TEACHER ================= -->

        <?php if ($role == 'teacher'): ?>

            <li>
                <a href="/Student-Record-System/02_teacher_management/teacher_dashboard.php"
                    <?= ($current_page == 'teacher_dashboard.php') ? 'class="active"' : '' ?>>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/03_Attendance_management/attendance_admin.php"
                    <?= ($current_page == 'attendance_admin.php') ? 'class="active"' : '' ?>>
                    Attendance
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/05_Grade_management/grade_admin.php" <?= ($current_page == 'grade_admin.php') ? 'class="active"' : '' ?>>
                    Grades
                </a>
            </li>

        <?php endif; ?>

        <!-- ================= STUDENT ================= -->

        <?php if ($role == 'student'): ?>

            <li>
                <a href="/Student-Record-System/01_student_management/student_dashboard.php"
                    <?= ($current_page == 'student_dashboard.php') ? 'class="active"' : '' ?>>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/04_course_management/course_dashboard.php"
                    <?= ($current_page == 'course_dashboard.php') ? 'class="active"' : '' ?>>
                    My Courses
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/03_Attendance_management/attendance_dashboard.php"
                    <?= ($current_page == 'attendance_dashboard.php') ? 'class="active"' : '' ?>>
                    Attendance
                </a>
            </li>

            <li>
                <a href="/Student-Record-System/05_Grade_management/grade_dashboard.php"
                    <?= ($current_page == 'grade_dashboard.php') ? 'class="active"' : '' ?>>
                    Grades
                </a>
            </li>

        <?php endif; ?>

    </ul>

    <!-- PROFILE -->

    <div class="nav-profile">

        <div class="nav-profile">

            <span>

                <?= htmlspecialchars($_SESSION['user_name']) ?>

            </span>

            <a href="/Student-Record-System/logout.php" class="logout-btn">
                Logout
            </a>

        </div>

</nav>
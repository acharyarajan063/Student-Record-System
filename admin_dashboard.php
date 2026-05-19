<?php
// Start session
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

include("navbar.php");

// Basic security check (optional but recommended)
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: ../index.php");
//     exit();
// }

// In the future, replace these hardcoded numbers with real database queries
// Example: $result = $conn->query("SELECT COUNT(*) as count FROM student");
$totalStudents = 1240;
$totalTeachers = 86;
$totalCourses = 34;

// Get the admin's name from the session to welcome them personally
$adminName = $_SESSION['user_name'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EduCare</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Main Content Container */
        .main-content {
            padding: 40px;
            background-color: #f8fafc;
            min-height: 100vh;
            color: #334155;
            box-sizing: border-box;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 8px 0;
        }

        .page-header p {
            color: #64748b;
            margin: 0;
            font-size: 15px;
        }

        /* STAT CARDS GRID */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border-top: 4px solid #3b82f6; /* Blue accent */
        }

        .stat-card.teachers { border-top-color: #10b981; /* Green accent */ }
        .stat-card.courses { border-top-color: #f59e0b; /* Orange accent */ }

        .stat-card h3 {
            font-size: 14px;
            color: #64748b;
            margin: 0 0 10px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .stat-card .number {
            font-size: 36px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        /* BOTTOM ROW: Activity & Quick Actions */
        .dashboard-row {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .panel {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .panel h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-top: 0;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* RECENT ACTIVITY LIST */
        .activity-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .activity-list li {
            display: flex;
            align-items: flex-start;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .activity-list li:last-child { border-bottom: none; }

        .activity-time {
            font-size: 12px;
            color: #94a3b8;
            min-width: 90px;
            padding-top: 2px;
            font-weight: 500;
        }

        .activity-details {
            font-size: 14px;
            color: #334155;
            line-height: 1.5;
        }

        .activity-details strong { color: #0f172a; }

        /* QUICK ACTIONS */
        .quick-action-btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin-bottom: 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
            transition: all 0.2s;
            box-sizing: border-box;
        }

        .quick-action-btn:hover {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        
        /* Responsive fallback for smaller screens */
        @media (max-width: 1024px) {
            .dashboard-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>

    <div class="main-content">
        
        <div class="page-header">
            <h2>Welcome back, <?php echo htmlspecialchars($adminName); ?>!</h2>
            <p>Here is what is happening with your institute today.</p>
        </div>

        <div class="stat-grid">
            <div class="stat-card">
                <h3>Total Students</h3>
                <p class="number"><?php echo $totalStudents; ?></p>
            </div>
            <div class="stat-card teachers">
                <h3>Total Teachers</h3>
                <p class="number"><?php echo $totalTeachers; ?></p>
            </div>
            <div class="stat-card courses">
                <h3>Active Courses</h3>
                <p class="number"><?php echo $totalCourses; ?></p>
            </div>
        </div>

        <div class="dashboard-row">
            
            <div class="panel">
                <h3>Recent Activity</h3>
                <ul class="activity-list">
                    <li>
                        <span class="activity-time">10 mins ago</span>
                        <span class="activity-details"><strong>Admin</strong> added a new student: Sita Thapa.</span>
                    </li>
                    <li>
                        <span class="activity-time">2 hours ago</span>
                        <span class="activity-details"><strong>Bikash Gurung</strong> updated their profile information.</span>
                    </li>
                    <li>
                        <span class="activity-time">Yesterday</span>
                        <span class="activity-details">New course <strong>Introduction to Programming</strong> was created.</span>
                    </li>
                    <li>
                        <span class="activity-time">Yesterday</span>
                        <span class="activity-details"><strong>Pooja Adhikari</strong> enrolled in Mathematics Level 1.</span>
                    </li>
                </ul>
            </div>

            <div class="panel">
                <h3>Quick Actions</h3>
                <a href="admin.php" class="quick-action-btn">Manage Students</a>
                <a href="01_student_management/add.php" class="quick-action-btn">+ Add New Student</a>
                <a href="teachers.php" class="quick-action-btn">Manage Teachers</a>
                <a href="courses.php" class="quick-action-btn">View Courses</a>
            </div>

        </div>

    </div>

</body>
</html>
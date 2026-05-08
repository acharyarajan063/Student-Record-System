<?php
// Include Teacher Model
require_once("../models/teacher.php");

// Create Teacher Object
$teacherModel = new Teacher();

/*
|--------------------------------------------------------------------------
| Search Logic
|--------------------------------------------------------------------------
| If search exists:
| -> search teachers
|
| Else:
| -> show all teachers
|--------------------------------------------------------------------------
*/

// Get search value
$search = $_GET['search'] ?? '';

if (!empty($search)) {

    $teachers = $teacherModel->searchTeachers($search);

} else {

    $teachers = $teacherModel->getAll();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Teacher Management</title>

    <!-- CSS -->
    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 2rem;
            background: #f4f4f4;
        }

        h2 {
            color: #2c3e50;
        }

        /* Add Button */
        .add-btn {
            display: inline-block;
            margin-bottom: 1rem;
            padding: 0.6rem 1.2rem;
            background: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Search Form */
        form {
            margin-bottom: 1rem;
        }

        input,
        button {
            padding: 0.5rem;
            margin-right: 0.5rem;
        }

        button {
            background: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Table Design */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th {
            background: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f1f1f1;
        }

        /* Buttons */
        .edit-btn {
            background: #3498db;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 5px;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .profile-btn {
            background: #9b59b6;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 5px;
        }

        .course-btn {
            background: #f39c12;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            margin-right: 5px;
        }

        /* Status Badge */
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 13px;
        }

        .active {
            background: #d4edda;
            color: #155724;
        }

        .inactive {
            background: #f8d7da;
            color: #721c24;
        }

        /* Messages */
        .msg {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .msg-success {
            background: #d4edda;
            color: #155724;
        }

        .msg-error {
            background: #f8d7da;
            color: #721c24;
        }

    </style>

</head>

<body>

    <!-- Page Title -->
    <h2>Teacher Management</h2>

    <!-- Add Teacher Button -->
    <a href="add_teacher.php" class="add-btn">
        ➕ Add New Teacher
    </a>

    <!-- Assign Courses -->
    <a href="assign_courses.php" class="add-btn" style="background:#8e44ad;">
        📘 Assign Courses
    </a>

    <!-- Success/Error Messages -->
    <?php if (isset($_GET['error'])): ?>

        <?php if ($_GET['error'] === 'duplicate_email'): ?>

            <p class="msg msg-error">
                That email is already registered.
            </p>

        <?php elseif ($_GET['error'] === 'future_date'): ?>

            <p class="msg msg-error">
                Date Joined cannot be in the future.
            </p>

        <?php endif; ?>

    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>

        <?php if ($_GET['success'] === 'added'): ?>

            <p class="msg msg-success">
                Teacher added successfully.
            </p>

        <?php elseif ($_GET['success'] === 'updated'): ?>

            <p class="msg msg-success">
                Teacher updated successfully.
            </p>

        <?php endif; ?>

    <?php endif; ?>

    <!-- Search Form -->
    <form method="GET">

        <input 
            type="text"
            name="search"
            placeholder="Search teacher..."
            value="<?= htmlspecialchars($search) ?>"
        >

        <button type="submit">
            Search
        </button>

    </form>

    <!-- Teacher Table -->
    <table>

        <!-- Table Header -->
        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Date Joined</th>
            <th>Status</th>
            <th>Courses</th>
            <th>Actions</th>

        </tr>

        <!-- Check Teachers -->
        <?php if ($teachers->num_rows > 0): ?>

            <!-- Loop Teachers -->
            <?php while($row = $teachers->fetch_assoc()) { ?>

                <tr>

                    <!-- Teacher ID -->
                    <td>
                        <?= htmlspecialchars($row['TeacherID']) ?>
                    </td>

                    <!-- Teacher Name -->
                    <td>
                        <?= htmlspecialchars($row['TeacherName']) ?>
                    </td>

                    <!-- Email -->
                    <td>
                        <?= htmlspecialchars($row['Email']) ?>
                    </td>

                    <!-- Department -->
                    <td>
                        <?= htmlspecialchars($row['Department']) ?>
                    </td>

                    <!-- Date Joined -->
                    <td>
                        <?= htmlspecialchars($row['DateJoined']) ?>
                    </td>

                    <!-- Status -->
                    <td>

                        <span class="badge <?= $row['IsActive'] ? 'active' : 'inactive' ?>">

                            <?= $row['IsActive'] ? 'Active' : 'Inactive' ?>

                        </span>

                    </td>

                    <!-- Courses -->
                    <td>

                        <a 
                            href="view_courses.php?id=<?= $row['TeacherID'] ?>"
                            class="course-btn"
                        >
                            View
                        </a>

                    </td>

                    <!-- Actions -->
                    <td>

                        <!-- Profile -->
                        <a 
                            href="profile.php?id=<?= $row['TeacherID'] ?>"
                            class="profile-btn"
                        >
                            Profile
                        </a>

                        <!-- Edit -->
                        <a 
                            href="edit.php?id=<?= $row['TeacherID'] ?>"
                            class="edit-btn"
                        >
                            Edit
                        </a>

                        <!-- Deactivate -->
                        <a 
                            href="../controllers/teachercontroller.php?delete=<?= $row['TeacherID'] ?>"
                            class="delete-btn"
                            onclick="return confirm('Are you sure you want to deactivate this teacher?')"
                        >
                            Deactivate
                        </a>

                    </td>

                </tr>

            <?php } ?>

        <?php else: ?>

            <!-- No Teachers -->
            <tr>

                <td colspan="8" style="text-align:center;">

                    No teachers found.

                </td>

            </tr>

        <?php endif; ?>

    </table>

</body>

</html>
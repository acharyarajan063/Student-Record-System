<?php
require_once("../models/teacher.php");

$teacher = new Teacher();
$teachers = $teacher->getAll();
$courses  = $teacher->getAllCourses();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Courses</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="teacher.css">
</head>

<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
        <div class="left-content">
            <h1>Assign Courses</h1>
            <p>Link teachers to courses</p>
            <span>Select a course and assign a teacher to it</span>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">
        <div class="form-box">

            <h2>Assign Teacher to Course</h2>

            <?php if (isset($_GET['success'])): ?>
                <?php if ($_GET['success'] === 'unassigned'): ?>
                    <p class="msg msg-success">Teacher unassigned from course.</p>
                <?php else: ?>
                    <p class="msg msg-success">Course assigned successfully.</p>
                <?php endif; ?>
            <?php endif; ?>

            <form method="POST" action="../controllers/teachercontroller.php">

                <label>Course</label>
                <select name="courseID" required>
                    <option value="" disabled selected>Select a course</option>
                    <?php
                    // store courses in array so we can reuse below
                    $courseList = [];
                    while ($row = $courses->fetch_assoc()) {
                        $courseList[] = $row;
                    }
                    foreach ($courseList as $course): ?>
                        <option value="<?php echo $course['CourseID']; ?>">
                            <?php echo htmlspecialchars($course['CourseName'] . ' (' . $course['CourseCode'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Teacher</label>
                <select name="teacherID" required>
                    <option value="" disabled selected>Select a teacher</option>
                    <?php
                    $teacherList = [];
                    while ($row = $teachers->fetch_assoc()) {
                        $teacherList[] = $row;
                    }
                    foreach ($teacherList as $t): ?>
                        <?php if ($t['IsActive']): ?>
                            <option value="<?php echo $t['TeacherID']; ?>">
                                <?php echo htmlspecialchars($t['TeacherName'] . ' — ' . $t['Department']); ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="assignCourse">Assign</button>

            </form>

            <hr>

            <h2>Current Assignments</h2>

            <table>
                <tr>
                    <th>Course</th>
                    <th>Code</th>
                    <th>Assigned Teacher</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($courseList as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['CourseName']); ?></td>
                    <td><?php echo htmlspecialchars($course['CourseCode']); ?></td>
                    <td><?php echo $course['TeacherName'] ? htmlspecialchars($course['TeacherName']) : '<em style="color:#94a3b8;">Unassigned</em>'; ?></td>
                    <td>
                        <?php if ($course['TeacherName']): ?>
                            <a href="../controllers/teachercontroller.php?unassign=<?php echo $course['CourseID']; ?>"
                               onclick="return confirm('Remove teacher from this course?')">
                                Unassign
                            </a>
                        <?php else: ?>
                            <span style="color:#94a3b8;">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>

            <p style="margin-top: 15px; text-align: center;">
                <a href="index.php">← Back to Teacher List</a>
            </p>

        </div>
    </div>

</div>

</body>
</html>

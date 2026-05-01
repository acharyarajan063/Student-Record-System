<?php
session_start();
require_once "../database/db.php";

// 1. Access control
if (!isset($_SESSION['staff_id'])) {
    die("Unauthorized access");
}

$message = "";

// 2. Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get input data safely
    $studentID = $_POST['studentID'];
    $courseID = $_POST['courseID'];
    $date = $_POST['attendanceDate'];
    $status = $_POST['status'];
    $isExcused = isset($_POST['isExcused']) ? 1 : 0;
    $recordedBy = $_SESSION['staff_id'];

    // 3. Validation: future date check
    if ($date > date("Y-m-d")) {
        $message = "Error: Future dates are not allowed.";
    }

    // 4. Validation: status check
    elseif (!in_array($status, ["Present", "Absent", "Late"])) {
        $message = "Error: Invalid attendance status.";
    }

    else {

        // 5. Check duplicate attendance
        $check = $pdo->prepare("
            SELECT AttendanceID 
            FROM attendance 
            WHERE StudentID = ? 
            AND CourseID = ? 
            AND AttendanceDate = ?
        ");

        $check->execute([$studentID, $courseID, $date]);

        if ($check->rowCount() > 0) {
            $message = "Error: Attendance already marked for this student on this date.";
        } else {

            // 6. Insert record
            $stmt = $pdo->prepare("
                INSERT INTO attendance 
                (StudentID, CourseID, AttendanceDate, Status, RecordedBy, IsExcused)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            if ($stmt->execute([
                $studentID,
                $courseID,
                $date,
                $status,
                $recordedBy,
                $isExcused
            ])) {
                $message = "Attendance saved successfully!";
            } else {
                $message = "Error: Could not save attendance.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
</head>
<body>

<h2>Mark Attendance</h2>

<p><?php echo $message; ?></p>

<form method="POST">

    Student ID:
    <input type="number" name="studentID" required><br><br>

    Course ID:
    <input type="number" name="courseID" required><br><br>

    Date:
    <input type="date" name="attendanceDate" required><br><br>

    Status:
    <select name="status" required>
        <option value="Present">Present</option>
        <option value="Absent">Absent</option>
        <option value="Late">Late</option>
    </select><br><br>

    Excused:
    <input type="checkbox" name="isExcused"><br><br>

    <button type="submit">Save Attendance</button>

</form>

</body>
</html>
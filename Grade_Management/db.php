<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "student_record_system";  // Changed to lowercase (match your database name)

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8mb4");

// PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("PDO connection failed: " . $e->getMessage());
}

// =============================================
// VALIDATION FUNCTIONS (ADD THESE!)
// =============================================

/**
 * Validate marks (0-100)
 */
function validateMarks($marks) {
    if (!is_numeric($marks)) {
        return false;
    }
    $marks = floatval($marks);
    return ($marks >= 0 && $marks <= 100);
}

/**
 * Calculate grade letter based on marks
 */
function calculateGrade($marks) {
    if ($marks >= 90) {
        return ['grade' => 'A+', 'passed' => 1];
    } elseif ($marks >= 80) {
        return ['grade' => 'A', 'passed' => 1];
    } elseif ($marks >= 75) {
        return ['grade' => 'B+', 'passed' => 1];
    } elseif ($marks >= 70) {
        return ['grade' => 'B', 'passed' => 1];
    } elseif ($marks >= 65) {
        return ['grade' => 'C+', 'passed' => 1];
    } elseif ($marks >= 60) {
        return ['grade' => 'C', 'passed' => 1];
    } elseif ($marks >= 50) {
        return ['grade' => 'D', 'passed' => 1];
    } else {
        return ['grade' => 'F', 'passed' => 0];
    }
}

/**
 * Check if grade already exists for a student in a course
 */
function gradeExists($conn, $student_id, $course_id) {
    $query = "SELECT GradeID FROM grade WHERE StudentID = ? AND CourseID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $student_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

/**
 * Get student name by ID
 */
function getStudentName($conn, $student_id) {
    $query = "SELECT StudentName FROM student WHERE StudentID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row ? $row['StudentName'] : 'Unknown';
}

/**
 * Get course name by ID
 */
function getCourseName($conn, $course_id) {
    $query = "SELECT CourseName FROM course WHERE CourseID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row ? $row['CourseName'] : 'Unknown';
}
?>
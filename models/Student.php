<?php
require_once __DIR__ . '/../database/db.php';

class Student {
    private $conn;

    /**
     * Constructor: create DB connection
     */
    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    /**
     * CREATE student (all fields)
     */
    public function create($name, $email, $level, $dob, $enrolled, $isActive) {
        $stmt = $this->conn->prepare(
            "INSERT INTO student 
            (StudentName, Email, Level, DateOfBirth, DateEnrolled, IsActive) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param("sssssi", $name, $email, $level, $dob, $enrolled, $isActive);

        return $stmt->execute();
    }

    /**
     * READ all students
     */
    public function getAll() {
        return $this->conn->query("SELECT * FROM student");
    }

    /**
     * READ single student
     */
    public function getById($id) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM student WHERE StudentID = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * UPDATE student
     */
    public function update($id, $name, $email, $level, $dob, $enrolled, $isActive) {
        $stmt = $this->conn->prepare(
            "UPDATE student SET 
                StudentName=?, 
                Email=?, 
                Level=?, 
                DateOfBirth=?, 
                DateEnrolled=?, 
                IsActive=? 
            WHERE StudentID=?"
        );

        $stmt->bind_param("sssssii", $name, $email, $level, $dob, $enrolled, $isActive, $id);

        return $stmt->execute();
    }

    /**
     * DELETE student
     */
    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM student WHERE StudentID=?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    // Get enrolled courses
public function getCourses($studentId) {
    $stmt = $this->conn->prepare("
        SELECT c.CourseName, c.CourseCode
        FROM enrollment e
        JOIN course c ON e.CourseID = c.CourseID
        WHERE e.StudentID = ?
    ");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    return $stmt->get_result();
}

// Get grades
public function getGrades($studentId) {
    $stmt = $this->conn->prepare("
        SELECT c.CourseName, g.Marks, g.GradeLetter
        FROM grade g
        JOIN course c ON g.CourseID = c.CourseID
        WHERE g.StudentID = ?
    ");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    return $stmt->get_result();
}
// Get attendance
public function getAttendanceStats($studentId) {
    $stmt = $this->conn->prepare("
        SELECT 
            COUNT(*) AS total,
            SUM(CASE WHEN Status = 'Present' THEN 1 ELSE 0 END) AS present
        FROM attendance
        WHERE StudentID = ?
    ");
    $stmt->bind_param("i", $studentId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc(); // returns array
}
}
?>
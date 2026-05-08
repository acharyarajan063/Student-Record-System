<?php
require_once __DIR__ . '/../database/db.php';

class Teacher
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Create function for teacher
    public function create($name, $email, $department, $dateJoined, $isActive)
    {
        $sql = "INSERT INTO teacher (TeacherName, Email, Department, DateJoined, IsActive) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ssssi", $name, $email, $department, $dateJoined, $isActive);
        return $stmt->execute();
    }

    // Read all teachers
    public function getAll()
    {
        $sql = "SELECT * FROM teacher";
        $result = $this->conn->query($sql);
        return $result;
    }

    // Get single teacher by id
    public function getById($id)
    {
        $sql = "SELECT * FROM teacher WHERE TeacherID = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Update teacher
    public function update($id, $name, $email, $department, $dateJoined, $isActive)
    {
        $sql = "UPDATE teacher 
                SET TeacherName=?, Email=?, Department=?, DateJoined=?, IsActive=? 
                WHERE TeacherID=?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ssssii", $name, $email, $department, $dateJoined, $isActive, $id);
        return $stmt->execute();
    }

    // Delete teacher (optional — your system uses deactivate instead)
    public function delete($id)
    {
        $sql = "DELETE FROM teacher WHERE TeacherID=?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Get all courses with their assigned teacher name
    public function getAllCourses()
    {
        $sql = "SELECT c.CourseID, c.CourseName, c.CourseCode, t.TeacherName
                FROM course c
                LEFT JOIN teacher t ON c.TeacherID = t.TeacherID
                WHERE c.IsActive = 1
                ORDER BY c.CourseName";
        return $this->conn->query($sql);
    }

    // Assign a teacher to a course
    public function assignCourse($courseId, $teacherId)
    {
        $sql = "UPDATE course SET TeacherID = ? WHERE CourseID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $teacherId, $courseId);
        return $stmt->execute();
    }

    // Get all courses assigned to a specific teacher
    public function getAssignedCourses($teacherId)
    {
        $sql = "SELECT CourseID, CourseName, CourseCode, CreditPoints, StartDate
                FROM course
                WHERE TeacherID = ? AND IsActive = 1
                ORDER BY CourseName";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $teacherId);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Unassign teacher from a course (set TeacherID to NULL)
    public function unassignCourse($courseId)
    {
        $sql = "UPDATE course SET TeacherID = NULL WHERE CourseID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $courseId);
        return $stmt->execute();
    }

    // Check if email already exists (for duplicate prevention)
    public function emailExists($email, $excludeId = null)
    {
        if ($excludeId) {
            $sql = "SELECT TeacherID FROM teacher WHERE Email = ? AND TeacherID != ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $email, $excludeId);
        } else {
            $sql = "SELECT TeacherID FROM teacher WHERE Email = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $email);
        }

        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Deactivate teacher (important for your system)
    public function deactivate($id)
    {
        $sql = "UPDATE teacher SET IsActive = 0 WHERE TeacherID = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
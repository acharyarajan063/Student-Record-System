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
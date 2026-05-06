<?php
require_once("../database/db.php");

class Teacher {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ADD TEACHER
    public function addTeacher($name, $email, $department, $dateJoined) {
    $sql = "INSERT INTO Teacher (TeacherName, Email, Department, DateJoined)
            VALUES (?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $department, $dateJoined);

    return $stmt->execute();
}

    // GET ALL TEACHERS
    public function getAllTeachers() {
        $sql = "SELECT * FROM Teacher";
        $result = $this->conn->query($sql);

        return $result;
    }

    // DEACTIVATE TEACHER
    public function deactivateTeacher($id) {
        $sql = "UPDATE Teacher SET IsActive = 0 WHERE TeacherID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
?>
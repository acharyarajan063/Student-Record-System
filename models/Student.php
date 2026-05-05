<?php
require_once __DIR__ . '/../database/db.php';

class Student
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Crreate function for the student.
    public function create($name, $email, $level, $dob, $enrolled, $isActive)
    {
        $sql = "INSERT INTO student (StudentName, Email, Level, DateOfBirth, DateEnrolled, IsActive) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        //this need to remove at last 
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("sssssi", $name, $email, $level, $dob, $enrolled, $isActive);
        return $stmt->execute();
    }

    //Read function for the student.
    public function getAll(){
        $sql= "SELECT * FROM student";
        $result = $this->conn->query($sql);
       $this->conn->query($sql);
       return $result;
    }
    //get single student by id
    public function getById($id){
        $sql= "SELECT * FROM student WHERE StudentID = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    //update student
    public function update($id, $name, $email, $level, $DateOfBirth, $DateEnrolled, $IsActive){
        $sql = "UPDATE student SET StudentName=?, Email=?, Level=?, DateOfBirth=?, DateEnrolled=?, IsActive=? WHERE StudentID=?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("sssssii", $name, $email, $level, $DateOfBirth, $DateEnrolled, $IsActive, $id);
        return $stmt->execute();
    }
    //delete student
    public function delete($id){
        $sql = "DELETE FROM student WHERE StudentID=?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
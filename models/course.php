<?php
require_once __DIR__ . '/../database/db.php';

class Course
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Create function for the course.
    public function create($courseName, $courseCode, $creditPoints, $startDate, $teacherID, $isActive)
    {
        $sql = "INSERT INTO course (CourseName, CourseCode, CreditPoints, StartDate, TeacherID, IsActive) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        //this need to remove at last
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("ssissi", $courseName, $courseCode, $creditPoints, $startDate, $teacherID, $isActive);
        return $stmt->execute();
    }

    //Read function for the course.
    public function getAll(){
        $sql= "SELECT * FROM course";
        $result = $this->conn->query($sql);
       $this->conn->query($sql);
       return $result;
    }

    //get single course by id
    public function getById($id){
        $sql= "SELECT * FROM course WHERE CourseID = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    //update course
    public function update($id, $courseName, $courseCode, $creditPoints, $startDate, $teacherID, $isActive){
        $sql = "UPDATE course SET CourseName=?, CourseCode=?, CreditPoints=?, StartDate=?, TeacherID=?, IsActive=? WHERE CourseID=?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("ssissii", $courseName, $courseCode, $creditPoints, $startDate, $teacherID, $isActive, $id);
        return $stmt->execute();
    }

    //delete course
    public function delete($id){
        $sql = "DELETE FROM course WHERE CourseID=?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
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

    // Add Course
    public function create(
        $courseName,
        $courseCode,
        $creditPoints,
        $startDate,
        $isActive,
        $teacherID
    ){

        $sql = "INSERT INTO course
        (
            CourseName,
            CourseCode,
            CreditPoints,
            StartDate,
            IsActive,
            TeacherID
        )
        VALUES
        (
            ?, ?, ?, ?, ?, ?
        )";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssisii",
            $courseName,
            $courseCode,
            $creditPoints,
            $startDate,
            $isActive,
            $teacherID
        );

        return $stmt->execute();
    }

    // Get All Courses
    public function getAll()
    {
        $sql = "SELECT * FROM course";

        return $this->conn->query($sql);
    }

    // Get Course By ID
    public function getById($id)
    {
        $sql = "SELECT * FROM course WHERE CourseID=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Update Course
    public function update(
        $id,
        $courseName,
        $courseCode,
        $creditPoints,
        $startDate,
        $isActive,
        $teacherID
    ){

        $sql = "UPDATE course
        SET
            CourseName=?,
            CourseCode=?,
            CreditPoints=?,
            StartDate=?,
            IsActive=?,
            TeacherID=?
        WHERE CourseID=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssisiii",
            $courseName,
            $courseCode,
            $creditPoints,
            $startDate,
            $isActive,
            $teacherID,
            $id
        );

        return $stmt->execute();
    }

    // Delete Course
    public function delete($id)
    {
        $sql = "DELETE FROM course WHERE CourseID=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Search Course
    public function search($keyword)
    {
        $sql = "SELECT * FROM course
        WHERE CourseName LIKE ?
        OR CourseCode LIKE ?";

        $stmt = $this->conn->prepare($sql);

        $search = "%$keyword%";

        $stmt->bind_param("ss", $search, $search);

        $stmt->execute();

        return $stmt->get_result();
    }

    // Filter Active Courses
    public function filter($status)
    {
        $sql = "SELECT * FROM course WHERE IsActive=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $status);

        $stmt->execute();

        return $stmt->get_result();
    }

    // Search + Filter
    public function searchAndFilter($keyword, $status)
    {
        $sql = "SELECT * FROM course
        WHERE
        (
            CourseName LIKE ?
            OR CourseCode LIKE ?
        )
        AND IsActive=?";

        $stmt = $this->conn->prepare($sql);

        $search = "%$keyword%";

        $stmt->bind_param(
            "ssi",
            $search,
            $search,
            $status
        );

        $stmt->execute();

        return $stmt->get_result();
    }
}
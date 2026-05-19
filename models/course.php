<?php
// Course Model - handles all database operations for the course table
// This is the MODEL layer in the MVC architecture
require_once __DIR__ . '/../database/db.php';

class Course
{
    // Stores the database connection to use in all methods
    private $conn;

    // Connects to the database when Course object is created
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Add Course - inserts a new course record into the course table
    public function create(
        $courseName,
        $courseCode,
        $creditPoints,
        $startDate,
        $isActive,
        $teacherID
    ){
        // INSERT query using ? placeholders to prevent SQL injection
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

        // bind_param defines data types: s=string, i=integer
        // ssisii = CourseName(s), CourseCode(s), CreditPoints(i), StartDate(s), IsActive(i), TeacherID(i)
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

    // Get All Courses - retrieves every course record from the database
    public function getAll()
    {
        $sql = "SELECT * FROM course";
        return $this->conn->query($sql);
    }

    // Get Course By ID - retrieves one course record using CourseID
    // Used by the edit page to pre-fill the form with existing data
    public function getById($id)
    {
        $sql = "SELECT * FROM course WHERE CourseID=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        // fetch_assoc returns the result as an associative array
        return $stmt->get_result()->fetch_assoc();
    }

    // Update Course - saves edited course data back to the database
    public function update(
        $id,
        $courseName,
        $courseCode,
        $creditPoints,
        $startDate,
        $isActive,
        $teacherID
    ){
        // UPDATE query sets new values where CourseID matches
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

        // ssisiii = CourseName(s), CourseCode(s), CreditPoints(i), StartDate(s), IsActive(i), TeacherID(i), CourseID(i)
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

    // Delete Course - removes a course record from the database by CourseID
    public function delete($id)
    {
        $sql = "DELETE FROM course WHERE CourseID=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Search Course - finds courses by CourseName or CourseCode
    // Uses SQL LIKE with % wildcard for partial matching
    public function search($keyword)
    {
        $sql = "SELECT * FROM course
        WHERE CourseName LIKE ?
        OR CourseCode LIKE ?";

        $stmt = $this->conn->prepare($sql);

        // % added around keyword so it matches any part of the name or code
        $search = "%$keyword%";

        $stmt->bind_param("ss", $search, $search);

        $stmt->execute();

        return $stmt->get_result();
    }

    // Filter Active Courses - returns only active or inactive courses
    // status=1 returns Active, status=0 returns Inactive
    public function filter($status)
    {
        $sql = "SELECT * FROM course WHERE IsActive=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $status);

        $stmt->execute();

        return $stmt->get_result();
    }

    // Search + Filter - searches and filters courses at the same time
    // Uses AND to combine both conditions in one SQL query
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

        // % added around keyword for partial matching
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
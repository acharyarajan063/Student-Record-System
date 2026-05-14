<?php

require_once __DIR__ . '/../database/db.php';

class Enrollment
{
    private $conn;

    public function __construct()
    {
        $db = new Database();

        $this->conn = $db->connect();
    }

    // Get All Enrollments
    public function getAll()
    {
        $sql = "
        SELECT
            enrollment.EnrollmentID,
            student.StudentName,
            course.CourseName,
            enrollment.EnrollmentDate
        FROM enrollment
        INNER JOIN student
            ON enrollment.StudentID = student.StudentID
        INNER JOIN course
            ON enrollment.CourseID = course.CourseID
        ";

        return $this->conn->query($sql);
    }

    // Add Enrollment
    public function create(
        $studentID,
        $courseID,
        $date
    ){

        $sql = "
        INSERT INTO enrollment
        (
            StudentID,
            CourseID,
            EnrollmentDate
        )
        VALUES
        (
            ?, ?, ?
        )
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iis",
            $studentID,
            $courseID,
            $date
        );

        return $stmt->execute();
    }

    // Delete Enrollment
    public function delete($id)
    {
        $sql = "
        DELETE FROM enrollment
        WHERE EnrollmentID=?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
?>
<?php

require_once __DIR__ . '/../database/db.php';

class Grade
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Get all grades
    public function getAll()
    {
        $sql = "
            SELECT grade.*,
                   student.StudentName,
                   course.CourseName
            FROM grade
            INNER JOIN student
                ON grade.StudentID = student.StudentID
            INNER JOIN course
                ON grade.CourseID = course.CourseID
            ORDER BY GradeID DESC
        ";

        return $this->conn->query($sql);
    }

    // Add grade
    public function create(
        $studentID,
        $courseID,
        $marks,
        $gradeLetter,
        $isPassed
    ) {

        $sql = "
            INSERT INTO grade
            (
                StudentID,
                CourseID,
                Marks,
                GradeLetter,
                isPassed
            )
            VALUES
            (
                ?, ?, ?, ?, ?
            )
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iidsi",
            $studentID,
            $courseID,
            $marks,
            $gradeLetter,
            $isPassed
        );

        return $stmt->execute();
    }

    // Delete grade
    public function delete($id)
    {
        $sql = "
            DELETE FROM grade
            WHERE GradeID = ?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Get grade by ID
    public function getById($id)
    {
        $sql = "
            SELECT *
            FROM grade
            WHERE GradeID = ?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // Update grade
    public function update(
        $gradeID,
        $studentID,
        $courseID,
        $marks,
        $gradeLetter,
        $isPassed
    ) {

        $sql = "
            UPDATE grade
            SET
                StudentID = ?,
                CourseID = ?,
                Marks = ?,
                GradeLetter = ?,
                isPassed = ?
            WHERE GradeID = ?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iidsii",
            $studentID,
            $courseID,
            $marks,
            $gradeLetter,
            $isPassed,
            $gradeID
        );

        return $stmt->execute();
    }

    // Student dashboard grades
    public function getGradesByStudent($studentID)
    {
        $sql = "
            SELECT grade.*,
                   course.CourseName
            FROM grade
            INNER JOIN course
                ON grade.CourseID = course.CourseID
            WHERE grade.StudentID = ?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $studentID);

        $stmt->execute();

        return $stmt->get_result();
    }
}

?>
<?php

require_once __DIR__ . '/../database/db.php';

class Attendance
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Get all attendance
    public function getAll()
    {
        $sql = "
            SELECT attendance.*,
                   student.StudentName,
                   course.CourseName
            FROM attendance
            INNER JOIN student
                ON attendance.StudentID = student.StudentID
            INNER JOIN course
                ON attendance.CourseID = course.CourseID
            ORDER BY AttendanceDate DESC
        ";

        return $this->conn->query($sql);
    }

    // Add attendance
    public function create(
        $studentID,
        $courseID,
        $attendanceDate,
        $status,
        $recordedBy,
        $isExcused
    ) {

        $sql = "
            INSERT INTO attendance
            (
                StudentID,
                CourseID,
                AttendanceDate,
                Status,
                RecordedBy,
                IsExcused
            )
            VALUES
            (
                ?, ?, ?, ?, ?, ?
            )
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iisssi",
            $studentID,
            $courseID,
            $attendanceDate,
            $status,
            $recordedBy,
            $isExcused
        );

        return $stmt->execute();
    }

    // Delete attendance
    public function delete($id)
    {
        $sql = "
            DELETE FROM attendance
            WHERE AttendanceID = ?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Get attendance by ID
    public function getById($id)
    {
        $sql = "
            SELECT *
            FROM attendance
            WHERE AttendanceID = ?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    // Update attendance
    public function update(
        $attendanceID,
        $studentID,
        $courseID,
        $attendanceDate,
        $status,
        $recordedBy,
        $isExcused
    ) {

        $sql = "
            UPDATE attendance
            SET
                StudentID = ?,
                CourseID = ?,
                AttendanceDate = ?,
                Status = ?,
                RecordedBy = ?,
                IsExcused = ?
            WHERE AttendanceID = ?
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iisssii",
            $studentID,
            $courseID,
            $attendanceDate,
            $status,
            $recordedBy,
            $isExcused,
            $attendanceID
        );

        return $stmt->execute();
    }
}
?>
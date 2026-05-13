<?php
require_once '../database/db.php';

class Attendance
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllAttendance()
    {
        $sql = "SELECT attendance.AttendanceID,
                       attendance.AttendanceDate,
                       attendance.Status,
                       student.StudentName
                FROM attendance
                INNER JOIN student
                ON attendance.StudentID = student.StudentID
                ORDER BY attendance.AttendanceDate DESC";

        return $this->conn->query($sql);
    }
}
?>
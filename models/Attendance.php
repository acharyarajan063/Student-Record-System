<?php
require_once __DIR__ . '/../database/db.php';

class Attendance {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    /**
     * CREATE: Links attendance to specific Student and Course
     */
    public function create($studentId, $courseId, $date, $status, $recordedBy, $isExcused) {
        $stmt = $this->conn->prepare(
            "INSERT INTO attendance 
            (StudentID, CourseID, AttendanceDate, Status, RecordedBy, IsExcused) 
            VALUES (?, ?, ?, ?, ?, ?)"
        );
        // "iiisss" matches the data types defined in your table design[cite: 2]
        $stmt->bind_param("iisssi", $studentId, $courseId, $date, $status, $recordedBy, $isExcused);
        return $stmt->execute();
    }

    /**
     * READ/FILTER: Find specific records
     */
    public function getFiltered($date, $courseId) {
        $query = "SELECT * FROM attendance WHERE 1=1";
        if ($date) $query .= " AND AttendanceDate = '$date'";
        if ($courseId) $query .= " AND CourseID = $courseId";
        
        return $this->conn->query($query);
    }

    /**
     * STATS: For calculating percentages in the controller[cite: 1]
     */
    public function getStatsByStudent($studentId) {
        $stmt = $this->conn->prepare(
            "SELECT 
                COUNT(*) as total, 
                SUM(CASE WHEN Status = 'Present' THEN 1 ELSE 0 END) as present 
            FROM attendance WHERE StudentID = ?"
        );
        $stmt->bind_param("i", $studentId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
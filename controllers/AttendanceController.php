<?php
require_once __DIR__ . '/../models/Attendance.php';

class AttendanceController {
    private $attendance;

    public function __construct() {
        $this->attendance = new Attendance();
    }

    /**
     * Mark daily attendance (CREATE)
     * Includes logic validation as required by individual specification
     */
    public function store($data) {
        // Business Logic Validation: Prevent future dates
        $today = date('Y-m-d');
        if ($data['attendance_date'] > $today) {
            return "Error: Cannot mark attendance for future dates.";
        }
        
        return $this->attendance->create(
            $data['student_id'],
            $data['course_id'],
            $data['attendance_date'],
            $data['status'],
            $data['recorded_by'],
            $data['is_excused']
        );
    }

    /**
     * Filter records (LIST/FILTER)
     * For staff to view attendance by date or course
     */
    public function filter($date = null, $courseId = null) {
        return $this->attendance->getFiltered($date, $courseId);
    }

    /**
     * Calculate individual student percentage (LOGIC)
     */
    public function getStudentPerformance($studentId) {
        $stats = $this->attendance->getStatsByStudent($studentId);
        if ($stats['total'] == 0) return 0;
        
        return ($stats['present'] / $stats['total']) * 100;
    }

    // Additional methods for update() and destroy() should follow here
}
?>
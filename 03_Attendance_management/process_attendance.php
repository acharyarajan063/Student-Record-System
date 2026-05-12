<?php
/**
 * Component: Attendance Management
 * Page: Process Bulk Attendance
 * Tier: Middle Layer (Business Logic)
 * * Logic: This script receives an array of student attendance data, 
 * iterates through it, and uses the Controller to save each record.
 */

// 1. CONNECTION: Navigate up one level to find the Controller
require_once '../controllers/AttendanceController.php';

// Instantiate the controller to access database methods
$controller = new AttendanceController();

/**
 * SECURITY CHECK: Ensure data is only processed via POST
 * This prevents users from accessing this script directly via URL.
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Capture shared information from the hidden fields
    $courseId = $_POST['course_id'];
    $date = $_POST['attendance_date'];
    $recordedBy = $_POST['recorded_by'];

    /**
     * BULK LOGIC: The 'attendance' variable is an associative array.
     * Key ($studentId) = The ID of the student
     * Value ($details) = Array containing [status] and [is_excused]
     */
    foreach ($_POST['attendance'] as $studentId => $details) {
        
        // Prepare a clean data package for the Database (Model)
        $data = [
            'student_id'      => $studentId,
            'course_id'       => $courseId,
            'attendance_date' => $date,
            'status'          => $details['status'],
            'recorded_by'     => $recordedBy,
            /**
             * BOOLEAN LOGIC: Checkboxes only send a value if they are checked.
             * If checked, we send 1. If not, we send 0.
             */
            'is_excused'      => isset($details['is_excused']) ? 1 : 0
        ];

        // Call the 'store' method in the Controller to save this specific student's record
        $controller->store($data);
    }

    /**
     * NAVIGATION & FEEDBACK: 
     * Requirement: "Clear navigation and messages"
     * Redirect back to the marking sheet with a success flag in the URL.
     */
    header("Location: mark_attendance.php?status=success");
    exit();
} else {
    // If someone tries to access this file directly, send them back to the main page
    header("Location: mark_attendance.php");
    exit();
}
?>
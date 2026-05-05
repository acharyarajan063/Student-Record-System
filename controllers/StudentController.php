<?php
require_once __DIR__ . '/../models/Student.php';

class StudentController {

    // Property to hold Student model object
    private $student;

    /**
     * Constructor
     * Initializes the Student model
     */
    public function __construct() {
        $this->student = new Student(); // create model instance
    }

    /**
     * Get all students (for dashboard list)
     */
    public function index() {
        return $this->student->getAll();
    }

    /**
     * Store new student (CREATE)
     * Accepts form data and inserts into database
     */
    public function store($data) {
        return $this->student->create(
            $data['name'],
            $data['email'],
            $data['level'],
            $data['dob'],
            $data['enrolled'],
            $data['isActive']
        );
    }

    /**
     * Get single student (for edit form)
     */
    public function edit($id) {
        return $this->student->getById($id);
    }

    /**
     * Update student (UPDATE)
     * Updates existing record
     */
    public function update($data) {
        return $this->student->update(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['level'],
            $data['dob'],
            $data['enrolled'],
            $data['isActive']
        );
    }

    /**
     * Delete student (DELETE)
     */
    public function destroy($id) {
        return $this->student->delete($id);
    }

    /**
     * Get courses of a specific student
     */
    public function getCourses($studentId) {
        return $this->student->getCourses($studentId);
    }

    /**
     * Get grades of a student
     */
    public function getGrades($studentId) {
        return $this->student->getGrades($studentId);
    }

    /**
     * Get attendance records of a student
     */
    public function getAttendanceStats($studentId) {
    return $this->student->getAttendanceStats($studentId);
}
}
?>
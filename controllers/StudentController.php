<?php
require_once __DIR__ . '/../models/Student.php';

class StudentController {
    private $student;

    /**
     * Constructor
     * Creates Student model object
     */
    public function __construct() {
        $this->student = new Student();
    }

    /**
     * Get all students (Dashboard)
     */
    public function index() {
        return $this->student->getAll();
    }

    /**
     * Store new student (Create)
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
     * Get single student (Edit page)
     */
    public function edit($id) {
        return $this->student->getById($id);
    }

    /**
     * Update student
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
     * Delete student
     */
    public function destroy($id) {
        return $this->student->delete($id);
    }
}
?>
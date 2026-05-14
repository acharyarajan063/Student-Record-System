<?php

require_once __DIR__ . '/../models/Enrollment.php';

class EnrollmentController
{
    private $enrollment;

    public function __construct()
    {
        $this->enrollment = new Enrollment();
    }

    // Show All
    public function index()
    {
        return $this->enrollment->getAll();
    }

    // Add Enrollment
    public function store($data)
    {
        return $this->enrollment->create(
            $data['student_id'],
            $data['course_id'],
            $data['date']
        );
    }

    // Delete
    public function destroy($id)
    {
        return $this->enrollment->delete($id);
    }
}
?>
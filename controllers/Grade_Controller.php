<?php

require_once __DIR__ . '/../models/Grade.php';

class GradeController
{
    private $grade;

    public function __construct()
    {
        $this->grade = new Grade();
    }

    // Show all grades
    public function index()
    {
        return $this->grade->getAll();
    }

    // Add grade
    public function store($data)
    {
        return $this->grade->create(
            $data['studentID'],
            $data['courseID'],
            $data['marks'],
            $data['gradeLetter'],
            $data['isPassed']
        );
    }

    // Get single grade
    public function edit($id)
    {
        return $this->grade->getById($id);
    }

    // Update grade
    public function update($data)
    {
        return $this->grade->update(
            $data['gradeID'],
            $data['studentID'],
            $data['courseID'],
            $data['marks'],
            $data['gradeLetter'],
            $data['isPassed']
        );
    }

    // Delete grade
    public function destroy($id)
    {
        return $this->grade->delete($id);
    }

    // Student dashboard
    public function studentGrades($studentID)
    {
        return $this->grade->getGradesByStudent($studentID);
    }
}

?>
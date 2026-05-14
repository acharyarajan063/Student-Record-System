<?php

require_once __DIR__ . '/../models/course.php';

class CourseController
{
    private $course;

    public function __construct()
    {
        $this->course = new Course();
    }

    // List All Courses
    public function index()
    {
        return $this->course->getAll();
    }

    // Add Course
    public function store($data)
    {
        return $this->course->create(

            $data['course_name'],
            $data['course_code'],
            $data['credit_points'],
            $data['start_date'],
            $data['is_active'],
            $data['teacher_id']

        );
    }

    // Get Single Course
    public function edit($id)
    {
        return $this->course->getById($id);
    }

    // Update Course
    public function update($data)
    {
        return $this->course->update(

            $data['id'],
            $data['course_name'],
            $data['course_code'],
            $data['credit_points'],
            $data['start_date'],
            $data['is_active'],
            $data['teacher_id']

        );
    }

    // Delete Course
    public function destroy($id)
    {
        return $this->course->delete($id);
    }

    // Search Course
    public function search($keyword)
    {
        return $this->course->search($keyword);
    }

    // Filter Course
    public function filter($status)
    {
        return $this->course->filter($status);
    }

    // Search + Filter
    public function searchAndFilter($keyword, $status)
    {
        return $this->course->searchAndFilter(
            $keyword,
            $status
        );
    }
}
?>
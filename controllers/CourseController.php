<?php

require_once __DIR__ . '/../models/course.php';

class CourseController
{
    private $course;

    // Create Course model object to use for database operations
    public function __construct()
    {
        $this->course = new Course();
    }

    // List All Courses - gets all courses from database to show on admin page
    public function index()
    {
        return $this->course->getAll();
    }

    // Add Course - takes form data and saves new course to database
    public function store($data)
    {
        return $this->course->create(
            $data['course_name'],    // course name entered in form
            $data['course_code'],    // course code entered in form
            $data['credit_points'],  // credit points entered in form
            $data['start_date'],     // start date entered in form
            $data['is_active'],      // active status selected in form
            $data['teacher_id']      // teacher id entered in form
        );
    }

    // Get Single Course - loads one course by ID to fill the edit form
    public function edit($id)
    {
        return $this->course->getById($id);
    }

    // Update Course - saves the edited course data back to database
    public function update($data)
    {
        return $this->course->update(
            $data['id'],             // identifies which course to update
            $data['course_name'],
            $data['course_code'],
            $data['credit_points'],
            $data['start_date'],
            $data['is_active'],
            $data['teacher_id']
        );
    }

    // Delete Course - removes a course from database using its ID
    public function destroy($id)
    {
        return $this->course->delete($id);
    }

    // Search Course - finds courses matching the keyword by name or code
    public function search($keyword)
    {
        return $this->course->search($keyword);
    }

    // Filter Course - shows only active or inactive courses based on status
    public function filter($status)
    {
        return $this->course->filter($status);
    }

    // Search + Filter - searches and filters courses at the same time
    public function searchAndFilter($keyword, $status)
    {
        return $this->course->searchAndFilter(
            $keyword,
            $status
        );
    }
}
?>
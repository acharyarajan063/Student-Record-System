<?php
require_once __DIR__ . '/../models/course.php';

class CourseController
{
    private $course;

    public function __construct()
    {
        $this->course = new Course();
    }

    public function index()
    {
        // Implementation for listing all courses
        return $this->course->getAll();
    }

    public function store($data)
    {
        return $this->course->create(
            $data['courseName'],
            $data['courseCode'],
            $data['creditPoints'],
            $data['startDate'],
            $data['teacherID'],
            $data['isActive']
        );
    }

    public function edit($id)
    {
        //
        return $this->course->getById($id);
    }

    public function update($data)
    {
        return $this->course->update(
            $data['id'],
            $data['courseName'],
            $data['courseCode'],
            $data['creditPoints'],
            $data['startDate'],
            $data['teacherID'],
            $data['isActive']
        );
    }

    public function destroy($id)
    {
        return $this->course->delete($id);
    }
}
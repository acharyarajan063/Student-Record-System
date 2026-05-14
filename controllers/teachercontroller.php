<?php

require_once __DIR__ . '/../models/teacher.php';

class TeacherController
{
    private $teacher;

    public function __construct()
    {
        $this->teacher = new Teacher();
    }

    // Show All Teachers
    public function index()
    {
        return $this->teacher->getAll();
    }

    // Add Teacher
    public function store($data)
    {
        return $this->teacher->create(
            $data['name'],
            $data['email'],
            $data['department'],
            $data['date_joined'],
            $data['is_active']
        );
    }

    // Edit Teacher
    public function edit($id)
    {
        return $this->teacher->getById($id);
    }

    // Update Teacher
    public function update($data)
    {
        return $this->teacher->update(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['department'],
            $data['date_joined'],
            $data['is_active']
        );
    }

    // Delete Teacher
    public function destroy($id)
    {
        return $this->teacher->delete($id);
    }

    // Search Teacher
    public function search($keyword)
    {
        return $this->teacher->search($keyword);
    }
}
?>
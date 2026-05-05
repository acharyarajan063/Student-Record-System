<?php
require_once __DIR__ . '/../models/Student.php';
class StudentController
{
    private $student;
    public function __construct()
    {
        $this->student = new Student();
    }
    public function index()
    {
        // Implementation for listing all students
        return $this->student->getAll();
    }

    public function store($data)
    {
        return $this->student->create(
            $data['name'],
            $data['email'],
            $data['level'],
            $data['dob'],
            $data['enrolled'],
            $data['isActive']
        );
    }

    public function edit($id){
        //
        return $this->student->getById($id);
    }

    public function update($data){
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
}
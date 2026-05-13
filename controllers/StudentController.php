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

    public function destroy($id){
        return $this->student->delete($id);
    }

    public function search($keyword){
        // Implementation for searching students by keyword
        return $this->student->search($keyword);
    }

    public function filterByLevel($level){
        // Implementation for filtering students by level
        return $this->student->filterByLevel($level);
    }
    public function searchAndFilter($search, $level){
    // Implementation for searching and filtering students
    return $this->student->searchAndFilter($search, $level);
}
public function getStudentById($id)
{
    return $this->student->getStudentById($id);
}

public function updateProfile($id, $name, $email, $phone, $password)
{
    return $this->student->updateProfile(
        $id,
        $name,
        $email,
        $phone,
        $password
    );
}
}
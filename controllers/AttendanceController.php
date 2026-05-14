<?php

require_once __DIR__ . '/../models/Attendance.php';

class AttendanceController
{
    private $attendance;

    public function __construct()
    {
        $this->attendance = new Attendance();
    }

    // Show all attendance
    public function index()
    {
        return $this->attendance->getAll();
    }

    // Store attendance
    public function store($data)
    {
        return $this->attendance->create(
            $data['studentID'],
            $data['courseID'],
            $data['attendanceDate'],
            $data['status'],
            $data['recordedBy'],
            $data['isExcused']
        );
    }

    // Get single attendance
    public function edit($id)
    {
        return $this->attendance->getById($id);
    }

    // Update attendance
    public function update($data)
    {
        return $this->attendance->update(
            $data['attendanceID'],
            $data['studentID'],
            $data['courseID'],
            $data['attendanceDate'],
            $data['status'],
            $data['recordedBy'],
            $data['isExcused']
        );
    }

    // Delete attendance
    public function destroy($id)
    {
        return $this->attendance->delete($id);
    }
}

?>
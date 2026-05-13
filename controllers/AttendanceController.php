<?php
require_once '../models/Attendance.php';

class AttendanceController
{
    private $attendance;

    public function __construct()
    {
        $this->attendance = new Attendance();
    }

    public function index()
    {
        return $this->attendance->getAllAttendance();
    }
}

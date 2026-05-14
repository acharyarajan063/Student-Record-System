<?php

require_once '../controllers/AttendanceController.php';

$controller = new AttendanceController();

$id = $_GET['id'];

$controller->destroy($id);

header("Location: attendance_admin.php");

exit();

?>
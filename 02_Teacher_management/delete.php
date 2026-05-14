<?php

require_once '../controllers/teachercontroller.php';

$controller = new TeacherController();

// Check ID
if(isset($_GET['id'])){

    $id = $_GET['id'];

    // Delete Teacher
    $controller->destroy($id);
}

// Redirect Back
header(
    "Location: teacher_admin.php"
);

exit();

?>
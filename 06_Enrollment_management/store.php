<?php

require_once '../controllers/EnrollmentController.php';

$controller = new EnrollmentController();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $controller->store($_POST);

    header(
        "Location: enrollment_admin.php"
    );

    exit();
}
?>
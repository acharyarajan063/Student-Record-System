<?php

require_once '../controllers/EnrollmentController.php';

$controller = new EnrollmentController();

if(isset($_GET['id'])){

    $controller->destroy($_GET['id']);
}

header(
    "Location: enrollment_admin.php"
);

exit();
?>
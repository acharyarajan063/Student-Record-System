<?php

require_once '../controllers/CourseController.php';

$controller = new CourseController();

/*
|--------------------------------------------------------------------------
| Check ID
|--------------------------------------------------------------------------
*/

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    // Delete Course
    $controller->destroy($id);
}

/*
|--------------------------------------------------------------------------
| Redirect Back
|--------------------------------------------------------------------------
*/

header("Location: course_admin.php");

exit();

?>
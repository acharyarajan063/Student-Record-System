<?php
require_once '../controllers/CourseController.php';

$controller = new CourseController();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $controller->destroy($id);
    header("Location: admin.php");
    exit();
}
?>
<?php
require_once '../controllers/StudentController.php';

$controller = new StudentController();

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $controller->destroy($id);

    header("Location: admin.php");
    exit();
}
?>
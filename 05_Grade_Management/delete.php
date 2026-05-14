<?php

require_once '../controllers/Grade_Controller.php';

$controller = new GradeController();

$id = $_GET['id'];

$controller->destroy($id);

header("Location: grade_admin.php");

exit();

?>
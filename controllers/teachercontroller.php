<?php
require_once("../models/teacher.php");

$teacher = new Teacher();

// ADD TEACHER
if (isset($_POST['addTeacher'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $dateJoined = $_POST['dateJoined'];

    $teacher->addTeacher($name, $email, $department, $dateJoined);

    header("Location: ../Teacher_management/index.php");
    exit();
}

// DEACTIVATE TEACHER
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $teacher->deactivateTeacher($id);

    header("Location: ../Teacher_management/index.php");
    exit();
}
?>
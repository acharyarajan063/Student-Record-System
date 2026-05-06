<?php
require_once("../models/teacher.php");

$teacher = new Teacher();

// ADD TEACHER
if (isset($_POST['addTeacher'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $dateJoined = $_POST['dateJoined'];

    // updated function name (team style)
    $teacher->create($name, $email, $department, $dateJoined, 1);

    header("Location: ../Teacher_management/index.php");
    exit();
}

// DEACTIVATE TEACHER
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    // updated function name (team style)
    $teacher->deactivate($id);

    header("Location: ../Teacher_management/index.php");
    exit();
}
?>
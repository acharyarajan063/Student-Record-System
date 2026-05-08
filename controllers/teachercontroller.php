<?php
require_once("../models/teacher.php");

$teacher = new Teacher();

// ADD TEACHER
if (isset($_POST['addTeacher'])) {

    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $department = $_POST['department'];
    $dateJoined = $_POST['dateJoined'];

    if ($teacher->emailExists($email)) {
        header("Location: ../Teacher_management/index.php?error=duplicate_email");
        exit();
    }

    if ($dateJoined > date('Y-m-d')) {
        header("Location: ../Teacher_management/index.php?error=future_date");
        exit();
    }

    $teacher->create($name, $email, $department, $dateJoined, 1);

    header("Location: ../Teacher_management/index.php?success=added");
    exit();
}

// UPDATE TEACHER
if (isset($_POST['updateTeacher'])) {

    $id         = (int) $_POST['teacherID'];
    $name       = $_POST['name'];
    $email      = $_POST['email'];
    $department = $_POST['department'];
    $dateJoined = $_POST['dateJoined'];

    if ($teacher->emailExists($email, $id)) {
        header("Location: ../Teacher_management/edit.php?id=$id&error=duplicate_email");
        exit();
    }

    if ($dateJoined > date('Y-m-d')) {
        header("Location: ../Teacher_management/edit.php?id=$id&error=future_date");
        exit();
    }

    $teacher->update($id, $name, $email, $department, $dateJoined, 1);

    header("Location: ../Teacher_management/index.php?success=updated");
    exit();
}

// ASSIGN COURSE TO TEACHER
if (isset($_POST['assignCourse'])) {

    $courseId  = (int) $_POST['courseID'];
    $teacherId = (int) $_POST['teacherID'];

    $teacher->assignCourse($courseId, $teacherId);

    header("Location: ../Teacher_management/assign_courses.php?success=1");
    exit();
}

// UNASSIGN TEACHER FROM COURSE
if (isset($_GET['unassign'])) {

    $courseId = (int) $_GET['unassign'];

    $teacher->unassignCourse($courseId);

    header("Location: ../Teacher_management/assign_courses.php?success=unassigned");
    exit();
}

// DEACTIVATE TEACHER
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    $teacher->deactivate($id);

    header("Location: ../Teacher_management/index.php");
    exit();
}
?>
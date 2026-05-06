<?php
require_once 'models/Student.php';
$student = new Student();
$students = $student->getAll();

while ($row = $students->fetch_assoc()) {
    echo $row['StudentName'] . "<br>";
}
?>
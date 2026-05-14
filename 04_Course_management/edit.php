<?php

require_once '../controllers/CourseController.php';

$controller = new CourseController();

$id = $_GET['id'];

$course = $controller->edit($id);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['course_name'])) {

        $error = "Course name is required";

    } elseif (empty($_POST['course_code'])) {

        $error = "Course code is required";

    } elseif (empty($_POST['credit_points'])) {

        $error = "Credit points required";

    } elseif (empty($_POST['start_date'])) {

        $error = "Start date required";

    } elseif (empty($_POST['teacher_id'])) {

        $error = "Teacher ID required";

    } else {

        $controller->update($_POST);

        header("Location: course_admin.php");

        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"
>

<title>Edit Course</title>

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
rel="stylesheet"
>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#f8fafc;
}

.main-content{
    padding:40px;
}

.form-card{

    max-width:700px;

    background:white;

    padding:40px;

    border-radius:18px;

    box-shadow:
    0 5px 20px rgba(0,0,0,0.06);
}

h2{
    margin-bottom:30px;
    color:#1e293b;
}

.input-group{
    margin-bottom:20px;
}

label{

    display:block;

    margin-bottom:8px;

    font-weight:600;
}

input,
select{

    width:100%;

    padding:14px;

    border:1px solid #cbd5e1;

    border-radius:10px;

    outline:none;
}

input:focus,
select:focus{
    border-color:#3b82f6;
}

.btn{

    width:100%;

    border:none;

    padding:14px;

    border-radius:10px;

    background:#3b82f6;

    color:white;

    font-weight:600;

    cursor:pointer;
}

.btn:hover{
    background:#2563eb;
}

.error{

    background:#fee2e2;

    color:#991b1b;

    padding:12px;

    border-radius:10px;

    margin-bottom:20px;
}

</style>

</head>

<body>

<?php include '../navbar.php'; ?>

<div class="main-content">

<div class="form-card">

<h2>Edit Course</h2>

<?php if (!empty($error)): ?>

<div class="error">

<?= $error ?>

</div>

<?php endif; ?>

<form method="POST">

<input
type="hidden"
name="id"
value="<?= $course['CourseID'] ?>"
>

<div class="input-group">

<label>Course Name</label>

<input
type="text"
name="course_name"
value="<?= htmlspecialchars($course['CourseName']) ?>"
>

</div>

<div class="input-group">

<label>Course Code</label>

<input
type="text"
name="course_code"
value="<?= htmlspecialchars($course['CourseCode']) ?>"
>

</div>

<div class="input-group">

<label>Credit Points</label>

<input
type="number"
name="credit_points"
value="<?= $course['CreditPoints'] ?>"
>

</div>

<div class="input-group">

<label>Start Date</label>

<input
type="date"
name="start_date"
value="<?= $course['StartDate'] ?>"
>

</div>

<div class="input-group">

<label>Teacher ID</label>

<input
type="number"
name="teacher_id"
value="<?= $course['TeacherID'] ?>"
>

</div>

<div class="input-group">

<label>Status</label>

<select name="is_active">

<option
value="1"
<?= $course['IsActive'] ? 'selected' : '' ?>
>

Active

</option>

<option
value="0"
<?= !$course['IsActive'] ? 'selected' : '' ?>
>

Inactive

</option>

</select>

</div>

<button
type="submit"
class="btn"
>

Update Course

</button>

</form>

</div>

</div>

</body>

</html>